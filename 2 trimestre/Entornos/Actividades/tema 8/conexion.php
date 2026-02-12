<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$basedatos = "tame";

$conexion = mysqli_connect($servidor, $usuario, $password, $basedatos);

if (!$conexion) {
    die("Error de conexión");
}
?>

