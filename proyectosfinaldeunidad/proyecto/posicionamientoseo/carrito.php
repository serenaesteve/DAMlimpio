<?php
session_start();

require_once __DIR__ . '/seo.php';

$db = new SQLite3(__DIR__ . '/recortables.db');

function h($s): string {
  return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function img_path(string $p): string {
  $p = trim((string)$p);
  if ($p === '') return '';
  if (preg_match('#^(https?://|data:)#i', $p)) return $p;

  $p = ltrim($p, '/');

  if (file_exists(__DIR__ . '/' . $p)) return $p;
  if (file_exists(__DIR__ . '/img/' . $p)) return 'img/' . $p;

  return $p;
}

/* Resolver ruta local (para ZIP). Devuelve path absoluto o '' */
function img_local_abspath(string $img): string {
  $img = trim((string)$img);
  if ($img === '') return '';
  if (preg_match('#^(https?://|data:)#i', $img)) return '';

  $img = ltrim($img, '/');

  $candidates = [
    __DIR__ . '/' . $img,
    __DIR__ . '/img/' . $img,
  ];

  foreach ($candidates as $c) {
    if (file_exists($c)) return $c;
  }
  return '';
}

/* =======================
   CARRITO (SESSION)
======================= */
if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
  $_SESSION['carrito'] = [];
}

// Añadir (desde producto)
if (isset($_GET['add'])) {
  $id = (int)$_GET['add'];
  if ($id > 0) {
    $_SESSION['carrito'][$id] = ($_SESSION['carrito'][$id] ?? 0) + 1;
  }
  header('Location: carrito.php');
  exit;
}

// Incrementar (+) desde carrito
if (isset($_GET['inc'])) {
  $id = (int)$_GET['inc'];
  if ($id > 0) {
    $_SESSION['carrito'][$id] = ($_SESSION['carrito'][$id] ?? 0) + 1;
  }
  header('Location: carrito.php');
  exit;
}

// Decrementar (-) desde carrito
if (isset($_GET['dec'])) {
  $id = (int)$_GET['dec'];
  if ($id > 0 && isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id] = max(0, (int)$_SESSION['carrito'][$id] - 1);
    if ($_SESSION['carrito'][$id] <= 0) {
      unset($_SESSION['carrito'][$id]);
    }
  }
  header('Location: carrito.php');
  exit;
}

// Eliminar producto (quita el item completo)
if (isset($_GET['eliminar'])) {
  $id = (int)$_GET['eliminar'];
  if ($id > 0 && isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
  }
  header('Location: carrito.php');
  exit;
}

// Vaciar
if (isset($_GET['vaciar'])) {
  $_SESSION['carrito'] = [];
  header('Location: carrito.php');
  exit;
}

$carrito = $_SESSION['carrito'];
$carritoCount = !empty($carrito) ? array_sum($carrito) : 0;

/* =======================
   Descargar ZIP
   (una vez por producto, aunque haya cantidad)
======================= */
if (isset($_GET['zip']) && !empty($carrito)) {
  $ids = array_keys($carrito);
  $in = implode(',', array_map('intval', $ids));

  $res = $db->query("SELECT id, nombre, imagen FROM productos WHERE id IN ($in)");

  $zip = new ZipArchive();
  $zipName = 'carrito_recortables.zip';
  $tmpZip = tempnam(sys_get_temp_dir(), 'zip_');

  if ($zip->open($tmpZip, ZipArchive::OVERWRITE) === true) {
    while ($p = $res->fetchArray(SQLITE3_ASSOC)) {
      $img = img_path((string)($p['imagen'] ?? ''));
      $abs = img_local_abspath($img);
      if ($abs !== '') {
        $zip->addFile($abs, basename($abs));
      }
    }
    $zip->close();

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.$zipName.'"');
    header('Content-Length: ' . filesize($tmpZip));
    readfile($tmpZip);
    @unlink($tmpZip);
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <?php
  seo(
    "Carrito de recortables",
    "Tu selección de recortables imprimibles.",
    canonical_url(),
    true // NOINDEX
  );
  ?>

  <link rel="stylesheet" href="styles.css" />

  <style>
    /* Ajustes mínimos para + / - */
    .qty-row{display:flex;align-items:center;justify-content:center;gap:10px;margin-top:10px}
    .qty-num{font-weight:bold;min-width:28px;text-align:center}
    .qty-btn{width:44px;height:38px;border-radius:14px;display:inline-flex;align-items:center;justify-content:center}
  </style>
</head>
<body>

<header>
  <h1>Carrito</h1>
  <p>Recortables seleccionados</p>

  <a class="cart-link" href="carrito.php" aria-label="Carrito">🛒
    <?php if ($carritoCount > 0) { ?><span class="cart-badge"><?= (int)$carritoCount ?></span><?php } ?>
  </a>
</header>

<main>
  <section>
    <?php if (empty($carrito)) { ?>
      <p style="text-align:center;">Tu carrito está vacío.</p>
      <div style="text-align:center; margin-top:20px;">
        <a class="btn" href="index.php">⬅ Volver</a>
      </div>
    <?php } else { ?>

      <?php
      $ids = array_keys($carrito);
      $in = implode(',', array_map('intval', $ids));
      $res = $db->query("SELECT id, nombre, imagen FROM productos WHERE id IN ($in) ORDER BY id DESC");
      ?>

      <div class="contenedor">
        <?php while ($p = $res->fetchArray(SQLITE3_ASSOC)) {
          $pid = (int)$p['id'];
          $qty = (int)($carrito[$pid] ?? 0);
        ?>
          <article class="destacado">
            <img src="<?= h(img_path($p['imagen'] ?? '')) ?>"
                 alt="Recortable <?= h($p['nombre'] ?? '') ?> para imprimir">
            <p><?= h($p['nombre'] ?? '') ?></p>

            <div class="qty-row">
              <a class="btn secundario qty-btn" href="carrito.php?dec=<?= $pid ?>" aria-label="Restar">−</a>
              <span class="qty-num"><?= $qty ?></span>
              <a class="btn qty-btn" href="carrito.php?inc=<?= $pid ?>" aria-label="Sumar">+</a>
            </div>

            <div style="margin-top:12px;">
              <a class="btn secundario" href="carrito.php?eliminar=<?= $pid ?>" aria-label="Eliminar">❌</a>
            </div>
          </article>
        <?php } ?>
      </div>

      <div style="text-align:center; margin-top:22px;">
        <a class="btn" href="index.php">⬅ Seguir viendo recortables</a>
        <a class="btn secundario" href="carrito.php?vaciar=1">Vaciar carrito</a>
        <a class="btn" href="carrito.php?zip=1">⬇ Descargar carrito (ZIP)</a>
      </div>

    <?php } ?>
  </section>
</main>

<footer>
  <p>© 2026 Serena Sania Esteve</p>
  <p>Proyecto realizado con HTML, CSS y PHP</p>
</footer>

</body>
</html>


