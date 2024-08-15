<?php

		$data = array();
		foreach($model->getFields() AS $item){
			if(strpos($item, '_i18n') > 0){
				$data[$item] = $util->purifyCheck($util->returnData(str_replace('_i18n', '_'.$key, $item)));
			}else{
				if($item == 'pid'){
					$data[$item] = $util->returnDataNum($item);
				}else{
					$data[$item] = $util->purifyCheck($util->returnData($item));
				}
			}
		}
		$data['status'] = $util->purifyCheck($util->returnData('status', 'post', 'P'));
		$data['approve_status'] = 'P';
		$data['lastModifyBy'] = $_SESSION['sales_login'];
		$data['lastModifyDateTime'] = date('Y-m-d H:i:s');
?>
