<?php
declare(strict_types=1);
require_once __DIR__ . "/inc/bootstrap.php";
$flash = flash_get();
cart_init();
$cartCount = array_sum($_SESSION['cart']);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= h(APP_NAME) ?></title>
  <link rel="stylesheet" href="<?= h(base_url('public/estilo.css')) ?>">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?= h(base_url('index.php')) ?>">
      <span class="logo">🐾</span>
      <span><?= h(APP_NAME) ?></span>
    </a>

    <form class="search" action="<?= h(base_url('catalogo.php')) ?>" method="get">
      <input type="search" name="q" placeholder="Buscar pienso, juguetes, arneses..." value="<?= h($_GET['q'] ?? '') ?>">
      <button type="submit">Buscar</button>
    </form>

    <nav class="nav">
      <a href="<?= h(base_url('catalogo.php')) ?>">Catálogo</a>
      <a class="cart-link" href="<?= h(base_url('carrito.php')) ?>">Carrito <span class="badge"><?= (int)$cartCount ?></span></a>
    </nav>
  </div>
</header>

<main class="container">
<?php if ($flash): ?>
  <div class="flash <?= h($flash['type']) ?>"><?= h($flash['msg']) ?></div>
<?php endif; ?>

