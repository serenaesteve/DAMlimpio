inventario = {}

def imprimeBienvenida():
    print("¡Bienvenido al Juego de Mesa!")
    print("Aqui puedes gestionar el inventario de tu jugador.\n")

def muestraMenu():
    print("=== Menu del Inventario ===")
    print("1. Insertar nuevo item")
    print("2. Listar items")
    print("3. Actualizar cantidad de item")
    print("4. Borrar item")
    print("5. Salir")

def insertarItem():
    global inventario
    nombre = input("Nombre del item: ")
    cantidad = int(input("Cantidad: "))
    inventario[nombre] = cantidad
    print("Item agregado.\n")

def listadoItems():
    global inventario
    if not inventario:
        print("El inventario está vacio.\n")
    else:
        print("=== Inventario Actual ===")
        for item, cantidad in inventario.items():
            print(item, ":", cantidad)
        print()

def actualizarItem():
    global inventario
    nombre = input("Nombre del item a actualizar: ")
    if nombre in inventario:
        nueva = int(input("Nueva cantidad: "))
        inventario[nombre] = nueva
        print("Item actualizado.\n")
    else:
        print("Ese item no existe.\n")

def borrarItem():
    global inventario
    nombre = input("Nombre del item a borrar: ")
    if nombre in inventario:
        del inventario[nombre]
        print("Item eliminado.\n")
    else:
        print("Ese item no existe.\n")


def main():
    imprimeBienvenida()
    muestraMenu()
    opcion = input("Elige una opcion (1-5): ")

    if opcion == "1":
        insertarItem()
    elif opcion == "2":
        listadoItems()
    elif opcion == "3":
        actualizarItem()
    elif opcion == "4":
        borrarItem()
    elif opcion == "5":
        print("¡Hasta la proxima!")
    else:
        print("Opcion no valida.")


if __name__ == "__main__":
    main()