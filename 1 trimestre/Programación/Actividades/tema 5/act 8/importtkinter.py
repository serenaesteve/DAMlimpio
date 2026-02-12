import tkinter as tk
from tkinter import messagebox
import os
import sqlite3

def procesar():
    carpeta = entry_carpeta.get().strip()
    disco = entry_disco.get().strip()
    
    if not carpeta or not disco:
        messagebox.showwarning("Advertencia", "Por favor completa ambos campos")
        return

    if not os.path.isdir(carpeta):
        messagebox.showerror("Error", "La carpeta no existe o no es valida")
        return

    conn = sqlite3.connect("discos.db")
    cursor = conn.cursor()

    cursor.execute("""
        CREATE TABLE IF NOT EXISTS archivos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            disco TEXT,
            ruta TEXT,
            nombre_archivo TEXT,
            tamano INTEGER
        )
    """)

    for root, dirs, files in os.walk(carpeta):
        for file in files:
            ruta_completa = os.path.join(root, file)
            try:
                tamano = os.path.getsize(ruta_completa)
                cursor.execute(
                    "INSERT INTO archivos (disco, ruta, nombre_archivo, tamano) VALUES (?, ?, ?, ?)",
                    (disco, root, file, tamano)
                )
            except Exception as e:
                print(f"No se pudo leer el archivo {ruta_completa}: {e}")

    conn.commit()
    conn.close()
    messagebox.showinfo("Exito", f"Se ha indexado la carpeta '{carpeta}' en el disco '{disco}'")

ventana = tk.Tk()
ventana.title("Indexador de Archivos")
ventana.geometry("400x200")

tk.Label(ventana, text="Nombre de la carpeta:").pack(pady=(20,0))
entry_carpeta = tk.Entry(ventana, width=50)
entry_carpeta.pack()

tk.Label(ventana, text="Nombre del disco:").pack(pady=(10,0))
entry_disco = tk.Entry(ventana, width=50)
entry_disco.pack()

btn_procesar = tk.Button(ventana, text="Procesar", command=procesar)
btn_procesar.pack(pady=20)

ventana.mainloop()
