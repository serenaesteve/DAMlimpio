<?php
// admin/auth.php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/config.php';

function require_admin(): void {
  if (empty($_SESSION['admin_ok'])) {
    header('Location: login.php');
    exit;
  }
}

function csrf_token(): string {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function verify_csrf(string $token): void {
  $sess = $_SESSION['csrf_token'] ?? '';
  if ($sess === '' || !hash_equals($sess, $token)) {
    http_response_code(403);
    exit('CSRF token inválido');
  }
}

