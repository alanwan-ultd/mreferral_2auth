$(function(){
	$('#sidebar .c-sidebar-nav-title').each(function(){
		if( !($(this).next().hasClass('c-sidebar-nav-dropdown')
			|| $(this).next().hasClass('c-sidebar-nav-item')
		)){
			$(this).hide();
		}
	});

	//left menu item, and listing back button
	$('#sidebar a.c-sidebar-nav-link').on('click', function(){
		//console.log($(this).html());
		if(table) table.datatable.state.clear();
	});
	
	window['$imageCropModal'] = new coreui.Modal(document.getElementById('imageCropModal'), {
		keyboard: false, 
		backdrop: 'static',  //true, click to close
	});
});

$(window).on('load', function(){
	crop = new Crop();
	
	document.getElementById('imageCropModal').addEventListener('shown.coreui.modal', function () {
		//do nothing
	});
	document.getElementById('imageCropModal').addEventListener('hidden.coreui.modal', function () {
		crop.reset();
		document.getElementById(crop.downloadTagId).innerHTML = '';
		$('#imageCropModal .modal-body').addClass('just-open');
	});
});

class Crop{
	constructor(){
		this.imageTagId = 'cropImage';
		this.downloadTagId = 'cropDownload';
		this.uploadedImageName = 'picture.jpg';
		this.uploadedImageType = 'image_jpeg';
		this.$inputImage = document.getElementById('cropInputImage');
		this._default = [
			[600, 400], 
			[250, 250], 
		];
		this.custom = [];
		
		this.init();
	}
	init(){
		var self = this;
		this.$inputImage.onchange = function () {
			$('#imageCropModal .modal-body').removeClass('just-open');
			if(!self.cropper){
				self.createCropper();
			}
			
			var files = this.files;
			var file;

			if (files && files.length) {
				file = files[0];
				if (/^image\/\w+/.test(file.type)) {
					self.uploadedImageType = file.type;
					self.uploadedImageName = file.name;
					document.getElementById(self.imageTagId).src = URL.createObjectURL(file);
					self.destroy();
					self.createCropper();
					self.$inputImage.value = null;
				} else {
					window.alert('Please choose an image file.');
				}
			}
		};
	}//fn init
	reset(){
		this.destroy();
		$('#cropInputImage').val('');
		this.custom = [];
	}
	destroy(){
		if(this.cropper) this.cropper.destroy();
	}//fn destroy
	changeRatio(r){
		this.cropper.setAspectRatio(r);
	}//fn changeRatio
	createButton(ary){
		$.each(ary, function(index, value){
			$('#imageCropModal .btn-group-crop').append('<button class="btn btn-primary" onclick="crop.output({ width: '+value[0]+', height: '+value[1]+' })">'+value[0]+'×'+value[1]+'</button>');
			$('#imageCropModal .btn-group-ratio').append('<button class="btn btn-info" onclick="crop.changeRatio('+value[0]+'/'+value[1]+')">'+value[0]+':'+value[1]+'</button>');
		});
	}
	createCropper(){
		$('#imageCropModal .btn-group-crop > button').not(':first').remove();
		$('#imageCropModal .btn-group-ratio > button').not(':first').remove();
		if(this.custom.length == 0){
			this.createButton(this._default);
		}else{
			this.createButton(this.custom);
		}
		
		var r;
		if(this.custom.length == 0){
			r = this._default[0][0]/this._default[0][1];
		}else{
			r = this.custom[0][0]/this.custom[0][1];
		}
		var image = document.querySelector('#'+this.imageTagId);
		this.cropper = new Cropper(image, {
			aspectRatio: r,
			ready: function () {},
			cropmove: function () {},
		});
	}//fn createCropper
	open(){
		$imageCropModal.show();
	}//fn open
	output(opt){
		var output = this.cropper.getCroppedCanvas(opt).toDataURL();
		//console.log(output);
		document.getElementById(this.downloadTagId).innerHTML = '<a href="'+output+'" download="'+this.uploadedImageName+'"><img src="'+output+'"></a>';
	}//fn output
	setCustom(ary){
		this.custom = ary;
	}
}//class crop

//crawler
function crawler(section, links){//links need be an array
	for (var i = 0; i < links.length; i++) {
		links[i] = section + links[i];
		if(links[i].slice(-1) != '/'){
			links[i] =  links[i] + '/';
		}
	}

	$.ajax({
		type: "POST",
		url: '../crawler/update/',
		data: {'link': links},
		success: function(data){},
		error: function(data){},
	});
}
//crawler end

// Cookies
function cookieGet(c_name) {
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1){
		c_start = c_value.indexOf(c_name + "=");
	}
	if (c_start == -1){
		c_value = null;
	}else{
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1){
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
	}
	return c_value;
}

function cookieSet(c_name, value, exdays) {
	if(typeof exdays == 'undefined') exdays = 1;
	var exdate = new Date();
	exdate.setTime(exdate.getTime() + (exdays*24*60*60*1000) );
	var c_value = escape(value) + "; path=/; expires="+exdate.toUTCString();
	document.cookie = c_name + "=" + c_value;
}