<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Animales en adopción</title>

  <style>
    * { box-sizing: border-box; }

    body, html {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      background: #f5f5f5;
    }

    header {
      background: #222;
      color: white;
      padding: 20px;
      text-align: center;
    }

    main {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      padding: 20px;
    }

    article {
      border-radius: 16px;
      padding: 20px;
      width: 100%;
      max-width: 320px;
      text-align: center;
      display: flex;
      flex-direction: column;
      gap: 10px;
      transition: opacity .3s;
    }

    article.no-disponible { opacity: 0.6; }

    article img {
      width: 140px;
      height: 140px;
      object-fit: cover;
      border-radius: 50%;
      margin: 0 auto;
      background: rgba(0,0,0,.08);
    }

    article strong { font-size: 24px; }

    article em {
      font-size: 14px;
      opacity: .9;
    }

    .estado {
      font-size: 12px;
      padding: 4px 10px;
      border-radius: 20px;
      background: rgba(0,0,0,.15);
      display: inline-block;
      margin: 5px auto;
    }

    article a {
      margin-top: 15px;
      background: white;
      padding: 10px 20px;
      border-radius: 30px;
      text-decoration: none;
      color: black;
      font-size: 14px;
    }

    article a.disabled {
      pointer-events: none;
      opacity: 0.5;
    }

    @media (min-width: 600px) {
      article { width: calc(50% - 20px); }
    }

    @media (min-width: 900px) {
      article { width: calc(33.333% - 20px); }
    }
  </style>
</head>

<body>

<header>
  <h1>Animales en adopción</h1>
</header>

<main>
<?php
// (Opcional) Para ver errores mientras desarrollas:
// error_reporting(E_ALL); ini_set('display_errors', 1);

$xml = simplexml_load_file("animales.xml");
if ($xml === false) {
  echo "<p>No se pudo cargar animales.xml</p>";
  exit;
}

// Clasificamos sin usort (más robusto con SimpleXML)
$grupos = [
  "En adopción" => [],
  "Reservado"  => [],
  "Adoptado"   => [],
  "Otros"      => [],
];

foreach ($xml->animal as $animal) {
  $estadoRaw = trim((string)$animal->estado);

  if (isset($grupos[$estadoRaw])) {
    $grupos[$estadoRaw][] = $animal;
  } else {
    $grupos["Otros"][] = $animal;
  }
}

$ordenSalida = ["En adopción", "Reservado", "Adoptado", "Otros"];

foreach ($ordenSalida as $estadoGrupo) {
  foreach ($grupos[$estadoGrupo] as $animal) {

    $nombre = htmlspecialchars(trim((string)$animal->nombre));
    $descripcion = htmlspecialchars(trim((string)$animal->descripcion));
    $foto = htmlspecialchars(trim((string)$animal->foto));
    $color = htmlspecialchars(trim((string)$animal->color));
    $estado = htmlspecialchars(trim((string)$animal->estado));
    $slug = urlencode(trim((string)$animal->slug));

    $disponible = ($estado === "En adopción");
    $clase = $disponible ? "" : "no-disponible";

    echo "<article class='$clase' style='background:$color'>";
    echo "<img src='$foto' alt='$nombre'>";
    echo "<strong>$nombre</strong>";
    echo "<em>$descripcion</em>";
    echo "<span class='estado'>$estado</span>";

    if ($disponible) {
      echo "<a href='ficha.php?animal=$slug'>Ver ficha</a>";
    } else {
      echo "<a class='disabled'>No disponible</a>";
    }

    echo "</article>";
  }
}
?>
</main>

</body>
</html>

