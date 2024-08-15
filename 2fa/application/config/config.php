<?php

header("Strict-Transport-Security:max-age=63072000 includeSubdomains");
ini_set('session.cookie_secure', '1');
ini_set("session.cookie_httponly", '1');
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(-1);  //all on
//error_reporting(0);  //off
date_default_timezone_set('Asia/Hong_Kong');  //Asia/Hong_Kong, America/New_York
libxml_disable_entity_loader(true);  //Disable libxml extensions
if(
	(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	|| (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https')
	|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
){
	$ssl_suffix = 's';
}else{
	$ssl_suffix = '';
}


//USE IN DO NOT HAVE CMS
/*
//ob_start("ob_gzhandler");  //server side compress control
$config['staging'] = true;  //staging
//$config['staging'] = false;  //live

$config['base_url'] = 'http'.$ssl_suffix.'://'.$_SERVER['HTTP_HOST'].'/www/_template_front_back/2020_Version/'; // Base URL including trailing slash (e.g. http://localhost/)
$config['default_controller'] = 'home'; // Default controller to load
$config['error_controller'] = 'error404'; // Controller used for errors (e.g. 404, 500 etc)

$config['lang_default'] = $config['lang'] = 'tc';
$config['lang_arr'] = array("en"=>array("en", "ENG", "en_US"), "tc"=>array("zh-Hant", "繁體", "zh_HK"), "sc"=>array("zh-Hans", "简体", "zh_CN"));

$config['db_host'] = 'localhost'; // Database host (e.g. localhost)
$config['db_name'] = ''; // Database name
$config['db_username'] = 'root'; // Database username
$config['db_password'] = ''; // Database password
$config['db_prefix'] = '';

$config['launch'] = (isset($_GET['launch']) && $_GET['launch'] === 'true')?true:false;  //true in live
$config['minifyFolder'] = ($config['launch'])?'dist/':'';
$config['minifyFile'] = ($config['launch'])?'.min':'';

//SMTP
$config['mail_host'] = 'smtp.gmail.com';
$config['mail_secure'] = 'tls';
$config['mail_port'] = 587;  //25, 465, 587
$config['mail_auth'] = true;
$config['mail_username'] = '';
$config['mail_password'] = '';

//contact
$config['contact_from'] = '';
$config['contact_from_name'] = '';
$config['contact_to'] = '';
$config['contact_to_name'] = '';

*/
//USE IN DO NOT HAVE CMS EOL


//USE IN HAVE CMS

include_once(WWW_DIR.'admin/inc/Setting.php');
$setting = new Setting();
$config['staging'] = $setting->STAGING;  //staging
//$config['staging'] = false;  //live

//ob_start("ob_gzhandler");  //server side compress control
$config['base_url'] = 'http'.$ssl_suffix.'://'.$_SERVER['HTTP_HOST'].$setting->ROOT_DIR; // Base URL including trailing slash (e.g. http://localhost/)
$config['default_controller'] = 'home'; // Default controller to load
$config['error_controller'] = 'error404'; // Controller used for errors (e.g. 404, 500 etc)

$config['lang_default'] = $config['lang'] = 'tc';
$config['lang_arr'] = array("en"=>array("en", "ENG", "en_US"), "tc"=>array("zh-Hant", "繁體", "zh_HK"), "sc"=>array("zh-Hans", "简体", "zh_CN"));

$config['db_host'] = $setting->DB_URL; // Database host (e.g. localhost)
$config['db_name'] = $setting->DB_TABLE; // Database name
$config['db_username'] = $setting->DB_USERNAME; // Database username
$config['db_password'] = $setting->DB_PASSWORD; // Database password
$config['db_prefix'] = $setting->DB_PREFIX;

$config['launch'] = (isset($_GET['launch']) && $_GET['launch'] === 'true')?true:false;  //true in live
$config['minifyFolder'] = ($config['launch'])?'dist/':'';
$config['minifyFile'] = ($config['launch'])?'.min':'';

//SMTP
$config['mail_host'] = $setting->MAIL_HOST;
$config['mail_secure'] = $setting->MAIL_SMTP_SECURE;
$config['mail_port'] = $setting->MAIL_PORT;  //25, 465, 587
$config['mail_auth'] = $setting->MAIL_SMTP_AUTH;
$config['mail_username'] = $setting->MAIL_SMTP_USERNAME;
$config['mail_password'] = $setting->MAIL_SMTP_PWD;

//contact
$config['contact_from'] = $setting->MAIL_CONTACT_FROM['email'];
$config['contact_from_name'] = $setting->MAIL_CONTACT_FROM['name'];
$config['contact_to'] = $setting->MAIL_CONTACT_TO['email'];
$config['contact_to_name'] = $setting->MAIL_CONTACT_TO['name'];

//USE IN HAVE CMS EOL

?>
