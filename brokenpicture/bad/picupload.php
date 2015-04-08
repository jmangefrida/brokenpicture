<?php
function __autoload($class_name) {
    include './classes/' .$class_name . '.php';
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

session_start();
$prevhash = $_SESSION['hash'];

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
    $sql = "insert into turns (id,idhash,game, turn, status) (select max(id) +1, md5(max(id) + 1),?,?, 0 from turns)";
 
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($gameid, $turn));
    
    echo $turn . " ";
    
    $sql = "select id, idhash from turns where game = ? and turn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($gameid, $turn));
    $stmt->bindColumn(1, $id);
    $stmt->bindColumn(2, $idhash);
    $stmt->fetch(PDO::FETCH_BOUND);
    
    echo $id . " ";
    
    $binary = str_replace("data:image/octet-stream;base64,", "", $_POST['image']);
    $binary = base64_decode($binary);
    $blobObj = new BlobDemo();
    $blobObj->insertBlob($id,$binary,"image/png");
    
    echo $idhash . " ";
    
    
    
    $url = "http://brokenpicture.com/play.php?id=" . $idhash;
    $nextplayer = $_POST['player'];
    //include 'mail.php';
    $mail = new mailer();
    $mail->send($nextplayer, $url, $user->getEmail());
    $conn->commit();
    

?>