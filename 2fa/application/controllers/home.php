<?php

class Home extends Controller {

	private $cashRebateModel;

	public function __construct(){
		global $config, $util;
		$config['need_db'] = true;  //true, false

		require_once(APP_DIR .'plugins/Util.php');
        $util = new Util();
	}

	function index($para0 = '', $para1 = '', $para2 = ''){
		global $config, $lang, $urlModel, $smarty, $util;

		$smartyConfSection = '';
		require_once('inc/common.php');
		require_once('inc/error.php');
		exit('test');
	}
}

?>
