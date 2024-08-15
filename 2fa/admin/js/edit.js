//console.log( ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName ) );
var allCKEditors = document.querySelectorAll('.ckeditor');
var allCKEditorObjs = [];
var ckeditorOpts = {
	language: {
		ui: 'en',
		content: 'en'
	},
	fontSize: {
		options: [
			'default',
			'small',
		]
	},
	ckfinder: {
		openerMethod: 'popup',
		uploadUrl: 'lib/ckfinder3/3.5.1.1/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
		options: {
			resourceType: ckfinderResourceType
		},
	  },
	//plugins: [ 'ImageResize' ],
	removePlugins: [ 'ImageCaption', 'ImageStyle' ],
	//toolbar: [ 'heading', '|', 'bold', 'italic', 'underline', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'ckfinder', ],
	//toolbar: [  'insertTable', 'heading', '|', 'outdent', 'indent', '|', 'HorizontalLine', 'IndentBlock', 'fontSize', 'bold', 'italic', 'underline', 'alignment', 'link', 'bulletedList', 'numberedList', '|', 'ckfinder', ],
	toolbar: [  'insertTable', 'heading', '|', 'outdent', 'indent', '|', 'HorizontalLine', 'removeFormat', 'fontSize', 'bold', 'italic', 'underline', 'Subscript', 'Superscript', 'link', 'bulletedList', 'numberedList', '|', 'ckfinder', ],
	table: {
		contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells','tableproperties', 'tableCellProperties' ]
	},
	link: {
		addTargetToExternalLinks: true,
	},
	heading: {
		options: [
			{ model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
			{ model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
			{ model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
		]
	},
	image: {
		//toolbar: [ 'imageStyle:full', 'imageStyle:side', '|', 'imageTextAlternative', '|', 'linkImage' ],
		toolbar: [ 'imageTextAlternative' ],
		//styles: [ 'full', 'side', 'alignLeft', 'alignCenter', 'alignRight' ], 
	},
};
if(typeof ckEditorOptsCustom_heading != 'undefined'){
	ckeditorOpts.heading.options = ckEditorOptsCustom_heading;
}
if(typeof ckEditorOptsCustom_toolbar != 'undefined'){
	ckeditorOpts.toolbar = ckEditorOptsCustom_toolbar;
}
//ClassicEditor.defaultConfig
for (var i = 0; i < allCKEditors.length; i++) {
	ClassicEditor
		.create( allCKEditors[i], ckeditorOpts)
		.then( editor => {
			//console.log( editor );
			allCKEditorObjs.push(editor);
			if(typeof ckEditorCallBackFn != 'undefined'){
				ckEditorCallBackFn();
			}
			editor.ui.focusTracker.on( 'change:isFocused', ( evt, data, isFocused ) => {
				//console.log( `The editor is focused: ${ isFocused }.` );
				if(typeof ckEditorCallBackFn != 'undefined'){
					ckEditorCallBackFn();
				}
			} );
		} )
		.catch( error => {
			//console.error( error );
		} );
}

isSubmitBtnClick = false;
formErrorMessageObj = [];
$(function(){
	var section = $('.c-sidebar-nav-link.c-active').text();
	$('input[name=section_name]').val(section);

	/*modal*/
	//const modalAry = ['publishModal', 'publishSuccessModal', 'dangerModal', 'successModal', 'warningModal', 'validationModal', 'duplicateModal'];
	const modalAry = [
		'publishModal',
		'publishSuccessModal',
		'dangerModal',
		'validationModal',
		'duplicateModal',
		'approvalModal',
		'tc2scModal',
		'crSpecialApprovalSalesAdminModal',
		'crSpecialApprovalKostkaModal',
		'crAdminApprovalModal',
		'crFinanceApprovalModal',
		'crRejectModal',
	];
	modalAry.forEach(function(value, index, array){
		window['$'+value] = new coreui.Modal(document.getElementById(value), {
			keyboard: false
			, backdrop: 'static' //true, click to close
		});

		window[value+'Close'] = ()=>{
			window['$'+value].hide();
		}

		window[value+'Open'] = ()=>{
			window['$'+value].show();
		}
	});

	/*hyperform*/
	const $myForm = document.getElementById('myForm');

	hyperform(window);

	$myForm.addEventListener('submit', function(event) {
		/* do not submit the form, because we'll do that later */
		event.preventDefault();
		event.stopPropagation();
		//document.forms['myForm'].submit();
		submitForm();
	});

	$('.btn-cashrebate-common-save').on('click', function() {
		submitCashRebateCommonForm();
	});

	$myForm.addEventListener('validate', function(event) {
		//console.log(event);
		$('.modal-body', '#validationModal').html('');
		formFirstInvalidElm = null;
	});

	var formTimeoutID = 0;
	var formFirstInvalidElm = null;
	$myForm.addEventListener('invalid', function(event) {
		/* do not submit the form, invalid */
		//console.log(event);  //return;
		var id = $(event.target).attr('id');
		if(formFirstInvalidElm == null) formFirstInvalidElm = $('#'+id);
		if($('#'+id).prev().length > 0){
			formErrorMessage(id);
		}
		clearTimeout(formTimeoutID);
		formTimeoutID = setTimeout(function(){
			if(isSubmitBtnClick){
				isSubmitBtnClick = false;
				validationModalOpen();
			}
		}, 100);
	});
	/*hyperform eol*/

	$('#myForm .card-footer .switch-input').on('change.bootstrapSwitch', function(){
		//console.log($(this).is(':checked'));
	});

	$('input[name=status]').on('change', function(e){
		if($('input[name=id]').val() != 0){
			submitFormStatus();
		}
	});

	$('#myForm button[type=submit]').on('click', function(e){
		//console.log('submit click');
		formFirstInvalidElm = null;
		isSubmitBtnClick = true;
		formErrorMessageObj = [];
		$('.modal-body', '#validationModal').html('');
	});

	$('#myForm').on('reset', function(e){
		if(allCKEditorObjs.length > 0){
			$.each(allCKEditorObjs, function(index, value){
				var $textarea = document.createElement('textarea');
				$textarea.innerHTML = allCKEditorObjs[index].sourceElement.innerHTML;
				allCKEditorObjs[index].setData($textarea.value);
			});
		}
	});

	/*$('.select-wrapper2').each(function(){
		var cat = $(this).find('select').first();
		var articles = $(this).find('select').last();
		var val = cat.val();
	
		selectWithCat(val, articles);
	});
	$('.select-wrapper2').click(function(){
		var cat = $(this).find('select').first();
		var articles = $(this).find('select').last();
	
		cat.change(function(){
			var val = $(this).val();
			selectWithCat(val, articles);
		});
	});*/

	if($('.sortable').length > 0){
		$('.sortable').each(function(){
			var el = document.getElementById($(this).attr('id'));
			new Sortable(el, {
				animation: 150,// ms, animation speed moving items when sorting, `0` — without animation
				ghostClass: 'sortable-ghost',// Class name for the drop placeholder
				handle: '.my-handle',// Drag handle selector within list items
			 });
		});
	}

	// disable input readonly field
	$('.readonly').keydown(function(e){
		e.preventDefault();
	});
	// disable input readonly field end

	//templateSelection();

	//2 way binding input, approval_title, url field
	$('[name=' + approvalTitleBind + ']').on('change', function(){
		$('[name=approval_title]').val('Title: ' + $(this).val());
		if($.trim( $('[name=url]').attr('data-original') ) == '' ){
			$('[name=url]').val( urlSlug($(this).val()) );
		}
	});
	//2 way binding input end

	//bootstrap tab
	$('a[data-toggle="tab"]').on('click', function (e) {
		//console.log($(this).attr('href'));
		let temp = $(this).attr('href').replace('#', '');

		$('.nav-tabs-boxed .nav-tabs .nav-link').removeClass('active');
		$('.nav-tabs-boxed .nav-tabs .nav-link[href="#'+temp+'"]').addClass('active');
		
		$('.nav-tabs-boxed .tab-content .tab-pane').removeClass('active');
		$('.nav-tabs-boxed .tab-content .tab-pane[data-tab='+temp+']').addClass('active');
	});

	//datetimepicker
	$('.daterangepicker').remove();

	// Single Date Picker
	if($('input.datepicker').length > 0){
		$('.daterangepicker').hide();
		$('input.datepicker').each(function(){
			let foramt = ($(this).attr('data-format'))?$(this).attr('data-format'):'YYYY-MM-DD';
			let timePicker = ($(this).attr('data-time'))?$(this).attr('data-time'):false;
			let option = {
				singleDatePicker: true, 
				locale: {
					format: foramt
				}, 
			};
			if(timePicker){
				option.timePicker = true;
				option.timePicker24Hour = true;
			}
			$(this).daterangepicker(option);
		});
	}

	$('.btn-back, .c-sidebar-nav-link ').click(function(){
		$('.daterangepicker').remove();
	});
	//datetimepicker end

	$('script.delay-call').each(function(){
		var code = $(this).html();
		//console.log(code);
		eval(code);
	});
});//end document ready

//submit
function submitApproval(){
	loadingModalOpen();
	approvalModalClose();
	var approvalData = {
		'status': ($('input[name=status]').is(':checked'))?$('input[name=status]').val():'P', 
		'section_name': $('input[name=section_name]').val(),
		'approval_title': $('input[name=approval_title]').val(),
		'id': $('input[name=id]').val(),
		'pid': $('input[name=pid]').val(),
	}
	$.ajax({
		type: "POST",
		url: $( "#myForm input[name=form_link]" ).val()+'action=approval',
		data: approvalData,
		success: function(data){
			setTimeout(function(){
				loadingModalClose();
				if(data == 't'){
					successModalOpen();
					publishBtnShow();
				}else if(data == 'f'){
					warningModalOpen();
				}
			}, 500);
		},
		error: function(data){
			//console.log('error'+data);
			setTimeout(function(){
				loadingModalClose();
				warningModalOpen();
			}, 500);
		},
		dataType: 'html'  //xml, json, script, or html
	});

	setTimeout(function(){
		loadingModalClose();
	}, 500);
	
	return false;
}

function submitForm(){
	loadingModalOpen();
	modifyBeforeSubmit();
	setTimeout(function(){
		$.ajax({
			type: "POST",
			url: $( "#myForm input[name=form_link]" ).val()+'action=save',
			data: $( "#myForm" ).serialize(),
			success: function(data){
				//console.log(data);
				setTimeout(function(){
					loadingModalClose();
					if(data == 't'){  //admin group page
						successModalOpen();
						publishBtnShow();
					}else if(Number.isInteger(parseInt(data))){  //get return from last insert id
						if(data === '0'){
							warningModalOpen();
						}else if($('#myForm input[name=id]').val() == '0'){
							//$('a.btn.btn-back')[0].click();  //go back to listing
							//location.href = location.href + '?id=' + data;
							//location.reload();
							let s = (location.href.indexOf('?') > 0)?'&':'?';
							$('#successModal').find('button[data-dismiss=modal]').attr('onclick', "location.href = location.href + '" + s + "id=' + " + data + ";location.reload();");
							successModalOpen();
							$('button.btn-light[data-link]').attr('data-link2', $.trim($('[name=url]').val()) );//preview button
						}else{
							successModalOpen();
							publishBtnShow();
							$('button.btn-light[data-link]').attr('data-link2', $.trim($('[name=url]').val()) );//preview button
						}
					}else if(data == 'f'){
						warningModalOpen();
					}else if(data == 'cannot_send_email') {
						warningEmailModalOpen();
					}else{
						$('.modal-body p', '#duplicateModal').html(data);
						duplicateModalOpen();
					}
				}, 500);

			},
			error: function(data){
				//console.log('error'+data);
				setTimeout(function(){
					loadingModalClose();
					warningModalOpen();
				}, 500);
			},
			dataType: 'html'  //xml, json, script, or html
		});
	}, 200);

	return false;
}

function submitFormStatus(){
	loadingModalOpen();
	$.ajax({
		type: "POST",
		url: $( "#myForm input[name=form_link]" ).val()+'action=status',
		data: {
			'status': ($('input[name=status]').is(':checked'))?$('input[name=status]').val():'P', 
			'section_name': $('input[name=section_name]').val(), 
			'approval_title': $('input[name=approval_title]').val(), 
			'id': $('input[name=id]').val(), 
		},
		success: function(data){
			//console.log(data);
			setTimeout(function(){
				loadingModalClose();
				if(data == 't'){
					successModalOpen();
					publishBtnShow();
				}else if(data == 'f'){
					warningModalOpen();
					$('#warningModal .modal-body p').eq(1).hide();
				}else{
					warningModalOpen();
					$('#warningModal .modal-body p').eq(1).show();
				}
			}, 500);
		},
		error: function(data){
			//console.log('error'+data);
			setTimeout(function(){
				loadingModalClose();
				warningModalOpen();
			}, 500);
		},
		dataType: 'html'  //xml, json, script, or html
	});

	return false;
}

function submitFormDelete(){
	loadingModalOpen();
	dangerModalClose();
	$.ajax({
		type: "POST",
		url: $( "#myForm input[name=form_link]" ).val()+'action=delete',
		data: {
			'approval_title': $('input[name=approval_title]').val(), 
			'section_name': $('input[name=section_name]').val(), 
			'id': $('input[name=id]').val(), 
		},
		success: function(data){
			//console.log(data);
			setTimeout(function(){
				loadingModalClose();
				if(data == 't'){
					setTimeout(function(){
						$('a.btn.btn-back')[0].click();
					}, 500);
				}else{
					warningModalOpen();
				}
			}, 500);
		},
		error: function(data){
			//console.log('error'+data);
			setTimeout(function(){
				loadingModalClose();
				warningModalOpen();
			}, 500);
		},
		dataType: 'html'  //xml, json, script, or html
	});

	return false;
}

function submitFormPublish(){
	loadingModalOpen();
	publishModalClose();

	var data = {
		'section_name': $('input[name=section_name]').val(),
		'approval_title': $('input[name=approval_title]').val(),
		'id':$('input[name=id]').val(),
	};
	if($('input[name=approval_id]').length > 0) data.approval_id = $('input[name=approval_id]').val();

	$.ajax({
		type: "POST",
		url: $( "#myForm input[name=form_link]" ).val()+'action=publish',
		data: data,
		success: function(data){
			//console.log(data);
			setTimeout(function(){
				loadingModalClose();
				if(data == 't'){
					publishBtnHide();

					var link = $('input[name=preview_link]').val().replace(/^\/staging[0-9]{4}\//g, '');  //pattern: /staging0000/xxx/ -> xxx/
					crawler('', [link]);  //ultd.js
				}else{
					warningModalOpen();
				}
			}, 500);
		},
		error: function(data){
			//console.log('error'+data);
			setTimeout(function(){
				loadingModalClose();
				warningModalOpen();
			}, 500);
		},
		dataType: 'html'  //xml, json, script, or html
	});

	return false;
}

// cash rebate common save Remark & Alert (Only for cash rebate form)
function submitCashRebateCommonForm(){
	loadingModalOpen();
	modifyBeforeSubmit();
	setTimeout(function(){
		$.ajax({
			type: "POST",
			url: 'views/cashRebate_common_save.php',
			data: $( "#myForm" ).serialize(),
			success: function(data){
				//console.log(data);
				setTimeout(function(){
					loadingModalClose();
					if(data == 't'){  //admin group page
						successModalOpen();
						publishBtnShow();
					}else if(Number.isInteger(parseInt(data))){  //get return from last insert id
						if(data === '0'){
							warningModalOpen();
						}else if($('#myForm input[name=id]').val() == '0'){
							//$('a.btn.btn-back')[0].click();  //go back to listing
							//location.href = location.href + '?id=' + data;
							//location.reload();
							let s = (location.href.indexOf('?') > 0)?'&':'?';
							$('#successModal').find('button[data-dismiss=modal]').attr('onclick', "location.href = location.href + '" + s + "id=' + " + data + ";location.reload();");
							successModalOpen();
							$('button.btn-light[data-link]').attr('data-link2', $.trim($('[name=url]').val()) );//preview button
						}else{
							successModalOpen();
							publishBtnShow();
							$('button.btn-light[data-link]').attr('data-link2', $.trim($('[name=url]').val()) );//preview button
						}
					}else if(data == 'f'){
						warningModalOpen();
					}else if(data == 'cannot_send_email') {
						warningEmailModalOpen();
					}else{
						$('.modal-body p', '#duplicateModal').html(data);
						duplicateModalOpen();
					}
				}, 500);

			},
			error: function(data){
				//console.log('error'+data);
				setTimeout(function(){
					loadingModalClose();
					warningModalOpen();
				}, 500);
			},
			dataType: 'html'  //xml, json, script, or html
		});
	}, 200);

	return false;
}

function publishBtnHide(){
	$('.btn[data-target="#publishModal"]').hide();
	//$('i.publish-sign').removeClass('publish-sign-off').addClass('publish-sign-on');
}

function publishBtnShow(){
	$('.btn[data-target="#publishModal"]').show();
	//$('i.publish-sign').removeClass('publish-sign-on').addClass('publish-sign-off');
}
//submit eol

//error handling
function formErrorMessage(id){  //console.log(formErrorMessageObj);
	if(formErrorMessageObj.indexOf(id) < 0){
		formErrorMessageObj.push(id);
		if($('#'+id).prev().length > 0){
			$('.modal-body', '#validationModal').append($('#'+id).prev().html()+'<br/>');
		}
	}
}
//error handling

function modifyBeforeSubmit(){
	if($('.youtube_value').length > 0){
		$('.youtube_value').each(function(){
			var val = $(this).val();
			getYouTubeIdFromURL(val, $(this));
		});
	}
	/*if($('.concat_list').length > 0){
		$('.concat_list').each(function(){
			var selected = $(this).attr('data-selected');
			concatData('.inputFields[data-selected='+ selected +']');
		});
	}*/
}

// trim youtube id
function getYouTubeIdFromURL(url, obj){
	//var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
	var regExp = /^.*(youtu.be\/|v\/|embed\/|watch\?|youtube.com\/user\/[^#]*#([^\/]*?\/)*)\??v?=?([^#\&\?]*).*/;
	var m = url.match(regExp);
	if (m && m[3].length == 11){
		//return m[3];
		obj.val(m[3]);
	}else{
		//return false;
	}
}
// trim youtube id end

/*function addBtnImg(elmId, str, elmId2){
	var $elm = $('#'+elmId);
	var html = $elm.html();
	//var counter = $elm.parent().parent().find('.input-group').length;
	var counter = $('#'+elmId2).data('counter');
	counter++;
	$('#'+elmId2).data('counter', counter);
	html = html.replace(new RegExp('xxxxx', 'g'), str+counter);
	html = html.replace(new RegExp('yyyyy', 'g'), str);
	//$(html).insertBefore('#'+elmId2);
	$('#'+elmId2).prev().append(html);
	popoverReinit();
}*/

/*function concatData(parent){
	var $collect = $(parent).find('.data-collect');
	var $temp = $(parent).find('.list-item');
	if( $(parent).attr('data-concat') != undefined){
		var concat = $(parent).attr('data-concat');
	}else{
		var concat = '#####';
	}
	//console.log(concat);
	$collect.find('textarea').each(function(){
		var name = $(this).attr('name');
		var text = '';
		$temp.find('[data-temp='+ name + ']').each(function(){
			if($(this).hasClass('ckeditor')){
				var content = $(this).next().find('.ck-editor__editable_inline').html();
				if(content == '<p><br data-cke-filler="true"></p>'){
					content = '';
				}
			}else{
				var content = $(this).val();
			}
			text += content + concat;
			//console.log(text);
		})
		$(this).val(text);
	});
}*/

var groupTemplateAddDelayCallTO, groupTemplateAddDelayCallTO2;
function groupTemplateAdd(id, value, imgIndexAry){
	var $elm = $('#'+id);
	var html = $elm.html();
	var $wrapper = $elm.next();
	var elmId = $wrapper.attr('data-id');
	var counter = parseInt($wrapper.attr('data-counter'));

	html = html.replace(new RegExp('##id##', 'g'), counter);
	html = html.replace(new RegExp('"tab-pane"', 'g'), '"tab-pane active"');
	if(Array.isArray(value)){
		$.each(value, function(i, v){
			html = html.replace(new RegExp('xxxxx'), v);
		});
	}else{
		html = html.replace(new RegExp('xxxxx', 'g'), value);
	}
	$wrapper.append(html);
	$wrapper.attr('data-counter', counter+1);
	//copy from popover.js
	document.querySelectorAll('[data-toggle="popover"]').forEach(function (element) {
		new coreui.Popover(element);
	});
	//copy from popover.js end
	
	//add image field with popover
	$.each(imgIndexAry, function(index, val){
		let a = (Array.isArray(value))?value[val]:value;
		groupTemplateImgPopover($wrapper, counter, a);//edit.php
	});

	clearTimeout(groupTemplateAddDelayCallTO);
	clearTimeout(groupTemplateAddDelayCallTO2);
	groupTemplateAddDelayCallTO = setTimeout(function(){
		groupTemplateAddDelayCall();
	}, 500);
	groupTemplateAddDelayCallTO2 = setTimeout(function(){
		groupTemplateAddDelayCall2();
	}, 1000);
}
function groupTemplateAddDelayCall(){
	//add ckeditor
	allCKEditors = document.querySelectorAll('.ckeditor');
	for (var i = 0; i < allCKEditors.length; i++) {
		if(allCKEditors[i].offsetHeight == 0) continue;
		ClassicEditor
			.create( allCKEditors[i], ckeditorOpts)
			.then( editor => {
				//console.log( editor );
				allCKEditorObjs.push(editor);
				if(typeof ckEditorCallBackFn != 'undefined'){
					ckEditorCallBackFn();
				}
				editor.ui.focusTracker.on( 'change:isFocused', ( evt, data, isFocused ) => {
					//console.log( `The editor is focused: ${ isFocused }.` );
					if(typeof ckEditorCallBackFn != 'undefined'){
						ckEditorCallBackFn();
					}
				} );
			} )
			.catch( error => {
				//console.error( error );
			} );
	}
}
function groupTemplateAddDelayCall2(){
	var activeLang = $('.nav-link.active').eq(0).attr('aria-controls');
	$('.nav-link').each(function(){
		if($(this).attr('aria-controls') != activeLang){
			$(this).removeClass('active');
			$(this).attr('aria-selected', 'false');
		}else{
			$(this).addClass('active');
			$(this).attr('aria-selected', 'true');
		}
	});
	$('.tab-pane').each(function(){
		if($(this).attr('data-tab') != activeLang){
			$(this).removeClass('active');
		}else{
			$(this).addClass('active');
		}
	});
	//add bootstrap tab, copy from edit.js
	$('a[data-toggle="tab"]').on('click', function (e) {
		//console.log($(this).attr('href'));
		let temp = $(this).attr('href').replace('#', '');

		$('.nav-tabs-boxed .nav-tabs .nav-link').removeClass('active');
		$('.nav-tabs-boxed .nav-tabs .nav-link[href="#'+temp+'"]').addClass('active');
		
		$('.nav-tabs-boxed .tab-content .tab-pane').removeClass('active');
		$('.nav-tabs-boxed .tab-content .tab-pane[data-tab='+temp+']').addClass('active');
	});
}
function groupTemplateDelete(id){
	$('#'+id).remove();
}

/*function listAddImg(parent){
	var temp = $(parent).find('.template').html();
	var i = $(parent).find('.list-item').length;
	temp = temp.replace(new RegExp('##i##', 'g'), i);
	$(parent).find('.listing-wrapper').append(temp);
}
function listDeleteImg(obj){
	var id = $(obj).attr('data-index');
	var parent = $(obj).attr('data-parent');
	$(parent).find('.list-item[data-index=' + id + ']').remove();
}*/

/*function selectWithCat(val, articles){
	if(val == 'all'){
		articles.find('option').show();
		return;
	}
	articles.find('option').each(function(){
		var option = $(this).val().split('#')[0];
		if(option.indexOf(val) == -1){
			 $(this).hide();
		}else{
			$(this).show();
		}
	});
}*/

/*function templateSelection(){
	if($('.template-elem').length > 0){
		var selected = $("select[name=type_id]").children("option:selected").val();
		if($('.ref_images').length > 0){
			$('.ref_images img').hide();
		}
		$('.inputFields').hide();
		$('.inputFields[data-selected='+ selected + ']').show();
		if($('.ref_images').length > 0){
			$('.ref_images img[data-selected='+ selected + ']').show();
		}
		$("select[name=type_id]").change(function(){
			var selected = $(this).children("option:selected").val();
			$('.inputFields').hide();
			$('.inputFields[data-selected='+ selected + ']').show();
			if($('.ref_images').length > 0){
				$('.ref_images img').hide()
				$('.ref_images img[data-selected='+ selected + ']').show();
			}
		});
	}
}*/

//translate
function JTPYStr(){
	return '万与丑专业丛东丝丢两严丧个丬丰临为丽举么义乌乐乔习乡书买乱争于亏云亘亚产亩亲亵亸亿仅从仑仓仪们价众优伙会伛伞伟传伤伥伦伧伪伫体余佣佥侠侣侥侦侧侨侩侪侬俣俦俨俩俪俭债倾偬偻偾偿傥傧储傩儿兑兖党兰关兴兹养兽冁内冈册写军农冢冯冲决况冻净凄凉凌减凑凛几凤凫凭凯击凼凿刍划刘则刚创删别刬刭刽刿剀剂剐剑剥剧劝办务劢动励劲劳势勋勐勚匀匦匮区医华协单卖卢卤卧卫却卺厂厅历厉压厌厍厕厢厣厦厨厩厮县参叆叇双发变叙叠叶号叹叽吁后吓吕吗吣吨听启吴呒呓呕呖呗员呙呛呜咏咔咙咛咝咤咴咸哌响哑哒哓哔哕哗哙哜哝哟唛唝唠唡唢唣唤唿啧啬啭啮啰啴啸喷喽喾嗫呵嗳嘘嘤嘱噜噼嚣嚯团园囱围囵国图圆圣圹场坂坏块坚坛坜坝坞坟坠垄垅垆垒垦垧垩垫垭垯垱垲垴埘埙埚埝埯堑堕塆墙壮声壳壶壸处备复够头夸夹夺奁奂奋奖奥妆妇妈妩妪妫姗姜娄娅娆娇娈娱娲娴婳婴婵婶媪嫒嫔嫱嬷孙学孪宁宝实宠审宪宫宽宾寝对寻导寿将尔尘尧尴尸尽层屃屉届属屡屦屿岁岂岖岗岘岙岚岛岭岳岽岿峃峄峡峣峤峥峦崂崃崄崭嵘嵚嵛嵝嵴巅巩巯币帅师帏帐帘帜带帧帮帱帻帼幂幞干并广庄庆庐庑库应庙庞废庼廪开异弃张弥弪弯弹强归当录彟彦彻径徕御忆忏忧忾怀态怂怃怄怅怆怜总怼怿恋恳恶恸恹恺恻恼恽悦悫悬悭悯惊惧惨惩惫惬惭惮惯愍愠愤愦愿慑慭憷懑懒懔戆戋戏戗战戬户扎扑扦执扩扪扫扬扰抚抛抟抠抡抢护报担拟拢拣拥拦拧拨择挂挚挛挜挝挞挟挠挡挢挣挤挥挦捞损捡换捣据捻掳掴掷掸掺掼揸揽揿搀搁搂搅携摄摅摆摇摈摊撄撑撵撷撸撺擞攒敌敛数斋斓斗斩断无旧时旷旸昙昼昽显晋晒晓晔晕晖暂暧札术朴机杀杂权条来杨杩杰极构枞枢枣枥枧枨枪枫枭柜柠柽栀栅标栈栉栊栋栌栎栏树栖样栾桊桠桡桢档桤桥桦桧桨桩梦梼梾检棂椁椟椠椤椭楼榄榇榈榉槚槛槟槠横樯樱橥橱橹橼檐檩欢欤欧歼殁殇残殒殓殚殡殴毁毂毕毙毡毵氇气氢氩氲汇汉污汤汹沓沟没沣沤沥沦沧沨沩沪沵泞泪泶泷泸泺泻泼泽泾洁洒洼浃浅浆浇浈浉浊测浍济浏浐浑浒浓浔浕涂涌涛涝涞涟涠涡涢涣涤润涧涨涩淀渊渌渍渎渐渑渔渖渗温游湾湿溃溅溆溇滗滚滞滟滠满滢滤滥滦滨滩滪漤潆潇潋潍潜潴澜濑濒灏灭灯灵灾灿炀炉炖炜炝点炼炽烁烂烃烛烟烦烧烨烩烫烬热焕焖焘煅煳熘爱爷牍牦牵牺犊犟状犷犸犹狈狍狝狞独狭狮狯狰狱狲猃猎猕猡猪猫猬献獭玑玙玚玛玮环现玱玺珉珏珐珑珰珲琎琏琐琼瑶瑷璇璎瓒瓮瓯电画畅畲畴疖疗疟疠疡疬疮疯疱疴痈痉痒痖痨痪痫痴瘅瘆瘗瘘瘪瘫瘾瘿癞癣癫癯皑皱皲盏盐监盖盗盘眍眦眬着睁睐睑瞒瞩矫矶矾矿砀码砖砗砚砜砺砻砾础硁硅硕硖硗硙硚确硷碍碛碜碱碹磙礼祎祢祯祷祸禀禄禅离秃秆种积称秽秾稆税稣稳穑穷窃窍窑窜窝窥窦窭竖竞笃笋笔笕笺笼笾筑筚筛筜筝筹签简箓箦箧箨箩箪箫篑篓篮篱簖籁籴类籼粜粝粤粪粮糁糇紧絷纟纠纡红纣纤纥约级纨纩纪纫纬纭纮纯纰纱纲纳纴纵纶纷纸纹纺纻纼纽纾线绀绁绂练组绅细织终绉绊绋绌绍绎经绐绑绒结绔绕绖绗绘给绚绛络绝绞统绠绡绢绣绤绥绦继绨绩绪绫绬续绮绯绰绱绲绳维绵绶绷绸绹绺绻综绽绾绿缀缁缂缃缄缅缆缇缈缉缊缋缌缍缎缏缐缑缒缓缔缕编缗缘缙缚缛缜缝缞缟缠缡缢缣缤缥缦缧缨缩缪缫缬缭缮缯缰缱缲缳缴缵罂网罗罚罢罴羁羟羡翘翙翚耢耧耸耻聂聋职聍联聩聪肃肠肤肷肾肿胀胁胆胜胧胨胪胫胶脉脍脏脐脑脓脔脚脱脶脸腊腌腘腭腻腼腽腾膑臜舆舣舰舱舻艰艳艹艺节芈芗芜芦苁苇苈苋苌苍苎苏苘苹茎茏茑茔茕茧荆荐荙荚荛荜荞荟荠荡荣荤荥荦荧荨荩荪荫荬荭荮药莅莜莱莲莳莴莶获莸莹莺莼萚萝萤营萦萧萨葱蒇蒉蒋蒌蓝蓟蓠蓣蓥蓦蔷蔹蔺蔼蕲蕴薮藁藓虏虑虚虫虬虮虽虾虿蚀蚁蚂蚕蚝蚬蛊蛎蛏蛮蛰蛱蛲蛳蛴蜕蜗蜡蝇蝈蝉蝎蝼蝾螀螨蟏衅衔补衬衮袄袅袆袜袭袯装裆裈裢裣裤裥褛褴襁襕见观觃规觅视觇览觉觊觋觌觍觎觏觐觑觞触觯詟誉誊讠计订讣认讥讦讧讨让讪讫训议讯记讱讲讳讴讵讶讷许讹论讻讼讽设访诀证诂诃评诅识诇诈诉诊诋诌词诎诏诐译诒诓诔试诖诗诘诙诚诛诜话诞诟诠诡询诣诤该详诧诨诩诪诫诬语诮误诰诱诲诳说诵诶请诸诹诺读诼诽课诿谀谁谂调谄谅谆谇谈谊谋谌谍谎谏谐谑谒谓谔谕谖谗谘谙谚谛谜谝谞谟谠谡谢谣谤谥谦谧谨谩谪谫谬谭谮谯谰谱谲谳谴谵谶谷豮贝贞负贠贡财责贤败账货质贩贪贫贬购贮贯贰贱贲贳贴贵贶贷贸费贺贻贼贽贾贿赀赁赂赃资赅赆赇赈赉赊赋赌赍赎赏赐赑赒赓赔赕赖赗赘赙赚赛赜赝赞赟赠赡赢赣赪赵赶趋趱趸跃跄跖跞践跶跷跸跹跻踊踌踪踬踯蹑蹒蹰蹿躏躜躯车轧轨轩轪轫转轭轮软轰轱轲轳轴轵轶轷轸轹轺轻轼载轾轿辀辁辂较辄辅辆辇辈辉辊辋辌辍辎辏辐辑辒输辔辕辖辗辘辙辚辞辩辫边辽达迁过迈运还这进远违连迟迩迳迹适选逊递逦逻遗遥邓邝邬邮邹邺邻郁郄郏郐郑郓郦郧郸酝酦酱酽酾酿释里鉅鉴銮錾钆钇针钉钊钋钌钍钎钏钐钑钒钓钔钕钖钗钘钙钚钛钝钞钟钠钡钢钣钤钥钦钧钨钩钪钫钬钭钮钯钰钱钲钳钴钵钶钷钸钹钺钻钼钽钾钿铀铁铂铃铄铅铆铈铉铊铋铍铎铏铐铑铒铕铗铘铙铚铛铜铝铞铟铠铡铢铣铤铥铦铧铨铪铫铬铭铮铯铰铱铲铳铴铵银铷铸铹铺铻铼铽链铿销锁锂锃锄锅锆锇锈锉锊锋锌锍锎锏锐锑锒锓锔锕锖锗错锚锜锞锟锠锡锢锣锤锥锦锨锩锫锬锭键锯锰锱锲锳锴锵锶锷锸锹锺锻锼锽锾锿镀镁镂镃镆镇镈镉镊镌镍镎镏镐镑镒镕镖镗镙镚镛镜镝镞镟镠镡镢镣镤镥镦镧镨镩镪镫镬镭镮镯镰镱镲镳镴镶长门闩闪闫闬闭问闯闰闱闲闳间闵闶闷闸闹闺闻闼闽闾闿阀阁阂阃阄阅阆阇阈阉阊阋阌阍阎阏阐阑阒阓阔阕阖阗阘阙阚阛队阳阴阵阶际陆陇陈陉陕陧陨险随隐隶隽难雏雠雳雾霁霉霭靓静靥鞑鞒鞯鞴韦韧韨韩韪韫韬韵页顶顷顸项顺须顼顽顾顿颀颁颂颃预颅领颇颈颉颊颋颌颍颎颏颐频颒颓颔颕颖颗题颙颚颛颜额颞颟颠颡颢颣颤颥颦颧风飏飐飑飒飓飔飕飖飗飘飙飚飞飨餍饤饥饦饧饨饩饪饫饬饭饮饯饰饱饲饳饴饵饶饷饸饹饺饻饼饽饾饿馀馁馂馃馄馅馆馇馈馉馊馋馌馍馎馏馐馑馒馓馔馕马驭驮驯驰驱驲驳驴驵驶驷驸驹驺驻驼驽驾驿骀骁骂骃骄骅骆骇骈骉骊骋验骍骎骏骐骑骒骓骔骕骖骗骘骙骚骛骜骝骞骟骠骡骢骣骤骥骦骧髅髋髌鬓魇魉鱼鱽鱾鱿鲀鲁鲂鲄鲅鲆鲇鲈鲉鲊鲋鲌鲍鲎鲏鲐鲑鲒鲓鲔鲕鲖鲗鲘鲙鲚鲛鲜鲝鲞鲟鲠鲡鲢鲣鲤鲥鲦鲧鲨鲩鲪鲫鲬鲭鲮鲯鲰鲱鲲鲳鲴鲵鲶鲷鲸鲹鲺鲻鲼鲽鲾鲿鳀鳁鳂鳃鳄鳅鳆鳇鳈鳉鳊鳋鳌鳍鳎鳏鳐鳑鳒鳓鳔鳕鳖鳗鳘鳙鳛鳜鳝鳞鳟鳠鳡鳢鳣鸟鸠鸡鸢鸣鸤鸥鸦鸧鸨鸩鸪鸫鸬鸭鸮鸯鸰鸱鸲鸳鸴鸵鸶鸷鸸鸹鸺鸻鸼鸽鸾鸿鹀鹁鹂鹃鹄鹅鹆鹇鹈鹉鹊鹋鹌鹍鹎鹏鹐鹑鹒鹓鹔鹕鹖鹗鹘鹚鹛鹜鹝鹞鹟鹠鹡鹢鹣鹤鹥鹦鹧鹨鹩鹪鹫鹬鹭鹯鹰鹱鹲鹳鹴鹾麦麸黄黉黡黩黪黾鼋鼌鼍鼗鼹齄齐齑齿龀龁龂龃龄龅龆龇龈龉龊龋龌龙龚龛龟志制咨只里系范松没尝尝闹面准钟别闲干尽脏拼';
}
function FTPYStr(){
	return '萬與醜專業叢東絲丟兩嚴喪個爿豐臨為麗舉麼義烏樂喬習鄉書買亂爭於虧雲亙亞產畝親褻嚲億僅從侖倉儀們價眾優夥會傴傘偉傳傷倀倫傖偽佇體餘傭僉俠侶僥偵側僑儈儕儂俁儔儼倆儷儉債傾傯僂僨償儻儐儲儺兒兌兗黨蘭關興茲養獸囅內岡冊寫軍農塚馮衝決況凍淨淒涼淩減湊凜幾鳳鳧憑凱擊氹鑿芻劃劉則剛創刪別剗剄劊劌剴劑剮劍剝劇勸辦務勱動勵勁勞勢勳猛勩勻匭匱區醫華協單賣盧鹵臥衛卻巹廠廳曆厲壓厭厙廁廂厴廈廚廄廝縣參靉靆雙發變敘疊葉號歎嘰籲後嚇呂嗎唚噸聽啟吳嘸囈嘔嚦唄員咼嗆嗚詠哢嚨嚀噝吒噅鹹呱響啞噠嘵嗶噦嘩噲嚌噥喲嘜嗊嘮啢嗩唕喚呼嘖嗇囀齧囉嘽嘯噴嘍嚳囁嗬噯噓嚶囑嚕劈囂謔團園囪圍圇國圖圓聖壙場阪壞塊堅壇壢壩塢墳墜壟壟壚壘墾坰堊墊埡墶壋塏堖塒塤堝墊垵塹墮壪牆壯聲殼壺壼處備複夠頭誇夾奪奩奐奮獎奧妝婦媽嫵嫗媯姍薑婁婭嬈嬌孌娛媧嫻嫿嬰嬋嬸媼嬡嬪嬙嬤孫學孿寧寶實寵審憲宮寬賓寢對尋導壽將爾塵堯尷屍盡層屭屜屆屬屢屨嶼歲豈嶇崗峴嶴嵐島嶺嶽崠巋嶨嶧峽嶢嶠崢巒嶗崍嶮嶄嶸嶔崳嶁脊巔鞏巰幣帥師幃帳簾幟帶幀幫幬幘幗冪襆幹並廣莊慶廬廡庫應廟龐廢廎廩開異棄張彌弳彎彈強歸當錄彠彥徹徑徠禦憶懺憂愾懷態慫憮慪悵愴憐總懟懌戀懇惡慟懨愷惻惱惲悅愨懸慳憫驚懼慘懲憊愜慚憚慣湣慍憤憒願懾憖怵懣懶懍戇戔戲戧戰戩戶紮撲扡執擴捫掃揚擾撫拋摶摳掄搶護報擔擬攏揀擁攔擰撥擇掛摯攣掗撾撻挾撓擋撟掙擠揮撏撈損撿換搗據撚擄摑擲撣摻摜摣攬撳攙擱摟攪攜攝攄擺搖擯攤攖撐攆擷擼攛擻攢敵斂數齋斕鬥斬斷無舊時曠暘曇晝曨顯晉曬曉曄暈暉暫曖劄術樸機殺雜權條來楊榪傑極構樅樞棗櫪梘棖槍楓梟櫃檸檉梔柵標棧櫛櫳棟櫨櫟欄樹棲樣欒棬椏橈楨檔榿橋樺檜槳樁夢檮棶檢欞槨櫝槧欏橢樓欖櫬櫚櫸檟檻檳櫧橫檣櫻櫫櫥櫓櫞簷檁歡歟歐殲歿殤殘殞殮殫殯毆毀轂畢斃氈毿氌氣氫氬氳彙漢汙湯洶遝溝沒灃漚瀝淪滄渢溈滬濔濘淚澩瀧瀘濼瀉潑澤涇潔灑窪浹淺漿澆湞溮濁測澮濟瀏滻渾滸濃潯濜塗湧濤澇淶漣潿渦溳渙滌潤澗漲澀澱淵淥漬瀆漸澠漁瀋滲溫遊灣濕潰濺漵漊潷滾滯灩灄滿瀅濾濫灤濱灘澦濫瀠瀟瀲濰潛瀦瀾瀨瀕灝滅燈靈災燦煬爐燉煒熗點煉熾爍爛烴燭煙煩燒燁燴燙燼熱煥燜燾煆糊溜愛爺牘犛牽犧犢強狀獷獁猶狽麅獮獰獨狹獅獪猙獄猻獫獵獼玀豬貓蝟獻獺璣璵瑒瑪瑋環現瑲璽瑉玨琺瓏璫琿璡璉瑣瓊瑤璦璿瓔瓚甕甌電畫暢佘疇癤療瘧癘瘍鬁瘡瘋皰屙癰痙癢瘂癆瘓癇癡癉瘮瘞瘺癟癱癮癭癩癬癲臒皚皺皸盞鹽監蓋盜盤瞘眥矓著睜睞瞼瞞矚矯磯礬礦碭碼磚硨硯碸礪礱礫礎硜矽碩硤磽磑礄確鹼礙磧磣堿镟滾禮禕禰禎禱禍稟祿禪離禿稈種積稱穢穠穭稅穌穩穡窮竊竅窯竄窩窺竇窶豎競篤筍筆筧箋籠籩築篳篩簹箏籌簽簡籙簀篋籜籮簞簫簣簍籃籬籪籟糴類秈糶糲粵糞糧糝餱緊縶糸糾紆紅紂纖紇約級紈纊紀紉緯紜紘純紕紗綱納紝縱綸紛紙紋紡紵紖紐紓線紺絏紱練組紳細織終縐絆紼絀紹繹經紿綁絨結絝繞絰絎繪給絢絳絡絕絞統綆綃絹繡綌綏絛繼綈績緒綾緓續綺緋綽緔緄繩維綿綬繃綢綯綹綣綜綻綰綠綴緇緙緗緘緬纜緹緲緝縕繢緦綞緞緶線緱縋緩締縷編緡緣縉縛縟縝縫縗縞纏縭縊縑繽縹縵縲纓縮繆繅纈繚繕繒韁繾繰繯繳纘罌網羅罰罷羆羈羥羨翹翽翬耮耬聳恥聶聾職聹聯聵聰肅腸膚膁腎腫脹脅膽勝朧腖臚脛膠脈膾髒臍腦膿臠腳脫腡臉臘醃膕齶膩靦膃騰臏臢輿艤艦艙艫艱豔艸藝節羋薌蕪蘆蓯葦藶莧萇蒼苧蘇檾蘋莖蘢蔦塋煢繭荊薦薘莢蕘蓽蕎薈薺蕩榮葷滎犖熒蕁藎蓀蔭蕒葒葤藥蒞蓧萊蓮蒔萵薟獲蕕瑩鶯蓴蘀蘿螢營縈蕭薩蔥蕆蕢蔣蔞藍薊蘺蕷鎣驀薔蘞藺藹蘄蘊藪槁蘚虜慮虛蟲虯蟣雖蝦蠆蝕蟻螞蠶蠔蜆蠱蠣蟶蠻蟄蛺蟯螄蠐蛻蝸蠟蠅蟈蟬蠍螻蠑螿蟎蠨釁銜補襯袞襖嫋褘襪襲襏裝襠褌褳襝褲襇褸襤繈襴見觀覎規覓視覘覽覺覬覡覿覥覦覯覲覷觴觸觶讋譽謄訁計訂訃認譏訐訌討讓訕訖訓議訊記訒講諱謳詎訝訥許訛論訩訟諷設訪訣證詁訶評詛識詗詐訴診詆謅詞詘詔詖譯詒誆誄試詿詩詰詼誠誅詵話誕詬詮詭詢詣諍該詳詫諢詡譸誡誣語誚誤誥誘誨誑說誦誒請諸諏諾讀諑誹課諉諛誰諗調諂諒諄誶談誼謀諶諜謊諫諧謔謁謂諤諭諼讒諮諳諺諦謎諞諝謨讜謖謝謠謗諡謙謐謹謾謫譾謬譚譖譙讕譜譎讞譴譫讖穀豶貝貞負貟貢財責賢敗賬貨質販貪貧貶購貯貫貳賤賁貰貼貴貺貸貿費賀貽賊贄賈賄貲賃賂贓資賅贐賕賑賚賒賦賭齎贖賞賜贔賙賡賠賧賴賵贅賻賺賽賾贗讚贇贈贍贏贛赬趙趕趨趲躉躍蹌蹠躒踐躂蹺蹕躚躋踴躊蹤躓躑躡蹣躕躥躪躦軀車軋軌軒軑軔轉軛輪軟轟軲軻轤軸軹軼軤軫轢軺輕軾載輊轎輈輇輅較輒輔輛輦輩輝輥輞輬輟輜輳輻輯轀輸轡轅轄輾轆轍轔辭辯辮邊遼達遷過邁運還這進遠違連遲邇逕跡適選遜遞邐邏遺遙鄧鄺鄔郵鄒鄴鄰鬱郤郟鄶鄭鄆酈鄖鄲醞醱醬釅釃釀釋裏钜鑒鑾鏨釓釔針釘釗釙釕釷釺釧釤鈒釩釣鍆釹鍚釵鈃鈣鈈鈦鈍鈔鍾鈉鋇鋼鈑鈐鑰欽鈞鎢鉤鈧鈁鈥鈄鈕鈀鈺錢鉦鉗鈷缽鈳鉕鈽鈸鉞鑽鉬鉭鉀鈿鈾鐵鉑鈴鑠鉛鉚鈰鉉鉈鉍鈹鐸鉶銬銠鉺銪鋏鋣鐃銍鐺銅鋁銱銦鎧鍘銖銑鋌銩銛鏵銓鉿銚鉻銘錚銫鉸銥鏟銃鐋銨銀銣鑄鐒鋪鋙錸鋱鏈鏗銷鎖鋰鋥鋤鍋鋯鋨鏽銼鋝鋒鋅鋶鐦鐧銳銻鋃鋟鋦錒錆鍺錯錨錡錁錕錩錫錮鑼錘錐錦鍁錈錇錟錠鍵鋸錳錙鍥鍈鍇鏘鍶鍔鍤鍬鍾鍛鎪鍠鍰鎄鍍鎂鏤鎡鏌鎮鎛鎘鑷鐫鎳鎿鎦鎬鎊鎰鎔鏢鏜鏍鏰鏞鏡鏑鏃鏇鏐鐔钁鐐鏷鑥鐓鑭鐠鑹鏹鐙鑊鐳鐶鐲鐮鐿鑔鑣鑞鑲長門閂閃閆閈閉問闖閏闈閑閎間閔閌悶閘鬧閨聞闥閩閭闓閥閣閡閫鬮閱閬闍閾閹閶鬩閿閽閻閼闡闌闃闠闊闋闔闐闒闕闞闤隊陽陰陣階際陸隴陳陘陝隉隕險隨隱隸雋難雛讎靂霧霽黴靄靚靜靨韃鞽韉韝韋韌韍韓韙韞韜韻頁頂頃頇項順須頊頑顧頓頎頒頌頏預顱領頗頸頡頰頲頜潁熲頦頤頻頮頹頷頴穎顆題顒顎顓顏額顳顢顛顙顥纇顫顬顰顴風颺颭颮颯颶颸颼颻飀飄飆飆飛饗饜飣饑飥餳飩餼飪飫飭飯飲餞飾飽飼飿飴餌饒餉餄餎餃餏餅餑餖餓餘餒餕餜餛餡館餷饋餶餿饞饁饃餺餾饈饉饅饊饌饢馬馭馱馴馳驅馹駁驢駔駛駟駙駒騶駐駝駑駕驛駘驍罵駰驕驊駱駭駢驫驪騁驗騂駸駿騏騎騍騅騌驌驂騙騭騤騷騖驁騮騫騸驃騾驄驏驟驥驦驤髏髖髕鬢魘魎魚魛魢魷魨魯魴魺鮁鮃鯰鱸鮋鮓鮒鮊鮑鱟鮍鮐鮭鮚鮳鮪鮞鮦鰂鮜鱠鱭鮫鮮鮺鯗鱘鯁鱺鰱鰹鯉鰣鰷鯀鯊鯇鮶鯽鯒鯖鯪鯕鯫鯡鯤鯧鯝鯢鯰鯛鯨鯵鯴鯔鱝鰈鰏鱨鯷鰮鰃鰓鱷鰍鰒鰉鰁鱂鯿鰠鼇鰭鰨鰥鰩鰟鰜鰳鰾鱈鱉鰻鰵鱅鰼鱖鱔鱗鱒鱯鱤鱧鱣鳥鳩雞鳶鳴鳲鷗鴉鶬鴇鴆鴣鶇鸕鴨鴞鴦鴒鴟鴝鴛鴬鴕鷥鷙鴯鴰鵂鴴鵃鴿鸞鴻鵐鵓鸝鵑鵠鵝鵒鷳鵜鵡鵲鶓鵪鶤鵯鵬鵮鶉鶊鵷鷫鶘鶡鶚鶻鶿鶥鶩鷊鷂鶲鶹鶺鷁鶼鶴鷖鸚鷓鷚鷯鷦鷲鷸鷺鸇鷹鸌鸏鸛鸘鹺麥麩黃黌黶黷黲黽黿鼂鼉鞀鼴齇齊齏齒齔齕齗齟齡齙齠齜齦齬齪齲齷龍龔龕龜誌製谘隻裡係範鬆冇嚐嘗鬨麵準鐘彆閒乾儘臟拚';
}
function translateAction(cc, type){
	var str = '';
	if(type == 'sc2tc'){
		var ss = JTPYStr();
		var tt = FTPYStr();
	}else{
		var tt = JTPYStr();
		var ss = FTPYStr();
	}

	for(var i = 0 ; i < cc.length ; i++ ){
		if( cc.charCodeAt(i) > 10000 && ss.indexOf( cc.charAt(i) ) != -1 )
			str += tt.charAt( ss.indexOf( cc.charAt(i) ) );
  		else 
  			str += cc.charAt(i);
	}
	return str;
}
function translateTC2SC(){
	$.each($('*[name*=_tc]'), function(index, value){
		var v;
		var orgId = $(this).attr('id');
		if($(this).is('input')){
			v = $(this).val();
		}else{
			v = $(this).val();
			allCKEditorObjs.forEach( (elm, index)=>{
				if(elm.sourceElement.id == orgId){
					v = allCKEditorObjs[index].getData();
				}
			});
		}
		v = translateAction(v, '');
		$('*[name*=_sc]').eq(index).val(v);
		var id = orgId.replace('_tc', '_sc');
		allCKEditorObjs.forEach( (elm, index)=>{
			if(elm.sourceElement.id == id){
				allCKEditorObjs[index].setData(v);
			}
		});
	});
}
//translate end

function urlSlug(str){
    //return str.replace(/[^0-9a-z\-_#/]/g, '').replace(/(\..*)\./g, '$1');
    return str.trim().toLowerCase().replace(/ /g,'-').replace(/[^#\w-]+/g,'');
}

