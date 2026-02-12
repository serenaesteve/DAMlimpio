<?php
declare(strict_types=1);

$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';

$texto = date('Y-m-d H:i:s')."\n".$nombre."\n".$email."\n".$mensaje."\n---\n";
file_put_contents('leads.txt',$texto,FILE_APPEND);
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Enviado</title>
<link rel="stylesheet" href="estilochatgpt.css">
</head>
<body>
<div class="container">
<p>Mensaje enviado correctamente</p>
<a href="index.php">Volver</a>
</div>
</body>
</html>

