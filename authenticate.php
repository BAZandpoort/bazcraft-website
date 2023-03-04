<?php
session_start();

if (!(isset($_POST["username"]) || isset($_POST["password"]))) {
    header("Location:login.php");
    return;
}

$_SESSION["username"] = $_POST["username"];
$_SESSION["password"] = $_POST["password"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticate - BA Zandpoort</title>
</head>
<body>
    <?php

    if (!(($_SESSION["username"] == "admin") && ($_SESSION["password"]) == "admin")) {
        $_SESSION["wrong_creds"] = true;
        header("Location:login.php");
        return;
    }

    header("Location:dashboard.php");
    ?>
</body>
</html>