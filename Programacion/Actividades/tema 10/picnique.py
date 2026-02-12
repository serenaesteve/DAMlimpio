
nombre_jugador = ""
edad_jugador = 0
actividad_jugador = ""


nombre_jugador = input("Ingrese el nombre del jugador: ")


edad_valida = False
while edad_valida == False:
    edad_texto = input("Ingrese la edad del jugador: ")

    if edad_texto.isdigit():
        edad_jugador = int(edad_texto)
        edad_valida = True
    else:
        print("Error: la edad debe ser un número y no puede ser negativa.")


actividad_valida = False
while actividad_valida == False:
    actividad_jugador = input("Ingrese la actividad (camping, picnique, exploración): ")

    if actividad_jugador == "camping" or actividad_jugador == "picnique" or actividad_jugador == "exploración":
        actividad_valida = True
    else:
        print("Error: actividad no válida. Debe ser camping, picnique o exploración.")


print("\n--- Información del jugador en la expedición ---")
print("Nombre del jugador:", nombre_jugador)
print("Edad del jugador:", edad_jugador, "anos")
print("Actividad durante la expedición:", actividad_jugador)

