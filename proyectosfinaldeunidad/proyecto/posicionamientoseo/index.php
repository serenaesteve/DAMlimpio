<?php
session_start();

require_once __DIR__ . '/seo.php';

$db = new SQLite3(__DIR__ . '/recortables.db');

function hasCol(SQLite3 $db, string $table, string $col): bool {
  $res = $db->query("PRAGMA table_info($table)");
  while ($r = $res->fetchArray(SQLITE3_ASSOC)) {
    if (($r['name'] ?? '') === $col) return true;
  }
  return false;
}

function h($s): string {
  return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function img_path(string $p): string {
  $p = trim($p);
  if ($p === '') return '';
  if (preg_match('#^(https?://|data:)#i', $p)) return $p;

  $p = ltrim($p, '/');

  if (file_exists(__DIR__ . '/' . $p)) return $p;
  if (file_exists(__DIR__ . '/img/' . $p)) return 'img/' . $p;

  return $p;
}

$carritoCount = isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0;

$tieneCategoria    = hasCol($db, 'productos', 'categoria');
$tieneCalificacion = hasCol($db, 'productos', 'calificacion');
$tienePrecio       = hasCol($db, 'productos', 'precio');
$tieneFecha        = hasCol($db, 'productos', 'fecha');

// Categorías (si existe columna)
$categorias = [];
if ($tieneCategoria) {
  $resC = $db->query("SELECT DISTINCT categoria FROM productos WHERE categoria IS NOT NULL AND TRIM(categoria) <> '' ORDER BY categoria ASC");
  while ($r = $resC->fetchArray(SQLITE3_ASSOC)) {
    $categorias[] = (string)$r['categoria'];
  }
}

// Destacados (por calificación o últimos)
$destacados = [];
if ($tieneCalificacion) {
  $cols = "id, nombre, imagen" . ($tienePrecio ? ", precio" : "") . ", calificacion";
  $resD = $db->query("SELECT $cols FROM productos ORDER BY calificacion DESC, id DESC LIMIT 8");
} else {
  $cols = "id, nombre, imagen" . ($tienePrecio ? ", precio" : "");
  $resD = $db->query("SELECT $cols FROM productos ORDER BY id DESC LIMIT 8");
}
while ($r = $resD->fetchArray(SQLITE3_ASSOC)) $destacados[] = $r;


$hero = 'img/banner.jpg';
if (!file_exists(__DIR__ . '/' . $hero)) {
  $hero = '';
  foreach ($destacados as $d) {
    $cand = img_path((string)($d['imagen'] ?? ''));
    if ($cand !== '') { $hero = $cand; break; }
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php
  seo(
    "Recortables imprimibles para niños y adultos",
    "Descubre recortables imprimibles por categorías. Manualidades educativas y creativas listas para imprimir.",
    canonical_url()
  );
  ?>

  <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="hero">
  <?php if ($hero !== ''): ?>
    <img class="hero-img" src="<?= h($hero) ?>" alt="Recortables imprimibles para niños y adultos">
  <?php endif; ?>

  <div class="hero-content">
    <div class="hero-box">
      <h1>Recortables imprimibles</h1>
      <p>Manualidades educativas y creativas para imprimir</p>

      <div class="hero-botones">
        <a class="btn" href="#categorias">Ver categorías</a>
        <a class="btn secundario" href="#destacados">Destacados</a>
      </div>
    </div>
  </div>

  <a class="cart-link" href="carrito.php" aria-label="Carrito">🛒
    <?php if ($carritoCount > 0) { ?><span class="cart-badge"><?= (int)$carritoCount ?></span><?php } ?>
  </a>
</header>

<main>

  <section>
    <form class="buscador" action="buscar.php" method="get">
      <input type="text" name="q" placeholder="Buscar recortables..." aria-label="Buscar recortables">
      <button class="btn" type="submit">Buscar</button>
    </form>
  </section>

  <section id="categorias">
    <h2 style="text-align:center; margin-bottom:20px;">Categorías de recortables</h2>

    <div class="contenedor">
      <?php if (!$tieneCategoria || empty($categorias)): ?>
        <p style="text-align:center;">No hay categorías disponibles.</p>
      <?php else: ?>
        <?php foreach ($categorias as $cat): ?>
          <a class="cardlink" href="categoria.php?c=<?= urlencode($cat) ?>">
            <article>
              <p><?= h($cat) ?></p>
            </article>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section id="destacados">
    <h2 style="text-align:center; margin-bottom:20px;">Recortables destacados</h2>

    <div class="contenedor">
      <?php foreach ($destacados as $p): ?>
        <a class="cardlink" href="producto.php?id=<?= (int)$p['id'] ?>">
          <article class="destacado">
            <img src="<?= h(img_path($p['imagen'] ?? '')) ?>" alt="Recortable <?= h($p['nombre'] ?? '') ?> para imprimir">
            <p><?= h($p['nombre'] ?? '') ?></p>

            <?php if ($tieneCalificacion && isset($p['calificacion'])): ?>
              <div class="calificacion">⭐ <?= h($p['calificacion']) ?></div>
            <?php endif; ?>

            <?php if ($tienePrecio && isset($p['precio'])): ?>
              <p class="precio"><?= number_format((float)$p['precio'], 2) ?> €</p>
            <?php endif; ?>
          </article>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="seo-text">
    <p style="max-width:900px;margin:0 auto;text-align:center;">
      En esta web encontrarás recortables imprimibles ideales para trabajar la creatividad, la motricidad fina y el
      aprendizaje de forma divertida tanto en casa como en el aula.
    </p>
  </section>

</main>

<footer>
  <p>© 2026 Serena Sania Esteve</p>
  <p>Proyecto realizado con HTML, CSS y PHP</p>
</footer>

</body>
</html>

