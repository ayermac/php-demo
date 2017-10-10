<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/6/12
 * Time: 11:33
 */
require_once "../include.php";
checkLogined();
$id=$_REQUEST["id"];
$res=getCateById($id)
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<body>

<h3>修改管理员</h3>
<form action="doAdminAction.php?act=editCate&id=<?php echo $id?>" method="post">
    <table width="60%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
        <tr>
            <td>分类名称</td>
            <td><input type="text" placeholder="" name="cName" value="<?php echo $res['cName'];?>" required></td>
        </tr>

        <tr>
            <td colspan="2"><input type="submit"  value="修改分类"/></td>
        </tr>
        </tr>
    </table>

</form>


</body>
</html>
