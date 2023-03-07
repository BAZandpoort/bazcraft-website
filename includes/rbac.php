<?php

// a list where other functions can resolve roles (0 = guest, 1 = user, 2 = admin)
$roles = array("guest", "user", "admin");



// function that converts a role to an int role from the list
function getRoleInt($role) {
    global $roles;
    return array_search($role, $roles);
}


// function that converts an int role to a role from the list
function getRoleString($role) {
    global $roles;
    return $roles[$role];
}

// a way to check role priority (admin > user > guest)
function checkRolePriority($role1, $role2) {
    global $roles;
    return array_search($role1, $roles) >= array_search($role2, $roles);
}

?>