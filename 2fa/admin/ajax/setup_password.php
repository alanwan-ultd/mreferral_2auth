<?php
header('Content-Type: application/json');

include_once(__DIR__ . '/../inc/Setting.php');
$setting = new Setting(true);
include_once(__DIR__ . '/../inc/Util.php');
$util = new Util();
include_once(__DIR__ . '/../inc/function.php');
include_once(__DIR__ . '/../inc/DB.php');
include_once(__DIR__ . '/../inc/dbInit.php');

$token = $util->purifyCheck($util->returnData('token', 'post'));
$username = $util->purifyCheck($util->returnData('username', 'post'));
$password = $util->purifyCheck($util->returnData('password', 'post'));
$confirm_password = $util->purifyCheck($util->returnData('confirm_password', 'post'));

if ($password !== $confirm_password) {
	echo json_encode(['success' => false, 'message' => 'Password and Confirm Password do not match']);
	exit;
}

if (!checkPasswordFormat($password)) {
	echo json_encode(['success' => false, 'message' => 'Password does not meet requirements']);
	exit;
}

$data = array(
	'password' => md5($password),
	'lastModifyBy' => $username,
	'lastModifyDateTime' => date('Y-m-d H:i:s'),
	// 'password_reset_token' => null
);

$rst = $db->update($setting->DB_PREFIX . 'adminuser', $data, 'password_reset_token=:token', array(':token' => $token));

if (!empty($rst)) {
	echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
} else {
	echo json_encode(['success' => false, 'message' => 'Failed to update password']);
}

function checkPasswordFormat($password)
{
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number	= preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8  || strlen($password) > 20) {
		return false;
	}
	return true;
}
