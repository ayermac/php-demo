<?php
require_once "../include.php";
checkLogined();
$id=$_REQUEST['id'];
$sql="select username,email,sex from shop_user where id=".$id;
$res=fetchOne($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>

<h3>修改用户</h3>
<form action="doAdminAction.php?act=editUser&id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
    <table width="60%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td>用户名称</td>
            <td><input type="text" value="<?php echo $res['username'];?>" name="username" required></td>
        </tr>
        <tr>
            <td>用户密码</td>
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td>用户邮箱</td>
            <td><input type="text" name="email" value="<?php echo $res['email'];?>" required></td>
        </tr>
        <tr>
            <td>用户性别</td>
            <td><input type="radio" name="sex" value="1" <?php echo ($res['sex']=="男")?"checked='checked'":null?>">男
                <input type="radio" name="sex" value="2" <?php echo ($res['sex']=="女")?"checked='checked'":null?>">女
                <input type="radio" name="sex" value="3" <?php echo ($res['sex']=="保密")?"checked='checked'":null?>">保密
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit"  value="修改用户"/></td>
        </tr>
        </tr>
    </table>

</form>


</body>
</html>