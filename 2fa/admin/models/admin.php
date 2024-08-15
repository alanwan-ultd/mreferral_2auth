<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

$FILE_ROOT = '../';
if(!isset($needIncludeHeader) || $needIncludeHeader === true) include_once('header.php');

class Admin{
	private $model;

	public function __construct(){

	}

	public function createRawItem(){
		$output = array(
			'id'=>0,
			'login'=>'',
			'2fa_secret'=>'',
			'2fa_qrcode'=>'',
			'password'=>'',
			'name'=>'',
			'email'=>'',
			'description'=>'',
			'groupId'=>'',
			'status'=>'',
		);
		return $output;
	}

	public function getItemById($id = 0){
		global $db, $setting;

		$rst = false;
		$raw = array();
		array_push($raw, $this->createRawItem());
		if($id){
			$rst = $db->select($setting->DB_PREFIX.'adminuser', 'id=:id AND deleted="N"', array(':id'=>$id));
		}
		return ($rst !== false && count($rst) == 1)?$rst:$raw;
	}

	public function getListCMS($name){
		global $db, $setting;

		$rst = $db->select($setting->DB_PREFIX.'adminuser', 'deleted="N"', array(), 'id, login, status');
		foreach($rst as $key => $row){
			switch($row['status']){
				case 'A': $rst[$key]['status'] = renderListStatusActive('Active'); break;
				case 'P': $rst[$key]['status'] = renderListStatusPending('Pending'); break;
			}
			$rst[$key]['action'] = renderListActionBtn($name.'_edit', $row['id']);
		}
		return $rst;
	}

	public function getListGroup(){
		global $db, $setting;

		$rst = $db->select($setting->DB_PREFIX.'admingroup', 'deleted="N" ORDER BY title DESC', array(), 'id, title');
		return $rst;
	}

	public function getListGroupOption(){
		$rst = $this->getListGroup();
		$outputAry = array();
		foreach($rst as $key=>$value){
			array_push($outputAry, array($value['id'], $value['title']));
		}
		return $outputAry;
	}

	public function login($login, $password, $authCode){
		global $db, $setting;

		$password = MD5($password);
		$rst = $db->select($setting->DB_PREFIX.'adminuser u LEFT JOIN '.$setting->DB_PREFIX.'admingroup g ON u.groupId=g.id', 'u.login=:login AND u.password=:password AND u.status="A" AND u.deleted="N" AND g.status="A" AND g.deleted="N"'
		, array(':login'=>$login, ':password'=>$password)
		, 'u.id AS id, u.login AS login, u.groupId AS groupId, u.noOfLogin AS noOfLogin, u.2fa_secret AS 2fa_secret'
		);

		if($rst !== false && count($rst) == 1){
			// check 2FA
			$g = new GoogleAuthenticator();
			$secret = $rst[0]['2fa_secret'];

			if (!$g->checkCode($secret, $authCode)) {
				return false;
			}
			// end of check 2FA

			$_SESSION['id'] = $rst[0]['id'];
			$_SESSION['login'] = $rst[0]['login'];
			$_SESSION['groupId'] = $rst[0]['groupId'];
			$this->saveItemById(array(
				'lastLoginDateTime'=>date('Y-m-d H:i:s'),
				'noOfLogin'=>intval($rst[0]['noOfLogin']) + 1
			), $rst[0]['id']);
			return true;
		}else{
			session_unset();
			session_destroy();
			ini_set('session.gc_maxlifetime', 10800);
			ini_set('session.cookie_samesite', 'None');
			ini_set('session.cookie_secure', 'true');
			session_start();
			return false;
		}
	}

	/*public function logout(){
		global $db, $setting;
	}*/

	public function saveItemById($data, $id = 0){
		global $db, $setting;

		if($id == 0){  //new
			$rst = $db->insert($setting->DB_PREFIX.'adminuser', $data);
		}else{  //update
			$rst = $db->update($setting->DB_PREFIX.'adminuser', $data, 'id=:id AND deleted="N"', array(':id'=>$id));
		}
		return $rst;
	}
}

?>
