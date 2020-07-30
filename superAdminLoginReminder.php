<?php
require 'PDOconnection.php';
header("content-type:text/html;charset=utf-8");
//清除输入中的空白符
foreach ($_POST as $key => $value) {
    $_POST[$key] = trim($value);
}
$account_id= isset($_POST['inputAccount']) ? htmlspecialchars($_POST['inputAccount'],ENT_QUOTES) : '';
$password = isset($_POST['inputPassword']) ? htmlspecialchars($_POST['inputPassword'],ENT_QUOTES) : '';
session_start();
try {
    $conn = connection();
    $stmt = $conn->prepare("select * from super_admin where account_id=:account_id and password=:password");
    $stmt->bindParam(":account_id", $account_id);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
    $a=$stmt->rowCount();
    if ( $a== 1) {
        $_SESSION["admin"] = true;
        $_SESSION['account']=$account_id;
        $note = "登录成功！";
        $page = "超级管理员界面";
        $imgRes="success.png";
        $url="superAdmin.php";
        Header("refresh:5;url=".$url);
    } else {
        $note = "账号或密码错误";
        $page = "登录界面";
        $imgRes="attention.png";
        $url="superAdminLogin.php";
        Header("refresh:5;url=".$url);
    }
} catch (PDOException $e) {
    $note = "出现未知错误，请联系管理员";
    $page = "登录界面";
    $imgRes="attention.png";
    $url="superAdminLogin.php";
    Header("refresh:5;url=".$url);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>提示</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/notice.css" rel="stylesheet">
    <!--引入jQuery库文件-->
    <script src="./bootstrap-3.3.7-dist/js/jquery-3.4.0.min.js"></script>
    <!-- 包括所有已编译的插件 -->
    <script src="./bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="./js/loginTime.js"></script>
</head>
<body>
<div class="container">
    <?php include "header.html"?>
    <div class="jumbotron">
        <div class="media">
            <div class="media-left media-middle">
                <img alt="notice" src="./img/<?php echo $imgRes?>" class="media-object" style="width:70px">
            </div>
            <div class="media-body"><h1><?php echo $note?></h1></div>
        </div>
        <p>系统将在 <span id="time">5</span> 秒后跳转到<?php echo $page?>...</p>
        <a href="<?php echo $url?>"><button class="btn btn-success">立即跳转</button></a>
    </div>
    <?php
    include 'beianCode.php';
    ?>
</div>
</body>
</html>
