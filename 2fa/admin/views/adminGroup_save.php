<?php
$FILE_ROOT = '../';
$group = 'admin';
$name = 'adminGroup';
include_once('../inc/views/header.php');

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
	$data = array(
		'title' => $util->purifyCheck($util->returnData('title', 'post')),
		'description' => $util->purifyCheck($util->returnData('description', 'post')),
		'status' => $util->purifyCheck($util->returnData('status', 'post', 'P')),
		//'approveDateTime' => date('Y-m-d H:i:s'), 
		//'approveBy' => $_SESSION['login'], 
		//'approve' => $util->purifyCheck($util->returnData('approve', 'post')),
		//'lastModifyBy' => $_SESSION['login'], 
		'lastModifyDateTime' => date('Y-m-d H:i:s')
	);
	if($id == 1){  //admin
		unset($data['title']);
		unset($data['status']);
	}else if($id > 1){
		$data['id'] = $id;
	}else if($id == 0){  //new item
		$data['createBy'] = $_SESSION['login'];
		$data['createDateTime'] = date('Y-m-d H:i:s');
	}
	$password = $util->purifyCheck($util->returnData('password', 'post'));
	if(trim($password) != ''){
		$data['password'] = md5($password);
	}
	
	//var_dump($data);exit();
	$rst = $model->saveItemById($data, $id);
	if($id == 0){  //new
		$id = $rst;
	}
	//echo ($rst)?'t':'f';
	//echo $db->getSql();
	//var_dump($db->getBind());
	
	$sectionModel = new Section('');
	$sectionModelList = $sectionModel->getCMSSection(); //var_dump($sectionModelList); exit;
	$sectionModelListCMS = $sectionModel->getPermissionByGroupId($id); //var_dump($sectionModelListCMS);exit;

	$r = $util->purifyCheck($util->returnData('r', 'post', array()));  //var_dump($r);
	$w = $util->purifyCheck($util->returnData('w', 'post', array()));  //var_dump($w);
	$a = $util->purifyCheck($util->returnData('a', 'post', array()));  //var_dump($a);
	
	foreach($sectionModelList AS $key => $value){
		if(!empty($value[0]) && !empty($value[1])){
			$data2 = array(
				'section'=>$value[0]
				, 'admingroup_id'=>$id
				, 'read_'=>(array_search($value[0], $r) !== false || $id == 1)?'1':'0'
				, 'write_'=>(array_search($value[0], $w) !== false || $id == 1)?'1':'0'
				, 'approve_'=>(array_search($value[0], $a) !== false || $id == 1)?'1':'0'
				, 'createBy'=>$_SESSION['login']
				, 'createDateTime'=>date('Y-m-d H:i:s')
				, 'lastModifyDateTime'=>date('Y-m-d H:i:s')
				, 'lastModifyBy'=>''
				, 'status'=>'A'
				, 'deleted'=>'N'
			);  //var_dump($data2);
			$rst = $model->savePermissionBygId($data2, $id);
			//var_dump($data2);
			//echo $db->getSql();
			//var_dump($db->getBind());
		}
	}
	
	echo 't';
}



?>