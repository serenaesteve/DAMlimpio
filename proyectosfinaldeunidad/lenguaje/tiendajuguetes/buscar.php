<?php
$db = new SQLite3(__DIR__ . '/recortables.db');

// Detectar si existe la columna 'fecha'
$cols = $db->query("PRAGMA table_info(productos)");
$tieneFecha = false;
while ($c = $cols->fetchArray(SQLITE3_ASSOC)) {
  if ($c['name'] === 'fecha') { $tieneFecha = true; break; }
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$qLike = '%' . $q . '%';

$sql = $tieneFecha
  ? "SELECT id, nombre, imagen, calificacion, fecha
     FROM productos
     WHERE nombre LIKE :q OR descripcion LIKE :q
     ORDER BY calificacion DESC, id ASC"
  : "SELECT id, nombre, imagen, calificacion
     FROM productos
     WHERE nombre LIKE :q OR descripcion LIKE :q
     ORDER BY calificacion DESC, id ASC";

$stmt = $db->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  echo "Error SQL: " . htmlspecialchars($db->lastErrorMsg());
  exit;
}
$stmt->bindValue(':q', $qLike, SQLITE3_TEXT);
$res = $stmt->execute();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buscar - Juguetes Recortables</title>
  <link rel="stylesheet" href="/styles.css">
</head>
<body>

<header>
  <h1>Juguetes Recortables</h1>
  <p>Crea, recorta y diviértete</p>
</header>

<main>
  <section>
    <h3>Buscar recortables</h3>

    <form class="buscador" action="/buscar.php" method="get">
      <input type="text" name="q" placeholder="Buscar por nombre o descripción..." value="<?= htmlspecialchars($q) ?>">
      <button class="btn" type="submit">🔎 Buscar</button>
      <a class="btn secundario" href="/index.php">⬅ Volver</a>
    </form>

    <div class="contenedor">
      <?php
      $hay = false;
      while ($p = $res->fetchArray(SQLITE3_ASSOC)) {
        $hay = true;

        $esNuevo = false;
        if ($tieneFecha && !empty($p['fecha'])) {
          $esNuevo = (strtotime($p['fecha']) >= strtotime('-7 days'));
        }
      ?>
        <a class="cardlink" href="/producto.php?id=<?= (int)$p['id'] ?>">
          <article class="destacado">
            <img src="/<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
            <h4>
              <?= htmlspecialchars($p['nombre']) ?>
              <?php if ($esNuevo) { ?><span class="badge">Nuevo</span><?php } ?>
            </h4>
            <p class="calificacion">⭐ <?= htmlspecialchars((string)$p['calificacion']) ?></p>
            <?php if ($tieneFecha && !empty($p['fecha'])) { ?>
              <p class="fecha">📅 <?= htmlspecialchars($p['fecha']) ?></p>
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

