import os

carpeta = r"C:\Users\Serena\Documents\Sistemas\Actividades"

for ruta, subdirs, archivos in os.walk(carpeta):
    print("Ruta:", ruta)
    print("Subcarpetas:", subdirs)
    print("Archivos:", archivos)
    print("-" * 40)

