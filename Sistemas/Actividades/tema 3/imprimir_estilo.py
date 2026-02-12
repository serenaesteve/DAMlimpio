import os

def obtener_tamano(ruta):
    total = 0
    try:
        if os.path.isfile(ruta):
            return os.path.getsize(ruta)

        for root, dirs, files in os.walk(ruta):
            for f in files:
                archivo = os.path.join(root, f)
                try:
                    total += os.path.getsize(archivo)
                except PermissionError:
                    pass
    except PermissionError:
        pass
    return total

def print_tree(ruta, nivel=0):
    prefijo = "│   " * nivel + "├── "
    nombre = os.path.basename(ruta)
    tamano = obtener_tamano(ruta)

    print(f"{prefijo}{nombre} ({tamano} bytes)")

    try:
        if os.path.isdir(ruta):
            for elemento in os.listdir(ruta):
                print_tree(os.path.join(ruta, elemento), nivel + 1)
    except PermissionError:
        print(f"{prefijo}Acceso denegado")

print_tree(r"C:\Users\Serena\Documents\Sistemas\Actividades")

