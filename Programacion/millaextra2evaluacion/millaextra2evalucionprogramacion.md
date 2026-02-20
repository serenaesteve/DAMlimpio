Enunciado de la actividad (Python)

Módulo: Programación
Curso: 1º DAM
Evaluación: 2ª evaluación

Contexto

Vas a crear un programa en Python para gestionar sesiones fotográficas de una fotógrafa. El objetivo es practicar funciones, listas/diccionarios, control de errores y ficheros (contenidos típicos de la segunda evaluación).

Requisitos

1. El programa deberá permitir gestionar sesiones con estos datos mínimos:
-id (único)
-cliente
-fecha (texto en formato YYYY-MM-DD)
-tipo (familia, pareja, naturaleza, etc.)
-precio (número)

2. El programa tendrá un menú  con estas opciones:
-Añadir sesión
-Listar sesiones
-Buscar sesión por ID
-Calcular ingresos totales
-Guardar sesiones en un fichero (sesiones.json o sesiones.txt)
-Cargar sesiones desde el fichero
-Salir

3. Las sesiones se almacenarán en una lista de diccionarios.

Validaciones mínimas:
-No permitir IDs repetidos.
-Controlar que el precio sea un número válido y no negativo.
-Si se busca un ID que no existe, mostrar un mensaje adecuado.

Entrega
-Archivo .py con el programa.
-Fichero de ejemplo generado (sesiones.json o similar).
-Capturas o breve explicación de pruebas (opcional, si el profesor lo pide).






Respuesta:

En esta actividad he desarrollado una aplicación en Python para gestionar sesiones fotográficas, aplicando los contenidos de la segunda evaluación del módulo de Programación. Para mejorar la interacción con el usuario, se ha utilizado Flask, creando una interfaz web sencilla e intuitiva.

app.py:
```
from flask import Flask, render_template, request, redirect, url_for, flash
import json
import os
from datetime import datetime

app = Flask(__name__)
app.secret_key = "milla_extra_flask_sesiones"


BASE_DIR = os.path.dirname(os.path.abspath(__file__))
FICHERO = os.path.join(BASE_DIR, "sesiones.json")


sesiones = []



def id_existe(id_sesion: str) -> bool:
    return any(s["id"] == id_sesion for s in sesiones)


def validar_fecha(fecha: str) -> bool:
    try:
        datetime.strptime(fecha, "%Y-%m-%d")
        return True
    except ValueError:
        return False


def validar_precio(texto: str):
    try:
        precio = float(texto.replace(",", "."))
        if precio < 0:
            return None
        return precio
    except ValueError:
        return None


def calcular_ingresos():
    return sum(s["precio"] for s in sesiones)


def guardar_sesiones():
    with open(FICHERO, "w", encoding="utf-8") as f:
        json.dump(sesiones, f, ensure_ascii=False, indent=2)


def cargar_sesiones():
    global sesiones
    if not os.path.exists(FICHERO):
        sesiones = []
        return

    with open(FICHERO, "r", encoding="utf-8") as f:
        data = json.load(f)

    sesiones = []
    for s in data:
        if all(k in s for k in ("id", "cliente", "fecha", "tipo", "precio")):
            try:
                s["precio"] = float(s["precio"])
            except:
                s["precio"] = 0.0
            sesiones.append(s)



@app.route("/")
def index():
    q = request.args.get("q", "").strip()
    lista = sorted(sesiones, key=lambda s: s["fecha"])

    if q:
        filtradas = [s for s in lista if s["id"] == q]
        if not filtradas:
            flash(f"No existe ninguna sesión con ID '{q}'.", "warning")
        return render_template("index.html", sesiones=filtradas, total=calcular_ingresos(), q=q)

    return render_template("index.html", sesiones=lista, total=calcular_ingresos(), q="")


@app.route("/add", methods=["POST"])
def add():
    id_sesion = request.form.get("id", "").strip()
    cliente = request.form.get("cliente", "").strip()
    fecha = request.form.get("fecha", "").strip()
    tipo = request.form.get("tipo", "").strip()
    precio_txt = request.form.get("precio", "").strip()

    if not all([id_sesion, cliente, fecha, tipo, precio_txt]):
        flash("Todos los campos son obligatorios.", "danger")
        return redirect(url_for("index"))

    if id_existe(id_sesion):
        flash("El ID ya existe.", "danger")
        return redirect(url_for("index"))

    if not validar_fecha(fecha):
        flash("Fecha inválida. Formato correcto: YYYY-MM-DD.", "danger")
        return redirect(url_for("index"))

    precio = validar_precio(precio_txt)
    if precio is None:
        flash("Precio inválido.", "danger")
        return redirect(url_for("index"))

    sesiones.append({
        "id": id_sesion,
        "cliente": cliente,
        "fecha": fecha,
        "tipo": tipo,
        "precio": precio
    })

    flash("Sesión añadida correctamente.", "success")
    return redirect(url_for("index"))


@app.route("/save", methods=["POST"])
def save():
    guardar_sesiones()
    flash("Sesiones guardadas en sesiones.json", "success")
    return redirect(url_for("index"))


@app.route("/load", methods=["POST"])
def load():
    cargar_sesiones()
    flash("Sesiones cargadas desde sesiones.json", "success")
    return redirect(url_for("index"))


@app.route("/delete/<id_sesion>", methods=["POST"])
def delete(id_sesion):
    global sesiones
    sesiones = [s for s in sesiones if s["id"] != id_sesion]
    flash("Sesión eliminada.", "success")
    return redirect(url_for("index"))


if __name__ == "__main__":
    try:
        cargar_sesiones()
    except:
        pass

    app.run(debug=True)
```


templates/base.html:
```
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestor de Sesiones</title>
  <style>
    body { font-family: system-ui, Arial; margin: 24px; }
    .row { display: flex; gap: 16px; flex-wrap: wrap; }
    .card { border: 1px solid #ddd; padding: 16px; border-radius: 12px; max-width: 980px; }
    input { padding: 8px; width: 220px; }
    button { padding: 8px 12px; cursor: pointer; }
    table { border-collapse: collapse; width: 100%; margin-top: 12px; }
    th, td { border-bottom: 1px solid #eee; padding: 10px; text-align: left; }
    .flash { padding: 10px 12px; border-radius: 10px; margin-bottom: 12px; }
    .success { background: #e7f7ea; }
    .danger  { background: #fde8e8; }
    .warning { background: #fff7e6; }
    .muted { color: #666; }
    .actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .small { width: 160px; }
  </style>
</head>
<body>

  {% with messages = get_flashed_messages(with_categories=true) %}
    {% if messages %}
      {% for category, msg in messages %}
        <div class="flash {{ category }}">{{ msg }}</div>
      {% endfor %}
    {% endif %}
  {% endwith %}

  {% block content %}{% endblock %}
</body>
</html>
```

templates/index.html:
```
{% extends "base.html" %}
{% block content %}

<h1>Gestor de sesiones fotográficas</h1>
<p class="muted">Datos: id (único), cliente, fecha (YYYY-MM-DD), tipo, precio.</p>

<div class="row">
  <div class="card">
    <h2>Añadir sesión</h2>
    <form method="POST" action="{{ url_for('add') }}">
      <div class="row">
        <input name="id" placeholder="ID (único)" required>
        <input name="cliente" placeholder="Cliente" required>
        <input name="fecha" placeholder="Fecha (YYYY-MM-DD)" required>
        <input name="tipo" placeholder="Tipo (familia, pareja...)" required>
        <input name="precio" placeholder="Precio" required>
      </div>
      <div style="margin-top:12px" class="actions">
        <button type="submit">Añadir</button>
        <form method="POST" action="{{ url_for('save') }}"></form>
      </div>
    </form>

    <div style="margin-top:12px" class="actions">
      <form method="POST" action="{{ url_for('save') }}">
        <button type="submit">Guardar en JSON</button>
      </form>
      <form method="POST" action="{{ url_for('load') }}">
        <button type="submit">Cargar desde JSON</button>
      </form>
    </div>
  </div>

  <div class="card">
    <h2>Buscar por ID</h2>
    <form method="GET" action="{{ url_for('index') }}" class="actions">
      <input class="small" name="q" placeholder="ID a buscar" value="{{ q }}">
      <button type="submit">Buscar</button>
      <a href="{{ url_for('index') }}">Ver todas</a>
    </form>

    <h2 style="margin-top:18px">Ingresos totales</h2>
    <p><strong>{{ "%.2f"|format(total) }} €</strong></p>
  </div>
</div>

<div class="card" style="margin-top:16px; max-width: 980px;">
  <h2>Listado de sesiones ({{ sesiones|length }})</h2>

  {% if sesiones %}
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Fecha</th>
          <th>Tipo</th>
          <th>Precio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        {% for s in sesiones %}
          <tr>
            <td>{{ s.id }}</td>
            <td>{{ s.cliente }}</td>
            <td>{{ s.fecha }}</td>
            <td>{{ s.tipo }}</td>
            <td>{{ "%.2f"|format(s.precio) }} €</td>
            <td>
              <form method="POST" action="{{ url_for('delete', id_sesion=s.id) }}" style="display:inline;">
                <button type="submit" onclick="return confirm('¿Eliminar la sesión {{ s.id }}?')">Eliminar</button>
              </form>
            </td>
          </tr>
        {% endfor %}
      </tbody>
    </table>
  {% else %}
    <p class="muted">No hay sesiones para mostrar.</p>
  {% endif %}
</div>

{% endblock %}
```

Despues de añadir una sesion:

sesion.json:
```
[
  {
    "id": "S001",
    "cliente": "Serena Sania",
    "fecha": "2026-02-19",
    "tipo": "pareja",
    "precio": 120.0
  }
]
```

En esta actividad he desarrollado una aplicación en Python para la gestión de sesiones fotográficas, utilizando el framework Flask para crear una interfaz web accesible desde el navegador.

La aplicación permite gestionar sesiones fotográficas almacenadas en una lista de diccionarios, donde cada sesión contiene los siguientes datos: un identificador único (id), el nombre del cliente, la fecha de la sesión en formato YYYY-MM-DD, el tipo de sesión (familia, pareja, naturaleza, etc.) y el precio.

Para interactuar con el programa, se ha creado una interfaz web que ofrece varias funcionalidades. En primer lugar, se pueden añadir nuevas sesiones mediante un formulario. El programa valida que todos los campos estén rellenos, que el identificador no se repita, que la fecha tenga un formato correcto y que el precio sea un número válido y no negativo.

También se pueden listar todas las sesiones, mostrándolas ordenadas por fecha, y buscar una sesión concreta por su ID. En caso de que el ID introducido no exista, la aplicación muestra un mensaje informativo al usuario.

La aplicación incluye una opción para calcular automáticamente los ingresos totales, sumando los precios de todas las sesiones registradas.

Además, se ha implementado la persistencia de datos mediante un fichero sesiones.json. El usuario puede guardar las sesiones en el fichero y cargarlas posteriormente, de forma que la información no se pierde al cerrar la aplicación.

Para mejorar la experiencia de usuario, se utilizan mensajes informativos mediante flash() de Flask, que indican si una operación se ha realizado correctamente o si ha ocurrido algún error.

En resumen, este programa permite gestionar sesiones fotográficas de forma sencilla y cumple los requisitos de la actividad, aplicando conceptos como funciones, listas de diccionarios, validación de datos, manejo de ficheros y creación de una interfaz web con Flask.
