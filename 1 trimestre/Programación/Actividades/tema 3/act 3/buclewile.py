def imprimir_dias():
    dia = 1
    while True:
        print(f"Dia {dia} explorado.")
        dia += 1
        if dia > 31:
            break

def saludar(nombre, edad):
    return f"Hola {nombre}! Tienes {edad} anos y estas listo para una nueva aventura."

imprimir_dias()

frase_juan = saludar("Juan", 25)
frase_maria = saludar("Maria", 30)

print(frase_juan)
print(frase_maria)