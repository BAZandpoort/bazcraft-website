<?php
session_start();
include "../../includes/auth.php";
isAuthenticated(true);
include "../../includes/rbac.php";
include "../../includes/dal.php";

// Check if user is admin using rbac.php functions
if (!(getRoleInt($_SESSION['role']) == 2)) {

    header("Location: dashboard.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // check if key exists
    if (isset($_POST["key"])) {
        $key = $_POST["key"];
        if (!keyExists($key) && isset($_POST["deleteKey"])) {
            exit();
        }
    }
    // check for key creating or deletion
    if (isset($_POST["createKey"])) {
        $role = $_POST["role"];
        $role = getRoleInt($role);
        $key = createKey($role, $_SESSION["username"]);
    } else if (isset($_POST["deleteKey"])) {
        deleteKey($_POST["key"]);
    }
}

$keys = getRegistrationKeys();

?>


<!--

Create a html page that allows the user to select a role and upon pressing "generate" it will give them a key


-->

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
    <link rel="stylesheet" href="../css/main.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - BA Zandpoort</title>
</head>
<body>
<h1 class="center">🚀 Admin Panel - BA Zandpoort</h1>
<h3 class="center">👋 Welcome, <?php echo $_SESSION["username"]; ?> (<?php echo $_SESSION['role'] ?>) </h3>
<div class="button-container">
    <button class="dashboard-button button-special" onclick="window.location.href='adminpanel.php'">👨‍💻 Admin panel
    </button>
    <!--<button class="dashboard-button button-special" onclick="window.location.href='manageusers.php'">👨‍💻 Manage users</button>-->

</div>

<!-- create a form that allows the user to pick from "admin", "user", "guest"-->
<form action="managekeys.php" method="post">
    <label for="role">Manage keys</label>
    <select name="role" id="role">
        <option value="admin">Admin</option>
        <option value="user">User</option>
        <option value="guest">Guest</option>
    </select>
    <br>
    <input type="submit" name='createKey' value="Generate">

</form>

<?php

foreach ($keys as $key) {
    if (!$key["used"]) {
        echo "
        <table>
        <tr>
        ";
        echo "<td>" . $key["key"] . " - type: " . getRoleString($key["role"]) . " - created: " . $key["createdby"] . "</td>";
        // send a post request to delete key
        echo "<form action='managekeys.php' method='post'>";
        echo "<input type='hidden' name='key' value='" . $key["key"] . "'>";
        echo "<td><input type='submit' name='deleteKey' value='Delete'></td>";
        echo "</form>";
        echo "
        </tr>
        </table>
        ";
    }


}

?>


</body>
</html>