nombre_participante = "serena"
edad_participante = 22
datos_contacto = "serenaestevee@gmail.com"

def es_mayor_de_edad(edad):
    if edad >= 18:
        return True
    else:
        return False
    
print("Datos del participante:")
print("Nombre:", nombre_participante)
print("Edad:", edad_participante)
print("Contacto:", datos_contacto)

if es_mayor_de_edad(edad_participante):
    print("Puede acceder a los recursos naturales.")
else:
    print("No puede acceder a los recursos naturales (menor de edad).")