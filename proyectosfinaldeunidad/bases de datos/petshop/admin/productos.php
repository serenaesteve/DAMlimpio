<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../inc/repos.php';
require_once __DIR__ . '/admin_guard.php';
admin_require();

$prods = productos(null, null);
$flash = flash_get();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - Productos</title>
  <link rel="stylesheet" href="../public/estilo.css">
</head>
<body>
<main class="container" style="margin-top:20px">
  <?php if ($flash): ?>
    <div class="flash <?= h($flash['type']) ?>"><?= h($flash['msg']) ?></div>
  <?php endif; ?>

  <div class="card pad">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap">
      <h2 style="margin:0">Productos</h2>
      <div>
        <a class="btn primary" href="producto_form.php">+ Nuevo producto</a>
        <a class="btn" href="index.php">Volver</a>
      </div>
    </div>

    <table class="table" style="margin-top:12px">
      <thead>
        <tr>
          <th>ID</th><th>Título</th><th>Categoría</th><th class="right">Precio</th><th class="right">Stock</th><th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($prods as $p): ?>
          <tr>
            <td><?= (int)$p['id'] ?></td>
            <td><?= h($p['titulo']) ?></td>
            <td><?= h($p['categoria']) ?></td>
            <td class="right"><?= h(money((float)$p['precio'])) ?></td>
            <td class="right"><?= (int)$p['stock'] ?></td>
            <td>
              <a class="btn" href="producto_form.php?id=<?= (int)$p['id'] ?>">Editar</a>
              <form action="producto_borrar.php" method="post" style="display:inline">
                <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                <button class="btn danger" type="submit">Borrar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>

