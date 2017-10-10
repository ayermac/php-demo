<?php
//①开启php缓冲区
ob_start();

//实现一个简单静态化过程
for ($i=0; $i <20 ; $i++) { 
	# code...
	echo $i."<hr/>";
}

//②抓取php缓冲区内容
$cont=ob_get_contents();

//③利用抓取到的的内容制作静态页面(文件)
file_put_contents('01.shtml', $cont);

//④删除缓冲区内容并关闭
ob_end_clean();//关闭并清除缓冲区
//ob_end_flush();//关闭并刷新缓冲区
?>