<?php
$FILE_ROOT = '../';
$group = 'admin';
$name = 'admin';
$sectionPermissionByPass = true;
include_once('../inc/views/header.php');

if(isset($_SESSION['sales_id']) && intval($_SESSION['sales_id']) == intval($id) && $action == 'save'){
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
	$login = $util->purifyCheck($util->returnData('login', 'post'));
	$groupId = $util->purifyCheck($util->returnDataNum('group', 'post'));

	$isDuplicateLogin = $model->checkDuplicateUsername($id, $login);
	if($isDuplicateLogin) {
		echo 'Duplicate username, please change other name for login.';
		return;
	}

	if($sectionPermission[1]){  //admin insert/update
		$data = array(
			'login' => $login,
			'name' => $util->purifyCheck($util->returnData('name', 'post')),
			'email' => $util->purifyCheck($util->returnData('email', 'post')),
			'phone' => $util->purifyCheck($util->returnData('phone', 'post', 'P')),
			'description' => $util->purifyCheck($util->returnData('desc', 'post')),
			'groupId' => $groupId,
			'status' => $util->purifyCheck($util->returnData('status', 'post', 'P')),
			//'approveDateTime' => date('Y-m-d H:i:s'), 
			//'approveBy' => $_SESSION['sales_login'], 
			//'approve' => $util->purifyCheck($util->returnData('approve', 'post')),
			'lastModifyBy' => $_SESSION['sales_login'], 
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
			$data['createBy'] = $_SESSION['sales_login'];
			$data['createDateTime'] = date('Y-m-d H:i:s');
		}
		$password = $util->purifyCheck($util->returnData('password', 'post'));
		$confirm_password = $util->purifyCheck($util->returnData('confirm_password', 'post'));

		if ($password != $confirm_password) {
            echo '<p>Please make suer your passwords match.</p>';
            return;
        }

		if(trim($password) != ''){
			// $data['password'] = md5($password);  //admin can set any password

			$uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);
            
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8  || strlen($password) > 20) {
                echo '<p>Password does not meet requirements</p>';
                exit();
            }
            
            $data['password'] = md5($password);
		}else if($id == 0){  //new item without password
			echo '<p>Password cannot be empty</p>';exit();
		}
	}else{  //user hisself/herself
		$data = array(
			// 'name' => $util->purifyCheck($util->returnData('name', 'post')),
			// 'email' => $util->purifyCheck($util->returnData('email', 'post')),
			// 'phone' => $util->purifyCheck($util->returnData('phone', 'post', 'P')),
			// 'description' => $util->purifyCheck($util->returnData('desc', 'post')),
			// 'profile_pic' => $util->purifyCheck($util->returnData('profile_pic', 'post', 'P')),
			'signature_1' => $util->purifyCheck($util->returnData('signature_1', 'post', 'P')),
			'signature_2' => $util->purifyCheck($util->returnData('signature_2', 'post', 'P')),
			'signature_3' => $util->purifyCheck($util->returnData('signature_3', 'post', 'P')),
			//'approveDateTime' => date('Y-m-d H:i:s'), 
			//'approveBy' => $_SESSION['sales_login'], 
			//'approve' => $util->purifyCheck($util->returnData('approve', 'post')),
			'lastModifyBy' => $_SESSION['sales_login'], 
			'lastModifyDateTime' => date('Y-m-d H:i:s')
		);
		$password = $util->purifyCheck($util->returnData('password', 'post'));
		$confirm_password = $util->purifyCheck($util->returnData('confirm_password', 'post'));

		if ($password != $confirm_password) {
            echo '<p>Please make suer your passwords match.</p>';
            return;
        }

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
		echo 'f';
		// $rst2 = $db->select($setting->DB_PREFIX.'adminuser', 'login=:login', array(':login'=>$login));
		// if($rst2 !== false && count($rst2) >= 1){
		// 	echo 'Duplicate username, please change other name for login.';
		// }else{
		// 	echo 'f';
		// }
	}
	//echo $db->getSql();
	//var_dump($db->getBind());
}

?>