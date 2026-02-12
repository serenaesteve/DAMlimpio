print("Bienvenido al programa de gestion CRUD")

registros = []

while True:
    print("\nMenu CRUD")
    print("1. Crear un registro")
    print("2. Leer registros")
    print("3. Actualizar un registro")
    print("4. Eliminar un registro")
    print("5. Salir")

    opcion = input("\nElige una opcion: ")

    if opcion == "1":
        nuevo = input("Introduce el nuevo registro: ")
        registros.append(nuevo)
        print("Registro agregado correctamente.")

    elif opcion == "2":
        if len(registros) == 0:
            print("No hay registros para mostrar.")
        else:
            print("Registros actuales:")
            for i, r in enumerate(registros):
                print(f"{i + 1}. {r}")

    elif opcion == "3":
        if len(registros) == 0:
            print("No hay registros para actualizar.")
        else:
            for i, r in enumerate(registros):
                print(f"{i + 1}. {r}")
            indice = int(input("Introduce el numero del registro que deseas actualizar: ")) - 1
            if 0 <= indice < len(registros):
                nuevo_valor = input("Introduce el nuevo valor: ")
                registros[indice] = nuevo_valor
                print("Registro actualizado correctamente.")
            else:
                print("Numero de registro no valido.")

    elif opcion == "4":
        if len(registros) == 0:
            print("No hay registros para eliminar.")
        else:
            for i, r in enumerate(registros):
                print(f"{i + 1}. {r}")
            indice = int(input("Introduce el numero del registro que deseas eliminar: ")) - 1
            if 0 <= indice < len(registros):
                registros.pop(indice)
                print("Registro eliminado correctamente.")
            else:
                print("Numero de registro no valido.")

    elif opcion == "5":
        print("Saliendo del programa...")
        break

    else:
        print("Opcion no valida. Intenta de nuevo.")






