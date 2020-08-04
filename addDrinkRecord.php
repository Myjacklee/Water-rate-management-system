<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>水费管理系统主界面</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/index.css" rel="stylesheet">
    <!--引入jQuery库文件-->
    <script src="./bootstrap-3.3.7-dist/js/jquery-3.4.0.min.js"></script>
    <!-- 包括所有已编译的插件 -->
    <script src="./bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="./js/loginTime.js"></script>
    <script src="./js/logout.js"></script>
    <script src="./js/drinkingNumCount.js"></script>
    <script src="./js/saveDrinkData.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="./js/font-normal.js"></script>
    <script src="./js/printPDF.js"></script>

</head>
<?php
header("content-type:text/html;charset=utf-8");
if(isset($_SESSION["loginStatus"]["status"])&&$_SESSION["loginStatus"]["status"]==true){
    try {
        require 'PDOconnection.php';
        $page = isset($_GET["page"]) ? intval(htmlspecialchars($_GET["page"],ENT_QUOTES)) : 1;
        $showColumns = 10;
        $paginationFrontNumMax = 2;  //分页标签向前最大输出页数
        $paginationFollowNumMax = 2; //分页标签向后最大输出页数
        $conn = connection();
        $stmt = $conn->prepare("select count(student_id) from student where Uid=:Uid");
        $stmt->bindParam(":Uid", $_SESSION["loginStatus"]["uid"]);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        $allStudentColumns = intval($row["count(student_id)"]);
        $showColumns = $allStudentColumns;
        $allPageNum = ceil($allStudentColumns / $showColumns);
        if ($page > $allPageNum) {
            $page = $allPageNum;
        }
        if ($page < 1) {
            $page = 1;
        }
        $stmt = $conn->prepare("select student_id,student_name from student where Uid=:uid limit :limitNum offset :offsetNum");
        $offsetNum = ($page - 1) * $showColumns;
        $stmt->bindValue(":limitNum", $showColumns, PDO::PARAM_INT);
        $stmt->bindValue(":offsetNum", $offsetNum, PDO::PARAM_INT);
        $stmt->bindParam(":uid", $_SESSION["loginStatus"]["uid"]);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        // $conn2=connection();
        $stmtUpdate = $conn->prepare("update admin set Student_num=:student_num where Uid=:Uid");
        $stmtUpdate->bindParam(":student_num", $allStudentColumns);
        $stmtUpdate->bindParam(":Uid", $_SESSION["loginStatus"]["uid"]);
        $stmtUpdate->execute();
        $_SESSION["loginStatus"]["student_num"] = $allStudentColumns;
        ?>
        <body>
        <nav class="navbar navbar-default navbar--fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">水费管理系统</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> 账户信息</a></li>
                        <li id="logout"><a href=""><span class="glyphicon glyphicon-log-out"></span> 注销</a></li>
                    </ul>
                </div>

            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li><a href="index.php">学生信息界面</a></li>
                        <li class="active"><a href="addDrinkRecord.php">水费录入界面</a></li>
                        <li><a href="drinkHistory.php">历史查询界面</a></li>
                        <li><a href="classDrinkHistory.php">班级历史记录</a></li>
                    </ul>

                </div>
                <div class="col-md-10 content">
                    <h2>基本信息</h2>
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">学校</h3>
                                </div>
                                <div class="panel-body">
                                    <?php echo $_SESSION["loginStatus"]["school"] ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">年级</h3>
                                </div>
                                <div class="panel-body" id="grade">
                                    <?php echo $_SESSION["loginStatus"]["grade"] ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">班级</h3>
                                </div>
                                <div class="panel-body" id="class_name">
                                    <?php echo $_SESSION["loginStatus"]["class"] ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">班级人数</h3>
                                </div>
                                <div class="panel-body" id="student_num">
                                    <?php echo $_SESSION["loginStatus"]["student_num"] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2>请输入</h2>
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">总费用</h3>
                                </div>
                                <div class="panel-body">
                                    <input type="number" class="form-control" id="allPrice" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">总次数</h3>
                                </div>
                                <div class="panel-body" id="allCount">
                                    0
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">本次单价</h3>
                                </div>
                                <div class="panel-body" id="drinkingUnitPrice">
                                    0
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h2>请录入数据</h2>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="printChargingList">打印收费详单</button>
                                <button type="button" class="btn btn-success" id="saveButton">保存记录</button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteStudent" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">删除学生</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="deleteStudentContainer">
                                            <input type="number" class="form-control deleteStudentControl"
                                                   id="deleteStudentID" placeholder="学号" required autofocus>
                                            <!--                                        <input type="text" class="form-control deleteStudentControl" id="deleteStudentName" placeholder="姓名" required>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="button" class="btn btn-primary" id="deleteStudentButton">提交更改</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                    </div>
                    <table class="table table-hover  table-responsive">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>学号</th>
                            <th>姓名</th>
                            <th>次数</th>
                            <th>应交费用</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $tempID = $offsetNum + 1;
                        while ($studentRow = $stmt->fetch()) {
                            echo "<tr><td>" . $tempID . "</td><td id='student_ID_" . $tempID . "'>" . $studentRow["student_id"] . "</td><td id='student_name_" . $tempID . "'>" . $studentRow["student_name"] . "</td><td><input value='0' type='number' id='student_" . $tempID . "_count' class='form-control drinkingNum' placeholder='请输入次数'></td><td><span class='student_price' id='student_" . $tempID . "_price'>0</span></td></td></tr>";
                            $tempID++;
                        }

                        ?>
                        </tbody>
                    </table>
                    <div class="row text-center">
                        <ul class="pagination mypage">
                            <?php
                            $showFollowPagination = $page + 1;
                            $showFrontPagination = $page - $paginationFrontNumMax;
                            if ($showFrontPagination <= 0) {
                                $showFrontPagination = 1;
                            }
                            if ($page == 1) {
                                echo "<li class=\"disabled\"><a href=\"index.php?page=" . $page . "\">上一页</a></li>";
                            } else {
                                echo "<li><a href=\"index.php?page=" . ($page - 1) . "\">上一页</a></li>";
                            }
                            while ($showFrontPagination < $page) {
                                echo "<li><a href=\"index.php?page=" . $showFrontPagination . "\">" . $showFrontPagination . "</a></li>";
                                $showFrontPagination++;
                            }
                            echo "<li class=\"active\"><a href=\"index.php?page=" . $page . "\">" . $page . "</a></li>";
                            $paginationNumCount = 0;
                            while ($paginationNumCount < $paginationFrontNumMax && $showFollowPagination <= $allPageNum) {
                                echo "<li><a href=\"index.php?page=" . $showFollowPagination . "\">" . $showFollowPagination . "</a></li>";
                                $paginationNumCount++;
                                $showFollowPagination++;
                            }
                            if ($page == $allPageNum || $allPageNum == 0) {
                                echo "<li class=\"disabled\"><a href=\"index.php?page=" . $page . "\">下一页</a></li>";
                            } else {
                                echo '<li><a href="index.php?page=' . ($page + 1) . '">下一页</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            include 'beianCode.php';
            ?>
        </div>
        </body>
        <?php
    }
    catch(PDOException $e){
        include "error.php";
    }
}else{
    $note = "用户未登录";
    $page = "登录界面";
    $imgRes="attention.png";
    $url="login.php";
    Header("refresh:5;url=".$url);
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
            <p>系统将在 <span id="time">5</span> 秒后跳转到<?php echo $page?>...</p>
            <a href="<?php echo $url?>"><button class="btn btn-success">立即跳转</button></a>
        </div>
        <?php
        include 'beianCode.php';
        ?>
    </div>
    </body>
<?php
}
?>
</html>
