<?php

function __autoload($class_name) {
    include '../classes/' .$class_name . '.php';
}

if ($_POST['agree'] == '') {
    echo "You must agree to the terms of use.";
    exit;
}

if ($_POST['password1'] == $_POST['password2']) {
    
    $email = $_POST['email'];
    $contact_type = 1;
    $contact = '';
    $password = $_POST['password1'];
    
    $user = user::create_user($email, $contact_type, $contact, $password);
    $conn = dbconn::getInstance();
    
  
    if ($user instanceof user) {
        $sql = "select id from invitations where email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $stmt->bindColumn(1, $invitation);
        //$stmt->bindColumn(2, $idhash);
        $stmt->fetch(PDO::FETCH_BOUND);
        $userid = $user->getId();
        $sql = "update turns set receiver = :user, invitation = NULL where invitation = :invit";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user',$userid);
        $stmt->bindParam(':invit',$invitation);
        $stmt->execute();
        
        $sql = "delete from invitations where id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$invitation);
        $stmt->execute();
        
        echo "good";
    } else {
        echo "This email already exists.";
    }
} else {
    echo "The passwords do not match.";
}

;