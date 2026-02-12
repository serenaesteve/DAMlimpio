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
