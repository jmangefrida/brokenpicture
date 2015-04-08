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
//echo "1.5";
$game = new game(turn::get_game($idhash));

session_start();
$_SESSION['hash'] = $idhash;
$_SESSION['game'] = $game->id;
//echo "1.6";
$game->load_turn($idhash);




//echo "1.7";
if ($game->turn[$idhash]->status == 1) {
    include "sorry.php";
    exit;
}
//echo "2";
if ($game->status == 2) {
    
    $game->load_all_turns();
    
    $hashes = $game->get_turn_hashes();
    //echo var_dump($hashes);
    foreach ($hashes as $hash) {
        $output .= $arrow;
        $arrow = "<img src=img/down.png><br/>";
    if ($game->turn[$hash]->turn % 2 == 1) {
            $output .= "<h1>" . $game->turn[$hash]->get_data() . "</h1><br/>";
         } else {
             $output .= "<img src=\"" . $game->turn[$hash]->get_data() . "\"><br/>";
         }
    }

    include "finished.php";
    //echo $output;
    exit;
}
//echo "3";

if (!($user->getId() == $game->turn[$idhash]->receiver)){
    var_dump($game->turn[$idhash]);
    echo $user->getId();
    echo "|" . $game->turn[$idhash]->id;
    $result =  "Sorry, this turn was not sent to you.";
    //include_once 'sorry.php';
    exit;
}

$result = $game->turn[$idhash]->get_data();
//echo "4";
if ($game->turn[$idhash]->turn % 2 == 1) {
    include "phrase2.php"; 
} else {
    include "picture2.php";
}