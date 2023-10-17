<?php

try{
    $pdo = new PDO('mysql:host=localhost;dbname=proyecto_grado','root','');
    //echo 'Connection Successfull';
}catch(PDOException $error){
    echo $error->getmessage();
}


?>