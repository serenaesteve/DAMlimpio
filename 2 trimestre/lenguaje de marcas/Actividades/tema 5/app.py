from flask import Flask, jsonify
import mysql.connector

def conectar_bd():
    return mysql.connector.connect(
        host="localhost",
        user="serena",
        password="blog2526",
        database="blog2526"
    )

def obtener_entradas():
    conexion = conectar_bd()
    cursor = conexion.cursor(dictionary=True)
    cursor.execute(
        "SELECT id, titulo, contenido, fecha FROM entradas ORDER BY fecha DESC"
    )
    entradas = cursor.fetchall()
    cursor.close()
    conexion.close()
    return entradas

app = Flask(__name__)

@app.route("/api/entradas")
def api_entradas():
    return jsonify(obtener_entradas())

if __name__ == "__main__":
    app.run(debug=True)

