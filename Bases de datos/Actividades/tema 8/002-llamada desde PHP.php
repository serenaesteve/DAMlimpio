<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function h($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$defaultProfile = [
  "ciudad" => "Madrid",
  "presupuesto" => "medio",
  "tiempo_disponible" => "tarde",
  "preferencias" => ["cultural", "tranquilo"],
  "hobbies" => [
    "juegos_de_mesa" => ["Catan", "Carcassonne"],
    "series_peliculas" => ["ciencia ficción", "misterio"],
    "videojuegos" => ["aventura", "RPG"]
  ]
];

$ciudad = $_POST["ciudad"] ?? $defaultProfile["ciudad"];
$presupuesto = $_POST["presupuesto"] ?? $defaultProfile["presupuesto"];
$tiempo = $_POST["tiempo"] ?? $defaultProfile["tiempo_disponible"];
$hobbyMesa = $_POST["hobbyMesa"] ?? implode(", ", $defaultProfile["hobbies"]["juegos_de_mesa"]);
$hobbySeries = $_POST["hobbySeries"] ?? implode(", ", $defaultProfile["hobbies"]["series_peliculas"]);
$hobbyVideojuegos = $_POST["hobbyVideojuegos"] ?? implode(", ", $defaultProfile["hobbies"]["videojuegos"]);

$userProfile = [
  "ciudad" => trim($ciudad),
  "presupuesto" => trim($presupuesto),
  "tiempo_disponible" => trim($tiempo),
  "hobbies" => [
    "juegos_de_mesa" => array_values(array_filter(array_map("trim", explode(",", $hobbyMesa)))),
    "series_peliculas" => array_values(array_filter(array_map("trim", explode(",", $hobbySeries)))),
    "videojuegos" => array_values(array_filter(array_map("trim", explode(",", $hobbyVideojuegos))))
  ]
];


$defaultPrompt =
"Actúa como recomendador de actividades y lugares.
Con el perfil del usuario, sugiere 5 planes realistas en su ciudad.
Requisitos:
- Ajustados a presupuesto y tiempo disponible.
- Integra hobbies en al menos 2 planes (juegos de mesa / series-películas / videojuegos).
- Responde SOLO con la lista y este formato por plan:

1) Título
2) Descripción (1-2 frases)
3) Por qué encaja (1 frase)
4) Coste (bajo/medio/alto)

Perfil del usuario (JSON):
" . json_encode($userProfile, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$model   = $_POST["model"]   ?? "llama3:latest";
$prompt  = $_POST["prompt"]  ?? $defaultPrompt;
$baseUrl = $_POST["baseUrl"] ?? "http://127.0.0.1:11434";

$result = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $prompt = trim($prompt);
  if ($prompt === "") $prompt = $defaultPrompt;

  $payload = [
    "model"  => $model,
    "prompt" => $prompt,
    "stream" => false,
    "options" => [
      "temperature" => 0.7
    ]
  ];

  $url = rtrim($baseUrl, "/") . "/api/generate";

  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => ["Content-Type: application/json"],
    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT        => 90,
  ]);

  $raw = curl_exec($ch);
  $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $curlErr  = curl_error($ch);
  curl_close($ch);

  if ($raw === false) {
    $result = ["ok" => false, "err" => "cURL error: " . $curlErr, "out" => ""];
  } elseif ($httpCode < 200 || $httpCode >= 300) {
    $result = ["ok" => false, "err" => "HTTP $httpCode\n$raw", "out" => ""];
  } else {
    $json = json_decode($raw, true);
    if (!is_array($json)) {
      $result = ["ok" => false, "err" => "Respuesta no-JSON:\n$raw", "out" => ""];
    } else {
      $result = ["ok" => true, "out" => (string)($json["response"] ?? ""), "err" => ""];
    }
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ollama Web (PHP → Recomendador de planes)</title>
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Arial,sans-serif;max-width:900px;margin:40px auto;padding:0 16px;line-height:1.4}
    .card{border:1px solid #e5e5e5;border-radius:12px;padding:16px;margin:16px 0}
    label{display:block;font-weight:600;margin:10px 0 6px}
    textarea,input,select{width:100%;padding:10px;border:1px solid #d6d6d6;border-radius:10px;font:inherit}
    textarea{min-height:140px}
    button{padding:10px 14px;border:0;border-radius:10px;cursor:pointer;font-weight:600}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    pre{white-space:pre-wrap;word-wrap:break-word;background:#0b0b0b;color:#f1f1f1;padding:12px;border-radius:12px;overflow:auto}
    .err{background:#fff3f3;border:1px solid #ffd0d0;color:#7a0000;padding:12px;border-radius:12px}
    @media (max-width:700px){.row{grid-template-columns:1fr}}
  </style>
</head>
<body>

<h1>Ollama Web (PHP → Recomendador de planes)</h1>

<div class="card">
  <form method="post">
    <div class="row">
      <div>
        <label for="model">Modelo</label>
        <input id="model" name="model" value="<?=h($model)?>" placeholder="llama3:latest">
      </div>
      <div>
        <label for="baseUrl">Ollama URL</label>
        <input id="baseUrl" name="baseUrl" value="<?=h($baseUrl)?>" placeholder="http://127.0.0.1:11434">
      </div>
    </div>

    <div class="row">
      <div>
        <label for="ciudad">Ciudad</label>
        <input id="ciudad" name="ciudad" value="<?=h($ciudad)?>" placeholder="Madrid">
      </div>
      <div>
        <label for="presupuesto">Presupuesto</label>
        <select id="presupuesto" name="presupuesto">
          <?php
            $opts = ["bajo","medio","alto"];
            foreach ($opts as $opt) {
              $sel = ($presupuesto === $opt) ? "selected" : "";
              echo "<option value='".h($opt)."' $sel>".h($opt)."</option>";
            }
          ?>
        </select>
      </div>
    </div>

    <label for="tiempo">Tiempo disponible</label>
    <input id="tiempo" name="tiempo" value="<?=h($tiempo)?>" placeholder="tarde / mañana / fin de semana...">

    <label for="hobbyMesa">Hobbies: juegos de mesa (separados por comas)</label>
    <input id="hobbyMesa" name="hobbyMesa" value="<?=h($hobbyMesa)?>" placeholder="Catan, Carcassonne">

    <label for="hobbySeries">Hobbies: series/películas (separados por comas)</label>
    <input id="hobbySeries" name="hobbySeries" value="<?=h($hobbySeries)?>" placeholder="ciencia ficción, misterio">

    <label for="hobbyVideojuegos">Hobbies: videojuegos (separados por comas)</label>
    <input id="hobbyVideojuegos" name="hobbyVideojuegos" value="<?=h($hobbyVideojuegos)?>" placeholder="aventura, RPG">

    <label for="prompt">Prompt (editable)</label>
    <textarea id="prompt" name="prompt"><?=h($prompt)?></textarea>

    <div style="margin-top:12px;">
      <button type="submit">Generar recomendaciones</button>
    </div>
  </form>
</div>

<?php if ($result !== null): ?>
  <div class="card">
    <h2>Respuesta</h2>
    <?php if (!$result["ok"]): ?>
      <div class="err"><?=nl2br(h($result["err"]))?></div>
    <?php else: ?>
      <pre><?=h($result["out"])?></pre>
    <?php endif; ?>
  </div>
<?php endif; ?>

<div class="card">
  <small>
    Si aparece HTTP 404/connection refused, revisa que Ollama esté activo y escuchando en esa URL/puerto.
  </small>
</div>

</body>
</html>

