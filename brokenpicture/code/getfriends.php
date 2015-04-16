<?php

function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
}

$user = user::check_login();
if ($user instanceof user) {

} else {
    exit;
}

$friends = $user->get_friends();
echo json_encode($friends);

?>