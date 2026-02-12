nombre_archivo = "mapa_bosque.txt"
tamano_archivo = 1024
tipo_archivo = "Texto"

def crear_archivo(nombre, tamano, tipo):
    archivo = {
        "nombre": nombre,
        "tamano": tamano,
        "tipo": tipo
    }
    return archivo

def leer_archivo(archivo):
    print(f"Nombre: {archivo['nombre']}")
    print(f"Tamano: {archivo['tamano']} bytes")
    print(f"Tipo: {archivo['tipo']}")

def modificar_archivo(archivo, nuevo_tamano, nuevo_tipo):
    archivo['tamano'] = nuevo_tamano
    archivo['tipo'] = nuevo_tipo

def eliminar_archivo(archivo):
    archivo = None
    return archivo

archivo1 = crear_archivo(nombre_archivo, tamano_archivo, tipo_archivo)
print("Archivo creado:")
leer_archivo(archivo1)

modificar_archivo(archivo1, 2048, "Texto y Datos")
print("\nArchivo modificado:")
leer_archivo(archivo1)

archivo1 = eliminar_archivo(archivo1)
print("\nArchivo eliminado:", archivo1)