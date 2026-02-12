import sqlite3
from flask import Flask, render_template

app = Flask(__name__)

@app.route('/')
def listar_productos():
    with sqlite3.connect('./tiendaonlinenew.db') as conn:
        cursor = conn.cursor()
        cursor.execute("SELECT * FROM productos")
        productos = cursor.fetchall()
    
    lista_productos = []
    for p in productos:
        lista_productos.append({
            'id': p[0],
            'nombre': p[1],
            'descripcion': p[2],
            'imagen': p[3],
            'precio': p[4]
        })
    
    return render_template('index.html', productos=lista_productos)

if __name__ == '__main__':
    app.run(debug=True)

