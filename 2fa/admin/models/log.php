<?php
$FILE_ROOT = '../';
include_once('header.php');
include_once('CMSPage.php');

class Log extends CMSPage{
	public function __construct(){
		global $db, $setting;
		
		$this->fields = array('');
		/*foreach($setting->LANG AS $key => $value){
			array_push($this->lang, $key);
		}*/
		$this->dbName = 'log';
	}

	public function getListCMS(){
		global $db, $setting;
		require(ROOT_DIR.'../lib/DataTables-1.10.22/server_side/script/ssp.class.php');

		$table = $setting->DB_PREFIX.$this->dbName;
		$primaryKey = 'id';
		$columns = array(
			array( 'db' => 'id',             'dt' => 0 ),
			array( 'db' => 'section',        'dt' => 1 ),
			array( 'db' => 'item_pid',       'dt' => 2 ),
			array( 'db' => 'item_id',        'dt' => 3 ),
			array( 'db' => 'createDateTime', 'dt' => 4 ),
			array( 'db' => 'createBy',       'dt' => 5 ),
			array( 'db' => 'action',         'dt' => 6 ),
			array( 'db' => 'status',         'dt' => 7 ),
			array( 'db' => 'approval_title', 'dt' => 8 ),
		);

		$sql_details = array(
			'user' => $setting->DB_USERNAME,
			'pass' => $setting->DB_PASSWORD,
			'db'   => $setting->DB_TABLE,
			'host' => $setting->DB_URL,
			'port' => $setting->DB_PORT
		);

		$rst =  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
		foreach ($rst['data'] as $key => $row) {
			switch($row[7]){
				case 'A': $rst['data'][$key][7] = renderListStatusActive('Active'); break;
				case 'P': $rst['data'][$key][7] = renderListStatusPending('Pending'); break;
				default: $rst['data'][$key][7] = 'N/A';
			}
			if(intval($row[2]) == 0 && intval($row[3]) != 0){
			//	$rst['data'][$key][2] = $row[3];
				$rst['data'][$key][2] = 'N/A';
			}
			if(intval($row[2]) != 0 && intval($row[3]) == 0){
				$rst['data'][$key][3] = 'N/A';
			}

			if(intval($row[2]) == 0 && intval($row[3]) == 0){
				$rst['data'][$key][2] = 'N/A';
				$rst['data'][$key][3] = 'N/A';
			}
		}
		echo json_encode($rst);
	}

}//class log end

?>
