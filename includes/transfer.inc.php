<?php

if (isset($_POST["transfer"])) { //check if user accessed the form the proper way
    
    $account_number = $_GET["account_number"]; 
    $account_beneficiary = $_POST["account_beneficiary"]; 
    $amount = $_POST["amount"];
    if ( $amount > 0) {
    require_once 'dbh.inc.php'; // Database handler
    require_once 'functions.inc.php';

    transfer($conn, $account_number, $amount, $account_beneficiary);
    } else {
        header("location: ../index.php?error=zerotransfer");
        exit();
    }
} 
else {
    header("location: ../index.php");
    exit();
}