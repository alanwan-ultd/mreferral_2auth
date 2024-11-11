<?php
$FILE_ROOT = '../';
$group = '';
$name = 'commission';
$controller = '';
include_once('../inc/views/header.php');

if ($mode == 'js') {
	header('Content-Type: application/javascript');
	$js = <<<JAVASCRIPT
	var approvalTitleBind = 'xxxxx'; //xxxxx when not use
	//ckeditor, ckfinder
	var ckfinderResourceType = '';
	var ckEditorCallBackFn = function(){
		
	};
	var ckEditorOptsCustom_heading = undefined;
	var ckEditorOptsCustom_toolbar = undefined;
JAVASCRIPT;

	echo $js;
	exit;
}

include_once('../inc/HtmlBuilderCMS.php');
$form = new HtmlBuilderCMS();

require_once(ROOT_DIR . '../models/' . strtolower($name) . '.php');
$model = new $name;
$item = $model->getOriginItemById($id);

// echo $db->getSql();

// generate back url
$backParams = [];
// end of generate back url

$layout = assignCMSControlBtnPermission(
	array(false, false, false, false, "", false, false, true, false),
	$sectionPermission
);
// $approvalTitle = $item[0]['title_i18n'];
?>
<style>
	.card-footer {
		display: none;
	}
</style>
<link rel="stylesheet" href="css/ckeditor/style.css" type="text/css"><!-- open if having ckeditor -->
<script src="views/<?php echo $name; ?>_edit.php?mode=js"></script>
<script src="js/popovers.js"></script>
<script src="js/edit.js"></script>
<script src="js/location-google-map.js?v=3"></script>
<!--script src="js/edit.php"></script-->
<form id="myForm" name="myForm" class="form-horizontal" action="views/<?php echo $name; ?>_save.php">
	<div class="col-lg-12 edit-page">
		<?php if ($approval_id) { ?>
			<a href="submitApproval_list.php" class="btn btn-back c-xhr-link"><i class="icon-arrow_back_ios mr-1"></i>Back to Approval List</a>
			<input type="hidden" name="approval_id" value="<?php echo $approval_id; ?>">
		<?php } else { ?>
			<!-- a href="<?php echo $name; ?>_list.php" class="btn btn-back c-xhr-link"><i class="icon-arrow_back_ios mr-1"></i>Back</!-- -->
			<a href="<?php echo $name; ?>_list.php" class="btn btn-back c-xhr-link"><i class="icon-arrow_back_ios mr-1"></i>Back</a>
		<?php } ?>

		<div class="card">
			<div class="card-header"><strong>Itinerary Item</strong></div>
			<div class="card-body">
				<?php
				echo $form->htmlLabel('Type Code', $item[0]['commission_data']['type_code']);
				echo $form->htmlLabel('Application Code', $item[0]['commission_data']['application_code']);
				echo $form->htmlLabel('mReferral Staff Name', $item[0]['commission_data']['mreferral_staff_name']);
				echo $form->htmlLabel('Tel No', $item[0]['commission_data']['tel_no']);
				echo $form->htmlLabel('Team Head', $item[0]['commission_data']['team_head']);
				echo $form->htmlLabel('Team Head Phone No', $item[0]['commission_data']['team_head_phone_no']);
				echo $form->htmlLabel('Payment Date', $item[0]['commission_data']['payment_date']);
				echo $form->htmlLabel('Staff No', $item[0]['commission_data']['staff_no']);
				echo $form->htmlLabel('Staff Name', $item[0]['commission_data']['staff_name']);
				echo $form->htmlLabel('Staff Bank Acc', $item[0]['commission_data']['staff_bank_acc']);
				echo $form->htmlLabel('Comm To PC', $item[0]['commission_data']['comm_to_pc']);
				echo $form->htmlLabel('Department Head ID', $item[0]['commission_data']['department_head_id']);
				echo $form->htmlLabel('Department Head Name', $item[0]['commission_data']['department_head_name']);
				echo $form->htmlLabel('Department Head Bank Account', $item[0]['commission_data']['department_head_bank_account']);
				echo $form->htmlLabel('Commission Branch Mgr', $item[0]['commission_data']['commission_branch_mgr']);
				echo $form->htmlLabel('Branch', $item[0]['commission_data']['branch']);
				?>
				<input name="status" type="hidden" value="A" />
			</div><!-- card body-->
			<?php include_once('../inc/views/edit-footer.php'); ?>
		</div><!-- card -->

	</div><!-- col -->
</form>