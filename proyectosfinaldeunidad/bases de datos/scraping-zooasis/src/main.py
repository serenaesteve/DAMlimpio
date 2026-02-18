import requests
from tqdm import tqdm

from src.config import START_URL, MAX_PAGES
from src.fetcher import fetch
from src.parser import parse_list_page, parse_detail_page
from src.storage import save
from src.exceptions import AntiBotDetected


def main():
    session = requests.Session()
    url = START_URL
    animals = []

    print("Scrapeando listado...")
    for _ in range(MAX_PAGES):
        if not url:
            break
        html = fetch(session, url)
        rows, url = parse_list_page(html)
        animals.extend(rows)

    print(f"{len(animals)} animales encontrados. Scrapeando fichas...")

    for animal in tqdm(animals):
        try:
            html = fetch(session, animal.url_ficha)
            animal.descripcion, animal.imagenes = parse_detail_page(html)
        except AntiBotDetected:
            print("Anti-bot detectado durante las fichas. Parando.")
            break

    save(animals)
    print("Datos guardados correctamente.")


if __name__ == "__main__":
    try:
        main()
    except AntiBotDetected:
        print("Anti-bot detectado. El scraping fue detenido limpiamente.")

