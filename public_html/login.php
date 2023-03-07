<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
          integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BA Zandpoort</title>
</head>
<body>
<?php

// if the user just tried to log in but failed
if (isset($_SESSION["wrong_creds"])) {
    echo '<script>toastr.error("The username or password was incorrect.")</script>';
    unset($_SESSION["password"]);
    session_destroy();
} // if the user just registered
else if (isset($_SESSION["registered"])) {
    echo '<script>toastr.success("You have successfully registered!")</script>';
    unset($_SESSION["registered"]);
} // if the user just logged out
else if (isset($_SESSION["logged_out"])) {
    echo '<script>toastr.success("You have successfully logged out!")</script>';
    unset($_SESSION["logged_out"]);
}

?>
<h1 class="center">Log-in 🔒</h1>
<form action="authenticate.php" method="post">
    <label>
        Username
        <input type="text" name="username" required>
    </label>
    <label>
        Password
        <input type="password" name="password" required>
    </label>
    <input type="submit" value="Log-in 🔑">
</form>
<p class="center">Don't have an account yet? <a href="register.php">Register here</a></p>
<footer>
    <p>&copy; 2023 BA Zandpoort</p>
</footer>
</body>
</html>