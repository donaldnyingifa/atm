<?php
include_once 'header.php'
?>
<body>
<style>
        ::-webkit-input-placeholder {
            /* Edge */
            color: grey;
        }

        :-ms-input-placeholder {
            /* Internet Explorer */
            color: grey;
        }

        ::placeholder {
            color: #592263;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
<div class="container">
<h4 class="center" style="text-shadow: 2px 2px #fee;"> Welcome to Atm </h4>
<?php


if (!isset($_SESSION["firstname"])) {
echo "<p style='color: coral;'>Please Login to Perform Transactions</p>";
} 
// Info for logged in user
            if (isset($_SESSION["firstname"])) {
                echo "<p><strong> Name: </strong>" . $_SESSION["firstname"] ." ". $_SESSION["lastname"] .  "</p>";
                echo "<p><strong>ACCOUNT NUMBER: </strong>" . $_SESSION['account_number'] . "</p>";

                $acn = $_SESSION['account_number'];

                require_once './includes/dbh.inc.php'; // Database handler
                
                $sql = "SELECT * FROM accounts WHERE account_number = $acn;";
               
                $result = mysqli_query($conn, $sql);
                $result_check = mysqli_num_rows($result);

                if ($result_check > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<p><strong>BALANCE: $</strong>" . $row['balance'] . "</p>";

                    }
                } else {
                    echo 'Details could not be loaded';
                }
            }
            ?>

<?php
// Display error message
if (isset($_GET["error"])) {
    if ($_GET["error"] == "zerotransfer") {
        echo "<h5 id='info' style='color: coral;'>Please select amount to transfer! </h5>";
    }
    if ($_GET["error"] == "noBenAcc") {
        echo "<h5 id='info' style='color: coral;'> <strong style='color: black;'>". $_SESSION["benAcc"] ."</strong> is an Invalid beneficiary account number - Input a valid account number and try again! </h5>";
    }
    if ($_GET["error"] == "zerowithdraw") {
        echo "<h5 id='info' style='color: coral;'>Please select amount to withdraw!  </h5>";
    }
    if ($_GET["error"] == "zerodeposit") {
        echo "<h5 id='info' style='color: coral;'>Please select amount to deposit! </h5>";
    }
    if ($_GET["error"] == "none") {
        echo "<h5 id='info' style='color: green;'>Transaction Successful! </h5>";
    }
}
?>

<!-- Atm-->
<div class="calculator">
        <!-- Display -->
        <div class="calculator-display">
            <span id="amountVal" style="font-size: 40px;">$</span><h1 onchange="updateInputs()">0</h1>
        </div>
        <!-- Buttons -->
        <div class="calculator-buttons">

        <?php

if (isset($_SESSION["firstname"])) {
    $account_number = $_SESSION["account_number"];
    echo "<form action='./includes/deposit.inc.php?account_number=$account_number' method='post'>
        <input id='deposit' type='text' name='amount' hidden />
        <input onclick='updateInputs()' class='btn' type='submit' name='deposit' value='Deposit' />
        </form>";

        echo "<form action='./includes/withdraw.inc.php?account_number=$account_number'  method='post'>
        <input id='withdraw' type='text' name='amount' value='' required hidden placeholder='Enter amount' />
        <input onclick='updateInputs()' class='btn' type='submit' name='withdraw' value='Withdraw' />
        </form>";

        echo "<form action='./includes/transfer.inc.php?account_number=$account_number'  method='post'>
        <input id='myInput' type='text' name='account_beneficiary' value='' required placeholder='Enter Acc No' />
        <input id='transfer' type='text' name='amount' value='' required hidden placeholder='Enter amount' />
        <input onclick='updateInputs()' class='btn' type='submit' name='transfer' value='Transfer' />
        </form>";
}

            ?>
            <button onclick="()=>updateInputs()" value="1000">1,000</button>
            <button onclick="updateInputs()" value="5000">5,000</button>
            <button onclick="updateInputs()" value="10000">10,000</button>
            <button onclick="updateInputs()" value="20000">20,000</button>
            <button onclick="updateInputs()" value="50000">50,000</button> 
            <button onclick="updateInputs()" value="100000">100,000</button>
            <button onclick="updateInputs()" value="500000">500,000</button>
            <button onclick="updateInputs()" value="1000000">1,000,000</button> 
            <button onclick="updateInputs()" class="clear" id="clear-button">clear</button>
        </div>
    </div>
<br />

<div style="width: 400px;">

<!-- <input style="border: 3px solid #4fa79a; border-radius: 5px;" type="text" name="account_number" value="" required="" placeholder="ENTER ACCOUNT NUMBER ">

<input style="border: 3px solid #4fa79a; border-radius: 5px;" type="text" name="pin" value="" required="" placeholder="ENTER PIN "> -->

</div>

</div>

<?php
    include_once 'footer.php'
?>