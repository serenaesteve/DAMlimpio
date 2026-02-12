<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Serena Sania Esteve | Diseño Web</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    @font-face {font-family: Ubuntu;src: url(estilo/Ubuntu-R.ttf);}
    @font-face {font-family: UbuntuB;src: url(estilo/Ubuntu-B.ttf);}

    :root{
      --bg:#f3f3f7;
      --card:#ffffff;
      --text:#111827;
      --muted:#374151;
      --border:#e5e7eb;
      --brand:#4f46e5;      
      --brand2:#16a34a;     
      --soft:#eef2ff;
    }

    *{box-sizing:border-box;}
    html,body{margin:0;padding:0;font-family:Ubuntu,sans-serif;background:var(--bg);color:var(--text);}

    /* Header */
    header{
      position:sticky; top:0; z-index:50;
      background:rgba(255,255,255,.95);
      backdrop-filter: blur(6px);
      border-bottom:1px solid var(--border);
    }
    .nav{
      max-width:1050px; margin:0 auto;
      padding:12px 16px;
      display:flex; align-items:center; justify-content:space-between;
      gap:12px;
    }
    .brand{
      display:flex; flex-direction:column;
      line-height:1.1;
    }
    .brand .name{font-family:UbuntuB;color:var(--brand);font-size:15px;}
    .brand .tag{font-size:12px;color:var(--muted);}
    .menu{display:flex; gap:12px; flex-wrap:wrap; justify-content:center;}
    .menu a{
      font-size:12px; color:var(--brand);
      text-decoration:none;
      padding:8px 10px;
      border-radius:999px;
      border:1px solid transparent;
    }
    .menu a:hover{background:var(--soft); border-color:#c7d2fe;}

    
    .container{max-width:1050px;margin:0 auto;padding:16px;}
    .card{
      background:var(--card);
      border:1px solid var(--border);
      border-radius:14px;
      box-shadow:0 6px 18px rgba(0,0,0,.06);
      overflow:hidden;
    }

    
    .hero{
      display:grid;
      grid-template-columns:1fr;
      gap:0;
    }
    .hero-left{padding:18px;}
    .hero h1{font-family:UbuntuB;margin:0 0 8px 0;font-size:26px;}
    .hero p{margin:0 0 12px 0;color:var(--muted);line-height:1.5;}
    .chips{display:flex; flex-wrap:wrap; gap:8px; margin-top:8px;}
    .chip{
      font-size:12px;
      padding:6px 10px;
      border-radius:999px;
      border:1px solid var(--border);
      background:#fafafa;
      color:#1f2937;
    }
    .chip.green{border-color:#bbf7d0;background:#f0fdf4;}
    .chip.indigo{border-color:#c7d2fe;background:#eef2ff;}

    .hero-right{
      min-height:230px;
      display:flex; align-items:center; justify-content:center;
      padding:14px;
      background:linear-gradient(135deg, rgba(79,70,229,.15), rgba(22,163,74,.12));
    }
    .hero-right img{
      width:100%;
      max-width:520px;
      border-radius:14px;
      border:1px solid rgba(17,24,39,.12);
      box-shadow:0 10px 22px rgba(0,0,0,.12);
      display:block;
      background:white;
    }

    .cta{
      display:flex; gap:10px; flex-wrap:wrap;
      margin-top:12px;
    }
    .btn{
      display:inline-block;
      text-decoration:none;
      font-size:13px;
      padding:10px 14px;
      border-radius:999px;
      border:1px solid var(--border);
      color:var(--text);
      background:white;
    }
    .btn.primary{
      background:var(--brand);
      color:white;
      border-color:transparent;
    }
    .btn.primary:hover{filter:brightness(0.95);}
    .btn:hover{background:#f9fafb;}

    /* Sections */
    .section{margin-top:14px;}
    .grid{
      display:grid;
      grid-template-columns:1fr;
      gap:12px;
    }
    .box{
      padding:14px;
      border-radius:14px;
      border:1px solid var(--border);
      background:var(--card);
      box-shadow:0 6px 18px rgba(0,0,0,.05);
    }
    .box h2{font-family:UbuntuB;margin:0 0 8px 0;font-size:18px;}
    .box p{margin:0;color:var(--muted);line-height:1.5;}
    .list{margin:10px 0 0 0;padding-left:18px;color:var(--muted);}
    .list li{margin:6px 0;}

    
    form{margin-top:10px;}
    label{font-size:12px;color:var(--muted);}
    input,textarea{
      width:100%;
      padding:10px 12px;
      border-radius:12px;
      border:1px solid #d1d5db;
      font-family:Ubuntu,sans-serif;
      font-size:14px;
      margin-top:6px;
      margin-bottom:10px;
      background:white;
      outline:none;
    }
    textarea{min-height:120px;resize:vertical;}
    button{
      background:var(--brand);
      color:white;
      border:none;
      padding:10px 16px;
      border-radius:999px;
      cursor:pointer;
      font-size:14px;
    }
    button:hover{filter:brightness(0.95);}
    .mini{
      font-size:12px;
      color:#6b7280;
      margin-top:6px;
    }

    /* Footer */
    footer{
      margin-top:16px;
      background:#111827;
      color:#e5e7eb;
      padding:18px 16px;
    }
    .foot{
      max-width:1050px;margin:0 auto;
      display:grid;
      grid-template-columns:1fr;
      gap:12px;
    }
    .foot h3{margin:0;font-family:UbuntuB;font-size:14px;color:white;}
    .foot p{margin:6px 0 0 0;font-size:12px;color:#cbd5e1;line-height:1.4;}
    .links a{color:#c7d2fe;text-decoration:none;font-size:12px;margin-right:10px;}
    .links a:hover{text-decoration:underline;}

    /* Responsive */
    @media (min-width:850px){
      .hero{grid-template-columns:1.05fr .95fr;}
      .grid{grid-template-columns:1fr 1fr;}
      .foot{grid-template-columns:1fr 1fr;}
      .hero h1{font-size:30px;}
    }
  </style>
</head>

<body>

<header>
  <div class="nav">
    <div class="brand">
      <div class="name">Serena Sania Esteve</div>
      <div class="tag">Diseño web sencillo y profesional</div>
    </div>

    <nav class="menu">
      <a href="#servicio">Servicio</a>
      <a href="#incluye">Qué incluye</a>
      <a href="#ejemplos">Ejemplos</a>
      <a href="#contacto">Contacto</a>
    </nav>
  </div>
</header>

<div class="container">

  
  <section class="card hero" id="servicio">
    <div class="hero-left">
      <h1>Página web básica para tu proyecto o negocio</h1>
      <p>
        Ofrezco la creación de una <b>web sencilla</b> para que te encuentren en Internet,
        vean lo que haces y puedan contactarte fácilmente.
      </p>
      <p>
        Está pensada para verse bien en móvil y ordenador (responsive) y tener un diseño limpio.
        La inspiración viene de dos cosas: la organización clara de los videojuegos y un estilo “eco”
        que evita papeles y mejora la comunicación online.
      </p>

      <div class="chips">
        <span class="chip indigo">📱 Responsive</span>
        <span class="chip indigo">🧩 Fácil de entender</span>
        <span class="chip green">🌿 Menos papel</span>
        <span class="chip">🎲 Juegos / videojuegos</span>
      </div>

      <div class="cta">
        <a class="btn primary" href="#contacto">Pedir información</a>
        <a class="btn" href="#incluye">Ver qué incluye</a>
      </div>

      <div class="mini">*(Ejercicio de práctica: página de producto + formulario en PHP.)*</div>
    </div>

    <div class="hero-right">
      <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&q=60"
           alt="Ejemplo de página web">
    </div>
  </section>

  
  <section class="section grid">

    <div class="box" id="incluye">
      <h2>¿Qué incluye?</h2>
      <ul class="list">
        <li>Diseño responsive (móvil y ordenador).</li>
        <li>Sección de presentación + servicios + contacto.</li>
        <li>Imágenes y texto bien organizado.</li>
        <li>Formulario de contacto funcionando con PHP.</li>
      </ul>
    </div>

    <div class="box">
      <h2>¿Para quién es?</h2>
      <p>
        Para quien tenga un proyecto personal o un negocio pequeño y quiera algo simple:
        una tienda de juegos de mesa, un proyecto de videojuegos o una actividad relacionada con el campo y la naturaleza.
      </p>
    </div>

    <div class="box">
      <h2>¿Cómo se usa?</h2>
      <p>
        El visitante entra, ve la información principal y al final tiene un formulario para escribirte.
        Así es fácil que te pidan presupuesto o dudas sin tener que llamar.
      </p>
    </div>

    <div class="box" id="ejemplos">
      <h2>Ejemplos prácticos</h2>
      <ul class="list">
        <li><b>Juegos:</b> mostrar catálogo, horarios y contacto.</li>
        <li><b>Naturaleza:</b> mostrar rutas, actividades y reservas por mensaje.</li>
      </ul>
    </div>

  </section>

  
  <section class="section card" style="padding:14px;">
    <h2 style="font-family:UbuntuB;margin:0 0 8px 0;font-size:18px;">Estilo “eco” (naturaleza)</h2>
    <p style="margin:0 0 10px 0;color:#374151;line-height:1.5;">
      Tener la información online ayuda a reducir impresiones y a organizarlo todo mejor.
    </p>
    <img
      src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1400&q=60"
      alt="Bosque y naturaleza"
      style="width:100%;border-radius:14px;border:1px solid rgba(17,24,39,.12);display:block;"
    >
  </section>

 
  <section class="section box" id="contacto">
    <h2>Formulario de contacto</h2>
    <p>Rellena estos datos y te respondo.</p>

    <form method="POST" action="enviar_contacto.php">
      <label>Nombre</label>
      <input type="text" name="nombre" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Mensaje</label>
      <textarea name="mensaje" required></textarea>

      <button type="submit">Enviar</button>
    </form>

    <div class="mini">Los mensajes se guardan en un archivo <b>contactos.txt</b> (práctica en local).</div>
  </section>

</div>

<footer>
  <div class="foot">
    <div>
      <h3>Serena Sania Esteve</h3>
      <p>Página de producto realizada como práctica (FP): contenido + diseño responsive + formulario en PHP.</p>
    </div>
    <div class="links">
      <h3>Enlaces</h3>
      <p>
        <a href="#servicio">Servicio</a>
        <a href="#incluye">Qué incluye</a>
        <a href="#contacto">Contacto</a>
      </p>
    </div>
  </div>
</footer>

</body>
</html>

