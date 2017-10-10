<?php
require_once "../include.php";
checkLogined();
$pagesize=2;
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$sql="select * from shop_cate";
$totalRows=getResultNum($sql);
$totalPage=ceil($totalRows/$pagesize);
if($page<1||$page==null||!is_numeric($page)){
    $page=1;
}
if($page>$totalPage)$page=$totalPage;
$offset=($page-1)*$pagesize;
$sql="select id,cName from shop_cate order by id ASC limit {$offset},{$pagesize}";
$res=fetchAll($sql);

if(!$res){
    alertMes("sorry,没有分类,请添加!","addCate.php");
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
            <input type="button" value="添&nbsp;&nbsp;加" class="add" onclick="addCate()">
        </div>

    </div>
    <!--表格-->
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="15%">ID</th>
            <th width="25%">分类名称</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($res as $row){ ?>
            <tr>

                <!--这里的id和for里面的c1 需要循环出来-->
                <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
                <td><?php echo $row['cName']?></td>
                <td align="center"><input type="button" value="修改" class="btn" onclick="editCate(<?php echo $row['id'];?>)">
                    <input type="button" value="删除" class="btn" onclick="delCate(<?php echo $row['id'];?>)"></td>

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
    function addCate(){
        window.location="addCate.php";
    }

    function editCate(id){
        window.location="editCate.php?id="+id;
    }

    function delCate(id){
        if(window.confirm("您确定要删除吗？删除之后不可以恢复哦！！")){
            window.location="doAdminAction.php?act=delCate&id="+id;
        }
    }
</script>
</html>