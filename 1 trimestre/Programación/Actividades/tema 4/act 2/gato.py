class Gato:
    def __init__(self, color, edad, raza):
        self.__color = color      
        self.edad = edad         
        self.raza = raza          

   
    def obtener_color(self):
        return self.__color


pelusa = Gato("Blanco y negro", 3, "persa")


print("El color de Pelusa es:", pelusa.obtener_color())