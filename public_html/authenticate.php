<?php
session_start();

include "../includes/auth.php";
include "../includes/dal.php";
include "../includes/hashing.php";
include "../includes/rbac.php";








if (!(isset($_POST["username"]) || isset($_POST["password"]))) {
    header("Location:login.php");
    return;
}


// verify if the user used the right credentials with the same hashing and salting of register.php
$authusername = $_POST["username"];
$authpassword = $_POST["password"];

$id = getUserId($authusername);
$salt = getUser($id)["salt"];
$hashedPassword = hashPassword($authpassword . $salt);
$verified = verifyPassword(getUserId($authusername), $authpassword);



if ($verified){
    $_SESSION["authenticated"] = true;
    $_SESSION["username"] = $authusername;
    $_SESSION["role"] = getRoleString(getUserRole(getUserId($_SESSION["username"])));
    header("Location:dashboard.php");
} else {
    $_SESSION["wrong_creds"] = true;
    $_SESSION["sensitive"] = array($authusername, $authpassword, $salt, $hashedPassword);

    header("Location:login.php");
}

// remove sensitive variables for security
unset($_SESSION["password"]);
unset($hashedPassword);
unset($salt);


return;


?>