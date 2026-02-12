import mysql.connector


conexion = mysql.connector.connect(
    host="localhost",
    user="root",                
    password="",  
    database="empresarial"
)

cursor = conexion.cursor()


while True:
    print("\n--- MENÚ DE CLIENTES ---")
    print("1.- Insertar un cliente")
    print("2.- Listar los clientes")
    print("3.- Actualizar un cliente")
    print("4.- Borrar un cliente")
    print("5.- Salir")

    try:
        opcion = int(input("Escoge tu opción: "))
    except ValueError:
        print("Debes ingresar un número del 1 al 5")
        continue


    if opcion == 1:
        nombre = input("Introduce el nombre del cliente: ")
        apellidos = input("Introduce los apellidos del cliente: ")
        telefono = input("Introduce el teléfono del cliente: ")
        email = input("Introduce el email del cliente: ")

        sql_insert = "INSERT INTO clientes (nombre, apellidos, telefono, email) VALUES (%s, %s, %s, %s)"
        cursor.execute(sql_insert, (nombre, apellidos, telefono, email))
        conexion.commit()
        print("Cliente insertado correctamente.")


    elif opcion == 2:
        cursor.execute("SELECT * FROM clientes")
        clientes = cursor.fetchall()
        if clientes:
            print("\nLista de clientes:")
            for cliente in clientes:
                print(f"ID: {cliente[0]}, Nombre: {cliente[1]}, Apellidos: {cliente[2]}, Teléfono: {cliente[3]}, Email: {cliente[4]}")
        else:
            print("No hay clientes registrados.")


    elif opcion == 3:
        Identificador = input("Introduce el ID del cliente a actualizar: ")
        nombre = input("Nuevo nombre: ")
        apellidos = input("Nuevos apellidos: ")
        telefono = input("Nuevo teléfono: ")
        email = input("Nuevo email: ")

        sql_update = "UPDATE clientes SET nombre=%s, apellidos=%s, telefono=%s, email=%s WHERE Identificador=%s"
        cursor.execute(sql_update, (nombre, apellidos, telefono, email, Identificador))
        conexion.commit()
        print("Cliente actualizado correctamente.")


    elif opcion == 4:
        Identificador = input("Introduce el ID del cliente a borrar: ")
        sql_delete = "DELETE FROM clientes WHERE Identificador=%s"
        cursor.execute(sql_delete, (Identificador,))
        conexion.commit()
        print("Cliente eliminado correctamente.")


    elif opcion == 5:
        print("Saliendo del programa...")
        break

    else:
        print("Opción no válida. Ingresa un número del 1 al 5.")


cursor.close()
conexion.close()

