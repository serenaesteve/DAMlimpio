import tkinter as tk
from tkinter import messagebox
import csv


ventana = tk.Tk()
ventana.title("Gestión de Clientes - Tienda de Juguetes al Aire Libre")
ventana.geometry("400x250")


nombre_var = tk.StringVar()
apellidos_var = tk.StringVar()
email_var = tk.StringVar()


tk.Label(ventana, text="Nombre:").grid(row=0, column=0, padx=10, pady=10)
tk.Label(ventana, text="Apellidos:").grid(row=1, column=0, padx=10, pady=10)
tk.Label(ventana, text="Email:").grid(row=2, column=0, padx=10, pady=10)


tk.Entry(ventana, textvariable=nombre_var).grid(row=0, column=1, padx=10, pady=10)
tk.Entry(ventana, textvariable=apellidos_var).grid(row=1, column=1, padx=10, pady=10)
tk.Entry(ventana, textvariable=email_var).grid(row=2, column=1, padx=10, pady=10)


def insertaCliente():
    nombre = nombre_var.get()
    apellidos = apellidos_var.get()
    email = email_var.get()
    
    if nombre == "" or apellidos == "" or email == "":
        messagebox.showwarning("Advertencia", "Todos los campos son obligatorios")
        return

    with open("clientes.csv", "a", newline="") as archivo:
        escritor = csv.writer(archivo)
        escritor.writerow([nombre, apellidos, email])
    
    nombre_var.set("")
    apellidos_var.set("")
    email_var.set("")
    
    messagebox.showinfo("Éxito", "Cliente registrado correctamente")


tk.Button(ventana, text="Guardar Cliente", command=insertaCliente).grid(row=3, column=0, columnspan=2, pady=20)


ventana.mainloop()
