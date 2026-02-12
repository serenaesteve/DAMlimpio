class Cliente:
    def __init__(self, nombre, email, direccion):
        self.nombre = nombre
        self.email = email
        self.direccion = direccion



nombre = input("Introduce el nombre del cliente: ")
email = input("Introduce el email del cliente: ")
direccion = input("Introduce la dirección del cliente: ")


cliente1 = Cliente(nombre, email, direccion)


print("\n--- Datos del cliente ---")
print("Nombre:", cliente1.nombre)
print("Email:", cliente1.email)
print("Dirección:", cliente1.direccion)