<?php

require_once("autoload.php");

use Oefeningen\pizzashop\business\PizzashopService;

if (isset($_GET['action']) && $_GET['action'] == 'get') {

    $pizzas = PizzashopService::getAllPizzas();
    echo json_encode($pizzas);
} else {
    include('src/Oefeningen/pizzashop/presentation/shopform.html');
}

?>