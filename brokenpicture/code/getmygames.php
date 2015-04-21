<?php

if ($user instanceof user) {
    $user_id = $user->getId();
} else {
    echo "Not logged in.";
    exit;
}

$games = game::get_user_games($user->getId());

foreach ($games as $game) {
    $game->load_all_turns();
    if ($game->status == 2) {
        $turns = $game->get_turn_hashes();
        //echo "<span><a href=# onclick=\"loadgameinfo('" . $game->get_last_turn() . "');\">" . $game->turn[$turns[1]]->get_data() . "</a></span><span class=\"label label-success\">Finished</span><br>";
    } else {
        if ($game->waiting($user->getId()) == true) {
            echo "<span><a href=# onclick=\"loadgameinfo('" . $game->get_last_turn() . "');\">" . $game->id . "</a></span><span class=\"label label-info\">New</span><br>";
        } else {
            echo "<span><a href=# onclick=\"loadgameinfo('" . $game->get_last_turn() . "');\">" . $game->id . "</a></span><br>";
        }
    }
}
