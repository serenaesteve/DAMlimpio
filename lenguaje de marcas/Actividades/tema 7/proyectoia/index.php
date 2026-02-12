<?php
declare(strict_types=1);

$asset = $_GET['asset'] ?? '';

if ($asset === 'robots') {
  header('Content-Type: text/plain; charset=utf-8');
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  echo "User-agent: *\n";
  echo "Allow: /\n";
  echo "Sitemap: https://{$host}/?asset=sitemap\n";
  exit;
}

if ($asset === 'sitemap') {
  header('Content-Type: application/xml; charset=utf-8');
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $date = gmdate('Y-m-d');
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
  echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
  echo "<url><loc>https://{$host}/</loc><lastmod>{$date}</lastmod></url>";
  echo "</urlset>";
  exit;
}

$template = file_get_contents('plantillaSEO.html');
$data = json_decode(file_get_contents('datos.json'), true);

foreach ($data as $k => $v) {
  if (is_string($v)) {
    $template = str_replace('{{'.$k.'}}', htmlspecialchars($v, ENT_QUOTES), $template);
  }
}

echo $template;

