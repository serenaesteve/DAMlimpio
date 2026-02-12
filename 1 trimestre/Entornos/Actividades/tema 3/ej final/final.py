def dividir(a, b):
    return a / b

def dividir_protegido(a, b):
    try:
        resultado = a / b
    except ZeroDivisionError:
        return "Error: No se puede dividir entre cero."
    except TypeError:
        return "Error: Debes ingresar numeros."
    else:
        return resultado

def procesar_divisiones(lista_de_pares):
    resultados = []
    for a, b in lista_de_pares:
        try:
            resultado = a / b
        except ZeroDivisionError:
            resultados.append("Error: Division entre cero")
        except TypeError:
            resultados.append("Error: Tipo de dato no valido")
        else:
            resultados.append(resultado)
    return resultados

pares = [(10, 2), (5, 0), (8, "x"), (9, 3)]

print("Usando dividir_protegido:")
for a, b in pares:
    print(f"{a} / {b} = {dividir_protegido(a, b)}")

print("\nUsando procesar_divisiones:")
print(procesar_divisiones(pares))

