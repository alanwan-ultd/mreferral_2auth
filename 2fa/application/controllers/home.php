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

		if($para0 == 'coupon') {
			$form_type = 'coupon';
			$slug_url = $util->purifyCheck($para1);
		} else {
			$form_type = 'cash_rebate';
			$slug_url = $util->purifyCheck($para0);
		}

		$smartyConfSection = 'cash-rebate';
		include('inc/common.php');

		$smarty->configLoad('cash_rebate_'.$lang . '.conf');

		if(!$this->cashRebateModel) $this->cashRebateModel = $this->loadModel('Cash_rebate_model');
		$form_details = $this->cashRebateModel->getFormDetails($form_type, $slug_url);

		if(!$form_details) {
			// error page
			$form_type = '';
		}

		include_once(APP_DIR.'data/bank_list.php');
		$smarty->assign('form_type', $form_type);
		$smarty->assign('bank_list', $bank_list);
		$smarty->assign('form_details', $form_details);

		$smarty->assign('EXTRA_CSS',
			$this->getCSSTag('css/cash-rebate-form')
		);
		$smarty->assign('EXTRA_JS',
			$this->getJSTag('js/cash-rebate-form')
		);
		$smarty->display('cash-rebate-form.tpl');
	}
}

?>
