<?php require_once 'common/header.php'; ?>
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-primary ">
    <div class="panel-heading"><h2>PHP 留言本</h2></div>
<div class="panel-body">

<?php

require 'config.php';
require 'mysql.class.php';

$gb_count_sql = 'SELECT count(*) FROM ' . GB_TABLE_NAME . ' WHERE status = 0';

DB::connect();

$gb_count_res = DB::$con->query($gb_count_sql);
$gb_count = $gb_count_res->fetch_row()[0];

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$pagenum = ceil($gb_count / PER_PAGE_GB);
if($page > $pagenum || $page < 0){
	$page = 1;
}

$offset = ($page - 1) * PER_PAGE_GB;

$pagedata_sql = 'SELECT nickname,content,email,createtime,reply,replytime FROM '.GB_TABLE_NAME . ' WHERE status = 0 ORDER BY createtime DESC LIMIT ' . $offset .',' . PER_PAGE_GB;

$sql_page_result = DB::$con->query($pagedata_sql);
// var_dump($sql_page_result);
while ($temp = $sql_page_result->fetch_array()) {
	$sql_page_array[] = $temp;
}

DB::close();

if(!empty($sql_page_array)){
	//循环打印出留言内容
	foreach ($sql_page_array as $key => $value) {
		echo '<div style="background-color:#F7F7F9"><li class="list-group-item list-group-item-info">留言者：<span>'. $value['nickname'].'</span> ' . (empty($value['email']) ? '' : ' &nbsp;&nbsp;  |  &nbsp;&nbsp; 邮箱：'.$value['email']);
		echo '<span style="float:right;">时间：' . $value['createtime'] .'</span></li>';
        		echo '<li class="list-group-item l">内容：' . $value['content'] .'</li>';

        		if(!empty($value['reply'])){
        			echo '<li class="list-group-item list-group-item-warning">管理员回复: '.$value['reply'];
        			echo '<span style="float:right">回复时间:'.$value['replytime'].'</span></li>';
        		}
        		echo '</div><hr>';

	}
}

echo '共'.$gb_count.'条留言';
if($pagenum > 1){
	for($i = 1;$i<=$pagenum;$i++){
		if($i == $page){
			echo '&nbsp;&nbsp;['.$i.']';
		}else{
			echo '<a href="?page='. $i .'">&nbsp;' . $i . '&nbsp;</a>';
		}
	}
}


?>
</div>
<div class="panel-footer"></div>
<div id="post">
<form name="message_submit" id="defaultForm" method="post" class="form-horizontal" >
	<div class="form-group">
	            <label for="" class="col-sm-2 control-label">姓名:</label>
	            <div class="col-lg-4">
                                <input type="text" class="form-control" name="nickname"  id="nickname" />
                        </div>
	</div>
	<div class="form-group">
	            <label for="" class="col-sm-2 control-label">内容:</label>
	            <div class="col-sm-4">
			<input type="text" name="content" class="form-control" id="content"  />
	            </div>
	</div>
	<div class="form-group">
	            <label for="" class="col-sm-2 control-label">E-Mail:</label>
	            <div class="col-sm-4">
			<input type="text" name="email" class="form-control" id="email" required data-bv-trigger="keyup" data-bv-notempty-message="邮箱不能为空" />
	            </div>
	</div>

	<div class="form-group">
	            <label for="" class="col-sm-2 control-label"></label>
	            <div class="col-sm-6">
			<button type="button" class="btn btn-primary" name="validateBtn" id="validateBtn">留言</button>
			<button type="reset" class="btn btn-primary" id="resetBtn">重置</button>
	            </div>
	</div>
</form>
</div>
</div>
</div>
</div>
<?php require 'common/footer.php'; ?>
<script type="text/javascript" src="js/validator.js"></script>
<script type="text/javascript" src="js/ajax_submit.js"></script>

