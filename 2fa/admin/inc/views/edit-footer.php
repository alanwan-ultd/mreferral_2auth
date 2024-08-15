
<a href="" class="btn hidden hidden-back-btn c-xhr-link"></a>

<div class="card-footer">
	<?php if(isset($layout['translateBtn']) && $layout['translateBtn']){ ?>
		<button class="btn btn-sm btn-primary mr-1" type="button" data-toggle="modal" data-target="#tc2scModal"><i class="icon-translate icons"></i>&nbsp; 繁轉簡</button>
	<?php } ?>
<?php if(isset($layout['statusSwitch']) && $layout['statusSwitch'] && (intval($sectionPermission[1]) == 1 || intval($sectionPermission[2]) == 1)){ ?>
	<label class="c-switch c-switch-label c-switch-success mr-1">
		<input class="c-switch-input" type="checkbox" name="status" value="A"<?php echo ($item['status'] == 'A')?' checked':''; ?>>
		<span class="c-switch-slider" data-checked="Active" data-unchecked="Pending"></span>
	</label>
<?php } ?>
<?php if(isset($layout['saveBtn']) && $layout['saveBtn'] && intval($sectionPermission[1]) == 1){ ?>
	<button class="btn btn-sm btn-primary mr-1" type="submit">Save</button>
<?php } ?>
<?php if(isset($layout['resetBtn']) && $layout['resetBtn'] == 'normal' && intval($sectionPermission[1]) == 1){ ?>
	<button class="btn btn-sm btn-warning mr-1 <?php echo $layout['resetBtn']; ?>" type="reset">Reset</button>
<?php }elseif(isset($layout['resetBtn']) && $layout['resetBtn'] == 'reload' && intval($sectionPermission[1]) == 1){ ?>
    <button class="btn btn-sm btn-warning mr-1 <?php echo $layout['resetBtn']; ?>" type="button" onclick="window.location.reload()">Reset</button>
<?php } ?>
<?php if(isset($layout['deleteBtn']) && $layout['deleteBtn'] && $id > 0 && intval($sectionPermission[1]) == 1){ ?>
	<button class="btn btn-sm btn-danger mr-1" type="button" data-toggle="modal" data-target="#dangerModal">Delete</button>
<?php } ?>
<?php if(isset($layout['previewBtn']) && $layout['previewBtn'] && $id > 0){ ?>
	<button class="btn btn-sm btn-info mr-1" type="button" data-target="preview">Preview</button>
<?php } ?>
<?php if(isset($layout['publishBtn']) && $layout['publishBtn'] && $id > 0 && intval($sectionPermission[2]) == 1){ ?>
	<button class="btn btn-sm btn-success mr-1" type="button" data-toggle="modal" data-target="#publishModal">Publish</button>
<?php } ?>
<?php if(isset($layout['eformStatus']) && $layout['eformStatus'] && $code){ ?>
	<a href="javascript:downloadPdf('<?php echo $code; ?>')" class="btn btn-sm btn-light mr-1">View PDF</a>
<?php } ?>
<?php if(isset($layout['midlandStatus']) && $layout['midlandStatus'] && $code){ ?>
	<a href="javascript:downloadPdf_midland('<?php echo $code; ?>')" class="btn btn-sm btn-light mr-1">View PDF</a>
<?php } ?>
<?php if(intval($sectionPermission[2]) != 1  && intval($sectionPermission[1]) == 1){ ?>
	<button class="btn btn-sm btn-success mr-1" type="button" data-toggle="modal" data-target="#approvalModal">Submit for Approval</button>
<?php } ?>

</div><!-- card footer-->

<input type="hidden" name="CKFinder_UserRole" value="<?php echo $name; ?>" />

<input type="hidden" name="form_link" value="views/<?php echo $name; ?>_save.php<?php echo (isset($pid) && $pid)?'?pid='.$pid.'&':'?'; ?>" />
<input type="hidden" name="back_link" value="<?php echo $name; ?>_list.php<?php echo (isset($pid) && $pid)?'?pid='.$pid:''; ?>" />
<input type="hidden" name="id" value="<?php echo (isset($items[0]['mapping_id']))?$items[0]['mapping_id']:$items[0]['id']; ?>" />
<input type="hidden" name="approve_link" value="submitApproval_save.php?" />
<?php echo renderModal('approvalModal', 'success', 'Publish', '<p>Please save before you submit for approval.</p><p>Are you sure?</p>', true, true, '', 'onclick="submitApproval()"'); ?>
<?php echo renderModal('publishModal', 'danger', 'Publish', '<p>Please save before publish.</p><p>Are you sure?</p>', true, true, '', 'onclick="submitFormPublish()"'); ?>
<?php echo renderModal('publishSuccessModal', 'success', 'Publish', '<p>Publish succeeded.</p>', true, false); ?>
<?php echo renderModal('dangerModal', 'danger', 'Delete', '<p>Are you sure?</p>', true, true, '', 'onclick="submitFormDelete()"'); ?>
<?php //echo renderModal('successModal', 'success', 'Save', '<p>Record saved.</p>', true, false); ?>
<?php //echo renderModal('warningModal', 'warning', 'Error', '<p>Record cannot be saved.</p>', true, false); ?>
<?php echo renderModal('validationModal', 'warning', 'Invalid/missing field(s)', '', true, false); ?>
<?php echo renderModal('duplicateModal', 'warning', 'Error', '<p>There is/are duplicated field(s).</p>', true, false); ?>
<?php echo renderModal('tc2scModal', 'warning', '繁轉簡', '<p>All SC content will be overwrite.</p><p>Are you sure?</p>', true, true, '', 'onclick="translateTC2SC();tc2scModalClose();"'); ?>
<?php echo renderModal('deleteWarningModal', 'warning', 'Error', '<p>Unable to delete an active record in live site.</p>', true, false); ?>
<?php echo renderModal('backModal', 'warning', 'Leave', '<p>Please save before you leave.</p><p>Are you sure to leave?</p>', true, true, '', 'onclick="back(this)"'); ?>

<template id="templateImgPopover">
	<img class="img" src='xxxxx' alt=''>
</template>



<!-- plugins-->
<?php if(isset($layout['datetimepicker']) && $layout['datetimepicker']){ ?>
	<!--script src="lib/daterangepicker/moment.min.js"></script>
	<script src="lib/daterangepicker/daterangepicker.js"></script>
	<link href="lib/daterangepicker/daterangepicker.css" rel="stylesheet"-->
<?php } ?>
<form id="approvalForm" name="myForm" class="form-horizontal" action="views/submitApproval_save.php">
	<input type="hidden" name="section" value="<?php echo  $name; ?>">
	<input type="hidden" name="section_name" value="<?php echo  $name; ?>">
	<input type="hidden" name="item_id" value="<?php echo (isset($id) && $id)?$id:''; ?>">
	<input type="hidden" name="item_pid" value="<?php echo (isset($pid) && $pid)?$pid:''; ?>">
	<input type="hidden" name="gid" value="<?php echo $_SESSION['groupId']; ?>">
	<input type="hidden" name="uid" value="<?php echo $_SESSION['id']; ?>">
</form>
