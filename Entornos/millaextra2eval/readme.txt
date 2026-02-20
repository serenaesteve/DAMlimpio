Nombre del proyecto: Saludo web con Flask

Lenguaje utilizado:
Python 3 + Flask

Cómo ejecutar el programa:
1) Entrar en la carpeta del proyecto
2) (Opcional recomendado) Crear y activar entorno virtual:
   python3 -m venv venv
   source venv/bin/activate
3) Instalar Flask:
   pip install flask
4) Ejecutar:
   python3 src/app.py
5) Abrir en el navegador:
   http://127.0.0.1:5000

Breve explicación:
Aplicación web sencilla con Flask. Muestra una página con un formulario para introducir el nombre.
Al enviar el formulario, la web muestra un mensaje de bienvenida.
Incluye botón "Limpiar" que vuelve a la página inicial.

Dificultades encontradas:
- Recordar la estructura de carpetas (templates/static) requerida por Flask.
- Validación del formulario para evitar nombres vacíos.
- Realizar commits separados en momentos distintos del desarrollo.
