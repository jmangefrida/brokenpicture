<?php

function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
}

$user = user::check_login();
if ($user instanceof user) {
    $user_id = $user->getId();
    $email = $_POST['player'];
} else {
  echo "Not logged in.";
  exit;
}
echo $email;
echo "1";
$game = game::new_game();
echo "2";
$nextplayer = user::exists($email);
echo "3";
if ($nextplayer == 0) {
    $invitation = new invitation($email);
    //$invitation->send($user->getEmail());
    $nextid = $invitation->id;
      //$nextid = 99;
    //$hash = $game->new_turn($user->getId(), 0, $invitation->id, $_POST['phrase']);
} else {
    //$hash = $game->new_turn($user->getId(), $nextplayer, 0, $_POST['phrase']);
    //$mail = new mailer();
    //$mail->send($nextplayer, $url,$user->getEmail());
    $nextid = 0;
    //include 'mail.php';
}
echo "4";

$hash = $game->new_turn($user->getId(), $nextplayer, $nextid, $_POST['phrase']);

if ($nextplayer > 0) {
    $mail = new mailer();
    $mail->send($email, $hash,$user->getEmail());
} else {
    $invitation->send($user->getEmail());
}