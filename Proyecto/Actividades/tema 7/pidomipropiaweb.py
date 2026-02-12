import os
import re
import requests

url = "https://jocarsa.com"
carpeta_imagenes = "imagenes"

if not os.path.exists(carpeta_imagenes):
    os.makedirs(carpeta_imagenes)

try:
    response = requests.get(url)
    print("Status:", response.status_code)
    html = response.text
    with open("pagina.html", "w", encoding="utf-8") as f:
        f.write(html)
    print("HTML guardado en pagina.html")
except Exception as e:
    print("Error al descargar la pagina:", e)
    html = ""

img_urls = re.findall(r'<img [^>]*src="([^"]+)"', html)
bg_urls = re.findall(r'background-image\s*:\s*url\(([^)]+)\)', html)
img_urls = [u.strip('"').strip("'").replace("&#039;", "") for u in img_urls + bg_urls]

def completar_url(u):
    if u.startswith("http"):
        return u
    elif u.startswith("/"):
        return url.rstrip("/") + u
    else:
        return url.rstrip("/") + "/" + u

img_urls = list(set([completar_url(u) for u in img_urls]))

print(f"Se encontraron {len(img_urls)} imagenes.")

for i, img_url in enumerate(img_urls):
    try:
        ext = os.path.splitext(img_url)[1]
        if ext.lower() not in [".jpg", ".jpeg", ".png", ".gif", ".svg"]:
            ext = ".jpg"

        nombre_archivo = os.path.join(carpeta_imagenes, f"imagen_{i+1}{ext}")
        img_data = requests.get(img_url).content
        with open(nombre_archivo, "wb") as f:
            f.write(img_data)

        print(f"Descargada: {img_url}")
    except Exception as e:
        print(f"No se pudo descargar {img_url}: {e}")

print("Descarga completa! Revisa la carpeta 'imagenes'.")

