<?php
//$FILE_ROOT = '../';
//include_once('header.php');

class Section
{
	private $group;
	private $model;
	private $name;
	private $section;


	public function __construct($name, $group = '')
	{
		global $CMSSection;
		$this->section = $CMSSection;
		$this->name = $name;
		$this->group = $group;
	}

	public function checkCanView($sectionPermission)
	{
		return (intval($sectionPermission[0]) == 0 && intval($sectionPermission[1]) == 0 && intval($sectionPermission[2]) == 0) ? false : true;
	}

	public function getCMSMenu($gid)
	{
		$output = array();
		$temp = array();
		$permission = $this->getPermissionByGroupId($gid);  //var_dump($permission);

		foreach ($this->section as $key => $value) {
			if (isset($value['title'])) {  //title item
				array_push($output, array('title' => $value['title']));
			} else if (isset($value['items'])) {  //have sub menu
				$temp = array();
				foreach ($value['items'] as $key2 => $value2) {
					if (array_key_exists($key2, $permission)) {
						if ($permission[$key2][0] == 1 || $permission[$key2][1] == 1 || $permission[$key2][2] == 1) {
							array_push($temp, $value2);
						}
					}
				}
				if (!empty($temp)) {
					array_push($output, array('name' => $value['name'], 'link' => '', 'icon' => $value['icon'], 'sub' => $temp));
				}
			} else {  //no sub menu
				if (array_key_exists($key, $permission)) {
					if ($permission[$key][0] == 1 || $permission[$key][1] == 1 || $permission[$key][2] == 1) {
						array_push($output, $value);
					}
				}
			}
		}

		//echo '<pre>';var_dump($output);echo '</pre>';
		return $output;
	}

	public function getCMSSection()
	{
		$output = array();
		foreach ($this->section as $key => $value) {
			if (isset($value['items'])) {  //sub
				array_push($output, array('', $value['name']));
				foreach ($value['items'] as $key2 => $value2) {
					array_push($output, array($key2, '&nbsp;&nbsp;&nbsp;&nbsp;' . $value2['name']));
				}
			} else {
				$temp = (isset($value['name'])) ? $value['name'] : '';
				array_push($output, array($key, $temp));
			}
		}
		//var_dump($output);
		return $output;
	}

	public function getCMSSectionBySection($name)
	{
		$output = array();
		foreach ($this->section as $key => $value) {
			if (isset($value['items'])) {  //sub
				foreach ($value['items'] as $key2 => $value2) {
					if ($name == $key2) {
						$output = $value2;
					}
				}
			} else {
				if ($name == $key) {
					$output = $value;
				}
			}
		}
		//var_dump($output);
		return $output;
	}

	public function getListCMS($gId, $section = '')
	{
		global $db, $setting;

		$tbl = $setting->DB_PREFIX . 'section_permission';
		$whereClause = 'admingroup_id=:gId AND status="A" AND deleted="N"';
		$bindArry = array(':gId' => $gId);
		$fields = 'section, admingroup_id, read_, write_, approve_';

		if ($section) {
			$whereClause = 'section=:section AND ' . $whereClause;
			$bindArry[':section'] = $section;
		}

		$rst = $db->select($tbl, $whereClause, $bindArry, $fields);
		//echo $db->getSQL();
		//echo '<pre>';var_dump($db->getBind());echo '</pre>';
		return $rst;
	}

	public function getPermissionByGroupId($gId)
	{
		$output = array();
		$list = $this->getListCMS($gId);  //var_dump($gId);var_dump($list);exit();
		if ($list !== false && count($list) >= 1) {
			foreach ($list as $key => $value) {
				$output[$value['section']] = array($value['read_'], $value['write_'], $value['approve_']);
			}
		}
		return $output;
	}

	public function getPermissionBySection($section)
	{
		$output = array();

		$gId = (isset($_SESSION['groupId'])) ? $_SESSION['groupId'] : 0;
		$list = $this->getListCMS($gId, $section);
		if ($list !== false && count($list) == 1) {
			$output = array($list[0]['read_'], $list[0]['write_'], $list[0]['approve_']);
		} else {
			$output = array(0, 0, 0);
		}
		return $output;
	}

	public function run()
	{
		if ($this->group == '') {
			if (isset($this->section[$this->name]) && is_array($this->section[$this->name])) {
				return $this->section[$this->name];
			} else {
				return false;
			}
		} else {
			if (isset($this->section[$this->group]['items'][$this->name]) && is_array($this->section[$this->group]['items'][$this->name])) {
				return $this->section[$this->group]['items'][$this->name];
			} else {
				return false;
			}
		}
	}
}

//support only 2 levels
/*
"[$name]" => array(
	"name" => "[display name in menu]"
	, "link" => "[link in menu]"
	, "icon" => "cil-xxxx"
	, "items" => array(
		"ourTeam" => array(
			"name" => "[display name in menu]"
			, "link" => "xxx_list.php"
			, "icon" => "cil-xxx"
			, "sort" => true
			, "create" => true
		)
	)
)
*/
$CMSSection = array(
	"titleSetting" => array(
		"title" => "Setting"
	)
	/*	, "staff" => array(
		"name" => "Staff Info"
		, "link" => "staff_list.php"
		, "icon" => "icon-user-tie"
		, "sort" => false
		, "create" => true
	)*/,
	"admin" => array(
		"name" => "Admin",
		"link" => "group",
		"icon" => "cil-settings",
		"items" => array(
			"admin" => array(
				"name" => "User",
				"link" => "admin_list.php",
				"icon" => "cil-user",
				"sort" => false,
				"create" => true
			),
			"adminGroup" => array(
				"name" => "User Group",
				"link" => "adminGroup_list.php",
				"icon" => "cil-people",
				"sort" => false,
				"create" => true
			),
			"uploadSalesCSV" => array(
				"name" => "Upload Sales CSV",
				"link" => "uploadSalesCSV_edit.php",
				"icon" => "cil-file",
				"sort" => false,
				"create" => false
			)
		)
	)

);
