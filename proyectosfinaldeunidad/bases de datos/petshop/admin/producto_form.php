<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../inc/repos.php';
require_once __DIR__ . '/admin_guard.php';
admin_require();

$id = (int)($_GET['id'] ?? 0);
$cats = categorias();
$p = $id ? producto_por_id($id) : null;

$flash = flash_get();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - <?= $id ? 'Editar' : 'Nuevo' ?> producto</title>
  <link rel="stylesheet" href="../public/estilo.css">
</head>
<body>
<main class="container" style="max-width:860px; margin-top:20px">

  <?php if ($flash): ?>
    <div class="flash <?= h($flash['type']) ?>"><?= h($flash['msg']) ?></div>
  <?php endif; ?>

  <div class="card pad">
    <h2 style="margin-top:0"><?= $id ? 'Editar' : 'Nuevo' ?> producto</h2>

    <form class="form" action="producto_guardar.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
      <input type="hidden" name="id" value="<?= $id ?>">

      <label>Categoría</label>
      <select name="categoria_id" required>
        <?php foreach($cats as $c): ?>
          <option value="<?= (int)$c['id'] ?>" <?= $p && (int)$p['categoria_id']===(int)$c['id'] ? 'selected' : '' ?>>
            <?= h($c['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label>Título</label>
      <input name="titulo" value="<?= h($p['titulo'] ?? '') ?>" required>

      <label>Descripción</label>
      <textarea name="descripcion" rows="4" required><?= h($p['descripcion'] ?? '') ?></textarea>

      <div class="split">
        <div>
          <label>Precio (€)</label>
          <input name="precio" type="number" step="0.01" value="<?= h((string)($p['precio'] ?? '0')) ?>" required>
        </div>
        <div>
          <label>Stock</label>
          <input name="stock" type="number" value="<?= h((string)($p['stock'] ?? '0')) ?>" required>
        </div>
      </div>

      <label>Destacado</label>
      <select name="destacado">
        <option value="0" <?= (!$p || (int)$p['destacado']===0) ? 'selected' : '' ?>>No</option>
        <option value="1" <?= ($p && (int)$p['destacado']===1) ? 'selected' : '' ?>>Sí</option>
      </select>

      <label>Imagen (subir archivo)</label>
      <input type="file" name="imagen" accept="image/*">

      <?php if ($p && !empty($p['imagen'])): ?>
        <p class="muted">Actual: <?= h($p['imagen']) ?></p>
      <?php endif; ?>

      <div style="display:flex; gap:10px; flex-wrap:wrap">
        <button class="btn primary" type="submit">Guardar</button>
        <a class="btn" href="productos.php">Cancelar</a>
      </div>
    </form>
  </div>

</main>
</body>
</html>

