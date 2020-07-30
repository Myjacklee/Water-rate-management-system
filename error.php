<?php
$note = "出现未知错误";
$imgRes="attention.png";
$detail= "请刷新页面重试";
?>
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
        <p><?php echo $detail;?></p>
    </div>
    <?php
    include 'beianCode.php';
    ?>
</div>
</body>
