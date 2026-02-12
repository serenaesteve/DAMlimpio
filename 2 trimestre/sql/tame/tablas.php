<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tablas de la base de datos</title>
    <link rel="stylesheet" href="estilos.php">
</head>
<body>

<h1>Tablas de la base de datos tame</h1>

<?php
$consulta = "SHOW TABLES";
$resultado = mysqli_query($conexion, $consulta);

while ($fila = mysqli_fetch_array($resultado)) {
    echo "<button>" . $fila[0] . "</button><br>";
}

mysqli_close($conexion);
?>

</body>
</html>

