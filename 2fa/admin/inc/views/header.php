<?php
//$FILE_ROOT = '../../';  declare on self page
include_once($FILE_ROOT.'inc/Setting.php'); $setting = new Setting(true);
include_once($FILE_ROOT.'inc/Util.php'); $util = new Util();
include_once($FILE_ROOT.'inc/function.php');
include_once($FILE_ROOT.'inc/DB.php');
include_once($FILE_ROOT.'inc/dbInit.php');
include_once($FILE_ROOT.'inc/template.php');
include_once($FILE_ROOT.'models/section.php');
include_once($FILE_ROOT.'inc/checking.php');  //must put after section.php

$id = $util->returnDataNum('id', 'request');
$lang = $util->purifyCheck($util->returnData('lang', 'get', 'en'));
$pid = $util->returnDataNum('pid', 'request');
$mode = $util->purifyCheck($util->returnData('mode', 'get'));
$action = $util->purifyCheck($util->returnData('action', 'request'));
$approval_id = $util->purifyCheck($util->returnData('approval_id', 'get'));
$version = '20';
if(
	(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ||
	(isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https') ||
	(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
){
	$ssl_suffix = 's';
}else{
	$ssl_suffix = '';
}

$base_url = 'http'.$ssl_suffix.'://'.$_SERVER['HTTP_HOST'].$setting->ROOT_DIR; // Base URL including trailing slash (e.g. http://localhost/)

?>
