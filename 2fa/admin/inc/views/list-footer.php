<?php $isAdminGroup = (isset($group) && $group == 'admin'); ?>
<?php if($name != 'cashRebate') { ?>
	<?php if(intval($sectionPermission[1]) == 1 && !$isAdminGroup){  //check write permission ?>
	<div class="footer-control">Bulk action
		<a class="btn btn-sm btn-success" href="javascript:multiItemsUpdate('status', 'A')"><i class="icon-check icons"></i>&nbsp; Active</a>
		<a class="btn btn-sm btn-warning mr-1 normal" href="javascript:multiItemsUpdate('status', 'P')"><i class="icon-cross1 icons"></i>&nbsp; Pending</a>
	<?php if(intval($sectionPermission[2]) != 1 && !$isAdminGroup){ ?>
		<a class="btn btn-sm btn-info mr-1" href="javascript:multiItemsUpdate('approval')"><i class="icon-clipboard icons"></i>&nbsp; Submit for Approval</a>
	<?php } ?>
	<?php if(intval($sectionPermission[2]) == 1 && !$isAdminGroup){  //publish ?>
		<a class="btn btn-sm btn-dark mr-1" href="javascript:multiItemsUpdate('publish')"><i class="icon-publish icons"></i>&nbsp; Publish</a>
	<?php } ?>
	</div>
	<?php } ?>
<?php } ?>

<?php if(isset($export) && $export){ ?>
<script type="text/javascript" src="lib/Buttons-1.6.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="lib/Buttons-1.6.3/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="lib/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="lib/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="lib/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="lib/Buttons-1.6.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="lib/Buttons-1.6.3/js/buttons.print.min.js"></script>
<?php } ?>
