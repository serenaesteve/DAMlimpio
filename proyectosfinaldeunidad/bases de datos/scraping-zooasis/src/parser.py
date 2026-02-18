import re
from bs4 import BeautifulSoup
from urllib.parse import urljoin

from src.models import Animal
from src.config import BASE_URL


def parse_meta(text: str):
    match = re.search(r"(Hembra|Macho)\s*\|\s*[^|]+\|\s*[^|]+", text)
    if match:
        parts = [p.strip() for p in match.group(0).split("|")]
        return parts[0], parts[1], parts[2]
    return None, None, None


def parse_list_page(html: str):
    soup = BeautifulSoup(html, "lxml")
    animals = []

    for article in soup.select("article"):
        title = article.select_one("h1 a, h2 a, h3 a, .entry-title a")
        if not title:
            continue

        nombre = title.get_text(strip=True)
        url = urljoin(BASE_URL, title["href"])

        date_el = article.select_one("time")
        fecha = date_el.get_text(strip=True) if date_el else None

        text = article.get_text(" ", strip=True)
        sexo, edad, tamano = parse_meta(text)

        animals.append(
            Animal(
                nombre=nombre,
                sexo=sexo,
                edad=edad,
                tamano=tamano,
                fecha_publicacion=fecha,
                url_ficha=url
            )
        )

    next_link = soup.select_one("a.next, a.next.page-numbers")
    next_url = urljoin(BASE_URL, next_link["href"]) if next_link else None

    return animals, next_url


def parse_detail_page(html: str):
    soup = BeautifulSoup(html, "lxml")

    content = soup.select_one(".entry-content")
    descripcion = content.get_text("\n", strip=True) if content else None

    imagenes = []
    if content:
        for img in content.select("img"):
            if img.get("src"):
                imagenes.append(img["src"])

    return descripcion, imagenes or None

