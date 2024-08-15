<?php
$FILE_ROOT = '../';
include_once('header.php');
include_once('CMSPage.php');

class Home extends CMSPage{
	public function __construct(){
		global $db, $setting;
		
		$this->fields = array('title_i18n', 'imgGroup0', 'meta_title_i18n', 'meta_desc_i18n', 'meta_keywords_i18n', 'meta_img');
		foreach($setting->LANG AS $key => $value){
			array_push($this->lang, $key);
		}
		$this->dbName = 'home';
	}
	
	public function getListCMS($name){
		global $db, $setting;
		
		reset($this->lang);
		$rst = $db->select($setting->DB_PREFIX.$this->dbName, 'i18n_id=:i18n_id AND id=version_id AND deleted="N" ORDER BY id DESC', array(':i18n_id'=>$this->lang[0]), 'mapping_id AS id, title_i18n, status, approve_id, approve_status');
		if($rst !== false && count($rst) > 0){
			foreach($rst as $key => $row){
				switch($row['status']){
					case 'A': $rst[$key]['status'] = renderListStatusActive('Active'); break;
					case 'P': $rst[$key]['status'] = renderListStatusPending('Pending'); break;
				}
				if($row['approve_status'] == 'A'){
					$rst[$key]['approve_id'] = renderListPublishActive();
				}else{
					$rst[$key]['approve_id'] = renderListPublishEdit();
				}
				$rst[$key]['approve_id'] .= ' : ';
				if(intval($row['approve_id']) > 0){
					$rst[$key]['approve_id'] .= renderListPublishActive();
				}else{
					$rst[$key]['approve_id'] .= renderListPublishPending();
				}
				$rst[$key]['action'] = renderListActionBtn($name.'_edit', $row['id']);


			}
		}
		
		//echo $db->getSQL();
		//var_dump($db->getBind());
		return $rst;
	}

}

?>