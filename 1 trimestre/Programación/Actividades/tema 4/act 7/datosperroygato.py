class Animal:
    def __init__(self, color, edad, raza):
        self.color = color
        self.edad = edad
        self.raza = raza


class Gato(Animal):
    pass  


class Perro(Animal):
    pass  


color_gato = input("Introduce el color del gato: ")
edad_gato = int(input("Introduce la edad del gato: "))
raza_gato = input("Introduce la raza del gato: ")
gato = Gato(color_gato, edad_gato, raza_gato)


color_perro = input("Introduce el color del perro: ")
edad_perro = int(input("Introduce la edad del perro: "))
raza_perro = input("Introduce la raza del perro: ")
perro = Perro(color_perro, edad_perro, raza_perro)


print("\n--- Datos del gato ---")
print("Color:", gato.color)
print("Edad:", gato.edad)
print("Raza:", gato.raza)

print("\n--- Datos del perro ---")
print("Color:", perro.color)
print("Edad:", perro.edad)
print("Raza:", perro.raza)


print("\nEste programa muestra cómo la herencia permite que Gato y Perro usen los mismos atributos de Animal,")
print("lo que hace mas facil organizar y reutilizar el codigo en situaciones practicas.")