<?php

function emptyInputSignup($firstname, $lastname, $email, $pwd, $pwdrepeat)
{
    $result;
    if (empty($firstname) || empty($lastname) || empty($email) || empty($pwd) || empty($pwdrepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidEmail($email)
{
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function pwdMatch($pwd, $pwdrepeat)
{
    $result;
    if ($pwd !== $pwdrepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function emailExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE user_email = ?;";
    // Initialize a new prepared statement
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function getAccountNumber($conn, $email)
{
    $sql = "SELECT * FROM accounts WHERE user_email = ?;";
     // Initialize a new prepared statement
     $stmt = mysqli_stmt_init($conn);
     if (!mysqli_stmt_prepare($stmt, $sql)) {
         header("location: ../register.php?error=stmtfailed");
         exit();
     }
 
     mysqli_stmt_bind_param($stmt, "s", $email);
     mysqli_stmt_execute($stmt);
 
     $resultData = mysqli_stmt_get_result($stmt);
 
     if ($row = mysqli_fetch_assoc($resultData)) {
         return $row;
     } else {
         $result = false;
         return $result;
     }
 
     mysqli_stmt_close($stmt);
}
function createUser($conn, $firstname, $lastname, $email, $pwd)
{
    $sql = "INSERT INTO users (firstname, lastname, user_email, user_password) VALUES (?, ?, ?, ?);";
    // Initialize a new prepared statement
    $stmt = mysqli_stmt_init($conn);
    // check if the statement will fail
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    //generate account number
    generateAccountNumber($conn, $email);
    loginUser($conn, $email, $pwd);
    header("location: ../index.php?error=none");
    exit();
}

function generateAccountNumber($conn, $email)
{
    $accountNumber = rand(1000000000, 9999999999);
    $pin = rand(1000, 9999);
    $sql = "INSERT INTO accounts (user_email, account_number, pin) VALUES (?, ?, ?);";
    // Initialize a new prepared statement
    $stmt = mysqli_stmt_init($conn);
    // check if the statement will fail
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $email, $accountNumber, $pin);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getAccount($conn, $account_number) 
{
    $sql = "SELECT * FROM accounts WHERE account_number = ?;";
     // Initialize a new prepared statement
     $stmt = mysqli_stmt_init($conn);
     if (!mysqli_stmt_prepare($stmt, $sql)) {
         header("location: ../index.php?error=stmtfailed");
         exit();
     }
 
     mysqli_stmt_bind_param($stmt, "s", $account_number);
     mysqli_stmt_execute($stmt);
 
     $resultData = mysqli_stmt_get_result($stmt);
 
     if ($row = mysqli_fetch_assoc($resultData)) {
         return $row;
     } else {
         $result = false;
         return $result;
     }
 
     mysqli_stmt_close($stmt);
}


function deposit($conn, $account_number, $amount)
{
    $prev = getAccount($conn, $account_number); 
    $prev_amount = $prev["balance"];
    $new_amount = floatval($prev_amount) + floatval($amount);
    $sql = "UPDATE accounts SET balance = ? WHERE account_number = ?;";
    // Initialize a new prepared statement
    $stmt = mysqli_stmt_init($conn);
    // check if the statement will fail
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $new_amount, $account_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
    exit();
}

function withdraw($conn, $account_number, $amount)
{
    $prev = getAccount($conn, $account_number); 
    $prev_amount = $prev["balance"];
    $new_amount = floatval($prev_amount) - floatval($amount);
    if ($new_amount < 0) {
        header("location: ../index.php?error=lowfunds");
        exit();
    }
    $sql = "UPDATE accounts SET balance = ? WHERE account_number = ?;";
    // Initialize a new prepared statement
    $stmt = mysqli_stmt_init($conn);
    // check if the statement will fail
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $new_amount, $account_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
    exit();
}

function transfer($conn, $account_number, $amount, $account_beneficiary)
{
    $prev = getAccount($conn, $account_number); 
    $s = getAccount($conn, $account_beneficiary); ;
    if (!$s) {
        session_start();
        $_SESSION["benAcc"] = $account_beneficiary;
        header("location: ../index.php?error=noBenAcc");
        exit();
    }
    $prev_amount = $prev["balance"];
    $new_amount = floatval($prev_amount) - floatval($amount);
    if ($new_amount < 0) {
        header("location: ../index.php?error=lowfunds");
        exit();
    }
    $sql = "UPDATE accounts SET balance = ? WHERE account_number = ?;";
    // Initialize a new prepared statement
    $stmt = mysqli_stmt_init($conn);
    // check if the statement will fail
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $new_amount, $account_number);
    mysqli_stmt_execute($stmt);
  

    $prev = getAccount($conn, $account_beneficiary); 
    $prev_amount = $prev["balance"];
    $new_amount = floatval($prev_amount) + floatval($amount);
    $sql = "UPDATE accounts SET balance = ? WHERE account_number = ?;";
    // Initialize a new prepared statement
    $stmt = mysqli_stmt_init($conn);
    // check if the statement will fail
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $new_amount, $account_beneficiary);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
    exit();
}

function emptyInputLogin($email, $pwd)
{
    $result;
    if (empty($email) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $email, $pwd)
{
    $emailExists = emailExists($conn, $email);

    if ($emailExists == false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $getAccountNumber = getAccountNumber($conn, $email);

    $pwdHashed = $emailExists["user_password"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd) {
        session_start();
        $_SESSION["user_email"] = $emailExists["user_email"];
        $_SESSION["firstname"] = $emailExists["firstname"];
        $_SESSION["lastname"] = $emailExists["lastname"];
        $_SESSION["user_id"] = $emailExists["user_id"];
        $_SESSION["is_admin"] = $emailExists["is_admin"];
        $_SESSION["account_number"] = $getAccountNumber["account_number"];
        header("location: ../index.php");
        exit();
    } else {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
}

function updateAddress($conn, $id, $address)
{

    $sql = "UPDATE users SET address = ? WHERE user_id = ?;";
    // Initialize a new prepared statement
    $stmt = mysqli_stmt_init($conn);
    // check if the statement will fail
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../updateaddress.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $address, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../details.php?error=none");
    exit();
}