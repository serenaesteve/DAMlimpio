<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// nombre del XML (sin extensión)
$p = $_GET['p'] ?? 'gestionacademicapro';

// ruta completa
$xmlFile = __DIR__ . "/productos/" . $p . ".xml";

// comprobar existencia
if (!file_exists($xmlFile)) {
    die("No existe el XML: " . $xmlFile);
}

// cargar XML
$xml = simplexml_load_file($xmlFile);
if (!$xml) {
    die("Error al cargar el XML");
}

function h($s){
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= h($xml->meta->title) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{margin:0;font-family:Arial;background:#f5f5f7}
    header{padding:40px;text-align:center;background:white}
    section{max-width:900px;margin:40px auto;background:white;padding:30px;border-radius:12px}
    h1,h2{text-align:center}
    ul{padding-left:20px}
    .card{border:1px solid #ddd;border-radius:10px;padding:15px;margin:10px 0}
    input,textarea{width:100%;padding:10px;margin:6px 0}
    button{padding:12px 20px;background:indigo;color:white;border:none;border-radius:999px}
  </style>
</head>

<body>

<header>
  <h1><?= h($xml->hero->name) ?></h1>
  <p><?= h($xml->hero->valueProposition) ?></p>
</header>

<section>
  <h2><?= h($xml->problem->title) ?></h2>
  <ul>
    <?php foreach($xml->problem->items->item as $i){ ?>
      <li><?= h($i) ?></li>
    <?php } ?>
  </ul>
</section>

<section>
  <h2><?= h($xml->targetAudience->title) ?></h2>
  <?php foreach($xml->targetAudience->profiles->profile as $p){ ?>
    <div class="card">
      <b><?= h($p->name) ?></b>
      <p><?= h($p->fit) ?></p>
    </div>
  <?php } ?>
</section>

<section>
  <h2><?= h($xml->faq->title) ?></h2>
  <?php foreach($xml->faq->qa as $qa){ ?>
    <div class="card">
      <b><?= h($qa->q) ?></b>
      <p><?= h($qa->a) ?></p>
    </div>
  <?php } ?>
</section>

<section>
  <h2><?= h($xml->finalCTA->title) ?></h2>
  <form>
    <?php foreach($xml->finalCTA->contact->form->field as $f){ ?>
      <?php if($f['type'] == 'textarea'){ ?>
        <textarea placeholder="<?= h(ucfirst($f['name'])) ?>"></textarea>
      <?php } else { ?>
        <input type="<?= h($f['type']) ?>" placeholder="<?= h(ucfirst($f['name'])) ?>">
      <?php } ?>
    <?php } ?>
    <button>Enviar</button>
  </form>
</section>

</body>
</html>

