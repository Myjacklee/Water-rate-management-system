<?php
header("content-type:text/html;charset=utf-8");
require "PDOconnection.php";
session_start();
if(isset($_SESSION["loginStatus"]["status"])&&$_SESSION["loginStatus"]["status"]==true){
    foreach($_POST as $key=>$value){
        $_POST[$key]=trim($value);
    }
    try{

        $conn=connection();
        $stmt=$conn->prepare("insert into student(Uid,student_id,student_name) values(:Uid,:student_id,:student_name)");
        $stmt->bindParam(":Uid",$_SESSION["loginStatus"]["uid"]);
        $stmt->bindValue(":student_id",intval($_POST["ID"]),PDO::PARAM_INT);
        $stmt->bindParam(":student_name",$_POST["name"]);
        $stmt->execute();
        echo "success";
    }
    catch (PDOException $e){
        echo "fail";
    }
}else{
require 'pleaseLog.php';
}


?>