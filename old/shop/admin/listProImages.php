<?php
require_once '../include.php';
checkLogined();
//$rows=getProInfo();
$order=$_REQUEST['order']?$_REQUEST['order']:null;
$orderBy=$order?"order by p.".$order:null;
$keywords=$_REQUEST['keywords']?$_REQUEST['keywords']:null;
$where=$keywords?"where pName like '%{$keywords}%'":null;

$sql="select id,pName from shop_pro {$where}  ";
$totalRows=getResultNum($sql);
$pageSize=5;
$totalPage=ceil($totalRows/$pageSize);
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select id,pName from shop_pro {$where} {$orderBy} limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
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
            <input type="button" value="添&nbsp;&nbsp;加" class="add" onclick="addPro()">
        </div>
        <div class="fr">
            <div class="text">
                <span>商品价格：</span>
                <div class="bui_select">
                    <select id="" class="select" onchange="change(this.value)">
                        <option>-请选择-</option>
                        <option value="iPrice asc" >由低到高</option>
                        <option value="iPrice desc">由高到底</option>
                    </select>
                </div>
            </div>
            <div class="text">
                <span>上架时间：</span>
                <div class="bui_select">
                    <select id="" class="select" onchange="change(this.value)">
                        <option>-请选择-</option>
                        <option value="pubTime desc" >最新发布</option>
                        <option value="pubTime asc">历史发布</option>
                    </select>
                </div>
            </div>
            <div class="text">
                <span>搜索</span>
                <input type="text" value="" class="search"  id="search" onkeypress="search()" >
            </div>
        </div>
    </div>
    <!--表格-->
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="10%">编号</th>
            <th width="20%">商品名称</th>
            <th width="50%">商品图片</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($rows as $row):?>
            <tr>
                <!--这里的id和for里面的c1 需要循环出来-->
                <td><input  type="checkbox" id="c<?php echo $row['id'];?>" class="check" value=<?php echo $row['id'];?>><label for="c1" class="label"><?php echo $row['id'];?></label></td>

                <td><?php echo $row['pName']; ?></td>
                <td>
                    <?php
                    $proImgs=getAllImgByProId($row['id']);
                    foreach($proImgs as $img):
                        ?>
                        <img width="100" height="100" src="../images/<?php echo $img['albumPath'];?>" alt=""/> &nbsp;&nbsp;
                    <?php endforeach;?>
                </td>
                <td>

                    <input type="button" value="添加文字水印" onclick="doImg('<?php echo $row['id'];?>','waterText')" class="btn"/>

                    <br/>
                    <input type="button" value="添加图片水印" onclick="doImg('<?php echo $row['id'];?>','waterPic')" class="btn"/>
                </td>




            </tr>
        <?php  endforeach;?>
        <?php if($totalRows>$pageSize):?>
            <tr>
                <td colspan="7"><?php echo showPage($page, $totalPage,"keywords={$keywords}&order={$order}");?></td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function doImg(id,act){
        window.location="doAdminAction.php?act="+act+"&id="+id;
    }
    function addPro(){
        window.location="addPro.php";
    }
    function change(val){
        window.location="listProImages.php?order="+val;
    }
    function search(){
        if(event.keyCode==13){
            var val=document.getElementById("search").value;
            window.location="listProImages.php?keywords="+val;
        }
    }
</script>
</body>
</html>