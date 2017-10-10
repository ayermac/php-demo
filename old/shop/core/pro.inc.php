<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/6/14
 * Time: 10:46
 */
error_reporting(E_ERROR|E_PARSE|E_WARNING);
function addPro(){
    $arr=$_POST;
    $arr['pubTime']=time();
    $path="../images";
        $uploadFiles=uploadFile($path);
        if (is_array($uploadFiles) && $uploadFiles) {
            foreach ($uploadFiles as $key => $uploadFile) {
                thumb($path . "/" . $uploadFile['name'], "../image_50/".$uploadFile['name'], 50, 50);
                thumb($path . "/" . $uploadFile['name'], "../image_220/".$uploadFile['name'], 220, 220);
                thumb($path . "/" . $uploadFile['name'], "../image_350/".$uploadFile['name'], 350, 350);
                thumb($path . "/" . $uploadFile['name'], "../image_800/".$uploadFile['name'], 800, 800);
            }

            $res = insert("shop_pro", $arr);
            $pid = getInsertId();
            if ($res && $pid) {
                foreach ($uploadFiles as $uploadFile) {
                    $arr1['pid'] = $pid;
                    $arr1['albumPath'] = $uploadFile['name'];
                    addAlbum($arr1);
                }
                $mes = "<p>添加成功!</p><a href='addPro.php' target='mainFrame'>继续添加</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a>";

            } else {

                /*foreach($uploadFiles as $uploadFile){
                    if(file_exists("../image_800/".$uploadFile['name'])){
                        unlink("../image_800/".$uploadFile['name']);
                    }
                    if(file_exists("../image_50/".$uploadFile['name'])){
                        unlink("../image_50/".$uploadFile['name']);
                    }
                    if(file_exists("../image_220/".$uploadFile['name'])){
                        unlink("../image_220/".$uploadFile['name']);
                    }
                    if(file_exists("../image_350/".$uploadFile['name'])){
                        unlink("../image_350/".$uploadFile['name']);
                    }
                }*/

                $mes = "<p>添加失败!</p><a href='addPro.php' target='mainFrame'>重新添加</a>";

            }
        } else {
            alertMes("请添加附件", "../admin/addPro.php");
        }

    return $mes;
}
function getAllProByAdmin(){
    $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName from shop_pro as p join shop_cate c on p.cId=c.id";
    $rows=fetchAll($sql);
    return $rows;
}
function getProById($id){
    $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from shop_pro as p join shop_cate c on p.cId=c.id where p.id={$id}";
    $row=fetchOne($sql);
    return $row;
}

function getAllImgByProId($id){
    $sql="select a.albumPath from shop_album a where pid={$id}";
    $rows=fetchAll($sql);
    return $rows;
}

function editPro($id){
    $arr=$_POST;
    $arr['pubTime']=time();
    $path="../images";

    $uploadFiles=uploadFile($path);
    if(is_array($uploadFiles)&&$uploadFiles){
        foreach($uploadFiles as $key=>$uploadFile){
            thumb($path . "/" . $uploadFile['name'], "../image_50/".$uploadFile['name'], 50, 50);
            thumb($path . "/" . $uploadFile['name'], "../image_220/".$uploadFile['name'], 220, 220);
            thumb($path . "/" . $uploadFile['name'], "../image_350/".$uploadFile['name'], 350, 350);
            thumb($path . "/" . $uploadFile['name'], "../image_800/".$uploadFile['name'], 800, 800);
        }

    }
    $where="id={$id}";
    $res=update("shop_pro",$arr,$where);
    $pid=$id;
    //此处有一处小bug,商品信息修改时一定要修改商品信息再添加附件才能成功。只是添加附件会失败。
    if($res&&$pid){
        if($uploadFiles&&is_array($uploadFiles)){
            foreach($uploadFiles as $uploadFile){
                $arr1['pid']=$pid;
                $arr1['albumPath']=$uploadFile['name'];
                addAlbum($arr1);
            }
        }
        $mes="<p>编辑成功!</p><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
    }else{
        /*if(is_array($uploadFiles)&&$uploadFiles){
            foreach($uploadFiles as $uploadFile){
                if(file_exists("../image_800".$uploadFile['name'])){
                    unlink("../image_800".$uploadFile['name']);
                }
                if(file_exists("../image_50".$uploadFile['name'])){
                    unlink("../image_50".$uploadFile['name']);
                }
                if(file_exists("../image_220".$uploadFile['name'])){
                    unlink("../image_220".$uploadFile['name']);
                }
                if(file_exists("../image_350".$uploadFile['name'])){
                    unlink("../image_350".$uploadFile['name']);
                }
            }
        }*/
        $mes="<p>编辑失败!</p><a href='listPro.php' target='mainFrame'>重新编辑</a>";
    }
    return $mes;
}

function delPro($id){
    $where="id={$id}";
    $res=delete("shop_pro",$where);
    $proImgs=getAllImgByProId($id);
    if($proImgs&&is_array($proImgs)){
        foreach($proImgs as $proImg){
            if(file_exists("../images/".$proImg['albumPath'])){
                unlink("../images/".$proImg['albumPath']);
            }
            if(file_exists("../image_50/".$proImg['albumPath'])){
                unlink("../image_50/".$proImg['albumPath']);
            }
            if(file_exists("../image_220/".$proImg['albumPath'])){
                unlink("../image_220/".$proImg['albumPath']);
            }
            if(file_exists("../image_350/".$proImg['albumPath'])){
                unlink("../image_350/".$proImg['albumPath']);
            }
            if(file_exists("../image_800/".$proImg['albumPath'])){
                unlink("../image_800/".$proImg['albumPath']);
            }
        }
    }
    $where1="pid={$id}";
    $res1=delete("shop_album",$where1);
    if($res&&$res1){
        $mes="删除成功!<br/><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
    }else{
        $mes="删除失败!<br/><a href='listPro.php' target='mainFrame'>重新删除</a>";
    }
    return $mes;
}

//检查分类下是否有商品
function checkProExist($cid){
    $sql="select * from shop_pro where cId={$cid}";
    $rows=fetchAll($sql);
    return $rows;
}
//得到4条产品
function getProsByCid($id){
    $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from shop_pro as p join shop_cate c on p.cId=c.id where p.cId={$id} limit 4";
    $rows=fetchAll($sql);
    return $rows;
}



/**
 * 得到下4条产品
 * @param int $cid
 * @return array
 */
function getSmallProsByCid($cid){
    $sql="select p.id,p.pName,p.pSn,p.pNum,p.mPrice,p.iPrice,p.pDesc,p.pubTime,p.isShow,p.isHot,c.cName,p.cId from shop_pro as p join shop_cate c on p.cId=c.id where p.cId={$cid} limit 4,4";
    $rows=fetchAll($sql);
    return $rows;
}

function checkproId($id){
    if(!$id){
        alertMes("请先选择商品!","index.php");
    }
}
//得到商品的信息
function getProInfo(){
    $sql="select id,pName from shop_pro order by id ASC ";
    $row=fetchAll($sql);
    return $row;
}