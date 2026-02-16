<?php
require_once __DIR__ . '/../inc/bootstrap.php';
unset($_SESSION['admin']);
flash_set('Sesión cerrada');
header('Location: login.php');
exit;

