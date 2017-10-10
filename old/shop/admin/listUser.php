<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/6/29
 * Time: 11:04
 */

require_once "../include.php";
checkLogined();
$pagesize=2;
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$res=getUserByPage($page,$pagesize);


if(!$res){
    alertMes("sorry,没有用户,请添加!","addUser.php");
    exit;
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>-.-</title>
    <link rel="stylesheet" href="styles/backstage.css">
</head>

<body>
<div class="details">
    <div class="details_operation clearfix">
        <div class="bui_select">
            <input type="button" value="添&nbsp;&nbsp;加" class="add" onclick="addUser()">
        </div>

    </div>
    <!--表格-->
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="15%">ID</th>
            <th width="25%">用户名称</th>
            <th width="25%">用户邮箱</th>
            <th width="15%">用户性别</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($res as $row){ ?>
            <tr>

                <!--这里的id和for里面的c1 需要循环出来-->
                <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
                <td><?php echo $row['username']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['sex']?></td>
                <td align="center"><input type="button" value="修改" class="btn" onclick="editUser(<?php echo $row['id'];?>)">
                    <input type="button" value="删除" class="btn" onclick="delUser(<?php echo $row['id'];?>)"></td>

            </tr>
        <?php }?>

        <?php if($totalRows>$pagesize){?>
            <tr>
                <td colspan="4"><?php echo showPage($page, $totalPage);?></td>
            </tr>
        <?php }?>

        </tbody>
    </table>
</div>

</body>
<script>
    function addUser(){
        window.location="addUser.php";
    }

    function editUser(id){
        window.location="editUser.php?id="+id;
    }

    function delUser(id){
        if(window.confirm("您确定要删除吗？删除之后不可以恢复哦！！！")){
            window.location="doAdminAction.php?act=delUser&id="+id;
        }
    }
</script>
</html>