<?php
function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
}

$user = user::create_user('jmange@gmail.com', 1, '', 'testing1');

if ($user instanceof user) {
    echo "user created";
} else {
    echo "fail!";
}