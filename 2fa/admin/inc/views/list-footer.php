<?php $hideButtons = true; ?>
<?php if(!$hideButtons && intval($sectionPermission[1]) == 1){  //check read permission ?>
            <div class="footer-control">Bulk action
                <a class="btn btn-sm btn-success" href="javascript:statusUpdate('A')"><i class="icon-check icons"></i>&nbsp; Active</a>
                <a class="btn btn-sm btn-warning mr-1 normal" href="javascript:statusUpdate('P')"><i class="icon-close icons"></i>&nbsp; Pending</a>
<?php if(!$hideButtons && intval($sectionPermission[2]) == 1){  //publish ?>
                <a class="btn btn-sm btn-info mr-1" href="javascript:publishUpdate()"><i class="icon-cloud-upload icons"></i>&nbsp; Publish</a>
<?php } ?>

<?php if(!$hideButtons && intval($sectionPermission[2]) != 1 ){  //publish ?>
                <a class="btn btn-sm btn-info mr-1" href="javascript:publishUpdate(true)"><i class="icon-cloud-upload icons"></i>&nbsp; Submit for Approval</a>
<?php } ?>

            </div>
<?php } ?>

<?php //$_SESSION['CKFinder_UserRole'] = '';  //reset ckfinder role ?>
<?php if(isset($export) && $export){ ?>

<?php } ?>
