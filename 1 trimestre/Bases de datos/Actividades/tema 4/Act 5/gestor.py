import sqlite3


def conectar():
    return sqlite3.connect("empresa.db")


def crear_cliente(conn):
    nombre = input("Nombre del cliente: ")
    email = input("Email: ")
    telefono = input("Teléfono: ")
    conn.execute("INSERT INTO clientes (nombre, email, telefono) VALUES (?, ?, ?)", (nombre, email, telefono))
    conn.commit()
    print("Cliente agregado correctamente.\n")

def listar_clientes(conn):
    cursor = conn.execute("SELECT * FROM clientes")
    print("\n--- Lista de clientes ---")
    for fila in cursor:
        print(fila)
    print()

def actualizar_cliente(conn):
    id_cliente = input("ID del cliente a actualizar: ")
    nombre = input("Nuevo nombre: ")
    email = input("Nuevo email: ")
    telefono = input("Nuevo teléfono: ")
    conn.execute("UPDATE clientes SET nombre=?, email=?, telefono=? WHERE id=?", (nombre, email, telefono, id_cliente))
    conn.commit()
    print("Cliente actualizado correctamente.\n")

def eliminar_cliente(conn):
    id_cliente = input("ID del cliente a eliminar: ")
    conn.execute("DELETE FROM clientes WHERE id=?", (id_cliente,))
    conn.commit()
    print("Cliente eliminado correctamente.\n")


def crear_producto(conn):
    nombre = input("Nombre del producto: ")
    precio = float(input("Precio: "))
    stock = int(input("Stock: "))
    conn.execute("INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)", (nombre, precio, stock))
    conn.commit()
    print("Producto agregado correctamente.\n")

def listar_productos(conn):
    cursor = conn.execute("SELECT * FROM productos")
    print("\n--- Lista de productos ---")
    for fila in cursor:
        print(fila)
    print()

def actualizar_producto(conn):
    id_producto = input("ID del producto a actualizar: ")
    nombre = input("Nuevo nombre: ")
    precio = float(input("Nuevo precio: "))
    stock = int(input("Nuevo stock: "))
    conn.execute("UPDATE productos SET nombre=?, precio=?, stock=? WHERE id=?", (nombre, precio, stock, id_producto))
    conn.commit()
    print("Producto actualizado correctamente.\n")

def eliminar_producto(conn):
    id_producto = input("ID del producto a eliminar: ")
    conn.execute("DELETE FROM productos WHERE id=?", (id_producto,))
    conn.commit()
    print("Producto eliminado correctamente.\n")


def crear_pedido(conn):
    id_cliente = input("ID del cliente: ")
    id_producto = input("ID del producto: ")
    cantidad = int(input("Cantidad: "))
    conn.execute("INSERT INTO pedidos (id_cliente, id_producto, cantidad) VALUES (?, ?, ?)", (id_cliente, id_producto, cantidad))
    conn.commit()
    print("Pedido creado correctamente.\n")

def listar_pedidos(conn):
    cursor = conn.execute("SELECT * FROM pedidos")
    print("\n--- Lista de pedidos ---")
    for fila in cursor:
        print(fila)
    print()

def eliminar_pedido(conn):
    id_pedido = input("ID del pedido a eliminar: ")
    conn.execute("DELETE FROM pedidos WHERE id=?", (id_pedido,))
    conn.commit()
    print("Pedido eliminado correctamente.\n")


def menu_entidad(entidad, conn):
    while True:
        if entidad == "clientes":
            print("\nOperaciones con CLIENTES:")
            print("1. Crear")
            print("2. Listar")
            print("3. Actualizar")
            print("4. Eliminar")
            print("5. Volver")
            op = input("Opción: ")
            if op == "1": crear_cliente(conn)
            elif op == "2": listar_clientes(conn)
            elif op == "3": actualizar_cliente(conn)
            elif op == "4": eliminar_cliente(conn)
            elif op == "5": break
        elif entidad == "productos":
            print("\nOperaciones con PRODUCTOS:")
            print("1. Crear")
            print("2. Listar")
            print("3. Actualizar")
            print("4. Eliminar")
            print("5. Volver")
            op = input("Opción: ")
            if op == "1": crear_producto(conn)
            elif op == "2": listar_productos(conn)
            elif op == "3": actualizar_producto(conn)
            elif op == "4": eliminar_producto(conn)
            elif op == "5": break
        elif entidad == "pedidos":
            print("\nOperaciones con PEDIDOS:")
            print("1. Crear")
            print("2. Listar")
            print("3. Eliminar")
            print("4. Volver")
            op = input("Opción: ")
            if op == "1": crear_pedido(conn)
            elif op == "2": listar_pedidos(conn)
            elif op == "3": eliminar_pedido(conn)
            elif op == "4": break


def menu_principal():
    conn = conectar()
    while True:
        print("\n=== TIENDA CAMPO Y HOGAR ===")
        print("1. Clientes")
        print("2. Productos")
        print("3. Pedidos")
        print("4. Salir")
        opcion = input("Elige una entidad: ")
        if opcion == "1": menu_entidad("clientes", conn)
        elif opcion == "2": menu_entidad("productos", conn)
        elif opcion == "3": menu_entidad("pedidos", conn)
        elif opcion == "4": break
        else: print("Opción no válida")
    conn.close()


if __name__ == "__main__":
    menu_principal()