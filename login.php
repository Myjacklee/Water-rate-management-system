<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>登录页面</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<!--<link href="./bootstrap-3.3.7-dist/css/bootstrap.min.css"-->
<!--	rel="stylesheet">-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/login.css" rel="stylesheet">
<!--引入jQuery库文件-->
<script src="./bootstrap-3.3.7-dist/js/jquery-3.4.0.min.js"></script>

    <!-- 包括所有已编译的插件 -->
<script src="./bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>


</head>
<body>
	<div class="container">
		<?php 
		  include 'header.html';
		?>
		<form class="form-signin" action="loginReminder.php" method="post">
			<h2 class="form-signin-heading">请登录</h2>
			<label for="inputEmail" class="sr-only">邮箱</label> 
			<input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="邮箱" required autofocus>
			<label for="inputPassword" class="sr-only">密码</label> 
			<input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="密码" required>
			<div class="checkbox">
				<label> <input type="checkbox" value="rememberme">记住我
				</label>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
			<a href="signin.php"><button class="btn btn-lg btn-default btn-block" type="button">注册</button></a>
			
		</form>
        <?php
        include 'beianCode.php';
        ?>
	</div>

</body>
</html>