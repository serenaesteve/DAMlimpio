<?php
declare(strict_types=1);
session_start();


const ADMIN_USER = 'admin';
const ADMIN_PASS = 'admin123'; // <-- cámbiala

$DATA_FILE = __DIR__ . '/../datos.json';

function e(string $v): string {
  return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function load_json(string $file): array {
  if (!is_file($file)) return [];
  $raw = file_get_contents($file);
  $data = json_decode($raw ?: '', true);
  return is_array($data) ? $data : [];
}

function save_json(string $file, array $data): bool {
  $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  if ($json === false) return false;
  return file_put_contents($file, $json . "\n") !== false;
}


if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: index.php');
  exit;
}


$login_error = '';

if (isset($_POST['action']) && $_POST['action'] === 'login') {
  $u = (string)($_POST['user'] ?? '');
  $p = (string)($_POST['pass'] ?? '');

  if ($u === ADMIN_USER && $p === ADMIN_PASS) {
    $_SESSION['auth'] = true;
    header('Location: index.php');
    exit;
  } else {
    $login_error = 'Usuario o contraseña incorrectos';
  }
}

$authed = !empty($_SESSION['auth']);


if (!$authed):
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin · Login</title>
  <style>
    :root{
      --bg:#0b0f17;
      --card:rgba(255,255,255,.06);
      --line:rgba(255,255,255,.12);
      --text:rgba(255,255,255,.92);
      --muted:rgba(255,255,255,.72);
      --accent:#f39a1a;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      min-height:100vh;
      display:grid;
      place-items:center;
      font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
      background:
        radial-gradient(1000px 500px at 10% -10%, rgba(243,154,26,.18), transparent 60%),
        radial-gradient(900px 500px at 90% 0%, rgba(111,143,18,.15), transparent 55%),
        var(--bg);
      color:var(--text);
    }
    .card{
      width:min(440px, 92vw);
      background:var(--card);
      border:1px solid var(--line);
      border-radius:16px;
      padding:22px;
      box-shadow:0 20px 60px rgba(0,0,0,.45);
    }
    h1{margin:0 0 6px;font-size:20px}
    p{margin:0 0 16px;color:var(--muted);font-size:13px;line-height:1.4}
    label{display:block;font-size:12px;font-weight:900;margin:10px 0 6px}
    input{
      width:100%;
      padding:12px;
      border-radius:12px;
      border:1px solid rgba(255,255,255,.16);
      background:rgba(0,0,0,.35);
      color:var(--text);
      font:inherit;
    }
    input:focus{
      outline:none;
      border-color:rgba(243,154,26,.75);
      box-shadow:0 0 0 4px rgba(243,154,26,.18);
    }
    button{
      width:100%;
      margin-top:14px;
      padding:12px 14px;
      border:0;
      border-radius:12px;
      background:var(--accent);
      font-weight:950;
      cursor:pointer;
    }
    button:hover{background:#e58c0e}
    .err{margin-top:10px;color:#ff8aa1;font-weight:800;font-size:13px}
    .hint{margin-top:10px;font-size:12px;color:rgba(255,255,255,.55)}
  </style>
</head>
<body>
  <form class="card" method="post">
    <h1>Panel de control</h1>
    <p>Accede para editar el contenido (datos.json) sin tocar el HTML.</p>

    <input type="hidden" name="action" value="login">

    <label>Usuario</label>
    <input name="user" required autocomplete="username">

    <label>Contraseña</label>
    <input name="pass" type="password" required autocomplete="current-password">

    <button type="submit">Entrar</button>

    <?php if ($login_error): ?>
      <div class="err"><?= e($login_error) ?></div>
    <?php endif; ?>

    <div class="hint">Por defecto: admin / admin123</div>
  </form>
</body>
</html>
<?php
exit;
endif;


$data  = load_json($DATA_FILE);
$error = '';
$saved = false;

if (isset($_POST['action']) && $_POST['action'] === 'save') {
  foreach ($data as $key => $value) {
    if (is_array($value) || is_object($value)) continue;
    if (isset($_POST['field'][$key])) {
      $data[$key] = (string)$_POST['field'][$key];
    }
  }

  if (save_json($DATA_FILE, $data)) $saved = true;
  else $error = 'No se pudo guardar datos.json (revisa permisos)';
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin · Editar contenido</title>

<style>
:root{
  --bg:#0b0f17;
  --card:rgba(255,255,255,.06);
  --line:rgba(255,255,255,.12);
  --text:rgba(255,255,255,.92);
  --muted:rgba(255,255,255,.72);
  --accent:#f39a1a;
}

*{ box-sizing:border-box; }

body{
  margin:0;
  font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
  background:
    radial-gradient(1000px 500px at 10% -10%, rgba(243,154,26,.18), transparent 60%),
    radial-gradient(900px 500px at 90% 0%, rgba(111,143,18,.15), transparent 55%),
    var(--bg);
  color:var(--text);
}

.wrap{
  width:min(1160px, calc(100% - 48px));
  margin:0 auto;
}

/* Header */
header{
  position:sticky;
  top:0;
  z-index:10;
  background:rgba(11,15,23,.85);
  backdrop-filter: blur(10px);
  border-bottom:1px solid var(--line);
}

.top{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:14px 0;
  gap:14px;
  flex-wrap:wrap;
}

.brand .title{
  font-size:18px;
  font-weight:950;
}
.brand .sub{
  font-size:13px;
  color:var(--muted);
}

.actions-top{
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}

.btn{
  padding:10px 14px;
  border-radius:999px;
  border:1px solid var(--line);
  background:rgba(255,255,255,.06);
  color:var(--text);
  text-decoration:none;
  font-weight:900;
  font-size:13px;
  transition:.15s;
}
.btn:hover{
  background:rgba(255,255,255,.12);
  transform:translateY(-1px);
}
.btn.primary{
  background:var(--accent);
  color:#111;
  border-color:transparent;
}
.btn.primary:hover{ background:#e58c0e; }

/* Grid */
form{ margin:0; }
.grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:14px;
  padding:18px 0 120px;
}
@media (max-width:980px){
  .wrap{ width: calc(100% - 32px); }
  .grid{ grid-template-columns:1fr; padding-bottom:140px; }
}

/* Card */
.card{
  background:var(--card);
  border:1px solid var(--line);
  border-radius:14px;
  padding:14px;
  box-shadow:0 18px 50px rgba(0,0,0,.35);
  display:flex;
  flex-direction:column;
  gap:8px;
  min-height:108px;
}

label{
  font-size:12px;
  font-weight:950;
  letter-spacing:.2px;
}

input, textarea{
  width:100%;
  padding:12px;
  border-radius:12px;
  border:1px solid rgba(255,255,255,.16);
  background:rgba(0,0,0,.35);
  color:var(--text);
  font:inherit;
}
textarea{ min-height:110px; resize:vertical; }

input:focus, textarea:focus{
  outline:none;
  border-color:rgba(243,154,26,.75);
  box-shadow:0 0 0 4px rgba(243,154,26,.18);
}

/* Save bar */
.save-bar{
  position:fixed;
  bottom:0;
  left:0;
  right:0;
  background:linear-gradient(to top, rgba(11,15,23,.95), rgba(11,15,23,.6));
  border-top:1px solid var(--line);
  padding:12px 0;
}
.save-inner{
  display:flex;
  gap:14px;
  align-items:center;
  flex-wrap:wrap;
}
button{
  padding:12px 16px;
  border-radius:12px;
  border:0;
  background:var(--accent);
  font-weight:950;
  cursor:pointer;
  color:#111;
}
button:hover{ background:#e58c0e; }

.msg{ font-size:13px; color:var(--muted); }
.ok{ color:#7CFFB2; font-weight:900; }
.bad{ color:#ff8aa1; font-weight:900; }
</style>
</head>

<body>

<header>
  <div class="wrap top">
    <div class="brand">
      <div class="title">Panel de control</div>
      <div class="sub">Edita datos.json sin tocar el HTML</div>
    </div>
    <div class="actions-top">
      <a class="btn primary" href="../" target="_blank">Ver web</a>
      <a class="btn" href="?logout=1">Salir</a>
    </div>
  </div>
</header>

<main class="wrap">
  <form method="post">
    <input type="hidden" name="action" value="save">

    <div class="grid">
      <?php foreach ($data as $key => $value): ?>
        <?php if (is_array($value) || is_object($value)) continue; ?>
        <div class="card">
          <label><?= e($key) ?></label>
          <?php
            $val = (string)$value;
            $isLong = strlen($val) > 120 || str_contains($val, "\n");
          ?>
          <?php if ($isLong): ?>
            <textarea name="field[<?= e($key) ?>]"><?= e($val) ?></textarea>
          <?php else: ?>
            <input type="text" name="field[<?= e($key) ?>]" value="<?= e($val) ?>">
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="save-bar">
      <div class="wrap save-inner">
        <button type="submit">Guardar cambios</button>
        <?php if ($saved): ?><span class="msg ok">✔ Cambios guardados</span><?php endif; ?>
        <?php if ($error): ?><span class="msg bad"><?= e($error) ?></span><?php endif; ?>
      </div>
    </div>

  </form>
</main>

</body>
</html>
