<?php


function isAuthenticated($redirect)
{
    if (!isset($_SESSION["authenticated"])) {
        if ($redirect) {
            header("Location: login.php");
            exit();
        } else {
            return false;
        }
    }
    return true;
}





