<?php

//$name declare at xxx_save.php
/*if($action == 'approval'){  //insert/update record
	$rst = $db->select(
		$setting->DB_PREFIX.'adminuser a LEFT JOIN '.$setting->DB_PREFIX.'section_permission s ON a.groupId=s.admingroup_id',
			's.section = :section AND s.approve_ = 1 AND id != :id AND a.deleted="N" AND s.status="A" AND s.deleted="N"'
			, array(':section' => $$name, ':id' => $_SESSION['id'])
			, 'a.id AS id, a.email AS email, a.name AS name'
	);

	$email = array();
	foreach ($rst as $key => $value) {
		$email[$key]['email'] = $value['email'];
		$email[$key]['name'] = $value['name'];
	}
	$subject = 'Approval Requset form '.$_SESSION['login'].' on '.date('Y-m-d');
	//sending request email
	if(false){
		$sendEmail = $model->sendEmail($subject, $email, $section_name, $id);
	}

	//$logData = array();  //variable declare at save-common.php
	$logData['action'] = 'Submit for Approval';
}*/