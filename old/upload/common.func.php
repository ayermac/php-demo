<?php 
/**
 * 得到文件扩展名
 * @param string $filename
 * @return string
 */
function getExt($filename){
	return strtolower(pathinfo($filename,PATHINFO_EXTENSION));

}
function getUniName(){
	return md5(uniqid(microtime(true),true));
}
?>