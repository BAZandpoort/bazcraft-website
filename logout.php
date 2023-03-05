<?php
    session_start();
    setcookie("toastr_welcome", false);
    session_destroy();

    header("Location: login.php");


?>