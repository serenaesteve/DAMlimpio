from flask import Flask, render_template
import sqlite3

app = Flask(__name__)

ruta_db = r"C:\Users\Serena\Documents\Proyecto\Actividades\tema 6\tiendaonline\tiendaonline.db"

def obtener_productos():
    conn = sqlite3.connect(ruta_db)
    cursor = conn.cursor()
    cursor.execute('SELECT * FROM productos')
    productos = cursor.fetchall()
    conn.close()
    return productos

@app.route('/')
def index():
    productos = obtener_productos()
    return render_template('index.html', productos=productos)

@app.route('/productos')
def productos():
    productos = obtener_productos()
    return render_template('productos.html', productos=productos)

@app.route('/contacto')
def contacto():
    return render_template('contacto.html')

if __name__ == '__main__':
    app.run(debug=True)

