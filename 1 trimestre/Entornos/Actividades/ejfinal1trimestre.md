ACTIVIDAD DE ESTORNOS DE DESARROLLO DE FIANL DE TRIMESTRE DE SERENA SANIA ESTEVE


📝 Proyecto en Python: Gestión básica de libros con enfoque en optimización y documentación 

📌 Contexto 

Este proyecto te ayudará a practicar cómo: 

Mejorar la estructura y eficiencia de tu código (optimización) 

Documentar correctamente tu código para que sea fácil de entender y mantener 

📋 Actividad 

Crea una clase Libro con los atributos: 

titulo (str) 

autor (str) 

anio (int) 

Crea una clase Biblioteca que contenga: 

Una lista para almacenar libros 

Métodos para: 

Añadir libro 

Mostrar todos los libros 

Buscar libro por título 

Eliminar libro por título 

El programa debe ofrecer un menú sencillo para que el usuario elija qué hacer. 

Optimiza tu código para evitar repeticiones y mejorar la claridad: 

Por ejemplo, usa métodos privados para búsquedas repetidas 

Evita duplicar código en mostrar resultados o validar datos 

Añade documentación clara y útil: 

Usa docstrings en todas las clases y métodos 

Incluye comentarios donde el código pueda no ser obvio 

Explica qué hace cada parte y cómo usarla 

Forma 

🧩 Qué entregar 

Código Python completo funcionando 

Código limpio, con funciones/métodos bien definidos 

Documentación correcta (docstrings y comentarios) 








RESPUESTA:



En este proyecto he desarrollado un programa en Python para la gestión básica de libros dentro de una biblioteca.
El objetivo principal es practicar el uso de clases, objetos, listas y métodos, además de aplicar conceptos de optimización del código y documentación.

El programa permite realizar operaciones simples como añadir, mostrar, buscar y eliminar libros, todo a través de un menú interactivo en consola.
Durante el desarrollo he intentado mantener el código limpio, ordenado y reutilizable, utilizando métodos privados para evitar repeticiones y docstrings para documentar correctamente cada parte del código.

Este proyecto me ha servido para reforzar mis conocimientos sobre la programación orientada a objetos (POO), la estructura de programas en Python y la importancia de una buena documentación para facilitar el mantenimiento y la comprensión del código

```
"""
Proyecto: Gestion basica de libros
Autor: Serena Sania Esteve
Fecha: 30/10/2025
Descripcion:
Este programa permite gestionar una coleccion de libros en una biblioteca.
Se pueden anadir, mostrar, buscar y eliminar libros.
Esta pensado para practicar clases, listas, metodos y documentacion en Python.
"""


class Libro:
    """
    Clase que define un libro con su titulo, autor y ano.
    """

    def __init__(self, titulo: str, autor: str, anio: int):
        """
        Constructor de la clase Libro.

        :param titulo: Titulo del libro
        :param autor: Autor del libro
        :param anio: Ano de publicacion
        """
        self.titulo = titulo
        self.autor = autor
        self.anio = anio

    def __str__(self) -> str:
        """
        Devuelve una representacion en texto del libro.

        :return: Cadena con los datos del libro
        """
        return f"'{self.titulo}' de {self.autor} ({self.anio})"


class Biblioteca:
    """
    Clase que gestiona una coleccion de libros.
    """

    def __init__(self):
        """Inicializa la biblioteca con una lista vacia de libros."""
        self.libros = []

    def _buscar_libro(self, titulo: str):
        """
        Metodo privado para buscar un libro por su titulo.

        :param titulo: Titulo del libro a buscar
        :return: Objeto Libro si existe, o None si no se encuentra
        """
        for libro in self.libros:
            if libro.titulo.lower() == titulo.lower():
                return libro
        return None

    def anadir_libro(self, libro: Libro):
        """
        Anade un libro a la biblioteca si no existe otro con el mismo titulo.

        :param libro: Objeto Libro a anadir
        """
        if self._buscar_libro(libro.titulo):
            print("Ya existe un libro con ese titulo.")
        else:
            self.libros.append(libro)
            print("Libro anadido correctamente.")

    def mostrar_libros(self):
        """Muestra todos los libros de la biblioteca."""
        if not self.libros:
            print("No hay libros en la biblioteca.")
        else:
            print("\n--- Lista de libros ---")
            for libro in self.libros:
                print(libro)

    def buscar_libro(self, titulo: str):
        """
        Busca y muestra un libro por su titulo.

        :param titulo: Titulo del libro a buscar
        """
        libro = self._buscar_libro(titulo)
        if libro:
            print(f"Libro encontrado: {libro}")
        else:
            print("No se encontro ningun libro con ese titulo.")

    def eliminar_libro(self, titulo: str):
        """
        Elimina un libro de la biblioteca por su titulo.

        :param titulo: Titulo del libro a eliminar
        """
        libro = self._buscar_libro(titulo)
        if libro:
            self.libros.remove(libro)
            print("Libro eliminado correctamente.")
        else:
            print("No se encontro el libro para eliminarlo.")


def menu():
    """
    Muestra un menu de opciones para interactuar con la biblioteca.
    """
    biblioteca = Biblioteca()

    while True:
        print("\n--- MENU DE BIBLIOTECA ---")
        print("1. Anadir libro")
        print("2. Mostrar todos los libros")
        print("3. Buscar libro por titulo")
        print("4. Eliminar libro por titulo")
        print("5. Salir")

        opcion = input("Elige una opcion: ")

        if opcion == "1":
            titulo = input("Titulo: ")
            autor = input("Autor: ")
            try:
                anio = int(input("Ano: "))
                nuevo_libro = Libro(titulo, autor, anio)
                biblioteca.anadir_libro(nuevo_libro)
            except ValueError:
                print("El ano debe ser un numero.")

        elif opcion == "2":
            biblioteca.mostrar_libros()

        elif opcion == "3":
            titulo = input("Introduce el titulo del libro a buscar: ")
            biblioteca.buscar_libro(titulo)

        elif opcion == "4":
            titulo = input("Introduce el titulo del libro a eliminar: ")
            biblioteca.eliminar_libro(titulo)

        elif opcion == "5":
            print("Saliendo del programa...")
            break

        else:
            print("Opcion no valida, intentalo de nuevo.")


if __name__ == "__main__":
    menu()
```


Salida del código en la terminal:


--- MENU DE BIBLIOTECA ---
1. Anadir libro
2. Mostrar todos los libros
3. Buscar libro por titulo
4. Eliminar libro por titulo
5. Salir
Elige una opcion: 1
Titulo: Hola
Autor: Antonio Lopez
Ano: 2003
Libro anadido correctamente.

--- MENU DE BIBLIOTECA ---
1. Anadir libro
2. Mostrar todos los libros
3. Buscar libro por titulo
4. Eliminar libro por titulo
5. Salir
Elige una opcion: 1
Titulo: Adios
Autor: Antonio Lopez
Ano: 2004
Libro anadido correctamente.

--- MENU DE BIBLIOTECA ---
1. Anadir libro
2. Mostrar todos los libros
3. Buscar libro por titulo
4. Eliminar libro por titulo
5. Salir
Elige una opcion: 2

--- Lista de libros ---
'Hola' de Antonio Lopez (2003)
'Adios' de Antonio Lopez (2004)

--- MENU DE BIBLIOTECA ---
1. Anadir libro
2. Mostrar todos los libros
3. Buscar libro por titulo
4. Eliminar libro por titulo
5. Salir
Elige una opcion: 3
Introduce el titulo del libro a buscar: Hola
Libro encontrado: 'Hola' de Antonio Lopez (2003)

--- MENU DE BIBLIOTECA ---
1. Anadir libro
2. Mostrar todos los libros
3. Buscar libro por titulo
4. Eliminar libro por titulo
5. Salir
Elige una opcion: 3
Introduce el titulo del libro a buscar: Buenos dias
No se encontro ningun libro con ese titulo.

--- MENU DE BIBLIOTECA ---
1. Anadir libro
2. Mostrar todos los libros
3. Buscar libro por titulo
4. Eliminar libro por titulo
5. Salir
Elige una opcion: 4
Introduce el titulo del libro a eliminar: Adios
Libro eliminado correctamente.

--- MENU DE BIBLIOTECA ---
1. Anadir libro
2. Mostrar todos los libros
3. Buscar libro por titulo
4. Eliminar libro por titulo
5. Salir
Elige una opcion: 5
Saliendo del programa...
PS C:\Users\Serena\Documents\Entornos\Actividades>




Gracias a este proyecto he aprendido a organizar mejor mi código y a aplicar los principios básicos de la orientación a objetos en Python.
He comprendido la importancia de planificar la estructura del programa antes de empezar a programar, así como el valor de optimizar y documentar correctamente cada parte.

También he podido practicar cómo trabajar con listas y clases, cómo usar métodos privados para evitar código duplicado, y cómo diseñar un menú sencillo para interactuar con el usuario.
En general, este proyecto me ha ayudado a mejorar mi lógica de programación y a escribir código más claro, ordenado y profesional.

 
