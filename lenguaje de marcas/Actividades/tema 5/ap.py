from flask import Flask
import mysql.connector
import json

app = Flask(__name__)


def conectar_bd():
    return mysql.connector.connect(
        host="localhost",
        user="root",          
        password="",          
        database="campo_reservas"
    )


@app.route('/areas', methods=['GET'])
def mostrar_areas():
    conexion = conectar_bd()
    cursor = conexion.cursor()

    
    cursor.execute("SHOW TABLES;")
    tablas = cursor.fetchall()

    resultado = {}

    
    for (nombre_tabla,) in tablas:
        cursor.execute(f"SELECT * FROM {nombre_tabla};")
        registros = cursor.fetchall()

        
        columnas = [col[0] for col in cursor.description]

       
        datos = []
        for fila in registros:
            datos.append(dict(zip(columnas, fila)))

        resultado[nombre_tabla] = datos

    cursor.close()
    conexion.close()

 
    return json.dumps(resultado, indent=4, ensure_ascii=False)


if __name__ == '__main__':
    app.run(debug=True)

