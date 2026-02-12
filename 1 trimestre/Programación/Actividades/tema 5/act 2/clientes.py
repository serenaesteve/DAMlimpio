clientes = []  

while True:
    print("===== MENU DE AGENDA DE CLIENTES =====")
    print("1. Insertar cliente")
    print("2. Listar clientes")
    print("3. Actualizar cliente")
    print("4. Eliminar cliente")
    print("5. Salir")

    opcion = input("Elija una opcion: ")

    if opcion == "1":
      
        nombre = input("Nombre: ")
        telefono = input("Telefono: ")
        correo = input("Correo: ")
        cliente = {"nombre": nombre, "telefono": telefono, "correo": correo}
        clientes.append(cliente)
        print("Cliente agregado correctamente.\n")

    elif opcion == "2":
        
        if len(clientes) == 0:
            print("No hay clientes registrados.\n")
        else:
            print("Lista de clientes:")
            for i, cliente in enumerate(clientes, start=1):
                print(i, cliente["nombre"], "-", cliente["telefono"], "-", cliente["correo"])
            print()

    elif opcion == "3":
        
        if len(clientes) == 0:
            print("No hay clientes para actualizar.\n")
        else:
            for i, cliente in enumerate(clientes, start=1):
                print(i, cliente["nombre"])
            num = int(input("Numero del cliente a actualizar: ")) - 1
            if 0 <= num < len(clientes):
                nombre = input("Nuevo nombre (dejar vacio para mantener): ")
                telefono = input("Nuevo telefono (dejar vacio para mantener): ")
                correo = input("Nuevo correo (dejar vacio para mantener): ")

                if nombre != "":
                    clientes[num]["nombre"] = nombre
                if telefono != "":
                    clientes[num]["telefono"] = telefono
                if correo != "":
                    clientes[num]["correo"] = correo

                print("Cliente actualizado correctamente.\n")
            else:
                print("Numero invalido.\n")

    elif opcion == "4":
       
        if len(clientes) == 0:
            print("No hay clientes para eliminar.\n")
        else:
            for i, cliente in enumerate(clientes, start=1):
                print(i, cliente["nombre"])
            num = int(input("Numero del cliente a eliminar: ")) - 1
            if 0 <= num < len(clientes):
                eliminado = clientes.pop(num)
                print("Cliente", eliminado["nombre"], "eliminado correctamente.\n")
            else:
                print("Numero invalido.\n")

    elif opcion == "5":
        print("Saliendo del programa. Gracias por usar la agenda.")
        break

    else:
        print("Opcion no valida. Intente de nuevo.\n")