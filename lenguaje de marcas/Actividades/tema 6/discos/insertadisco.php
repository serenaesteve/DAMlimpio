<?php
$mysqli = new mysqli("localhost", "discos", "discos", "discos");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "
  INSERT INTO discos (titulo, artista, anio, genero, duracion_minutos, fecha_compra, precio)
  VALUES (
    '" . $_POST['titulo'] . "',
    '" . $_POST['artista'] . "',
    " . intval($_POST['anio']) . ",
    '" . $_POST['genero'] . "',
    " . intval($_POST['duracion_minutos']) . ",
    '" . $_POST['fecha_compra'] . "',
    " . floatval($_POST['precio']) . "
  );
";

if ($mysqli->query($sql) === TRUE) {
    echo "Disco insertado con éxito";
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}

$mysqli->close();
?>
