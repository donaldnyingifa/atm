<?php
// dev
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "atm";

$servername = "sql109.unaux.com";
$username = "unaux_29185597";
$password = "tyj46ru8xuq73odd";
$dbname = "unaux_29185597_atm";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  echo $conn;
  die("Connection failed: " . mysqli_connect_error());
}
