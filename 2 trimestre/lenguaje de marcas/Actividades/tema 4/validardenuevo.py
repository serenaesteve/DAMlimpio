import xmlschema

esquema = xmlschema.XMLSchema("002-plantilla.xsd")

if esquema.is_valid("004-documento no valido.xml"):
    print("✔️ XML válido")
else:
    print("❌ XML NO válido")
    # Mostrar los errores de manera legible
    for error in esquema.iter_errors("004-documento no valido.xml"):
        print("-", error)

