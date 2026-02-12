import random

def generar_objetos():
    return random.randint(1, 5)

sendero_actual = 0
objetos_encontrados = 0
longitud_sendero = 10  # por ejemplo, 10 espacios

for _ in range(longitud_sendero):
    sendero_actual += 1
    objetos_encontrados += generar_objetos()

print("Posicion final del sendero:", sendero_actual)
print("Total de objetos encontrados:", objetos_encontrados)
