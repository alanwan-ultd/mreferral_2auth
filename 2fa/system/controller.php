<?php

class Controller {

	public function getCSSTag($link)
	{
		global $config, $smarty;
		return '<link rel="stylesheet" href="'.$link.$config['minifyFile'].'.css'.$smarty->getConfigVars('ASSET_VERSION').'" type="text/css" media="screen" onload="CSSLoad()" />'.PHP_EOL;
	}

	public function getJSTag($link, $module = 'module', $min = true)
	{
		global $config, $smarty;
		return '<script'.($module?' type="'.$module.'"':'').' src="'.($min?$config['minifyFolder']:'').$link.($min?$config['minifyFile']:'').'.js'.$smarty->getConfigVars('ASSET_VERSION').'"></script>'.PHP_EOL;
	}
	
	public function loadModel($name)
	{
		require_once(APP_DIR .'models/'. strtolower($name) .'.php');

		$model = new $name;
		return $model;
	}
	
	public function loadView($name)
	{
		$view = new View($name);
		return $view;
	}
	
	public function loadPlugin($name)
	{
		require_once(APP_DIR .'plugins/'. strtolower($name) .'.php');
	}
	
	public function loadHelper($name)
	{
		require_once(APP_DIR .'helpers/'. strtolower($name) .'.php');
		$helper = new $name;
		return $helper;
	}
	
	public function redirect($loc)
	{
		global $config;
		
		header('Location: '. $config['base_url'] . $loc);
	}
    
}

?>