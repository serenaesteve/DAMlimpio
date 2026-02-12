class Perro:
    def __init__(self, nombre, raza, edad, color_pelaje, color_ojos):
        self.nombre = nombre
        self.raza = raza
        self.edad = edad
        self.color_pelaje = color_pelaje
        self.color_ojos = color_ojos

    def ladrar(self):
        print(f"{self.nombre} hace: guau")

mi_perro = Perro("Luna", "mestiza", 10, "negro", "avellana")

mi_perro.ladrar()