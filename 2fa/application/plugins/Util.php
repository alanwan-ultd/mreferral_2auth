<?php
class Util{
	public function __construct() {
		//do nothing
	}

	public function combineArray2String($arr, $pattern){
		$dataStr = '';
		for($i = 0; $i < count($arr); $i++){
			$dataStr .= ($i != 0) ? $pattern : '';
			$dataStr .= $arr[$i];
		}
		return $dataStr;
	}
	
	public function comparePostdata($post, $fields) {
		$total_post = count($post);
		$total_fields = count($fields);

		if($total_post != $total_fields) {
			// not same post item length
			//var_dump('not same post item length');
			return false;
		}
		
		foreach(array_keys($post) as $post_field) {
			if(!in_array($post_field, $fields)) {
				//var_dump('no this field');
				return false;
			}
		}

		return true;
	}

	public function dbOutput($s, $plainTxt2HTML = false){
		global $isMagicQuotes;
		$output = $s;
		if($isMagicQuotes) $output = stripslashes($output);
		$output = htmlentities($output, ENT_QUOTES, 'UTF-8');
		if($plainTxt2HTML){
			$output = nl2br($output);
			//$order   = array("\r\n", "\n", "\r");
			//$replace = '<br />';
			//$output = str_replace($order, $replace, $output);
		}else{
			//do nothing
		}
		return $output;
	}

	public function dbOutputJsonTxt($s){
		$strReplace = array("\r\n","\r","\n","\\r","\\n","\\r\\n","\t","\\t");
		$output = str_replace($strReplace, "", $s);
		//$output = addslashes($output);
		$output = addcslashes($output, '"\\/');
		return $output;
	}

	public function dbOutputNoNewLine($s){
		$strReplace = array("\r\n","\r","\n","\\r","\\n","\\r\\n","\t","\\t");
		$output = str_replace($strReplace, "", $s);
		//$output = addslashes($output);
		return $output;
	}

	public function dbOutputNoStyle($s){
		$output = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $s);
		return $output;
	}

	public function decode($string,$key) {
		$j = 0;
		$hash = '';
		$key = sha1($key);
		$strLen = strlen($string);
		$keyLen = strlen($key);
		for ($i = 0; $i < $strLen; $i+=2) {
			$ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
			if (isset($j) && $j == $keyLen) { $j = 0; }
			$ordKey = ord(substr($key,$j,1));
			$j++;
			$hash .= chr($ordStr - $ordKey);
		}
		return $hash;
	}

	public function emojiRemove($string){
		// Match Emoticons
		$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
		$clear_string = preg_replace($regex_emoticons, '', $string);

		// Match Miscellaneous Symbols and Pictographs
		$regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
		$clear_string = preg_replace($regex_symbols, '', $clear_string);

		// Match Transport And Map Symbols
		$regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
		$clear_string = preg_replace($regex_transport, '', $clear_string);

		// Match Miscellaneous Symbols
		$regex_misc = '/[\x{2600}-\x{26FF}]/u';
		$clear_string = preg_replace($regex_misc, '', $clear_string);

		// Match Dingbats
		$regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
		$clear_string = preg_replace($regex_dingbats, '', $clear_string);

		return $clear_string;
	}

	public function encode($string,$key) {
		$j = 0;
		$hash = '';
		$key = sha1($key);
		$strLen = strlen($string);
		$keyLen = strlen($key);
		for ($i = 0; $i < $strLen; $i++) {
			$ordStr = ord(substr($string,$i,1));
			if ($j == $keyLen) { $j = 0; }
			$ordKey = ord(substr($key,$j,1));
			$j++;
			$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
		}
		return $hash;
	}

	public function getDirname($path){
		$current_dir = dirname($path);
		if($current_dir == "/" || $current_dir == "\\"){
			$current_dir = '';
		}
		return $current_dir;
	}

	public function getFileInfo($path){
		$info = array();
		if (!file_exists($path))
			return false;
		else{
			$pathInfo = pathinfo($path);
			$info['size'] = filesize($path);
			$info['name'] = $pathInfo['basename'];
			$info['extension'] = $pathInfo['extension'];
			$info['lastDateTime'] = date ("Y-m-d H:i:s", filemtime($path));
		}
		return $info;
	}

	public function getFolderFiles($dir = '', $fullPath = false){  //getFolderFiles('admin/images/bg/');
		$outputArray = array();
		if(file_exists($dir)){
			$outputArray = scandir($dir);
			foreach($outputArray as $key => $value){
				if($value == '.'
				|| $value == '..'
				|| $value == 'Thumb.db'
				|| $value == 'Thumbs.db'
				){
					unset($outputArray[$key]);
				}else{
					$outputArray[$key] = ($fullPath) ? $dir . $value : $value;
				}
			}
			return $outputArray;
		}else{
			return $outputArray;
		}
	}

	/*public function getFolderFiles($dir = ''){  //useage getFolderFiles('/www/cms/2014Version/admin/images/bg');
		$listDir = array();
		if($handler = opendir($_SERVER["DOCUMENT_ROOT"].$dir)) {
			while (($sub = readdir($handler)) !== FALSE) {
				if ($sub != "." && $sub != ".." && $sub != "Thumb.db" && $sub != "Thumbs.db") {
					if(is_file($_SERVER["DOCUMENT_ROOT"].$dir."/".$sub)) {
						$listDir[] = $dir."/".$sub;
					}elseif(is_dir($_SERVER["DOCUMENT_ROOT"].$dir."/".$sub)){
						//is directory
					}
				}
			}
			closedir($handler);
		}
		return $listDir;
	}*/

	public function getGeoIP($format = 'string', $field = ''){ //format: string, json
		$ip = $_SERVER['REMOTE_ADDR'];
		if(empty($ip)){
			return 'error';
		}else{
			//$result = file_get_contents("http://ipinfo.io/".$ip."/json");
			$ch = curl_init("http://ipinfo.io/".$ip."/json");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			if($format == 'json'){
				$result = json_decode($result);
				if($field != '' && $result){
					if(property_exists($result, $field)){
						return $result->{$field};
					}else{
						return 'error2';
					}
				}
			}else{
				return 'error3';
			}
			return $result;
		}
	}

	public function getURL(){
		if(
			(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
			|| (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https')
			|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		){
			$ssl_suffix = 's';
		}else{
			$ssl_suffix = '';
		}
		return "http{$ssl_suffix}://".$_SERVER['HTTP_HOST'].$this->getDirname($_SERVER['PHP_SELF']);
	}

	public function getURLDomain(){
		if(
			(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
			|| (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https')
			|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		){
			$ssl_suffix = 's';
		}else{
			$ssl_suffix = '';
		}
		return (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']) ? "http{$ssl_suffix}://".$_SERVER['HTTP_HOST'] : '';
	}

	public function getURLPage() {
		$pageURL = 'http';
		if(
			(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
			|| (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https')
			|| (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		){
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	public function getUserIP(){
		// Get real visitor IP behind CloudFlare network
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP)){
			$ip = $client;
		}elseif(filter_var($forward, FILTER_VALIDATE_IP)){
			$ip = $forward;
		}else{
			$ip = $remote;
		}

		return $ip;
	}

	public function isImage($pathName){
		$ext = substr(strrchr($pathName, '.'), 1);
		if(preg_match("/(" . implode("|", array("jpg", "jpeg", "gif", "png", "bmp")) . ")$/i", $ext)){
			return true;
		}elseif(!empty($value)){
			return false;
		}
	}

	public function isValidDate($date, $format = 'YYYY-MM-DD'){
		if(strlen($date) >= 8 && strlen($date) <= 10){
			$separator_only = str_replace(array('M','D','Y'),'', $format);
			$separator = $separator_only[0];
			if($separator){
				$regexp = str_replace($separator, "\\" . $separator, $format);
				$regexp = str_replace('MM', '(0[1-9]|1[0-2])', $regexp);
				$regexp = str_replace('M', '(0?[1-9]|1[0-2])', $regexp);
				$regexp = str_replace('DD', '(0[1-9]|[1-2][0-9]|3[0-1])', $regexp);
				$regexp = str_replace('D', '(0?[1-9]|[1-2][0-9]|3[0-1])', $regexp);
				$regexp = str_replace('YYYY', '\d{4}', $regexp);
				$regexp = str_replace('YY', '\d{2}', $regexp);
				if($regexp != $date && preg_match('/'.$regexp.'$/', $date)){
					foreach (array_combine(explode($separator,$format), explode($separator,$date)) as $key=>$value) {
						if ($key == 'YY') $year = '20'.$value;
						if ($key == 'YYYY') $year = $value;
						if ($key[0] == 'M') $month = $value;
						if ($key[0] == 'D') $day = $value;
					}
					if (checkdate($month,$day,$year)) return $date;
				}
			}
		}
		return '';
	}

	public function isValidateDateTime($dateStr, $format){  //isValidateDateTime('2001-03-10 17:16:18', 'Y-m-d H:i:s');
		//date_default_timezone_set('UTC');
		$date = DateTime::createFromFormat($format, $dateStr);
		return $date && ($date->format($format) === $dateStr);
	}

	public function isValidEmail($email){
		return preg_match("/^([A-Za-z0-9_\-\.\'])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/", $email);
		//return preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email);
	}

	public function isValidReferrer($referrer, $referrerArray, $debug = false){
		$valid = false;
		foreach($referrerArray as $value){
			if(strpos($referrer, $value) === 0){
				$valid = true;
				if($debug){
					echo $value;
					exit();
				}
				break;
			}
		}
		return $valid;
	}

	public function purifyCheck($input, $html = false){
		if(is_array($input)){
			$ary = array();
			foreach ($input as $k => $v) {
				array_push($ary, $this->purify($v, $html));
			}
			return $ary;
		}else{
			return $this->purify($input, $html);
		}
	}

	public function purify($input, $html = false){
		$result = "";
		if(isset($input) && !empty($input)){
			$result = rawurldecode($input);
			if($html) $result = strip_tags($result);
			$result = stripcslashes($result);
			$result = htmlspecialchars($result, ENT_QUOTES);
			$result = iconv('utf-8','utf-8//IGNORE',$result);
		}
		return $result;
	}

	public function randString($length=32, $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890'){
		$chars_length = (strlen($chars)-1);
		$string = $chars[rand(0, $chars_length)];
		for ($i=1; $i<$length; $i=strlen($string)){
			$r = $chars[rand(0, $chars_length)];
			if ($r != $string[$i-1]) $string .=  $r;
		}
		return $string;
	}

	public function randArray($arr = array(), $num = 1){
		if (!is_array($arr)) return false;
		$rand_keys = array_rand($arr, $num);
		if($num < 2){
			return $arr[$rand_keys];
		}else{
			$outputArray = array();
			for($i=0;$i<$num;$i++){
				array_push($outputArray, $arr[$rand_keys[$i]]);
			}
			return $outputArray;
		}
	}

	public function redirectHTTPS($needWWW = false){
		$pageURL = 'https://';
		$pagePort = '';
		if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") $pagePort = ':'.$_SERVER["SERVER_PORT"];
		if(@$_SERVER["HTTPS"] != "on"){
			if($needWWW){
				if(strpos($_SERVER['HTTP_HOST'], 'www.') !== false){
					$pageURL .= substr($_SERVER['SERVER_NAME'], 4).$pagePort.$_SERVER["REQUEST_URI"];
				}else{
					$pageURL .= 'www.'.$_SERVER['SERVER_NAME'].$pagePort.$_SERVER["REQUEST_URI"];
				}
			}else{
				$pageURL .= $_SERVER['SERVER_NAME'].$pagePort.$_SERVER["REQUEST_URI"];
			}
			return $pageURL;
		}
		return false;
	}

	public function redirectNonWWW(){
		$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
		if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443"){
			$pageURL .= substr($_SERVER['SERVER_NAME'], 4).":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}else{
			$pageURL .= substr($_SERVER['SERVER_NAME'], 4).$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	public function returnArray($assocArray, $key = 0){
		$output = array();
		if(count($assocArray)){
			foreach($assocArray as $tempArray){
				array_push($output, $tempArray[$key]);
			}
		}
		return $output;
	}

	public function returnAssocArray($arr, $offset0 = 0, $offset1 = ''){
		if(count($arr) > $offset0){
			return $arr[$offset0][$offset1];
		}else{
			return '';
		}
	}

	public function returnAssocArrayShuffle($arr) {
		if (!is_array($arr)) return $arr;

		$keys = array_keys($arr);
		shuffle($keys);
		$random = array();
		foreach ($keys as $key){
			$random[$key] = $arr[$key];
		}

		return $random;
	}

	public function returnData($var, $type = 'request', $default = ""){
		switch($type){
			case "get": $output = (isset($_GET[$var]))?$_GET[$var]:$default; break;
			case "post": $output = (isset($_POST[$var]))?$_POST[$var]:$default; break;
			case "request": $output = (isset($_REQUEST[$var]))?$_REQUEST[$var]:$default; break;
		}
		return $output;
	}

	public function returnDataNum($var, $type = 'request', $default = 0){
		switch($type){
			case "get": $output = (isset($_GET[$var]) && is_numeric($_GET[$var]))?$_GET[$var]:$default; break;
			case "post": $output = (isset($_POST[$var]) && is_numeric($_POST[$var]))?$_POST[$var]:$default; break;
			case "request": $output = (isset($_REQUEST[$var]) && is_numeric($_REQUEST[$var]))?$_REQUEST[$var]:$default; break;
		}
		return intval($output);
	}

	public function returnFileExtension($filename){
		$path_info = pathinfo($filename);
		return $path_info['extension'];
		//return substr(strrchr($file_name,'.'),1);  //old method
	}

	public function returnFileName($filename){
		$path_info = pathinfo($filename);
		return str_replace('.'.$path_info['extension'], '', $path_info['basename']);
	}
	
	public function sortAssocArray($ary, $key, $order = ''){
		//php 5.3+
		/*if ($item1['price'] == $item2['price']) return 0;
		if($order == 'asc')
			return $item1['price'] < $item2['price'] ? -1 : 1;
		}else{
			return $item1['price'] > $item2['price'] ? -1 : 1;
		}*/
		//php7+
		if($order == 'asc'){
			return $item1[$key] <=> $item2[$key];
		}else{
			return $item2[$key] <=> $item1[$key];
		}
	}
	
	public function stripEmptyPTag($s){
		$output = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $s);
		return $output;
	}

	public function renderResultJSON($message = '', $error_code = '', $result = 'f') 
    {
        $data['message'] = $message;
        $data['error_code'] = $error_code;
        $data['result'] = $result;
        return json_encode($data);
    }

	public function checkOverdue($dateString)
	{
		global $setting;

		// if no date value
		if(!$dateString) {
			return false;
		}
		
		// demo
		// $dateString = '2022-06-08 12:41:22';
		$targetDate = strtotime($dateString);
		$currentDate = strtotime('today');

		$daysDifference = floor(($currentDate - $targetDate) / (60 * 60 * 24));

		return ($daysDifference > $setting->CASH_REBATE_FORM_EXPIRED_DAY); // over 30 day
	}
}
?>
