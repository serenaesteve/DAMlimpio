import sqlite3, os

db_path = "blog.db"
html_path = "index.html"

# Conectar a la base de datos
conn = sqlite3.connect(db_path)
cur = conn.cursor()

# Crear la tabla si no existe
cur.execute("""
CREATE TABLE IF NOT EXISTS articulos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    contenido TEXT NOT NULL
)
""")

# Insertar ejemplos si la tabla está vacía
cur.execute("SELECT COUNT(*) FROM articulos")
if cur.fetchone()[0] == 0:
    ejemplos = [
        ("Explorando el Bosque de la Vida", "Hoy recorrí un sendero lleno de robles y flores silvestres."),
        ("Estrategias para Catan", "Consejos para ganar más partidas en Catan."),
        ("Rutas fáciles para caminatas", "Tres senderos perfectos para principiantes.")
    ]
    cur.executemany("INSERT INTO articulos (titulo, contenido) VALUES (?, ?)", ejemplos)
    conn.commit()

# Consultar artículos
cur.execute("SELECT titulo, contenido FROM articulos")
articulos = cur.fetchall()

# Mostrar títulos por consola
print("Títulos de los artículos:")
for a in articulos:
    print(" -", a[0])

# Crear HTML
html = """<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Blog de Jose Vicente</title>
<style>
body { font-family: Arial, sans-serif; background-color: #eef3f0; margin: 40px; }
h1 { color: #2b6b4f; text-align: center; }
.articulo { background: #fff; border-radius: 10px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
.titulo { color: #1a4d2e; font-size: 1.4em; margin-bottom: 10px; }
.contenido { color: #333; }
</style>
</head>
<body>
<h1>Blog de Jose Vicente</h1>
"""

for titulo, contenido in articulos:
    html += f'<div class="articulo"><div class="titulo">{titulo}</div><div class="contenido">{contenido}</div></div>\n'

html += "</body></html>"

# Guardar HTML
with open(html_path, "w", encoding="utf-8") as f:
    f.write(html)

conn.close()

print("\nSe ha creado el archivo:", os.path.abspath(html_path))

