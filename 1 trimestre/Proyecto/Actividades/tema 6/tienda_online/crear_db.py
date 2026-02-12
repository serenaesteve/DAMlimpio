import sqlite3
import os

db_file = 'tiendaonlinenew.db'


if os.path.exists(db_file):
    os.remove(db_file)


conn = sqlite3.connect(db_file)
cursor = conn.cursor()

cursor.execute("""
CREATE TABLE productos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    descripcion TEXT NOT NULL,
    imagen TEXT NOT NULL,
    precio REAL NOT NULL
)
""")


cursor.execute("""
INSERT INTO productos (nombre, descripcion, imagen, precio) VALUES
('Portatil Lenovo IdeaPad', 'Portatil con procesador Ryzen 5 y 16GB RAM', 'lenovo.jpg', 799.99),
('Smartphone Samsung Galaxy S23', 'Telefono inteligente de ultima generacion', 'samsung.jpg', 899.99)
""")

conn.commit()
conn.close()

print("Base de datos creada correctamente")

