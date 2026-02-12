<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$dbPath = __DIR__ . '/recortables.db';

try {
    if (!file_exists($dbPath)) {
        throw new Exception("No existe la base de datos en: $dbPath");
    }

    $db = new SQLite3($dbPath, SQLITE3_OPEN_READWRITE);

    // 1) Leer id (si viene). Si no viene, usaremos el primero.
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // 2) Si no hay id, tomar el primero disponible
    if ($id <= 0) {
        $res = $db->query("SELECT id FROM productos ORDER BY id ASC LIMIT 1");
        if (!$res) {
            throw new Exception("No puedo leer la tabla 'productos': " . $db->lastErrorMsg());
        }
        $row = $res->fetchArray(SQLITE3_ASSOC);
        if (!$row) {
            die("La tabla 'productos' está vacía. Inserta productos primero.");
        }
        $id = (int)$row['id'];
    }

    // 3) Buscar el producto por id
    $stmt = $db->prepare("
        SELECT id, nombre, descripcion, precio, imagen
        FROM productos
        WHERE id = :id
        LIMIT 1
    ");
    if (!$stmt) {
        throw new Exception("Error preparando SELECT producto: " . $db->lastErrorMsg());
    }
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

    $result = $stmt->execute();
    if (!$result) {
        throw new Exception("Error ejecutando SELECT producto: " . $db->lastErrorMsg());
    }

    $producto = $result->fetchArray(SQLITE3_ASSOC);
    if (!$producto) {
        // Si el id no existe, mostramos un mensaje y sugerimos ids existentes
        $ids = [];
        $resIds = $db->query("SELECT id FROM productos ORDER BY id ASC LIMIT 10");
        while ($r = $resIds->fetchArray(SQLITE3_ASSOC)) {
            $ids[] = (int)$r['id'];
        }
        die("Producto no encontrado. Prueba con alguno de estos IDs: " . implode(", ", $ids));
    }

    // 4) Similares: 4 aleatorios, excluyendo el actual
    $stmtSim = $db->prepare("
        SELECT id, nombre, precio, imagen
        FROM productos
        WHERE id <> :id
        ORDER BY RANDOM()
        LIMIT 4
    ");
    if (!$stmtSim) {
        throw new Exception("Error preparando SELECT similares: " . $db->lastErrorMsg());
    }
    $stmtSim->bindValue(':id', $id, SQLITE3_INTEGER);

    $resSim = $stmtSim->execute();
    if (!$resSim) {
        throw new Exception("Error ejecutando SELECT similares: " . $db->lastErrorMsg());
    }

    $similares = [];
    while ($row = $resSim->fetchArray(SQLITE3_ASSOC)) {
        $similares[] = $row;
    }

} catch (Throwable $e) {
    http_response_code(500);
    echo "Error: " . e($e->getMessage());
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= e($producto['nombre']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; }
    .producto { display: flex; gap: 30px; align-items: flex-start; }
    .producto img { width: 280px; border: 1px solid #ddd; border-radius: 10px; }
    .precio { font-size: 20px; font-weight: bold; margin: 10px 0; }
    .similares { margin-top: 40px; }
    .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; }
    .card { border: 1px solid #ddd; border-radius: 12px; padding: 10px; text-align: center; }
    .card img { width: 100%; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; }
    a { color: inherit; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>

<h1><?= e($producto['nombre']) ?></h1>

<section class="producto">
  <img src="<?= e((string)$producto['imagen']) ?>" alt="<?= e($producto['nombre']) ?>">
  <div>
    <p><?= nl2br(e((string)$producto['descripcion'])) ?></p>
    <div class="precio"><?= number_format((float)$producto['precio'], 2) ?> €</div>
    <p><small>ID: <?= (int)$producto['id'] ?></small></p>
  </div>
</section>

<section class="similares">
  <h2>Productos similares</h2>

  <?php if (count($similares) === 0): ?>
    <p>No hay productos similares.</p>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($similares as $s): ?>
        <article class="card">
          <a href="producto.php?id=<?= (int)$s['id'] ?>">
            <img src="<?= e((string)$s['imagen']) ?>" alt="<?= e($s['nombre']) ?>">
            <p><?= e($s['nombre']) ?></p>
            <strong><?= number_format((float)$s['precio'], 2) ?> €</strong>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

</body>
</html>

