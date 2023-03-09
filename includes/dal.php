<?php


function connectToDatabase($dbname)
{
    $servername = "127.0.0.1"; // localhost (You can use your own IP address if you want to connect to a remote database)
    $username = "root";
    $password = "Fruitsla!123";
    // Create connection

    $conn = mysqli_init();

    //$conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
    //$conn->ssl_set(NULL, NULL, "path/to/certificate/bazandpoort-ca-certificate.crt", NULL, NULL); // Replace with your own path to the certificate
    $conn->real_connect($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    // Check connection
    return $conn;
}


function get_users(): array
{
    $conn = connectToDatabase("minecraft");
    $sql = "SELECT * FROM players";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }
    return array();

}

function getPlayerRoom($playerName)
{

    //$conn = getDatabaseConnection();  I wanted to use a function called getDatabaseConnection() that returns a connection object, but I was too lazy to make it
    // and ended up just using the $conn variable 🗿
    $conn = connectToDatabase("minecraft");


    $sql = "SELECT currentregion FROM players WHERE playername = ?"; // parameterized query (playername = ?) allows us to pass in a value for the ? placeholder when executing the query
    // to prevent possible SQL injections
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $playerName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["currentregion"] ?? "Hallways";
    }
    return null;

}


function getLectureData(): array
{

    $conn = connectToDatabase("minecraft");

    $sql = "SELECT * FROM lectures";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $lectures = array();
        while ($row = $result->fetch_assoc()) {
            $lectures[] = $row;
        }
        return $lectures;
    }
    return array();


}

function getClasses(): array
{
    $conn = connectToDatabase("minecraft");

    $sql = "SELECT * FROM classes";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $lectures = array();
        while ($row = $result->fetch_assoc()) {
            $lectures[] = $row;
        }
        return $lectures;
    }
    return array();

}


// create a function to resolve the user id from username
function getUserId($username)
{

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
function getUser($id)
{
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

function createUser($username, $password, $salt, $twoFactor, $registration_key)
{
    //createUser($username, $hashedPassword, $salt, "" , $registrationKey);
    $conn = connectToDatabase("credentials");
    $sql = "INSERT INTO `credentials`.`users` (username, password, 2fa, salt, role, invitedby) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $username, $password, $twoFactor, $salt, getKeyInfo($registration_key)["role"], getKeyInfo($registration_key)["createdby"]);
    $stmt->execute();
    return $stmt->get_result();
}


function usedRegistrationKey($registration_key)
{
    // set "used" to true in the database
    $conn = connectToDatabase("registration_keys");
    $sql = "UPDATE registration_keys.`keys` SET used = 1 WHERE `key` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $registration_key);
    $stmt->execute();
}


function getUserRole($id)
{

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


// --Commented out by Inspection START (07/03/2023 21:15):
//function getKeyRole($registration_key)
//{
//
//    $conn = connectToDatabase("registration_keys");
//    $sql = "SELECT role FROM registration_keys.`keys` WHERE `key` = ?";
//    $stmt = $conn->prepare($sql);
//    $stmt->bind_param("s", $registration_key);
//    $stmt->execute();
//    $result = $stmt->get_result();
//
//    if ($result->num_rows > 0) {
//        $row = $result->fetch_assoc();
//        return $row["role"];
//    }
//    return null;
//
//}
// --Commented out by Inspection STOP (07/03/2023 21:15)


function getKeyInfo($registration_key)
{

    $conn = connectToDatabase("registration_keys");
    $sql = "SELECT * FROM registration_keys.`keys` WHERE `key` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $registration_key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;

}

// create a new key with role values: 0 = guest, 1 = user, 2 = admin
function createKey($role, $createdby): string
{

    $conn = connectToDatabase("registration_keys");
    try {
        $key = bin2hex(random_bytes(32));
    } catch (Exception $e) {
    }
    $sql = "INSERT INTO `registration_keys`.`keys` (`key`, role, createdby) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $key, $role, $createdby);
    $stmt->execute();
    return $key;
}

function getRegistrationKeys(): array
{

    $conn = connectToDatabase("registration_keys");
    $sql = "SELECT * FROM registration_keys.`keys`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $keys = array();
        while ($row = $result->fetch_assoc()) {
            $keys[] = $row;
        }
        return $keys;
    }
    return array();


}

function keyExists($key): bool
{

    $conn = connectToDatabase("registration_keys");
    $sql = "SELECT `key` FROM registration_keys.`keys` WHERE `key` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return true;
    }
    return false;

}

function deleteKey($key)
{

    $conn = connectToDatabase("registration_keys");
    $sql = "DELETE FROM registration_keys.`keys` WHERE `key` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $key);
    $stmt->execute();
    return $stmt->get_result();

}


