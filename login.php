<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BA Zandpoort</title>
</head>
<body>
    <?php
    
    if (isset($_SESSION["wrong_creds"])) {
        echo '<p>The username or password was incorrect.</p>';
        unset($_SESSION["username"]);
        unset($_SESSION["password"]);
        session_destroy();
    }

    ?>
    <h1 class="center">Inloggen</h1>
    <form action="authenticate.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" required>
        <input type="submit" value="Inloggen">
    </form>

    <footer>
        <p>&copy; 2023 BA Zandpoort</p>
    </footer>
</body>
</html>