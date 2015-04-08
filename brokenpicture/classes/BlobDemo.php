<?php
class BlobDemo
{
const DB_HOST = 'localhost';
const DB_NAME = 'drawing';
const DB_USER = 'draw';
const DB_PASSWORD = 'aurelia';
 
private $conn = null;
 
/**
* Open the database connection
*/
public function __construct(){
// open database connection
$connectionString = sprintf("mysql:host=%s;dbname=%s;charset=utf8",
BlobDemo::DB_HOST,
BlobDemo::DB_NAME);
 
try {
$this->conn = new PDO($connectionString,
BlobDemo::DB_USER,
BlobDemo::DB_PASSWORD);
//for prior PHP 5.3.6
//$conn->exec("set names utf8");
 
} catch (PDOException $pe) {
die($pe->getMessage());
}
}

public function insertBlob($id,$blob,$mime){
    //$blob = fopen($filePath,'rb');

    $sql = "INSERT INTO files(id, mime,data) VALUES(:id,:mime,:data)";
    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(":id", $id);
    $stmt->bindParam(':mime',$mime);
    $stmt->bindParam(':data',$blob);

    return $stmt->execute();
    
}
 
public function selectBlob($id) {

    $sql = "SELECT mime,
data
FROM files
WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(array(":id" => $id));
    $stmt->bindColumn(1, $mime);
    $stmt->bindColumn(2, $data, PDO::PARAM_LOB);

    $stmt->fetch(PDO::FETCH_BOUND);

    return array("mime" => $mime,
        "data" => $data);

}

/**
* close the database connection
*/
public function __destruct() {
// close the database connection
$this->conn = null;
}
}