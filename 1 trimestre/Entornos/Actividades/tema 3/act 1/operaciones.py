def operacionMatematica(num1, num2, operacion="suma"):
    if operacion == "suma":
        return num1 + num2
    elif operacion == "resta":
        return num1 - num2
    elif operacion == "multiplicacion":
        return num1 * num2
    else:
        return 0 
    
resultado1 = operacionMatematica(5, 3, "suma")
print("Resultado de la suma:", resultado1)  


resultado2 = operacionMatematica(10, 4, "resta")
print("Resultado de la resta:", resultado2)  


resultado3 = operacionMatematica(6, 7, "multiplicacion")
print("Resultado de la multiplicacion:", resultado3)  


resultado4 = operacionMatematica(2, 2, "division")
print("Resultado de operacion no valida:", resultado4) 