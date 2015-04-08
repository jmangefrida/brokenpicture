<?php

function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
    
}

$user = user::check_login();

if ($user instanceof user) {
    $user_id = $user->getId();
    $nextplayer = $_POST['player'];
    //session_start();
    //$greeting = "Welcome, <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">" . $user->getEmail() . "</a>";
} else {
   // $greeting = "<a href=\"login.php\">Log In</a> / <a href=\"signup.php\">Sign Up</a>";
   // require_once 'notloggedin.php';
  echo "Not logged in.";
  exit;
}

$conn = dbconn::getInstance();



    $conn->beginTransaction();
    $sql = "insert into turns (id,idhash,game, turn, status, time, player) (select max(id) +1, md5(max(id) + 1),max(game) + 1, 1, 0, now(), " . $user_id . " from turns)";

    $stmt = $conn->prepare($sql);
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $sql = "select id, idhash from turns order by id desc limit 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->bindColumn(1, $id);
    $stmt->bindColumn(2, $idhash);
    $stmt->fetch(PDO::FETCH_BOUND);
    
    $sql = "insert into phrases (id, phrase) values (:id, :phrase)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':phrase',$_POST['phrase']);
    $stmt->execute();
    

    
    
    $nextplayerid = user::exists($nextplayer);
    if ($nextplayerid > 0) {
        echo $nextplayerid;
        echo $idhash;
        //$conn->query('update turns set receiver = ' . $nextplayerid . ' where idhash = ' . $idhash);
        $sql = "update turns set receiver = :id where idhash = :idhash";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':id',$nextplayerid);
        $stmt->bindParam(':idhash',$idhash);
        $stmt->execute();
        $url = "http://brokenpicture.com/play.php?id=" . $idhash;
        $mail = new mailer();
        $mail->send($nextplayer, $url,$user->getEmail());
        //include 'mail.php';   
    } else {
        echo "new invite.";
        $sql = "insert into invitations (email, time) values (:email, now())";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email',$nextplayer);
        $stmt->execute();
        
        $sql = "select id from invitations where email = :email order by id desc limit 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email',$nextplayer);
        $stmt->execute();
        $stmt->bindColumn(1, $invitation);
        //$stmt->bindColumn(2, $idhash);
        $stmt->fetch(PDO::FETCH_BOUND);
        
        $sql = "update turns set invitation = :invite where idhash = :idhash";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':invite',$invitation);
        $stmt->bindParam(':idhash',$idhash);
        $stmt->execute();
        $url = "http://brokenpicture.com/play.php?id=" . $idhash;
        $mail = new mailer();
        $mail->invite($nextplayer, $url, $user->getEmail());
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email',$nextplayer);
        $stmt->execute();
        $stmt->bindColumn(1, $invitation);
        //$stmt->bindColumn(2, $idhash);
        $stmt->fetch(PDO::FETCH_BOUND);
        //create invitation in database and send invite
    }
    $conn->commit();
    
