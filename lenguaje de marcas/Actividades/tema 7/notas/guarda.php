<?php


$usuario   = $_GET['usuario']   ?? '';
$pregunta  = $_GET['pregunta']  ?? '';
$respuesta = $_GET['respuesta'] ?? '';
$opciones  = $_GET['opciones']  ?? '[]';


$opciones_array = json_decode($opciones, true);
if (!is_array($opciones_array)) {
    $opciones_array = [];
}


$opciones_json = json_encode($opciones_array, JSON_UNESCAPED_UNICODE);

// Abrir CSV en modo append
$fp = fopen("respuestas.csv", "a");


fputcsv($fp, [
    $usuario,
    $pregunta,
    $respuesta,
    $opciones_json
]);

fclose($fp);

