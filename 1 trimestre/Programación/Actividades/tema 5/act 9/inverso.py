posts = [
    ["05/10/2025", "Plantando rosas en otoño"],
    ["10/09/2025", "Cómo cuidar el césped"],
    ["01/11/2025", "Explorando senderos en la naturaleza"]
]


posts_orden_inverso = posts[::-1]


with open("blog.html", "w", encoding="utf-8") as archivo:
    archivo.write("<html>\n")
    archivo.write("<head><title>Blog de Naturaleza y Juegos de Mesa</title></head>\n")
    archivo.write("<body>\n")
    archivo.write("<header><h1>Posts recientes</h1></header>\n")
    archivo.write("<main>\n")

    for post in posts_orden_inverso:
        archivo.write(f"<article><time>{post[0]}</time><p>{post[1]}</p></article>\n")

    archivo.write("</main>\n")
    archivo.write("<footer>(c) 2025 Serena Sania Esteve</footer>\n")
    archivo.write("</body>\n</html>")

print("Archivo blog.html creado correctamente. Abrelo en tu navegador.")