<?php
// $cookie_name = "user";

// if(!isset($_COOKIE[$cookie_name])) {
//     echo "Cookie named '" . $cookie_name . "' is not set!";
// } else {
//     echo "Cookie '" . $cookie_name . "' is set!<br>";
//     echo "Value is: " . $_COOKIE[$cookie_name];
//     session_start();
//     //echo $_SESSION['user'];
// }

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