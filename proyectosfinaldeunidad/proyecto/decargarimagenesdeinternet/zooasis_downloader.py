import argparse
import hashlib
import json
import os
import random
import re
import time
from dataclasses import dataclass
from pathlib import Path
from typing import Dict, List, Set, Tuple
from urllib.parse import urljoin, urlparse

import requests
from bs4 import BeautifulSoup


BASE_URL = "https://zooasis.org/"

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 "
                  "(KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "Accept-Language": "es-ES,es;q=0.9,en;q=0.7",
    "Connection": "keep-alive",
}

SECTION_URLS = {
    "perros": urljoin(BASE_URL, "adoptar-perro/"),
    "cachorros": urljoin(BASE_URL, "adopta-cachorro/"),

}


BLOCKLIST_PATHS = {
    "/adoptar-perro/", "/adopta-cachorro/", "/adoptar-gato/",
    "/politica-de-privacidad/", "/politica-de-cookies/", "/aviso-legal/",
    "/formulario-de-abandono/", "/donar/", "/apadrinar/",
}

IMG_EXTS = (".jpg", ".jpeg", ".png", ".webp", ".gif")


@dataclass
class Config:
    section: str
    output_dir: Path
    limit_animals: int
    limit_images_per_animal: int
    timeout: int
    max_pages: int
    min_delay: float
    max_delay: float



def make_session() -> requests.Session:
    s = requests.Session()
    s.headers.update(HEADERS)
    return s


def sleep_random(cfg: Config) -> None:
    time.sleep(random.uniform(cfg.min_delay, cfg.max_delay))



def get_soup(session: requests.Session, url: str, cfg: Config) -> BeautifulSoup:
    r = session.get(url, timeout=cfg.timeout)
    r.raise_for_status()
    return BeautifulSoup(r.text, "html.parser")


def is_candidate_animal_url(href: str) -> bool:
    if not href:
        return False
    if not href.startswith(BASE_URL):
        return False

    p = urlparse(href).path
    if not p or p == "/":
        return False
    if any(p.startswith(bp) for bp in BLOCKLIST_PATHS):
        return False

    # suele ser /nombre/ (una sola “carpeta”)
    parts = [x for x in p.split("/") if x]
    if len(parts) != 1:
        return False

    return True


def extract_animal_links(listing_soup: BeautifulSoup) -> List[str]:
    links: Set[str] = set()
    for a in listing_soup.find_all("a", href=True):
        href = a["href"].strip()
        if is_candidate_animal_url(href):
            links.add(href)
    return sorted(links)


def extract_pagination_links(listing_soup: BeautifulSoup) -> List[str]:
    """
    Busca links de paginación típicos de WordPress (page/2, page-numbers, etc.)
    """
    pages: Set[str] = set()
    for a in listing_soup.find_all("a", href=True):
        href = a["href"].strip()
        if href.startswith(BASE_URL) and ("/page/" in href or "page-numbers" in (a.get("class") or [])):
            pages.add(href)
    return sorted(pages)



def collect_animal_pages(session: requests.Session, start_url: str, cfg: Config) -> List[str]:
    to_visit = [start_url]
    visited: Set[str] = set()
    animal_pages: List[str] = []

    while to_visit and len(visited) < cfg.max_pages and len(animal_pages) < cfg.limit_animals:
        url = to_visit.pop(0)
        if url in visited:
            continue

        visited.add(url)
        print(f"📄 Leyendo listado: {url}")

        soup = get_soup(session, url, cfg)
        new_animals = extract_animal_links(soup)

        for u in new_animals:
            if u not in animal_pages:
                animal_pages.append(u)
                if len(animal_pages) >= cfg.limit_animals:
                    break

        # añadir paginación
        for p in extract_pagination_links(soup):
            if p not in visited and p not in to_visit:
                to_visit.append(p)

        sleep_random(cfg)

    return animal_pages[:cfg.limit_animals]



def pick_best_src(img_tag) -> str:
    # prioridad: data-src, src, srcset (primer srcset)
    for attr in ("data-src", "data-lazy-src", "src"):
        v = img_tag.get(attr)
        if v:
            return v.strip()

    srcset = img_tag.get("srcset")
    if srcset:
        
        first = srcset.split(",")[0].strip().split(" ")[0]
        return first.strip()

    return ""


def extract_image_urls_from_animal_page(soup: BeautifulSoup) -> List[str]:
    urls: Set[str] = set()

    for img in soup.find_all("img"):
        src = pick_best_src(img)
        if not src:
            continue

        if src.startswith("/"):
            src = urljoin(BASE_URL, src)

        if not src.startswith("http"):
            continue

        path = urlparse(src).path.lower()
        if any(path.endswith(ext) for ext in IMG_EXTS):
            urls.add(src)

    return sorted(urls)



def safe_filename(url: str) -> str:
    h = hashlib.sha256(url.encode("utf-8")).hexdigest()[:16]
    path = urlparse(url).path
    ext = os.path.splitext(path)[1].lower()
    if ext == ".jpeg":
        ext = ".jpg"
    if ext not in IMG_EXTS:
        ext = ".jpg"
    return f"img_{h}{ext}"


def download_image(session: requests.Session, url: str, out_path: Path, cfg: Config) -> Tuple[bool, int, str]:
    try:
        with session.get(url, stream=True, timeout=cfg.timeout) as r:
            r.raise_for_status()
            ct = r.headers.get("Content-Type", "")

            if ct and not ct.lower().startswith("image/"):
                return False, 0, f"no-image-content-type:{ct}"

            out_path.parent.mkdir(parents=True, exist_ok=True)
            with open(out_path, "wb") as f:
                for chunk in r.iter_content(chunk_size=8192):
                    if chunk:
                        f.write(chunk)

            size = out_path.stat().st_size
            if size < 1024:
                out_path.unlink(missing_ok=True)
                return False, 0, "too-small"

            return True, size, "ok"

    except Exception as e:
        return False, 0, f"error:{e}"



def parse_args() -> argparse.Namespace:
    p = argparse.ArgumentParser(description="Descargador de imágenes desde Zooasis (sección Adoptar).")
    p.add_argument("--section", default="perros", choices=["perros", "cachorros"],
                   help="Sección a scrapear")
    p.add_argument("--out", default="zooasis_images", help="Directorio de salida")
    p.add_argument("--limit-animals", type=int, default=30, help="Máx. fichas de animales")
    p.add_argument("--limit-images", type=int, default=5, help="Máx. imágenes por animal")
    p.add_argument("--timeout", type=int, default=15, help="Timeout HTTP")
    p.add_argument("--max-pages", type=int, default=10, help="Máx. páginas de listado a recorrer")
    return p.parse_args()


def main() -> None:
    args = parse_args()
    cfg = Config(
        section=args.section,
        output_dir=Path(args.out),
        limit_animals=args.limit_animals,
        limit_images_per_animal=args.limit_images,
        timeout=args.timeout,
        max_pages=args.max_pages,
        min_delay=0.8,
        max_delay=2.2,
    )

    start_url = SECTION_URLS[cfg.section]

    session = make_session()

    print(f"🔎 Sección: {cfg.section} | Inicio: {start_url}")
    animal_pages = collect_animal_pages(session, start_url, cfg)
    print(f"✅ Fichas encontradas: {len(animal_pages)}")

    report: Dict = {
        "base_url": BASE_URL,
        "section": cfg.section,
        "start_url": start_url,
        "animals_found": len(animal_pages),
        "items": [],
    }

    for idx, animal_url in enumerate(animal_pages, start=1):
        print(f"\n🐾 [{idx}/{len(animal_pages)}] Ficha: {animal_url}")
        soup = get_soup(session, animal_url, cfg)
        img_urls = extract_image_urls_from_animal_page(soup)[: cfg.limit_images_per_animal]

        animal_slug = [x for x in urlparse(animal_url).path.split("/") if x][0]
        animal_dir = cfg.output_dir / cfg.section / animal_slug

        downloaded = 0
        images_info = []

        for img_i, img_url in enumerate(img_urls, start=1):
            filename = safe_filename(img_url)
            out_path = animal_dir / filename

            ok, size, status = download_image(session, img_url, out_path, cfg)
            images_info.append({
                "img_url": img_url,
                "file": str(out_path),
                "ok": ok,
                "bytes": size,
                "status": status,
            })

            if ok:
                downloaded += 1
                print(f"  ✔ ({img_i}/{len(img_urls)}) {filename} ({size} bytes)")
            else:
                print(f"  ✘ ({img_i}/{len(img_urls)}) {img_url} -> {status}")

            sleep_random(cfg)

        report["items"].append({
            "animal_url": animal_url,
            "slug": animal_slug,
            "images_found": len(img_urls),
            "images_downloaded": downloaded,
            "images": images_info,
        })

        sleep_random(cfg)

    cfg.output_dir.mkdir(parents=True, exist_ok=True)
    report_path = cfg.output_dir / f"report_{cfg.section}.json"
    with open(report_path, "w", encoding="utf-8") as f:
        json.dump(report, f, ensure_ascii=False, indent=2)

    print(f"\n📦 Reporte guardado en: {report_path}")
    print(f"🏁 Fin. Carpeta: {cfg.output_dir}")


if __name__ == "__main__":
    main()

