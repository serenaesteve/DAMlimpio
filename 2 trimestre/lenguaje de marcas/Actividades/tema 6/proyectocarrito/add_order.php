<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$nombre = $data['nombre'];
$direccion = $data['direccion'];
$correo = $data['correo'];
$cart = $data['cart']; 


$conn->query("INSERT INTO usuarios (nombre, direccion, correo) VALUES ('$nombre','$direccion','$correo')");
$id_usuario = $conn->insert_id;


$total = 0;
foreach($cart as $item) {
    $total += $item['precio'] * $item['cantidad'];
}


$conn->query("INSERT INTO pedidos (id_usuario, total) VALUES ($id_usuario, $total)");
$id_pedido = $conn->insert_id;


foreach($cart as $item) {
    $id_producto = $item['id'];
    $cantidad = $item['cantidad'];
    $precio = $item['precio'];
    $conn->query("INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio) VALUES ($id_pedido, $id_producto, $cantidad, $precio)");
}

echo json_encode(["success" => true, "pedido_id" => $id_pedido]);
?>

