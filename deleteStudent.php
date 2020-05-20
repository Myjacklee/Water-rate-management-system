<?php
header("content-type:text;charset=uff-8");
require  "PDOconnection.php";
session_start();
if(isset($_SESSION["loginStatus"]["status"])&&$_SESSION["loginStatus"]["status"]==true){
    foreach($_POST as $key=>$value){
        $_POST[$key]=trim($value);
    }
    try{
        $student_id=$_POST["ID"];
        $conn=connection();
        $stmt=$conn->prepare("select count(student_id) from student where Uid=:Uid and student_id=:student_id");
        $stmt->bindParam(":Uid",$_SESSION["loginStatus"]["uid"]);
        $stmt->bindParam(":student_id",$student_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row=$stmt->fetch();
        $resultNum=intval($row["count(student_id)"]);
        if($resultNum==1){
            $stmt=$conn->prepare("delete from student where Uid=:Uid and student_id=:student_id");
            $stmt->bindParam(":Uid",$_SESSION["loginStatus"]["uid"]);
            $stmt->bindParam(":student_id",$student_id);
            $stmt->execute();
            echo "success";
        }else{
            echo "do not exist";
        }

    }
    catch (PDOException $e){
        echo "fail";
    }
}else{
    require 'pleaseLog.php';
}

?>