<?php
$c = new mysqli("localhost", "jocarsapress", "jocarsapress", "jocarsapress");
if ($c->connect_error) { die("Error de conexión"); }
$c->set_charset("utf8mb4");


function md_inline($s){
  $s = htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  $s = preg_replace('/`([^`]+)`/', '<code>$1</code>', $s);
  $s = preg_replace('/\*\*([^\*]+)\*\*/', '<strong>$1</strong>', $s);
  $s = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $s);

  $s = preg_replace_callback('/\[(.*?)\]\((.*?)\)/', function($m){
    $text = $m[1];
    $url  = $m[2];
    if (!preg_match('~^(https?://|mailto:)~i', $url)) return $text;
    $url = htmlspecialchars($url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    return '<a href="'.$url.'" class="c-brand td-none">'.$text.'</a>';
  }, $s);

  return $s;
}

function markdown_to_html($md){
  $md = str_replace(["\r\n","\r"], "\n", (string)$md);
  $lines = explode("\n", $md);

  $html = "";
  $in_ul = false;
  $in_ol = false;
  $in_pre = false;
  $pre_buf = [];

  $flush_lists = function() use (&$html, &$in_ul, &$in_ol){
    if ($in_ul) { $html .= "</ul>\n"; $in_ul = false; }
    if ($in_ol) { $html .= "</ol>\n"; $in_ol = false; }
  };

  foreach($lines as $line){
    if (preg_match('/^\s*```/', $line)) {
      if (!$in_pre) {
        $flush_lists();
        $in_pre = true;
        $pre_buf = [];
      } else {
        $code = htmlspecialchars(implode("\n", $pre_buf), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $html .= "<pre class=\"p-10 b-surface bradius-10\"><code>".$code."</code></pre>\n";
        $in_pre = false;
      }
      continue;
    }

    if ($in_pre) { $pre_buf[] = $line; continue; }

    if (trim($line) === "") { $flush_lists(); continue; }

    if (preg_match('/^(#{1,6})\s+(.*)$/', $line, $m)) {
      $flush_lists();
      $lvl = strlen($m[1]);
      $txt = md_inline(trim($m[2]));
      $html .= "<h$lvl class=\"m-0\">$txt</h$lvl>\n";
      continue;
    }

    if (preg_match('/^\s*[-\*]\s+(.*)$/', $line, $m)) {
      if ($in_ol) { $html .= "</ol>\n"; $in_ol = false; }
      if (!$in_ul) { $html .= "<ul class=\"m-0 p-0\" style=\"padding-left:18px;\">\n"; $in_ul = true; }
      $html .= "<li>".md_inline(trim($m[1]))."</li>\n";
      continue;
    }

    if (preg_match('/^\s*\d+\.\s+(.*)$/', $line, $m)) {
      if ($in_ul) { $html .= "</ul>\n"; $in_ul = false; }
      if (!$in_ol) { $html .= "<ol class=\"m-0 p-0\" style=\"padding-left:18px;\">\n"; $in_ol = true; }
      $html .= "<li>".md_inline(trim($m[1]))."</li>\n";
      continue;
    }

    if (preg_match('/^\s*>\s+(.*)$/', $line, $m)) {
      $flush_lists();
      $html .= "<blockquote class=\"p-10 b-white bradius-10\" style=\"border-left:4px solid var(--brand);\">".md_inline(trim($m[1]))."</blockquote>\n";
      continue;
    }

    $flush_lists();
    $html .= "<p class=\"m-0 lh-24\">".md_inline(trim($line))."</p>\n";
  }

  if ($in_pre) {
    $code = htmlspecialchars(implode("\n", $pre_buf), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $html .= "<pre class=\"p-10 b-surface bradius-10\"><code>".$code."</code></pre>\n";
  } else {
    $flush_lists();
  }

  $allowed = '<p><br><h1><h2><h3><h4><h5><h6><ul><ol><li><strong><em><code><pre><a><blockquote>';
  return strip_tags($html, $allowed);
}

function get_pagina_por_titulo(mysqli $c, string $titulo){
  $stmt = $c->prepare("SELECT * FROM paginas WHERE titulo = ? LIMIT 1");
  $stmt->bind_param("s", $titulo);
  $stmt->execute();
  $res = $stmt->get_result();
  return $res ? $res->fetch_assoc() : null;
}

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

$p = isset($_GET['p']) ? (string)$_GET['p'] : "";
?>
<!doctype html>
<html lang="es" class="w-100pc h-100pc p-0 m-0">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Jose Vicente Carratalá</title>

  <link rel="stylesheet" href="JVestilo/JVestilo.php">
  <link rel="stylesheet" href="JVestilo/escritorio.php">
  <link rel="stylesheet" href="estilo/estilo.css">

  <style>*{box-sizing:border-box}</style>
</head>

<body class="b-app flex fd-column fa-center p-20 ff-sans-serif">

  <header class="w-900 card p-20 flex fd-column g-16 shadow-soft">
    <div class="flex fd-column g-6">
      <h1 class="p-0 m-0 fs-32">Jose Vicente Carratalá</h1>
      <h2 class="p-0 m-0 fs-14 c-muted">Desarrollador, profesor y diseñador</h2>
    </div>

    <nav class="flex g-10 fa-center fw-wrap">
      <a href="?" class="btn btn-ghost">Inicio</a>
      <?php
        $r = $c->query("SELECT titulo FROM paginas ORDER BY titulo ASC;");
        while($f = $r->fetch_assoc()){
      ?>
        <a href="?p=<?= urlencode($f['titulo']) ?>" class="btn btn-ghost"><?= h($f['titulo']) ?></a>
      <?php } ?>
      <a href="?p=blog" class="btn btn-brand">Blog</a>
    </nav>
  </header>

  <main class="w-900 card p-20 flex fd-column g-20 shadow-soft" style="margin-top:16px;">

    <?php if(!isset($_GET['p'])){ ?>

      <section id="heroe" class="b-brand-soft bradius-16 p-20 flex fd-column g-10">
        <div class="badge">Color corporativo: teal</div>
        <h2 class="m-0 fs-22">Bienvenido</h2>
        <p class="m-0 c-muted ta-justify">
          Esta portada renderiza contenidos en <strong>Markdown</strong> desde base de datos y los muestra como HTML de forma segura.
        </p>
      </section>

      <section class="grid gc-1 d-gc-2 g-20">
        <article class="ta-center h-180 flex fd-column fa-center fj-center b-surface bradius-16">
          <h3 class="m-0">Páginas</h3>
          <p class="m-0 c-muted">Contenido editable</p>
        </article>
        <article class="ta-center h-180 flex fd-column fa-center fj-center b-surface bradius-16">
          <h3 class="m-0">Blog</h3>
          <p class="m-0 c-muted">Entradas en Markdown</p>
        </article>
      </section>

    <?php } else { ?>

      <?php if($p === "blog"){ ?>

        <h2 class="m-0 fs-20">Blog</h2>

        <section class="grid gc-1 d-gc-3 g-20">
          <?php
            $r = $c->query("SELECT * FROM entradas ORDER BY fecha DESC;");
            while($f = $r->fetch_assoc()){
          ?>
            <article class="b-surface p-16 bradius-16 flex fd-column g-10">
              <h3 class="m-0 fs-16"><?= h($f['titulo']) ?></h3>
              <time class="fs-10 c-muted"><?= h($f['fecha']) ?></time>
              <div class="markdown ta-justify"><?= markdown_to_html($f['contenido']) ?></div>
            </article>
          <?php } ?>
        </section>

      <?php } else {

        $pagina = get_pagina_por_titulo($c, $p);

        if(!$pagina){ ?>
          <section class="b-surface p-16 bradius-16">
            <h3 class="m-0">Página no encontrada</h3>
            <p class="m-0 c-muted">La página solicitada no existe.</p>
          </section>
        <?php } else { ?>

          <article class="flex fd-column g-12">
            <h2 class="m-0 fs-22"><?= h($pagina['titulo']) ?></h2>
            <div class="markdown ta-justify"><?= markdown_to_html($pagina['contenido'] ?? "") ?></div>
          </article>

        <?php } ?>

      <?php } ?>

    <?php } ?>

  </main>

  <footer class="w-900 p-20 ta-center c-muted fs-10">
    © <?= date("Y") ?> — Jocarsa
  </footer>

</body>
</html>

