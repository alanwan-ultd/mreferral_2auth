ajaxLink = 'views/<?php echo $name; ?>_list.php?mode=json<?php echo ($pid)?'&pid='.$pid:''; ?>';  //ajaxLink = 'views/demo.json';
sortLink = 'views/<?php echo $name; ?>_save.php?action=sort<?php echo ($pid)?'&pid='.$pid:''; ?>';
statusLink = 'views/<?php echo $name; ?>_save.php?action=statusUpdate<?php echo ($pid)?'&pid='.$pid:''; ?>';
publishLink = 'views/<?php echo $name; ?>_save.php?action=publishUpdate<?php echo ($pid)?'&pid='.$pid:''; ?>';
approvalLink = 'views/<?php echo $name; ?>_save.php?action=approvalUpdate<?php echo ($pid)?'&pid='.$pid:''; ?>';
exportFile = [];

pageLength = <?php echo ($name == 'admin') ? '-1' : $setting->CMS_ITEM_PAGE; ?>;

// for submit approval
//approval_pid = '<?php echo $pid; ?>';
section_name = '<?php echo $name; ?>';

callBack = ()=> {
	var html = '';

<?php if($pid){ ?>
	html += '<a class="btn btn-sm btn-primary btn-back c-xhr-link mr-1" href="<?php echo (isset($nameP) && $nameP)?$nameP:$name; ?>_list.php<?php echo (isset($selfPid) && $selfPid)?'?id='.$selfPid:''; ?>"><i class="icon-arrow_back_ios icon mr-1"></i>Back</a>';
<?php }?>
<?php if(isset($mySection['create']) && $mySection['create'] === true && intval($sectionPermission[1]) == 1){ ?>
	html += '<a class="btn btn-sm btn-primary btn-new c-xhr-link mr-1" href="<?php  echo $name; ?>_edit.php<?php echo (isset($pid) && $pid)?'?pid='.$pid:''; ?>"><i class="icon-file-empty icons mr-1"></i>New</a>';
<?php } ?>
<?php if(isset($mySection['sort']) && $mySection['sort'] === true && intval($sectionPermission[1]) == 1){ ?>
	//sorting
	html += '<button class="btn btn-sm btn-primary btn-sort mr-1" onclick="javascript:sortPage()"><i class="icon-sort icons mr-1"></i>Sort</button>';
	html += '<button class="btn btn-sm btn-primary btn-list mr-1" onclick="javascript:listPage()"><i class="icon-list icons mr-1"></i>List</button>';
	if(typeof table != 'undefined'){
		if(table.sortingMode){
			$("div.toolbar").removeClass('mode-list').addClass('mode-sort');
		}else{
			$("div.toolbar").removeClass('mode-sort').addClass('mode-list');
		}
	}
	//sorting eol
<?php } ?>
	$("div.toolbar").html(html);

	//please define listDataTableCallBack @ xxxx_list.php
	if(!(typeof listDataTableCallBack == 'undefined' || listDataTableCallBack == null)) listDataTableCallBack();
};
