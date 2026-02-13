<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Ficha del animal</title>

  <style>
    body {
      margin: 0;
      padding: 40px;
      font-family: sans-serif;
      background: #f5f5f5;
    }

    article {
      max-width: 600px;
      margin: auto;
      padding: 30px;
      border-radius: 20px;
      background: white;
      text-align: center;
    }

    img {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      object-fit: cover;
      background: rgba(0,0,0,.08);
    }

    h1 { margin-top: 20px; }

    p { margin: 8px 0; }

    a {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      background: #222;
      color: white;
      padding: 10px 20px;
      border-radius: 30px;
    }
  </style>
</head>

<body>

<?php
if (!isset($_GET["animal"])) {
  echo "<p>Animal no especificado</p>";
  exit;
}

$slug = trim($_GET["animal"]);
$xml = simplexml_load_file("animales.xml");
if ($xml === false) {
  echo "<p>No se pudo cargar animales.xml</p>";
  exit;
}

$encontrado = false;

foreach ($xml->animal as $animal) {
  if (trim((string)$animal->slug) === $slug) {

    $nombre = htmlspecialchars(trim((string)$animal->nombre));
    $descripcion = htmlspecialchars(trim((string)$animal->descripcion));
    $foto = htmlspecialchars(trim((string)$animal->foto));
    $estado = htmlspecialchars(trim((string)$animal->estado));
    $especie = htmlspecialchars(trim((string)$animal->especie));
    $edad = htmlspecialchars(trim((string)$animal->edad));
    $sexo = htmlspecialchars(trim((string)$animal->sexo));

    echo "<article>";
    echo "<img src='$foto' alt='$nombre'>";
    echo "<h1>$nombre</h1>";
    echo "<p><strong>Especie:</strong> $especie</p>";
    echo "<p><strong>Edad:</strong> $edad</p>";
    echo "<p><strong>Sexo:</strong> $sexo</p>";
    echo "<p>$descripcion</p>";
    echo "<p><strong>Estado:</strong> $estado</p>";
    echo "<a href='index.php'>← Volver</a>";
    echo "</article>";

    $encontrado = true;
    break;
  }
}

if (!$encontrado) {
  echo "<p>Animal no encontrado</p>";
}
?>

</body>
</html>


