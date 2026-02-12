def mostrar(mensaje):
    print(mensaje)

def saluda(nombre, edad):
    mensaje = "Hola, " + nombre + ". Tienes " + str(edad) + " anos."
    mostrar(mensaje)

saluda("Serena", 22)
saluda("Thais", 29)
saluda("Jonathan", 26)

class Gato:
    def __init__(self, color, edad, raza):
        self.color = color
        self.edad = edad
        self.raza = raza

    def describir(self):
        mensaje = "Este gato es de color " + self.color + ", tiene " + str(self.edad) + " anos y es de raza " + self.raza + "."
        mostrar(mensaje)

gato1 = Gato("naranja", 3, "siames")
gato2 = Gato("negro", 2, "persa")

gato1.describir()
gato2.describir()