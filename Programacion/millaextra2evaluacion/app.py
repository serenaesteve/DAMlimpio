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

