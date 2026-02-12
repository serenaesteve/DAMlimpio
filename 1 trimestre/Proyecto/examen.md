En este proyecto he creado un portafolio web completo utilizando Flask, Python y MySQL, donde puedo mostrar mis proyectos, habilidades y currículum de manera interactiva. El objetivo principal ha sido desarrollar una aplicación funcional que integre la parte de backend con la base de datos y el frontend con HTML y CSS, aplicando los conocimientos adquiridos durante el primer trimestre. Este ejercicio me ha permitido aprender a manejar rutas, formularios y bases de datos en un entorno real de desarrollo.



1. Creo mi archivo app.py dentro de la carpeta portafolio_flask:
```
"""
Programa CRUD web para la gestión del portafolio de piezas.

Autor: Serena Sania Esteve
Versión: 2.0 adaptada a Flask
"""

from flask import Flask, render_template, request, redirect, url_for
import mysql.connector

app = Flask(__name__)

def conectar_bd():
    """
    Crea y devuelve una conexión a la base de datos 'portafolioexamen'.
    """
    conexion = mysql.connector.connect(
        host="localhost",
        user="serena",
        password="Examen123",
        database="portafolioexamen"
    )
    return conexion

# --------------------
# Rutas principales
# --------------------

@app.route('/')
def index():
    """
    Muestra el portafolio y las piezas desde la base de datos, incluyendo el currículum.
    """
    db = conectar_bd()
    cursor = db.cursor(dictionary=True)
    
    # Obtener los proyectos de la base de datos
    cursor.execute("""
        SELECT piezasportafolio.Identificador, piezasportafolio.titulo, 
               piezasportafolio.descripcion, piezasportafolio.fecha, 
               categoriasportafolio.nombre AS categoria, piezasportafolio.imagen 
        FROM piezasportafolio 
        INNER JOIN categoriasportafolio 
        ON piezasportafolio.id_categoria = categoriasportafolio.identificador
        ORDER BY piezasportafolio.fecha DESC
    """)
    piezas = cursor.fetchall()
    cursor.close()
    db.close()

    # Añadir manualmente el proyecto del currículum
    piezas.insert(0, {
        'Identificador': 0,  # ID ficticio, no existe en la DB
        'titulo': 'Mi Currículum',
        'descripcion': 'Mi primer proyecto profesional, hecho con HTML, CSS y un diseño limpio.',
        'fecha': '2025-01-01',  # Fecha arbitraria
        'categoria': 'Currículum',
        'imagen': 'images/serena.jpg'  # Ruta dentro de static/
    })

    return render_template('index.html', piezas=piezas)

@app.route('/create', methods=['GET', 'POST'])
def create():
    """
    Formulario para crear una nueva pieza en el portafolio.
    """
    if request.method == 'POST':
        titulo = request.form['titulo']
        descripcion = request.form['descripcion']
        fecha = request.form['fecha']
        imagen = request.form['imagen']
        id_categoria = request.form['id_categoria']

        db = conectar_bd()
        cursor = db.cursor()
        cursor.execute("""
            INSERT INTO piezasportafolio (titulo, descripcion, fecha, id_categoria, imagen)
            VALUES (%s, %s, %s, %s, %s)
        """, (titulo, descripcion, fecha, id_categoria, imagen))
        db.commit()
        cursor.close()
        db.close()
        return redirect('/')

    # Obtener categorías para el formulario
    db = conectar_bd()
    cursor = db.cursor(dictionary=True)
    cursor.execute("SELECT * FROM categoriasportafolio")

    categorias = cursor.fetchall()
    cursor.close()
    db.close()

    return render_template('create.html', categorias=categorias)

@app.route('/update/<int:id>', methods=['GET', 'POST'])
def update(id):
    """
    Actualiza una pieza existente.
    """
    db = conectar_bd()
    cursor = db.cursor(dictionary=True)

    if request.method == 'POST':
        titulo = request.form['titulo']
        descripcion = request.form['descripcion']
        fecha = request.form['fecha']
        imagen = request.form['imagen']
        id_categoria = request.form['id_categoria']

        cursor.execute("""
            UPDATE piezasportafolio
            SET titulo=%s, descripcion=%s, fecha=%s, id_categoria=%s, imagen=%s
            WHERE Identificador=%s
        """, (titulo, descripcion, fecha, id_categoria, imagen, id))
        db.commit()
        cursor.close()
        db.close()
        return redirect('/')

    # GET: Mostrar datos de la pieza
    cursor.execute("SELECT * FROM piezasportafolio WHERE Identificador=%s", (id,))
    pieza = cursor.fetchone()
    cursor.execute("SELECT * FROM categoriasportafolio")
    categorias = cursor.fetchall()
    cursor.close()
    db.close()
    return render_template('update.html', pieza=pieza, categorias=categorias)

@app.route('/delete/<int:id>')
def delete(id):
    """
    Elimina una pieza según su ID.
    """
    db = conectar_bd()
    cursor = db.cursor()
    cursor.execute("DELETE FROM piezasportafolio WHERE Identificador=%s", (id,))
    db.commit()
    cursor.close()
    db.close()
    return redirect('/')

@app.route('/curriculum')
def curriculum():
    """
    Muestra la página del currículum.
    """
    return render_template('micurriculum.html')

# --------------------
# Ejecutar app
# --------------------
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
```

2. Ahora creo la carpeta templates.


3. Archivo index.html dentro de templates:
```
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Serena Sania Esteve — Portafolio</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url_for('static', filename='style.css') }}">
</head>
<body>

<header>
    <nav class="navbar">
        <h1 class="logo">Serena Sania Esteve</h1>

        <ul class="nav-links">
            <li><a href="#inicio">Inicio</a></li>
            <li><a href="#sobre-mi">Sobre mí</a></li>
            <li><a href="#proyectos">Proyectos</a></li>
            <li><a href="#habilidades">Habilidades</a></li>
            <li><a href="#contacto">Contacto</a></li>
        </ul>

        <button class="menu-toggle" aria-label="Abrir menú">☰</button>
    </nav>
</header>

<section id="inicio" class="inicio">
    <div class="contenido-inicio">
        <p class="saludo">Hola, soy</p>
        <h2 class="nombre">Serena Sania Esteve</h2>
        <p class="titulo">Técnico Superior en Desarrollo Multiplataforma</p>
        <p class="descripcion">Diseño y desarrollo aplicaciones y sitios web modernos, con atención al detalle y experiencia de usuario.</p>
        <a href="#proyectos" class="boton">Ver mis proyectos</a>
    </div>
</section>

<section id="sobre-mi">
    <div class="contenedor-sobre-mi">
        <img src="{{ url_for('static', filename='images/serena.jpg') }}" alt="Foto de Serena Sania Esteve" class="foto-perfil">
        <div class="texto-sobre-mi">
            <h2>Sobre mí</h2>
            <h3>Serena Sania Esteve</h3>
            <h4>Técnico Superior en Desarrollo Multiplataforma</h4>
            <p>
                Soy una desarrolladora apasionada por la tecnología, el diseño y la creación de soluciones prácticas.
                Me encanta aprender nuevas herramientas, optimizar procesos y cuidar cada detalle del desarrollo.
            </p>
            <p>
                Mi objetivo es seguir creciendo profesionalmente, participar en proyectos innovadores y combinar creatividad con lógica en cada aplicación que desarrollo.
            </p>
        </div>
    </div>
</section>

<section id="proyectos">
    <h2 class="titulo-seccion">Mis Proyectos</h2>
    <div class="contenedor-proyectos">
        {% for pieza in piezas %}
        <div class="proyecto">
            {% if pieza.imagen %}
            <img src="{{ url_for('static', filename=pieza.imagen) }}" alt="{{ pieza.titulo }}">
            {% else %}
            <img src="https://via.placeholder.com/300x200" alt="{{ pieza.titulo }}">
            {% endif %}
            <h3>{{ pieza.titulo }}</h3>
            <p>{{ pieza.descripcion }}</p>

            {% if pieza.Identificador == 0 %}
            <!-- Proyecto especial: currículum -->
            <a href="{{ url_for('curriculum') }}" class="boton">Ver Currículum</a>
            {% else %}
            <div class="botones-proyecto">
                <a href="{{ url_for('update', id=pieza.Identificador) }}" class="boton">Editar</a>
                <a href="{{ url_for('delete', id=pieza.Identificador) }}" class="boton boton-eliminar">Eliminar</a>
            </div>
            {% endif %}
        </div>
        {% endfor %}
    </div>
</section>

<section id="habilidades">
    <h2 class="titulo-seccion">Mis Habilidades</h2>
    <div class="contenedor-habilidades">
        <div class="habilidad">
            <h3>HTML & CSS</h3>
            <div class="barra">
                <div class="progreso" style="width: 90%;"></div>
            </div>
        </div>
        <div class="habilidad">
            <h3>JavaScript</h3>
            <div class="barra">
                <div class="progreso" style="width: 80%;"></div>
            </div>
        </div>
        <div class="habilidad">
            <h3>Python</h3>
            <div class="barra">
                <div class="progreso" style="width: 70%;"></div>
            </div>
        </div>
        <div class="habilidad">
            <h3>SQL</h3>
            <div class="barra">
                <div class="progreso" style="width: 75%;"></div>
            </div>
        </div>
    </div>
</section>

<section id="contacto">
    <h2 class="titulo-seccion">Contacto</h2>
    <div class="contenedor-contacto">
        <div class="info-contacto">
            <p><strong>Email:</strong> serenaestevee@gmail.com</p>
            <p><strong>Teléfono:</strong> 637383762</p>
            <p><strong>Ubicación:</strong> Mislata, Valencia</p>
        </div>
        <form class="form-contacto">
            <input type="text" name="nombre" placeholder="Tu nombre" required>
            <input type="email" name="email" placeholder="Tu email" required>
            <textarea name="mensaje" rows="5" placeholder="Tu mensaje" required></textarea>
            <button type="submit" class="boton">Enviar</button>
        </form>
    </div>
</section>

</body>
</html>
```

4. Archivo create.html dentro de templates:
```
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Piezas — Portafolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url_for('static', filename='style.css') }}">
</head>
<body>

<header>
    <nav class="navbar">
        <h1 class="logo">Serena Sania Esteve</h1>
        <ul class="nav-links">
            <li><a href="{{ url_for('index') }}">Inicio</a></li>
            <li><a href="{{ url_for('create') }}">Crear Piezas</a></li>
        </ul>
        <button class="menu-toggle" aria-label="Abrir menú">☰</button>
    </nav>
</header>

<section id="create" style="padding: 120px 20px; text-align: center;">
    <h2 class="titulo-seccion">Crear Nueva Pieza</h2>
    <form method="POST" style="max-width:500px; margin: 30px auto; display:flex; flex-direction:column; gap:15px;">
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="descripcion" placeholder="Descripción" rows="4" required></textarea>
        <input type="date" name="fecha" required>
        <input type="text" name="imagen" placeholder="Ruta de imagen (ej: images/proyecto.jpg)">
        <select name="id_categoria" required>
            <option value="">Selecciona categoría</option>
            {% for cat in categorias %}
            <option value="{{ cat.identificador }}">{{ cat.nombre }}</option>
            {% endfor %}
        </select>
        <button type="submit" class="boton">Crear Pieza</button>
    </form>
</section>

<script src="{{ url_for('static', filename='script.js') }}"></script>
</body>
</html>
```

5. Archivo micurriculum.html dentro de templates:
```
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Currículum de Serena Sania Esteve</title>

  <style>
    body {
      font-family: Verdana, Geneva, sans-serif;
      background: linear-gradient(to bottom, #e9e4f0, #d3cce3);
      margin: 0;
      padding: 40px 0;
      display: flex;
      justify-content: center;
    }

    main {
      width: 800px;
      background-color: white;
      padding: 40px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
      border-radius: 10px;
    }

    header {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      border-bottom: 3px solid #b7a2d6;
      padding-bottom: 20px;
      margin-bottom: 20px;
      gap: 20px;
    }

    header img {
      width: 180px;
      aspect-ratio: 1/1;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      border: none;
    }

    header div {
      flex: 1;
      min-width: 200px;
    }

    h1 {
      font-size: 2em;
      color: #4b3b73;
      margin: 0;
    }

    header p {
      font-style: italic;
      color: #333;
      margin-top: 10px;
    }

    h2 {
      color: white;
      background-color: #a48bd3;
      padding: 6px 10px;
      border-radius: 5px;
      margin-top: 30px;
      font-size: 1.2em;
    }

    h3 {
      margin-top: 15px;
      color: #333;
    }

    ul {
      list-style-type: square;
      padding-left: 25px;
    }

    li {
      margin: 3px 0;
    }

    hr {
      border: none;
      height: 2px;
      background-color: #b7a2d6;
      margin: 30px 0;
    }

    footer {
      text-align: center;
      margin-top: 40px;
      color: #555;
      font-size: 0.9em;
      border-top: 2px solid #b7a2d6;
      padding-top: 10px;
    }

    @media (max-width: 768px) {
      header {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      header div {
        min-width: 0;
      }
    }
  </style>
</head>
<body>
  <main>
    <header>
      <img src="{{ url_for('static', filename='images/serena.jpg') }}" alt="Foto de Serena Sania Esteve">
      <div>
        <h1>Serena Sania Esteve</h1>
        <p>Gran facilidad de comunicación. Capacidad de organización alta. Responsabilidad elevada. Con espíritu emprendedor. Aptitudes para el trabajo en equipo. Resolutiva. Dispongo de vehículo propio.</p>
      </div>
    </header>

    <section>
      <h2>Datos personales</h2>
      <ul>
        <li>📧 Email: serenaestevee@gmail.com</li>
        <li>📞 Teléfono: 637383762</li>
        <li>📍 Ubicación: Mislata, Valencia</li>
      </ul>
    </section>

    <hr>

    <section>
      <h2>Formación académica</h2>
      <ul>
        <li>Grado Superior en Desarrollo de Aplicaciones Multiplataforma (DAM) – TAME FORMACIÓN (Cursando actualmente)</li>
        <li>Grado Medio Técnico Auxiliar Administrativo – Colegio Santa Cruz de Mislata (2019 - 2021)</li>
        <li>ESO – Colegio Santa Cruz de Mislata (2015 - 2019)</li>
      </ul>
    </section>

    <hr>

    <section>
      <h2>Experiencia profesional</h2>
      <h3>Administrativa – MISLATA FORMACIÓN SL (2022 - Actual)</h3>
      <ul>
        <li>Atención telefónica y física a clientes</li>
        <li>Documentación</li>
        <li>Redactar y enviar correos</li>
        <li>Marketing de las redes sociales</li>
        <li>Plan de igualdad</li>
        <li>Informes</li>
      </ul>

      <h3>Administrativa – NEMASA (3 meses - Plan social del Ayuntamiento)</h3>
      <ul>
        <li>Fichajes</li>
        <li>Documentación</li>
        <li>Informes</li>
      </ul>

      <h3>Administrativa (prácticas) – FOREDU (3 meses - Prácticas)</h3>
      <ul>
        <li>Documentación</li>
        <li>Redactar y enviar correos</li>
        <li>Búsqueda de información</li>
      </ul>
    </section>

    <hr>

    <section>
      <h2>Idiomas</h2>
      <ul>
        <li>Español: Nativo</li>
        <li>Inglés: Nivel A1 (en proceso de aprendizaje)</li>
        <li>Valenciano: Alto</li>
      </ul>
    </section>

    <hr>

    <section>
      <h2>Formación complementaria</h2>
      <ul>
        <li>Implantación de planes y medidas de igualdad en las empresas</li>
        <li>IFCT163PO - Inteligencia artificial aplicada a la empresa</li>
        <li>Aprende a usar un CRM</li>
        <li>Gestión de posicionamiento SEM</li>
        <li>Plan estratégico de social media nivel 1 y 2</li>
      </ul>
    </section>

    <hr>

    <section>
      <h2>Otras competencias</h2>
      <ul>
        <li>Conocimientos y experiencia en paquete Office</li>
        <li>Curso de mecanografía</li>
        <li>Conocimientos en Contasol y Factusol</li>
      </ul>
    </section>

    <hr>

    <section>
      <h2>Vehículos</h2>
      <p>Dispongo de vehículo propio.</p>
    </section>

    <hr>

    <section>
      <h2>Aficiones y hobbies</h2>
      <p>Viajar, aprender nuevas tecnologías, leer y practicar deporte.</p>
    </section>

    <footer>
      <p>© 2025 Serena Sania Esteve</p>
    </footer>
  </main>
</body>
</html>
```

6. Archivo update.html dentro de templates:
```
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Pieza — Portafolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url_for('static', filename='style.css') }}">
</head>
<body>

<header>
    <nav class="navbar">
        <h1 class="logo">Serena Sania Esteve</h1>
        <ul class="nav-links">
            <li><a href="{{ url_for('index') }}">Inicio</a></li>
            <li><a href="{{ url_for('update', id=pieza.Identificador) }}">Editar Pieza</a></li>
        </ul>
        <button class="menu-toggle" aria-label="Abrir menú">☰</button>
    </nav>
</header>

<section id="update" style="padding: 120px 20px; text-align: center;">
    <h2 class="titulo-seccion">Editar Pieza</h2>
    <form method="POST" style="max-width:500px; margin: 30px auto; display:flex; flex-direction:column; gap:15px;">
        <input type="text" name="titulo" value="{{ pieza.titulo }}" placeholder="Título" required>
        <textarea name="descripcion" placeholder="Descripción" rows="4" required>{{ pieza.descripcion }}</textarea>
        <input type="date" name="fecha" value="{{ pieza.fecha }}" required>
        <input type="text" name="imagen" value="{{ pieza.imagen }}" placeholder="Ruta de imagen (ej: images/proyecto.jpg)">
        <select name="id_categoria" required>
            {% for cat in categorias %}
            <option value="{{ cat.identificador }}" {% if cat.identificador == pieza.id_categoria %}selected{% endif %}>{{ cat.nombre }}</option>
            {% endfor %}
        </select>
        <button type="submit" class="boton">Actualizar Pieza</button>
    </form>
</section>

<script src="{{ url_for('static', filename='script.js') }}"></script>
</body>
</html>
```

7. Ahora salgo de templates y vuelvo a portafolio_flask y creo la carpeta static.

8. Archivo style.css dentro de static:
```
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #ffffff; 
    color: #3e206d; 
}

header {
    background-color: #d8b4f8; 
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
}

.logo {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
}

.nav-links {
    list-style: none;
    display: flex;
    gap: 25px;
}

.nav-links a {
    text-decoration: none;
    color: #fff;
    font-weight: 500;
    transition: color 0.3s ease;
}

.nav-links a:hover {
    color: #f5e1ff;
}

.menu-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.8rem;
    color: #fff;
    cursor: pointer;
}

.inicio {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f5e1ff 0%, #ffffff 100%);
    padding: 0 20px;
    text-align: center;
}

.contenido-inicio {
    max-width: 700px;
}

.saludo {
    font-size: 1.2rem;
    color: #8a5cc2;
}

.nombre {
    font-size: 2.5rem;
    color: #3e206d;
    margin: 10px 0;
}

.titulo {
    font-size: 1.3rem;
    color: #5b4288;
    margin-bottom: 15px;
}

.descripcion {
    font-size: 1.1rem;
    color: #5b4288;
    margin-bottom: 25px;
}

.boton {
    display: inline-block;
    background-color: #b185db;
    color: white;
    padding: 12px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.boton:hover {
    background-color: #9f74cf;
    transform: scale(1.05);
}

#sobre-mi {
    padding: 120px 20px;
    background-color: #ffffff;
    display: flex;
    justify-content: center;
}

.contenedor-sobre-mi {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    max-width: 1000px;
    gap: 50px;
}

.foto-perfil {
    width: 220px;
    height: 220px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #e5ccff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.texto-sobre-mi {
    flex: 1;
    min-width: 280px;
}

.texto-sobre-mi h2 {
    color: #3e206d;
    font-size: 2rem;
    margin-bottom: 10px;
}

.texto-sobre-mi h3 {
    color: #8a5cc2;
    font-size: 1.4rem;
    margin-bottom: 5px;
}

.texto-sobre-mi h4 {
    color: #b185db;
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.texto-sobre-mi p {
    color: #5b4288;
    line-height: 1.6;
    margin-bottom: 10px;
    font-size: 1.05rem;
}

#proyectos {
    padding: 100px 20px;
    background-color: #f5e1ff;
    text-align: center;
}

.contenedor-proyectos {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

.proyecto {
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    width: 300px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.proyecto img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.proyecto:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

.proyecto:hover img {
    transform: scale(1.05);
}

.proyecto h3 {
    color: #8a5cc2;
    font-size: 1.3rem;
    margin: 15px 10px 5px 10px;
    text-align: center;
}

.proyecto p {
    color: #5b4288;
    font-size: 1rem;
    margin: 0 10px 15px 10px;
    line-height: 1.4;
    text-align: center;
}

/* Botones Editar y Eliminar solo visibles al hover */
.botones-proyecto {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.proyecto:hover .botones-proyecto {
    opacity: 1;
}

.boton {
    padding: 5px 12px;
    background-color: #3e206d;
    color: #fff;
    border-radius: 30px;
    text-decoration: none;
    font-size: 0.9em;
    font-weight: 500;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.boton:hover {
    background-color: #5b4288;
    transform: scale(1.05);
}

.boton-eliminar {
    background-color: #c0392b;
}

.boton-eliminar:hover {
    background-color: #e74c3c;
}

#habilidades {
    padding: 100px 20px;
    background-color: #ffffff;
    text-align: center;
}

.contenedor-habilidades {
    max-width: 900px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
}

.habilidad {
    flex: 1 1 300px;
}

.habilidad h3 {
    color: #3e206d;
    font-size: 1.3rem;
    margin-bottom: 10px;
    text-align: left;
}

.barra {
    background-color: #f0dfff;
    height: 20px;
    border-radius: 10px;
    overflow: hidden;
}

.progreso {
    background-color: #b185db;
    height: 100%;
    width: 0;
    border-radius: 10px;
    transition: width 1.5s ease-in-out;
}

#contacto {
    padding: 100px 20px;
    background-color: #f5e1ff;
    text-align: center;
}

.contenedor-contacto {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 50px;
    max-width: 900px;
    margin: 0 auto;
}

.info-contacto {
    flex: 1 1 300px;
    color: #3e206d;
    font-size: 1.1rem;
    text-align: left;
}

.info-contacto p {
    margin-bottom: 15px;
}

.form-contacto {
    flex: 1 1 300px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-contacto input,
.form-contacto textarea {
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #b185db;
    font-size: 1rem;
    outline: none;
}

.form-contacto input:focus,
.form-contacto textarea:focus {
    border-color: #8a5cc2;
}

.form-contacto .boton {
    align-self: flex-start;
    padding: 12px 30px;
    border-radius: 30px;
    background-color: #b185db;
    color: white;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.form-contacto .boton:hover {
    background-color: #9f74cf;
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .nav-links {
        display: none;
        flex-direction: column;
        background-color: #d8b4f8;
        position: absolute;
        top: 70px;
        right: 0;
        width: 100%;
        text-align: center;
        padding: 20px 0;
    }

    .nav-links.active {
        display: flex;
    }

    .menu-toggle {
        display: block;
    }

    .contenedor-sobre-mi,
    .contenedor-proyectos,
    .contenedor-habilidades,
    .contenedor-contacto {
        flex-direction: column;
        align-items: cen
```

9. Dentro de static creo la carpeta images.

10. Dento de la carpeta images pon serena.jpg

portafolio_flask/
│
├─ app.py
├─ templates/
│   ├─ index.html
│   ├─ micurriculum.html
│   ├─ create.html
│   └─ update.html
├─ static/
│   ├─ style.css
│   └─ images/
│       └─ serena.jpg

Con este proyecto he logrado construir un portafolio totalmente funcional y visualmente atractivo, capaz de gestionar mis proyectos y mostrar mi información personal de manera profesional. He aprendido a conectar Flask con MySQL, implementar formularios de creación y actualización de datos, y diseñar una interfaz amigable para el usuario. Este proyecto no solo cumple los objetivos del examen, sino que también me proporciona una base sólida para futuros desarrollos web full stack.

