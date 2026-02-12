nombre_muestras = ["roca_granito", "hiedra_verde", "petala_rosa"]

muestras_recolectadas = []

for nombre in nombre_muestras:
    muestra = {"nombre": nombre, "peso": 100}
    print(f"Muestra '{nombre}' creada.")
    muestras_recolectadas.append(muestra)

    
    def destruir_muestra(muestra):
        print(f"Muestra '{muestra['nombre']}' destruida.")
    del muestra

    for muestra in muestras_recolectadas:
     destruir_muestra(muestra)

muestras_recolectadas.clear()

print("Todas las muestras fueron destruidas y la memoria liberada.")




