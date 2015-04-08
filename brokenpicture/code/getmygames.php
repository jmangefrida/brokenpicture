<?php


//$user = user::check_login();

if ($user instanceof user) {
    $user_id = $user->getId();
//    $nextplayer = $_POST['player'];
    //session_start();
    //$greeting = "Welcome, <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">" . $user->getEmail() . "</a>";
} else {
   // $greeting = "<a href=\"login.php\">Log In</a> / <a href=\"signup.php\">Sign Up</a>";
   // require_once 'notloggedin.php';
  echo "Not logged in.";
  exit;
}

$games = game::get_user_games($user->getId());

foreach ($games as $game) {
    $game->load_all_turns();
    if ($game->status == 2) {
        $turns = $game->get_turn_hashes();
        echo "<span><a href='play.php?id=" . $game->get_last_turn() . "'>" . $game->turn[$turns[1]]->get_data() . "</a></span><span class=\"label label-success\">Finished</span><br>";
    } else {
        if ($game->waiting($user->getId()) == true) {
            echo "<span><a href='play.php?id=" . $game->get_last_turn() . "'>" . $game->id . "</a></span><span class=\"label label-info\">New</span><br>";
        } else {
            echo "<span><a href='play.php?id=" . $game->idhash . "'>" . $game->id . "</a></span><br>";
        }
    }
}



// $conn = dbconn::getInstance();
// //echo $user->getId();

// $sql = "select idhash from turns where receiver = " . $user->getId() . " and status = 0";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// //echo "testing";
// while ($row = $stmt->fetch()) {
//     echo "<div><a href='play.php?id=" . $row['idhash'] . "'</a>" . $row['idhash'] . "<span class=\"label label-info\">New</span></div>";
// }

// $sql = "select id,idhash, game, max(status) as gamestatus from turns where player = " . $user->getId() . " group by game order by gamestatus";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// while ($row = $stmt->fetch()) {
//     if ($row['gamestatus'] == 2) {
//         echo "<div><a href='play.php?id=" . $row['idhash'] . "'</a>" . $row['idhash'] . "<span class=\"label label-success\">Finished</span></div>";
//     } else {
//         echo "<div><a href='play.php?id=" . $row['idhash'] . "'</a>" . $row['idhash'] . "</div>";
//     }
    
// }
