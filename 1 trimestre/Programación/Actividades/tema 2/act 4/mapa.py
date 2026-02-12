class PuntoDeInteres:
    def __init__(self, nombre, descripcion):
        self.nombre = nombre
        self.descripcion = descripcion

cueva = PuntoDeInteres(
    "Cueva Escondida", 
    "Una cueva secreta rodeada de un bosque denso y misterioso."
)

print("Nombre:", cueva.nombre)
print("Descripción:",cueva.descripcion)


