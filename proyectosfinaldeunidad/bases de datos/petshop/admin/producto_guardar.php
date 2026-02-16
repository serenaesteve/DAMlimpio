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

$d = [
  'categoria_id' => (int)($_POST['categoria_id'] ?? 0),
  'titulo' => trim((string)($_POST['titulo'] ?? '')),
  'descripcion' => trim((string)($_POST['descripcion'] ?? '')),
  'precio' => (float)($_POST['precio'] ?? 0),
  'stock' => (int)($_POST['stock'] ?? 0),
  'destacado' => (int)($_POST['destacado'] ?? 0),
  'imagen' => null,
];

if ($d['categoria_id'] <= 0 || $d['titulo'] === '' || $d['descripcion'] === '') {
  flash_set('Faltan datos', 'bad');
  header('Location: producto_form.php' . ($id ? '?id='.$id : ''));
  exit;
}

$imgPath = null;
if (!empty($_FILES['imagen']['name']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
  $dir = __DIR__ . '/../public/img/productos';
  if (!is_dir($dir)) mkdir($dir, 0755, true);

  $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
  if (!in_array($ext, ['jpg','jpeg','png','webp'], true)) $ext = 'jpg';

  $safe = preg_replace('/[^a-z0-9\-]+/i', '-', $d['titulo']);
  $safe = trim($safe, '-');
  $filename = $safe . '-' . time() . '.' . $ext;

  move_uploaded_file($_FILES['imagen']['tmp_name'], $dir . '/' . $filename);
  $imgPath = 'public/img/productos/' . $filename;
}

if ($id > 0) {
  $old = producto_por_id($id);
  $d['imagen'] = $imgPath ?: ($old['imagen'] ?? null);
  producto_actualizar($id, $d);
  flash_set('Producto actualizado');
} else {
  $d['imagen'] = $imgPath;
  producto_crear($d);
  flash_set('Producto creado');
}

header('Location: productos.php');
exit;

