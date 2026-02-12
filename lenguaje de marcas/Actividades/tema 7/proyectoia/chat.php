<?php
declare(strict_types=1);

function e($s){ return htmlspecialchars($s, ENT_QUOTES); }

$data = json_decode(file_get_contents('datos.json'), true);

$pregunta = $_POST['pregunta'] ?? '';
$respuesta = '';

if ($pregunta !== '') {
  $p = strtolower($pregunta);

  if (strpos($p,'curso') !== false) {
    $respuesta = $data['heroetexto'];
  } elseif (strpos($p,'email') !== false) {
    $respuesta = $data['email'];
  } else {
    $respuesta = "No tengo esa informacion";
  }
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Chat IA</title>
<link rel="stylesheet" href="estilochatgpt.css">
</head>
<body>

<div class="container">
<h1>Asistente IA</h1>

<form method="post">
<textarea name="pregunta" required></textarea>
<button type="submit">Preguntar</button>
</form>

<?php if($pregunta): ?>
<p><strong>Pregunta:</strong> <?=e($pregunta)?></p>
<p><strong>Respuesta:</strong> <?=e($respuesta)?></p>
<?php endif; ?>

<a href="index.php">Volver</a>
</div>

</body>
</html>

