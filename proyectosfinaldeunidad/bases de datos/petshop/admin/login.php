<?php
require_once __DIR__ . '/../inc/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = trim((string)($_POST['user'] ?? ''));
  $p = trim((string)($_POST['pass'] ?? ''));

  if ($u === ADMIN_USER && $p === ADMIN_PASS) {
    $_SESSION['admin'] = true;
    flash_set('Bienvenida al panel de control');
    header('Location: index.php');
    exit;
  } else {
    flash_set('Usuario o contraseña incorrectos', 'bad');
  }
}

$flash = flash_get();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - Login</title>
  <link rel="stylesheet" href="../public/estilo.css">
</head>
<body>
<main class="container" style="max-width:520px; margin-top:40px">
  <div class="card pad">
    <h2 style="margin-top:0">Panel de control</h2>
    <?php if ($flash): ?>
      <div class="flash <?= h($flash['type']) ?>"><?= h($flash['msg']) ?></div>
    <?php endif; ?>

    <form method="post" class="form">
      <label>Usuario</label>
      <input name="user" required>
      <label>Contraseña</label>
      <input name="pass" type="password" required>
      <button class="btn primary" type="submit">Entrar</button>
    </form>
  </div>
</main>
</body>
</html>

