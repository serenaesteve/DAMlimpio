<?php
$db = new SQLite3(__DIR__ . '/recortables.db');

$cat = isset($_GET['c']) ? trim($_GET['c']) : '';
if ($cat === '') {
  echo "Categoría no válida";
  exit;
}

$stmt = $db->prepare("SELECT id, nombre, imagen, calificacion FROM productos WHERE categoria = :c ORDER BY calificacion DESC, id ASC");
$stmt->bindValue(':c', $cat, SQLITE3_TEXT);
$res = $stmt->execute();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($cat) ?> - Juguetes Recortables</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
  <h1>Juguetes Recortables</h1>
  <p>Crea, recorta y diviértete</p>
</header>

<main>
  <section>
    <h3>Categoría: <?= htmlspecialchars($cat) ?></h3>

    <div class="contenedor">
      <?php
      $hay = false;
      while ($p = $res->fetchArray(SQLITE3_ASSOC)) {
        $hay = true;
      ?>
        <article class="destacado">
          <a class="cardlink" href="producto.php?id=<?= (int)$p['id'] ?>">
            <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
            <h4><?= htmlspecialchars($p['nombre']) ?></h4>
            <p class="calificacion">⭐ <?= htmlspecialchars((string)$p['calificacion']) ?></p>
          </a>
        </article>
      <?php } ?>

      <?php if (!$hay) { ?>
        <p>No hay productos en esta categoría todavía.</p>
      <?php } ?>
    </div>

    <div style="text-align:center; margin-top:20px;">
      <a class="btn" href="index.php">⬅ Volver al inicio</a>
    </div>
  </section>
</main>

<footer>
  <p>© 2026 Serena Sania Esteve</p>
  <p>Proyecto realizado con HTML, CSS y PHP</p>
</footer>

</body>
</html>

