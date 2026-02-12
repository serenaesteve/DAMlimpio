"""
Programa CRUD web para la gestión del portafolio de piezas.

Autor: Serena Sania Esteve
Versión: 2.0 adaptada a Flask
"""

from flask import Flask, render_template, request, redirect, url_for
import mysql.connector

app = Flask(__name__)

def conectar_bd():
    """
    Crea y devuelve una conexión a la base de datos 'portafolioexamen'.
    """
    conexion = mysql.connector.connect(
        host="localhost",
        user="serena",
        password="Examen123",
        database="portafolioexamen"
    )
    return conexion

# --------------------
# Rutas principales
# --------------------

@app.route('/')
def index():
    """
    Muestra el portafolio y las piezas desde la base de datos, incluyendo el currículum.
    """
    db = conectar_bd()
    cursor = db.cursor(dictionary=True)
    
    # Obtener los proyectos de la base de datos
    cursor.execute("""
        SELECT piezasportafolio.Identificador, piezasportafolio.titulo, 
               piezasportafolio.descripcion, piezasportafolio.fecha, 
               categoriasportafolio.nombre AS categoria, piezasportafolio.imagen 
        FROM piezasportafolio 
        INNER JOIN categoriasportafolio 
        ON piezasportafolio.id_categoria = categoriasportafolio.identificador
        ORDER BY piezasportafolio.fecha DESC
    """)
    piezas = cursor.fetchall()
    cursor.close()
    db.close()

    # Añadir manualmente el proyecto del currículum
    piezas.insert(0, {
        'Identificador': 0,  # ID ficticio, no existe en la DB
        'titulo': 'Mi Currículum',
        'descripcion': 'Mi primer proyecto profesional, hecho con HTML, CSS y un diseño limpio.',
        'fecha': '2025-01-01',  # Fecha arbitraria
        'categoria': 'Currículum',
        'imagen': 'images/serena.jpg'  # Ruta dentro de static/
    })

    return render_template('index.html', piezas=piezas)

@app.route('/create', methods=['GET', 'POST'])
def create():
    """
    Formulario para crear una nueva pieza en el portafolio.
    """
    if request.method == 'POST':
        titulo = request.form['titulo']
        descripcion = request.form['descripcion']
        fecha = request.form['fecha']
        imagen = request.form['imagen']
        id_categoria = request.form['id_categoria']

        db = conectar_bd()
        cursor = db.cursor()
        cursor.execute("""
            INSERT INTO piezasportafolio (titulo, descripcion, fecha, id_categoria, imagen)
            VALUES (%s, %s, %s, %s, %s)
        """, (titulo, descripcion, fecha, id_categoria, imagen))
        db.commit()
        cursor.close()
        db.close()
        return redirect('/')

    # Obtener categorías para el formulario
    db = conectar_bd()
    cursor = db.cursor(dictionary=True)
    cursor.execute("SELECT * FROM categoriasportafolio")
    categorias = cursor.fetchall()
    cursor.close()
    db.close()

    return render_template('create.html', categorias=categorias)

@app.route('/update/<int:id>', methods=['GET', 'POST'])
def update(id):
    """
    Actualiza una pieza existente.
    """
    db = conectar_bd()
    cursor = db.cursor(dictionary=True)

    if request.method == 'POST':
        titulo = request.form['titulo']
        descripcion = request.form['descripcion']
        fecha = request.form['fecha']
        imagen = request.form['imagen']
        id_categoria = request.form['id_categoria']

        cursor.execute("""
            UPDATE piezasportafolio
            SET titulo=%s, descripcion=%s, fecha=%s, id_categoria=%s, imagen=%s
            WHERE Identificador=%s
        """, (titulo, descripcion, fecha, id_categoria, imagen, id))
        db.commit()
        cursor.close()
        db.close()
        return redirect('/')

    # GET: Mostrar datos de la pieza
    cursor.execute("SELECT * FROM piezasportafolio WHERE Identificador=%s", (id,))
    pieza = cursor.fetchone()
    cursor.execute("SELECT * FROM categoriasportafolio")
    categorias = cursor.fetchall()
    cursor.close()
    db.close()
    return render_template('update.html', pieza=pieza, categorias=categorias)

@app.route('/delete/<int:id>')
def delete(id):
    """
    Elimina una pieza según su ID.
    """
    db = conectar_bd()
    cursor = db.cursor()
    cursor.execute("DELETE FROM piezasportafolio WHERE Identificador=%s", (id,))
    db.commit()
    cursor.close()
    db.close()
    return redirect('/')

@app.route('/curriculum')
def curriculum():
    """
    Muestra la página del currículum.
    """
    return render_template('micurriculum.html')

# --------------------
# Ejecutar app
# --------------------
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)

