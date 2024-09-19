<?php

$FILE_ROOT = '../';
if (!isset($needIncludeHeader) || $needIncludeHeader === true) include_once('header.php');

class Commission
{
	public function __construct() {}

	public function getListCMS($name)
	{
		global $db, $setting;

		$rst = $db->select($setting->DB_PREFIX . 'commission_origin', 'staff_no=:staff_no', array(':staff_no' => 'H2115681'), 'id, staff_no, commission_data, createDateTime');
		foreach ($rst as $key => $row) {
			$commissionData = json_decode($row['commission_data'], true);
			$rst[$key]['type_code'] = $commissionData['type_code'];
			$rst[$key]['application_code'] = $commissionData['application_code'];
			$rst[$key]['mreferral_staff_name'] = $commissionData['mreferral_staff_name'];
			$rst[$key]['tel_no'] = $commissionData['tel_no'];
			$rst[$key]['team_head'] = $commissionData['team_head'];
			$rst[$key]['team_head_phone_no'] = $commissionData['team_head_phone_no'];
			$rst[$key]['payment_date'] = $commissionData['payment_date'];
			// $dateString = preg_replace('/\.\d+/', '', $commissionData['payment_date']); // Remove fractional seconds
			// $paymentDate = new DateTime($dateString);
			// $rst[$key]['payment_date'] = $paymentDate->format('Y-m-d H:i:s');
			$rst[$key]['staff_no'] = $commissionData['staff_no'];
			$rst[$key]['staff_name'] = $commissionData['staff_name'];
			$rst[$key]['staff_bank_acc'] = $commissionData['staff_bank_acc'];
			$rst[$key]['comm_to_pc'] = $commissionData['comm_to_pc'];
			$rst[$key]['department_head_id'] = $commissionData['department_head_id'];
			$rst[$key]['department_head_name'] = $commissionData['department_head_name'];
			$rst[$key]['department_head_bank_account'] = $commissionData['department_head_bank_account'];
			$rst[$key]['commission_branch_mgr'] = $commissionData['commission_branch_mgr'];
			$rst[$key]['branch'] = $commissionData['branch'];
			$rst[$key]['action'] = renderListActionBtn($name . '_edit', $row['id']);
		}

		return $rst;
	}

	public function getOriginItemById($id)
	{
		global $db, $setting;

		$rst = $db->select($setting->DB_PREFIX . 'commission_origin', 'id=:id LIMIT 1', array(':id' => $id), 'id, staff_no, commission_data, createDateTime');

		if (empty($rst)) {
			return null;
		}

		foreach ($rst as $key => $row) {
			$rst[$key]['commission_data'] = json_decode($row['commission_data'], true);
		}

		return $rst;
	}
}
