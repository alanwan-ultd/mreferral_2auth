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
		, {'data':'action', "orderable":false, 'class':'dt-center'}
		, {'data':'application_code'}
		, {'data':'property_addr'}
		, {'data':'mreferral_staff_name'}
		, {'data':'drawdown_date'}
		, {'data':'payment_date'}
		, {'data':'comm_to_pc'}
		, {'data':'create_datetime_display'}
	];
	var columnDefs = [
		{targets: [0], visible: false}
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
	<script src="js/commission-list.js?v=<?php echo $version; ?>"></script>

	<div>
		<div class="fade-in">
			<!-- Filter -->
			<div class="commission-filter">
				<div class="filter-header">
					<h6>Filter</h6>
					<span class="btn-collapse icon-keyboard_arrow_down"></span>
				</div>
				<div class="filter-group-wrapper">
					<hr>
					<div class="form-group">
						Last Modify Date: <input type="date" id="modify_fm" name="modify_fm" placeholder="eg. 2017-01-01">
						to <input type="date" id="modify_to" name="modify_to" placeholder="eg. 2017-01-31">
					</div>

					<div class="btn-group">
						<div class="btn btn-info btn-sm btn-filter">Filter</div>
						<div class="btn btn-light btn-sm btn-reset">Reset</div>
					</div>
				</div>
			</div>

			<div id="totalAmountDisplay">Total Amount: <b>$<span></span></b></div>

			<table id="dataTable" class="display" style="width:100%" data-table-id="2faCommissionTable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Action</th>
						<th>Application Code</th>
						<th>Property Address</th>
						<th>mReferral Staff Name</th>
						<th>Drawdown Date</th>
						<th>Payment Date</th>
						<th>Commission</th>
						<th>Upload Date</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Action</th>
						<th>Application Code</th>
						<th>Property Address</th>
						<th>mReferral Staff Name</th>
						<th>Drawdown Date</th>
						<th>Payment Date</th>
						<th>Commission</th>
						<th>Upload Date</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

<?php
	include_once('../inc/views/list-footer.php');
} ?>