<?php
session_start();

include "../includes/auth.php";
include "../includes/rbac.php";
include "../includes/dal.php";
isAuthenticated(true);

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
    <title>Dashboard - BA Zandpoort</title>
</head>
<body>
<?php

if (!(isset($_COOKIE["toastr_welcome"]))) {
    echo '<script>toastr.success("😎 Welcome, ' . $_SESSION["username"] . '!")</script>';
    setcookie("toastr_welcome", true);
}

?>
<h1 class="center">🚀 Dashboard - BA Zandpoort</h1>
<h3 class="center">👋 Welcome, <?php echo $_SESSION["username"]; ?> (<?php echo $_SESSION["role"] ?>) </h3>


<div class="button-container">
    <button class="dashboard-button button-primary" onclick="window.location.href='players.php'">👥 View Players</button>
    <button class="dashboard-button button-primary" onclick="window.location.href='lectureinfo.php'">📕 View lecture
        info
    </button>
    <button class="dashboard-button button-primary" onclick="window.location.href='classinfo.php'">💼 View classes info
    </button>

    <?php

    if (getRoleInt($_SESSION["role"]) == 2) {


        echo '<button class="dashboard-button button-special" onclick="window.location.href=\'admin/adminpanel.php\'">👨‍💻 Admin Panel</button>';
    }
    ?>

    <button class="dashboard-button button-secondary" onclick="window.location.href='logout.php'">✌️ Log out</button>
</div>

<footer>
    <p>&copy; 2023 BA Zandpoort</p>
    <a href="logout.php">✌️ Log out</a>
</footer>

</body>
</html>