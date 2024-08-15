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
//log

$log = array();
$log['action'] = $action;

$log['item_pid'] = $pid;
$log['item_id'] = $id;
//var_dump($log['item_id']);
$log['section'] = $util->purifyCheck($util->returnData('section'));
$log['approval_title'] = $util->purifyCheck($util->returnData('approval_title'));
$log['createBy'] = $_SESSION['login'];
$log['createDateTime'] = date('Y-m-d H:i:s');
$log['status'] = $util->purifyCheck($util->returnData('status', 'post', 'P'));
// end of log


if($action == 'status'){  //update status
	$status =  $util->purifyCheck($util->returnData('status', 'post'));
	$data = array(
		'lastModifyBy' => $_SESSION['login']
		, 'lastModifyDateTime' => date('Y-m-d H:i:s')
		, 'approve_status' => 'P'
		, 'status' => $status
	);
	if($id == 0){
		echo 'f'; exit();
	}
	//var_dump($data);exit();
	$rst = $model->saveItemAllLangById($data, $id);
	echo ($rst)?'t':'f';
	if($rst){
		$log['action'] = 'Update Status';
		if($pid){
			$log['action'] = 'Update Content Status';
		}
		$log['approval_title'] = 'Title: ' .$log['approval_title'];
		$log_rst = $model->saveLog($log, $log['item_id']);
	}

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
	if($rst){
		$log['action'] = 'Delete';
		if($pid){
			$log['action'] = 'Delete Content';
		}
		$log['approval_title'] = 'Title: ' .$log['approval_title'];
		$log_rst = $model->saveLog($log, $log['item_id']);
	}
	exit();
}elseif($action == 'publish'){  //publish record
	$originalData = $model->getItemById($id);
	$i = 0;
	foreach($setting->LANG AS $key => $value){
		unset($originalData[$i]['id']);
		$originalData[$i]['approveBy'] = $_SESSION['login'];
		$originalData[$i]['approveDateTime'] = date('Y-m-d H:i:s');
		$originalData[$i]['approve_status'] = 'A';
		$lastInsertId = $model->saveItemById($originalData[$i], 0, $key, true);
		$lang = (isset($originalData[$i]['i18n_id']))?$originalData[$i]['i18n_id']:'';
		if($lastInsertId){
			$model->saveItemById(array(
				'approveBy'=>$_SESSION['login']
				, 'approveDateTime'=>date('Y-m-d H:i:s')
				, 'approve_id'=>$lastInsertId
				, 'approve_status' => 'A'
			), $id, $lang, false);
		}
		$i++;
	}
	echo 't';
	$log['action'] = 'Publish';
	if($pid){
		$log['action'] = 'Publish Content';
	}
	$log['approval_title'] = 'Title: ' .$log['approval_title'];
	$log_rst = $model->saveLog($log, $log['item_id']);
	exit();
}elseif($action == 'publishUpdate'){  //update record(s) publish
	$ids = $util->purifyCheck($util->returnData('ids', 'post'));
	$pid = $util->purifyCheck($util->returnData('pid', 'post'));
	$rst = $model->saveItemPublishAllLangByIds($ids);
	echo ($rst)?'t':'f';
	if($rst){
	//	$log['status'] = 'N/A';
		$log['action'] = 'Bulk publish';
		if($pid != 0){
			$log['approval_title'] = 'Id: '.$pid. ', Publish content(s) id: '.implode(", ",$ids);
		}else{
			$log['approval_title'] = 'Publish id(s): '.implode(", ",$ids);
		}
		$log_rst = $model->saveLog($log, $log['item_id']);
	}
	//echo $db->getSql();
	//var_dump($db->getBind());

	exit();
}elseif($action == 'sort'){  //reorder record(s)
	$order = $util->returnData('order', 'post');
	if(!isset($order)){
		echo 'f'; exit();
	}
	//var_dump($order);

	$ids = array();
	foreach($order AS $key => $value){
		if(is_array($value) && count($value) == 2){
			$id = intval($value[0]);
			$pos = intval($value[1]);
			array_push($ids, $id);
			$rst = $model->saveItemAllLangById(array(
				'lastModifyBy' => $_SESSION['login']
				, 'lastModifyDateTime' => date('Y-m-d H:i:s')
				, 'position'=>$pos
				, 'approve_status' => 'P'
			), $id);
		}
	}
	echo 't';
	if($rst){
		$log['status'] = 'N/A';
		$log['action'] = 'Sort';
		$ids = array_unique($ids);
		if($pid != 0){
			$log['approval_title'] = 'Id: '.$pid. ', Sorting content(s) id: '.implode(", ",$ids);
		}else{
			$log['approval_title'] = 'Sorting id(s): '.implode(", ",$ids);
		}

		$log_rst = $model->saveLog($log, $log['item_id']);
	}
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
	if($rst){
		$log['status'] = $value;
		$log['action'] = 'Bulk update status';
		if($pid != 0){
			$log['approval_title'] = 'Id: '.$pid. ', Updated content(s) id: '.implode(", ",$ids);
		}else{
			$log['approval_title'] = 'Updated id(s): '.implode(", ",$ids);
		}
		$log_rst = $model->saveLog($log, $log['item_id']);
	}

	//echo $db->getSql();
	//var_dump($db->getBind());
	exit();
}

?>
