import sqlite3

conn = sqlite3.connect('tiendaonline.db')
cursor = conn.cursor()

cursor.execute('''
CREATE TABLE IF NOT EXISTS productos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    descripcion TEXT,
    precio REAL
)
''')

productos = [
    ('Sudadera Deportiva', 'Sudadera cómoda para actividades al aire libre', 25.99),
    ('Mochila de Senderismo', 'Mochila resistente para excursiones', 45.50),
    ('Juego de Mesa Aventura', 'Juego de mesa divertido para toda la familia', 30.00),
    ('Pelota de Fútbol', 'Pelota oficial de tamaño estándar', 20.00)
]

cursor.executemany('INSERT INTO productos (nombre, descripcion, precio) VALUES (?, ?, ?)', productos)

conn.commit()
conn.close()

print("Base de datos creada y productos insertados correctamente.")

