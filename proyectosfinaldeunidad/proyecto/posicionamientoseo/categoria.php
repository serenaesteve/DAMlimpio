<?php
session_start();

require_once __DIR__ . '/seo.php';

$db = new SQLite3(__DIR__ . '/recortables.db');

function hasCol(SQLite3 $db, string $table, string $col): bool {
  $res = $db->query("PRAGMA table_info($table)");
  while ($r = $res->fetchArray(SQLITE3_ASSOC)) if (($r['name'] ?? '') === $col) return true;
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

$c = isset($_GET['c']) ? trim($_GET['c']) : '';
if ($c === '') { echo "Categoría no válida"; exit; }

$tieneCategoria    = hasCol($db, 'productos', 'categoria');
$tieneCalificacion = hasCol($db, 'productos', 'calificacion');
$tienePrecio       = hasCol($db, 'productos', 'precio');
$tieneFecha        = hasCol($db, 'productos', 'fecha');

$cols = "id, nombre, imagen" .
  ($tieneCalificacion ? ", calificacion" : "") .
  ($tienePrecio ? ", precio" : "") .
  ($tieneFecha ? ", fecha" : "");

if ($tieneCategoria) {
  $stmt = $db->prepare("SELECT $cols FROM productos WHERE categoria = :c ORDER BY id DESC");
  $stmt->bindValue(':c', $c, SQLITE3_TEXT);
} else {
  echo "La tabla no tiene columna 'categoria'"; exit;
}

$res = $stmt->execute();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php
  seo(
    "Recortables de " . $c . " para imprimir",
    "Explora recortables de " . $c . " listos para imprimir. Manualidades creativas y educativas.",
    canonical_url()
  );
  ?>

  <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
  <h1>Juguetes Recortables</h1>
  <p>Categoría: <?= h($c) ?></p>

  <a class="cart-link" href="carrito.php" aria-label="Carrito">🛒
    <?php if ($carritoCount > 0) { ?><span class="cart-badge"><?= (int)$carritoCount ?></span><?php } ?>
  </a>
</header>

<main>
  <section>
    <h3>Recortables en <?= h($c) ?></h3>

    <div class="contenedor">
      <?php
      $hay = false;
      while ($p = $res->fetchArray(SQLITE3_ASSOC)) {
        $hay = true;
      ?>
        <a class="cardlink" href="producto.php?id=<?= (int)$p['id'] ?>">
          <article>
            <img src="<?= h(img_path($p['imagen'] ?? '')) ?>"
                 alt="Recortable <?= h($p['nombre'] ?? '') ?> para imprimir">
            <p><?= h($p['nombre'] ?? '') ?></p>

            <?php if ($tieneCalificacion && isset($p['calificacion'])) { ?>
              <div class="calificacion">⭐ <?= h($p['calificacion']) ?></div>
            <?php } ?>

            <?php if ($tienePrecio && isset($p['precio'])) { ?>
              <p class="precio"><?= number_format((float)$p['precio'], 2) ?> €</p>
            <?php } ?>

            <?php if (isset($p['fecha']) && $p['fecha']) { ?>
              <p class="fecha">📅 <?= h($p['fecha']) ?></p>
            <?php } ?>
          </article>
        </a>
      <?php } ?>

      <?php if (!$hay) { ?>
        <p>No hay recortables en esta categoría.</p>
      <?php } ?>
    </div>

    <section class="seo-text">
      <p style="max-width:900px;margin:20px auto 0;text-align:center;">
        Los recortables de <?= h($c) ?> son perfectos para fomentar la creatividad y el aprendizaje mediante
        manualidades imprimibles listas para usar en casa o en clase.
      </p>
    </section>

    <div style="text-align:center; margin-top:20px;">
      <a class="btn" href="index.php">⬅ Volver</a>
    </div>
  </section>
</main>

<footer>
  <p>© 2026 Serena Sania Esteve</p>
  <p>Proyecto realizado con HTML, CSS y PHP</p>
</footer>

</body>
</html>

