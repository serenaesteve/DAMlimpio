<?php
require_once "inc/bootstrap.php";
csrf_check();
cart_clear();
flash_set("Pedido realizado correctamente");
header("Location: gracias.php");

