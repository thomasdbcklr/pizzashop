<?php

require_once("autoload.php");

session_start();

if (isset($_SESSION['user']) && isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    $obj = new stdClass();
    $obj->gelukt = true;
    echo json_encode($obj);
} else {
    include('src/Oefeningen/pizzashop/presentation/shopform.html');
}
?>