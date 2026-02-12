
arboles = {
    "roble": {
        "nombre_comun": "Roble",
        "altura_promedio": 15,
        "hojas": True
    },
    "pinos": {
        "nombre_comun": "Pinos",
        "altura_promedio": 30,
        "hojas": False
    },
    "abeto": {
        "nombre_comun": "Abeto",
        "altura_promedio": 25,
        "hojas": True
    }
}

nombre_roble = arboles["roble"]["nombre_comun"]
altura_roble = arboles["roble"]["altura_promedio"]
hojas_roble = arboles["roble"]["hojas"]

print("Nombre comun del roble:", nombre_roble)
print("Altura promedio del roble:", altura_roble, "metros")
print("El roble tiene hojas?", "Si" if hojas_roble else "No")
