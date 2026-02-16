<?php
require_once "inc/bootstrap.php";
require_once "header.php";
?>
<h2>Finalizar compra</h2>
<form action="confirmar.php" method="post">
  <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
  <input name="nombre" placeholder="Nombre" required>
  <input name="email" placeholder="Email" required>
  <button>Confirmar</button>
</form>
<?php require_once "footer.php"; ?>

