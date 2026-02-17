<?php
$db = new SQLite3(__DIR__ . '/recortables.db');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $db->prepare("SELECT id, nombre, descripcion, imagen, calificacion FROM productos WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$res = $stmt->execute();

$producto = $res ? $res->fetchArray(SQLITE3_ASSOC) : null;

if (!$producto) {
  http_response_code(404);
  echo "Producto no encontrado";
  exit;
}

// “Similares”: 4 productos distintos, por calificación alta
$sim = $db->prepare("
  SELECT id, nombre, imagen, calificacion
  FROM productos
  WHERE id != :id
  ORDER BY calificacion DESC, id ASC
  LIMIT 4
");
$sim->bindValue(':id', $id, SQLITE3_INTEGER);
$simRes = $sim->execute();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($producto['nombre']) ?> - Juguetes Recortables</title>
  <link rel="stylesheet" href="styles.css">
</head>

<div id="modalImg" class="modal" onclick="this.style.display='none'">
  <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
</div>

<body>

<header>
  <h1>Juguetes Recortables</h1>
  <p>Crea, recorta y diviértete</p>
</header>

<main>

  <section class="producto">
    <div class="producto-card">
      <img class="producto-img zoomable"
     src="<?= htmlspecialchars($producto['imagen']) ?>"
     alt="<?= htmlspecialchars($producto['nombre']) ?>"
     onclick="document.getElementById('modalImg').style.display='flex'">

      <div class="producto-info">
        <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
        <p class="calificacion">⭐ <?= htmlspecialchars((string)$producto['calificacion']) ?></p>
        <p><?= nl2br(htmlspecialchars($producto['descripcion'] ?? '')) ?></p>

        <a class="btn" href="index.php">⬅ Volver</a>
        <a class="btn" href="<?= htmlspecialchars($producto['imagen']) ?>" download>
	  ⬇ Descargar imagen
	</a>
      </div>
    </div>
  </section>

  <section>
    <h3>Te puede gustar</h3>
    <div class="contenedor">
      <?php while ($s = $simRes->fetchArray(SQLITE3_ASSOC)) { ?>
        <article class="destacado">
          <a class="cardlink" href="producto.php?id=<?= (int)$s['id'] ?>">
            <img src="<?= htmlspecialchars($s['imagen']) ?>" alt="<?= htmlspecialchars($s['nombre']) ?>">
            <h4><?= htmlspecialchars($s['nombre']) ?></h4>
            <p class="calificacion">⭐ <?= htmlspecialchars((string)$s['calificacion']) ?></p>
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

