$(function(){
	$('#sidebar a.c-sidebar-nav-link').on('click', function(){
		//console.log($(this).html());
		if(table) table.datatable.state.clear();
	});

	window['$imageCropModal'] = new coreui.Modal(document.getElementById('imageCropModal'), {
		keyboard: false
		, backdrop: 'static' //true, click to close
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
			[600, 400]
			, [250, 250]
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
			ready: function () {

			},
			cropmove: function () {

			},
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

// crawler

function crawler(link){
	return;
	if(link.slice(-1) != '/'){
		link = link + '/';
	}
	$.ajax({
			type: "POST",
			url: '../crawler/update/',
			data: {'link': link},
			success: function(data){
			},
			error: function(data){
			},
		})
}

function bulk_crawler(section, links){
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
			success: function(data){
			},
			error: function(data){
			},
		})

}
/*var modalAry = ['clearCacheModel'];

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
});*/
window['$clearCacheModal'] = new coreui.Modal(document.getElementById('clearCacheModal'), {
	keyboard: false
	, backdrop: 'static' //true, click to close
});
window['clearCacheModalClose'] = ()=>{
	window['$clearCacheModal'].hide();
}

function updateSitemap(){
	$.ajax({
			type: "POST",
			url: '../../gensitemap/',
			data: '',
			success: function(data){
				console.log('update Sitemap');
			//	clearCacheModalClose();
				//$('#clearCacheModal').hide();
			}
		})
}
function updateBankApi(){
	console.log('updateBankApi');
	$.ajax({
			type: "POST",
			url: '../../home/update_bank/',
			data: 'type=bank',
			dataType: "json",
			success: function(data){
				console.log(data);
				$(data).each(function(i, item){
					console.log(item);
					var temp = JSON.stringify(item);

					$.ajax({
							type: "POST",
							url: '../../home/update_bank/',
							data: 'type=process&data=' + temp,
							dataType: "json",
							success: function(data){
								console.log(data);
							}
						})
				})
			//	console.log('update updateBankApi');
			//	clearCacheModalClose();
				//$('#clearCacheModal').hide();
			}
		})
}

function clearCache(){
	$.ajax({
			type: "POST",
			url: '../../clear-cache/',
			data: '',
			success: function(data){
				console.log('Clear Cache');
				clearCacheModalClose();
				//$('#clearCacheModal').hide();
			}
		})
}

function createCache(page){
	if(page.indexOf('//') > 1) return;
	$.ajax({
		type: "POST",
		url: page,
		data: '',
		success: function(){
			console.log('createCache');
			//$('#clearCacheModal').hide();
		}
	})
}

function downloadPdf(code){
	// Create a new link
	$.ajax({
		type: "POST",
		url: '../../apply-now/download-pdf/',
		data: 'code=' + code + '&regen=true',
		success: function(data){
			console.log(data);
			const anchor = document.createElement('a');
			//anchor.href = '../temp_pdf/' + code + '.pdf';
			anchor.href = '../' + data;
			//anchor.download = code + '.pdf' ;
			let tempAry = data.split('/');
			anchor.download = tempAry[tempAry.length -1];
			// Append to the DOM
			document.body.appendChild(anchor);
			// Trigger `click` event
			anchor.click();
			// Remove element from DOM
			document.body.removeChild(anchor);
		}
	})
	return;

}

function downloadPdf_midland(code){
	// Create a new link
	$.ajax({
		type: "POST",
		url: '../../midland-apply-now/download-pdf/',
		data: 'code=' + code + '&regen=true',
		success: function(data){
			console.log(data);
			const anchor = document.createElement('a');
			//anchor.href = '../temp_midland_pdf/' + code + '.pdf';
			anchor.href = '../' + data;
			//anchor.download = code + '.pdf' ;
			let tempAry = data.split('/');
			anchor.download = tempAry[tempAry.length -1];
			// Append to the DOM
			document.body.appendChild(anchor);
			// Trigger `click` event
			anchor.click();
			// Remove element from DOM
			document.body.removeChild(anchor);
		}
	})
	return;
}
