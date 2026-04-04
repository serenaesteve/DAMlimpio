<?php


$db = new PDO('sqlite:log.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$db->exec("
CREATE TABLE IF NOT EXISTS logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    timestamp INTEGER,
    user_agent TEXT,
    referer TEXT,
    accept_language TEXT,
    cookie TEXT,
    ip_address TEXT,
    request_uri TEXT,
    fecha TEXT
);
");


$epoch = $_SERVER['REQUEST_TIME'];
$dt = new DateTime("@$epoch");
$fecha = $dt->format("Y-m-d H:i:s");

// Insertar registro
$sql = "
INSERT INTO logs
(timestamp,user_agent,referer,accept_language,cookie,ip_address,request_uri,fecha)
VALUES
(
'".$_SERVER['REQUEST_TIME']."',
'".$_SERVER['HTTP_USER_AGENT']."',
'".$_SERVER['HTTP_REFERER']."',
'".$_SERVER['HTTP_ACCEPT_LANGUAGE']."',
'".$_SERVER['HTTP_COOKIE']."',
'".$_SERVER['REMOTE_ADDR']."',
'".$_SERVER['REQUEST_URI']."',
'".$fecha."'
)
";

$db->exec($sql);

echo "Registro guardado correctamente";

?>
