<?php

function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
}

$user = user::check_login();
if ($user instanceof user) {

} else {
    exit;
}
session_start();
$prevhash = $_SESSION['hash'];
$game = $_SESSION['game'];

if ($prevhash == ""){
    echo "nohash";
}
echo $game;
$game = new game($game);
$game->set_turn_status($prevhash, 1);


if ($_POST['status'] == "end") {
    $nextid = 0;
    $nextplayer = 0;
    $game->set_status(2);
    $hash = $game->new_turn($user->getId(), $nextplayer, $nextid, $_POST['data']);
    $game->set_turn_status($hash, 2);
    $game->load_all_turns();
    $players = $game->get_all_users();
    var_dump($players);
    $mail = new mailer();
    foreach ($players as $player) {
        $email = user::lookup_email($player);
        $mail->finish($email, $hash);
    }
    
} else {
    
    $email = $_POST['player'];
    //echo $email;
    $nextplayer = user::exists($email);

    if ($nextplayer == 0) {
        $invitation = new invitation($email);
        $invitation->send($user->getEmail());
        $nextid = $invitation->id;
    } else {
        $nextid = 0;
    }
    //echo $game->id;
    $hash = $game->new_turn($user->getId(), $nextplayer, $nextid, $_POST['data']);
    if ($nextplayer > 0) {
        $mail = new mailer();
        $mail->send($email, $hash,$user->getEmail());
    }
}



