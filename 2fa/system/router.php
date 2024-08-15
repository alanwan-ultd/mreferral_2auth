<?php
//pip
function router(){
	global $config, $lang, $urlModel, $smarty;

	$controller = $config['default_controller'];	//default controller: home
	$action = 'index';
	$url = '';

	require_once(APP_DIR .'helpers/url_helper.php');
	$urlModel = new Url_helper();
	$segments = $urlModel->getSegmentsAry();  //var_dump($segments);exit;
	$lang = $urlModel->getLang();
	
	// Do our default checks
	$controller = (isset($segments[0]) && $segments[0] != '') ? $segments[0] : $controller;
	$controller = str_replace('-', '_', $controller);
	$action = (isset($segments[1]) && $segments[1] != '') ? $segments[1] : $action;
	$action = str_replace('-', '_', $action);
	if ($controller == 'home' && (isset($segments[0]) && $segments[0] == 'home')) $controller = $config['error_controller'];

	// Get our controller file
	$path = APP_DIR . 'controllers/' . $controller . '.php';
	if(file_exists($path)){
		require_once($path);
	} else {
		$controller = $config['error_controller'];
		require_once(APP_DIR . 'controllers/' . $controller . '.php');
	}

	// Check the action exists
	if(!method_exists($controller, $action)){
		$action = 'index';
	}

	// Create object and call method
	//echo $controller;echo $action;var_dump($segments);exit;
	$obj = new $controller;
	if($controller != $config['default_controller']){
		$segments = array_slice($segments, 1);
	}
	if($action == 'index'){
		die(call_user_func_array(array($obj, $action), $segments));
	}else{
		if(is_callable(array($obj, $action))){
			die(call_user_func_array(array($obj, $action), array_slice($segments, 1)));
		}else{//for set private function
			$action = 'index';
			die(call_user_func_array(array($obj, $action), array_slice($segments, 1)));
		}
	}
}

?>
