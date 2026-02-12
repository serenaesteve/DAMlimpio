class Cliente:
    def __init__(self, id, nombre, apellidos, email, direccion):
        self.id = id
        self.nombre = nombre
        self.apellidos = apellidos
        self.email = email
        self.direccion = direccion

    def __repr__(self):
        return (
            "Cliente(id=" + str(self.id) +
            ", nombre=" + self.nombre +
            ", apellidos=" + self.apellidos +
            ", email=" + self.email +
            ", direccion=" + self.direccion + ")"
        )

cliente1 = Cliente(
    1,
    "Serena",
    "Sania Esteve",
    "serena@gmail.com",
    "Calle Castellon 25"
)

print(cliente1)

