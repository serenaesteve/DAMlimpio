"""
Proyecto: Registro simple de alumnos
Autor: [Tu nombre]
Fecha: [Fecha actual]
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