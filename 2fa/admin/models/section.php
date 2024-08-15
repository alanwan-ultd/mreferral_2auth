<?php
//$FILE_ROOT = '../';
//include_once('header.php');

class Section{
	private $group;
	private $model;
	private $name;
	private $section;


	public function __construct($name, $group = '', $groupSub = ''){
		global $CMSSection;
		$this->section = $CMSSection;
		$this->name = $name;
		$this->group = $group;
		$this->groupSub = $groupSub;
	}

	public function checkCanView($sectionPermission){
		return (intval($sectionPermission[0]) == 0 && intval($sectionPermission[1]) == 0 && intval($sectionPermission[2]) == 0)?false:true;
	}

	public function getCMSMenu($gid){
		$output = array();
		$temp = array();
		$permission = $this->getPermissionByGroupId($gid);  //var_dump($permission);
		foreach($this->section AS $key=>$value){
			if(isset($value['title'])){  //title item
				array_push($output, array('title'=>$value['title']));
			}else if(isset($value['items'])){  //have sub menu
				$temp = array();
				foreach($value['items'] AS $key2=>$value2){
					if(isset($value2['items'])){  //have sub sub menu
						$temp2 = array();
						foreach($value2['items'] AS $key3=>$value3){
							if(array_key_exists($key3, $permission)){
								if($permission[$key3][0] == 1 || $permission[$key3][1] == 1 || $permission[$key3][2] == 1){
									array_push($temp2, $value3);
								}
							}
						}
						if(!empty($temp2)){
							array_push($temp, array('name'=>$value2['name'], 'link'=>'', 'icon'=>$value2['icon'], 'sub'=>$temp2));
						}
					}else{
						if(array_key_exists($key2, $permission)){
							if($permission[$key2][0] == 1 || $permission[$key2][1] == 1 || $permission[$key2][2] == 1){
								array_push($temp, $value2);
							}
						}
						
					}
				}
				if(isset($temp) && !empty($temp)){  //this level and inside level have permission
					array_push($output, array('name'=>$value['name'], 'link'=>'', 'icon'=>$value['icon'], 'sub'=>$temp));
				}
			}else{  //no sub menu
				if(array_key_exists($key, $permission)){
					if($permission[$key][0] == 1 || $permission[$key][1] == 1 || $permission[$key][2] == 1){
						array_push($output, $value);
					}
				}
			}
		}

		//echo '<pre>';var_dump($output);echo '</pre>';  //exit;
		return $output;
	}

	public function getCMSSection(){
		$output = array();
		foreach($this->section AS $key => $value){
			if(isset($value['items'])){  //sub
				array_push($output, array('', $value['name']));

				foreach($value['items'] AS $key2 => $value2){
					if(isset($value2['items'])){  //have sub sub menu
						array_push($output, array('', '&nbsp;&nbsp;&nbsp;&nbsp;'.$value2['name']));
						foreach($value2['items'] AS $key3=>$value3){
							array_push($output, array($key3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$value3['name']));
						}
					}else{
						array_push($output, array($key2, '&nbsp;&nbsp;&nbsp;&nbsp;'.$value2['name']));
					}
				}
			}else{
				$temp = (isset($value['name']))?$value['name']:'';
				array_push($output, array($key, $temp));
			}
		}
		//var_dump($output);exit;
		return $output;
	}

	public function getCMSSectionBySection($name){
		$output = array();
		foreach($this->section AS $key => $value){
			if(isset($value['items'])){  //sub
				foreach($value['items'] AS $key2 => $value2){
					if($name == $key2){
						$output = $value2;
					}
				}
			}else{
				if($name == $key){
					$output = $value;
				}
			}
		}
		//var_dump($output);
		return $output;
	}

	public function getListCMS($gId, $section = ''){
		global $db, $setting;

		$tbl = $setting->DB_PREFIX.'section_permission';
		$whereClause = 'admingroup_id=:gId AND status="A" AND deleted="N"';
		$bindArry = array(':gId'=>$gId);
		$fields = 'section, admingroup_id, read_, write_, approve_';

		if($section){
			$whereClause = 'section=:section AND ' . $whereClause;
			$bindArry[':section'] = $section;
		}

		$rst = $db->select($tbl, $whereClause, $bindArry, $fields);
		//echo $db->getSQL();
		//echo '<pre>';var_dump($db->getBind());echo '</pre>';
		return $rst;
	}

	public function getPermissionByGroupId($gId){
		$output = array();
		$list = $this->getListCMS($gId);  //var_dump($gId);var_dump($list);exit();
		if($list !== false && count($list) >= 1){
			foreach($list AS $key => $value){
				$output[$value['section']] = array($value['read_'], $value['write_'], $value['approve_']);
			}
		}
		return $output;
	}

	public function getPermissionBySection($section){
		$output = array();

		$gId = (isset($_SESSION['sales_groupId']))?$_SESSION['sales_groupId']:0;
		$list = $this->getListCMS($gId, $section);
		if($list !== false && count($list) == 1){
			$output = array($list[0]['read_'], $list[0]['write_'], $list[0]['approve_']);
		}else{
			$output = array(0, 0, 0);
		}
		return $output;
	}

	public function run(){
		if($this->group == ''){  //single level
			if(isset($this->section[$this->name]) && is_array($this->section[$this->name])){
				return $this->section[$this->name];
			}else{
				return false;
			}
		}else{
			if(isset($this->section[$this->group]['items'][$this->name]) && is_array($this->section[$this->group]['items'][$this->name])){  //sub
				return $this->section[$this->group]['items'][$this->name];
			}elseif(isset($this->section[$this->group]['items'][$this->groupSub]['items'][$this->name]) 
				&& is_array($this->section[$this->group]['items'][$this->groupSub]['items'][$this->name])){  //sub sub
				return $this->section[$this->group]['items'][$this->groupSub]['items'][$this->name];
			}else{
				return false;
			}
		}
	}

}//class

?>
