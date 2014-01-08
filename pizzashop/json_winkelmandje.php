<?php

require_once("autoload.php");

session_start();

if (isset($_GET['action']) && $_GET['action'] == 'get') {

    $winkelmandje = unserialize($_SESSION['winkelmandje']);
    echo json_encode($winkelmandje->getItems());
    
} else {

    include("src/Oefeningen/pizzashop/presentation/shopform.html");
}
?>