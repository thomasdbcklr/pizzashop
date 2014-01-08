<?php

require_once("autoload.php");

use Oefeningen\pizzashop\business\PizzashopService;

/////////////////////////////////

session_start();

if (!isset($_SESSION['user'])) {

    if (isset($_POST['action']) && $_POST['action'] == 'login' && isset($_POST['email']) && isset($_POST['wachtwoord'])) {

        $user = PizzashopService::controleerUser($_POST['email'], $_POST['wachtwoord']);
        if (isset($user->user)) {
            $_SESSION['user'] = serialize($user->user);
        }
        
        echo json_encode($user);
        
    } else {
        include('src/Oefeningen/pizzashop/presentation/shopform.html');
    }
} else {
    include('src/Oefeningen/pizzashop/presentation/shopform.html');
}
?>