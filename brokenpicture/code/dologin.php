<?php
function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
}

$email = $_POST['email'];
$password = $_POST['password'];

$user = user::login_user($email, $password);

if ($user instanceof user) {
    session_start();
    $_SESSION['user'] = "testing";
    echo "good";
} else {
    echo "The email and password do not match.";
}
