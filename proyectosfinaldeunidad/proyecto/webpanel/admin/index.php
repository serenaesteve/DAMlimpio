<?php
session_start();

$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $u = isset($_POST['usuario']) ? (string)$_POST['usuario'] : "";
  $p = isset($_POST['contrasena']) ? (string)$_POST['contrasena'] : "";

  if($u === "jocarsa" && $p === "jocarsa"){
    session_regenerate_id(true);
    $_SESSION['admin_ok'] = 1;
    header("Location: escritorio.php");
    exit;
  }else{
    $error = "Usuario o contraseña incorrectos";
  }
}
?>
<!doctype html>
<html class="w-100pc h-100pc p-0 m-0" lang="es">
<head>
  <meta charset="utf-8">

  <link rel="stylesheet" href="../JVestilo/JVestilo.php">
  <link rel="stylesheet" href="../estilo/estilo.css">

  <style>
    *{box-sizing:border-box}
    body{background:#f4f7f7;}
  </style>
</head>

<body class="flex fa-center fj-center w-100pc h-100pc p-0 m-0">
  <form method="post" class="w-320 p-20 flex fd-column g-15 card shadow-1">
    <h2 class="m-0 c-brand ta-center">Acceso</h2>
    <input name="usuario" type="text" placeholder="usuario" autocomplete="username" required class="p-10 bradius-10 br-1-solid-lightgray">
    <input name="contrasena" type="password" placeholder="contraseña" autocomplete="current-password" required class="p-10 bradius-10 br-1-solid-lightgray">
    <input type="submit" value="Entrar" class="p-10 btn-brand" style="border-radius:12px;border:0;cursor:pointer;">

    <?php if($error){ ?>
      <p class="m-0 c-muted ta-center"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?></p>
    <?php } ?>
  </form>
</body>
</html>

