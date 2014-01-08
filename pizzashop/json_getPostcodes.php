<?php

require_once("autoload.php");

use Oefeningen\pizzashop\business\PizzashopService;

if (isset($_GET['action']) && $_GET['action'] == 'get') {

    $postcodes = PizzashopService::getAllPostcodes();
    echo json_encode($postcodes);
} else {
    include('src/Oefeningen/pizzashop/presentation/shopform.html');
}
?>