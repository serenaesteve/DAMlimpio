<?php
cart_init();

$img = trim((string)($p['imagen'] ?? ''));
$placeholder = 'public/img/productos/placeholder.jpg';

// comprobamos en disco (ruta física)
$img_fs = __DIR__ . '/../' . ($img !== '' ? $img : $placeholder);
if ($img === '' || !is_file($img_fs)) {
  $img = $placeholder;
}

$enCarrito = (int)($_SESSION['cart'][(int)$p['id']] ?? 0);
?>

<article class="product">
  <a class="imgwrap" href="<?= h(base_url('producto.php?id='.(int)$p['id'])) ?>">
    <img class="img"
         src="<?= h(base_url($img)) ?>"
         alt="<?= h($p['titulo']) ?>">
  </a>

  <div class="body">
    <div class="muted"><?= h($p['categoria'] ?? '') ?></div>
    <p class="title"><?= h($p['titulo']) ?></p>

    <div class="muted">
      <?= h(mb_strimwidth((string)$p['descripcion'], 0, 70, '…', 'UTF-8')) ?>
    </div>

    <div class="row">
      <span class="price"><?= h(money((float)$p['precio'])) ?></span>
      <span class="muted">En carrito: <?= $enCarrito ?></span>
    </div>

    <div class="qtybar">
      <form action="acciones_carrito.php" method="post">
        <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
        <input type="hidden" name="accion" value="dec">
        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
        <button class="btn">−</button>
      </form>

      <div class="qty"><?= $enCarrito ?></div>

      <form action="acciones_carrito.php" method="post">
        <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
        <input type="hidden" name="accion" value="inc">
        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
        <button class="btn">+</button>
      </form>
    </div>
  </div>
</article>



