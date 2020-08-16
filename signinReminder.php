<?php
require 'PDOconnection.php';
header("content-type:text/html;charset=utf-8");
//清除输入中的空白符
foreach($_POST as $key=>$value){
    $_POST[$key]=trim($value);
}
$email=isset($_POST['inputEmail'])?htmlspecialchars($_POST['inputEmail'],ENT_QUOTES):'';
$name=isset($_POST['inputName'])?htmlspecialchars($_POST['inputName'],ENT_QUOTES):'';
$school=isset($_POST['inputSchool'])?htmlspecialchars($_POST['inputSchool'],ENT_QUOTES):'';
$grade=isset($_POST['inputGrade'])?htmlspecialchars($_POST['inputGrade'],ENT_QUOTES):'';
$class=isset($_POST['inputClass'])?htmlspecialchars($_POST['inputClass'],ENT_QUOTES):'';
$password=isset($_POST['inputPassword'])?htmlspecialchars($_POST['inputPassword'],ENT_QUOTES):'';
$password=md5($password);
$confirmPassword=isset($_POST['confirmPassword'])?htmlspecialchars($_POST['confirmPassword'],ENT_QUOTES):'';
$confirmPassword=md5($confirmPassword);
$inventionCode=isset($_POST['inventionCode'])?htmlspecialchars($_POST['inventionCode'],ENT_QUOTES):'';
$today=date("Y-m-d");
session_unset();
setcookie(session_name(),'',time()-3600); //销毁与客户端的卡号
session_start();
try {
    $conn = connection();
    $conn->beginTransaction();
    $stmt=$conn->prepare("select * from admin where email=:email");
    $stmt->bindParam(":email",$email);
    $stmt->execute();
    $result=$stmt->rowCount();
    $stmt=$conn->prepare("select * from invention_code where code=:code and used=0");
    $stmt->bindParam(":code",$inventionCode);
    $stmt->execute();
    $codeResult=$stmt->rowCount();
    if($result!=0){
        $note="账号已被占用！";
        $page="注册界面";
        $imgRes="attention.png";
        $url="signin.php";
        Header("refresh:5;url=".$url);
    }else if($codeResult==1){
        $stmtB = $conn->prepare("insert into admin(email,password,admin_name,school,grade,class,Sign_date) values(:email,:password,:admin_name,:school,:grade,:class,:sign_date)");
        $stmtB->bindParam(":email", $email);
        $stmtB->bindParam(":password", $password);
        $stmtB->bindParam(":admin_name", $name);
        $stmtB->bindParam(":school", $school);
        $stmtB->bindParam(":grade", $grade);
        $stmtB->bindParam(":class", $class);
        $stmtB->bindParam(":sign_date",$today);
        $excA=$stmtB->execute();
        if ($excA) {
            $stmtC=$conn->prepare("select Uid,Student_num from admin where email=:email");
            $stmtC->bindParam(":email",$email);
            $stmtC->execute();
            $result=$stmtC->fetch(PDO::FETCH_ASSOC);
            $_SESSION["loginStatus"]=array(
                "email"=>$email,
                "admin_name"=>$name,
                "status"=>true,
                "uid"=>$result["Uid"],
                "school"=>$school,
                "grade"=>$grade,
                "class"=>$class,
                "student_num"=>$result["Student_num"],
                "loginTime"=>time()
            );
            $stmt=$conn->prepare("update invention_code set used=1,uid=:uid where code=:code");
            $stmt->bindParam(":code",$inventionCode);
            $stmt->bindParam(":uid",$_SESSION["loginStatus"]["uid"]);
            $stmt->execute();
            $note="注册成功！";
            $imgRes="success.png";
            $page="登录界面";
            $url="index.php";
            Header("refresh:5;url=".$url);
        }else{
            $note="注册失败！";
            $page="注册界面";
            $imgRes="attention.png";
            $url="signin.php";
            Header("refresh:5;url=".$url);
        }
    }else{
        $note="注册失败,邀请码无效或邀请码已被使用!";
        $page="注册界面";
        $imgRes="attention.png";
        $url="signin.php";
        Header("refresh:5;url=".$url);
    }
    $conn->commit();

}catch(PDOException $e){
    $note="注册失败！";
    $page="注册界面";
    $imgRes="attention.png";
    $url="signin.php";
    Header("refresh:5;url=".$url);
    $conn->rollBack();
}

?>
<!DOCTYPE html>
<html>
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
    <?php
    include 'header.html';
    ?>
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