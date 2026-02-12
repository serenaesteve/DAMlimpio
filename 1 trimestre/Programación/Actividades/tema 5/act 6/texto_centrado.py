import os


columnas, filas = os.get_terminal_size()

print("\033[2J")


texto = "¡Bienvenido al juego!"


print("\033[34m")


centrox = round(columnas / 2)
centroy = round(filas / 2)
iniciox = round(centrox - len(texto) / 2)


print(f"\033[{centroy};{iniciox}H", end="")
print(texto)


print("\033[0m")