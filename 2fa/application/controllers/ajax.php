<?php

// include form status
require_once(APP_DIR .'config/config_form.php');
require_once(APP_DIR .'plugins/Util.php');
require_once(APP_DIR .'../admin/inc/email.php');

// TODO need to fix use admin/inc/email
// require_once(APP_DIR .'controllers/inc/email.php');


class Ajax extends Controller {

	private $cashRebateModel;

	public function __construct(){
		global $config, $util;
		$config['need_db'] = true;  //true, false

		if (!$this->cashRebateModel) {
            $this->cashRebateModel = $this->loadModel('Cash_rebate_model');
        }

		$this->email = new Email();
	}

	public function submitCashRebateForm() {
		global $config;
		
        $util = new Util();
		
		$slug_url = $util->returnData('slug_url', 'post');
		$type = $util->returnData('type', 'post');
		$rst = $this->cashRebateModel->getFormDetails($type, $slug_url);

		// item not found
		if(!$rst) {
			echo $util->renderResultJSON('form not found', 'from_not_found', 'f'); return;
		}

		if($rst['status'] != 'P') {
			echo $util->renderResultJSON('form not ready', 'from_not_ready', 'f'); return;
		}
		
		$caseData = $rst;
		$form_fields = $this->needSubmitDataFields($caseData['type']);
		
		// [Type: cash_rebate] need speical approval and send email to customer if drawdown date after submission date; else normal flow
		$needSpecialApproval = $this->needSpecialApproval($caseData['type'], $caseData['drawdown_date']);

		if($needSpecialApproval) {
			// send email
			$this->sendEmailToSales($rst);

			// create special case approval table
			$special_approval_id = $this->cashRebateModel->createSpecialAppprovalTable($caseData['case_no']);
		}

		// ---------------------------------- esignature (Image) ----------------------------------
		// $post_esignature = $_FILES['esignature'];
		// $file_size = round($post_esignature['size'] / (1024 * 1024), 2);

		// if($file_size == 0) {
        //     echo $util->renderResultJSON('Invalid file', 'no_file_upload', 'f'); return;
        // } else if($file_size > UPLOAD_FILE_SIZE_LIMIT) {
        //     echo $util->renderResultJSON('large than file size limit', 'file_size_limit', 'f'); return;
        // }

		//  // move temp file to target folder
		//  if (!file_exists(UPLOAD_DIR)) {
        //     mkdir(UPLOAD_DIR, 0777, true);
        // }

		// $document_prefix = date('Ymd_His').'_'.rand(1,999).'_';
        // $file_name = preg_replace('/\s+/', '_', $post_esignature['name']); // convert space to _
        // $file_name = preg_replace("/[^\\p{L} 0-9\.\-\_]/mu", '', $file_name); // trim special characters
        // $document_location = UPLOAD_DIR . $document_prefix . $file_name;

		// $temp_name = $post_esignature['tmp_name'];
		// $image_info = getimagesize($temp_name);
		// if (($image_info[2] !== IMAGETYPE_JPEG) && 
		// 	($image_info[2] !== IMAGETYPE_PNG)) {
		// 		echo $util->renderResultJSON('Invalid file format', 'file_format', 'f'); return;
		// }

        // if(!move_uploaded_file($temp_name, $document_location)){
        //     echo $util->renderResultJSON('cannot move tmp to target folder', 'move_file_error', 'f'); return;
        // }
		// ---------------------------------- end of esignature (Image) ----------------------------------

        foreach ($form_fields as $field) {
            ${'post_'.$field} = $util->returnData($field, 'post');
        }

		foreach ($form_fields as $field) {
            $field_item = $util->purifyCheck(${'post_'.$field});
            $caseData[$field] = ($field_item) ? $field_item : NULL; // if no value, put 'N.A.' into email
        }

		// validation
		if($caseData['type'] == 'cash_rebate') {
			if(!$caseData['bank_name']) {
				echo $util->renderResultJSON('Invalid bank name', 'invalid_bank_name', 'f'); return;
			}
	
			// to prevent frontend cannot get bank_code when bank_name on change
			if($caseData['bank_code'] == '' && $caseData['bank_name']) {
				$caseData['bank_code'] = $caseData['bank_name'];
			}
		}

		// ---------------------------------- esignature ----------------------------------
		// move temp file to target folder
		if (!file_exists(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0777, true);
        }

		$document_prefix = date('Ymd_His').'_'.rand(1,999).'_';
        $signature_location = UPLOAD_DIR . $document_prefix . 'signature.png';

		$data_uri = $caseData['esignature'];
		$encoded_image = explode(",", $data_uri)[1];
		$decoded_image = base64_decode($encoded_image);
		$signature_create_success = file_put_contents($signature_location, $decoded_image);

		if(!$signature_create_success) {
			echo $util->renderResultJSON('Invalid file', 'no_file_upload', 'f'); return;
		}
		// ---------------------------------- end of esignature ----------------------------------

		$caseData['is_special_approval'] = ($needSpecialApproval) ? 1 : 0;
		$caseData['special_approval_id'] = ($needSpecialApproval) ? $special_approval_id : NULL;
		$caseData['esignature'] = $signature_location;
		$caseData['status'] = ($needSpecialApproval) ? STATUS_SPECIAL_APPROVAL_SUBMITTED : STATUS_SUBMITTED;
		$caseData['version'] = $caseData['version'];
		$caseData['last_updated_at'] = date('Y-m-d H:i:s');
		$caseData['last_updated_by'] = CLIENT_ID;
		$caseData['submission_at'] = date('Y-m-d H:i:s');

		// remove id
		array_shift($caseData);

		$success_update = $this->cashRebateModel->submitForm($caseData);
		// assign id for log
		$caseData['id'] = $success_update;
		$success_update_log = $this->cashRebateModel->submitLog($caseData);

        if (!$success_update || !$success_update_log) {
            $data['result'] = 'f';
            $data['message'] = 'cannot insert db';
        } else {
			$data['result'] = 't';
			$data['message'] = 'send success!';
		}

		return json_encode($data);
	}

	private function needSubmitDataFields($form_type) {	
		$form_fields = [];	

		if($form_type == 'coupon') {
			$form_fields = [
				'hkid',
				'referee_name',
				'referee_contact_no',
				'referrer_name',
				'referrer_contact_no',
				'collect_coupon_method',
				'collect_coupon_address',
				'collect_coupon_email',
				'esignature'
			];
		} else if($form_type == 'cash_rebate') {
			$form_fields = [
				'hkid',
				'client_name',
				'client_contact_no',
				// 'mortgage_address',
				// 'cash_rebate_amount',
				// 'cash_rebate_reason',
				'remarks',
				'bank_name',
				'bank_code',
				'branch_code',
				'account_code',
				'esignature'
			];
		}

		return $form_fields;
	}

	private function needSpecialApproval($form_type, $drawdown_date) {
		// is today greater than drawdown date
		// return ($form_type === 'cash_rebate' && (date("Y-m-d H:i:s") > $drawdown_date)) ? true : false;

		// is today greater than drawdown date or same month also count dont need special approval
		$drawdown_year_month = date("Y-m", strtotime($drawdown_date));
		return ($form_type === 'cash_rebate' && (date("Y-m") > $drawdown_year_month)) ? true : false;
	}

	private function sendEmailToSales($data) {
		global $email;
		
		//  Send email to sales
		$template = $this->email->specialApprovalSalesTemplate($data);
		$emailSubject = $template['subject'];
		$emailBody = $template['body'];

		$emailList[0]['name'] = $data['sales_name'];
		$emailList[0]['email'] = $data['sales_email'];

		$email_result = $this->email->send($emailSubject, $emailBody, $emailList);

		if($email_result['result'] === 'f') {
			
		}
	}
}

?>
