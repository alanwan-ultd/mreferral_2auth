<?php
//checking
switch($action){
	case 'status': 
	case 'statusUpdate': if($sectionPermission[1] != 1 && $sectionPermission[2] != 1) $action = ''; break;
	
	case 'delete': 
	case 'save': 
	case 'sort': if($sectionPermission[1] != 1) $action = ''; break;

	case 'publish': 
	case 'publishUpdate': if($sectionPermission[2] != 1) $action = ''; break;
	
	case 'approval': 
	case 'approvalUpdate': if($sectionPermission[1] != 1) $action = ''; break;
}
$logData = array();
$logData['approval_title'] = $util->purifyCheck($util->returnData('approval_title', 'post')); //will be overwrite if need at below

if($action == 'delete'){  //delete record
	$data = array(
		'lastModifyBy' => $_SESSION['sales_login'],
		'lastModifyDateTime' => date('Y-m-d H:i:s'),
		'deleted' => 'Y',
	);
	if($id != 0){
		//$data['id'] = $id;
	}else{
		echo 'f'; exit();
	}
	$rst = $model->deleteItemAllLangById($data, $id);
	//echo $db->getSql();

	echo ($rst)?'t':'f';
	if($rst){
		$logData['status'] = 'N/A';
		$logData['action'] = 'Delete';
		if($pid){
			$logData['action'] = 'Delete Content';
		}
		$logData['approval_title'] = 'Title: ' .$logData['approval_title'];
	}
}elseif($action == 'publish'){  //publish record
	$originalData = $model->getItemById($id);
	$i = 0;
	$rst = array();
	foreach($setting->LANG AS $key => $value){
		unset($originalData[$i]['id']);
		$originalData[$i]['approveBy'] = $_SESSION['sales_login'];
		$originalData[$i]['approveDateTime'] = date('Y-m-d H:i:s');
		$originalData[$i]['approve_status'] = 'A';
		$lastInsertId = $model->saveItemById($originalData[$i], 0, $key, true);
		$lang = (isset($originalData[$i]['i18n_id']))?$originalData[$i]['i18n_id']:'';
		if($lastInsertId){
			$rst[$i] = $model->saveItemById(array(
				'approveBy' => $_SESSION['sales_login'],
				'approveDateTime' => date('Y-m-d H:i:s'),
				'approve_id' => $lastInsertId,
				'approve_status' => 'A',
			), $id, $lang, false);
		}
		$i++;
	}
	echo (array_search(false, $rst) !== false)?'f':'t';
	
	if($approval_id !== 0){  //publish at "submit for approval" section
		$modelSubmitapproval->saveApprovalItemById(array(
			'lastModifyBy' => $_SESSION['sales_login'], 
			'lastModifyDateTime' => date('Y-m-d H:i:s'), 
			'status' => 'A', 
		), $approval_id, false);//only statsu P item will be updated
	}

	if(!array_search(false, $rst) !== false){
		$logData['status'] = $originalData[0]['status'];
		$logData['action'] = 'Publish';
		if($pid){
			$logData['action'] = 'Publish Content';
		}
		$logData['approval_title'] = 'Title: ' .$logData['approval_title'];
	}
}elseif($action == 'publishUpdate'){  //update record(s) publish
	$ids = $util->purifyCheck($util->returnData('ids', 'post'));
	$rst = $model->saveItemPublishAllLangByIds($ids);
	//echo $db->getSql();
	//var_dump($db->getBind());

	echo ($rst)?'t':'f';
	if($rst){
		$logData['status'] = 'N/A';
		$logData['action'] = 'Bulk publish';
		if($pid){
			$logData['approval_title'] = 'Id: '.$pid. ', Publish content(s) id: '.implode(", ", $ids);
		}else{
			$logData['approval_title'] = 'Publish id(s): '.implode(", ", $ids);
		}
	}
}elseif($action == 'sort'){  //reorder record(s)
	$order = $util->returnData('order', 'post');
	if(!isset($order)){
		echo 'f'; exit();
	}
	$i = 0;
	$rst = array();
	$ids = array();
	foreach($order AS $key => $value){
		if(is_array($value) && count($value) == 2){
			$id = intval($value[0]);
			$pos = intval($value[1]);
			array_push($ids, $id);
			$rst[$i] = $model->saveItemAllLangById(array(
				'lastModifyBy' => $_SESSION['sales_login'],
				'lastModifyDateTime' => date('Y-m-d H:i:s'),
				'position'=>$pos,
				'approve_status' => 'P',
			), $id);
			//echo $db->getSql();
			$i++;
		}
	}
	echo (array_search(false, $rst) !== false)?'f':'t';

	if(!array_search(false, $rst) !== false){
		$logData['status'] = 'N/A';
		$logData['action'] = 'Sort';
		$ids = array_unique($ids);
		if($pid){
			$logData['approval_title'] = 'Id: '.$pid. ', Sorting content(s) id: '.implode(", ", $ids);
		}else{
			$logData['approval_title'] = 'Sorting id(s): '.implode(", ", $ids);
		}
	}
}elseif($action == 'status'){  //update status
	$status =  $util->purifyCheck($util->returnData('status', 'post'));
	$data = array(
		'lastModifyBy' => $_SESSION['sales_login'],
		'lastModifyDateTime' => date('Y-m-d H:i:s'),
		'approve_status' => 'P',
		'status' => $status,
	);
	//var_dump($data);exit();
	if($id == 0){
		echo 'f'; exit();
	}
	$rst = $model->saveItemAllLangById($data, $id);
	//echo $db->getSql();

	echo ($rst)?'t':'f';
	if($rst){
		$logData['status'] = $status;
		$logData['action'] = 'Update Status';
		if($pid){
			$logData['action'] = 'Update Content Status';
		}
		$logData['approval_title'] = 'Title: ' .$logData['approval_title'];
	}
}elseif($action == 'statusUpdate'){  //update record(s) status
	$ids = $util->purifyCheck($util->returnData('ids', 'post'));
	$value = $util->purifyCheck($util->returnData('value', 'post'));
	switch($value){
		case 'A': break;
		case 'P': break;
		default: echo 'f'; exit();
	}

	$rst = $model->saveItemStatusAllLangByIds(array(
		'lastModifyBy' => $_SESSION['sales_login'],
		'lastModifyDateTime' => date('Y-m-d H:i:s'),
		'approve_status' => 'P',
		'status'=>$value,
	), $ids);
	//echo $db->getSql();
	//var_dump($db->getBind());

	echo ($rst)?'t':'f';
	if($rst){
		$logData['status'] = $value;
		$logData['action'] = 'Bulk update status';
		if($pid){
			$logData['approval_title'] = 'Id: '.$pid. ', Updated content(s) id: '.implode(", ",$ids);
		}else{
			$logData['approval_title'] = 'Updated id(s): '.implode(", ",$ids);
		}
	}
}elseif($action == 'approval'){  //insert record
	$section_name = $util->purifyCheck($util->returnData('section_name'));
	$status = $util->purifyCheck($util->returnData('status', 'post'));

	//save
	$data = array();
	foreach($modelSubmitapproval->getFields() AS $item){
		$data[$item] = $util->purifyCheck($util->returnData($item));
	}
	$data['gid'] = intval($_SESSION['sales_groupId']);
	$data['uid'] = intval($_SESSION['sales_id']);
	$data['item_id'] = intval($id);
	$data['item_pid'] = intval($pid);
	$data['section'] = $name;
	$data['status'] = 'P';
	$data['createBy'] = $data['lastModifyBy'] = $_SESSION['sales_login'];
	$data['createDateTime'] = 	$data['lastModifyDateTime'] = date('Y-m-d H:i:s');
	$rst = $modelSubmitapproval->saveApprovalItemById($data, 0, true);

	echo ($rst)?'t':'f';

	//send email
	$rst = $db->select(
		$setting->DB_PREFIX.'adminuser a LEFT JOIN '.$setting->DB_PREFIX.'section_permission s ON a.groupId=s.admingroup_id',
			's.section = :section AND s.approve_ = 1 AND id != :id AND a.deleted="N" AND s.status="A" AND s.deleted="N"'
			, array(':section' => $name, ':id' => $_SESSION['sales_id'])
			, 'a.id AS id, a.email AS email, a.name AS name'
	);

	$email = array();
	foreach ($rst as $key => $value) {
		$email[$key]['email'] = $value['email'];
		$email[$key]['name'] = $value['name'];
	}
	$subject = 'Approval Requset form '.$_SESSION['sales_login'].' on '.date('Y-m-d');
	//send request email
	if(false){
		$sendEmail = $modelSubmitapproval->sendEmail($subject, $email, $section_name, $id);
	}

	//log
	$logData['status'] = $status;
	$logData['action'] = 'Submit for Approval';
}elseif($action == 'approvalUpdate'){  //insert record
	$ids = $util->purifyCheck($util->returnData('ids', 'post'));
	$section_name = $util->purifyCheck($util->returnData('section_name'));
	$approval_titles = $util->purifyCheck($util->returnData('approval_titles', 'post'));

	//save
	$data = array();
	/*foreach($modelSubmitapproval->getFields() AS $item){
		$data[$item] = $util->purifyCheck($util->returnData($item));
	}*/
	$data['gid'] = intval($_SESSION['sales_groupId']);
	$data['uid'] = intval($_SESSION['sales_id']);
	//$data['item_id'] = intval($id);  //will insert in submitApprovalItemByIds function
	$data['item_pid'] = intval($pid);
	$data['section'] = $name;
	$data['section_name'] = $section_name;
	$data['status'] = 'P';
	$data['createBy'] = $data['lastModifyBy'] = $_SESSION['sales_login'];
	$data['createDateTime'] = 	$data['lastModifyDateTime'] = date('Y-m-d H:i:s');
	$rst = $modelSubmitapproval->submitApprovalItemByIds($data, $ids, $approval_titles);

	echo ($rst)?'t':'f';

	//send email
	$rst = $db->select(
		$setting->DB_PREFIX.'adminuser a LEFT JOIN '.$setting->DB_PREFIX.'section_permission s ON a.groupId=s.admingroup_id',
			's.section = :section AND s.approve_ = 1 AND id != :id AND a.deleted="N" AND s.status="A" AND s.deleted="N"'
			, array(':section' => $name, ':id' => $_SESSION['sales_id'])
			, 'a.id AS id, a.email AS email, a.name AS name'
	);

	$email = array();
	foreach ($rst as $key => $value) {
		$email[$key]['email'] = $value['email'];
		$email[$key]['name'] = $value['name'];
	}
	$subject = 'Approval Requset form '.$_SESSION['sales_login'].' on '.date('Y-m-d');
	//send request email
	if(false){
		$sendEmail = $modelSubmitapproval->sendEmail($subject, $email, $section_name, $ids);
	}

	//log
	$logData['status'] = 'N/A';
	$logData['action'] = 'Bulk Submit for Approval';
	if($pid){
		$logData['approval_title'] = 'Id: '.$pid. ', Approval content(s) id: '.implode(", ", $ids);
	}else{
		$logData['approval_title'] = 'Approval items id(s): '.implode(", ", $ids);
	}
}

?>
