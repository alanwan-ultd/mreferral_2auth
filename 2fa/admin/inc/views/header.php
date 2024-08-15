<?php
//$FILE_ROOT = '../../';  declare on self page


include_once($FILE_ROOT.'inc/Setting.php'); $setting = new Setting();
include_once($FILE_ROOT.'../application/plugins/Util.php'); $util = new Util();
include_once($FILE_ROOT.'inc/function.php');
include_once($FILE_ROOT.'../application/plugins/DB.php');
include_once($FILE_ROOT.'../application/plugins/dbInit.php');
include_once($FILE_ROOT.'inc/template.php');
include_once($FILE_ROOT.'models/section_array.php');
include_once($FILE_ROOT.'models/section.php');
include_once($FILE_ROOT.'../application/config/config_form.php'); // root application folder

//open/hide PLUGIN
define('PLUGIN_LOG', true);
define('PLUGIN_APPROVAL', true);

$id = $util->returnDataNum('id', 'request');
$lang = $util->purifyCheck($util->returnData('lang', 'get', 'en'));
$pid = $util->returnDataNum('pid', 'request');
$mode = $util->purifyCheck($util->returnData('mode', 'get'));
$action = $util->purifyCheck($util->returnData('action', 'request'));
$approval_id = $util->returnDataNum('approval_id', 'request');

include_once($FILE_ROOT.'inc/checking.php');  //must put after section.php

?>
