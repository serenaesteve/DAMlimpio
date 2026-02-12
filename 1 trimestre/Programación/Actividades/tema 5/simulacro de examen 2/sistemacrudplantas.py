print("Bienvenido al sistema de gestion de plantas")

plantas = []

while True:
    print("\nMenu CRUD de plantas")
    print("1. Insertar planta")
    print("2. Listar plantas")
    print("3. Actualizar planta")
    print("4. Eliminar planta")
    print("5. Salir")

    opcion = input("\nElige una opcion: ")

    if opcion == "1":
        nombre = input("Introduce el nombre de la planta: ")
        plantas.append(nombre)
        print("Planta agregada correctamente.")

    elif opcion == "2":
        if len(plantas) == 0:
            print("No hay plantas registradas.")
        else:
            print("Lista de plantas:")
            for i, p in enumerate(plantas):
                print(f"{i + 1}. {p}")

    elif opcion == "3":
        if len(plantas) == 0:
            print("No hay plantas para actualizar.")
        else:
            for i, p in enumerate(plantas):
                print(f"{i + 1}. {p}")
            indice = int(input("Introduce el numero de la planta que deseas actualizar: ")) - 1
            if 0 <= indice < len(plantas):
                nuevo_nombre = input("Introduce el nuevo nombre: ")
                plantas[indice] = nuevo_nombre
                print("Planta actualizada correctamente.")
            else:
                print("Numero de planta no valido.")

    elif opcion == "4":
        if len(plantas) == 0:
            print("No hay plantas para eliminar.")
        else:
            for i, p in enumerate(plantas):
                print(f"{i + 1}. {p}")
            indice = int(input("Introduce el numero de la planta que deseas eliminar: ")) - 1
            if 0 <= indice < len(plantas):
                plantas.pop(indice)
                print("Planta eliminada correctamente.")
            else:
                print("Numero de planta no valido.")

    elif opcion == "5":
        print("Saliendo del sistema...")
        break

    else:
        print("Opcion no valida. Intenta de nuevo.")