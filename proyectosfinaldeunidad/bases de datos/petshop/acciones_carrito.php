<?php
require_once "inc/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: carrito.php");
  exit;
}

csrf_check();
cart_init();

$accion = $_POST['accion'] ?? 'add';
$id = (int)($_POST['id'] ?? 0);
$qty = (int)($_POST['qty'] ?? 1);

if ($accion === 'clear') {
  cart_clear();
  flash_set("Carrito vaciado");
  header("Location: carrito.php");
  exit;
}

if ($id <= 0) {
  flash_set("Producto inválido", "bad");
  header("Location: index.php");
  exit;
}

$actual = (int)($_SESSION['cart'][$id] ?? 0);

switch ($accion) {
  case 'add':
    if ($qty < 1) $qty = 1;
    $_SESSION['cart'][$id] = $actual + $qty;
    break;

  case 'inc':
    $_SESSION['cart'][$id] = $actual + 1;
    break;

  case 'dec':
    $nuevo = $actual - 1;
    if ($nuevo <= 0) unset($_SESSION['cart'][$id]);
    else $_SESSION['cart'][$id] = $nuevo;
    break;

  case 'set':
    if ($qty <= 0) unset($_SESSION['cart'][$id]);
    else $_SESSION['cart'][$id] = $qty;
    break;

  case 'remove':
    unset($_SESSION['cart'][$id]);
    break;
}

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "carrito.php"));
exit;

