<?php

class CMSPage{
	protected $dbName;
	protected $fields;
	protected $lang = array();
	protected $me;
	protected $model;

	public function __construct(){

	}
	
	function checkDuplicateURL($url, $id){
		global $db, $setting;
		$url = $this->smarty_function_urlslug(array('url' => $url));
		reset($this->lang);
		$rst = $db->select($setting->DB_PREFIX.$this->dbName,
			'i18n_id=:i18n_id AND id=version_id AND deleted="N" AND url=:url AND mapping_id != :id',
			array(':i18n_id'=>$this->lang[0], ':id'=>$id, ':url'=>$url),
			'mapping_id');
		
		$data = array('url'=>$url);
		if($rst){
			if(count($rst)>0){
				$url = $url.'_'.$id;
				$data = array('url'=>$url);
			}
		}
		$rst = $db->update($setting->DB_PREFIX.$this->dbName, $data, ' WHERE mapping_id=:id', array(':id'=>$id));

		return $url;
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

	public function deleteItemAllLangById($data, $id = 0){
		global $db, $setting;

		$rst = $db->update($setting->DB_PREFIX.$this->dbName, $data, 'mapping_id=:mapping_id AND id=version_id AND status="P" AND deleted="N"', array(':mapping_id'=>$id));

		return ($rst)?true:false;
	}
	
	public function getApprovalMsg($id){
		global $db, $setting;
		$rst = $db->select($setting->DB_PREFIX.'approval', 'item_id=:id AND id=version_id AND deleted="N" ORDER BY createDateTime', array(':id'=>$id), 'msg, createBy, createDateTime, approve_status');
		foreach ($rst as $key => $value) {
			if($value['approve_status'] == 'P'){
				$rst[$key]['approve'] = 'Not yet approved';
			}else{
				$rst[$key]['approve'] = 'Approved';
			}
		}
		return $rst;
	}
	
	function getApprovalTitle($id){
		global $db, $setting;
		reset($this->lang);
		$rst = $db->select($setting->DB_PREFIX.$this->dbName,
			'i18n_id=:i18n_id AND id=version_id AND deleted="N" AND mapping_id='. $id,
			array(':i18n_id'=>$this->lang[0]),
			'*');
		return $rst;
	}

	public function getFields(){
		return $this->fields;
	}

	public function getItemById($id = 0){
		global $db, $setting;

		$rst = false;
		$raw = array();
		$output = array();

		//new blank item
		foreach($this->lang AS $value){
			array_push($raw, $this->createRawItem());
		}

		if($id){  //existing item
			$rst = $db->select($setting->DB_PREFIX.$this->dbName, 'id=:id AND id=version_id AND deleted="N"', array(':id'=>$id));
			if($rst !== false && count($rst) == 1){
				//$output = array_merge($output, $rst);
				foreach($this->lang AS $key => $value){
					//if($key == 0) continue;
					$rst2 = $db->select($setting->DB_PREFIX.$this->dbName, 'mapping_id=:mid AND i18n_id=:i18n_id AND id=version_id AND deleted="N"', array(':mid'=>$rst[0]['mapping_id'], ':i18n_id'=>$value));
					if($rst2 !== false && count($rst2) == 1){
						$output = array_merge($output, $rst2);
					}else{
						array_push($output, $this->createRawItem());
					}
				}
			}else{
				$rst = false;
			}
		}
		//var_dump($output);
		$this->me = ($rst !== false)?$output:$raw;
		//return ($rst !== false)?$output:$raw;
		return $this->me;
	}

	public function getItemByMapLang($mid, $lang){
		global $db, $setting;

		$rst = $db->select($setting->DB_PREFIX.$this->dbName, 'mapping_id=:mid AND i18n_id=:i18n_id AND deleted="N"', array(':mid'=>$mid, ':i18n_id'=>$lang));
		return ($rst !== false && count($rst) > 0)?true:false;
	}

	public function getItemMaxPos(){
		global $db, $setting;

		$rst = $db->select($setting->DB_PREFIX.$this->dbName, 'deleted="N"', array(), 'MAX(position) AS pos');
		return ($rst !== false && count($rst) == 1)?$rst[0]['pos']:0;
	}

	public function getMe(){
		return $this->me;
	}

	public function getPID($id){
		if($this->me){
			//do nothing
		}else{
			$this->getItemById($id);
		}
		if(isset($this->me[0]['pid'])){
			return $this->me[0]['pid'];
		}else{
			return false;
		}
	}

	public function isPubished($id){
		global $db, $setting;

		if($this->me && count($this->me) > 0 && $id){
			//$rst = $db->select($setting->DB_PREFIX.$this->dbName, 'mapping_id=:mapping_id AND i18n_id=:i18n_id AND deleted="N" ORDER BY id DESC LIMIT 1', array(':mapping_id'=>$this->me[0]['mapping_id'], ':i18n_id'=>$this->me[0]['i18n_id']));
			$rst = $db->select($setting->DB_PREFIX.$this->dbName, 'id=:id AND i18n_id=:i18n_id AND deleted="N" ORDER BY id DESC LIMIT 1', array(':id'=>$this->me[0]['id'], ':i18n_id'=>$this->me[0]['i18n_id']));
			if($rst !== false && count($rst) == 1){
				//if($rst[0]['id'] == $this->me[0]['approve_id']){
				if($rst[0]['approve_status'] == 'A'){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function saveItemById($data, $id = 0, $lang = '', $new = true){
		global $db, $setting;

		if($new){  //new
			$data['i18n_id'] = $lang;
			$rst = $db->insert($setting->DB_PREFIX.$this->dbName, $data);
		}else{  //update
			if($lang == ''){
				$rst = $db->update($setting->DB_PREFIX.$this->dbName, $data, 'id=:id AND deleted="N"', array(':id'=>$id));
			}else{
				$rst = $db->update($setting->DB_PREFIX.$this->dbName, $data, 'i18n_id=:i18n_id AND mapping_id=:mapping_id AND id=version_id AND deleted="N"', array(':i18n_id'=>$lang, ':mapping_id'=>$id));
			}
		}
		return $rst;
	}

	public function saveItemAllLangById($data, $id = 0){
		global $db, $setting;

		$rst = $db->update($setting->DB_PREFIX.$this->dbName, $data, 'mapping_id=:mapping_id AND id=version_id AND deleted="N"', array(':mapping_id'=>$id));
		return ($rst)?true:false;
	}

	public function saveItemPublishAllLangByIds($ids){
		global $db, $setting, $util;

		$canDo = true;
		foreach($ids as $key => $value){
			if(!is_numeric($value)) $canDo = false;
		}

		if($canDo == false) return false;

		foreach($ids as $key => $value){
			$originalData = $this->getItemById($value);
			$i = 0;
			if($this->isPubished($originalData[$i]['id']) == true) continue;
			//$id = $originalData[$i]['id'];
			$id = $originalData[$i]['mapping_id'];
			foreach($setting->LANG AS $k => $v){
				unset($originalData[$i]['id']);
				$originalData[$i]['approveBy'] = $_SESSION['sales_login'];
				$originalData[$i]['approveDateTime'] = date('Y-m-d H:i:s');
				$originalData[$i]['approve_status'] = 'A';
				$lastInsertId = $this->saveItemById($originalData[$i], 0, $k, true);
				$lang = (isset($originalData[$i]['i18n_id']))?$originalData[$i]['i18n_id']:'';
				if($lastInsertId){
					$this->saveItemById(array(
						'approveBy'=>$_SESSION['sales_login'], 
						'approveDateTime'=>date('Y-m-d H:i:s'), 
						'approve_id'=>$lastInsertId, 
						'approve_status' => 'A', 
					), $id, $lang, false);
				}
				$i++;
			}
		}
		return true;
	}

	public function saveItemStatusAllLangByIds($data, $ids){
		global $db, $setting, $util;

		$canDo = true;
		foreach($ids as $key => $value){
			if(!is_numeric($value)) $canDo = false;
		}

		if($canDo == false) return false;
		$idsStr = implode(',', $ids);

		$rst = $db->update($setting->DB_PREFIX.$this->dbName, $data, 'mapping_id IN ('.$idsStr.') AND id=version_id AND deleted="N"', array());
		return ($rst)?true:false;
	}
	
	public function saveLog($data, $item_id){
		global $db, $setting;

		$rst = $db->insert($setting->DB_PREFIX.'log', $data);
		//var_dump($rst);
		//echo $db->getSql();
		return $rst;
	}

	function smarty_function_urlslug($params){
		if(empty($params['url'])){
			return;
		}
		$str = $params['url'];
		$maxlen = 100;
		if(!empty($params['maxlen'])){
			$maxlen = intval($params['maxlen']);
		}
		$str = mb_substr(mb_strtolower($str), 0, $maxlen, "utf-8");
		$string = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
		// replace non letter or digits by -
		$string = preg_replace('~[^\\pL\d]+~u', '-', $string);
		$string = trim($string, '-');

		return $string;
	}

	public function trimContent($content, $trim_offset = 300)
	{
		$content = strip_tags(html_entity_decode($content));
		return strlen($content) > $trim_offset ? mb_substr($content, 0, $trim_offset) . "..." : $content;
	}

	public function makeThumbnail($src, $maxWidth = 100)
	{
		return "<img src='/{$src}' alt='' style='width:100%; max-width: {$maxWidth}px' />";
	}

}//class CMSPage end

?>