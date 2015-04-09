<?php

function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
}

$user = user::check_login();
if ($user instanceof user) {
    $user_id = $user->getId();
} else {
    echo "Not logged in.";
    exit;
}

$idhash = $_GET['hash'];

$game = new game(turn::get_game($idhash));

$game->load_all_turns();


echo "<b>Players already in game:</b><br>";
$users = $game->get_all_users();

foreach ($users as $player) {
   $email = user::lookup_email($player);
    echo $email . "<br>";
}

$game->load_all_turns();
$receiver = $game->turn[$game->get_last_turn()]->receiver;

if (($game->status < 2) && ($receiver == $user->getId())) {
  echo "<p><a href=\"http://brokenpicture.com/play.php?id=" . $idhash . "\">Play!</a>";  
}
