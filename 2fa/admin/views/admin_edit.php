<?php
$FILE_ROOT = '../';
$group = 'admin';
$name = 'admin';
$sectionPermissionByPass = true;
include_once('../inc/views/header.php');
include_once('../inc/HtmlBuilderCMS.php');
$form = new HtmlBuilderCMS();

if(isset($_SESSION['id']) && $_SESSION['id'] == $id){
	//same user, view user profile
	$sectionPermission[1] = 1;
}

require_once(ROOT_DIR .'../models/'. strtolower($name) .'.php');
$model = new $name;
$items = $model->getItemById($id);
$item = $items[0];
//echo $db->getSql();
//default
$layout = assignCMSControlBtnPermission(
	array(true, true, 'normal', true, true, false, false, false, false),
	$sectionPermission
);

//permission overwrite
if($id == 1){
	$layout['statusSwitch'] = false;
	$layout['deleteBtn'] = false;
}
if(isset($_SESSION['id']) && $_SESSION['id'] == $id && $sectionPermission[0] == 0){
	$layout['statusSwitch'] = false;
	$layout['deleteBtn'] = false;
	$layout['backBtn'] = false;
}
?>
<script src="js/edit.js?v=<?php echo $version; ?>"></script>
<script src="js/admin-edit.js?v=<?php echo $version; ?>"></script>

<!--script src="js/edit.php"></script-->
<form id="myForm" name="myForm" class="form-horizontal">
	<input type="hidden" id="2fa_secret" name="2fa_secret" value="<?php echo $item['2fa_secret'] ?? ''; ?>" />
	<input type="hidden" id="2fa_qrcode" name="2fa_qrcode" value="<?php echo $item['2fa_qrcode'] ?? ''; ?>" />
	<div class="col-lg-12 edit-page">
		<a href="<?php echo $name; ?>_list.php" class="btn btn-back c-xhr-link"><i class="icon-arrow_back_ios mr-1"></i>Back</a>
		<div class="card">
			<div class="card-header"><strong>Admin User</strong></div>
			<div class="card-body">
<?php
echo $form->htmlInputText('Username', 'login', $item['login'], '', 255, 'required');
echo $form->htmlInputText('Password<br>(Password should be 8-20 characters in length and should include at least one upper case letter, one number, and one special character.)', 'password', '', 'Enter password', 255);
echo $form->htmlInputText('Name', 'name', $item['name'], '', 255, 'required');
echo $form->htmlInputText('Email', 'email', $item['email'], '', 255);
//echo $form->htmlTextarea('Description', 'desc', str_replace( '&', '&amp;', $item['desc']), 'Enter description', 'ckeditor', '');
echo $form->htmlTextarea('Description', 'desc', $item['description'], '');

// update for only admin can change admin group
$temp = $model->getListGroupOption(); 
if($item['groupId'] == 1){
	echo $form->htmlSelectOption('Group', 'group', $temp, $item['groupId']);
} else {
	$groupTitle = '-';
	$groupId = $item['groupId'];

	$groupMap = array_column($temp, 1, 0);
	$groupTitle = $groupMap[$groupId] ?? '-';

	echo $form->htmlLabel('Group', $groupTitle);
}

// 2fa QR code section
$secret = $item['2fa_secret'];
$qrcode = $item['2fa_qrcode'];
// only allow super admin regen the qrcode
$btnGenCode = $_SESSION['groupId'] === '1' ? "<div class='btn btn-sm btn-info btn-google-2fa-gen'>Regenerate Code</div>" : "";

if($secret && $qrcode) {
	$html = "
	<div class='google-2fa-group'>
		<label>2FA</label>
		<img src='{$qrcode}' alt='{$secret}' />
		<div class='google-2fa-secret'>{$secret}</div>
		{$btnGenCode}
	</div>";
	echo $html;
}
?>
			</div><!-- card body-->
			<?php include_once('../inc/views/edit-footer.php'); ?>
		</div><!-- card -->
	</div><!-- col -->
</form>
