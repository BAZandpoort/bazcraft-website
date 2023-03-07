<?php
if (!function_exists('connectToDatabase')) {
    include "../includes/dal.php";
}


// Create a function that creates a dynamic salt for each user
function createSalt(): string
{
    $salt = openssl_random_pseudo_bytes(16);
    return bin2hex($salt);
}




// Verify if passwords matched by checking a hashed version against the hashed version in the database
function verifyPassword($id, $password): bool
{
    $hashedPassword = getUser($id)["password"];
    return password_verify($password, $hashedPassword);
}

// Hash a password using the Argon2i algorithm
function hashPassword($password) {
    return password_hash($password, PASSWORD_ARGON2I);
}

?>