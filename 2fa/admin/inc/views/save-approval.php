<?php
//checking
switch($action){
	case 'status': if($sectionPermission[1] != 1 && $sectionPermission[2] != 1) $action = ''; break;
	case 'delete': if($sectionPermission[1] != 1) $action = ''; break;
	case 'publish': if($sectionPermission[2] != 1) $action = ''; break;
	case 'publishUpdate': if($sectionPermission[2] != 1) $action = ''; break;
	case 'sort': if($sectionPermission[1] != 1) $action = ''; break;
	case 'statusUpdate': if($sectionPermission[1] != 1) $action = ''; break;
	case 'save': if($sectionPermission[1] != 1) $action = ''; break;
	case 'approval': if($sectionPermission[1] != 1 && $sectionPermission[2] == 1) $action = ''; break;

}

if($action == 'status'){  //update status
	$data = array(
		'lastModifyBy' => $_SESSION['login']
		, 'lastModifyDateTime' => date('Y-m-d H:i:s')
		, 'approve_status' => 'P'
		, 'status' => $util->purifyCheck($util->returnData('status', 'post'))
	);
	if($id == 0){
		echo 'f'; exit();
	}
	//var_dump($data);exit();
	$rst = $model->saveItemAllLangById($data, $id);
	echo ($rst)?'t':'f';

	//echo $db->getSql();
	exit();
}elseif($action == 'delete'){  //delete record
	$data = array(
		'lastModifyBy' => $_SESSION['login']
		, 'lastModifyDateTime' => date('Y-m-d H:i:s')
		, 'deleted' => 'Y'
	);
	if($id != 0){
		//$data['id'] = $id;
	}else{
		echo 'f'; exit();
	}
	//$rst = $model->saveItemAllLangById($data, $id);
	$rst = $model->deleteItemAllLangById($data, $id);

	//echo $db->getSql();
	echo ($rst)?'t':'f';
	exit();
}elseif($action == 'publish'){  //publish record
	$originalData = $model->getItemById($id);
	$i = 0;
	foreach($setting->LANG AS $key => $value){
		unset($originalData[$i]['id']);
		$originalData[$i]['approveBy'] = $_SESSION['login'];
		$originalData[$i]['approveDateTime'] = date('Y-m-d H:i:s');
		$originalData[$i]['approve_status'] = 'A';
	//	$lastInsertId = $model->saveApprovalItemById($originalData[$i], 0, $key, true);
		$lang = (isset($originalData[$i]['i18n_id']))?$originalData[$i]['i18n_id']:'';
	//	if($lastInsertId){
			$model->saveApprovalItemById(array(
				'approveBy'=>$_SESSION['login']
				, 'approveDateTime'=>date('Y-m-d H:i:s')
	//		, 'approve_id'=>$lastInsertId
				, 'approve_status' => 'A'
			), $id, $lang, false);
	//	}
		$i++;
	}
	echo 't'; exit();
}elseif($action == 'publishUpdate'){  //update record(s) publish
	$ids = $util->purifyCheck($util->returnData('ids', 'post'));
	$rst = $model->saveItemPublishAllLangByIds($ids);
	echo ($rst)?'t':'f';
	//echo $db->getSql();
	//var_dump($db->getBind());
	exit();
}elseif($action == 'submitAllItems'){
	  //submit all approval items
		$items = array();
		$data1 = array();

		$data1['ids'] = $util->purifyCheck($util->returnData('ids', 'post'));
		$data1['pid'] = $util->purifyCheck($util->returnData('pid', 'post'));
		$data1['section'] = $util->purifyCheck($util->returnData('section', 'post'));
		$items = $model->submitApprovalAllLangByIds($data1);
	//	var_dump($items); exit();
		foreach ($items as $key => $value) {
			$rst = array();
			foreach($setting->LANG AS $key => $value2){
			$data = array();
			$data['gid'] = $_SESSION['groupId'];
			$data['uid'] = $_SESSION['id'];
			$data['section'] = $value['section'];
			$data['item_id'] = $value['id'];
			$data['item_pid'] = $value['pid'];
			$data['approval_title'] = $value['title'];
			$data['status'] = $util->purifyCheck($util->returnData('status', 'post', 'P'));
			$data['approve_status'] = 'P';
			$data['lastModifyBy'] = $_SESSION['login'];
			$data['lastModifyDateTime'] = date('Y-m-d H:i:s');
			$data['createBy'] = $_SESSION['login'];
			$data['createDateTime'] = date('Y-m-d H:i:s');
			$position = $data['position'] = $model->getItemMaxPos()+1;
			$rst[0] = $model->saveItemById($data, 0, $key, true);
			$data = array('mapping_id' => $rst[0]);
			$data['version_id'] = $rst[0];
			$model->saveItemById($data, $rst[0], '', false);
		}

	}

	if($data1['pid'] > 0 ){
		$temp_id = $data1['pid'];
	}else{
		$temp_id = implode(' ,', $data1['ids']);
	}

	$rst = $db->select(
		$setting->DB_PREFIX.'adminuser a LEFT JOIN '.$setting->DB_PREFIX.'section_permission s ON a.groupId=s.admingroup_id',
	's.section = :section AND s.approve_ = 1 AND a.deleted="N" AND s.status="A" AND s.deleted="N"'
	, array(':section' => $data1['section'])
	, 'a.id AS id, a.email AS email, a.name AS name'
	);

	foreach ($rst as $key => $value) {
		$email[$key]['email'] = $value['email'];
		$email[$key]['name'] = $value['name'];
	}
	$subject = 'Approval Requset form '.$_SESSION['login'].' on '.date('Y-m-d');

//	$sendEmail = $model->sendRequestEmail($subject, $email, '', $data1['section'], $temp_id);

	echo ($rst)?'t':'f';
	//echo $db->getSql();
	//var_dump($db->getBind());
	exit();

}elseif($action == 'sort'){  //reorder record(s)
	$order = $util->returnData('order', 'post');
	if(!isset($order)){
		echo 'f'; exit();
	}
	foreach($order AS $key => $value){
		if(is_array($value) && count($value) == 2){
			$id = intval($value[0]);
			$pos = intval($value[1]);
			$rst = $model->saveItemAllLangById(array(
				'lastModifyBy' => $_SESSION['login']
				, 'lastModifyDateTime' => date('Y-m-d H:i:s')
				, 'position'=>$pos
				, 'approve_status' => 'P'
			), $id);
		}
	}
	echo 't';
	//echo $db->getSql();
	exit();
}elseif($action == 'statusUpdate'){  //update record(s) status
	$ids = $util->purifyCheck($util->returnData('ids', 'post'));
	$value = $util->purifyCheck($util->returnData('value', 'post'));
	switch($value){
		case 'A': break;
		case 'P': break;
		default: echo 'f'; exit();
	}

	$rst = $model->saveItemStatusAllLangByIds(array(
		'lastModifyBy' => $_SESSION['login']
		, 'lastModifyDateTime' => date('Y-m-d H:i:s')
		, 'approve_status' => 'P'
		, 'status'=>$value
	), $ids);
	echo ($rst)?'t':'f';
	//echo $db->getSql();
	//var_dump($db->getBind());
	exit();
}

?>
