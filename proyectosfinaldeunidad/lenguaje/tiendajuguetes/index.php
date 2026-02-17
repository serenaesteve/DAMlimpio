<?php
// Conexión a la base de datos
$db = new SQLite3(__DIR__ . '/recortables.db');

// Destacados (los 3 mejor valorados)
$destacados = $db->query("
  SELECT id, nombre, imagen, calificacion
  FROM productos
  ORDER BY calificacion DESC, id ASC
  LIMIT 3
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Juguetes Recortables</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>

<header>
  <h1>Juguetes Recortables</h1>
  <p>Crea, recorta y diviértete</p>
</header>

<main>

  <!-- HERO -->
  <section id="heroe">
  <section>
	  <h3>Buscar</h3>
	  <form class="buscador" action="buscar.php" method="get">
	    <input type="text" name="q" placeholder="Buscar recortables...">
	    <button class="btn" type="submit">🔎 Buscar</button>
	  </form>
	</section>

    <h2>Recorta, arma y juega</h2>
    <p>
      Descubre recortables de vehículos, edificios, robots y mucho más.
      Imprime, recorta y construye tus propios juguetes.
    </p>
    <a href="#categoriasprincipales">Ver categorías</a>
    <a href="#recortablesdestacados">Ver destacados</a>
  </section>

  <!-- CATEGORÍAS -->
  <section id="categoriasprincipales">
    <h3>Categorías principales</h3>

    <div class="contenedor">

      <a class="cardlink" href="categoria.php?c=Vehículos">
        <article>
          <img src="vehiculos.jpg" alt="Vehículos">
          <p>Vehículos</p>
        </article>
      </a>

      <a class="cardlink" href="categoria.php?c=Edificios">
        <article>
          <img src="edificios.jpg" alt="Edificios">
          <p>Edificios</p>
        </article>
      </a>

      <a class="cardlink" href="categoria.php?c=Robots">
        <article>
          <img src="robots.jpg" alt="Robots">
          <p>Robots</p>
        </article>
      </a>

      <a class="cardlink" href="categoria.php?c=Animales">
        <article>
          <img src="animales.jpg" alt="Animales">
          <p>Animales</p>
        </article>
      </a>

      <a class="cardlink" href="categoria.php?c=Fantasía">
        <article>
          <img src="fantasia.jpg" alt="Fantasía">
          <p>Fantasía</p>
        </article>
      </a>

    </div>
  </section>

  <!-- DESTACADOS -->
  <section id="recortablesdestacados">
    <h3>Recortables destacados</h3>

    <div class="contenedor">
      <?php while ($p = $destacados->fetchArray(SQLITE3_ASSOC)) { ?>
        <article class="destacado">
          <a class="cardlink" href="producto.php?id=<?= (int)$p['id'] ?>">
            <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
            <h4><?= htmlspecialchars($p['nombre']) ?></h4>
            <p class="calificacion">⭐ <?= htmlspecialchars((string)$p['calificacion']) ?></p>
          </a>
        </article>
      <?php } ?>
    </div>
  </section>

</main>

<footer>
  <p>© 2026 Serena Sania Esteve</p>
  <p>Proyecto realizado con HTML, CSS y PHP</p>
</footer>

</body>
</html>


