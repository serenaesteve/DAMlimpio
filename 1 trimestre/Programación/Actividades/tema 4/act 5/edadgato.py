class Gato:
    def __init__(self, color, edad, raza, nombre, color_ojos):
        self.color = color
        self.edad = edad
        self.raza = raza
        self.nombre = nombre
        self.color_ojos = color_ojos

    def maulla(self):
        return "miau"

    def setEdad(self, nuevaedad):
        if self.edad + 1 == nuevaedad:
            self.edad = nuevaedad
        else:
            print("operacion no permitida")

    def getEdad(self):
        return self.edad


gato1 = Gato("blanco", 5, "persa", "alita", "azules")

print(gato1.nombre, "dice:", gato1.maulla())      
print("Edad actual:", gato1.getEdad())            

gato1.setEdad(6)                                  
print("Nueva edad:", gato1.getEdad())             

gato1.setEdad(4)                                  