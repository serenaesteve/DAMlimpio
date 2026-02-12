import sqlite3

# Conectar con la base de datos (se crea si no existe)
conn = sqlite3.connect("empresa.db")

# Crear cursor para ejecutar comandos SQL
cursor = conn.cursor()

# Crear tablas si no existen
cursor.execute("""
CREATE TABLE IF NOT EXISTS clientes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT,
    email TEXT,
    telefono TEXT
)
""")

cursor.execute("""
CREATE TABLE IF NOT EXISTS productos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT,
    precio REAL,
    stock INTEGER
)
""")

cursor.execute("""
CREATE TABLE IF NOT EXISTS pedidos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_cliente INTEGER,
    id_producto INTEGER,
    cantidad INTEGER,
    FOREIGN KEY(id_cliente) REFERENCES clientes(id),
    FOREIGN KEY(id_producto) REFERENCES productos(id)
)
""")

conn.commit()
conn.close()

print("Base de datos creada correctamente.")