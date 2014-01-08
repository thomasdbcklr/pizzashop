<?php

require_once("autoload.php");

use Oefeningen\pizzashop\DTO\Winkelmandje;

session_start();

if (!isset($_SESSION['winkelmandje'])) {
    $winkelmandje = new Winkelmandje();
    $_SESSION["winkelmandje"] = serialize($winkelmandje);
}

include('src/Oefeningen/pizzashop/presentation/shopform.html');
?>