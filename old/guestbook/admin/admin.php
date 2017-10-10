<?php
/**
* set title 
*/
//is admin login?
session_start();
if (!$_SESSION['admin']) {
	header('location:index.html');
}

require '../config.php';
require '../common/admin_header.php';
require '../mysql.class.php';

$gb_count_sql = 'SELECT count(*) FROM ' . GB_TABLE_NAME;
//connect db
DB::connect();
$gb_count_res = mysqli_query(DB::$con,$gb_count_sql);
$gb_count = mysqli_fetch_array($gb_count_res)[0];

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//计算留言数，得出分页数
$pagenum = ceil($gb_count / PER_PAGE_GB);
if ($page > $pagenum || $page < 0) {
	$page = 1;
}
// 限制搜索结果
$offset = ($page - 1) * PER_PAGE_GB;

$pagedata_sql = 'SELECT id,nickname,content,email,createtime,reply,replytime,status FROM ' . GB_TABLE_NAME . ' ORDER BY createtime DESC LIMIT ' . $offset . ',' . PER_PAGE_GB;
$sql_page_result = mysqli_query(DB::$con,$pagedata_sql);
if (!empty($sql_page_result)) {
	while($temp = mysqli_fetch_array($sql_page_result)) {
		$sql_page_array[] = $temp;
	}
}
DB::close();
?>
<div class="panel panel-info col-md-8 col-md-offset-2 ">
	<div class="panel-body ">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>id</th>
					<th>author</th>
					<th>content</th>
					<th>time</th>
					<th>status</th>
					<th>reply</th>
					<th>replytime</th>
					<th>options</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($sql_page_array as $key => $value) {
						echo "<tr>";
						echo "<td class='id'>" . $value['id'] . "</td>";
						echo "<td>" . $value['nickname'] . "</td>";
						echo "<td>" . $value['content'] . "</td>";
						echo "<td>" . $value['createtime'] . "</td>";
						echo "<td>" . $value['status'] . "</td>";
						echo "<td>" . (empty($value['reply']) ? 'no' : $value['reply']) . "</td>";
						echo "<td>" . (empty($value['replytime']) ? 'no' : $value['replytime']) . "</td>";
						echo "<td>" . (!empty($value['reply']) ? '' : '<input type="button" name="reply" value="reply" class="reply" data-toggle="modal" data-target=".replymodal"/> &nbsp;&nbsp;') . '<input type="button" class="option" value="'.($value["status"] == "1" ? "unlock" : "lock") .'"/>' ."</td>";
						echo "</tr>";
					}
						echo '<tr><td colspan="8">共 '.$gb_count.'&nbsp;&nbsp;条留言  ';
						if ($pagenum > 1) {
							for($i = 1; $i <= $pagenum; $i++) {
								if($i == $page) {
									echo '&nbsp;&nbsp;['.$i.']';
								} else {
									echo '<a href="?page='. $i .'">&nbsp;' . $i . '&nbsp;</a>';
								}
							}
						}
						echo "</td></tr>";
				 ?>
			</tbody>
		</table>
		<h4 style="text-align: center"><a href="logout.php" >Super admin logout</a></h4>
	</div>
	<!-- Large modal -->
	<div class="modal fade replymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Reply</h4>
			</div>
			<div class="modal-body">
				<div action="" class="form-horizontal" method="post" accept-charset="utf-8">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">ReplyContent:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="replycontent" name="reply" placeholder="内容(50个字符以内)">
							<input type="hidden" name="id" id="replyid" value="">
						</div>
						<button name="sub" id="sub">提交</button>
					</div>
				</div>
			</div>
	    </div>
	  </div>
	</div>
</div>

<script type="text/javascript" src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="../js/admin.js"></script>
<?php require '../common/footer.php';?>