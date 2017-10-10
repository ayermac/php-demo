<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/12
 * Time: 21:27
 */
function addCate(){
    $arr=$_POST;
    if(insert("shop_cate",$arr)){
        $mes="分类添加成功!<br/><a href='addCate.php'>继续添加</a>|<a href='listCate.php'>查看分类</a>";
    }else{
        $mes="分类添加失败！<br/><a href='addCate.php'>重新添加</a>|<a href='listCate.php'>查看分类</a>";
    }
    return $mes;
}
function editCate($id){
    $arr=$_POST;
    if(update("shop_cate",$arr,"id={$id}")){
        $mes="修改成功!<br/><a href='listCate.php'>查看分类列表</a>";
    }else{
        $mes="修改失败!<br/><a href='list-*20Cate.php'>请重新修改</a>";
    }
    return $mes;

}

function delCate($id){
   $res=checkProExist($id);
    if(!$res){
        $where="id=".$id;
        if(delete("shop_cate",$where)){
            $mes="分类删除成功!<br/><a href='listCate.php'>查看分类</a>|<a href='addCate.php'>添加分类</a></a>";
        }else{
            $mes="删除失败！<br/><a href='listCate.php'>请重新操作</a>";
        }
        return $mes;
    }else{
        alertMes("不能删除分类，请先删除分类下的商品!","listPro.php");
    }
}

function getCateById($id){
    $sql="select id,cName from shop_cate where id=".$id;
    return fetchOne($sql);

}

function getAllCate(){
    $sql="select id,cName from shop_cate";
    $rows=fetchAll($sql);
    return $rows;
}


?>