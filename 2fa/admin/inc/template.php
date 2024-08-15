<?php

function assignCMSControlBtnPermission($ary, $section){
    $layout = array(
        'statusSwitch' => $ary[0]
        , 'saveBtn' => $ary[1]
        , 'resetBtn' => $ary[2]  //normal, reload
        , 'deleteBtn' => $ary[3]
        , 'previewBtn' => false//$ary[4]
        , 'publishBtn' => $ary[5]
        , 'elementSorting' => $ary[6]  //js link
        , 'datetimepicker' => $ary[7]  //js link
        , 'translateBtn' => ( isset($ary[8]))?$ary[8]:false,  //js link

    //    , 'approveBtn' => $ary[8]  //

    );
    if( ($layout['statusSwitch'] && intval($section[1]) == 1) || ($layout['statusSwitch'] && intval($section[2]) == 1) ){
        $layout['statusSwitch'] = true;
    }else{
        $layout['statusSwitch'] = false;
    }

    if(intval($section[1]) == 0 && intval($section[2]) == 0 ){
        $layout['saveBtn'] = false;
        $layout['resetBtn'] = false;
        $layout['deleteBtn'] = false;
    }

    return $layout;
}

function renderFormSwitch($checked = true, $id = '', $name = '', $value = ''){
    $s = ($checked)?' checked=""':'';
    $s1 = ($id)?' id="'.$id.'"':'';
    $s2 = ($name)?' name="'.$name.'"':'';
    $s3 = ($value)?' value="'.$value.'"':'';

$text = <<<EOT
<label class="c-switch c-switch-label c-switch-success mr-1">
	<input class="c-switch-input" type="checkbox"{$s}{$s1}{$s2}{$s3}>
	<span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
</label>
EOT;
    return $text;
}

function renderListActionBtn($page, $id, $pid="", $approval_id=""){
    $extra = '';
    if($pid){
      $extra .= 'pid='.$pid.'&';
    }
    if($approval_id){
      $extra .= 'approval_id='.$approval_id.'&';
    }
    $text = '<a class="btn btn-sm btn-primary c-xhr-link" href="'.$page.'.php?'.$extra.'id='.$id.'"><i class="c-icon-sm cil-search"></i>&nbsp; Detail</a>';
    return $text;
}

function renderListFolder($page, $id){
    $text = '<a class="btn btn-sm c-xhr-link" href="'.$page.'.php?pid='.$id.'"><i class="icon-folder-open lead"></i></a>';
    return $text;
}

function renderListFolder2($page, $id){
    $text = '<a href="javascript:loadPage(\''.$page.'.php?id='.$id.'\', true)"><i class="fa fa-folder-open lead"></i></a>';
    return $text;
}

function renderListPublishActive(){
    $text = '<i class="icon-check_circle text-success lead"></i>';
    return $text;
}

function renderListPublishEdit(){
    $text = '<i class="icon-edit text-danger lead"></i>';
    return $text;
}

function renderListPublishPending(){
    $text = '<i class="icon-circle-with-cross text-danger lead"></i>';
    return $text;
}

function renderListStatusActive($s){
    $text = '<span class="badge badge-success">'.$s.'</span>';
    return $text;
}

function renderListStatusPending($s){
    $text = '<span class="badge badge-warning">'.$s.'</span>';
    return $text;
}

function renderModal($elmId, $modalType, $h4, $body, $close = true, $ok = true, $onclick = '', $onclick2 = ''){
	$output = '';
	$output .= '<div class="modal fade" id="'.$elmId.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'.PHP_EOL;
	$output .= '	<div class="modal-dialog modal-'.$modalType.'" role="document">'.PHP_EOL;
	$output .= '		<div class="modal-content">'.PHP_EOL;
	$output .= '			<div class="modal-header">'.PHP_EOL;
	$output .= '				<h4 class="modal-title">'.$h4.'</h4>'.PHP_EOL;
	if($close) $output .= '				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>'.PHP_EOL;
	$output .= '			</div>'.PHP_EOL;
	$output .= '			<div class="modal-body">'.$body.'</div>'.PHP_EOL;
	$output .= '			<div class="modal-footer">'.PHP_EOL;
	if($close) $output .= '				<button class="btn btn-secondary" type="button" data-dismiss="modal" '.$onclick.'>Close</button>'.PHP_EOL;
	if($ok) $output .= '				<button class="btn btn-success" type="button" '.$onclick2.'>OK</button>'.PHP_EOL;
	$output .= '			</div>'.PHP_EOL;
	$output .= '		</div><!-- /.modal-content-->'.PHP_EOL;
	$output .= '	</div><!-- /.modal-dialog-->'.PHP_EOL;
	$output .= '</div>'.PHP_EOL;
	return $output;
}

function renderPermissionLogin(){
	global $setting;

    $text = 'You do not have permission to visit this page or your session is timeout.<br/>Please <a href="'.$setting->CMS_DIR.'login.php">login</a> again.';
    return $text;
}

function renderTabList(){
	global $setting;
	$i = 0;
	$end = PHP_EOL;

	$output = '<div class="nav-tabs-boxed">'.$end;
	$output .= '<ul class="nav nav-tabs" role="tablist">'.$end;
	foreach($setting->LANG AS $key => $value){
		$temp = ($i==0)?' active':'';
		$output .= '<li class="nav-item"><a class="nav-link'.$temp.'" data-toggle="tab" href="#'.$key.'" role="tab" aria-controls="'.$key.'" aria-selected="true">'.$value[0].'</a></li>'.$end;
		$i++;
	}
	$output .= '</ul>'.$end;
	$output .= '</div>'.$end;
	return $output;
}

function renderTabContent($content){
	global $setting;
	$i = 0;
	$end = PHP_EOL;

	$output = '<div class="nav-tabs-boxed mb-3">'.$end;
	$output .= '<div class="tab-content">'.$end;
	foreach($setting->LANG AS $key => $value){
		$temp = ($i==0)?' active':'';
		$output .= '<div class="tab-pane'.$temp.'" data-tab="'.$key.'" role="tabpanel">'.$end;
		$output .= $content[$i];
		$output .= '</div>'.$end;
		$i++;
	}
	$output .= '</div>'.$end;
	$output .= '</div>'.$end;
	return $output;
}

?>
