<?php

require_once("autoload.php");

session_start();


if (isset($_SESSION['user'])) {

    if (isset($_GET['action']) && $_GET['action'] == 'get') {

        $user = unserialize($_SESSION['user']);
        echo json_encode($user);
        
    } else {
        include('src/Oefeningen/pizzashop/presentation/shopform.html');
    }
} else {
    include('src/Oefeningen/pizzashop/presentation/shopform.html');
}
?>