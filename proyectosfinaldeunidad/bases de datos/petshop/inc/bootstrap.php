<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function money(float $n): string {
    return number_format($n, 2, ',', '.') . ' €';
}

function base_url(string $path = ''): string {
    // Si BASE_URL está vacío, devuelve rutas relativas
    $base = rtrim((string)BASE_URL, '/');
    $path = ltrim($path, '/');
    return ($base === '') ? $path : $base . '/' . $path;
}

/* ===== Flash messages ===== */
function flash_set(string $msg, string $type='ok'): void {
    $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
}
function flash_get(): ?array {
    if (!isset($_SESSION['flash'])) return null;
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}

/* ===== Carrito ===== */
function cart_init(): void {
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}
function cart_add(int $id, int $qty = 1): void {
    cart_init();
    if ($qty < 1) $qty = 1;
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
}
function cart_clear(): void {
    $_SESSION['cart'] = [];
}

/* ===== CSRF ===== */
function csrf_check(): void {
    $t = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', (string)$t)) {
        http_response_code(400);
        exit('CSRF inválido');
    }
}

