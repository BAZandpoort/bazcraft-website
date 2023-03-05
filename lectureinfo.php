<?php
session_start();
include "auth.php";
include 'dal.php';
$lectures = getLectureData();

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

if (empty($lectures)) {
    echo '<div class="center">';
    echo '<span class="no-data-text center">No data to display :(</span>';
    echo '</div>';
} else {
    foreach ($lectures as $lecture) {
        echo '<div class="card">';
        echo '<h2 class="card-text">' . $lecture['lecture'] . '</h2>';
        echo '<p class="card-text"><strong>Using:</strong> ' . $lecture['using'] . '</p>';
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