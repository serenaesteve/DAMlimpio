<?php include "motoridioma.php"; ?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($currentLang) ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($lang['Lenguaje de Programación Logos'] ?? 'Lenguaje de Programación Logos') ?></title>

  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/atom-one-dark.min.css" />
</head>

<body>

  <div class="lang-selector">
    <?php selectorIdioma(); ?>
  </div>

  <!-- Navegación -->
  <nav class="navbar">
    <div class="nav-container">
      <a class="nav-logo" href="#home" aria-label="Logo">
        <span class="logo-mark">λ</span>
        <span><?= htmlspecialchars($lang['Logos'] ?? 'Logos') ?></span>
      </a>

      <ul class="nav-menu" id="navMenu">
        <li><a href="#home"><?= $lang['Inicio'] ?? 'Inicio' ?></a></li>
        <li><a href="#features"><?= $lang['Características'] ?? 'Características' ?></a></li>
        <li><a href="#syntax"><?= $lang['Sintaxis'] ?? 'Sintaxis' ?></a></li>
        <li><a href="#examples"><?= $lang['Ejemplos'] ?? 'Ejemplos' ?></a></li>
        <li><a href="#keywords"><?= $lang['Palabras clave'] ?? 'Palabras clave' ?></a></li>
        <li><a href="#download"><?= $lang['Descargar'] ?? 'Descargar' ?></a></li>
        <li><a href="#docs"><?= $lang['Documentación'] ?? 'Documentación' ?></a></li>
        <li>
          <a href="https://github.com" target="_blank" rel="noreferrer">
            <i class="fab fa-github"></i> <?= $lang['GitHub'] ?? 'GitHub' ?>
          </a>
        </li>
      </ul>

      <button class="nav-toggle" id="navToggle" aria-label="<?= htmlspecialchars($lang['Abrir menú'] ?? 'Abrir menú') ?>">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </nav>


  <header class="hero" id="home">
    <div class="hero-content">
      <h1><?= $lang['Lenguaje de Programación Logos'] ?? 'Lenguaje de Programación Logos' ?></h1>
      <p><?= $lang['Simplicidad pythonica, léxico greco-latino y un núcleo minimalista'] ?? '' ?></p>

      <div class="hero-badges">
        <span class="pill"><i class="fa-solid fa-indent"></i> <?= $lang['Indentación'] ?? 'Indentación' ?></span>
        <span class="pill"><i class="fa-solid fa-feather-pointed"></i> <?= $lang['Minimalista'] ?? 'Minimalista' ?></span>
        <span class="pill"><i class="fa-solid fa-globe"></i> <?= $lang['Internacional'] ?? 'Internacional' ?></span>
        <span class="pill"><i class="fa-solid fa-cube"></i> <?= $lang['Núcleo + Stdlib'] ?? 'Núcleo + Stdlib' ?></span>
      </div>

      <div class="hero-buttons">
        <a class="btn btn-primary" href="#download"><?= $lang['Empezar'] ?? 'Empezar' ?></a>
        <a class="btn btn-secondary" href="#examples"><?= $lang['Ver ejemplos'] ?? 'Ver ejemplos' ?></a>
      </div>

      <div class="hero-mini">
        <div class="mini-card">
          <div class="mini-title"><?= $lang['Versión'] ?? 'Versión' ?></div>
          <div class="mini-value">0.1.0</div>
        </div>
        <div class="mini-card">
          <div class="mini-title"><?= $lang['Licencia'] ?? 'Licencia' ?></div>
          <div class="mini-value">MIT</div>
        </div>
        <div class="mini-card">
          <div class="mini-title"><?= $lang['Compila con'] ?? 'Compila con' ?></div>
          <div class="mini-value">GCC / Clang</div>
        </div>
      </div>
    </div>

    <div class="hero-code">
      <div class="code-head">
        <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
        <span class="code-title">main.logos</span>
        <button class="code-copy" data-copy="heroCode" type="button">
          <i class="fa-regular fa-copy"></i> <?= $lang['Copiar'] ?? 'Copiar' ?>
        </button>
      </div>
      <pre><code class="language-logos" id="heroCode"># Logos: programa minimo + condicion
import sonus

nomen = "Mundo"
salutatio = "salve " + nomen

si nomen == "Logos":
    sonus.dic("optime!")
alio:
    sonus.dic(salutatio)</code></pre>
    </div>
  </header>

  <!-- FEATURES -->
  <section class="features" id="features">
    <div class="container">
      <h2><?= $lang['¿Por qué Logos?'] ?? '¿Por qué Logos?' ?></h2>

      <div class="features-grid">
        <div class="feature-card">
          <i class="fa-solid fa-indent"></i>
          <h3><?= $lang['Indentación y legibilidad'] ?? 'Indentación y legibilidad' ?></h3>
          <p><?= $lang['Bloques definidos por espacios. Sin llaves ni punto y coma.'] ?? '' ?></p>
        </div>

        <div class="feature-card">
          <i class="fa-solid fa-language"></i>
          <h3><?= $lang['Léxico greco-latino'] ?? 'Léxico greco-latino' ?></h3>
          <p><?= $lang['Palabras reservadas en minúsculas, sin acentos ni caracteres especiales.'] ?? '' ?></p>
        </div>

        <div class="feature-card">
          <i class="fa-solid fa-layer-group"></i>
          <h3><?= $lang['Núcleo estable'] ?? 'Núcleo estable' ?></h3>
          <p><?= $lang['El núcleo es pequeño y explícito. El resto vive en librerías/extensiones.'] ?? '' ?></p>
        </div>

        <div class="feature-card">
          <i class="fa-solid fa-bolt"></i>
          <h3><?= $lang['Minimalista y expresivo'] ?? 'Minimalista y expresivo' ?></h3>
          <p><?= $lang['Asignación directa, control de flujo claro y una stdlib conceptual.'] ?? '' ?></p>
        </div>
      </div>
    </div>
  </section>


  <section class="syntax" id="syntax">
    <div class="container">
      <h2><?= $lang['Ejemplos de sintaxis'] ?? 'Ejemplos de sintaxis' ?></h2>

      <div class="syntax-grid">
        <div class="code-card">
          <h3><?= $lang['Hola mundo'] ?? 'Hola mundo' ?></h3>
          <pre><code class="language-logos">import sonus
sonus.dic("salve mundus!")</code></pre>
        </div>

        <div class="code-card">
          <h3><?= $lang['Condicionales'] ?? 'Condicionales' ?></h3>
          <pre><code class="language-logos">import sonus

nomen = "Logos"

si nomen == "Logos":
    sonus.dic("optime!")
alio:
    sonus.dic("quis es?")</code></pre>
        </div>

        <div class="code-card">
          <h3><?= $lang['Operadores lógicos'] ?? 'Operadores lógicos' ?></h3>
          <pre><code class="language-logos">import sonus

x = 7

si x > 0 et x < 10:
    sonus.dic("en rango")
alio:
    sonus.dic("fuera de rango")</code></pre>
        </div>
      </div>
    </div>
  </section>

  <!-- EXAMPLES -->
  <section class="examples" id="examples">
    <div class="container">
      <h2><?= $lang['Más ejemplos'] ?? 'Más ejemplos' ?></h2>

      <div class="examples-grid">
        <div class="example-card">
          <h3><?= $lang['Literales: verum/falsum/nulla'] ?? 'Literales: verum/falsum/nulla' ?></h3>
          <pre><code class="language-logos">import sonus

activo = verum
valor = nulla

si activo et valor == nulla:
    sonus.dic("estado valido")
alio:
    sonus.dic("estado mixtus")</code></pre>
        </div>

        <div class="example-card">
          <h3><?= $lang['Entrada/salida: sonus.lege'] ?? 'Entrada/salida: sonus.lege' ?></h3>
          <pre><code class="language-logos">import sonus

nomen = sonus.lege("nomen? ")
sonus.dic("salve " + nomen)</code></pre>
        </div>
      </div>
    </div>
  </section>

  <!-- KEYWORDS -->
  <section class="keywords" id="keywords">
    <div class="container">
      <h2><?= $lang['Palabras clave en latín'] ?? 'Palabras clave en latín' ?></h2>

      <div class="keywords-table-container">
        <table class="keywords-table">
          <thead>
            <tr>
              <th><?= $lang['Palabra clave Logos'] ?? 'Palabra clave Logos' ?></th>
              <th><?= $lang['Equivalente'] ?? 'Equivalente' ?></th>
              <th><?= $lang['Uso'] ?? 'Uso' ?></th>
            </tr>
          </thead>
          <tbody>
            <tr><td>si</td><td>if</td><td><?= $lang['Condicional'] ?? 'Condicional' ?></td></tr>
            <tr><td>aliosi</td><td>elif</td><td><?= $lang['Condición encadenada'] ?? '' ?></td></tr>
            <tr><td>alio</td><td>else</td><td><?= $lang['Alternativa final'] ?? '' ?></td></tr>
            <tr><td>pro</td><td>for</td><td><?= $lang['Iteración'] ?? '' ?></td></tr>
            <tr><td>dum</td><td>while</td><td><?= $lang['Bucle condicionado'] ?? '' ?></td></tr>
            <tr><td>munus</td><td>def</td><td><?= $lang['Definir función'] ?? '' ?></td></tr>
            <tr><td>redit</td><td>return</td><td><?= $lang['Devolver valor'] ?? '' ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>


  <section class="download" id="download">
    <div class="container">
      <h2><?= $lang['Obtén Logos'] ?? 'Obtén Logos' ?></h2>
      <p class="download-desc"><?= $lang['Descarga la última versión o compílala desde el código fuente'] ?? '' ?></p>

      <div class="download-info">
        <div class="version-badge"><?= $lang['Versión actual: 0.1.0'] ?? 'Versión actual: 0.1.0' ?></div>
        <div class="download-requirements"><?= $lang['Requisitos: compilador C (GCC/Clang), Make'] ?? '' ?></div>
      </div>

      <div class="download-buttons">
        <a href="https://github.com/yourusername/Logos" target="_blank" class="btn btn-primary">
          <i class="fab fa-github"></i> <?= $lang['Código fuente'] ?? 'Código fuente' ?>
        </a>
        <a href="#" class="btn btn-secondary"><?= $lang['Descargar binario'] ?? 'Descargar binario' ?></a>
      </div>
    </div>
  </section>


  <section class="docs" id="docs">
    <div class="container">
      <h2><?= $lang['Documentación'] ?? 'Documentación' ?></h2>

      <div class="docs-grid">
        <a class="docs-card" href="#syntax">
          <div class="docs-ico"><i class="fa-solid fa-code"></i></div>
          <div>
            <h3><?= $lang['Sintaxis'] ?? 'Sintaxis' ?></h3>
            <p><?= $lang['Ejemplos cortos y patrones de uso.'] ?? '' ?></p>
          </div>
        </a>

        <a class="docs-card" href="#keywords">
          <div class="docs-ico"><i class="fa-solid fa-list"></i></div>
          <div>
            <h3><?= $lang['Palabras clave'] ?? 'Palabras clave' ?></h3>
            <p>Cheat-sheet rápida para estudiar.</p>
          </div>
        </a>

        <a class="docs-card" href="#download">
          <div class="docs-ico"><i class="fa-solid fa-download"></i></div>
          <div>
            <h3><?= $lang['Instalación'] ?? 'Instalación' ?></h3>
            <p><?= $lang['Compilación, binarios y primeros pasos.'] ?? '' ?></p>
          </div>
        </a>
      </div>
    </div>
  </section>


  <footer class="footer">
    <div class="container">
      <div class="footer-bottom">
        <p>© 2024 <?= $lang['Proyecto del Lenguaje Logos. Licencia MIT.'] ?? 'Proyecto del Lenguaje Logos. Licencia MIT.' ?></p>
      </div>
    </div>
  </footer>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
  <script src="app.js"></script>
</body>
</html>


