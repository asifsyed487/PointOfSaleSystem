<?php 
include "connectdb.php";
session_start();
if($_SESSION['useremail'] == "" OR $_SESSION['role'] == "User") {
    header("location: index.php");
}
$id = $_POST['pidd'];
$sql= "delete from product where productid='$id'";
$delete = $pdo->prepare($sql);
if($delete->execute()) {
    
} else {
    echo 'Product delettion failed';
}


?>