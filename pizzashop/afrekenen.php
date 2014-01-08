<?php

require_once("autoload.php");

session_start();



if (isset($_SESSION["winkelmandje"])) {
    $winkelmandje = unserialize($_SESSION["winkelmandje"]);
    $items = $winkelmandje->getItems();

    if (!empty($items)) {
        /////al aangemeld
        if (isset($_SESSION['user'])) {
            /////goto User bestelform
            include('src/Oefeningen/pizzashop/presentation/bestelform.html');
        } else {
            include('src/Oefeningen/pizzashop/presentation/loginform.html');
        }
    } else {
        include('src/Oefeningen/pizzashop/presentation/shopform.html');
    }
} else {
    include('src/Oefeningen/pizzashop/presentation/shopform.html');
}
?>