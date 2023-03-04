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

    <h1 class="center">Welkom, <?php echo $_SESSION["username"]; ?></h1>


    <form action="logout.php" method="get">
        <input type="submit" value="Log uit">
    </form>

    <footer>
        <p>&copy; 2023 BA Zandpoort</p>
        <a href="logout.php">Logout</a>
    </footer>

</body>
</html>