edad = int(input("Introduce tu edad: "))

if edad < 10:
    print("¡Eres un niño!")
elif 10 <= edad <= 19:
    print("Eres un adolescente")
elif 20 <= edad <= 29:
    print("Eres un joven")
else:
    print("Ya no eres un joven")
    