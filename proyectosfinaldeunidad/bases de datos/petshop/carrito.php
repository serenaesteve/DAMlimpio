<?php
require_once "inc/repos.php";
cart_init();
require_once "header.php";
?>
<h2>Carrito</h2>
<ul>
<?php foreach($_SESSION['cart'] as $id=>$qty): ?>
  <li>Producto <?= $id ?> x <?= $qty ?></li>
<?php endforeach; ?>
</ul>
<a href="checkout.php">Finalizar compra</a>
<?php require_once "footer.php"; ?>

