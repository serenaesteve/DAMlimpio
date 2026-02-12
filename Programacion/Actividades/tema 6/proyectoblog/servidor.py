from flask import Flask, render_template
import mysql.connector
import json

aplicacion = Flask(__name__)

conexion = mysql.connector.connect(
    host="localhost",
    user="serena",
    password="blog2526",
    database="blog2526"
)

cursor = conexion.cursor(dictionary=True)

@aplicacion.route("/")
def index():
    return render_template("index.html")


@aplicacion.route("/api")
def api():
    cursor.execute("SHOW TABLES;")
    tablas = cursor.fetchall()
    documento = {}

    for tabla in tablas:
        nombre_tabla = tabla["Tables_in_blog2526"]
        cursor.execute(f"SELECT * FROM {nombre_tabla};")
        registros = cursor.fetchall()
        documento[nombre_tabla] = registros

    return json.dumps(documento, indent=4, ensure_ascii=False)

aplicacion.run(debug=True)

