<div class="card-footer">
	<!-- <button class="btn btn-sm btn-primary mr-1" type="button" data-toggle="modal" data-target="#tc2scModal"><i class="icon-translate icons"></i>&nbsp; 繁轉簡</button> -->
<?php if(isset($layout['statusSwitch']) && $layout['statusSwitch'] && (intval($sectionPermission[1]) == 1 || intval($sectionPermission[2]) == 1)){ ?>
	<label class="c-switch c-switch-label c-switch-success mr-1">
		<input class="c-switch-input" type="checkbox" name="status" value="A"<?php echo ($items[0]['status'] == 'A')?' checked':''; ?>>
		<span class="c-switch-slider" data-checked="Active" data-unchecked="Pending"></span>
	</label>
<?php } ?>
<?php if(isset($layout['saveBtn']) && $layout['saveBtn'] && intval($sectionPermission[1]) == 1){ ?>
	<button class="btn btn-sm btn-primary mr-1" type="submit"><i class="icon-save icons"></i>&nbsp; Save</button>
<?php } ?>
<?php if(isset($layout['resetBtn']) && $layout['resetBtn'] == 'normal' && intval($sectionPermission[1]) == 1){ ?>
	<button class="btn btn-sm btn-warning mr-1 <?php echo $layout['resetBtn']; ?>" type="reset"><i class="icon-undo1 icons"></i>&nbsp; Reset</button>
<?php }elseif(isset($layout['resetBtn']) && $layout['resetBtn'] == 'reload' && intval($sectionPermission[1]) == 1){ ?>
    <button class="btn btn-sm btn-warning mr-1 <?php echo $layout['resetBtn']; ?>" type="button" onclick="window.location.reload()"><i class="icon-undo1 icons"></i>&nbsp; Reset</button>
<?php } ?>
<?php if(isset($layout['deleteBtn']) && $layout['deleteBtn'] && $id > 0 && intval($sectionPermission[1]) == 1){ ?>
	<button class="btn btn-sm btn-danger mr-1" type="button" data-toggle="modal" data-target="#dangerModal"><i class="icon-delete icons"></i>&nbsp; Delete</button>
<?php } ?>
<?php if(isset($layout['previewBtn']) && $layout['previewBtn'] && $id > 0){ ?>
	<button class="btn btn-sm btn-light mr-1" type="button" onclick="javascript:window.open(this.getAttribute('data-link') + this.getAttribute('data-link2') );" data-link="<?php echo $layout['previewBtn']; ?>" data-link2="<?php echo isset($items[0]['url'])?$items[0]['url']:''; ?>"><i class="icon-eye icons"></i>&nbsp; Preview</button>
<?php } ?>
<?php if(intval($sectionPermission[1]) == 1 && intval($sectionPermission[2]) != 1 && $id > 0 && $group != 'admin' && PLUGIN_APPROVAL){ ?>
	<button class="btn btn-sm btn-info mr-1" type="button" data-toggle="modal" data-target="#approvalModal"><i class="icon-clipboard icons"></i>&nbsp; Submit for Approval</button>
<?php } ?>
<?php if(isset($layout['publishBtn']) && $layout['publishBtn'] && $id > 0 && intval($sectionPermission[2]) == 1){ ?>
	<button class="btn btn-sm btn-dark mr-1" type="button" data-toggle="modal" data-target="#publishModal"<?php if($items[0]['approve_status'] == 'A'){echo ' style="display:none;"';} ?>><i class="icon-publish icons"></i>&nbsp; Publish</button>
	<!--i class="icon-publish icons publish-sign <?php echo ($items[0]['approve_status'] == 'A')?'publish-sign-on':'publish-sign-off'; ?>"></i-->
<?php } ?>
</div><!-- card footer-->

<input type="hidden" name="CKFinder_UserRole" value="<?php echo $name; ?>" />
<input type="hidden" name="form_link" value="views/<?php echo $name; ?>_save.php<?php echo (isset($pid) && $pid)?'?pid='.$pid.'&':'?'; ?>" />
<input type="hidden" name="back_link" value="<?php echo $name; ?>_list.php<?php echo (isset($pid) && $pid)?'?pid='.$pid:''; ?>" />
<input type="hidden" name="preview_link" value="<?php echo (isset($layout['previewBtn'])) ? $layout['previewBtn'] : ''; ?>" />
<input type="hidden" name="id" value="<?php echo (isset($items[0]['mapping_id']))?$items[0]['mapping_id']:$items[0]['id']; ?>" />

<?php echo renderModal('tc2scModal', 'warning', '繁轉簡', '<p>All SC content will be overwrite.</p><p>Are you sure?</p>', true, true, '', 'onclick="translateTC2SC();tc2scModalClose()"'); ?>
<?php echo renderModal('publishModal', 'danger', 'Publish', '<p>Please save before publish.</p><p>Are you sure?</p>', true, true, '', 'onclick="submitFormPublish()"'); ?>
<?php echo renderModal('publishSuccessModal', 'success', 'Publish', '<p>Publish succeeded.</p>', true, false); ?>
<?php echo renderModal('dangerModal', 'danger', 'Delete', '<p>You can delete pending record only.<br>Are you sure?</p>', true, true, '', 'onclick="submitFormDelete()"'); ?>
<?php echo renderModal('validationModal', 'warning', 'Invalid/missing field(s)', '', true, false); ?>
<?php echo renderModal('duplicateModal', 'warning', 'Error', '<p>There is/are duplicated field(s).</p>', true, false); ?>

<template id="templateImgPopover">
	<img class="img" src='xxxxx' alt=''>
</template>

<?php if(isset($previewLink) && $previewLink != ''){ ?><input type="hidden" name="preview_link" value="<?php echo $previewLink; ?>"><?php } ?>

<!-- submitApproval -->
<?php echo renderModal('approvalModal', 'info', 'Submit for Approval', '<p>Please save before you submit for approval.</p><p>Are you sure?</p>', true, true, '', 'onclick="submitApproval()"'); ?>
<input type="hidden" name="section_name" value="<?php echo $name; ?>">
<input type="hidden" name="approval_title" value="Title: <?php echo (isset($approvalTitle) && $approvalTitle) ? $approvalTitle : ''; ?>">
<input type="hidden" name="pid" value="<?php echo (isset($pid) && $pid)?$pid:''; ?>">
<!-- submitApproval end -->