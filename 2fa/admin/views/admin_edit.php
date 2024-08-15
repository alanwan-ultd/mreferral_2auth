<?php
$FILE_ROOT = '../';
$group = 'admin';
$name = 'admin';
$sectionPermissionByPass = true;
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

if(isset($_SESSION['sales_id']) && $_SESSION['sales_id'] == $id){
	//same user, view user profile
	$sectionPermission[1] = 1;
}

require_once(ROOT_DIR .'../models/'. strtolower($name) .'.php');
$user = new $name;
$items = $user->getItemById($id);
$item = $items[0];
//echo $db->getSql();
//default
$layout = assignCMSControlBtnPermission(
	array(true, true, 'normal', true, false, false, false),
	$sectionPermission
);

//permission overwrite
if($id == 1){  //cannot delete admin
	$layout['statusSwitch'] = false;
	$layout['deleteBtn'] = false;
}
if(isset($_SESSION['sales_id']) && $_SESSION['sales_id'] == $id && $sectionPermission[0] == 0){  //cannot delete self
	$layout['statusSwitch'] = false;
	$layout['deleteBtn'] = false;
	$layout['backBtn'] = false;
}
?>
<script src="views/<?php echo $name; ?>_edit.php?mode=js"></script>
<script src="js/popovers.js"></script>
<script src="js/edit.js"></script>
<script src="js/admin_edit.js"></script>
<script src="js/edit.php"></script>
<form id="myForm" name="myForm" class="form-horizontal">
	<div class="col-lg-12 edit-page">
	<?php if(!isset($layout['backBtn'])){ ?><a href="<?php echo $name; ?>_list.php" class="btn btn-back c-xhr-link"><i class="icon-arrow_back_ios mr-1"></i>Back</a><?php } ?>
		<div class="card">
			<div class="card-header"><strong>Admin User</strong></div>
			<div class="card-body">
<?php

echo $form->htmlInputText('Username', 'login', $item['login'], '', 255, 'required'.$isReadOnly);

echo $form->htmlInputText('Name', 'name', $item['name'], '', 255, 'required'.$isReadOnly);
echo $form->htmlInputText('Email', 'email', $item['email'], '', 255, $isReadOnly);
echo $form->htmlInputText('Phone', 'phone', $item['phone'], '', 255, $isReadOnly);

if($user->hasRole(ROLE_ADMIN)) {
	
}

//echo $form->htmlTextarea('Description', 'desc', str_replace( '&', '&amp;', $item['desc']), 'Enter description', 'ckeditor', '');
echo $form->htmlTextarea('Description', 'desc', $item['description'], '', '', $isReadOnly);
?>
			</div><!-- card body-->
			<?php include_once('../inc/views/edit-footer.php'); ?>
		</div><!-- card -->
	</div><!-- col -->
</form>
