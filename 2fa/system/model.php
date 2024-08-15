<?php

class Model {

	private $connection;

	public function __construct()
	{
		global $config, $db, $setting;
        if(isset($config['need_db']) && $config['need_db']){  //define @ page controller
            require_once(APP_DIR.'plugins/DB.php');
            require_once(APP_DIR.'plugins/dbInit.php');
        }else{
            //do nothing
        }
	}

	public function escapeString($string)
	{
		return mysql_real_escape_string($string);
	}

	public function escapeArray($array)
	{
	    array_walk_recursive($array, create_function('&$v', '$v = mysql_real_escape_string($v);'));
		return $array;
	}

	public function to_bool($val)
	{
	    return !!$val;
	}

	public function to_date($val)
	{
	    return date('Y-m-d', $val);
	}

	public function to_time($val)
	{
	    return date('H:i:s', $val);
	}

	public function to_datetime($val)
	{
	    return date('Y-m-d H:i:s', $val);
	}

	public function query($qry)
	{
		$result = mysql_query($qry) or die('MySQL Error: '. mysql_error());
		$resultObjects = array();

		while($row = mysql_fetch_object($result)) $resultObjects[] = $row;

		return $resultObjects;
	}

	public function execute($qry)
	{
		$exec = mysql_query($qry) or die('MySQL Error: '. mysql_error());
		return $exec;
	}

	public function getRecord($db, $language, $setting, $tbl, $query1Where, $query1Bind, $query1Fields, $query2Where, $query2Bind, $query2Fields){
		$debug = false; //$debug = true;

		$rst = $db->select($tbl, $query1Where, $query1Bind, $query1Fields);
		if($debug){
			echo $db->getSQL();
			echo '<pre>';var_dump($db->getBind());echo '</pre>';
		}
        if($rst !== false && count($rst) > 0){
			$idsAry = array();
            $ids = '';
            foreach($rst AS $id=>$row){
				if(is_numeric($row['approve_id'])){
					array_push($idsAry, $row['approve_id']);
				}
            }
			$ids = implode(',', $idsAry);
            $rst2 = $db->select($tbl, 'id IN ('.$ids.') '.$query2Where, $query2Bind, $query2Fields);
			if($debug){
				echo $db->getSQL();
				echo '<pre>';var_dump($db->getBind());echo '</pre>';
			}

			if($rst2 !== false && count($rst2) > 0){
				/*foreach($rst2 AS $id2=>$row2){

				}*/
				return $rst2;
			}
		}else{
			return false;
		}
	}

}
?>
