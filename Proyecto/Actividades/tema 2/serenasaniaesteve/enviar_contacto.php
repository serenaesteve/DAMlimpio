<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
  header("Location: producto.php");
  exit;
}

$nombre  = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
$email   = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$mensaje = isset($_POST["mensaje"]) ? trim($_POST["mensaje"]) : "";

if($nombre=="" || $email=="" || $mensaje==""){
  echo "Faltan datos. Vuelve atrás y completa el formulario.";
  exit;
}


$linea = date("Y-m-d H:i:s")." | ".$nombre." | ".$email." | ".str_replace("\n"," ",$mensaje)."\n";
file_put_contents("contactos.txt", $linea, FILE_APPEND);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Mensaje enviado</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    @font-face {font-family: Ubuntu;src: url(estilo/Ubuntu-R.ttf);}
    @font-face {font-family: UbuntuB;src: url(estilo/Ubuntu-B.ttf);}
    html,body{margin:0;padding:0;font-family:Ubuntu,sans-serif;background:#f3f3f7;color:#111827;}
    .caja{
      max-width:720px;margin:40px auto;background:white;
      border:1px solid #e5e7eb;border-radius:14px;padding:16px;
      box-shadow:0 10px 22px rgba(0,0,0,.08);
    }
    h2{font-family:UbuntuB;margin:0 0 8px 0;}
    p{margin:0 0 10px 0;color:#374151;line-height:1.4;}
    a{color:#4f46e5;text-decoration:none;}
    a:hover{text-decoration:underline;}
  </style>
</head>
<body>
  <div class="caja">
    <h2>¡Mensaje enviado!</h2>
    <p>Gracias <b><?php echo htmlspecialchars($nombre); ?></b>. He recibido tu mensaje.</p>
    <p>Te responderé al email: <b><?php echo htmlspecialchars($email); ?></b></p>
    <p><a href="producto.php">Volver a la página del producto</a></p>
  </div>
</body>
</html>

