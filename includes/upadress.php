<?php

if (isset($_POST["update"])) { //check if user accessed the form the proper way

    $id = $_POST["id"];
    $address = $_POST["address"];
   

    require_once 'dbh.inc.php'; // Database handler
    require_once 'functions.inc.php';

    updateAddress($conn, $id, $address);
} else {
    header("location: ../updateaddress.php");
    exit();
}
