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
            $stmt->bindParam(":uid",intval($_SESSION["loginStatus"]["uid"]));
            $stmt->bindParam(":student_id",$_GET["student_ID_".strval($i)]);
            $stmt->bindParam(":drink_count",intval($_GET["student_".strval($i)."_count"]));
            $stmt->bindParam(":cost",floatval($_GET["student_".strval($i)."_price"]));
            $stmt->bindParam(":up_date",strval(date("Y-m-d")));
            $stmt->execute();
        }
        $stmt=$conn->prepare("insert into class_drink(uid,cost,drink_count,price,up_date) values(:uid,:cost,:drink_count,:price,:up_date) ");
        $stmt->bindParam(":uid",intval($_SESSION["loginStatus"]["uid"]));
        $stmt->bindParam("cost",floatval($_GET["totalCost"]));
        $stmt->bindParam("drink_count",intval($_GET["totalDrinkNum"]));
        $stmt->bindParam(":price",floatval($_GET["price"]));
        $stmt->bindParam(":up_date",strval(date("Y-m-d")));
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