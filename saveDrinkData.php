<?php
header("content-type:text/html;charset=uft-8");
session_start();
if(isset($_SESSION["loginStatus"]["status"])&&$_SESSION["loginStatus"]["status"]==true){
    require 'PDOconnection.php';
    foreach ($_POST as $key=>$value){
        $_POST[$key]=trim($value);
    }
    try{
        $conn=connection();
        $stmt=$conn->prepare("insert into student_drink(uid,student_id,drink_count,cost,up_date) values(:uid,:student_id,:drink_count,:cost,:up_date)");
        for($i =1;$i<=$_SESSION["loginStatus"]["student_num"];$i++){
            $temp1=intval($_SESSION["loginStatus"]["uid"]);
            $stmt->bindParam(":uid",$temp1);
            $stmt->bindParam(":student_id",$_GET["student_ID_".strval($i)]);
            $temp2=intval($_GET["student_".strval($i)."_count"]);
            $stmt->bindParam(":drink_count",$temp2);
            $temp3=floatval($_GET["student_".strval($i)."_price"]);
            $stmt->bindParam(":cost",$temp3);
            $temp4=strval(date("Y-m-d"));
            $stmt->bindParam(":up_date",$temp4);
            $stmt->execute();
        }
        $stmt=$conn->prepare("insert into class_drink(uid,cost,drink_count,price,up_date) values(:uid,:cost,:drink_count,:price,:up_date) ");
        $temp5=intval($_SESSION["loginStatus"]["uid"]);
        $stmt->bindParam(":uid",$temp5);
        $temp6=floatval($_GET["totalCost"]);
        $stmt->bindParam("cost",$temp6);
        $temp7=intval($_GET["totalDrinkNum"]);
        $stmt->bindParam("drink_count",$temp7);
        $temp8=floatval($_GET["price"]);
        $stmt->bindParam(":price",$temp8);
        $temp9=strval(date("Y-m-d"));
        $stmt->bindParam(":up_date",$temp9);
        $stmt->execute();
        echo 'success';
    }
    catch (PDOException $e){
        echo "fail";
    }

}else{
    require 'pleaseLog.php';
}
?>