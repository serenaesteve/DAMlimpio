import mysql.connector
from flask import Flask

aplicacion = Flask(__name__)

def obtener_cursor():
    conexion = mysql.connector.connect(
        host="localhost",
        user="root",       
        password="", 
        database="blog2526"
    )
    return conexion, conexion.cursor()

consulta_sql = "SELECT titulo, introduccion, fecha, autor FROM entradas_blog"

def mostrar_entradas():
    conexion, cursor = obtener_cursor()
    cursor.execute(consulta_sql)
    entradas = cursor.fetchall()

    bloque_html = ""
    for entrada in entradas:
        titulo, introduccion, fecha, autor = entrada
        bloque_html += f"""
        <div>
            <h2>{titulo}</h2>
            <p>{introduccion}</p>
            <p>Fecha: {fecha} | Autor: {autor}</p>
            <hr>
        </div>
        """

    cursor.close()
    conexion.close()

    pagina = f"""
    <html>
    <head>
        <title>Mi Blog de Hobbies</title>
    </head>
    <body>
        <h1>Mis Hobbies: Naturaleza y Juegos de Mesa</h1>
        {bloque_html}
    </body>
    </html>
    """
    return pagina

@aplicacion.route("/")
def inicio():
    return mostrar_entradas()

if __name__ == "__main__":
    aplicacion.run(debug=True)

