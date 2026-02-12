from flask import Flask, render_template

app = Flask(__name__)

@app.route('/')
def tablero():
    
    filas = 8
    columnas = 8
    return render_template('tablero.html', filas=filas, columnas=columnas)

if __name__ == '__main__':
    app.run(debug=True)
