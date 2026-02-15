<?php

$active = $active ?? "";
?>

<nav class="sidebar f-1 b-teal p-20 flex fd-column g-15">

  <div class="c-white fs-22 fw-bold">Admin</div>
  <div class="c-white fs-12" style="opacity:.85;">Panel de control</div>

  <a class="navlink b-white p-10 c-teal td-none <?php echo ($active==='clientes')?'active':''; ?>" href="clientes.php">Clientes</a>
  <a class="navlink b-white p-10 c-teal td-none <?php echo ($active==='productos')?'active':''; ?>" href="productos.php">Productos</a>
  <a class="navlink b-white p-10 c-teal td-none <?php echo ($active==='pedidos')?'active':''; ?>" href="pedidos.php">Pedidos</a>
  <a class="navlink b-white p-10 c-teal td-none <?php echo ($active==='almacen')?'active':''; ?>" href="almacen.php">Almacén</a>

  <div class="f-1"></div>

  <a class="navlink b-white p-10 c-red td-none" href="logout.php">Salir</a>
</nav>

