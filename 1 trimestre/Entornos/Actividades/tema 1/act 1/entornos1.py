procesos_generados = []

def generar_proceso(proceso):
    procesos_generados.append(proceso)

def ejecutar_proceso(indice):
    print("Ejecutando proceso:", procesos_generados[indice])

def mostrar_procesos():
    for i in range(len(procesos_generados)):
        print(i, ":", procesos_generados[i])


generar_proceso("combate")
generar_proceso("recolección")

mostrar_procesos()
ejecutar_proceso(0)