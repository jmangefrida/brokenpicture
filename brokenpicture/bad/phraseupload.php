<?php

function __autoload($class_name) {
    include './classes/' .$class_name . '.php';
}

$user = user::check_login();
if ($user instanceof user) {
    
} else {
    exit;
}

$conn = dbconn::getInstance();

//include 'classes/BlobDemo.php';
session_start();
$prevhash = $_SESSION['hash'];
echo $prevhash;

if ($prevhash == ""){
    echo "nohash";
}
    $conn->beginTransaction();

    $sql = "select game, turn from turns where idhash = ?";    
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($prevhash));
    $stmt->bindColumn(1, $gameid);
    $stmt->bindColumn(2, $turn);
    $stmt->fetch(PDO::FETCH_BOUND);
    

        $sql = "update turns set status = 1 where idhash = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($prevhash));
 
    
    echo $gameid . " ";
    $turn = $turn + 1;
    $player = $user->getId();
    $sql = "insert into turns (id,idhash,game, turn, status, time, player) (select max(id) +1, md5(max(id) + 1),?,?, 0, now(), " . $player . " from turns)";
    
    $stmt = $conn->prepare($sql);
    //$stmt = $conn->prepare($sql);
    $stmt->execute(array($gameid, $turn));
    
    echo $turn . " ";
    
    $sql = "select id, idhash from turns where game = ? and turn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($gameid, $turn));
    $stmt->bindColumn(1, $id);
    $stmt->bindColumn(2, $idhash);
    $stmt->fetch(PDO::FETCH_BOUND);


    
    echo $id . " ";
    
    $sql = "insert into phrases (id, phrase) values (:id, :phrase)";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':phrase',$_POST['phrase']);
    $stmt->execute();
    
    if ($_POST['status'] == "end") {
        $sql = "update turns set status = 2 where game = ? and turn = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($gameid, $turn));
        echo $url = "http://brokenpicture.com/play.php?id=" . $idhash;
        exit;
    } else {
        $url = "http://brokenpicture.com/play.php?id=" . $idhash;
        $nextplayer = $_POST['player'];
        //include 'mail.php';
        $mail = new mailer();
        $mail->send($nextplayer, $url);
    }
    $conn->commit();

?>