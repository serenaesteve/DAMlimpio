<?php
require_once "header.php";
require_once "inc/repos.php";

$productos = productos($_GET['q'] ?? '');
?>

<main class="container">

  <?php if ($flash): ?>
    <div class="flash"><?= h($flash['msg']) ?></div>
  <?php endif; ?>

  <!-- CAMBIO AQUÍ: catalogo → grid -->
  <section class="grid">
    <?php foreach($productos as $p): ?>
      <?php include "inc/product_card.php"; ?>
    <?php endforeach; ?>
  </section>

</main>

<?php require_once "footer.php"; ?>

