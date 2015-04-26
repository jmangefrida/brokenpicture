<?php
function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
}


$games = new game_collection('stale');

//var_dump($games->games);

foreach ($games->games as $game) {
    $game->load_all_turns();
    $turn = $game->get_last_turn();
    $players[] = new user($game->turn[$turn]->receiver);
    echo $game->turn[$turn]->receiver;
    echo '<br>';
    //echo $game->id . ' ' . $player->getEmail();
    //echo var_dump($player); 
    echo '<p>';

}

$mail = new mailer();
foreach ($players as $player) {
    echo $player->getEmail();
    $mail->stale($player->getEmail());
}