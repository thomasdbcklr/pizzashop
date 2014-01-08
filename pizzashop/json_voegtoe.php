<?php

require_once("autoload.php");

use Oefeningen\pizzashop\business\PizzashopService;
//////


session_start();

if (isset($_GET['action']) && $_GET['action'] == 'voegtoe' && isset($_GET['pizzaid']) && isset($_GET['aantal'])) {

    $winkelmandje = unserialize($_SESSION['winkelmandje']);
    $winkelmandje = PizzashopService::voegToeAanWinkelmandje($_GET['pizzaid'], $_GET['aantal'], $winkelmandje);
    if (isset($winkelmandje->winkelmandje)) {
        $_SESSION['winkelmandje'] = serialize($winkelmandje->winkelmandje);
    }
    echo json_encode($winkelmandje);
} else {
    include("src/Oefeningen/pizzashop/presentation/shopform.html");
}
?>