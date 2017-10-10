<?php
require_once "../include.php";
checkLogined();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>

<h3>添加用户</h3>
<form action="doAdminAction.php?act=addUser" method="post" enctype="multipart/form-data">
    <table width="60%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td>用户名称</td>
            <td><input type="text" placeholder="请输入用户名" name="username" required></td>
        </tr>
        <tr>
            <td>用户密码</td>
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td>用户邮箱</td>
            <td><input type="text" name="email" required></td>
        </tr>
        <tr>
            <td>用户性别</td>
            <td><input type="radio" name="sex" value="1" checked="checked">男
                <input type="radio" name="sex" value="2">女
                <input type="radio" name="sex" value="3">保密
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit"  value="添加用户"/></td>
        </tr>
        </tr>
    </table>

</form>


</body>
</html>