"""
Archivo: 004-importacion_de_archivo.py
Descripción:
    Programa principal para gestionar un portafolio de piezas.
    Importa las funciones desde 'extraccion_a_funciones.py' y ejecuta un menú interactivo.
"""

from extraccionafunciones import presentaMenu, insertar, seleccionar, actualizar, eliminar

print("Gestión de portafolio v0.1")

while True:
    presentaMenu()
    opcion = int(input("Escoge una opción: "))
    print("La opción que has escogido es:", opcion)

    if opcion == 1:
        insertar()
    elif opcion == 2:
        seleccionar()
    elif opcion == 3:
        actualizar()
    elif opcion == 4:
        eliminar()
    elif opcion == 5:
        print("Saliendo del programa...")
        break
    else:
        print("Opción no válida. Intenta de nuevo.")

