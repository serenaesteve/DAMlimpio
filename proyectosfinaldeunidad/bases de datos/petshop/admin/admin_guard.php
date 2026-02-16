<?php
require_once __DIR__ . '/../inc/bootstrap.php';

function admin_require(): void {
  if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
  }
}

