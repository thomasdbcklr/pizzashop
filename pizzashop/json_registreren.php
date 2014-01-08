<?php

require_once("autoload.php");

use Oefeningen\pizzashop\business\PizzashopService;

session_start();

if (!isset($_SESSION['user'])) {

    if (isset($_POST['action']) && $_POST['action'] == 'regis' && isset($_POST['naam']) && isset($_POST['email']) && isset($_POST['wachtwoord'])) {
        $user = PizzashopService::maakAccountAan($_POST['naam'], $_POST['voornaam'], $_POST['straat'], $_POST['huisnummer'], $_POST['postcode'], $_POST['woonplaats'], $_POST['telefoon'], $_POST['email'], $_POST['wachtwoord']);
        echo json_encode($user);
    } else {
        include('src/Oefeningen/pizzashop/presentation/shopform.html');
    }
} else {
    include('src/Oefeningen/pizzashop/presentation/shopform.html');
}
?>