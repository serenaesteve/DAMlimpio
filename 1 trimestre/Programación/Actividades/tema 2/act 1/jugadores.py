class jugador:
    def __init__(self, nombre, puntos):
        self.nombre = nombre
        self.puntos = puntos

    def sumar_puntos(self, puntos):
        self.puntos += puntos
    def restar_puntos(self,puntos):
        self.puntos -= puntos


jugador1 = jugador("juan", 0)
jugador2 = jugador("ana", 0)

jugador1.sumar_puntos(5)
jugador2.restar_puntos(3)
print(jugador1.nombre,jugador1.puntos)
print(jugador2.nombre,jugador2.puntos)