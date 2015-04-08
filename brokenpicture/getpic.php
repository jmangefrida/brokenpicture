<?php

function __autoload($class_name) {
   include './classes/' .$class_name . '.php';
}

$conn = dbconn::getInstance();

session_start();
$idhash = $_SESSION['hash'];

$sql = "SELECT id, game, turn from games where idhash = ?";

$stmt = $conn->prepare($sql);

$stmt->execute(array($idhash));
$row = $stmt->fetch();

$blobObj = new BlobDemo();
$a = $blobObj->selectBlob($row['id']);
header("Content-Type:" . $a['mime']);
echo $a['data'];