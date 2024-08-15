<?php
$log['section'] = $util->purifyCheck($util->returnData('section_name'));

		if($id == 0){  //new item
			$data['createBy'] = $_SESSION['login'];
			$data['createDateTime'] = date('Y-m-d H:i:s');
			//var_dump($data);//exit();
			if($i == 0){
				$position = $data['position'] = $model->getItemMaxPos()+1;
				$rst[$i] = $model->saveItemById($data, 0, $key, true);

				$all_data = $data;
				$all_data['mapping_id'] = $rst[0];
				$data = array('mapping_id' => $rst[0]);
				$data['version_id'] = $rst[0];
				$model->saveItemById($data, $rst[0], '', false);
			}else{
				$data['position'] = $position;
				$data['mapping_id'] = $rst[0];
				$rst[$i] = $model->saveItemById($data, $rst[0], $key);
				$all_data = $data;
				$data = array('version_id' => $rst[$i]);
				$model->saveItemById($data, $rst[$i], '', false);
			}
		/*	$log['item_id'] = $rst[0];

			if($log['action'] != 'Submit for Approval'){
				$log['action'] = 'Create New Item';
				if($pid){
			//		$log['action'] = 'Create New Content';
				}else{
					if($log['approval_title'] == ''){
						$log['approval_title'] = (isset($all_data['title_i18n']))?$all_data['title_i18n']: $all_data['name_i18n'];
					}
				}
			}else{
				$log['item_id'] = (isset($all_data['item_pid']) && !empty($all_data['item_pid']))?$all_data['item_pid'] :$all_data['item_id'] ;
			}*/

	//		$log['approval_title'] = 'Title: '. $log['approval_title'];

		//	$log_rst = $model->saveLog($log, $log['item_id']);
		}else{  //existing item
			if($model->getItemByMapLang($id, $key)){  //item exist
				$rst[$i] = $model->saveItemById($data, $id, $key, false);
			}else{  //item not exist
				$data['position'] = $originalData[0]['position'];
				$data['status'] = $originalData[0]['status'];
				$data['createBy'] = $_SESSION['login'];
				$data['createDateTime'] = date('Y-m-d H:i:s');
				$rst[$i] = $model->saveItemById($data, $id, $key, true);
				$data = array('version_id' => $rst[$i]);
				$model->saveItemById($data, $rst[$i], '', false);
			}
			$data['mapping_id'] = $id;

			$all_data = $data;

			unset($originalData[$i]['id']);
			$model->saveItemById($originalData[$i], 0, $key, true);
		/*	if($log['action'] != 'Submit for Approval'){
				$log['action'] = 'Save';
				if($pid){
					$log['action'] = 'Save Content';
				}
			}*/

		//	$log['approval_title'] = 'Title: '. $log['approval_title'];

			//$log_rst = $model->saveLog($log, $log['item_id']);
		//	var_dump($data);exit();
		}
		//echo $db->getSql();

?>
