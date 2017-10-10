<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/5
 * Time: 15:56
 */
require_once 'dir.func.php';
require_once 'file.func.php';
require_once 'common.func.php';
error_reporting(E_ERROR|E_WARNING|E_PARSE);
$path="file";
//$path=$_REQUEST['path']?$_REQUEST['path']:$path;
$act=$_REQUEST['act'];
$filename=$_REQUEST['filename'];
$info=readDirectory($path);
//print_r(readDirectory($path));
if(!$info){
    echo "<script>alert('没有文件或目录！！！');</script>";
}
$redirect="index.php?path={$path}";
if($act=="创建文件"){
    if($filename!=="") {
        $mes = createFile($path . "/" .$filename);
        alertMes($mes, $redirect);
    }
}else if($act=="showContent"){
    $content=file_get_contents($filename);
    if(strlen($content)){
        $newContent=highlight_string($content,true);
        $str=<<<EOF
        <table width="100%" bgcolor='pink' cellpadding='5' cellspacing='0'>
        <tr>
            <td>{$newContent}</td>
        </tr>
        </table>
EOF;
        echo $str;
    }else{
        alertMes("文件没有内容，请编辑再查看!",$redirect);
    }
}
?>
<html>
<head>
    <title>WEB在线文件管理器</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="cikonss.css" />
    <script src="jquery-ui/js/jquery-1.10.2.js"></script>
    <script src="jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <link rel="stylesheet" href="jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css"  type="text/css"/>
    <style type="text/css">
        body,p,div,ul,ol,table,dl,dd,dt{
            margin:0;
            padding: 0;
        }
        a{
            text-decoration: none;
        }
        ul,li{
            list-style: none;
            float: left;
        }
        #top{
            width:100%;
            height:48px;
            margin:0 auto;
            background: #E2E2E2;
        }
        #navi a{
            display: block;
            width:48px;
            height: 48px;
        }
        #main{
            margin:0 auto;
            border:2px solid #ABCDEF;
        }
        .small{
            width:25px;
            height:25px;
            border:0;
        }
    </style>
    <script>
       function show(dis){
           document.getElementById(dis).style.display="block";
       }

       function creatTxt() {
           $createTxt = document.getElementById("createTxt").value;
           if ($createTxt == "") {
               alert("文件名不能为空");
           }
       }

       function showDetail(t,filename){
           $("#showImg").attr("src",filename);
           $("#showDetail").dialog({
              height:"auto",
              width:"auto",
               position: {my: "center", at: "center",  collision:"fit"},
               modal:false,//是否模式对话框
               draggable:true,//是否允许拖拽
               resizable:true,//是否允许拖动
               title:t,//对话框标题
               show:"slide",
               hide:"explode"

           });
       }
    </script>
</head>
<body>

<div id="showDetail"  style="display:none"><img src="" id="showImg" alt=""/></div>
<h1>在线文件管理器</h1>
<div id="top">
    <ul id="navi">
        <li><a href="index.php" title="主目录"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-home"></span></span></a></li>
        <li><a href="#"  onclick="show('createFile')" title="新建文件" ><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-file"></span></span></a></li>
        <li><a href="#"  onclick="show('createFolder')" title="新建文件夹"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-folder"></span></span></a></li>
        <li><a href="#" onclick="show('uploadFile')"title="上传文件"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-upload"></span></span></a></li>
        <?php
        $back=($path=="file")?"file":dirname($path);
        ?>
        <li><a href="#" title="返回上级目录" onclick="goBack('<?php echo $back;?>')"><span style="margin-left: 8px; margin-top: 0px; top: 4px;" class="icon icon-small icon-square"><span class="icon-arrowLeft"></span></span></a></li>
    </ul>
</div>
<form action="index.php" method="post" enctype="multipart/form-data">
    <table width="100%" border="1" cellpadding="5" cellspacing="0" bgcolor="#ABCDEF" align="center">
        <tr id="createFolder"  style="display:none;">
            <td>请输入文件夹名称</td>
            <td >
                <input type="text" name="dirname" />
                <input type="hidden" name="path"  value="<?php echo $path;?>"/>
                <input type="submit"  name="act"  value="创建文件夹"/>
            </td>
        </tr>
        <tr id="createFile"  style="display:none;">
            <td>请输入文件名称</td>
            <td >
                <input type="text"  id="createTxt" name="filename" />
                <input type="hidden" name="path" value="<?php echo $path;?>"/>
                <input type="submit"  name="act" value="创建文件" onclick="creatTxt()"/>
            </td>
        </tr>
        <tr id="uploadFile" style="display:none;">
            <td >请选择要上传的文件</td>
            <td ><input type="file" name="myFile" />
                <input type="submit" name="act" value="上传文件" />
            </td>
        </tr>
        <tr>
            <td>编号</td>
            <td>名称</td>
            <td>类型</td>
            <td>大小</td>
            <td>可读</td>
            <td>可写</td>
            <td>可执行</td>
            <td>创建时间</td>
            <td>修改时间</td>
            <td>访问时间</td>
            <td>操作</td>
        </tr>
        <?php
        if($info['file']){
            $i=1;
            foreach($info['file'] as $val){
                $p=$path."/".$val;
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $val;?></td>
                    <td><?php $src=filetype($p)=="file"?"file_ico.png":"folder_ico.png";?><img src="images/<?php echo $src;?>" alt=""  title="文件"/></td>
                    <td><?php echo transByte(filesize($p));?></td>
                    <td><?php $src=is_readable($p)?"correct.png":"error.png"?><img class="small" src="images/<?php echo $src?>"/></td>
                    <td><?php $src=is_writable($p)?"correct.png":"error.png";?><img class="small" src="images/<?php echo $src;?>" alt=""/></td>
                    <td><?php $src=is_executable($p)?"correct.png":"error.png";?><img class="small" src="images/<?php echo $src;?>" alt=""/></td>
                    <td><?php echo date("Y-m-d H:i:s",filectime($p));?></td>
                    <td><?php echo date("Y-m-d H:i:s",filemtime($p));?></td>
                    <td><?php echo date("Y-m-d H:i:s",fileatime($p));?></td>
                    <td>
                        <?php
                        //得到文件扩展名
                        $ext=strtolower(end(explode(".",$val)));
                        $imageExt=array("gif","jpg","jpeg","png");
                        if(in_array($ext,$imageExt)){
                            ?>
                            <a href="#"  onclick="showDetail('<?php echo $val;?>','<?php echo $p;?>')"><img class="small" src="images/show.png"  alt="" title="查看"/></a>|
                            <?php
                        }else{
                            ?>
                            <a href="index.php?act=showContent&path=<?php echo $path;?>&filename=<?php echo $p;?>" ><img class="small" src="images/show.png"  alt="" title="查看"/></a>|
                        <?php }?>
                        <a href="index.php?act=editContent&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small" src="images/edit.png"  alt="" title="修改"/></a>|
                        <a href="index.php?act=renameFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small" src="images/rename.png"  alt="" title="重命名"/></a>|
                        <a href="index.php?act=copyFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small" src="images/copy.png"  alt="" title="复制"/></a>|
                        <a href="index.php?act=cutFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small" src="images/cut.png"  alt="" title="剪切"/></a>|
                        <a href="#"  onclick="delFile('<?php echo $p;?>','<?php echo $path;?>')"><img class="small" src="images/delete.png"  alt="" title="删除"/></a>|
                        <a href="index.php?act=downFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img class="small"  src="images/download.png"  alt="" title="下载"/></a>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }



        ?>

        <!-- 读取目录的操作-->
        <?php
        if($info['dir']){
            $i=$i==null?1:$i;
            foreach($info['dir'] as $val){
                $p=$path."/".$val;
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><?php echo $val;?></td>
                    <td><?php $src=filetype($p)=="file"?"file_ico.png":"folder_ico.png";?><img src="images/<?php echo $src;?>" alt=""  title="文件"/></td>
                    <td><?php  $sum=0; echo transByte(dirSize($p));?></td>
                    <td><?php $src=is_readable($p)?"correct.png":"error.png";?><img class="small" src="images/<?php echo $src;?>" alt=""/></td>
                    <td><?php $src=is_writable($p)?"correct.png":"error.png";?><img class="small" src="images/<?php echo $src;?>" alt=""/></td>
                    <td><?php $src=is_executable($p)?"correct.png":"error.png";?><img class="small" src="images/<?php echo $src;?>" alt=""/></td>
                    <td><?php echo date("Y-m-d H:i:s",filectime($p));?></td>
                    <td><?php echo date("Y-m-d H:i:s",filemtime($p));?></td>
                    <td><?php echo date("Y-m-d H:i:s",fileatime($p));?></td>
                    <td>
                        <a href="index.php?path=<?php echo $p;?>" ><img class="small" src="images/show.png"  alt="" title="查看"/></a>|
                        <a href="index.php?act=renameFolder&path=<?php echo $path;?>&dirname=<?php echo $p;?>"><img class="small" src="images/rename.png"  alt="" title="重命名"/></a>|
                        <a href="index.php?act=copyFolder&path=<?php echo $path;?>&dirname=<?php echo $p;?>"><img class="small" src="images/copy.png"  alt="" title="复制"/></a>|
                        <a href="index.php?act=cutFolder&path=<?php echo $path;?>&dirname=<?php echo $p;?>"><img class="small" src="images/cut.png"  alt="" title="剪切"/></a>|
                        <a href="#"  onclick="delFolder('<?php echo $p;?>','<?php echo $path;?>')"><img class="small" src="images/delete.png"  alt="" title="删除"/></a>|
                    </td>
                </tr>
                <?php
                $i++;
            }
        }

        ?>




    </table>
</form>
</body>
</html>
