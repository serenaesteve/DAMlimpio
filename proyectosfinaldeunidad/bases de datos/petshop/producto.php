<?php
require_once "inc/repos.php";
$id = (int)($_GET['id'] ?? 0);
$p = producto_por_id($id);
require_once "header.php";
?>
<section class="producto">
  <h2><?= h($p['titulo']) ?></h2>
  <p><?= h($p['descripcion']) ?></p>
  <p><?= money($p['precio']) ?></p>
  <form action="acciones_carrito.php" method="post">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    <input type="hidden" name="id" value="<?= $p['id'] ?>">
    <button>Añadir al carrito</button>
  </form>
</section>
<?php require_once "footer.php"; ?>

