<?php
include_once 'header.php'
?>

<body>
    <div class="container">
        <h4 class="center" style='text-shadow: 2px 2px #301934;'> UPDATE ADDRESS </h4>
        <div class="row">
            <div class="col s3 ">
            </div>
            <div class="col s6 ">

                <form action="includes/upadress.php" method="POST">
                    <input type="hidden" name="id" value="<?= $_GET["id"]; ?>">
                    <input type="text" name="address" value="<?= $_GET["address"]; ?>" required placeholder="Address" />
   
                    <input class="btn" type="submit" name="update" value="Update" />

                </form>

                <?php
                // Display error message
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p>Please fill in all fields! </p>";
                    } elseif ($_GET["error"] == "stmtfailed") {
                        echo "<p>Something went wrong! Please try again. </p>";
                    } elseif ($_GET["error"] == "none") {
                        echo "<p>You have updated your address successfully! </p>";
                    }
                }
                ?>
            </div>
            <div class="col s3 ">
            </div>
        </div>
    </div>
    <?php
    include_once 'footer.php'
    ?>