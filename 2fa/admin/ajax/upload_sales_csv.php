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

require_once __DIR__ . '/../vendor/autoload.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

// Function to save QR code to database
function saveQRCodeToDatabase($sales, $qrCodeUrl, $secret)
{
	global $db, $setting, $util;

	$data = array(
		'login' => $sales['id'],
		'password' => '',
		'password_reset_token' => $sales['password_reset_token'],
		'2fa_secret' => $secret,
		'2fa_qrcode' => $qrCodeUrl,
		'2fa_receive_email' => 'N',
		'name' => $util->purifyCheck($sales['name']),
		'email' => $util->purifyCheck($sales['email']),
		'description' => '',
		'groupId' => SALES_GROUP_ID,
		'lastLoginDateTime' => '1000-01-01 00:00:00',
		'noOfLogin' => 0,
		'createBy' => 'system',
		'createDateTime' => date('Y-m-d H:i:s'),
		'lastModifyBy' => 'system',
		'lastModifyDateTime' => date('Y-m-d H:i:s'),
		'status' => 'A',
		'deleted' => 'N',
	);

	// if user already exists, update the record
	$rst = $db->select($setting->DB_PREFIX . 'adminuser', 'login=:login', array(':login' => $sales['id']));

	if ($rst) {
		// do nothing when user already exists
		// $data['id'] = $rst[0]['id'];
		// $db->update($setting->DB_PREFIX . 'adminuser', $data, 'id=' . $rst[0]['id']);
	} else {
		$db->insert($setting->DB_PREFIX . 'adminuser', $data);
	}
}

// Check if a file was uploaded
if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == UPLOAD_ERR_OK) {
	$tmpName = $_FILES['csvFile']['tmp_name'];

	// Read CSV file
	$csvFile = fopen($tmpName, 'r');
	fgetcsv($csvFile); // Skip header row

	$ga = new GoogleAuthenticator();

	while (($row = fgetcsv($csvFile)) !== false) {
		$sales = [];
		$sales['id'] = $row[0];
		$sales['name'] = $row[1];
		$sales['email'] = $row[2];
		$sales['password_reset_token'] = generateUniqueResetToken($sales['id']);

		// Generate secret key
		$secret = $ga->generateSecret();

		// Generate QR code URL
		$qrCodeUrl = GoogleQrUrl::generate("Mreferral - {$sales['name']}", $secret, 'www.mreferral.com');

		// save record to database
		$action = saveQRCodeToDatabase($sales, $qrCodeUrl, $secret);
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
