<?php

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$pedido = [
    "cliente" => "Serena",
    "fecha" => new MongoDB\BSON\UTCDateTime(),
    "estado" => "pendiente",
    "productos" => [
        ["nombre" => "Collar para perro", "cantidad" => 1, "precio" => 9.99],
        ["nombre" => "Comida para gato", "cantidad" => 2, "precio" => 6.50]
    ],
    "total" => 9.99 + (2 * 6.50)
];

$bulk = new MongoDB\Driver\BulkWrite();
$bulk->insert($pedido);
$manager->executeBulkWrite("tiendaonline.pedidos", $bulk);


$query = new MongoDB\Driver\Query(
    [],                 
    ['limit' => 1]      
);

$cursor = $manager->executeQuery('tiendaonline.pedidos', $query);

foreach ($cursor as $doc) {
    echo "Primer pedido encontrado:\n";
    var_dump($doc);
    break;
}

if (!isset($doc)) {
    echo "La colección 'pedidos' está vacía\n";
}

