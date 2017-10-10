<?php
require_once '../configs/configs.php';
function connect(){
	$link=mysql_connect(DB_HOST,DB_USER,DB_PWD) or die("数据库连接失败Error:".mysql_error());
    mysql_set_charset(DB_CHARSET);
    mysql_select_db(DB_DBNAME) or die("数据库连接失败");
    return $link;
}

function insert($table,$array){
    $keys=join(",",array_keys($array));
    $vals="'".join("','",array_values($array))."'";
    $sql="insert {$table}($keys) values({$vals})";
    mysql_query($sql);
    return mysql_insert_id();
}

function update($table,$array,$where=null){
    foreach ($array as $key => $val) {
    	# code...
        if ($str==null) {
        	# code...
        	$sep="";
        }else{
        	$sep=",";
        }
        $str.=$sep.$key."='".$val."'";
       
    }
        $sql="update {$table} set {$str}".( $where==null?null:" where ".$where);
        $result=mysql_query($sql);
    if($result) {
        return mysql_affected_rows();
    }else{
        return false;
    }
}

function delete($table,$where=null){
    $where=$where==null?null:" where ".$where;
    $sql="delete from {$table} {$where}";
    mysql_query($sql);
    return mysql_affected_rows();
}

function fetchOne($sql,$result_type=MYSQL_ASSOC){
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result,$result_type);
    return $row;
}

function fetchAll($sql,$result_type=MYSQL_ASSOC){
    $result=mysql_query($sql);
    while(@$row=mysql_fetch_array($result,$result_type)){
        $rows[]=$row;
    }
    return $rows;
}

function getResultNum($sql){
	$result=mysql_query($sql);
	return mysql_num_rows($result);
}

function getInsertId(){
    return mysql_insert_id();
}
?>