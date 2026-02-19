<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/config.php';

// Si ya estás logueado, entra al panel
if (!empty($_SESSION['admin_ok'])) {
  header('Location: index.php');
  exit;
}

$error = '';

// CSRF token para el formulario de login
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = (string)($_POST['csrf_token'] ?? '');
  if (!hash_equals($_SESSION['csrf_token'], $token)) {
    $error = 'Sesión caducada. Recarga e inténtalo de nuevo.';
  } else {
    $user = trim((string)($_POST['user'] ?? ''));
    $pass = trim((string)($_POST['pass'] ?? ''));

    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
      session_regenerate_id(true);
      $_SESSION['admin_ok'] = true;
      header('Location: index.php');
      exit;
    } else {
      $error = 'Usuario o contraseña incorrectos';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Admin - Login</title>
  <meta name="robots" content="noindex, nofollow">

  <link rel="stylesheet" href="../styles.css">
  <style>
    .admin-box{max-width:520px;margin:24px auto;background:#fff;padding:18px;border-radius:14px;box-shadow:0 4px 10px rgba(0,0,0,.08)}
    label{display:block;margin-top:12px;margin-bottom:6px;font-weight:bold}
    input{width:100%;padding:10px 14px;border-radius:12px;border:1px solid #ddd;outline:none}
    .error{color:#b00020;margin-top:10px;text-align:center}
    .actions{display:flex;gap:10px;justify-content:center;margin-top:16px;flex-wrap:wrap}
  </style>
</head>
<body>

<header>
  <h1>Acceso administrador</h1>
</header>

<main>
  <div class="admin-box">
    <form method="post" autocomplete="off">
      <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

      <label>Usuario</label>
      <input type="text" name="user" required>

      <label>Contraseña</label>
      <input type="password" name="pass" required>

      <div class="actions">
        <button class="btn" type="submit">Entrar</button>
        <a class="btn secundario" href="<?= h(BASE_URL) ?>/">Volver a la web</a>
      </div>

      <?php if ($error): ?>
        <p class="error"><?= h($error) ?></p>
      <?php endif; ?>
    </form>
  </div>
</main>

</body>
</html>

