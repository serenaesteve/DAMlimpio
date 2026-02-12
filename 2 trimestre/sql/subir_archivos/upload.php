<?php

$mysqli = new mysqli("localhost", "root", "", "archivos_db");
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}


$nombre = $_POST['nombre'];


if(isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK){
    $archivoTmp = $_FILES['archivo']['tmp_name'];
    $archivoBinario = file_get_contents($archivoTmp);

    
    $stmt = $mysqli->prepare("INSERT INTO archivos (nombre, datos) VALUES (?, ?)");
    $stmt->bind_param("sb", $nombre, $null);
    $stmt->send_long_data(1, $archivoBinario);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        echo "Archivo subido correctamente.";
    } else {
        echo "Error al subir el archivo.";
    }

    $stmt->close();
} else {
    echo "No se ha subido ningún archivo o hubo un error.";
}

$mysqli->close();
?>

