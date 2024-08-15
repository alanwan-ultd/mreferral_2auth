<link rel="stylesheet" href="lib/hyperform/css/hyperform.css" type="text/css" media="screen" />
<script type="text/javascript" src="lib/hyperform/js/hyperform.min.js"></script>
<script type="text/javascript" src="lib/hyperform/polyfills/classList.min.js"></script>
<script type="text/javascript" src="lib/hyperform/polyfills/weakmap.min.js"></script>
<?php if(isset($layout['ckeditor']) && $layout['ckeditor']){ ?><script type="text/javascript" src="lib/ckeditor4.5.5/ckeditor.js"></script><?php echo "\n";} ?>
<?php if(isset($layout['ckfinder']) && $layout['ckfinder']){ ?><script type="text/javascript" src="lib/ckfinder/ckfinder.js"></script><?php echo "\n";} ?>
<?php if(isset($layout['elementSorting']) && $layout['elementSorting']){ ?><script src="lib/DataTables-1.10.15/ext/Sortable/1.6.0/Sortable.js"></script><?php echo "\n";} ?>
<script src="lib/DataTables-1.10.15/ext/Sortable/1.6.0/Sortable.js"></script>
<?php if(isset($layout['datetimepicker']) && $layout['datetimepicker']){ ?><script src="lib/smalot-bootstrap-datetimepicker/2.4.4/js/bootstrap-datetimepicker.js"></script>
<link href="lib/smalot-bootstrap-datetimepicker/2.4.4/css/bootstrap-datetimepicker.css" rel="stylesheet"><?php echo "\n";} ?>
<?php if(isset($layout['datepicker']) && $layout['datepicker']){ ?><script src="lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<link href="lib/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"><?php echo "\n";} ?>
<?php if(isset($layout['daterangepicker']) && $layout['daterangepicker']){ ?>
<script src="lib/bootstrap-daterangepicker/js/moment.min.js"></script>
<script src="lib/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<link href="lib/bootstrap-daterangepicker/css/daterangepicker.css" rel="stylesheet"><?php echo "\n";} ?>
<?php if(isset($layout['timepicker']) && $layout['timepicker']){ ?><script src="lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<link href="lib/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet"><?php echo "\n";} ?>
<?php if(isset($layout['colorpicker']) && $layout['colorpicker']){ ?><script src="lib/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<link href="lib/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet"><?php echo "\n";} ?>
<?php if(isset($layout['tagsInput']) && $layout['tagsInput']){ ?><script src="lib/bootstrap-tag-input/tagsinput.js"></script>
<link href="lib/bootstrap-tag-input/tagsinput.css" rel="stylesheet"><?php echo "\n";} ?>
<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>


<?php if(isset($layout['multiTab']) && $layout['multiTab'] === true){?>
<script>



$(function(){
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        tabMulti(e.relatedTarget, 'hide');  //newly activated tab
        tabMulti(e.target, 'show');  //previous active tab

    });

});

function tabMulti(elm, action){
    $elm = $(elm);
    var href = $elm.attr('href');
    var ids = href.split(',');
    $.each(ids, function(index, value){
        if(action == 'show'){
            $($.trim(value)).show();
        }else{
            $($.trim(value)).hide();
        }
    });
}
</script>
<?php } ?>
