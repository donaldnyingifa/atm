<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/main.css" />
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <meta charset="UTF-8">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Atm</title>
</head>
<div class=" navbar-fixed">
    <nav class="z-depth-4">
        <div class="container">
            <div class="nav-wrapper">
                <a class="title" href="index.php"> BANK OF MERIT</a>
                <a href="#" data-activates="mobile-nav" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
                <ul class="right hide-on-med-and-down">
                    <li>
                        <a href="index.php">HOME</a>
                    </li>

                    <?php
                    if (isset($_SESSION["user_email"])) {
                        if ($_SESSION["is_admin"] == "1") {
                            echo "<li>
                                <a href='accounts.php'>ALL ACCOUNTS </a>
                            </li>";
                            echo "<li>
                                <a href='users.php'> ALL USERS </a>
                            </li>";
                        } else {
                            echo "<li>
                                <a href='details.php'>CHECK DETAILS </a>
                            </li>";
                           
                        }
                        echo "<li>
                            <a href='includes/logout.inc.php'>LOGOUT </a>
                        </li>";
                    } else {
                        echo "<li>
                            <a href='login.php'>LOGIN </a>
                        </li>";
                        echo "<li>
                            <a href='register.php'>SIGN UP </a>
                        </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</div>
<ul class="side-nav" id="mobile-nav">
    <li>
        <a href="index.php">HOME</a>
    </li>

    <?php
    if (isset($_SESSION["user_email"])) {
        if ($_SESSION["is_admin"] == "1") {
            echo "<li>
                <a href='accounts.php'>ALL ACCOUNTS </a>
            </li>";
            echo "<li>
                <a href='users.php'> ALL USERS </a>
            </li>";
        } else {
            echo "<li>
            <a href='details.php'>CHECK DETAILS </a>
            </li>";
           
        }
        echo "<li>
                    <a href='includes/logout.inc.php'>LOGOUT </a>
                 </li>";
    } else {
        echo "<li>
                      <a href='login.php'>LOGIN </a>
                 </li>";
        echo "<li>
                    <a href='register.php'>SIGN UP </a>
                 </li>";
    }
    ?>

</ul>