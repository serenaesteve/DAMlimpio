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

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$qLike = '%' . $q . '%';

$tieneFecha        = hasCol($db, 'productos', 'fecha');
$tienePrecio       = hasCol($db, 'productos', 'precio');
$tieneCalificacion = hasCol($db, 'productos', 'calificacion');

$cols = "id, nombre, imagen, descripcion" .
  ($tienePrecio ? ", precio" : "") .
  ($tieneCalificacion ? ", calificacion" : "") .
  ($tieneFecha ? ", fecha" : "");

$stmt = $db->prepare("SELECT $cols FROM productos WHERE nombre LIKE :q OR descripcion LIKE :q ORDER BY id DESC");
$stmt->bindValue(':q', $qLike, SQLITE3_TEXT);
$res = $stmt->execute();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php
  seo(
    "Buscar recortables",
    "Resultados de búsqueda de recortables imprimibles.",
    canonical_url(),
    true // NOINDEX
  );
  ?>

  <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
  <h1>Juguetes Recortables</h1>
  <p>Búsqueda</p>

  <a class="cart-link" href="carrito.php" aria-label="Carrito">🛒
    <?php if ($carritoCount > 0) { ?><span class="cart-badge"><?= (int)$carritoCount ?></span><?php } ?>
  </a>
</header>

<main>
  <section>
    <form class="buscador" action="buscar.php" method="get">
      <input type="text" name="q" value="<?= h($q) ?>" placeholder="Buscar..." aria-label="Buscar recortables">
      <button class="btn" type="submit">Buscar</button>
      <a class="btn secundario" href="index.php">Volver</a>
    </form>

    <h3>Resultados</h3>

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

            <?php if (isset($p['precio'])) { ?>
              <p class="precio"><?= number_format((float)$p['precio'], 2) ?> €</p>
            <?php } ?>

            <?php if ($tieneFecha && !empty($p['fecha'])) { ?>
              <p class="fecha">📅 <?= h($p['fecha']) ?></p>
            <?php } ?>
          </article>
        </a>
      <?php } ?>

      <?php if (!$hay) { ?>
        <p>No se encontraron resultados.</p>
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

