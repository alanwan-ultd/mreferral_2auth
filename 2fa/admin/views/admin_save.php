<?php
require __DIR__ . '/../vendor/autoload.php';
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

$FILE_ROOT = '../';
$group = 'admin';
$name = 'admin';
$sectionPermissionByPass = true;
include_once('../inc/views/header.php');

if(isset($_SESSION['id']) && intval($_SESSION['id']) == intval($id) && $action == 'save'){
	// can pass if same user.
}elseif(!$sectionPermission[1]){
	echo 'f';exit();
}

require_once(ROOT_DIR .'../models/'. strtolower($name) .'.php');
$model = new $name;

//include_once('../inc/views/save-common.php');
if($action == 'status'){  //update status
	$data = array(
		'status' => $util->purifyCheck($util->returnData('status', 'post'))
	);
	if($id > 1){  //avoid change admin which is id = 1
		$data['id'] = $id;
	}else{
		echo 'f'; exit();
	}
	//var_dump($data);exit();
	$rst = $model->saveItemById($data, $id);
	//echo $db->getSql();
	echo ($rst)?'t':'f';
	exit();
}elseif($action == 'delete'){  //delete record
	$data = array(
		'deleted' => 'Y'
	);
	if($id > 1){  //avoid change admin which is id = 1
		$data['id'] = $id;
	}else{
		echo 'f'; exit();
	}
	//var_dump($data);exit();
	$rst = $model->saveItemById($data, $id);
	//echo $db->getSql();
	echo ($rst)?'t':'f';
	exit();
}

if($action == 'save'){  //insert/update record
	if($sectionPermission[1]){  //admin insert/update
		$login = $util->purifyCheck($util->returnData('login', 'post'));
		$data = array(
			'login' => $login,
			'name' => $util->purifyCheck($util->returnData('name', 'post')),
			'email' => $util->purifyCheck($util->returnData('email', 'post')),
			'description' => $util->purifyCheck($util->returnData('desc', 'post')),
			'groupId' => $util->purifyCheck($util->returnDataNum('group', 'post')),
			'status' => $util->purifyCheck($util->returnData('status', 'post', 'P')),
			'2fa_secret' => $util->purifyCheck($util->returnData('2fa_secret', 'post')),
			'2fa_qrcode' => $util->purifyCheck($util->returnData('2fa_qrcode', 'post')),
			//'approveDateTime' => date('Y-m-d H:i:s'), 
			//'approveBy' => $_SESSION['login'], 
			//'approve' => $util->purifyCheck($util->returnData('approve', 'post')),
			'lastModifyBy' => $_SESSION['login'], 
			'lastModifyDateTime' => date('Y-m-d H:i:s')
		);
		if($id == 1){  //admin
			unset($data['login']);
			unset($data['groupId']);
			unset($data['status']);
		}else if($id > 1){
			$data['id'] = $id;
		}else if($id == 0){  //new item
			$data['lastLoginDateTime'] = '1000-01-01 00:00:00';
			$data['createBy'] = $_SESSION['login'];
			$data['createDateTime'] = date('Y-m-d H:i:s');

			// generate 2fa secret and qrcode
			$g = new GoogleAuthenticator();
			$secret = $g->generateSecret();
			$qrCodeUrl = GoogleQrUrl::generate($setting->GOOGLE_2FA_SITE_NAME, $secret, $setting->GOOGLE_2FA_SITE_DOMAIN);

			$data['2fa_secret'] = $secret;
			$data['2fa_qrcode'] = $qrCodeUrl;
			// end of generate 2fa secret and qrcode
		}
		$password = $util->purifyCheck($util->returnData('password', 'post'));
		if(trim($password) != ''){
			$data['password'] = md5($password);
		}else if($id == 0){  //new item without password
			echo '<p>Password cannot be empty</p>';exit();
		}
	}else{  //user hisself/herself
		$data = array(
			'name' => $util->purifyCheck($util->returnData('name', 'post')),
			'description' => $util->purifyCheck($util->returnData('desc', 'post')),
			//'approveDateTime' => date('Y-m-d H:i:s'), 
			//'approveBy' => $_SESSION['login'], 
			//'approve' => $util->purifyCheck($util->returnData('approve', 'post')),
			'lastModifyBy' => $_SESSION['login'], 
			'lastModifyDateTime' => date('Y-m-d H:i:s')
		);
		$password = $util->purifyCheck($util->returnData('password', 'post'));
		if(trim($password) != ''){
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			$number	= preg_match('@[0-9]@', $password);
			$specialChars = preg_match('@[^\w]@', $password);
			
			if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8  || strlen($password) > 20) {
				echo '<p>Password does not meet requirements</p>';exit();
			}
			
			$data['password'] = md5($password);
		}
	}
	
	//var_dump($data);exit();
	if(isset($data)){
		$rst = $model->saveItemById($data, $id);
		//echo $db->getSql();
		//var_dump($db->getBind());
	}

	//echo ($rst)?'t':'f';
	if($rst){
		echo 't';
	}else{
		$rst2 = $db->select($setting->DB_PREFIX.'adminuser', 'login=:login', array(':login'=>$login));
		if($rst2 !== false && count($rst2) >= 1){
			echo 'e';
		}else{
			echo 'f';
		}
	}
	//echo $db->getSql();
	//var_dump($db->getBind());
}

?>