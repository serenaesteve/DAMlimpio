def dividir_numeros(numerador, denominador):
    try:
        resultado = numerador / denominador
        return resultado
    except ZeroDivisionError:
        print("Error: No se puede dividir entre cero.")
        return None
    
resultado1 = dividir_numeros(20, 2)
if resultado1 is not None:
    print("Resultado de la division:", resultado1)   

resultado2 = dividir_numeros(8, 0)
if resultado2 is not None:
    print("Resultado de la división:", resultado2)