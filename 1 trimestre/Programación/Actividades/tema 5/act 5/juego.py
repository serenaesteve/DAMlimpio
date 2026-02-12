import os


os.mkdir("juegos_de_mesa")
print("Directorio 'juegos_de_mesa' creado.")


os.chdir("juegos_de_mesa")
print("Cambiado al directorio 'juegos_de_mesa'.")


with open("lista_juegos.txt", "w") as archivo:
    archivo.write("Ajedrez, Monopoly, Catán, Risk")
print("Archivo 'lista_juegos.txt' creado con juegos favoritos.")


with open("lista_juegos.txt", "a") as archivo:
    archivo.write(", Scrabble")
print("Nuevo juego anadido al archivo.")


os.chdir("..")
print("Volviendo al directorio principal.")


os.remove("juegos_de_mesa/lista_juegos.txt")
os.rmdir("juegos_de_mesa")
print("Directorio 'juegos_de_mesa' eliminado.")