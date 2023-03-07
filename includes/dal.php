<?php




function connectToDatabase($dbname) {
    $servername = "lin-17544-10111-mysql-primary.servers.linodedb.net";
    $username = "linroot";
    $password = "2l395YaLc8l!bqLy";
    // Create connection

    $conn = mysqli_init();

    $conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
    $conn->ssl_set(NULL, NULL, "C:\Users\IBABE\bazandpoort-ca-certificate.crt", NULL, NULL);
    $conn->real_connect($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}


function get_users() {
    $conn = connectToDatabase("bazandpoort");
    $sql = "SELECT * FROM players";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $users = array();
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }
    return array();

}

function getPlayerRoom($playerId) {

    //$conn = getDatabaseConnection();  I wanted to use a function called getDatabaseConnection() that returns a connection object but I was too lazy to make it
    // and ended up just using the $conn variable 🗿
    $conn = connectToDatabase("bazandpoort");


    $sql = "SELECT room FROM score WHERE id = ?"; // parameterized query (player_id = ?) allows us to pass in a value for the ? placeholder when executing the query
    // to prevent possible SQL injections
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $playerId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["room"];
    }
    return null;

}


function getLectureData() {

    $conn = connectToDatabase("bazandpoort");

    $sql = "SELECT * FROM lectures";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $lectures = array();
        while($row = $result->fetch_assoc()) {
            $lectures[] = $row;
        }
        return $lectures;
    }
    return array();


}

function getClasses() {
    $conn = connectToDatabase("bazandpoort");

    $sql = "SELECT * FROM classes";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $lectures = array();
        while($row = $result->fetch_assoc()) {
            $lectures[] = $row;
        }
        return $lectures;
    }
    return array();

}


// create a function to resolve the user id from username
function getUserId($username) {

    $conn = connectToDatabase("credentials");

    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["id"];
    }
    return null;
}

// get a user from the database using the id
function getUser($id) {
    $conn = connectToDatabase("credentials");
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}


// create a new user in the database

function createUser($username, $password, $salt, $twoFactor) {

    $conn = connectToDatabase("credentials");
    $sql = "INSERT INTO `credentials`.`users` (username, password, 2fa, salt) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $password, $twoFactor, $salt);
    $stmt->execute();
    return $stmt->get_result();
}


// create a function to check if a registration key exists in a database and if it does return true and delete the key from the database
function checkRegistrationKey($registration_key): bool
{
    $conn = connectToDatabase("registration_keys");
    $sql = "SELECT `key` FROM registration_keys.`keys` WHERE `key` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $registration_key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "DELETE FROM registration_keys.`keys` WHERE `key` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $registration_key);
        $stmt->execute();
        return true;
    }
    return false;
}


function getUserRole($id) {

    $conn = connectToDatabase("credentials");
    $sql = "SELECT role FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["role"];
    }
    return null;
}


function getKeyRole($registration_key) {

    $conn = connectToDatabase("registration_keys");
    $sql = "SELECT role FROM registration_keys.`keys` WHERE `key` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $registration_key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["role"];
    }
    return null;

}

// create a new key with role values: 0 = guest, 1 = user, 2 = admin
function createKey($role) {

    $conn = connectToDatabase("registration_keys");
    $key = bin2hex(random_bytes(32));
    $sql = "INSERT INTO `registration_keys`.`keys` (`key`, role) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $key, $role);
    $stmt->execute();
    return $key;
}

function getRegistrationKeys() {

    $conn = connectToDatabase("registration_keys");
    $sql = "SELECT * FROM registration_keys.`keys`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $keys = array();
        while($row = $result->fetch_assoc()) {
            $keys[] = $row;
        }
        return $keys;
    }
    return array();


}

?>
