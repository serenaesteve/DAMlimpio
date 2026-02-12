madera = 10
piedra = 5
metal = 3

# Suma
total_recursos = madera + piedra + metal
print(f"Total de recursos: {total_recursos}")

# Resta
recursos_restantes = total_recursos - metal
print(f"Recursos restantes: {recursos_restantes}")

# Multiplicacion
piedra_duplicada = piedra * 2
print(f"Piedra duplicada: {piedra_duplicada}")

# Division
madera_dividida = madera / 3
print(f"Madera dividida: {madera_dividida}")

# Operaciones de comparacion
if total_recursos > 15:
    print("Tienes suficientes recursos para avanzar.")
else:
    print("No tienes suficientes recursos para avanzar.")

if piedra_duplicada < madera:
    print("La cantidad de piedra duplicada es menor que la de madera.")
else:
    print("La cantidad de piedra duplicada no es menor que la de madera.")