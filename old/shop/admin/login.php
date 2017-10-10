<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>登陆</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<!--[if IE 6]>
<script type="text/javascript" src="../js/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript" src="../js/ie6Fixpng.js"></script>
<![endif]-->
</head>

<body>
<div class="headerBar">
	<div class="logoBar login_logo">
		<div class="comWidth">
			<div class="logo fl">
<!--                放置logo处-->
			</div>
			<h3 class="welcome_title">欢迎登陆</h3>
		</div>
	</div>
</div>

<div class="loginBox">
	<div class="login_cont">
	<form action="doLogin.php" method="post">
			<ul class="login">
				<li class="l_tit">管理员帐号</li>
				<li class="mb_10"><input type="text"  name="username" placeholder="请输入管理员帐号"class="login_input user_icon" required></li>
				<li class="l_tit">密码</li>
				<li class="mb_10"><input type="password"  name="password" class="login_input password_icon" required></li>
				<li class="l_tit">验证码</li>
				<li class="mb_10"><input type="text"  name="verify" class="login_input password_icon"></li>
				<img src="getVerify.php" alt="" id="captcha_img"/>
				<a href="javascript:void(0)" onClick="document.getElementById('captcha_img').src='./getVerify.php?r='+Math.random()">换一个</a>
				<li class="autoLogin"><input type="checkbox" id="a1" class="checked" name="autoFlag" value="1"><label for="a1">自动登陆(一周内自动登陆)</label></li>
				<li><input type="submit" value="" class="login_btn"></li>
			</ul>
		</form>
	</div>
</div>

<div class="hr_25"></div>
<div class="footer">
	<p><a href="#">简介</a><i>|</i><a href="#">公告</a><i>|</i> <a href="#">招纳贤士</a><i>|</i><a href="#">联系我们</a><i>|</i>客服热线：400-000-1234</p>
	<p>Copyright &copy; 2006 - 2014 版权所有&nbsp;&nbsp;&nbsp;京ICP备12345678号&nbsp;&nbsp;&nbsp;京ICP证1234-4567号&nbsp;&nbsp;&nbsp;某市公安局XX分局备案编号：123456789123</p>
	<p class="web"><a href="#"><img src="images/webLogo.jpg" alt="logo"></a><a href="#"><img src="images/webLogo.jpg" alt="logo"></a><a href="#"><img src="images/webLogo.jpg" alt="logo"></a><a href="#"><img src="images/webLogo.jpg" alt="logo"></a></p>
</div>
</body>
</html>
