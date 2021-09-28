<?php
include_once 'header.php'
?>

<body>

    <div class="container">
    <h4 class='center' style='text-shadow: 2px 2px #301934;'> My Account Details</h4>

        <div class="row">
            <div class="col s3 ">
            </div>
            <div class="col s6 ">

                <?php

                $acn = $_SESSION['account_number'];
                $id = $_SESSION['user_id'];

                require_once './includes/dbh.inc.php'; // Database handler
                
                $sql = "SELECT * FROM accounts WHERE account_number = $acn;";
                $sql2 = "SELECT * FROM users WHERE user_id = $id;";
               
                $result = mysqli_query($conn, $sql);
                $result_check = mysqli_num_rows($result);

                $result2 = mysqli_query($conn, $sql2);
                $result_check2 = mysqli_num_rows($result2);

                if ($result_check > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<p><strong>ACCOUNT NUMBER: </strong>" . $row['account_number'] . "</p>";
                        echo "<p><strong>PIN: </strong>" . $row['pin'] . "</p>";
                        echo "<p><strong>BALANCE: $</strong>" . $row['balance'] . "</p>";
                    }
                } else {
                    echo 'Details could not be loaded';
                }

                if ($result_check2 > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        $ad = $row['address'];
                        echo "<p><strong>Address: </strong>" . $row['address'] . "</p>";
                        echo "<form action='./updateaddress.php?id=$id&address=$ad'  method='post'>
                    <input class='btn' type='submit' name='update' value='Update Address' />
                    </form>";
                    }
                } else {
                    echo "<p><strong>Address: </strong>" . 'Details could not be loaded';
                }
                echo "<br />";
                // Display error message
                if (isset($_GET["atm"])) {
                    if ($_GET["atm"] == "true") {
                        echo "<p style='color: coral; margin-bottom:0;'>Atm card requested successfully! </p>";
                        echo "<i style='margin-top:0;'>Please make sure your address is updated for delivery</i>";
                       
                    }
                    echo "<br />";
                    echo "<br />";
                }
                echo "<form action='./includes/reqatm.inc.php?user_id=$id'  method='post'>
                    <input class='btn' type='submit' name='update' value='Request Atm' />
                    </form>";
                ?>


            </div>
            <div class="col s3 ">
            </div>
        </div>
    </div>
    <?php
    include_once 'footer.php'
    ?>