<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../inc/repos.php';
require_once __DIR__ . '/admin_guard.php';
admin_require();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: productos.php');
  exit;
}
csrf_check();

$id = (int)($_POST['id'] ?? 0);
if ($id > 0) {
  producto_borrar($id);
  flash_set('Producto borrado');
}
header('Location: productos.php');
exit;

