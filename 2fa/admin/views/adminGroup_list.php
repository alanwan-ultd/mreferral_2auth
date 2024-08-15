<?php
$FILE_ROOT = '../';
$group = 'admin';
$name = 'adminGroup';
include_once('../inc/views/header.php');

if($mode == 'js'){
	header('Content-Type: application/javascript');
	include_once($FILE_ROOT.'inc/views/list.php');
?>
var columns = [
	{'data':'id'},
	{'data':'title'},
	{'data':'description'},
	{'data':'status', 'class':'dt-center'},
	{'data':'action', "orderable":false, 'class':'dt-center'},
];
var columnDefs = [
	//{targets: [0, 1], visible: false}
];
var order = [[0, "asc"]];
var paginate = true;
listDataTableCallBack = null;  //must be set in every xxxx_list.php
<?php
	exit();
}elseif($mode == 'json'){
	require_once(ROOT_DIR .'../models/'. strtolower($name) .'.php');
	$model = new $name;
	$rst = $model->getListCMS($name);
	//echo $db->getSql();
	header('Content-Type: application/json');
	echo json_encode(array('data'=>$rst));
	exit;
}else{
?>
<script src="views/<?php echo $name; ?>_list.php?mode=js"></script>
<script src="js/list.js"></script>

<div>
	<div class="fade-in">
		<table id="dataTable" class="display" style="width:100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Description</th>
					<th>Status</th>
					<th>Action&nbsp;&nbsp;&nbsp;&nbsp;</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Description</th>
					<th>Status</th>
					<th>Action&nbsp;&nbsp;&nbsp;&nbsp;</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?php 
	include_once('../inc/views/list-footer.php');
} ?>