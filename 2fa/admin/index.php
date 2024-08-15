<?php
$FILE_ROOT = '';
//$name = 'index';
//$group = 'index';
include_once('inc/views/header.php');

$sectionModel = new Section('');
$sectionModelMenu = $sectionModel->getCMSMenu($_SESSION['groupId']);
include_once('inc/views/index-header.php');
include_once('inc/views/index-footer.php');
?>
