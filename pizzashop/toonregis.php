<?php

require_once("autoload.php");

session_start();

if (!isset($_SESSION['user'])) {
    include('src/Oefeningen/pizzashop/presentation/regisform.html');
} else {
    include('src/Oefeningen/pizzashop/presentation/shopform.html');
}
?>