<?php

require_once("autoload.php");

use Oefeningen\pizzashop\business\PizzashopService;

session_start();


if (isset($_GET['action']) && $_GET['action'] == 'bestelaccount') {

    if (isset($_SESSION["winkelmandje"])) {
        $winkelmandje = unserialize($_SESSION["winkelmandje"]);
    }
    $items = $winkelmandje->getItems();

    if (!empty($items) && isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
        $winkelmandje = unserialize($_SESSION["winkelmandje"]);
        $obj = PizzashopService::bestellenMetAccount($user, $_GET['straat'], $_GET['huisnummer'], $_GET['postcode'], $_GET['woonplaats'], $_GET['telefoon'], $_GET['extra'], $winkelmandje);
        if (isset($obj->bestelinfo)) {
            unset($_SESSION['winkelmandje']);
        }
        echo json_encode($obj);
    } else {
        include('src/Oefeningen/pizzashop/presentation/shopform.html');
    }
}
?>