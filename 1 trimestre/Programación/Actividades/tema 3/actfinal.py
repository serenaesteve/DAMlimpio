import mysql.connector

# Conexión a la base de datos
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="crud_python"
)
cursor = conexion.cursor()

print("Bienvenido al programa de gestión CRUD con MySQL")

while True:
    print("\n--- Menú CRUD ---")
    print("1. Crear un registro")
    print("2. Listar registros")
    print("3. Actualizar un registro")
    print("4. Eliminar un registro")
    print("5. Salir")

    opcion = input("Elige una opción: ")

    if opcion == "1":  
        nuevo = input("Introduce el nuevo registro: ")
        cursor.execute("INSERT INTO registros (contenido) VALUES (%s)", (nuevo,))
        conexion.commit()
        print("Registro agregado correctamente.")

    elif opcion == "2":  
        cursor.execute("SELECT * FROM registros")
        resultados = cursor.fetchall()
        if resultados:
            print("\nRegistros actuales:")
            for fila in resultados:
                print(f"{fila[0]}. {fila[1]}")
        else:
            print("No hay registros para mostrar.")

    elif opcion == "3":  
        cursor.execute("SELECT * FROM registros")
        resultados = cursor.fetchall()
        if resultados:
            print("\nRegistros disponibles:")
            for fila in resultados:
                print(f"{fila[0]}. {fila[1]}")
            id_registro = input("Introduce el ID del registro a actualizar: ")
            nuevo_valor = input("Introduce el nuevo valor: ")
            cursor.execute(
                "UPDATE registros SET contenido = %s WHERE id = %s",
                (nuevo_valor, id_registro)
            )
            conexion.commit()
            print("Registro actualizado correctamente.")
        else:
            print("No hay registros para actualizar.")

    elif opcion == "4": 
        cursor.execute("SELECT * FROM registros")
        resultados = cursor.fetchall()
        if resultados:
            print("\nRegistros disponibles:")
            for fila in resultados:
                print(f"{fila[0]}. {fila[1]}")
            id_registro = input("Introduce el ID del registro a eliminar: ")
            cursor.execute("DELETE FROM registros WHERE id = %s", (id_registro,))
            conexion.commit()
            print("Registro eliminado correctamente.")
        else:
            print("No hay registros para eliminar.")

    elif opcion == "5":  
        print("Saliendo del programa...")
        break

    else:
        print("Opción no válida. Intenta de nuevo.")


cursor.close()
conexion.close()
print("Conexión cerrada correctamente.")
