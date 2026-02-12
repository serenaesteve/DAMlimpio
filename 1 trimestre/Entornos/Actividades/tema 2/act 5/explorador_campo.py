arboles = ["rojo", "verde", "marrón","rojo" ]

estados = {
    False: "Árbol verde saludable",
    True:  "Árbol rojo sano"
}

for arbol in arboles:
    print(f"Árbol: {arbol}")
    
    estado = estados['rojo' in arbol.lower()]
    print(estado)
   