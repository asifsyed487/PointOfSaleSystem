<?php 
include "connectdb.php";
session_start();
if($_SESSION['useremail'] == "") {
    header("location: index.php");
}
$id = $_POST['pidd'];

//Delete t1,t2 from t1 join t2 on t1.key=t2.key where t1.key=key;
$sql= "delete invoice, invoicedetails from invoice INNER JOIN invoicedetails ON invoice.invoiceid=invoicedetails.invoiceid where invoice.invoiceid='$id'";
$delete = $pdo->prepare($sql);
if($delete->execute()) {
    
} else {
    echo 'Product deletion failed';
}


?>