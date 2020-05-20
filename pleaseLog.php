<?php
$note = "用户未登录，请登录";
$page = "登录界面";
$imgRes="attention.png";
$url="login.php";
Header("refresh:5;url=login.php");
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
</div>
</body>
</html>