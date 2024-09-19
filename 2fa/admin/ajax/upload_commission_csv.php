<?php
header('Content-Type: application/json');

define('SALES_GROUP_ID', 2);
define('DEFAULT_PASSWORD', 'default_password');

include_once(__DIR__ . '/../inc/Setting.php');
$setting = new Setting(true);
include_once(__DIR__ . '/../inc/Util.php');
$util = new Util();
include_once(__DIR__ . '/../inc/function.php');
include_once(__DIR__ . '/../inc/DB.php');
include_once(__DIR__ . '/../inc/dbInit.php');

// Check if a file was uploaded
if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == UPLOAD_ERR_OK) {
	$tmpName = $_FILES['csvFile']['tmp_name'];

	// Read CSV file
	$csvFile = fopen($tmpName, 'r');
	fgetcsv($csvFile); // Skip header row

	// who are upload
	$username = $util->purifyCheck($util->returnData('username', 'post'));

	// delete old record
	$table = $setting->DB_PREFIX . 'commission_origin';
	$sql = "DELETE FROM {$table};";
	$db->run($sql);

	while (($row = fgetcsv($csvFile)) !== false) {
		$data = [];
		$commissionData = [];
		$commissionData['type_code'] = $row[0];
		$commissionData['application_code'] = $row[1];
		$commissionData['mreferral_staff_name'] = $row[2];
		$commissionData['tel_no'] = $row[3];
		$commissionData['team_head'] = $row[4];
		$commissionData['team_head_phone_no'] = $row[5];
		$commissionData['payment_date'] = $row[6];
		$commissionData['staff_no'] = $row[7];
		$commissionData['staff_name'] = $row[8];
		$commissionData['staff_bank_acc'] = $row[9];
		$commissionData['comm_to_pc'] = $row[10];
		$commissionData['department_head_id'] = $row[11];
		$commissionData['department_head_name'] = $row[12];
		$commissionData['department_head_bank_account'] = $row[13];
		$commissionData['commission_branch_mgr'] = $row[14];
		$commissionData['branch'] = $row[15];

		$data['staff_no'] = $commissionData['staff_no'];
		$data['commission_data'] = json_encode($commissionData);
		$data['createBy'] = $username;
		$data['createDateTime'] = date('Y-m-d H:i:s');
		$data['lastModifyDateTime'] = date('Y-m-d H:i:s');
		$data['lastModifyBy'] = $username;

		$db->insert($table, $data);
	}

	fclose($csvFile);

	echo json_encode(['success' => true, 'message' => 'File uploaded and processed successfully.']);
} else {
	echo json_encode(['success' => false, 'message' => 'Please upload a valid CSV file.']);
}

function generateUniqueResetToken($userId)
{
	$randomBytes = random_bytes(16); // Generate 16 random bytes
	$randomString = bin2hex($randomBytes); // Convert to 32 character hex string
	$uniqueToken = $userId . '_' . $randomString; // Combine user ID with random string
	return $uniqueToken;
}
