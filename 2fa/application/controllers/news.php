<?php

class News extends Controller {

	private $newsModel;

	public function __construct(){
		global $config;
		$config['need_db'] = false;  //true, false
	}

	function index($para0 = '', $para1 = '', $para2 = ''){
		global $config, $lang, $urlModel, $smarty;
		
		$smartyConfSection = 'news';
		include('inc/common.php');
		if(!$this->newsModel) $this->newsModel = $this->loadModel('News_model');

		$smarty->assign('EXTRA_CSS',
			$this->getCSSTag('css/news')
		);
		$smarty->assign('EXTRA_JS',
			$this->getJSTag('js/news')
		);
		$smarty->display('news.tpl');
	}
}

?>
