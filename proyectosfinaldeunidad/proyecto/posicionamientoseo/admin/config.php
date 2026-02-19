<?php
// admin/config.php
declare(strict_types=1);

// Ruta a tu BD (en la raíz del proyecto)
define('DB_PATH', dirname(__DIR__) . '/recortables.db');

// Usuario/clave del admin (cámbialo)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123');

function db(): SQLite3 {
  $db = new SQLite3(DB_PATH);
  $db->busyTimeout(3000);
  return $db;
}

function h($s): string {
  return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}


$script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/admin/index.php');
$base = dirname(dirname($script)); // sube desde /admin/archivo.php a /
$base = rtrim($base, '/');
define('BASE_URL', $base === '' ? '/' : $base);

define('ADMIN_URL', rtrim(BASE_URL, '/') . '/admin');

