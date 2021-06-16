<?php 
include_once "connectdb.php";

$id = $_GET["id"];

$select = $pdo->prepare("select * from product where productid=:pid");
$select->bindParam(":pid", $id);
$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);

$response = $row;

header('Content-Type: application/json');

echo json_encode($response);













?>