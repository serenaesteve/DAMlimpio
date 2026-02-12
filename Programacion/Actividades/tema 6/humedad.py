rocas_encontradas = ["granito", "basalto", "caliza", "arenisca", "marmol"]
humedad_suelo = 65
arboles_contados = {"roble": 5, "pino": 8, "abedul": 3}

def calcular_promedio_humedad(lista_humedades):
    total = lista_humedades[0] + lista_humedades[1] + lista_humedades[2]
    return total / len(lista_humedades)

humedades = [65, 70, 60]
promedio_humedad = calcular_promedio_humedad(humedades)

print("Rocas encontradas:", rocas_encontradas)
print("Humedad del suelo:", humedad_suelo)
print("Arboles contados:", arboles_contados)
print("Promedio de humedad recolectada:", promedio_humedad)

