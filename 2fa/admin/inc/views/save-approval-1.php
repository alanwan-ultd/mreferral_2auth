<?php
$section = $util->purifyCheck($util->returnData('section', 'post'));
$msg = $util->purifyCheck($util->returnData('msg', 'post'));
$item_id = $util->purifyCheck($util->returnData('item_id', 'post'));
$item_pid = $util->purifyCheck($util->returnData('item_pid', 'post'));
$section_name = $util->purifyCheck($util->returnData('section_name', 'post'));

if($item_pid > 0 ){
	$temp_id = $item_pid;
}else{
	$temp_id = $item_id;
}

$rst = $db->select(
	$setting->DB_PREFIX.'adminuser a LEFT JOIN '.$setting->DB_PREFIX.'section_permission s ON a.groupId=s.admingroup_id',
's.section = :section AND s.approve_ = 1 AND a.deleted="N" AND s.status="A" AND s.deleted="N"'
, array(':section' => $section)
, 'a.id AS id, a.email AS email, a.name AS name'
);

foreach ($rst as $key => $value) {
	$email[$key]['email'] = $value['email'];
	$email[$key]['name'] = $value['name'];
}

$subject = 'Approval Requset form '.$_SESSION['login'].' on '.date('Y-m-d');

//$sendEmail = $model->sendRequestEmail($subject, $email, $msg, $section, $temp_id);
//sending request email

?>
