<?php
     
     if(isset($_REQUEST['authcode']))
     {
        session_start();
        if (strtolower($_REQUEST['authcode'])==$_SESSION['authcode']) 
        {
            header('Content-type: text/html; charset=UTF8'); 
            echo '<font color="#0000CC">输入正确</font>';
        }
        else{
            header('Content-type: text/html; charset=UTF8'); 
            echo '<font color="#CC0000"><b>输入错误</b></font>';
            }
        exit();
     }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/> 
    <title>确认验证</title>
</head>
 <body>
  <form method="post" action="./form.php">
   <p>验证码图片：<img id="captcha_img" border="1" src="./captcha.php?r=<?php echo rand();?>" style="width:200px; height:60px"/>
    <a href="javascript:void(0)" onClick="document.getElementById('captcha_img').src='./captcha.php?r='+Math.random()">换一

个？</a>
   </p>
  
   <p>请输入图片的内容：<input type="text" name="authcode" value=""/></p>
   <p><input type="submit" value="提交" style="padding:6px 20px;"></p>
  </form>
 </body>
</html>