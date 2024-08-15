<?php
try{
	if(isset($setting)){
		//$db = new DB("mysql:host=".$setting->DB_URL.";dbname=".$setting->DB_TABLE, $setting->DB_USERNAME, $setting->DB_PASSWORD);
		$db = new DB("mysql:host=".$setting->DB_URL.";dbname=".$setting->DB_TABLE.";port=".$setting->DB_PORT.";", $setting->DB_USERNAME, $setting->DB_PASSWORD);
	}else{
		$db = new DB("mysql:host=".$config['db_host'].";dbname=".$config['db_name'].";port=".$setting->DB_PORT.";", $config['db_username'], $config['db_password']);
	}
	//UTF8
	//$db->exec("SET NAMES UTF8");
	//$db->exec("SET CHARACTER SET UTF8");
	//$db->exec("SET CHARACTER_SET_CLIENT=UTF8");
	//$db->exec("SET CHARACTER_SET_RESULTS=UTF8");

	//utf8mb4
	$db->exec("SET NAMES utf8mb4");
	$db->exec("SET CHARACTER SET utf8mb4");
	$db->exec("SET CHARACTER_SET_CLIENT=utf8mb4");
	$db->exec("SET CHARACTER_SET_RESULTS=utf8mb4");

	//$db_timezone = (new DateTime('now', new DateTimeZone('Asia/Hong_Kong')))->format('P');
	$tempDateTimeZone = new DateTimeZone('Asia/Hong_Kong');
	$tempDateTime = new DateTime('now', $tempDateTimeZone);
	$db_timezone = $tempDateTime->format('P');
	$db->exec("SET time_zone='$db_timezone';");
}catch (Exception $e){
	exit('DataBase connection failure');
}

?>
