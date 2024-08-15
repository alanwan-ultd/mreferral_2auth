<?php
// Defines
define('WWW_DIR', realpath(dirname(__FILE__)) .'/');
define('APP_DIR', WWW_DIR .'application/');
// Includes
require(APP_DIR .'config/config.php');
require(WWW_DIR .'system/model.php');
require(WWW_DIR .'system/view.php');
require(WWW_DIR .'system/controller.php');
require(WWW_DIR .'system/router.php');

// Smarty
require_once(APP_DIR . 'plugins/smarty/libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir(APP_DIR . 'views/');
$smarty->setCompileDir(APP_DIR . 'plugins/smarty/templates_c/');
$smarty->setConfigDir(APP_DIR . 'data/smartyConfigs/');
$smarty->setCacheDir(APP_DIR . 'plugins/smarty/cache/');
//$smarty->caching = 1;
//$smarty->debugging = true;

// Define base URL
global $config, $lang, $router, $urlModel, $smarty;

router();

?>
