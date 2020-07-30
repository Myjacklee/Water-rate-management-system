<?php
function connection(){
    $servername="127.0.0.1";
    $username="root";
    $password="";
    $DBName="systemDB";
    $conn=new PDO("mysql:host=$servername;dbname=$DBName",$username,$password,array(PDO::ATTR_PERSISTENT=>true));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
?>
