<?php 
try {
    $pdo = new PDO('mysql:host=localhost;dbname=posalesystem', 'root', '');
//    echo "Connection Successful <br />"; 
}catch(PDOException $f) {
    echo $f->getmessage();
}



?>