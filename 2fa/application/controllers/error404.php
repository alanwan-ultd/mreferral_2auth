<?php

class Error404 extends Controller {

	public function __construct(){
		global $config;
		$config['need_db'] = false;  //true, false
	}

	function index(){
		$this->detail();
	}

	private function detail(){
		global $config, $lang, $urlModel, $smarty;

		$smartyConfSection = 'error404';
		include('inc/common.php');
		include('inc/error.php');
	}
}

?>
