<?php
declare(strict_types=1);

function seo(string $title, string $description, ?string $canonical = null, bool $noindex = false): void {
  echo "<title>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</title>\n";
  echo '<meta name="description" content="' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . '">' . "\n";

  if ($canonical) {
    echo '<link rel="canonical" href="' . htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') . '">' . "\n";
  }

  if ($noindex) {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
  }
}


function canonical_url(): string {
  $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
  $scheme = $https ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $uri = $_SERVER['REQUEST_URI'] ?? '/';
  $uri = explode('#', $uri, 2)[0];
  return $scheme . '://' . $host . $uri;
}

