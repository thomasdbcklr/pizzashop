<?php

require_once("autoload.php");

session_start();

if (isset($_SESSION["winkelmandje"])) {
    $winkelmandje = unserialize($_SESSION["winkelmandje"]);
    $items = $winkelmandje->getItems();

    if (!empty($items)) {
        include('src/Oefeningen/pizzashop/presentation/bestelform.html');
    } else {
        include('src/Oefeningen/pizzashop/presentation/shopform.html');
    }
} else {
    include('src/Oefeningen/pizzashop/presentation/shopform.html');
}
?>