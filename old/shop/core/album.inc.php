<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/6/14
 * Time: 11:20
 */
function addAlbum($arr){
    insert("shop_album",$arr);
}
//得到1张产品图片
function getProImgById($id){
    $sql="select albumPath from shop_album where pid={$id} limit 1";
    $row=fetchOne($sql);
    return $row;
}
//得到所有产品图片
function getProImgsById($id){
    $sql="select albumPath from shop_album where pid={$id}";
    $row=fetchAll($sql);
    return $row;
}
//添加文字水印
function doWaterText($id){
    if($row=getProImgsById($id)) {
        foreach ($row as $row) {
            $filename = "../image_800/" . $row['albumPath'];
            waterText($filename);
        }
        $mes = "操作成功<br/><a href='../admin/listProImages.php'>返回</a>";
    }else{
        $mes="操作失败<br/><a href='../admin/listProImages.php'>返回</a>";
    }
    return $mes;
}
function doWaterPic($id){
    if($row=getProImgsById($id)) {
        foreach ($row as $row) {
            $filename = "../image_800/" . $row['albumPath'];
            waterPic($filename);
        }
        $mes = "操作成功<br/><a href='../admin/listProImages.php'>返回</a>";
    }else{
        $mes="操作失败<br/><a href='../admin/listProImages.php'>返回</a>";
    }
    return $mes;
}