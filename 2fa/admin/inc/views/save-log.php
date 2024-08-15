<?php

//log part one
//$logData = array();  //variable declare at save-common.php
$logData['action'] = ( isset($logData['action']) )?$logData['action']:$action;
$logData['item_pid'] = ( isset($logData['item_pid']) )?intval($logData['item_pid']):intval($pid);
$logData['item_id'] = ( isset($logData['item_id']) )?intval($logData['item_id']):intval($id);
$logData['section_name'] = $util->purifyCheck($util->returnData('section_name'));
//$logData['approval_title'];  //variable declare at save-common.php
$logData['uid'] = intval($_SESSION['sales_id']);
$logData['createBy'] = $_SESSION['sales_login'];
$logData['createDateTime'] = date('Y-m-d H:i:s');

if(PLUGIN_APPROVAL){
	//var_dump($logData);exit;
	$log_rst = $model->saveLog($logData, $logData['item_id']);
}

?>