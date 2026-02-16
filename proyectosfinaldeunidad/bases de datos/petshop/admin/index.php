<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/admin_guard.php';
admin_require();

$flash = flash_get();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin</title>
  <link rel="stylesheet" href="../public/estilo.css">
</head>
<body>
<main class="container" style="margin-top:20px">
  <?php if ($flash): ?>
    <div class="flash <?= h($flash['type']) ?>"><?= h($flash['msg']) ?></div>
  <?php endif; ?>

  <div class="card pad">
    <h2 style="margin:0 0 10px 0">Panel de control</h2>
    <p class="muted">Desde aquí puedes gestionar productos.</p>
    <p>
      <a class="btn primary" href="productos.php">Gestionar productos</a>
      <a class="btn" href="logout.php">Salir</a>
      <a class="btn" href="../index.php">Ver tienda</a>
    </p>
  </div>
</main>
</body>
</html>

