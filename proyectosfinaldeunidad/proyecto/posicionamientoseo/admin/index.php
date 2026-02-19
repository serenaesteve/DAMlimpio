<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin();
require_once __DIR__ . '/config.php';

$db = db();

// Listado de productos
$res = $db->query("SELECT id, nombre, categoria, calificacion, imagen FROM productos ORDER BY id DESC");
$productos = [];
while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
  $productos[] = $row;
}

$token = csrf_token();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Admin - Productos</title>
  <meta name="robots" content="noindex, nofollow">

  <link rel="stylesheet" href="../styles.css">
  <style>
    .admin-wrap{max-width:1100px;margin:20px auto;padding:0 14px}
    .topbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between;margin:16px 0}
    table{width:100%;border-collapse:collapse;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,.08)}
    th,td{padding:12px 10px;border-bottom:1px solid #eee;vertical-align:middle;text-align:left}
    th{background:#f2f3f5}
    .img{width:70px}
    .img img{width:70px;height:70px;object-fit:cover;border-radius:10px}
    .actions{display:flex;gap:8px;flex-wrap:wrap}
    .mini{padding:8px 12px;border-radius:16px}
    .danger{background:#ff3b30}
  </style>
</head>
<body>

<header>
  <h1>Panel de administración</h1>
</header>

<main class="admin-wrap">
  <div class="topbar">
    <div>
      <a class="btn" href="edit.php">+ Nuevo recortable</a>
      <a class="btn secundario" href="<?= h(BASE_URL) ?>/">Ver web</a>
    </div>
    <div>
      <a class="btn secundario" href="logout.php">Salir</a>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th class="img">Imagen</th>
        <th>ID</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Calificación</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $p): ?>
        <tr>
          <td class="img">
            <?php if (!empty($p['imagen'])): ?>
              <img src="../<?= h(ltrim((string)$p['imagen'], '/')) ?>" alt="">
            <?php endif; ?>
          </td>
          <td><?= (int)$p['id'] ?></td>
          <td><?= h($p['nombre'] ?? '') ?></td>
          <td><?= h($p['categoria'] ?? '') ?></td>
          <td><?= h($p['calificacion'] ?? '') ?></td>
          <td>
            <div class="actions">
              <a class="btn mini" href="edit.php?id=<?= (int)$p['id'] ?>">Editar</a>

              <form action="delete.php" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este producto?');">
                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= h($token) ?>">
                <button class="btn mini danger" type="submit">Borrar</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>

</body>
</html>

