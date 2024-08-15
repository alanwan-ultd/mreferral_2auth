<?php
class HtmlBuilderCMS{
	//variables

	public function __construct() {

	}

	//function
	public function htmlFile($label, $field, $value, $placeholder, $configJs, $folder, $extra = ''){
		$end = PHP_EOL;
		$temp = (empty($value))?'no image':'<img class=&quot;img&quot; src=&quot;../'.$value.'&quot; alt=&quot;&quot;>';

		$output = '<div class="form-group">'.$end;
		$output .= '<label for="'.$field.'">'.$label.'</label>'.$end;
		$output .= '<div class="controls">';
		$output .= '<div class="input-group">'.$end;
		$output .= '<span class="hidden_label">'.$label.'</span>'.$end;
		$output .= '<input type="text" class="form-control readonly" id="'.$field.'" name="'.$field.'" value="'.$value.'" _readonly placeholder="'.$placeholder.'" title="" data-placement="bottom" data-html=true data-trigger="hover" data-container="body" '. $extra .' data-content=\''.$temp.'\'>'.$end;
		$output .= '<span class="input-group-append">'.$end;
		$output .= '<button class="btn btn-secondary" type="button" onclick="browseServer(\''.$field.'\', \''.$configJs.'\', \''.$folder.'\')">Browse</button>'.$end;
		$output .= '<button class="btn btn-secondary" type="button" onclick="$(\'#'.$field.'\').val(\'\');$(\'#'.$field.'\').attr(\'data-content\', \'no image\');"><i class="icon-circle-with-cross icons"></i></button>'.$end;
		$output .= '</span>'.$end;
		$output .= '</div>'.$end;
		$output .= '</div>'.$end;
		$output .= '</div>'.$end;

		return $output;
	}

	public function htmlImg($label, $field, $value, $placeholder, $configJs, $folder, $extra = '', $crop = '[]', $preview = true){
		$end = PHP_EOL;
		$temp = (empty($value))?'no image':'<img class=&quot;img&quot; src=&quot;../'.$value.'&quot; alt=&quot;&quot;>';
		$toggle = ($preview)? 'popover':'';

		$output = '<div class="form-group">'.$end;
		$output .= '<label for="'.$field.'">'.$label.'</label>'.$end;
		$output .= '<div class="controls">';
		$output .= '<div class="input-group">'.$end;
		$output .= '<span class="hidden_label">'.$label.'</span>'.$end;
		$output .= '<input type="text" class="form-control readonly" id="'.$field.'" name="'.$field.'" value="'.$value.'" _readonly placeholder="'.$placeholder.'" title="" data-toggle="'. $toggle .'" data-placement="bottom" data-html=true data-trigger="hover" data-container="body" '. $extra .' data-content=\''.$temp.'\'>'.$end;
		$output .= '<span class="input-group-append">'.$end;
		$output .= '<button class="btn btn-secondary" type="button" onclick="browseServer(\''.$field.'\', \''.$configJs.'\', \''.$folder.'\')">Browse</button>'.$end;
		if($crop !== false){
			$output .= '<button class="btn btn-secondary" type="button" onclick="crop.custom='.$crop.';crop.open();"><i class="icon-crop1 icons"></i></button>'.$end;
		}
		$output .= '<button class="btn btn-secondary" type="button" onclick="$(\'#'.$field.'\').val(\'\');$(\'#'.$field.'\').attr(\'data-content\', \'no image\');"><i class="icon-circle-with-cross icons"></i></button>'.$end;
		$output .= '</span>'.$end;
		$output .= '</div>'.$end;
		$output .= '</div>'.$end;
		$output .= '</div>'.$end;

		return $output;
	}

//	public function htmlImgGroup($label, $imgArray, $field, $configJs, $folder){
	public function htmlImgGroup(){
	/*	$end = PHP_EOL;
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
			echo '<span class="input-file-hover icon-search"></span><span class="input-file-preview containerDiv"><img src="'.$setting->ROOT_DIR.$value.'" style="max-width:'.$width.'px;display:none;" /></span>';
		}else{
			echo '<span class="input-file-hover icon-search"></span><span class="input-file-preview containerDiv"><img src="'.$setting->ROOT_DIR.'images/spacer.gif" style="max-width:'.$width.'px;display:none;" /></span>';
		}
	}*/



	public function htmlInputCheckbox($name, $text, $value, $isCheck,  $extra = ''){
		$c = ($isCheck)?' checked':'';
		$output = '<div class="form-check form-group">';
		$output .= '<input class="form-check-input" type="checkbox" id="'.$name.'" name="'.$name.'" value="'.$value.'"'.$c.' />';
		$output .= '<label class="form-check-label" for="'.$name.'">'.$text.'</label>';
		$output .= "</div><!-- form-group -->";
		return $output;

	}

	public function htmlInputRadio($name, $text, $value, $isCheck, $extra = ''){
		$output = '<div class="form-group">';

		for($i=0;$i<count($value);$i++){
			$c = ($isCheck == $value[$i])?' checked':'';
			$output .= '<div class="form-check">';
			$output .=  '<input class="form-check-input" type="radio" id="'.$name.$i.'" name="'.$name.'" value="'.$value[$i].'"'.$c.' '.$extra.' />';
			$output .=  '<label class="form-check-label" for="'.$name.$i.'">'.$text[$i].'</label>';
			$output .=  "</div><!-- form-check-->";
		}
		$output .=  "</div><!-- form-check-->";

		return $output;
	}

	public function htmlInputText($label, $field, $value, $placeholder, $maxlength = '255', $extra = '', $class = '', $type='text'){
		switch($type){
			case 'email': case 'password': case 'search': case 'tel': case 'text': case 'url': 
				$maxlengthStr = ' maxlength="'.$maxlength.'"';
				break;
			default: 
				$maxlengthStr = '';
		}
		$output ='<div class="form-group '.$type.'">
			<label class="form-col-form-label" for="'.$field.'">'.$label.'</label>
			<input class="form-control '.$class.'" id="'.$field.'" name="'.$field.'" type="'.$type. '" value="'.$value.'" placeholder="'.$placeholder.'"'.$maxlengthStr.' '.$extra.'>
		</div><!-- form-group -->';
		return $output;
	}

	public function htmlSelectOption($label, $field, $ary, $selected = '', $extra = ''){
		$output = '<div class="form-group">';
		if($label != ''){
			$output .= '<label class="form-col-form-label" for="'.$field.'">'.$label.'</label>';

		}
		$output .= '<select class="form-control" id="'.$field.'" name="'.$field.'" '.$extra.'>';
		for($i = 0;$i < count($ary);$i++){
			$temp = ($ary[$i][0] == $selected)?' selected':'';
			$output .= '<option value="'.$ary[$i][0].'"'.$temp.'>'.$ary[$i][1].'</option>';
		}
		$output .= '</select>';
		$output .= '</div><!-- form-group -->';

		return $output;
	}

    public function htmlTextarea($label, $field, $value, $placeholder, $class = '', $extra = ''){
		return '<div class="form-group">
			<label class="form-col-form-label" for="'.$field.'">'.$label.'</label>
			<textarea class="form-control '.$class.'" id="'.$field.'" name="'.$field.'" rows="10" placeholder="'.$placeholder.'" '.$extra.'>'.$value.'</textarea>
		</div><!-- form-group -->';
    }

	public function htmlLabel($label, $value, $extra = '')
	{
		global $util;

		$html = '<div class="form-group">' . PHP_EOL;

		if (!empty($label)) {
			$html .= "<label class='form-col-form-label' {$extra}><b>{$label}</b></label>:<br />" . PHP_EOL;
		}

		$value = ($value !== '' && $value !== null) ? $value : '-';
		$html .= "{$value}" . PHP_EOL;
		$html .= "</div><!-- form-group -->" . PHP_EOL;

		return $html;
	}
}
?>
