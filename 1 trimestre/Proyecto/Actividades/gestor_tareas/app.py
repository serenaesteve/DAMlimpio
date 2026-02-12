from flask import Flask, render_template, request, redirect, url_for

app = Flask(__name__)


tareas = []

@app.route("/")
def index():
    return render_template("index.html", tareas=tareas)

@app.route("/anadir", methods=["POST"])
def anadir():
    nombre = request.form.get("nombre")
    descripcion = request.form.get("descripcion")
    if nombre:
        tareas.append({"nombre": nombre, "descripcion": descripcion, "completada": False})
    return redirect(url_for("index"))

@app.route("/completar/<int:indice>")
def completar(indice):
    if 0 <= indice < len(tareas):
        tareas[indice]["completada"] = True
    return redirect(url_for("index"))

@app.route("/eliminar/<int:indice>")
def eliminar(indice):
    if 0 <= indice < len(tareas):
        tareas.pop(indice)
    return redirect(url_for("index"))

if __name__ == "__main__":
    app.run(debug=True)

