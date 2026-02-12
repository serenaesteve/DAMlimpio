class Partida:
    def __init__(self, jugadores):
        self.jugadores = jugadores       
        self.estado = "No iniciada"      
        self.puntos_total = 0            

    def iniciar(self):
        self.estado = "En curso"         

    def finalizar(self):
        self.estado = "Finalizada"      

    def mostrar_estado(self):
        print("Jugadores:", self.jugadores)
        print("Estado:", self.estado)
        print("Puntos totales:", self.puntos_total)

if __name__ == "__main__":
    partida = Partida(["serena", "obdulia"])
    partida.mostrar_estado()
    partida.iniciar()
    partida.puntos_total = 100
    partida.mostrar_estado()
    partida.finalizar()
    partida.mostrar_estado()