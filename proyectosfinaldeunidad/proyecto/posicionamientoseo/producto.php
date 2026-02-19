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

$tienePrecio       = hasCol($db, 'productos', 'precio');
$tieneCalificacion = hasCol($db, 'productos', 'calificacion');
$tieneFecha        = hasCol($db, 'productos', 'fecha');
$tieneCategoria    = hasCol($db, 'productos', 'categoria');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { echo "ID no válido"; exit; }

$cols = "id, nombre, descripcion, imagen" .
  ($tienePrecio ? ", precio" : "") .
  ($tieneCalificacion ? ", calificacion" : "") .
  ($tieneFecha ? ", fecha" : "") .
  ($tieneCategoria ? ", categoria" : "");

$stmt = $db->prepare("SELECT $cols FROM productos WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$producto = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
if (!$producto) { echo "Producto no encontrado"; exit; }

// Sugerencias
$sug = [];
$resS = $db->query("SELECT id, nombre, imagen" . ($tienePrecio ? ", precio" : "") . " FROM productos WHERE id <> $id ORDER BY RANDOM() LIMIT 4");
while ($r = $resS->fetchArray(SQLITE3_ASSOC)) $sug[] = $r;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php
  $name = (string)($producto['nombre'] ?? 'Recortable');
  seo(
    $name . " para imprimir | Recortable",
    "Descarga e imprime el recortable \"" . $name . "\". Manualidades creativas y educativas listas para usar.",
    canonical_url()
  );
  ?>

  <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
  <h1>Juguetes Recortables</h1>
  <p><?= h($producto['nombre']) ?></p>

  <a class="cart-link" href="carrito.php" aria-label="Carrito">🛒
    <?php if ($carritoCount > 0) { ?><span class="cart-badge"><?= (int)$carritoCount ?></span><?php } ?>
  </a>
</header>

<main>
  <section class="producto">
    <div class="producto-card">
      <div class="producto">
        <img class="producto-img"
             src="<?= h(img_path($producto['imagen'] ?? '')) ?>"
             alt="Recortable <?= h($producto['nombre'] ?? '') ?> para imprimir">

        <div class="producto-info">
          <h2><?= h($producto['nombre'] ?? '') ?> para imprimir</h2>

          <?php if (!empty($producto['descripcion'])): ?>
            <p><?= nl2br(h($producto['descripcion'])) ?></p>
          <?php endif; ?>

          <?php if ($tienePrecio && isset($producto['precio'])): ?>
            <p class="precio"><?= number_format((float)$producto['precio'], 2) ?> €</p>
          <?php endif; ?>

          <?php if ($tieneCalificacion && isset($producto['calificacion'])): ?>
            <div class="calificacion">⭐ <?= h($producto['calificacion']) ?></div>
          <?php endif; ?>

          <?php if ($tieneFecha && !empty($producto['fecha'])): ?>
            <p class="fecha">📅 <?= h($producto['fecha']) ?></p>
          <?php endif; ?>

          <div style="margin-top:14px;">
            <a class="btn" href="carrito.php?add=<?= (int)$producto['id'] ?>">Añadir al carrito</a>
            <?php if ($tieneCategoria && !empty($producto['categoria'])): ?>
              <a class="btn secundario" href="categoria.php?c=<?= urlencode((string)$producto['categoria']) ?>">Ver categoría</a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <section class="seo-text" style="margin-top:14px;">
        <p>
          Este recortable imprimible es ideal para actividades educativas, manualidades creativas y trabajo de la
          motricidad fina. Imprime, recorta y juega.
        </p>
      </section>
    </div>
  </section>

  <?php if (!empty($sug)) { ?>
    <section>
      <h3>También te puede gustar</h3>
      <div class="contenedor">
        <?php foreach ($sug as $s) { ?>
          <a class="cardlink" href="producto.php?id=<?= (int)$s['id'] ?>">
            <article class="destacado">
              <img src="<?= h(img_path($s['imagen'] ?? '')) ?>" alt="Recortable <?= h($s['nombre'] ?? '') ?> para imprimir">
              <h4><?= h($s['nombre'] ?? '') ?></h4>
              <?php if (isset($s['precio'])) { ?>
                <p class="precio"><?= number_format((float)$s['precio'], 2) ?> €</p>
              <?php } ?>
            </article>
          </a>
        <?php } ?>
      </div>
    </section>
  <?php } ?>
</main>

<footer>
  <p>© 2026 Serena Sania Esteve</p>
  <p>Proyecto realizado con HTML, CSS y PHP</p>
</footer>

</body>
</html>

