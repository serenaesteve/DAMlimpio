<?php
require_once "header.php";
require_once "inc/repos.php";

$q = $_GET['q'] ?? null;
$cat = isset($_GET['cat']) ? (int)$_GET['cat'] : null;

$cats = categorias();
$productos = productos($q, $cat);
?>

<main class="container">

  <div class="card pad" style="margin:16px 0">
    <h2 style="margin:0 0 10px 0">Catálogo</h2>

    <form method="get" action="catalogo.php" style="display:flex; gap:10px; flex-wrap:wrap; align-items:end">
      <div>
        <label class="muted">Buscar</label><br>
        <input type="text" name="q" value="<?= h((string)$q) ?>" placeholder="pienso, juguetes..." />
      </div>

      <div>
        <label class="muted">Categoría</label><br>
        <select name="cat">
          <option value="">Todas</option>
          <?php foreach ($cats as $c): ?>
            <option value="<?= (int)$c['id'] ?>" <?= ($cat === (int)$c['id']) ? 'selected' : '' ?>>
              <?= h($c['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <button class="btn primary" type="submit">Filtrar</button>
      <a class="btn" href="catalogo.php">Quitar filtros</a>
    </form>
  </div>

  <section class="grid">
    <?php foreach($productos as $p): ?>
      <?php include "inc/product_card.php"; ?>
    <?php endforeach; ?>
  </section>

</main>

<?php require_once "footer.php"; ?>

