ACTIVIDAD DE FINAL DE TRIMESTRE DE LA ASIGNATURA PROGRAMACIÓN DE SERENA SANIA ESTEVE

📝 PROYECTO EN PYTHON: Registro simple de alumnos 

📌 Descripción del ejercicio 

Vas a desarrollar un pequeño programa en Python que permita al usuario: 

Añadir alumnos nuevos 

Ver todos los alumnos registrados 

Salir del programa 

Todo esto a través de un menú sencillo en la consola. 

Forma 

🎯 Objetivos del ejercicio 

Con este proyecto aprenderás a: 

Crear y usar clases en Python 

Usar listas para guardar objetos 

Usar input() para leer datos del usuario 

Aplicar estructuras de control como if y while 

Organizar un programa en varias funciones 

Forma 

🧱 Requisitos 

1. Clase Alumno 

Crea una clase llamada Alumno que tenga: 

Atributos: 

nombre (str) 

edad (int) 

curso (str) 

Un constructor __init__ que reciba esos valores 

Un método __str__ que devuelva una frase con los datos del alumno, por ejemplo: 

"Nombre: Ana, Edad: 18, Curso: 1º DAM" 

Forma 

2. Menú principal del programa 

El programa debe mostrar este menú: 

--- REGISTRO DE ALUMNOS --- 

1. Añadir alumno 

2. Ver lista de alumnos 

3. Salir 

Elige una opción:  

Si el usuario pulsa 1: 

Se le pide el nombre, la edad y el curso del alumno 

Se crea un objeto Alumno y se guarda en una lista 

Si pulsa 2: 

Se muestran todos los alumnos registrados (uno por línea) 

Si pulsa 3: 

El programa muestra "Hasta pronto" y termina 

Si pulsa otra opción: 

Se muestra "Opción no válida" y vuelve al menú 

Forma 

🧩 Estructura sugerida del código (resumen) 

class Alumno: 

    def __init__(self, nombre, edad, curso): 

        # Guardar los datos 

 

    def __str__(self): 

        # Devolver texto con los datos del alumno 

 

def mostrar_menu(): 

    # Mostrar el menú y pedir una opción 

 

# Lista para guardar los alumnos 

alumnos = [] 

 

# Bucle principal del programa 

while True: 

    # Mostrar menú y controlar opciones 

Forma 

✅ El programa estará bien si… 

Se pueden añadir alumnos sin errores 

Se pueden ver los alumnos registrados 

El menú funciona correctamente 

El código está ordenado y comentado 

Forma 

💡 Opcional (si te animas) 

No permitir edad negativa 

Limitar la cantidad máxima de alumnos 

Guardar los datos en un archivo .txt (si ya sabes hacerlo) 




RESPUESTA:


En este proyecto he creado un programa sencillo en Python para gestionar un pequeño registro de alumnos.
El objetivo es practicar el uso de clases, listas, bucles y estructuras de control, además de mejorar la organización del código mediante funciones.
El usuario puede añadir alumnos, ver la lista completa y salir del programa mediante un menú en la consola.


```
"""
Proyecto: Registro simple de alumnos
Autor: Serena Sania Esteve
Fecha: 30/10/2025
Descripcion:
Este programa permite registrar alumnos introduciendo su nombre, edad y curso.
Los datos se guardan en una lista y se pueden mostrar en pantalla mediante un menu.
"""


class Alumno:
    """
    Clase que almacena los datos de un alumno.
    """

    def __init__(self, nombre: str, edad: int, curso: str):
        """
        Constructor de la clase Alumno.

        :param nombre: Nombre del alumno
        :param edad: Edad del alumno
        :param curso: Curso del alumno
        """
        self.nombre = nombre
        self.edad = edad
        self.curso = curso

    def __str__(self):
        """
        Devuelve una representacion en texto del alumno.
        """
        return f"Nombre: {self.nombre}, Edad: {self.edad}, Curso: {self.curso}"


def mostrar_menu():
    """
    Muestra el menu principal y devuelve la opcion elegida por el usuario.
    """
    print("\n--- REGISTRO DE ALUMNOS ---")
    print("1. Anadir alumno")
    print("2. Ver lista de alumnos")
    print("3. Salir")
    opcion = input("Elige una opcion: ")
    return opcion



alumnos = []


while True:
    opcion = mostrar_menu()

    if opcion == "1":
       
        nombre = input("Introduce el nombre del alumno: ")
        try:
            edad = int(input("Introduce la edad del alumno: "))
            if edad < 0:
                print("La edad no puede ser negativa.")
                continue
        except ValueError:
            print("La edad debe ser un numero entero.")
            continue
        curso = input("Introduce el curso del alumno (ej. 1o DAM): ")

        
        nuevo_alumno = Alumno(nombre, edad, curso)
        alumnos.append(nuevo_alumno)
        print("Alumno anadido correctamente.")

    elif opcion == "2":
       
        if len(alumnos) == 0:
            print("No hay alumnos registrados todavia.")
        else:
            print("\n--- LISTA DE ALUMNOS ---")
            for alumno in alumnos:
                print(alumno)

    elif opcion == "3":
        print("Hasta pronto.")
        break

    else:
        print("Opcion no valida. Intentalo de nuevo.")
```


Salida del código en la terminal:


PS C:\Users\Serena\Documents\Programacion\Actividades> python ejfinal1trimestre.py

--- REGISTRO DE ALUMNOS ---
1. Anadir alumno
2. Ver lista de alumnos
3. Salir
Elige una opcion: 1
Introduce el nombre del alumno: Serena
Introduce la edad del alumno: 22
Introduce el curso del alumno (ej. 1o DAM): 1o DAM
Alumno anadido correctamente.

--- REGISTRO DE ALUMNOS ---
1. Anadir alumno
2. Ver lista de alumnos
3. Salir
Elige una opcion: 1
Introduce el nombre del alumno: Sandro
Introduce la edad del alumno: 23
Introduce el curso del alumno (ej. 1o DAM): 1o DAM
Alumno anadido correctamente.

--- REGISTRO DE ALUMNOS ---
1. Anadir alumno
2. Ver lista de alumnos
3. Salir
Elige una opcion: 2

--- LISTA DE ALUMNOS ---
Nombre: Serena, Edad: 22, Curso: 1o DAM
Nombre: Sandro, Edad: 23, Curso: 1o DAM

--- REGISTRO DE ALUMNOS ---
1. Anadir alumno
2. Ver lista de alumnos
3. Salir
Elige una opcion: 3
Hasta pronto.
PS C:\Users\Serena\Documents\Programacion\Actividades>




Con este proyecto he aprendido a crear y manejar clases en Python, así como a guardar objetos dentro de listas.
También he practicado el uso de funciones para organizar el código y el uso de condicionales y bucles para crear un menú interactivo.
Este ejercicio me ayudó a entender mejor cómo se comunican las distintas partes de un programa y la importancia de validar los datos para evitar errores.
