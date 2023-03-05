<?php

include 'dal.php';
$users = get_users();
closeDatabaseConnection();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
    <meta http-equiv="refresh" content="15">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BA Zandpoort</title>
</head>
<body>



<?php


foreach ($users as $user) {
    $text = sprintf('Id: %d | Playername: %s | Age: %d | Room: %s', $user['id'],  $user['playername'], $user['age'], getPlayerRoom($user['id']));
    echo "<p>" . $text . "</p>";
}


?>
<div class="button-container">
    <button class="dashboard-button button-primary" onclick="window.location.href='dashboard.php'">📖 Dashboard</button>
</div>

<footer>
    <p>&copy; 2023 BA Zandpoort</p>
    <a href="logout.php">Logout</a>
</footer>

</body>
</html>