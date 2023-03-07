<?php
session_start();
include "../../includes/auth.php";
isAuthenticated(true);
include "../../includes/rbac.php";
include "../../includes/dal.php";
$keys = getRegistrationKeys();
// Check if user is admin using rbac.php functions
if (!(getRoleInt($_SESSION['role']) == 2)) {

    header("Location: dashboard.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST["role"];
    $role = getRoleInt($role);
    $key = createKey($role);
    exit();
}

?>



<!--

Create a html page that allows the user to select a role and upon pressing "generate" it will give them a key


-->

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - BA Zandpoort</title>
</head>
<body>
<h1 class="center">🚀 Admin Panel - BA Zandpoort</h1>
<h3 class="center">👋 Welcome, <?php echo $_SESSION["username"]; ?> (<?php echo $_SESSION['role'] ?>) </h3>

<!-- create a form that allows the user to pick from "admin", "user", "guest"-->
<form action="managekeys.php" method="post">
    <select name="role" id="role">
        <option value="admin">Admin</option>
        <option value="user">User</option>
        <option value="guest">Guest</option>
    </select>
    <br>
    <input type="submit" value="Generate">

</form>

<?php

foreach ($keys as $key) {
    echo "<p class='center'>" . $key["key"] . " - " . getRoleString($key["role"]) . "</p>";
}

?>


</body>
</html>