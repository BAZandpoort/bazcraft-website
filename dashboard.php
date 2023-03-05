<?php
session_start();

    include "auth.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BA Zandpoort</title>
</head>
<body>

    <h1 class="center">🚀 Dashboard - BA Zandpoort</h1>
    <h3 class="center">👋 Welcome, <?php echo $_SESSION["username"]; ?></h3>


    <div class="button-container">
        <button class="dashboard-button button-primary" onclick="window.location.href='players.php'">👥 View Players</button>
        <button class="dashboard-button button-secondary" onclick="window.location.href='logout.php'">✌️ Log out</button>
    </div>

    <footer>
        <p>&copy; 2023 BA Zandpoort</p>
        <a href="logout.php">✌️ Log out</a>
    </footer>

</body>
</html>