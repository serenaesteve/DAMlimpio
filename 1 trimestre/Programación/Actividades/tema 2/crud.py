import mysql.connector


conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",          
    database="crud_python" 
)

cursor = conexion.cursor()

print("Bienvenido al programa de gestion CRUD con MySQL")

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
        cursor.execute("INSERT INTO registros (contenido) VALUES (%s)", (nuevo,))
        conexion.commit()
        print("Registro agregado correctamente.")

    elif opcion == "2":
        cursor.execute("SELECT * FROM registros")
        resultados = cursor.fetchall()
        if len(resultados) == 0:
            print("No hay registros para mostrar.")
        else:
            print("\nRegistros actuales:")
            for fila in resultados:
                print(f"{fila[0]}. {fila[1]}")

    elif opcion == "3":
        cursor.execute("SELECT * FROM registros")
        resultados = cursor.fetchall()
        if len(resultados) == 0:
            print("No hay registros para actualizar.")
        else:
            print("\nRegistros disponibles:")
            for fila in resultados:
                print(f"{fila[0]}. {fila[1]}")
            id_registro = input("Introduce el numero del registro que deseas actualizar: ")
            nuevo_valor = input("Introduce el nuevo valor: ")
            cursor.execute("UPDATE registros SET contenido = %s WHERE id = %s", (nuevo_valor, id_registro))
            conexion.commit()
            print("Registro actualizado correctamente.")

    elif opcion == "4":
        cursor.execute("SELECT * FROM registros")
        resultados = cursor.fetchall()
        if len(resultados) == 0:
            print("No hay registros para eliminar.")
        else:
            print("\nRegistros disponibles:")
            for fila in resultados:
                print(f"{fila[0]}. {fila[1]}")
            id_registro = input("Introduce el numero del registro que deseas eliminar: ")
            cursor.execute("DELETE FROM registros WHERE id = %s", (id_registro,))
            conexion.commit()
            print("Registro eliminado correctamente.")

    elif opcion == "5":
        print("Saliendo del programa...")
        break

    else:
        print("Opcion no valida. Intenta de nuevo.")


cursor.close()
conexion.close()
print("Conexion cerrada correctamente.")


