<?php
session_start();
include "../includes/auth.php";
isAuthenticated(true);
include '../includes/dal.php';
$users = get_users();
rsort($users);
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
if (empty($users)) {
    echo '<div class="center">';
    echo '<span class="no-data-text center">No data to display :(</span>';
    echo '</div>';
} else {
    foreach ($users as $user) {
        echo '<div class="card">';
        echo '<h2 class="card-text">' . $user['playername'] . '</h2>';
        echo '<p class="card-text"><strong>Room:</strong> ' . getPlayerRoom($user['id']) . '</p>';
        echo '<p class="card-text"><strong>Age:</strong> ' . $user['age'] . '</p>';
        echo '<p class="card-text"><strong>ID:</strong> ' . $user['id'] . '</p>';
        echo '</div>';
    }
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
