def mostrar_menu():
    print("\nQue quieres hacer hoy?")
    print("1) Recolectar puntos")
    print("2) Cuidar animales")
    print("3) Explorar el campo")
    print("4) Ver estado actual")
    print("5) Salir")

def mostrar_granja_ascii():
    print(r"""
                 __|__
               _/_____\_
        ______/_________\______
       /  _  \  FARM LAND  / _  \
      /__/ \__\         /__/ \__\
        \_/ \_/  _   _  \_/ \_/
          \___/  (") (")  \___/
           / \    \   /    / \
          /___\    ) (    /___\
           |||    (   )   |||
           |||     '-'    |||
    """)
    print("Has llegado a la granja. Elige un area para explorar:")

def explorar_area(state):
    mostrar_granja_ascii()
    print("a) Granero")
    print("b) Campo de trigo")
    print("c) Lago")
    print("d) Volver al menu")
    choice = input("Elige un area (a/b/c/d): ").strip().lower()
    if choice == 'a':
        print("\nEntraste al granero. Obtienes semillas.")
        print("-> +5 puntos")
        state['puntos'] += 5
    elif choice == 'b':
        print("\nCaminas por el campo de trigo.")
        print("-> Los animales ganan +5 salud")
        for a in state['animales']:
            state['animales'][a] = min(100, state['animales'][a] + 5)
    elif choice == 'c':
        print("\nLlegas al lago.")
        print("-> +3 puntos")
        state['puntos'] += 3
    elif choice == 'd':
        print("\nRegresas al menu.")
    else:
        print("\nOpcion no valida.")

def cuidar_animales(state):
    print("\nHas alimentado a los animales.")
    for a in state['animales']:
        before = state['animales'][a]
        state['animales'][a] = min(100, before + 10)
        after = state['animales'][a]
        print(f" - {a}: salud {before} -> {after}")

def recolectar_puntos(state):
    state['puntos'] += 10
    print(f"\nHas recolectado 10 puntos. Total: {state['puntos']}")

def ver_estado(state):
    print("\n--- Estado actual ---")
    print(f"Jugador: {state['jugador']}")
    print(f"Puntos: {state['puntos']}")
    print("Salud de animales:")
    for a, salud in state['animales'].items():
        print(f"  - {a}: {salud}/100")
    print("---------------------")

def main():
    print("Bienvenido a la Granja Virtual!")
    nombre = input("Introduce tu nombre de jugador: ").strip()
    if nombre == "":
        nombre = "Jugador"
    estado = {
        'jugador': nombre,
        'puntos': 0,
        'animales': {
            'vaca': 70,
            'gallina': 60,
            'cerdo': 65
        }
    }
    print(f"\nHola, {estado['jugador']}!")
    while True:
        mostrar_menu()
        opcion = input("Selecciona una opcion (1-5): ").strip()
        if opcion == '1':
            recolectar_puntos(estado)
        elif opcion == '2':
            cuidar_animales(estado)
        elif opcion == '3':
            explorar_area(estado)
        elif opcion == '4':
            ver_estado(estado)
        elif opcion == '5':
            print(f"\nGracias por jugar, {estado['jugador']}!")
            break
        else:
            print("Opcion no valida.")

if __name__ == "__main__":
    main()
