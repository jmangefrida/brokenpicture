<?php
//echo "begin ";

function __autoload($class_name) {
    include './classes/' .$class_name . '.php';
}

$greeting = '';
$user = user::check_login();

if ($user instanceof user) {
    //session_start();
    $greeting = "Welcome, <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">" . $user->getEmail() . "</a>";
} else {
    $greeting = "<a href=\"login.php\">Log In</a> / <a href=\"signup.php\">Sign Up</a>";
    require_once 'notloggedin.php';
    exit;
}

$idhash = $_GET['id'];

if ($idhash == '') {
    echo "no game found!";
    exit;
}

