				</div>
			</div>
		</main>
		<footer class="c-footer">
			<div class="ml-auto">© <?php echo $setting->CMS_COPYRIGHT_YEAR; ?> <?php echo $setting->CMS_COMPANY_NAME; ?></div>
		</footer>
	</div>
</div>

<?php echo renderModal('loadingModal', '', 'Loading', 'Please wait...', false, false); ?>
<?php echo renderModal('successModal', 'success', 'Save', '<p>Record saved.</p>', true, false); ?>
<?php echo renderModal('warningModal', 'warning', 'Error', '<p>Record cannot be saved.</p>', true, false); ?>
<?php echo renderModal('clearCacheModal', 'success', 'Clear Cache', '<p>Are you sure Clear Cache?</p>', true, true, '', 'onclick="clearCache()"', 'onclick="clearCacheModalClose()"'); ?>
<?php echo renderModal('sitemapModal', 'success', '', '<p>Updated.</p>', true, false, 'onclick="updateSitemap()"', '', ''); ?>
<?php echo renderModal('bankapiModal', 'success', '', '<p>Updated.</p>', true, false, 'onclick="updateBankApi()"', '', ''); ?>

<div class="modal fade" id="imageCropModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Cropping Tool</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body just-open">
				<div class="img-container mb-3">
					<img id="cropImage" src="assets/img/picture.png" alt="Picture">
				</div>
				<div class="mb-3">
					<input type="file" id="cropInputImage" name="file" accept="image/*">
				</div>
				<div class="btn-group btn-group-crop mb-3 mr-1">
					<button class="btn btn-primary" onclick="crop.output({ maxWidth: 4096, maxHeight: 4096 })">Crop size</button>
					<button class="btn btn-primary" onclick="crop.output({ width: 160, height: 90 })">160×90</button>
					<button class="btn btn-primary" onclick="crop.output({ width: 320, height: 180 })">320×180</button>
				</div>
				<div class="btn-group btn-group-ratio mb-3">
					<button class="btn btn-info" onclick="crop.changeRatio(NaN)"><i class="icon-crop1 mr-1"></i>Free crop</button>
					<button class="btn btn-info" onclick="crop.changeRatio(16/9)">16:9</button>
					<button class="btn btn-info" onclick="crop.changeRatio(1)">1:1</button>
				</div>
				<div id="cropDownload"></div>
			</div>
			<div class="modal-footer"></div>
		</div><!-- /.modal-content-->
	</div><!-- /.modal-dialog-->
</div>


<!-- CoreUI and necessary plugins-->
<script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
<!--[if IE]><!-->
<script src="vendors/@coreui/icons/js/svgxuse.min.js"></script>
<!--<![endif]-->
<script src="lib/jquery/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="lib/DataTables-1.10.21/datatables.min.css"/>
<script src="lib/DataTables-1.10.21/datatables.min.js"></script>
<!-- DataTables extension -->
<script src="lib/DataTables-1.10.21/ext/dataTables.rowReorder.min.js"></script>
<link href="lib/DataTables-1.10.21/ext/rowReorder.dataTables.min.css" rel="stylesheet">
<!-- DataTables extension -->
<script src="js/Table.js"></script>

<link rel="stylesheet" href="lib/hyperform-0.12.0/css/hyperform.css">
<script src="lib/hyperform-0.12.0/js/hyperform.min.js"></script>
<script src="lib/ckeditor5/29.1.0/build/ckeditor.js"></script>

<!--script src="lib/ckeditor5/19.1.1/custom/build/translations/zh.js"></script-->
<script src="lib/ckfinder3/3.4.5/ckfinder.js"></script>

<script src="lib/jQuery-Tags-Input/src/jquery.tagsinput.js"></script>

<!--script src="lib/ckfinder3/3.5.1.1/ckfinder.js"></script-->
<script src="lib/cropperjs/v1.5.7/cropper.min.js"></script>
<script src="js/ultd.js?v=<?php echo $version; ?>"></script>

<script src="lib/daterangepicker/moment.min.js"></script>
<script src="lib/daterangepicker/daterangepicker.js"></script>
<link href="lib/daterangepicker/daterangepicker.css" rel="stylesheet">
<script src="js/edit.php"></script>
<script src="lib/Sortable/master/Sortable.js"></script>


<script type="text/javascript" src="lib/Buttons-1.6.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="lib/Buttons-1.6.3/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="lib/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="lib/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="lib/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="lib/Buttons-1.6.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="lib/Buttons-1.6.3/js/buttons.print.min.js"></script>
<script>
coreuiAsyncLoadConfig = {
	defaultPage: 'main.php',
	errorPage: '404.php',
	subpagesDirectory: 'views/'
}
new coreui.AsyncLoad(document.getElementById('ui-view'), coreuiAsyncLoadConfig);
//var tooltipEl = document.getElementById('header-tooltip');
//var tootltip = new coreui.Tooltip(tooltipEl);

//var myModal = new coreui.Modal(document.getElementById('myModal'), options);
const modalAry = ['loadingModal', 'successModal', 'warningModal'];

modalAry.forEach(function(value, index, array){
	window['$'+value] = new coreui.Modal(document.getElementById(value), {
		keyboard: false
		, backdrop: 'static' //true, click to close
	});

	window[value+'Close'] = ()=>{
		window['$'+value].hide();
	}

	window[value+'Open'] = (text = '')=>{
		window['$'+value].show();
	}
});

</script>
</body>
</html>
