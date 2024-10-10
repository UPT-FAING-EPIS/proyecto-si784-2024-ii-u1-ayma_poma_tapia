<?php
require_once __DIR__ . 'vendor/autoload.php'; 

require_once("Config/Config.php");
require_once("Helpers/Helpers.php");

$url = isset($_GET['url']) ? $_GET['url'] : "Home/home";
$arrUrl = explode("/", $url);
$controller = $arrUrl[0];
$methop = $arrUrl[0]; // Parece que hay un error tipográfico aquí, debería ser 'method'
$params = "";

if (isset($arrUrl[1]) && $arrUrl[1] != "") {
    $methop = $arrUrl[1];
}

if (isset($arrUrl[2]) && $arrUrl[2] != "") {
    for ($i = 2; $i < count($arrUrl); $i++) {
        $params .= $arrUrl[$i] . ',';
    }
    $params = trim($params, ',');
}

// Asegúrate de que estas clases existan y sean autoloaded correctamente
require_once("Libraries/Core/Autoload.php");
require_once("Libraries/Core/Load.php");
?>
