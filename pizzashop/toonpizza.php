<?php

require_once("autoload.php");

session_start();

use Oefeningen\pizzashop\DTO\Winkelmandje;

if (!isset($_SESSION['winkelmandje'])) {
    $winkelmandje = new Winkelmandje();
    $_SESSION["winkelmandje"] = serialize($winkelmandje);
}

include('src/Oefeningen/pizzashop/presentation/pizzaform.html');
?>