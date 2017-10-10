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

    <h3>添加管理员</h3>
    <form action="doAdminAction.php?act=addAdmin" method="post">
        <table width="60%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
            <tr>
                <td>管理员名称</td>
                <td><input type="text" placeholder="请输入管理员用户名" name="username" required></td>
            </tr>
            <tr>
                <td>管理员密码</td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td>管理员邮箱</td>
                <td><input type="text" placeholder="请输入管理员邮箱" name="email" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit"  value="添加管理员"/></td>
            </tr>
            </tr>
        </table>

    </form>


</body>
</html>