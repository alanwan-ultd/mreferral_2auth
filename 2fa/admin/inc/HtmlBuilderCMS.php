<?php
class HtmlBuilderCMS{
	//variables

	public function __construct() {

	}

	//function
	public function htmlFile($name, $value, $id, $width = 200){
		global $setting;
		echo '<input id="'.$id.'" name="'.$name.'" type="text" size="255" value="'.$value.'" /> <div class=\'button\' onclick=\'javascript:browseServer("'.$id.'");\'><span class="icon-folder-open"></span></div>';
		$ext = substr(strrchr($value, '.'), 1);
		if(preg_match("/(" . implode("|", array("jpg", "jpeg", "gif", "png", "bmp")) . ")$/i", $ext)){
			//echo '<br/><img src="'.$setting->ROOT_DIR.$value.'" style="max-width:'.$width.'px"/>';
			echo '<span class="input-file-hover icon-search"></span><span class="input-file-preview containerDiv"><img src="'.$setting->ROOT_DIR.$value.'" style="max-width:'.$width.'px;display:none;" /></span>';
		}elseif(!empty($value)){
			echo '<br/>file: <a href="'.$setting->ROOT_DIR.$value.'" target="_blank">'.$setting->ROOT_DIR.urldecode(basename($value)).'</a>';
		}
	}

	public function htmlImg($label, $field, $value, $placeholder, $configJs, $folder, $extra = '', $crop = '[]', $preview = true, $template = false){
		global $setting;
		$end = PHP_EOL;
		//$temp = (empty($value))?'no image':'<img class=&quot;img&quot; src=&quot;../'.$value.'&quot; alt=&quot;&quot;>';
		$temp = (empty($value) || $value == 'xxxxx')?'no image':'<img class=&quot;img&quot; src=&quot;'.$setting->CMS_LIVE_LINK.$value.'&quot; alt=&quot;&quot;>';
		$toggle = ($preview)? 'popover':'';
		if($template == false){
			$id = $field;
			$name = $field;
		}else{//template group item
			$id = $field . '_##id##';
			$name = $field . '[]';
		}
		
		$output = <<<EOT
<div class="form-group">
	<label for="{$id}">{$label}</label>
	<div class="controls">
		<div class="input-group mb-4">
			<span class="hidden_label">{$label}</span>
			<input type="text" class="form-control readonly" id="{$id}" name="{$name}" value="{$value}" _readonly placeholder="{$placeholder}" title="" data-toggle="{$toggle}" data-placement="bottom" data-html="true" data-trigger="hover" data-container="body" {$extra} data-content="{$temp}">
			<span class="input-group-append">
				<button class="btn btn-secondary" type="button" onclick="browseServer('{$id}', '{$configJs}', '{$folder}')">Browse</button>
				<button class="btn btn-secondary" type="button" onclick="crop.custom={$crop};crop.open();"><i class="icon-crop1 icons"></i></button>
				<button class="btn btn-secondary" type="button" onclick="$('#{$id}').val('');$('#{$id}').attr('data-content', 'no image');"><i class="icon-circle-with-cross icons"></i></button>
			</span>
		</div><!-- input-group-->
	</div><!-- controls-->
</div>
EOT;

		/*$output = '';
		$output .= '<div class="form-group">'.$end;
		$output .= '<label for="'.$field.'">'.$label.'</label>'.$end;
		$output .= '<div class="controls">';
		//$output .= '<span class="hidden_label">'.$label.'</span>'.$end;
		if($template == false){
			$output .= '<input type="text" class="form-control readonly" id="'.$field.'" name="'.$field.'" value="'.$value.'" _readonly placeholder="'.$placeholder.'" title="" data-toggle="'. $toggle .'" data-placement="bottom" data-html=true data-trigger="hover" data-container="body" '. $extra .' data-content=\''.$temp.'\'>'.$end;
		}else{
			$output .= '<input type="text" class="form-control readonly" id="'.$field.'_##id##" name="'.$field.'[]" value="'.$value.'" _readonly placeholder="'.$placeholder.'" title="" data-toggle="'. $toggle .'" data-placement="bottom" data-html=true data-trigger="hover" data-container="body" '. $extra .' data-content=\''.$temp.'\'>'.$end;
		}
		$output .= '<span class="input-group-append">'.$end;
		$output .= '<button class="btn btn-secondary" type="button" onclick="browseServer(\''.$field.'\', \''.$configJs.'\', \''.$folder.'\')">Browse</button>'.$end;
		$output .= '<button class="btn btn-secondary" type="button" onclick="crop.custom='.$crop.';crop.open();"><i class="icon-crop1 icons"></i></button>'.$end;
		$output .= '<button class="btn btn-secondary" type="button" onclick="$(\'#'.$field.'\').val(\'\');$(\'#'.$field.'\').attr(\'data-content\', \'no image\');"><i class="icon-circle-with-cross icons"></i></button>'.$end;
		$output .= '</span>'.$end;
		$output .= '</div><!-- input-group-->'.$end;
		$output .= '</div><!-- controls-->'.$end;
		$output .= '</div><!-- form-group-->'.$end;*/

		return $output;
	}

	//public function htmlImgGroup($label, $imgArray, $field, $configJs, $folder){
	public function htmlImgGroup(){
		/*$end = PHP_EOL;
		$tempArray = explode('##', $imgArray);
		$temp = '';
		if(empty($tempArray)) $tempArray[0] = $item[0]['gallery'];
		foreach($tempArray AS $k => $row){
			$temp .=  '<div class="input-group mb-4">'.$end;
			$temp .= '<input id="gallery_'.$k.'" name="gallery[]" class="form-control popover-tf" size="16" type="text" value="'.'$row'.'" data-toggle="popover" data-placement="bottom" data-trigger="hover" title="Image"';
			$temp .= '<span class="input-group-btn">';
			$temp .= '<button class="btn btn-secondary" type="button" onclick="browseServer(\''.$field.'\', \''.$configJs.'\', \''.$folder.'\')">Browse</button>'.$end;
			$temp .= '<span class="input-group-btn">';

		}

		$output = '<div class="form-group">'.$end;
		$output .= '<label>'. $label .'</label>'.$end;
		$output .= '</div>'.$end;
		*/
		$output = <<<EOT
<script id="templateImgGroup" type="text/template">
	<div class="input-group mb-4">
		<input id="xxxxx" name="yyyyy[]" class="form-control popover-tf" size="16" type="text" value="" readonly placeholder="Enter image" data-toggle="popover" data-placement="bottom" data-trigger="hover" title="Image" data-html=true data-content="" data-animation=false>
		<span class="input-group-btn">
			<button class="btn btn-default" type="button" onclick="browseServer('xxxxx')">Browse</button>
			<button class="btn btn-default" type="button" onclick="deleteBtnImg('xxxxx')">
				<i class="icon-close icons"></i>
			</button>
			<span class="input-group-addon"><i class="icon-cursor-move icons"></i></span>
		</span>
	</div>
</script>
<script id="templateImgGroupPopover" type="text/template">
	<img src='xxxxx' alt='' style='max-width:100%;max-height:100%;' />
</script>
EOT;
    	return $output;
	}

	/*public function htmlFileImgCrop($name, $value, $id, $width = 200){
		global $setting;
		echo '<input id="'.$id.'" name="'.$name.'" type="text" size="255" value="'.$value.'" readonly /> <div class=\'button\' onclick=\'javascript:imgCropOpen("'.$id.'");\'><span class="icon-upload"></span></div>';
		echo '<input id="'.$id.'_data" name="'.$name.'_data" type="hidden" value="" />';
		if(!empty($value)){
			echo '<span class="input-file-hover icon-search"></span><span class="input-file-preview containerDiv"><img src="'.$setting->ROOT_DIR.$value.'" style="max-width:'.$width.'px;display:none;" /></span>'.PHP_EOL;
		}else{
			echo '<span class="input-file-hover icon-search"></span><span class="input-file-preview containerDiv"><img src="'.$setting->ROOT_DIR.'images/spacer.gif" style="max-width:'.$width.'px;display:none;" /></span>'.PHP_EOL;
		}
	}*/

	public function htmlInputCheckbox($name, $text, $value, $isCheck){
		$c = ($isCheck)?' checked="yes"':'';
		echo '<div class="form-check form-group">';
		echo '<input class="form-check-input" type="checkbox" id="'.$name.'" name="'.$name.'" value="'.$value.'"'.$c.' />';
		echo '<label class="form-check-label" for="'.$name.'">'.$text.'</label>';
		echo "</div><!-- form-group -->".PHP_EOL;
	}

	public function htmlInputRadio($name, $text, $value, $isCheck){
		echo '<div class="form-group">';

		for($i=0;$i<count($value);$i++){
			$c = ($isCheck == $i)?' checked="yes"':'';
			echo '<div class="form-check">';
			echo '<input class="form-check-input" type="radio" id="'.$name.$i.'" name="'.$name.'" value="'.$value[$i].'"'.$c.' />';
			echo '<label class="form-check-label" for="'.$name.$i.'">'.$text[$i].'</label>';
			echo "</div><!-- form-check-->";

		}
		echo "</div><!-- form-check-->".PHP_EOL;
	}

	public function htmlLabel($label, $value, $id ='', $checkbox = false) {
		$value = ($value) ? nl2br($value) : '-';
		$idAttr = ($id) ? "id=label_{$id}" : "";
		$checkbox = ($checkbox) ? "&nbsp;&nbsp;<input type='checkbox'>" : "";
		$output = "
			<div class='form-group-row'>
				<label>{$label}:</label>
				<div {$idAttr}><strong>{$value}</strong>{$checkbox}</div>
			</div>
		";		
		return $output;
	}

	public function htmlLabelImage($label, $image_path) {
		global $setting;
		$image = ($image_path) ? "<img src='{$setting->CMS_LIVE_LINK}{$image_path}' />" : '-';
		$output = "
			<div class='form-group-row'>
				<label>{$label}:</label>
				<div><strong>{$image}</strong></div>
			</div>
		";		
		return $output;
	}

	public function htmlInputText($label, $field, $value, $placeholder, $maxlength = '255', $extra = '', $class = '', $template = false){
		$end = PHP_EOL;
		if($template == false){
			$id = $field;
			$name = $field;
		}else{//template group item
			$id = $field . '_##id##';
			$name = $field . '[]';
		}

		$output = '<div class="form-group">'.$end;
		if($label != ''){
			$output .= '	<label class="form-col-form-label" for="'.$id.'">'.$label.'</label>'.$end;
		}
		$output .= '	<input class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" type="text" value="'.$value.'" placeholder="'.$placeholder.'" maxlength="'.$maxlength.'" '.$extra.'>'.$end;
		$output .= '</div><!-- form-group -->'.$end;
		
		return $output;
	}

	public function htmlInputPassword($label, $field, $value, $placeholder, $maxlength = '255', $extra = '', $class = '', $template = false){
		$end = PHP_EOL;
		$id = $field;
		$name = $field;

		$output = '<div class="form-group">'.$end;
		if($label != ''){
			$output .= '	<label class="form-col-form-label" for="'.$id.'">'.$label.'</label>'.$end;
		}
		$output .= '	<input class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" type="password" value="'.$value.'" placeholder="'.$placeholder.'" maxlength="'.$maxlength.'" '.$extra.'>'.$end;
		$output .= '</div><!-- form-group -->'.$end;
		
		return $output;
	}

	public function htmlInputDate($label, $id, $name, $value, $extra = '', $class = ''){
		$end = PHP_EOL;

		$output = '<div class="form-group">'.$end;
		if($label != ''){
			$output .= '	<label class="form-col-form-label" for="'.$id.'">'.$label.'</label>'.$end;
		}
		$output .= '	<input class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" type="date" value="'.$value.'" '.$extra.'>'.$end;
		$output .= '</div><!-- form-group -->'.$end;
		
		return $output;
	}

	// $htmlBuilderCMS->htmlInputSwitches("is_show_on_menu", 1, 'Is show on menu', ($item[0]['is_show_on_menu'] == 1));
	public function htmlInputSwitches($field, $value, $title, $isCheck)
	{
		$checked = ($isCheck) ? 'checked' : '';
		$html = "
            <div class'form-group'>
                <label>{$title}</label>
				<br>
                <label class='c-switch c-switch-label c-switch-success mr-1'>
                    <input type='checkbox' class='c-switch-input' id='{$field}' name='{$field}' value='{$value}' {$checked}>
					<span class='c-switch-slider' data-checked='On' data-unchecked='Off'></span>
                </label>
            </div>
        ";

		return $html;
	}

	public function htmlSelectOption($label, $field, $ary, $selected = '', $extra = ''){
		$output = '<div class="form-group">';
		$output .= '<label class="form-col-form-label" for="'.$field.'">'.$label.'</label>';
		$output .= '<select class="form-control" id="'.$field.'" name="'.$field.'">';
		for($i = 0;$i < count($ary);$i++){
			$temp = ($ary[$i][0] == $selected)?' selected':'';
			$output .= '<option value="'.$ary[$i][0].'"'.$temp.'>'.$ary[$i][1].'</option>';
		}
		$output .= '</select>';
		$output .= '</div><!-- form-group -->'.PHP_EOL;

		return $output;
	}

    public function htmlTextarea($label, $field, $value, $placeholder, $class = '', $extra = '', $template = false){
		if($template == false){
			$id = $field;
			$name = $field;
		}else{//template group item
			$id = $field . '_##id##';
			$name = $field . '[]';
		}
		return '<div class="form-group">
			<label class="form-col-form-label" for="'.$id.'">'.$label.'</label>
			<textarea class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" rows="10" placeholder="'.$placeholder.'" '.$extra.'>'.$value.'</textarea>
		</div><!-- form-group -->'.PHP_EOL;
    }

	public function htmlCRLog($case_no, $logs) {
		if($logs) {
			foreach($logs as $log_key => $log_items) {
				echo "<div class='hstory-group'>
						<div><a class='c-xhr-link' href='cashRebate_edit.php?case_no={$case_no}&version={$log_key}'><strong>Version: {$log_key}</strong></a></div>";
				foreach($log_items as $log_item) {
					$rejectReason = ($log_item['reject_reason']) ? "<br>(Reject reason: " . nl2br($log_item['reject_reason']) . ")": '';
					echo "
						<div class='history-row'>
							<div class='col-3'>{$log_item['created_at']}</div>
							<div class='col-3'>{$log_item['created_by']['name']}</div>
							<div class='col-6'>{$log_item['action']}{$rejectReason}</div>
						</div>";
				}
				echo "</div>";
			}
		} else {
			echo "No records";
		}
	}

	public function htmlInputNumber($label, $field, $value, $placeholder, $min = '1', $max = '9999', $extra = '', $class = ''){
		$end = PHP_EOL;
		$id = $field;
		$name = $field;

		$output = '<div class="form-group">'.$end;
		if($label != ''){
			$output .= '	<label class="form-col-form-label" for="'.$id.'">'.$label.'</label>'.$end;
		}
		$output .= '	<input class="form-control '.$class.'" id="'.$id.'" name="'.$name.'" type="number" value="'.$value.'" placeholder="'.$placeholder.'" min="'.$min.'" max="'.$max.'" maxlength="4" '.$extra.'>'.$end;
		$output .= '</div><!-- form-group -->'.$end;
		
		return $output;
	}
}
?>
