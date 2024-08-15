<?php
$FILE_ROOT = '../';
$group = 'admin';
$name = 'adminGroup';
include_once('../inc/views/header.php');

if($mode == 'js'){
	header('Content-Type: application/javascript');
?>
var approvalTitleBind = 'xxxxx';  //xxxxx when not use
//ckeditor, ckfinder
var ckfinderResourceType = '';
var ckEditorCallBackFn = function(){};
var ckEditorOptsCustom_heading = undefined;
//var ckEditorOptsCustom_toolbar = undefined;
<?php
	exit;
}

include_once('../inc/HtmlBuilderCMS.php');
$form = new HtmlBuilderCMS();

require_once(ROOT_DIR .'../models/'. strtolower($name) .'.php');
$model = new $name;
$items = $model->getItemById($id);
$item = $items[0];
//echo $db->getSql();
//var_dump($item);

//default
$layout = assignCMSControlBtnPermission(
	array(true, true, 'normal', true, false, false, false),
	$sectionPermission
);

$sectionModel = new Section('');
$sectionModelList = $sectionModel->getCMSSection(); //echo '<pre>';var_dump($sectionModelList);echo '</pre>';
$sectionModelListCMS = $sectionModel->getPermissionByGroupId($id); //echo '<pre>';var_dump($sectionModelListCMS);echo '</pre>';

//permission overwrite
if($id == 1){
	$layout['statusSwitch'] = false;
	$layout['deleteBtn'] = false;
}
?>
<script src="views/<?php echo $name; ?>_edit.php?mode=js"></script>
<script src="js/edit.js"></script>
<script src="js/edit.php"></script>
<form id="myForm" name="myForm" class="form-horizontal" action="views/<?php echo $name; ?>_save.php">
	<div class="col-lg-12 edit-page">
		<a href="<?php echo $name; ?>_list.php" class="btn btn-back c-xhr-link"><i class="icon-arrow_back_ios mr-1"></i>Back</a>
		<div class="card">
			<div class="card-header"><strong>Admin Group</strong></div>
			<div class="card-body">
<?php
echo $form->htmlInputText('Title', 'title', $item['title'], '', 255, 'required');
echo $form->htmlTextarea('Description', 'description', $item['description'], '', 255, 'required');
?>
		<div class="row mb-3">
			<div class="col-sm-3"><h6>Page</h6></div>
			<div class="col-sm-3 col-4"><h6>Read</h6></div>
			<div class="col-sm-3 col-4"><h6>Write</h6></div>
			<div class="col-sm-3 col-4"><h6>Approve</h6></div>
		</div>
<?php
foreach($sectionModelList AS $key => $value){
	if($value[1] == '') continue;
	if($id == 1){  //fixed value if it is admingroup id = 1
?>
		<div class="row mb-3">
			<div class="col-sm-3 mb-2"><?php echo ($value[0] != '')?$value[1]:'<h6>'.$value[1].'</h6>'; ?></div>
			<div class="col-sm-3 col-4"><?php echo ($value[0] != '')?renderFormSwitch(true, '', 'r[]', $value[0]):''; ?></div>
			<div class="col-sm-3 col-4"><?php echo ($value[0] != '')?renderFormSwitch(true, '', 'w[]', $value[0]):''; ?></div>
			<div class="col-sm-3 col-4"><?php echo ($value[0] != '')?renderFormSwitch(true, '', 'a[]', $value[0]):''; ?></div>
		</div>
<?php }else{ ?>
		<div class="row mb-3">
			<div class="col-sm-3 mb-2"><?php echo ($value[0] != '')?$value[1]:'<h6>'.$value[1].'</h6>'; ?></div>
			<div class="col-sm-3 col-4"><?php echo ($value[0] != '')?renderFormSwitch( isset($sectionModelListCMS[$value[0]]) ? $sectionModelListCMS[$value[0]][0] : false, '', 'r[]', $value[0]):''; ?></div>
			<div class="col-sm-3 col-4"><?php echo ($value[0] != '')?renderFormSwitch( isset($sectionModelListCMS[$value[0]]) ? $sectionModelListCMS[$value[0]][1] : false, '', 'w[]', $value[0]):''; ?></div>
			<div class="col-sm-3 col-4"><?php echo ($value[0] != '')?renderFormSwitch( isset($sectionModelListCMS[$value[0]]) ? $sectionModelListCMS[$value[0]][2] : false, '', 'a[]', $value[0]):''; ?></div>
		</div>
<?php
	}
}
?>
			</div><!-- card body-->
			<?php include_once('../inc/views/edit-footer.php'); ?>
		</div><!-- card -->
	</div><!-- col -->
</form>
