<?php
header('Content-type: text/javascript');
$FILE_ROOT = "../";
include_once('../inc/views/header.php');
//include_once('../inc/HtmlBuilderCMS.php');
//$form = new HtmlBuilderCMS();

?>

$(function(){
	//todo
});

//ckfinder
function browseServer(elmId, customConfigPath, name){
	//CKFinder 3
	var elementId = elmId;
	var configPath = (typeof customConfigPath == 'undefined')?'config.js':'<?php echo $setting->CMS_DIR; ?>lib/ckfinder3/3.5.1.1/'+customConfigPath;
	CKFinder.popup( {
		startupPath: name,
		chooseFiles: true,
		width: 800,
		height: 600,
		onInit: function( finder ) {
			finder.on( 'files:choose', function( evt ) {
				var file = evt.data.files.first();
				var $elm = document.getElementById( elementId );
				//var fileUrl = file.getUrl().replace('<?php echo $setting->ROOT_DIR; ?>', '');
				var fileUrl = file.getUrl().replace('<?php echo $setting->CMS_LIVE_LINK; ?>', '');
				$elm.value = fileUrl;

				var html = $('#templateImgPopover').html();
				//html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->ROOT_DIR; ?>'+fileUrl);
				html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->CMS_LIVE_LINK; ?>'+fileUrl);
				$elm.setAttribute('data-content', html);
			});

			finder.on( 'file:choose:resizedImage', function( evt ) {
				var file = evt.data.resizedUrl;
				var $elm = document.getElementById( elementId );

				if('<?php echo $setting->ROOT_DIR; ?>' != '/'){
					//var fileUrl = file.replace('<?php echo $setting->ROOT_DIR; ?>', '');
					var fileUrl = file.replace('<?php echo $setting->CMS_LIVE_LINK; ?>', '');
				}
				$elm.value = fileUrl;

				var html = $('#templateImgPopover').html();
				//html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->ROOT_DIR; ?>'+fileUrl);
				html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->CMS_LIVE_LINK; ?>'+fileUrl);
				$elm.setAttribute('data-content', html);
			});
		},
		configPath: configPath,
	} );
}

function setFileField(fileUrl){
	if('<?php echo $setting->ROOT_DIR; ?>' != '/'){
		//fileUrl = fileUrl.replace('<?php echo $setting->ROOT_DIR; ?>', '');
		fileUrl = fileUrl.replace('<?php echo $setting->CMS_LIVE_LINK; ?>', '');
	}
	document.getElementById(inputField).value = fileUrl;

	var html = $('#templateImgGroupPopover').html();
	//html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->ROOT_DIR; ?>'+fileUrl);
	html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->CMS_LIVE_LINK; ?>'+fileUrl);
	document.getElementById(inputField).setAttribute('data-content', html);
}
//ckfinder eol

function groupTemplateImgPopover($wrapper, counter, fileUrl){
	$wrapper.find('input[data-content]').eq(counter).each(function(){
		if(fileUrl != ''){
			var html = $('#templateImgPopover').html();
			//html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->ROOT_DIR; ?>'+fileUrl);
			html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->CMS_LIVE_LINK; ?>'+fileUrl);
			$(this)[0].setAttribute('data-content', html);
		}
	});
}
