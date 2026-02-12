class FichaTerritorio:
    def __init__(self, nombre_jugador, posicion_inicial):
        self.nombre_jugador = nombre_jugador
        self.posicion_actual = posicion_inicial

    def moverTerritorio(self, nueva_posicion):
        self.posicion_actual = nueva_posicion
        
    print(f"La ficha de {self.nombre_jugador} se movió a la posición {self.posicion_actual}")


if __name__ == "__main__":
    ficha_juan = FichaTerritorio("Juan", 1)
    ficha_maria = FichaTerritorio("Maria", 3)

print(f"{ficha_juan.nombre_jugador} inicia en la posición {ficha_juan.posicion_actual}")
print(f"{ficha_maria.nombre_jugador} inicia en la posición {ficha_maria.posicion_actual}")

ficha_juan.moverTerritorio(5)
ficha_maria.moverTerritorio(7)
