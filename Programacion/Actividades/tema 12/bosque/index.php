<?php
  $friend = [
    "name" => "Serena Sania",
    "role" => "Entusiasta de la naturaleza & Aventurera al aire libre",
    "bio"  => "Serena Sania ama explorar paisajes naturales, descubrir rutas nuevas y capturar momentos únicos en el bosque, la montaña o junto al mar. Para ella, cada salida es una oportunidad para aprender, relajarse y conectar con el planeta.",
    "email" => "serena.sania@example.com"
  ];

  $skills = [
    ["title" => "Senderismo y exploración", "desc" => "Disfruta caminatas por rutas naturales, buscando miradores y lugares escondidos."],
    ["title" => "Observación de aves", "desc" => "Identifica aves por su canto, colores y comportamiento. Siempre lleva su guía de especies."],
    ["title" => "Fotografía de naturaleza", "desc" => "Toma fotos creativas de paisajes, flores y animales, capturando momentos espontáneos."],
    ["title" => "Recolección responsable", "desc" => "Recolecta pequeñas muestras (hojas, rocas, semillas) de manera ética y educativa."],
    ["title" => "Cuidado del ecosistema", "desc" => "Promueve buenas prácticas como no dejar basura y respetar la flora y fauna local."],
    ["title" => "Campamento y supervivencia básica", "desc" => "Sabe organizar campamentos, preparar mochilas y usar herramientas de orientación."]
  ];


  $portfolio = [
    ["title" => "Amanecer en la montaña", "url" => "img/amanecermontaña.jpg"],
    ["title" => "Ruta entre árboles", "url" => "img/rutaarboles.jpg"],
    ["title" => "Cerca del río", "url" => "img/rio.jpg"],
    ["title" => "Exploración en el bosque", "url" => "img/bosque.jpg"],
    ["title" => "Momento divertido en la ruta", "url" => "img/ruta.jpg"],
    ["title" => "Vista panorámica", "url" => "img/panoramica.jpg"],
    ["title" => "Descanso con picnic", "url" => "img/picnic.jpg"],
    ["title" => "Naturaleza en primer plano", "url" => "img/natu.jpg"],
    ["title" => "Atardecer en el lago", "url" => "img/lago.jpg"]
  ];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Perfil de <?php echo htmlspecialchars($friend["name"]); ?> | Naturaleza</title>

  <style>
    :root{
      --bg: #0b1020;
      --surface: rgba(255,255,255,.06);
      --text: rgba(255,255,255,.92);
      --muted: rgba(255,255,255,.72);
      --border: rgba(255,255,255,.12);
      --primary: #7c3aed;
      --primary2: #22c55e;
      --shadow: 0 10px 30px rgba(0,0,0,.35);
      --radius: 16px;
      --maxw: 1100px;
    }

    [data-theme="light"]{
      --bg: #f6f7fb;
      --surface: rgba(15, 23, 42, .04);
      --text: rgba(15, 23, 42, .92);
      --muted: rgba(15, 23, 42, .70);
      --border: rgba(15, 23, 42, .10);
      --shadow: 0 10px 30px rgba(2, 6, 23, .10);
    }

    *{ box-sizing: border-box; }
    html, body{ height: 100%; }
    body{
      margin: 0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
      background: radial-gradient(1200px 600px at 15% 10%, rgba(124,58,237,.20), transparent 55%),
                  radial-gradient(1000px 600px at 85% 30%, rgba(34,197,94,.18), transparent 50%),
                  var(--bg);
      color: var(--text);
      line-height: 1.6;
    }

    a{ color: inherit; text-decoration: none; }
    .container{
      max-width: var(--maxw);
      margin: 0 auto;
      padding: 28px 18px 80px;
    }

    header{
      position: sticky;
      top: 0;
      backdrop-filter: blur(10px);
      background: linear-gradient(to bottom, rgba(0,0,0,.15), transparent);
      z-index: 50;
    }

    .nav{
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      max-width: var(--maxw);
      margin: 0 auto;
      padding: 14px 18px;
    }

    .brand{
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 700;
    }

    .logo{
      width: 38px;
      height: 38px;
      border-radius: 12px;
      background:
        radial-gradient(circle at 30% 30%, rgba(34,197,94,.95), rgba(34,197,94,.15) 45%, transparent 60%),
        radial-gradient(circle at 70% 70%, rgba(124,58,237,.95), rgba(124,58,237,.15) 45%, transparent 60%),
        rgba(255,255,255,.08);
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
    }

    .navlinks{
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      align-items: center;
      justify-content: flex-end;
    }

    .navlinks a{
      font-size: 14px;
      color: var(--muted);
      padding: 8px 10px;
      border-radius: 999px;
      transition: all .2s ease;
    }

    .navlinks a:hover{
      color: var(--text);
      background: var(--surface);
      border: 1px solid var(--border);
    }

    .toggle{
      border: 1px solid var(--border);
      background: var(--surface);
      color: var(--text);
      padding: 10px 12px;
      border-radius: 999px;
      cursor: pointer;
      display: inline-flex;
      gap: 10px;
      align-items: center;
      user-select: none;
    }

    .toggle .dot{
      width: 10px; height: 10px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--primary2));
      box-shadow: 0 0 0 3px rgba(124,58,237,.20);
    }

    .card{
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
    }

    .hero{
      margin-top: 22px;
      padding: 28px;
      display: grid;
      gap: 18px;
      grid-template-columns: 1.3fr .7fr;
      align-items: center;
    }

    .badge{
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 8px 12px;
      border-radius: 999px;
      background: rgba(124,58,237,.15);
      border: 1px solid rgba(124,58,237,.25);
      font-size: 13px;
      width: fit-content;
    }

    .hero h1{
      margin: 10px 0 8px;
      font-size: clamp(28px, 4vw, 44px);
      line-height: 1.15;
    }

    .hero p{
      margin: 0;
      color: var(--muted);
      max-width: 62ch;
    }

    .cta-row{
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 16px;
    }

    .btn{
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid var(--border);
      background: var(--surface);
      color: var(--text);
      cursor: pointer;
      font-weight: 600;
      font-size: 14px;
    }

    .btn.primary{
      background: linear-gradient(135deg, rgba(124,58,237,.92), rgba(34,197,94,.70));
      border-color: rgba(255,255,255,.18);
      color: white;
    }

    .hero-side{
      padding: 18px;
      border-radius: var(--radius);
      border: 1px solid var(--border);
      background:
        radial-gradient(500px 200px at 20% 20%, rgba(34,197,94,.18), transparent 55%),
        radial-gradient(500px 200px at 80% 40%, rgba(124,58,237,.18), transparent 55%),
        rgba(255,255,255,.04);
    }

    .stat{
      display: grid;
      gap: 6px;
      padding: 14px;
      border-radius: 14px;
      border: 1px solid var(--border);
      background: rgba(255,255,255,.04);
      margin-bottom: 12px;
    }

    .stat span{
      color: var(--muted);
      font-size: 13px;
    }

    section{ margin-top: 28px; }

    .section-title{
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      gap: 12px;
      margin: 0 0 12px;
    }

    .section-title h2{
      margin: 0;
      font-size: 20px;
    }

    .section-title p{
      margin: 0;
      color: var(--muted);
      font-size: 14px;
    }

    .grid-skills{
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
    }

    .skill{
      padding: 16px;
      border-radius: var(--radius);
    }

    .skill h3{
      margin: 0 0 6px;
      font-size: 16px;
    }

    .skill p{
      margin: 0;
      color: var(--muted);
      font-size: 14px;
    }


    .portfolio{ padding: 16px; }

    .grid-portfolio{
      display: grid;
      grid-template-columns: repeat(3, 1fr); /* requisito */
      gap: 12px;
      margin-top: 12px;
    }

    .tile{
      position: relative;
      overflow: hidden;
      border-radius: 14px;
      border: 1px solid var(--border);
      aspect-ratio: 4/3;
    }

    .tile img{
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transform: scale(1.02);
      transition: transform .35s ease;
    }

    .tile:hover img{ transform: scale(1.08); }

    .tile .cap{
      position: absolute;
      inset: auto 0 0 0;
      padding: 10px 12px;
      background: linear-gradient(to top, rgba(0,0,0,.65), rgba(0,0,0,0));
      color: white;
      font-size: 13px;
    }

    .two-col{
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .box{
      padding: 18px;
      border-radius: var(--radius);
    }

    .muted{ color: var(--muted); }

    .contact-list{
      display: grid;
      gap: 10px;
      margin-top: 10px;
    }

    .contact-item{
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 12px;
      border-radius: 14px;
      border: 1px solid var(--border);
      background: rgba(255,255,255,.04);
    }

    .pill{
      display: inline-flex;
      padding: 6px 10px;
      border-radius: 999px;
      border: 1px solid var(--border);
      background: var(--surface);
      font-size: 13px;
      color: var(--muted);
      white-space: nowrap;
    }

    footer{
      margin-top: 28px;
      color: var(--muted);
      font-size: 13px;
      text-align: center;
    }

    @media (max-width: 960px){
      .hero{ grid-template-columns: 1fr; }
      .grid-skills{ grid-template-columns: repeat(2, 1fr); }
      .two-col{ grid-template-columns: 1fr; }
      .grid-portfolio{ grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 560px){
      .grid-skills{ grid-template-columns: 1fr; }
      .grid-portfolio{ grid-template-columns: 1fr; }
      .navlinks a{ display:none; }
    }
  </style>
</head>

<body>
  <header>
    <div class="nav">
      <div class="brand">
        <div class="logo" aria-hidden="true"></div>
        <div><?php echo htmlspecialchars($friend["name"]); ?></div>
      </div>

      <div class="navlinks">
        <a href="#habilidades">Habilidades</a>
        <a href="#portafolio">Portafolio</a>
        <a href="#acerca">Acerca</a>
        <a href="#contacto">Contacto</a>

        <button id="themeToggle" class="toggle" type="button">
          <span class="dot" aria-hidden="true"></span>
          <span id="themeLabel">Modo oscuro</span>
        </button>
      </div>
    </div>
  </header>

  <main class="container">
    <!-- HERO -->
    <section class="card hero" id="inicio">
      <div>
        <div class="badge">🌿 <?php echo htmlspecialchars($friend["role"]); ?></div>
        <h1><?php echo htmlspecialchars($friend["name"]); ?></h1>
        <p><?php echo htmlspecialchars($friend["bio"]); ?></p>

        <div class="cta-row">
          <a class="btn primary" href="#portafolio">Ver portafolio</a>
          <a class="btn" href="#contacto">Contactar</a>
        </div>
      </div>

      <aside class="hero-side">
        <div class="stat">
          <strong>Estilo</strong>
          <span>Aventura, curiosidad y amor por la vida al aire libre.</span>
        </div>
        <div class="stat">
          <strong>Plan favorito</strong>
          <span>Ruta + fotografía + descanso con vistas.</span>
        </div>
        <div class="stat">
          <strong>Regla de oro</strong>
          <span>“Disfrutar cuidando el lugar”.</span>
        </div>
      </aside>
    </section>

    <!-- HABILIDADES -->
    <section id="habilidades">
      <div class="section-title">
        <h2>Habilidades / Servicios</h2>
        <p>Lo que Serena disfruta haciendo en la naturaleza</p>
      </div>

      <div class="grid-skills">
        <?php foreach ($skills as $s): ?>
          <article class="card skill">
            <h3><?php echo htmlspecialchars($s["title"]); ?></h3>
            <p><?php echo htmlspecialchars($s["desc"]); ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- PORTAFOLIO -->
    <section id="portafolio" class="card portfolio">
      <div class="section-title">
        <h2>Portafolio</h2>
        <p>9 momentos únicos y emocionantes de Serena Sania</p>
      </div>

      <div class="grid-portfolio">
        <?php foreach ($portfolio as $p): ?>
          <figure class="tile" title="<?php echo htmlspecialchars($p["title"]); ?>">
            <img src="<?php echo htmlspecialchars($p["url"]); ?>" alt="<?php echo htmlspecialchars($p["title"]); ?>" loading="lazy" />
            <figcaption class="cap"><?php echo htmlspecialchars($p["title"]); ?></figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    </section>

   
    <section class="two-col">
      <article id="acerca" class="card box">
        <div class="section-title">
          <h2>Acerca de</h2>
          <p>Nuestra amistad</p>
        </div>

        <p class="muted" style="margin-top:0;">
          Mi amistad con Serena Sania es especial porque siempre logra convertir cualquier salida en una experiencia divertida.
          Es de esas personas que te animan a salir, respirar aire puro y disfrutar del mundo con una sonrisa.
        </p>

        <p class="muted" style="margin-bottom:0;">
          La aprecio por su carisma, su energía y por recordarme que la naturaleza es un regalo que debemos cuidar.
        </p>
      </article>

      <article id="contacto" class="card box">
        <div class="section-title">
          <h2>Contacto</h2>
          <p>Correo y redes sociales</p>
        </div>

        <div class="contact-list">
          <div class="contact-item">
            <div>
              <strong>Correo</strong><br />
              <span class="muted"><?php echo htmlspecialchars($friend["email"]); ?></span>
            </div>
            <a class="pill" href="mailto:<?php echo htmlspecialchars($friend["email"]); ?>">Enviar email</a>
          </div>

          <div class="contact-item">
            <div><strong>Facebook</strong><br /><span class="muted">facebook.com/serena.sania</span></div>
            <span class="pill">Placeholder</span>
          </div>

          <div class="contact-item">
            <div><strong>Instagram</strong><br /><span class="muted">@serena.nature</span></div>
            <span class="pill">Placeholder</span>
          </div>

          <div class="contact-item">
            <div><strong>X / Twitter</strong><br /><span class="muted">@serena_sania</span></div>
            <span class="pill">Placeholder</span>
          </div>

          <div class="contact-item">
            <div><strong>LinkedIn</strong><br /><span class="muted">linkedin.com/in/serena-sania</span></div>
            <span class="pill">Placeholder</span>
          </div>
        </div>
      </article>
    </section>

    <footer>
      Página personalizada para Serena Sania — <?php echo date("Y"); ?>
    </footer>
  </main>

  <script>
    (function () {
      const root = document.documentElement;
      const toggleBtn = document.getElementById("themeToggle");
      const label = document.getElementById("themeLabel");

      function setTheme(theme) {
        if (theme === "light") {
          root.setAttribute("data-theme", "light");
          label.textContent = "Modo claro";
        } else {
          root.removeAttribute("data-theme");
          label.textContent = "Modo oscuro";
        }
        localStorage.setItem("theme", theme);
      }

      const saved = localStorage.getItem("theme");
      const prefersLight = window.matchMedia && window.matchMedia("(prefers-color-scheme: light)").matches;
      setTheme(saved ? saved : (prefersLight ? "light" : "dark"));

      toggleBtn.addEventListener("click", () => {
        const current = root.getAttribute("data-theme") === "light" ? "light" : "dark";
        setTheme(current === "light" ? "dark" : "light");
      });
    })();
  </script>
</body>
</html>

