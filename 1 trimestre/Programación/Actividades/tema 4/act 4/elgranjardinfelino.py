class Gato:
    def __init__(self, color, edad, raza, nombre, color_ojos):
        self.__color = color
        self.__edad = edad
        self.__raza = raza
        self.__nombre = nombre
        self.__color_ojos = color_ojos

    def maulla(self):
        print("miau")

    def getEdad(self):
        return self.__edad

    def setEdad(self, nuevaedad):
        if nuevaedad == self.__edad + 1:
            self.__edad = nuevaedad
            print("Edad cambiada correctamente.")
        else:
            print("Operacion no permitida.")

    def imprimeInformacion(self):
        print("Nombre:", self.__nombre)
        print("Color:", self.__color)
        print("Edad:", self.__edad)
        print("Raza:", self.__raza)
        print("Color de ojos:", self.__color_ojos)


g1 = Gato("Negro", 2, "persa", "Luna", "avellana")
g1.maulla()
g1.imprimeInformacion()
g1.setEdad(4)
g1.setEdad(3)
print("Edad actual:", g1.getEdad())