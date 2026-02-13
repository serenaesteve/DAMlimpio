<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config.php';


$lang = $_GET['lang'] ?? 'es';
$lang = ($lang === 'en') ? 'en' : 'es';

$TXT = [
  'es' => [
    'blogTitle' => 'Blog desde la bandeja de entrada',
    'subtitle'  => 'Cada correo se muestra como si fuera una entrada de blog.',
    'back'      => '← Volver al listado',
    'from'      => 'De',
    'readmore'  => 'Leer más →',
    'empty'     => 'No se han encontrado correos para mostrar.',
    'menuHome'  => 'Inicio',
    'menuBlog'  => 'Blog correo',
    'menuContact'=> 'Contacto'
  ],
  'en' => [
    'blogTitle' => 'Inbox Blog',
    'subtitle'  => 'Each email is shown like a blog post.',
    'back'      => '← Back to list',
    'from'      => 'From',
    'readmore'  => 'Read more →',
    'empty'     => 'No emails found to display.',
    'menuHome'  => 'Home',
    'menuBlog'  => 'Inbox blog',
    'menuContact'=> 'Contact'
  ]
];


function decodePart($content, $encoding){
  switch ($encoding) {
    case 3: return base64_decode($content);
    case 4: return quoted_printable_decode($content);
    default: return $content;
  }
}


function extractEmailParts($imap, $msgno){
  $structure = imap_fetchstructure($imap, $msgno);

  $result = [
    'html'  => null,
    'text'  => null,
    'image' => null,
  ];

  if (!isset($structure->parts)) {
    $content = imap_body($imap, $msgno);
    $content = decodePart($content, $structure->encoding ?? 0);

    if (($structure->type ?? null) == 0) {
      $subtype = isset($structure->subtype) ? strtoupper($structure->subtype) : '';
      if ($subtype === 'HTML') $result['html'] = $content;
      else $result['text'] = nl2br(htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
    }
    return $result;
  }

  traverseParts($imap, $msgno, $structure, '', $result);
  return $result;
}

function traverseParts($imap, $msgno, $structure, $prefix, &$result){
  if (!isset($structure->parts)) return;

  foreach ($structure->parts as $index => $part) {
    $partNumber = $prefix === '' ? (string)($index + 1) : $prefix . '.' . ($index + 1);

    if (isset($part->parts) && count($part->parts) > 0) {
      traverseParts($imap, $msgno, $part, $partNumber, $result);
      continue;
    }

    $type    = $part->type ?? null;
    $subtype = isset($part->subtype) ? strtoupper($part->subtype) : '';
    $content = imap_fetchbody($imap, $msgno, $partNumber);
    $content = decodePart($content, $part->encoding ?? 0);


    if ($type === 0) {
      if ($subtype === 'HTML' && $result['html'] === null) $result['html'] = $content;
      if ($subtype === 'PLAIN' && $result['text'] === null) $result['text'] = nl2br(htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
    }


    if ($type === 5 && $result['image'] === null) {
      $mimeSubtype = strtolower($subtype ?: 'jpeg');
      $mime        = 'image/' . $mimeSubtype;
      $dataUri     = 'data:' . $mime . ';base64,' . base64_encode($content);

      $result['image'] = [
        'dataUri'  => $dataUri,
        'filename' => 'imagen_' . $partNumber . '.jpg',
      ];
    }
  }
}


function makeExcerpt($html, $length){
  $text = trim(strip_tags($html));
  $text = preg_replace('/\s+/', ' ', $text);

  if (function_exists('mb_strlen') && function_exists('mb_substr')) {
    if (mb_strlen($text, 'UTF-8') <= $length) return $text;
    return mb_substr($text, 0, $length, 'UTF-8') . '…';
  }
  if (strlen($text) <= $length) return $text;
  return substr($text, 0, $length) . '…';
}


$inbox = @imap_open(IMAP_HOST, IMAP_USER, IMAP_PASS);
if (!$inbox) die('Error IMAP: ' . imap_last_error());

$selectedId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$isDetail   = $selectedId ? true : false;

if ($isDetail) $emails = [$selectedId];
else $emails = imap_search($inbox, 'ALL');
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $isDetail ? $TXT[$lang]['blogTitle'] : $TXT[$lang]['blogTitle']; ?></title>

  <style>
    :root{
      --bg: #fff7fb;
      --card: #ffffff;
      --border: #f2d6e7;
      --text: #2d2230;
      --muted: #6b5a66;
      --accent: #e88bb6;
      --accent-2: #f7c1d9;
    }
    *{box-sizing:border-box;}
    body{
      margin:0;
      font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
      background: var(--bg);
      color: var(--text);
    }
    .layout{
      max-width: 980px;
      margin: 0 auto;
      padding: 24px 16px 50px;
    }

    /* Header */
    .topbar{
      background: linear-gradient(90deg, var(--accent-2), #ffeaf4);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 16px 18px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 14px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .brand h1{
      margin:0;
      font-size: 1.35rem;
      line-height:1.15;
    }
    .brand p{
      margin:4px 0 0;
      color: var(--muted);
      font-size: 0.95rem;
    }
    .actions{
      display:flex;
      gap:10px;
      align-items:center;
      flex-wrap:wrap;
      justify-content:flex-end;
    }
    .chip{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:8px 12px;
      background: rgba(255,255,255,0.75);
      border: 1px solid var(--border);
      border-radius: 999px;
      text-decoration:none;
      color: var(--text);
      font-size: 0.9rem;
    }
    .chip:hover{border-color: var(--accent);}
    .lang{
      display:flex;
      gap:8px;
    }

    nav.menu{
      margin-top: 14px;
      display:flex;
      gap:10px;
      flex-wrap:wrap;
    }
    nav.menu a{
      text-decoration:none;
      padding:10px 14px;
      border-radius:999px;
      border:1px solid var(--border);
      background: var(--card);
      color: var(--text);
      font-size:0.92rem;
    }
    nav.menu a:hover{border-color: var(--accent);}

    /* Posts */
    .posts{
      margin-top: 18px;
      display:grid;
      gap: 16px;
    }
    article.post{
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 18px;
      overflow:hidden;
      box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }
    .post-hero{
      max-height: 260px;
      overflow:hidden;
    }
    .post-hero img{
      width:100%;
      display:block;
      object-fit:cover;
    }
    .post-content{padding: 16px 18px 18px;}
    .post-title{
      margin:0 0 6px;
      font-size: 1.1rem;
      line-height:1.25;
    }
    .post-title a{
      text-decoration:none;
      color: var(--text);
    }
    .post-title a:hover{color: var(--accent);}
    .post-meta{
      font-size: 0.85rem;
      color: var(--muted);
    }
    .post-body{
      margin-top: 10px;
      line-height: 1.6;
      font-size: 0.95rem;
    }
    .read-more{
      margin-top: 10px;
    }
    .read-more a{
      color: var(--accent);
      text-decoration:none;
      font-weight: 600;
    }

    .back-link{
      display:inline-block;
      margin-top: 16px;
      text-decoration:none;
      color: var(--accent);
      font-weight: 600;
    }

    .empty{
      margin-top: 20px;
      text-align:center;
      color: var(--muted);
    }

    @media (max-width: 700px){
      .topbar{flex-direction:column; align-items:flex-start;}
      .actions{justify-content:flex-start;}
    }
  </style>
</head>
<body>
<div class="layout">

  <header class="topbar">
    <div class="brand">
      <h1><?php echo htmlspecialchars(BRAND_NAME, ENT_QUOTES, 'UTF-8'); ?></h1>
      <p>
        <?php echo htmlspecialchars($lang === 'es' ? BRAND_TITLE_ES : BRAND_TITLE_EN, ENT_QUOTES, 'UTF-8'); ?>
        · <?php echo htmlspecialchars(BRAND_DOMAIN, ENT_QUOTES, 'UTF-8'); ?>
      </p>
    </div>

    <div class="actions">
      <a class="chip" href="<?php echo htmlspecialchars(URL_PORTFOLIO, ENT_QUOTES, 'UTF-8'); ?>" target="_blank">🌐 Portfolio</a>
      <a class="chip" href="mailto:<?php echo htmlspecialchars(BRAND_EMAIL, ENT_QUOTES, 'UTF-8'); ?>">✉ <?php echo htmlspecialchars(BRAND_EMAIL, ENT_QUOTES, 'UTF-8'); ?></a>

      <div class="lang">
        <a class="chip" href="?<?php echo $isDetail ? 'id='.(int)$selectedId.'&' : ''; ?>lang=es">ES</a>
        <a class="chip" href="?<?php echo $isDetail ? 'id='.(int)$selectedId.'&' : ''; ?>lang=en">EN</a>
      </div>
    </div>
  </header>

  <nav class="menu">
    <a href="<?php echo htmlspecialchars(URL_PORTFOLIO, ENT_QUOTES, 'UTF-8'); ?>" target="_blank"><?php echo $TXT[$lang]['menuHome']; ?></a>
    <a href="<?php echo strtok($_SERVER['REQUEST_URI'], '?'); ?>?lang=<?php echo $lang; ?>"><?php echo $TXT[$lang]['menuBlog']; ?></a>
    <a href="mailto:<?php echo htmlspecialchars(BRAND_EMAIL, ENT_QUOTES, 'UTF-8'); ?>"><?php echo $TXT[$lang]['menuContact']; ?></a>
  </nav>

  <?php if ($isDetail): ?>
    <a class="back-link" href="<?php echo strtok($_SERVER['REQUEST_URI'], '?'); ?>?lang=<?php echo $lang; ?>">
      <?php echo $TXT[$lang]['back']; ?>
    </a>
  <?php endif; ?>

  <section class="posts">
    <?php
    if ($emails) {
      if (!$isDetail) {
        rsort($emails);
        $emails = array_slice($emails, 0, 12);
      }

      foreach ($emails as $email_number) {
        $overviewList = imap_fetch_overview($inbox, $email_number, 0);
        $overview     = $overviewList[0] ?? null;
        if (!$overview) continue;

        $subject = isset($overview->subject) ? imap_utf8($overview->subject) : '(Sin asunto)';
        $from    = isset($overview->from)    ? imap_utf8($overview->from)    : '(Desconocido)';
        $date    = isset($overview->date)    ? $overview->date               : '';

        $subject_safe = htmlspecialchars($subject, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $from_safe    = htmlspecialchars($from,    ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $date_safe    = htmlspecialchars($date,    ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        $parts = extractEmailParts($inbox, $email_number);

        if ($isDetail) {
          $bodyToShow = $parts['html'] ?? $parts['text'] ?? '<em>Sin contenido legible.</em>';
        } else {
          $bodyFull   = $parts['html'] ?? $parts['text'] ?? '';
          $excerpt    = makeExcerpt($bodyFull, EXCERPT_LENGTH);
          $bodyToShow = '<p>' . htmlspecialchars($excerpt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
        }

        $image = $parts['image'];
        $detailUrl = strtok($_SERVER['REQUEST_URI'], '?') . '?id=' . (int)$email_number . '&lang=' . $lang;
        ?>
        <article class="post">
          <?php if ($image && !$isDetail): ?>
            <div class="post-hero">
              <img src="<?php echo $image['dataUri']; ?>" alt="">
            </div>
          <?php endif; ?>

          <div class="post-content">
            <h2 class="post-title">
              <a href="<?php echo $detailUrl; ?>"><?php echo $subject_safe; ?></a>
            </h2>

            <div class="post-meta">
              <?php echo $TXT[$lang]['from']; ?>: <?php echo $from_safe; ?>
              <?php if ($date_safe): ?> · <?php echo $date_safe; ?><?php endif; ?>
            </div>

            <div class="post-body"><?php echo $bodyToShow; ?></div>

            <?php if (!$isDetail): ?>
              <div class="read-more">
                <a href="<?php echo $detailUrl; ?>"><?php echo $TXT[$lang]['readmore']; ?></a>
              </div>
            <?php endif; ?>
          </div>
        </article>
        <?php

        if ($isDetail) break;
      }
    } else {
      echo '<p class="empty">'.$TXT[$lang]['empty'].'</p>';
    }

    imap_close($inbox);
    ?>
  </section>

</div>
</body>
</html>

