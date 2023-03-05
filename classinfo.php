<?php
session_start();
include "auth.php";
include 'dal.php';
$classes = getClasses();

// Define the sort function
function sortClasses($a, $b) {
    if ($a['current'] != $b['current']) {
        return ($a['current'] < $b['current']) ? 1 : -1;
    } else {
        return ($a['used'] < $b['used']) ? 1 : -1;
    }
}

// Sort the classes array
usort($classes, "sortClasses");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
    <meta http-equiv="refresh" content="10">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BA Zandpoort</title>
</head>
<body>



<?php
if (empty($classes)) {
    echo '<div class="center">';
    echo '<span class="no-data-text center">No data to display :(</span>';
    echo '</div>';
} else {
    foreach ($classes as $class) {
        echo '<div class="card">';
        echo '<h2 class="card-text">' . $class["class"] . '</h2>';
        echo '<p class="card-text"><strong>Current:</strong> ' . $class['current'] . '</p>';
        echo '<p class="card-text"><strong>Times used:</strong> ' . $class['used'] . '</p>';
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