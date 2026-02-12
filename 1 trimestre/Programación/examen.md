En este proyecto desarrollé un programa en Python para la gestión de mi portafolio, utilizando una base de datos MySQL. El objetivo principal fue crear una aplicación sencilla que permitiera insertar, listar, actualizar y eliminar registros de manera interactiva. Aprendí a conectar Python con MySQL, manejar consultas SQL y diseñar un menú que facilita la interacción del usuario. Además, el proyecto me permitió entender mejor cómo funcionan las operaciones CRUD y la importancia de organizar el código para que sea funcional y claro.


1. Importación y conexión a la base de datos:
```
import mysql.connector

conexion = mysql.connector.connect(
  host="localhost",
  user="portafolio",
  password="Portafolio123$",
  database="portafolioexamen"
)
cursor = conexion.cursor()
```

2. Mensaje de bienvenida:
```
 print("Gestion de portafolio v1.0")
```

3. Bucle principal del programa:
```
while True:
  print("Escoge una opcion")
  print("1.-Insertar pieza")
  print("2.-Listar piezas")
  print("3.-Actualizar pieza")
  print("4.-Eliminar pieza")
  print("5.-Salir")
  opcion = int(input("Escoge una opcion: "))
  print("La opcion que has escogido es:", opcion)
```

4. Opción 1 – Insertar nueva pieza:
```
if opcion == 1:
  titulo = input("Introduce el titulo de la pieza: ")
  descripcion = input("Introduce la descripcion de la pieza: ")
  fecha = input("Introduce la fecha de la pieza (YYYY-MM-DD): ")
  imagen = input("Introduce el nombre de la imagen: ")
  id_categoria = input("Introduce el id de la categoria: ")
  cursor.execute("INSERT INTO piezasportafolio VALUES (NULL,'"+titulo+"','"+descripcion+"','"+fecha+"',"+id_categoria+",'"+imagen+"');")
  conexion.commit()
```

5. Opción 2 – Listar piezas:
```
elif opcion == 2:
  cursor.execute("SELECT piezasportafolio.Identificador, piezasportafolio.titulo, piezasportafolio.descripcion, piezasportafolio.fecha, categoriasportafolio.nombre, piezasportafolio.imagen FROM piezasportafolio INNER JOIN categoriasportafolio ON piezasportafolio.id_categoria = categoriasportafolio.id;")
  lineas = cursor.fetchall()
  for linea in lineas:
    print(linea)
```

6. Opción 3 – Actualizar pieza:
```
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
```

7. Opción 4 – Eliminar pieza:
```
elif opcion == 4:
  identificador = input("Introduce el id de la pieza a eliminar: ")
  cursor.execute("DELETE FROM piezasportafolio WHERE Identificador = "+identificador+";")
  conexion.commit()
```

8. Opción 5 – Salir del programa:
```
elif opcion == 5:
  print("Saliendo del programa...")
  break
```

9. Cierre de conexión:
```
cursor.close()
conexion.close()
```

Código completo:
```
import mysql.connector

conexion = mysql.connector.connect(
  host="localhost",
  user="portafolio",
  password="Portafolio123$",
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
    cursor.execute("SELECT piezasportafolio.Identificador, piezasportafolio.titulo, piezasportafolio.descripcion, piezasportafolio.fecha, categoriasportafolio.nombre, piezasportafolio.imagen FROM piezasportafolio INNER JOIN categoriasportafolio ON piezasportafolio.id_categoria = categoriasportafolio.id;")
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

```

El desarrollo de este programa me permitió consolidar mis conocimientos en Python y en la gestión de bases de datos MySQL. Pude implementar correctamente las operaciones de insertar, listar, actualizar y eliminar registros, creando un sistema funcional para manejar un portafolio de piezas. Además, me hizo notar la importancia de escribir código seguro y organizado, así como de validar la información ingresada por el usuario. Este proyecto me sirve como base para seguir mejorando y construir aplicaciones más robustas y profesionales en el futuro.
