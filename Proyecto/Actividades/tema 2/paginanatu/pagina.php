<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function h($s){
  return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function safe_path($rel){
  $rel = (string)$rel;
  if (!preg_match('/^[a-zA-Z0-9_\-\/\.]+$/', $rel) || str_contains($rel, '..')) return "";
  return __DIR__ . '/' . ltrim($rel, '/');
}

function safe_img_src($src){
  $src = trim((string)$src);
  if ($src === "") return "";
  if (str_contains($src, '..')) return "";
  if (preg_match('#^https?://#i', $src)) return $src;
  if (!preg_match('/^[a-zA-Z0-9_\-\/\.\%\=\?\&]+$/', $src)) return "";
  return $src;
}


$defaultRel = "paginas/".($_GET['p'] ?? "").".xml";
$relFile = $_GET['file'] ?? $defaultRel;
$xmlPath = safe_path($relFile);

if ($xmlPath === "" || !file_exists($xmlPath)) {
  die("XML no encontrado");
}

$xml = simplexml_load_file($xmlPath);


$cats = [];
if (file_exists("db/categorias.json")) {
  $cats = json_decode(file_get_contents("db/categorias.json"), true);
  if (!is_array($cats)) $cats = [];
}

$footerJson = [];
if (file_exists("db/piedepagina.json")) {
  $footerJson = json_decode(file_get_contents("db/piedepagina.json"), true);
  if (!is_array($footerJson)) $footerJson = [];
}


$title = (string)($xml->meta->title ?? $xml->hero->title ?? "Página");
$subtitle = (string)($xml->hero->subtitle ?? "");

$heroImg = [
  'src' => (string)($xml->hero->media->image['src'] ?? ''),
  'alt' => (string)($xml->hero->media->image['alt'] ?? '')
];

$badges = [];
if (isset($xml->hero->badges->badge)) {
  foreach ($xml->hero->badges->badge as $b) {
    $badges[] = (string)$b;
  }
}

$actions = [];
if (isset($xml->hero->actions->action)) {
  foreach ($xml->hero->actions->action as $a) {
    $actions[] = [
      'type' => (string)($a['type'] ?? ''),
      'text' => (string)$a,
      'href' => (string)($a['href'] ?? '')
    ];
  }
}

$sections = [];
if (isset($xml->sections->section)) {
  foreach ($xml->sections->section as $s) {

    $items = [];
    if (isset($s->items->item)) {
      foreach ($s->items->item as $it) $items[] = (string)$it;
    }

    $cards = [];
    if (isset($s->cards->card)) {
      foreach ($s->cards->card as $c) {
        $cards[] = [
          'title' => (string)$c->title,
          'text'  => (string)$c->text
        ];
      }
    }

    $faqs = [];
    if (isset($s->faq->qa)) {
      foreach ($s->faq->qa as $qa) {
        $faqs[] = [
          'q' => (string)$qa->q,
          'a' => (string)$qa->a
        ];
      }
    }

    $sections[] = [
      'id' => (string)$s['id'],
      'layout' => (string)$s['layout'],
      'title' => (string)$s->title,
      'subtitle' => (string)$s->subtitle,
      'text' => (string)$s->text,
      'image' => [
        'src' => (string)($s->media->image['src'] ?? ''),
        'alt' => (string)($s->media->image['alt'] ?? '')
      ],
      'items' => $items,
      'cards' => $cards,
      'faqs' => $faqs
    ];
  }
}

function render_image($img){
  $src = safe_img_src($img['src']);
  if ($src === "") return;
  echo '<div class="articleMedia">';
  echo '<img src="'.h($src).'" alt="'.h($img['alt']).'">';
  echo '</div>';
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= h($title) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <style>
    @font-face {font-family:Ubuntu;src:url(estilo/Ubuntu-R.ttf);}
    @font-face {font-family:UbuntuB;src:url(estilo/Ubuntu-B.ttf);}
    html{scroll-behavior:smooth;}

    body{
      margin:0;
      font-family:Ubuntu,sans-serif;
      background:#fff;
      color:#111;
    }

    header{
      position:sticky;
      top:0;
      display:flex;
      justify-content:center;
      gap:20px;
      padding:10px;
      background:white;
      box-shadow:0 2px 4px rgba(0,0,0,.2);
      z-index:10;
    }

    header a{
      text-decoration:none;
      color:indigo;
      font-size:11px;
      font-family:UbuntuB,Ubuntu,sans-serif;
    }

    .wrap{max-width:1100px;margin:auto;}

    .hero{text-align:center;padding:60px 20px 20px;}
    .hero h1{font-size:48px;margin:0;}
    .hero p{color:#555;}

    .badges{display:flex;justify-content:center;gap:10px;flex-wrap:wrap;}
    .badge{background:#eee;padding:6px 10px;border-radius:20px;font-size:11px;}

    .actions{margin-top:20px;}
    .btn{padding:10px 18px;border-radius:20px;border:1px solid #ccc;text-decoration:none;color:#111;font-size:12px;}
    .btn.primary{background:indigo;color:white;border-color:indigo;}

    main{padding:20px;display:grid;gap:20px;}
    article{background:#f8f8f8;border-radius:16px;overflow:hidden;}
    .articleMedia img{width:100%;height:200px;object-fit:cover;}
    .articleBody{padding:20px;text-align:center;}

    .card{border:1px solid #ccc;border-radius:10px;padding:10px;margin-bottom:10px;}
    details{margin-bottom:10px;}

    footer{
      text-align:center;
      padding:20px;
      font-size:11px;
      border-top:1px solid #ccc;
    }
  </style>
</head>

<body>

<header>
 
  <a href="pagina.php?p=<?= h($_GET['p'] ?? '') ?>">
    <?= h($title) ?>
  </a>

  <?php foreach($cats as $c){ ?>
    <a href="pagina.php?p=<?= h(strtolower($c)) ?>"><?= h($c) ?></a>
  <?php } ?>
</header>

<section class="hero">
  <div class="wrap">
    <?php if($heroImg['src'] !== ""){ ?>
      <img src="<?= h($heroImg['src']) ?>" alt="<?= h($heroImg['alt']) ?>" style="width:100%;max-height:240px;object-fit:cover;border-radius:16px;">
    <?php } ?>

    <h1><?= h($title) ?></h1>
    <p><?= h($subtitle) ?></p>

    <div class="badges">
      <?php foreach($badges as $b){ ?><span class="badge"><?= h($b) ?></span><?php } ?>
    </div>

    <div class="actions">
      <?php foreach($actions as $a){ 
        $cls = ($a['type']==='primary') ? 'btn primary' : 'btn';
      ?>
        <a class="<?= $cls ?>" href="<?= h($a['href']) ?>"><?= h($a['text']) ?></a>
      <?php } ?>
    </div>
  </div>
</section>

<main class="wrap">
  <?php foreach($sections as $sec){ ?>
    <article id="<?= h($sec['id']) ?>">
      <?php render_image($sec['image']); ?>
      <div class="articleBody">
        <h3><?= h($sec['title']) ?></h3>
        <p><?= h($sec['subtitle']) ?></p>

        <?php if($sec['layout']==="text"){ ?>
          <p><?= h($sec['text']) ?></p>

        <?php } elseif($sec['layout']==="list"){ ?>
          <p><?= h($sec['text']) ?></p>
          <ul>
            <?php foreach($sec['items'] as $it){ ?><li><?= h($it) ?></li><?php } ?>
          </ul>

        <?php } elseif($sec['layout']==="cards"){ ?>
          <?php foreach($sec['cards'] as $c){ ?>
            <div class="card">
              <b><?= h($c['title']) ?></b>
              <p><?= h($c['text']) ?></p>
            </div>
          <?php } ?>

        <?php } elseif($sec['layout']==="faq"){ ?>
          <?php foreach($sec['faqs'] as $qa){ ?>
            <details>
              <summary><?= h($qa['q']) ?></summary>
              <p><?= h($qa['a']) ?></p>
            </details>
          <?php } ?>
        <?php } ?>
      </div>
    </article>
  <?php } ?>
</main>

<footer>
  Página creada con XML y PHP – 1º DAM
</footer>

</body>
</html>

