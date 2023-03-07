<?php
include "../includes/auth.php";
include "../includes/hashing.php";

if (!function_exists('connectToDatabase')) {
    include "../includes/dal.php";
}
session_start();


// run code when the user is registering

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // check if all the post variables exist by checking if one is not set or the other is not set
    if (!(isset($_POST["username"]) || !(isset($_POST["password"])) || !(isset($_POST["key"])))) {
        header("Location:register.php");
        return;
    }

    $registrationKey = $_POST["key"];

    // check the registration key with the function from dal.php
    $keyExists = checkRegistrationKey($registrationKey);
    // stop when the key doesn't exist
    if (!$keyExists) {
        header("Location:register.php");
        return;
    }


    // create a new user with the credentials provided
    $username = $_POST["username"];
    $password = $_POST["password"];
    $salt = createSalt();
    $hashedPassword = hashPassword($password, $salt);
    usedRegistrationKey($registrationKey);
    $id = createUser($username, $hashedPassword, $salt, "" , $registrationKey);


    // make sure to keep things safe and delete variables that contain their password or hashed password
    unset($password);
    unset($hashedPassword);

    // redirect the user to the login page
    $_SESSION["registered"] = true;
    header("Location:login.php");

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BA Zandpoort</title>
</head>
<body>
<h1 class="center">Account creation 📝</h1>
<form action="register.php" method="post">

    <label for="username">Username</label>
    <input type="text" name="username" required>

    <label for="password">Password</label>
    <input type="password" name="password" required>

    <label for="password">Registration key</label>
    <input type="password" name="key" required>


    <input type="submit" value="Register 🔑">
</form>

<footer>
    <p>&copy; 2023 BA Zandpoort</p>
</footer>
</body>
</html>