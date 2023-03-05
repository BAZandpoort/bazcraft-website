<?php

$servername = "lin-17544-10111-mysql-primary.servers.linodedb.net";
$username = "linroot";
$password = "2l395YaLc8l!bqLy";
$dbname = "bazandpoort";



// Create connection
$conn = mysqli_init();
$conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
$conn->ssl_set(NULL, NULL, "C:\Users\IBABE\bazandpoort-ca-certificate.crt", NULL, NULL);
$conn->real_connect($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function get_users() {
    global $conn;
    $sql = "SELECT * FROM players";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $users = array();
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    } else {
        return array();
    }
}

function getPlayerRoom($playerId) {
    //$conn = getDatabaseConnection();  I wanted to use a function called getDatabaseConnection() that returns a connection object but I was too lazy to make it
    // and ended up just using the $conn variable 🗿
    global $conn;


    $sql = "SELECT room FROM score WHERE id = ?"; // parameterized query (player_id = ?) allows us to pass in a value for the ? placeholder when executing the query
    // to prevent possible SQL injections
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $playerId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["room"];
    } else {
        return null;
    }
}





?>
