<?php

require_once("autoload.php");

use Oefeningen\pizzashop\business\PizzashopService;

/////////////////////////////////


session_start();

if (isset($_GET['action']) && $_GET['action'] == 'verwijder' && isset($_GET['itemid'])) {

    $winkelmandje = unserialize($_SESSION['winkelmandje']);
    $winkelmandje = PizzashopService::verwijderUitwinkelmandje($_GET['itemid'], $winkelmandje);
    $_SESSION['winkelmandje'] = serialize($winkelmandje);

    echo json_encode($winkelmandje);
    
} else {
    include("src/Oefeningen/broodjes/presentation/login.html");
}
?>