<?php
$FILE_ROOT = '../';
$group = '';
$name = 'commission';
include_once('../inc/views/header.php');

if ($mode == 'js') {
	header('Content-Type: application/javascript');
	include_once($FILE_ROOT . 'inc/views/list.php');

	$js = <<<JAVASCRIPT

	var columns = [
		{'data':'id'}
		, {'data':'type_code'}
		, {'data':'application_code'}
		, {'data':'property_addr'}
		, {'data':'mreferral_staff_name'}
		, {'data':'drawdown_date'}
		, {'data':'payment_date'}
		, {'data':'comm_to_pc'}
		, {'data':'action', "orderable":false, 'class':'dt-center'}
	];
	var columnDefs = [
	//{targets: [0, 1], visible: false}
	];
	var order = [[0, "desc"]];
	var paginate = true;
	listDataTableCallBack = null; //must be set in every xxxx_list.php

	JAVASCRIPT;
	echo $js;
	exit();
} elseif ($mode == 'json') {
	require_once(ROOT_DIR . '../models/' . strtolower($name) . '.php');
	$model = new $name;
	$rst = $model->getListCMS($name);
	//echo $db->getSql();
	header('Content-Type: application/json');
	echo json_encode(array('data' => $rst));
	exit;
} else {
?>
	<script src="views/<?php echo $name; ?>_list.php?mode=js"></script>
	<script src="js/list.js"></script>

	<div>
		<div class="fade-in">
			<table id="dataTable" class="display" style="width:100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Type Code</th>
						<th>Application Code</th>
						<th>Property Address</th>
						<th>mReferral Staff Name</th>
						<th>Drawdown Date</th>
						<th>Payment Date</th>
						<th>Comm to PC</th>
						<th>Action</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Type Code</th>
						<th>Application Code</th>
						<th>Property Address</th>
						<th>mReferral Staff Name</th>
						<th>Drawdown Date</th>
						<th>Payment Date</th>
						<th>Comm to PC</th>
						<th>Action</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

<?php
	include_once('../inc/views/list-footer.php');
} ?>