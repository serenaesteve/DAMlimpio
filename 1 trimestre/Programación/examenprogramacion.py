import mysql.connector

conexion = mysql.connector.connect(
  host="localhost",
  user="serena",
  password="Examen123",
  database="portafolioexamen"
)

cursor = conexion.cursor()
print("Gestion de portafolio v1.0")
while True:
  print("Escoge una opcion")
  print("1.-Insertar pieza")
  print("2.-Listar piezas")
  print("3.-Actualizar pieza")
  print("4.-Eliminar pieza")
  print("5.-Salir")
  opcion = int(input("Escoge una opcion: "))
  print("La opcion que has escogido es:", opcion)
  


  if opcion == 1:
    titulo = input("Introduce el titulo de la pieza: ")
    descripcion = input("Introduce la descripcion de la pieza: ")
    fecha = input("Introduce la fecha de la pieza (YYYY-MM-DD): ")
    imagen = input("Introduce el nombre de la imagen: ")
    id_categoria = input("Introduce el id de la categoria: ")
    cursor.execute("INSERT INTO piezasportafolio VALUES (NULL,'"+titulo+"','"+descripcion+"','"+fecha+"',"+id_categoria+",'"+imagen+"');")
    conexion.commit()
  
  elif opcion == 2:
    cursor = conexion.cursor() 
    cursor.execute("SELECT * FROM piezasportafolio;")
    lineas = cursor.fetchall()
    for linea in lineas:
      print(linea)
  
  elif opcion == 3:
    identificador = input("Introduce el id de la pieza a actualizar: ")
    titulo = input("Introduce el nuevo titulo: ")
    descripcion = input("Introduce la nueva descripcion: ")
    fecha = input("Introduce la nueva fecha (YYYY-MM-DD): ")
    imagen = input("Introduce el nuevo nombre de la imagen: ")
    id_categoria = input("Introduce el nuevo id de la categoria: ")
    cursor.execute('''
      UPDATE piezasportafolio
      SET
      titulo = "'''+titulo+'''",
      descripcion = "'''+descripcion+'''",
      fecha = "'''+fecha+'''",
      id_categoria = '''+id_categoria+''',
      imagen = "'''+imagen+'''"
      WHERE Identificador = '''+identificador+'''
    ''')
    conexion.commit()
  
  elif opcion == 4:
    identificador = input("Introduce el id de la pieza a eliminar: ")
    cursor.execute("DELETE FROM piezasportafolio WHERE Identificador = "+identificador+";")
    conexion.commit()
  
  elif opcion == 5:
    print("Saliendo del programa...")
    break

cursor.close()
conexion.close()

