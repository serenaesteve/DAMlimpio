Enunciado del Proyecto

Ciclo: Desarrollo de Aplicaciones Multiplataforma (DAM)
Curso: 1.º
Módulo: Proyecto Intermodular

Título del proyecto

Gestión sencilla de una biblioteca escolar

Descripción del proyecto

El proyecto consiste en desarrollar una aplicación con interfaz gráfica que permita gestionar de forma básica los libros de una biblioteca escolar. La aplicación facilitará el registro y la consulta de libros y préstamos de manera sencilla.

Objetivo del proyecto

Crear una aplicación fácil de usar que ayude a organizar los libros de una biblioteca y controlar los préstamos realizados.

Funcionalidades obligatorias

La aplicación deberá permitir:

Añadir libros (título, autor y año).

Listar los libros registrados.

Registrar y consultar préstamos.

Interfaz de usuario

La aplicación contará con una interfaz gráfica sencilla, con ventanas o pantallas para la gestión de libros y préstamos.

Persistencia de datos

La información se almacenará en una base de datos relacional, utilizando claves primarias y foráneas.

Herramientas y entorno de desarrollo

Se utilizará un lenguaje de programación a elegir y un editor de texto básico. La aplicación se ejecutará en entorno gráfico.

Integración de módulos

Programación: desarrollo de la lógica y gestión de eventos.

Bases de Datos: diseño y creación de la base de datos.

Sistemas Informáticos: organización de carpetas y copias de seguridad.

Entornos de Desarrollo: estructura del proyecto y documentación básica.

Entrega

Se entregará el proyecto completo con el código y una breve documentación explicativa.




Respuesta:


En este proyecto intermodular he desarrollado una aplicación con interfaz gráfica para la gestión sencilla de una biblioteca escolar. El objetivo del proyecto es facilitar el registro y la consulta de los libros, así como llevar un control básico de los préstamos que se realizan.

Para el desarrollo de la aplicación he utilizado Flask como framework web y SQLite como base de datos relacional. Con este proyecto he podido aplicar los conocimientos aprendidos en los distintos módulos del curso, como Programación, Bases de Datos, Sistemas Informáticos y Entornos de Desarrollo.

Durante la realización del proyecto he trabajado en el diseño de la base de datos, la programación de la lógica de la aplicación y la creación de una interfaz sencilla e intuitiva, pensada para que cualquier usuario pueda utilizarla sin dificultad.

app.py:
```
from flask import Flask, render_template, request, redirect, url_for, flash
import sqlite3
from datetime import date

app = Flask(__name__)
app.secret_key = "dam_biblioteca_secret"  # para flash messages

DB_NAME = "biblioteca.db"


def get_conn():
    conn = sqlite3.connect(DB_NAME)
    conn.row_factory = sqlite3.Row
    return conn


def init_db():
    conn = get_conn()
    cur = conn.cursor()

    cur.execute("""
    CREATE TABLE IF NOT EXISTS libros (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        autor TEXT NOT NULL,
        anio INTEGER NOT NULL
    );
    """)

    cur.execute("""
    CREATE TABLE IF NOT EXISTS prestamos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        libro_id INTEGER NOT NULL,
        prestatario TEXT NOT NULL,
        fecha_prestamo TEXT NOT NULL,
        fecha_devolucion TEXT,
        devuelto INTEGER NOT NULL DEFAULT 0,
        FOREIGN KEY (libro_id) REFERENCES libros(id)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
    );
    """)

    conn.commit()
    conn.close()


@app.route("/")
def home():
    return redirect(url_for("libros"))


# -----------------------
# LIBROS
# -----------------------
@app.route("/libros", methods=["GET", "POST"])
def libros():
    if request.method == "POST":
        titulo = request.form.get("titulo", "").strip()
        autor = request.form.get("autor", "").strip()
        anio = request.form.get("anio", "").strip()

        if not titulo or not autor or not anio:
            flash("Rellena título, autor y año.", "error")
            return redirect(url_for("libros"))

        try:
            anio_int = int(anio)
        except ValueError:
            flash("El año debe ser un número.", "error")
            return redirect(url_for("libros"))

        conn = get_conn()
        cur = conn.cursor()
        cur.execute("INSERT INTO libros (titulo, autor, anio) VALUES (?, ?, ?)",
                    (titulo, autor, anio_int))
        conn.commit()
        conn.close()

        flash("Libro añadido correctamente.", "ok")
        return redirect(url_for("libros"))

    conn = get_conn()
    libros_list = conn.execute("SELECT * FROM libros ORDER BY id DESC").fetchall()
    conn.close()
    return render_template("libros.html", libros=libros_list)


# -----------------------
# PRÉSTAMOS
# -----------------------
@app.route("/prestamos", methods=["GET", "POST"])
def prestamos():
    conn = get_conn()

    if request.method == "POST":
        libro_id = request.form.get("libro_id", "").strip()
        prestatario = request.form.get("prestatario", "").strip()
        fecha_prestamo = request.form.get("fecha_prestamo", "").strip()
        fecha_devolucion = request.form.get("fecha_devolucion", "").strip()

        if not libro_id or not prestatario or not fecha_prestamo:
            flash("Rellena libro, prestatario y fecha de préstamo.", "error")
            conn.close()
            return redirect(url_for("prestamos"))

        # fecha_devolucion puede estar vacía
        if fecha_devolucion == "":
            fecha_devolucion = None

        try:
            libro_id_int = int(libro_id)
        except ValueError:
            flash("Libro inválido.", "error")
            conn.close()
            return redirect(url_for("prestamos"))

        # Comprobar que el libro existe
        libro = conn.execute("SELECT id FROM libros WHERE id = ?", (libro_id_int,)).fetchone()
        if not libro:
            flash("Ese libro no existe.", "error")
            conn.close()
            return redirect(url_for("prestamos"))

        # (Opcional) Evitar prestar un libro que ya está prestado sin devolver
        abierto = conn.execute("""
            SELECT id FROM prestamos
            WHERE libro_id = ? AND devuelto = 0
        """, (libro_id_int,)).fetchone()
        if abierto:
            flash("Ese libro ya está prestado y no se ha devuelto.", "error")
            conn.close()
            return redirect(url_for("prestamos"))

        conn.execute("""
            INSERT INTO prestamos (libro_id, prestatario, fecha_prestamo, fecha_devolucion, devuelto)
            VALUES (?, ?, ?, ?, 0)
        """, (libro_id_int, prestatario, fecha_prestamo, fecha_devolucion))
        conn.commit()
        conn.close()

        flash("Préstamo registrado.", "ok")
        return redirect(url_for("prestamos"))

    # GET: listar
    libros_list = conn.execute("SELECT * FROM libros ORDER BY titulo ASC").fetchall()
    prestamos_list = conn.execute("""
        SELECT p.*, l.titulo, l.autor
        FROM prestamos p
        JOIN libros l ON l.id = p.libro_id
        ORDER BY p.id DESC
    """).fetchall()
    conn.close()

    return render_template("prestamos.html", libros=libros_list, prestamos=prestamos_list, hoy=str(date.today()))


@app.post("/prestamos/<int:prestamo_id>/devolver")
def devolver_prestamo(prestamo_id: int):
    conn = get_conn()
    p = conn.execute("SELECT id, devuelto FROM prestamos WHERE id = ?", (prestamo_id,)).fetchone()
    if not p:
        conn.close()
        flash("Préstamo no encontrado.", "error")
        return redirect(url_for("prestamos"))

    if p["devuelto"] == 1:
        conn.close()
        flash("Ese préstamo ya estaba devuelto.", "error")
        return redirect(url_for("prestamos"))

    conn.execute("""
        UPDATE prestamos
        SET devuelto = 1,
            fecha_devolucion = COALESCE(fecha_devolucion, ?)
        WHERE id = ?
    """, (str(date.today()), prestamo_id))
    conn.commit()
    conn.close()

    flash("Préstamo marcado como devuelto.", "ok")
    return redirect(url_for("prestamos"))


if __name__ == "__main__":
    init_db()
    app.run(debug=True)
```


templates/base.html:
```
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Biblioteca escolar</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    nav a { margin-right: 12px; }
    .box { border: 1px solid #ddd; padding: 12px; margin: 12px 0; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    .ok { background: #e7ffe7; padding: 8px; border: 1px solid #b6ffb6; }
    .error { background: #ffe7e7; padding: 8px; border: 1px solid #ffb6b6; }
    .muted { color: #666; font-size: 0.9em; }
    button { cursor: pointer; }
  </style>
</head>
<body>
  <nav>
    <a href="{{ url_for('libros') }}">Libros</a>
    <a href="{{ url_for('prestamos') }}">Préstamos</a>
  </nav>

  {% with messages = get_flashed_messages(with_categories=true) %}
    {% if messages %}
      {% for cat, msg in messages %}
        <div class="{{ cat }}">{{ msg }}</div>
      {% endfor %}
    {% endif %}
  {% endwith %}

  {% block content %}{% endblock %}
</body>
</html>
```

templates/libros.html:
```
{% extends "base.html" %}
{% block content %}
<h2>Libros</h2>

<div class="box">
  <h3>Añadir libro</h3>
  <form method="post">
    <label>Título:</label><br>
    <input name="titulo" required><br><br>

    <label>Autor:</label><br>
    <input name="autor" required><br><br>

    <label>Año:</label><br>
    <input name="anio" required><br><br>

    <button type="submit">Guardar</button>
  </form>
</div>

<div class="box">
  <h3>Listado de libros</h3>
  <table>
    <thead>
      <tr><th>ID</th><th>Título</th><th>Autor</th><th>Año</th></tr>
    </thead>
    <tbody>
    {% for l in libros %}
      <tr>
        <td>{{ l.id }}</td>
        <td>{{ l.titulo }}</td>
        <td>{{ l.autor }}</td>
        <td>{{ l.anio }}</td>
      </tr>
    {% else %}
      <tr><td colspan="4" class="muted">No hay libros todavía.</td></tr>
    {% endfor %}
    </tbody>
  </table>
</div>
{% endblock %}
```

templates/prestamos.html:
```
{% extends "base.html" %}
{% block content %}
<h2>Préstamos</h2>

<div class="box">
  <h3>Registrar préstamo</h3>
  <form method="post">
    <label>Libro:</label><br>
    <select name="libro_id" required>
      <option value="">-- Selecciona un libro --</option>
      {% for l in libros %}
        <option value="{{ l.id }}">{{ l.titulo }} ({{ l.autor }})</option>
      {% endfor %}
    </select><br><br>

    <label>Prestatario:</label><br>
    <input name="prestatario" required><br><br>

    <label>Fecha préstamo:</label><br>
    <input name="fecha_prestamo" value="{{ hoy }}" required><br><br>

    <label>Fecha devolución (opcional):</label><br>
    <input name="fecha_devolucion" placeholder="YYYY-MM-DD"><br><br>

    <button type="submit">Registrar</button>
  </form>
</div>

<div class="box">
  <h3>Consultar préstamos</h3>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Libro</th><th>Prestatario</th>
        <th>Fecha préstamo</th><th>Fecha devolución</th><th>Estado</th><th>Acción</th>
      </tr>
    </thead>
    <tbody>
    {% for p in prestamos %}
      <tr>
        <td>{{ p.id }}</td>
        <td>{{ p.titulo }} - {{ p.autor }}</td>
        <td>{{ p.prestatario }}</td>
        <td>{{ p.fecha_prestamo }}</td>
        <td>{{ p.fecha_devolucion or "-" }}</td>
        <td>{{ "Devuelto" if p.devuelto == 1 else "Prestado" }}</td>
        <td>
          {% if p.devuelto == 0 %}
          <form method="post" action="{{ url_for('devolver_prestamo', prestamo_id=p.id) }}">
            <button type="submit">Marcar devuelto</button>
          </form>
          {% else %}
            -
          {% endif %}
        </td>
      </tr>
    {% else %}
      <tr><td colspan="7" class="muted">No hay préstamos todavía.</td></tr>
    {% endfor %}
    </tbody>
  </table>
</div>
{% endblock %}
```


Readme.txt:
```
Proyecto Intermodular DAM 1º
Gestión sencilla de una biblioteca escolar

Aplicación web desarrollada con Flask que permite:
- Añadir y listar libros.
- Registrar y consultar préstamos.
- Marcar préstamos como devueltos.

Tecnologías:
- Python 3
- Flask
- SQLite

Ejecución:
1. Instalar Flask: pip install flask
2. Ejecutar la aplicación: python app.py
3. Abrir en el navegador: http://127.0.0.1:5000

Autor: (tu nombre)
Curso: 1º DAM
```

Con la realización de este proyecto he podido poner en práctica los contenidos aprendidos a lo largo del curso, desarrollando una aplicación funcional que cumple con los requisitos del enunciado. La aplicación permite gestionar libros y préstamos de forma sencilla, utilizando una base de datos relacional y una interfaz gráfica clara.

Este proyecto me ha ayudado a entender mejor cómo se desarrolla una aplicación completa, desde la creación de la base de datos hasta la interacción con el usuario. Además, me ha servido para mejorar mi organización del código y la documentación del proyecto.

Como posibles mejoras futuras, podría añadir nuevas funcionalidades como la búsqueda de libros, la edición y eliminación de registros o la gestión de usuarios, ampliando así las posibilidades de la aplicación.

