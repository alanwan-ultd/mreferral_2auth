<?php
header('Content-type: text/javascript');
$FILE_ROOT = "../";
include_once('../inc/views/header.php');
include_once('../inc/HtmlBuilderCMS.php');
$form = new HtmlBuilderCMS();

?>

$(function(){
	//todo
	$('#copy-path').click(function(){
			var self = $(this);
			var copyText = document.getElementById("commonpdf");
			copyText.select();
			copyText.setSelectionRange(0, 99999); /*For mobile devices*/
			document.execCommand("copy");
		//	console.log('copy!');
		//	console.log(document.execCommand("copy"));
			alert('copied')
	})

});

//ckfinder
/*
function browseServer(arg, customConfigPath){
    inputField = arg;
	var finder = new CKFinder();
	//finder.basePath = './plugin/ckfinder/';
	finder.selectActionFunction = setFileField;
    if(typeof customConfigPath != 'undefined'){
        finder.customConfig = '<?php echo $setting->CMS_DIR; ?>lib/ckfinder3/3.4.5/'+customConfigPath;
    }
	finder.popup();
}

function setFileField(fileUrl){
	if('<?php echo $setting->ROOT_DIR; ?>' != '/'){
		fileUrl = fileUrl.replace('<?php echo $setting->ROOT_DIR; ?>', '');
	}
    document.getElementById(inputField).value = fileUrl;

    var html = $('#templateImgGroupPopover').html();
    html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->ROOT_DIR; ?>'+fileUrl);
    document.getElementById(inputField).setAttribute('data-content', html);
}*/


function browseServer(elmId, customConfigPath, name){
	//CKFinder 3
	var elementId = elmId;
	var configPath = (typeof customConfigPath == 'undefined')?'config.js':'<?php echo $setting->CMS_DIR; ?>lib/ckfinder3/3.4.5/'+customConfigPath;

//	var configPath = 'config.js';
console.log(name);
	CKFinder.popup( {
		startupPath: name,
		chooseFiles: true,
		chooseFilesOnDblClick:true,
		width: 800,
		height: 600,
		resourceType: name,
		onInit: function( finder ) {

			finder.on( 'files:choose', function( evt ) {
				var file = evt.data.files.first();
				var $elm = document.getElementById( elementId );
				var fileUrl = file.getUrl().replace('<?php echo $setting->ROOT_DIR; ?>', '');
				$elm.value = fileUrl;
				console.log(fileUrl);
				var html = $('#templateImgPopover').html();
				html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->ROOT_DIR; ?>'+fileUrl);
				$elm.setAttribute('data-content', '<?php echo $setting->ROOT_DIR; ?>'+fileUrl);
			});

			finder.on( 'toolbar:reset:Main:file', function( evt ) {
			    evt.data.toolbar.push( {
			        type: 'button',
			        priority: 100,
			        label: 'Copy Path',
							icon: 'ckf-presets',
			        action: function() {
			            var files = evt.finder.request( 'files:getSelected' ).toArray();
									var fileUrl = files[0].getUrl().replace('<?php echo $setting->ROOT_DIR; ?>', '');
									$('#commonpdf').attr('value', fileUrl);
			        }
			    } );
			} );


			finder.on( 'file:choose:resizedImage', function( evt ) {
				var file = evt.data.resizedUrl;
				var $elm = document.getElementById( elementId );

				if('<?php echo $setting->ROOT_DIR; ?>' != '/'){
					var fileUrl = file.replace('<?php echo $setting->ROOT_DIR; ?>', '');
				}
				$elm.value = fileUrl;

				var html = $('#templateImgPopover').html();
				html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->ROOT_DIR; ?>'+fileUrl);

				$elm.setAttribute('data-content', html);
			});


		},
		configPath: configPath
	} );
}
function setFileField(fileUrl){
	if('<?php echo $setting->ROOT_DIR; ?>' != '/'){
		fileUrl = fileUrl.replace('<?php echo $setting->ROOT_DIR; ?>', '');
	}
    document.getElementById(inputField).value = fileUrl;

    var html = $('#templateImgGroupPopover').html();
    html = html.replace(new RegExp('xxxxx', 'g'), '<?php echo $setting->ROOT_DIR; ?>'+fileUrl);
    document.getElementById(inputField).setAttribute('data-content', html);
}
//ckfinder eol
