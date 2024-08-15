<?php
		if($id == 0){  //new item
			$data['createBy'] = $_SESSION['sales_login'];
			$data['createDateTime'] = date('Y-m-d H:i:s');
			//var_dump($data);//exit();
			if($i == 0){
				$position = $data['position'] = $model->getItemMaxPos()+1;
				$rst[$i] = $model->saveItemById($data, 0, $key, true);
				//echo $db->getSql();
				$data = array('mapping_id' => $rst[0]);
				$data['version_id'] = $rst[0];
				$model->saveItemById($data, $rst[0], '', false);
			}else{
				$data['position'] = $position;
				$data['mapping_id'] = $rst[0];
				$rst[$i] = $model->saveItemById($data, $rst[0], $key);
				$data = array('version_id' => $rst[$i]);
				$model->saveItemById($data, $rst[$i], '', false);
			}

			$logData['status'] = $util->purifyCheck($util->returnData('status', 'post', 'P'));;
			$logData['item_id'] = $rst[0];
			$logData['action'] = 'Create New Item';
			if($pid){
				$logData['action'] = 'Create New Content';
			}
		}else{  //existing item
			if($model->getItemByMapLang($id, $key)){  //item exist
				$rst[$i] = $model->saveItemById($data, $id, $key, false);
				//var_dump($data);var_dump($db->getSql());//exit();
				unset($originalData[$i]['id']);
				$model->saveItemById($originalData[$i], 0, $key, true);//copy/duplicate old record
			}else{  //item of that language not exist
				$data['position'] = $originalData[0]['position'];
				$data['mapping_id'] = $id;
				$data['status'] = $originalData[0]['status'];
				$data['createBy'] = $_SESSION['sales_login'];
				$data['createDateTime'] = date('Y-m-d H:i:s');
				//var_dump($data);exit();
				$rst[$i] = $model->saveItemById($data, $id, $key, true);
				$data = array('version_id' => $rst[$i]);
				$model->saveItemById($data, $rst[$i], '', false);
			}

			$logData['status'] = $util->purifyCheck($util->returnData('status', 'post', 'P'));;
			$logData['action'] = 'Save';
			if($pid){
				$logData['action'] = 'Save Content';
			}
		}
		//echo $db->getSql();

?>
