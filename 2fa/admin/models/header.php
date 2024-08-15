<?php
//$FILE_ROOT = '../../';  declare on self page
include_once($FILE_ROOT.'inc/Setting.php'); if(!isset($setting)) $setting = new Setting(true);
include_once($FILE_ROOT.'inc/Util.php'); if(!isset($util)) $util = new Util();
include_once($FILE_ROOT.'inc/function.php');
include_once($FILE_ROOT.'inc/DB.php');
include_once($FILE_ROOT.'inc/dbInit.php');

$id = $util->purifyCheck($util->returnDataNum('id', 'request'));
$lang = $util->purifyCheck($util->returnData('lang', 'get', 'en'));
$pid = $util->purifyCheck($util->returnDataNum('pid', 'request'));
//$cat = $util->purifyCheck($util->returnData('cat', 'request'));
//$action = $util->purifyCheck($util->returnData('action', 'get'));
?>