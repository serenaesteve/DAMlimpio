<?php
session_start();


$languages = [
    "es" => "Español 🇪🇸",
    "en" => "English 🇬🇧",
    "fr" => "Français 🇫🇷",
    "de" => "Deutsch 🇩🇪",
    "it" => "Italiano 🇮🇹",
    "pt" => "Português 🇵🇹",
    "nl" => "Nederlands 🇳🇱",
    "sv" => "Svenska 🇸🇪",
    "da" => "Dansk 🇩🇰",
    "fi" => "Suomi 🇫🇮",
    "no" => "Norsk 🇳🇴"
];


if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = "es";
}


if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $languages)) {
    $_SESSION['lang'] = $_GET['lang'];
}

$currentLang = $_SESSION['lang'];


$lang = [];

$csvPath = __DIR__ . "/idiomas.csv";
$fh = fopen($csvPath, "r");
if ($fh === false) {
    http_response_code(500);
    die("Cannot open translation file: " . htmlspecialchars($csvPath));
}


$headers = fgetcsv($fh);
if ($headers === false) {
    fclose($fh);
    http_response_code(500);
    die("Translation CSV is empty or invalid.");
}

$baseIndex = array_search("es", $headers, true);
$currentIndex = array_search($currentLang, $headers, true);

if ($baseIndex === false) {
    fclose($fh);
    http_response_code(500);
    die('Translation CSV must include an "es" column header.');
}


if ($currentIndex === false) {
    $currentIndex = $baseIndex;
}

while (($row = fgetcsv($fh)) !== false) {
    if (!isset($row[$baseIndex])) {
        continue;
    }

    $key = $row[$baseIndex];


    $value = $row[$currentIndex] ?? ($row[$baseIndex] ?? $key);

    $lang[$key] = $value;
}

fclose($fh);

function selectorIdioma(){
    global $languages, $currentLang;

    echo '<select id="idioma">';
    foreach ($languages as $code => $label){
        echo '<option value="'.htmlspecialchars($code).'"';
        if ($code === $currentLang) {
            echo ' selected';
        }
        echo '>'.$label.'</option>';
    }
    echo '</select>';
}


?>





















