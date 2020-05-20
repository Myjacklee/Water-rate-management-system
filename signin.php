<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>注册</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<!--引入jQuery库文件-->
    <script src="./bootstrap-3.3.7-dist/js/jquery-3.4.0.min.js"></script>
    <!-- 包括所有已编译的插件 -->
    <script src="./bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <link href="./css/signin.css" rel="stylesheet">
    <script rel="stylesheet">
        $(document).ready(function () {
            $("#confirmPassword").blur(function(){
                var getPS=$("#inputPassword");
                var getConfirmPS=$("#confirmPassword");
                var password=getPS.val();
                var confirmPassword=getConfirmPS.val();
                if(password!=confirmPassword){
                    alert("两次输入的秘密不一致，请重新输入！");
                    getPS.val('');
                    getConfirmPS.val('');
                }
            });
        });
    </script>
	</head>
	<body>
    	<div class="container">
    		<?php 
    		  include 'header.html';
    		?>
    		<form class="form-signin" action="signinReminder.php" method="post">
    			<h2 class="form-signin-heading">请注册</h2>
    			<label for="inputEmail" class="sr-only">邮箱</label> 
    			<input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="邮箱" required autofocus>
    			<label for="inputName" class="sr-only">姓名</label>
    			<input type="text" name="inputName" id="inputName" class="form-control" placeholder="姓名" required>
    			<label for="inputSchool" class="sr-only">姓名</label>
    			<input type="text" name="inputSchool" id="inputSchool" class="form-control" placeholder="学校" required>
    			<label for="inputGrade" class="sr-only">年级</label>
    			<input type="text" name="inputGrade" id="inputGrade" class="form-control" placeholder="请输入入学年份如 高2017级" required>
    			<label for="inputClass" class="sr-only">班级</label>
    			<input type="text" name="inputClass" id="inputClass" class="form-control" placeholder="班级" required>
    			<label for="inputPassword" class="sr-only">密码</label> 
    			<input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="密码" required>
                <label for="confirmPassword" class="sr-only">确认密码</label>
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="确认密码" required>
                <input type="text" name="inventionCode" id="inventionCode" class="form-control" placeholder="邀请码" required>
    			<button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
                <a href="login.php"><button class="btn btn-lg btn-default btn-block" type="button">登录</button></a>
    		</form>
    	</div>
	</body>
</html>