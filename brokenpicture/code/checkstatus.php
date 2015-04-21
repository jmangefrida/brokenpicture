<?php

function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
}

$user = user::check_login();

if ($user instanceof user) {
    echo "logged in as " . $user->getEmail();
} else {
    echo "Not logged in.";
}

?>