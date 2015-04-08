<?php

function __autoload($class_name) {
   include '../classes/' .$class_name . '.php';
}

$conn = dbconn::getInstance();

//session_start();
//$idhash = $_SESSION['hash'];

$sql = "SELECT idhash from turns where id = ?";

$stmt = $conn->prepare($sql);

$stmt->execute(array($_GET['id']));
$row = $stmt->fetch();

$turn = new turn($row['idhash']);


//$blobObj = new BlobDemo();
//$a = $blobObj->selectBlob($_GET['id']);
//header("Content-Type:" . $a['mime']);
//echo "<img src=\"data:image/png;base64," . base64_encode($row['data']) . "\">";
echo "<img src=\"" . $turn->get_data() . "\">";
?>