<?php

if (isset($_POST["withdraw"])) { //check if user accessed the form the proper way
    
    $account_number = $_GET["account_number"]; 
    $amount = $_POST["amount"];
    if ( $amount > 0) {
    require_once 'dbh.inc.php'; // Database handler
    require_once 'functions.inc.php';

    withdraw($conn, $account_number, $amount);
    } else {
        header("location: ../index.php?error=zerowithdraw");
        exit();
    }
} 
else {
    header("location: ../index.php");
    exit();
}