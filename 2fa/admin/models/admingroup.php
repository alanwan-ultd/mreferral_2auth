<?php
$FILE_ROOT = '../';
include_once('header.php');

class AdminGroup{
	private $model;
	
	public function __construct(){
		global $db, $setting;
		
		$this->fields = array('title', 'description');
		$this->dbName = 'admingroup';
		$this->dbName2 = 'section_permission';
	}
	
	 public function createRawItem(){
		$output = array();
		$output['id'] = 0;
		$output['status'] = 'P';
		foreach($this->fields AS $value){
			$output[$value] = '';
		}
		return $output;
	}
	
	public function getItemById($id = 0){
		global $db, $setting;
		
		$rst = false;
		$raw = array();
		array_push($raw, $this->createRawItem());
		if($id){
			$rst = $db->select($setting->DB_PREFIX.$this->dbName, 'id=:id AND deleted="N"', array(':id'=>$id));
		}
		return ($rst !== false && count($rst) == 1)?$rst:$raw;
	}
	
	public function getListCMS($name){
		global $db, $setting;
		
		$rst = $db->select($setting->DB_PREFIX.$this->dbName, 'deleted="N"', array(), 'id, title, description, status');
		foreach($rst as $key => $row){
			switch($row['status']){
				case 'A': $rst[$key]['status'] = renderListStatusActive('Active'); break;
				case 'P': $rst[$key]['status'] = renderListStatusPending('Pending'); break;
			}
			$rst[$key]['action'] = renderListActionBtn($name.'_edit', $row['id']);
		}
		return $rst;
	}
	
	public function saveItemById($data, $id = 0){
		global $db, $setting;
		
		if($id == 0){  //new
			$rst = $db->insert($setting->DB_PREFIX.$this->dbName, $data);
		}else{  //update
			$rst = $db->update($setting->DB_PREFIX.$this->dbName, $data, 'id=:id AND deleted="N"', array(':id'=>$id));
		}
		return $rst;
	}
	
	public function savePermissionBygId($data, $gid){
		global $db, $setting;
		
		$section = $data['section'];
		$rst = $db->select($setting->DB_PREFIX.$this->dbName2, 'section=:section AND admingroup_id=:gid AND status="A" AND deleted="N"', array(':gid'=>$gid, ':section'=>$section));
		//echo $db->getSql();
		//var_dump($db->getBind());
		//var_dump($rst);
		if($rst === false || count($rst) <= 0){  //new
			$rst = $db->insert($setting->DB_PREFIX.$this->dbName2, $data);
		}else{  //update
			unset($data['section']);
			unset($data['admingroup_id']);
			unset($data['createBy']);
			unset($data['createDateTime']);
			unset($data['status']);
			unset($data['deleted']);
			$rst = $db->update($setting->DB_PREFIX.$this->dbName2, $data, 'section=:section AND admingroup_id=:gid AND status="A" AND deleted="N"', array(':gid'=>$gid, ':section'=>$section));
		}
		return $rst;
	}
}

?>