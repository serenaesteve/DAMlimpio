<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin();
require_once __DIR__ . '/config.php';

// Solo permitir POST (acción destructiva)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: index.php');
  exit;
}

verify_csrf((string)($_POST['csrf_token'] ?? ''));

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
  header('Location: index.php');
  exit;
}

$db = db();
$st = $db->prepare("DELETE FROM productos WHERE id = :id");
$st->bindValue(':id', $id, SQLITE3_INTEGER);
$st->execute();

header('Location: index.php');
exit;

