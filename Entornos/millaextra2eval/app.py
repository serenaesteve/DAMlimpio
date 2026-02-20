from flask import Flask, render_template, request

app = Flask(__name__)

@app.route("/", methods=["GET", "POST"])
def index():
    mensaje = ""
    nombre = ""

    if request.method == "POST":
        nombre = request.form.get("nombre", "").strip()
        if not nombre:
            mensaje = "Por favor, introduce tu nombre."
        else:
            mensaje = f"Hola {nombre}, bienvenido/a a la aplicación."

    return render_template("index.html", mensaje=mensaje, nombre=nombre)

if __name__ == "__main__":
   
    app.run(debug=True)
