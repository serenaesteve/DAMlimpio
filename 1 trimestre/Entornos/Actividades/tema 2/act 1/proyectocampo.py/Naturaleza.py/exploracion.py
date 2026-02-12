class Explorador:
    def __init__(self, ubicacion):
        self.ubicacion = ubicacion
        self.objetos_encontrados = []
        self.energia_restante = 100

    def moverse(self, nueva_ubicacion):
        print(f"Moviéndose de {self.ubicacion} a {nueva_ubicacion}...")
        self.ubicacion = nueva_ubicacion
        self.energia_restante -= 10

    def recolectar(self, objeto):
        print(f"Recolectando {objeto}...")
        self.objetos_encontrados.append(objeto)
        self.energia_restante -= 3

    def mostrar_progreso(self):
        print("Ubicación actual:", self.ubicacion)
        print("Objetos encontrados:", self.objetos_encontrados)
        print("Energía restante:", self.energia_restante)

if __name__ == "__main__":
    explorador = Explorador("Bosque")
    explorador.mostrar_progreso()
    explorador.moverse("Montaña")
    explorador.recolectar("planta")
    explorador.mostrar_progreso()