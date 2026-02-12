
import sqlite3


conexion = sqlite3.connect("libreria.db")


def crear_tabla():
    cursor = conexion.cursor()
    cursor.execute("""
        CREATE TABLE IF NOT EXISTS libros (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            titulo TEXT NOT NULL,
            autor TEXT NOT NULL,
            precio REAL NOT NULL
        )
    """)
    conexion.commit()
    print("Tabla 'libros' creada correctamente.")


def insertar_libros():
    cursor = conexion.cursor()
    libros = [
        ("Cien años de soledad", "Gabriel García Márquez", 20.5),
        ("El principito", "Antoine de Saint-Exupéry", 15.0),
        ("1984", "George Orwell", 18.75)
    ]
    cursor.executemany("INSERT INTO libros (titulo, autor, precio) VALUES (?, ?, ?)", libros)
    conexion.commit()
    print("Libros insertados correctamente.")


def mostrar_libros():
    cursor = conexion.cursor()
    cursor.execute("SELECT * FROM libros")
    resultados = cursor.fetchall()
    
    print("\nLibros en la base de datos:")
    for libro in resultados:
        print(f"ID: {libro[0]}, Título: {libro[1]}, Autor: {libro[2]}, Precio: ${libro[3]}")


crear_tabla()
insertar_libros()
mostrar_libros()

# Cerrar la conexión
conexion.close()

