import os
import fnmatch

def buscar_archivos(carpeta, patron):
    encontrados = False
    for ruta_actual, subcarpetas, archivos in os.walk(carpeta):
        for archivo in archivos:
            if fnmatch.fnmatch(archivo, patron):
                print(os.path.join(ruta_actual, archivo))
                encontrados = True
    if not encontrados:
        print("No se encontraron archivos")

carpeta = r"C:\Users\Serena\Documents\Sistemas\Actividades\tema 3"
patron = "*"

if os.path.isdir(carpeta):
    buscar_archivos(carpeta, patron)
else:
    print("La ruta no es valida")

