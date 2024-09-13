<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Upload CSV File</title>
	</head>

	<body>
		<h2>Upload Sales CSV File</h2>
		<form action="" method="post" enctype="multipart/form-data" onsubmit="return confirmSubmit()">
			<input type="file" name="csvFile" accept=".csv" required>
			<input type="submit" value="Upload and Process">
		</form>

		<script>
        function confirmSubmit() {
            return confirm("Warning: This action may update existing sales items. Are you sure you want to proceed?");
        }
        </script>
	</body>

	</html>
<?php
	exit;
}

// If it's a POST request, process the uploaded file
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

	$action = '';

	$data = array(
		'login' => $sales['id'],
		'password' => md5(DEFAULT_PASSWORD),
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
		$action = 'update';
		$data['id'] = $rst[0]['id'];
		$db->update($setting->DB_PREFIX . 'adminuser', $data, 'id=' . $rst[0]['id']);
	} else {
		$action = 'insert';
		$db->insert($setting->DB_PREFIX . 'adminuser', $data);
	}

	return $action;
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

		// Generate secret key
		$secret = $ga->generateSecret();

		// Generate QR code URL
		$qrCodeUrl = GoogleQrUrl::generate("Mreferral - {$sales['name']}", $secret, 'www.mreferral.com');

		// save record to database
		$action = saveQRCodeToDatabase($sales, $qrCodeUrl, $secret);

		echo "Success: {$sales['name']} ({$sales['email']}) [{$action}] <br>";
	}

	fclose($csvFile);

	echo "<br>";
	echo "All Records have been imported into the database.";
} else {
	echo "Please upload a valid CSV file.";
}
