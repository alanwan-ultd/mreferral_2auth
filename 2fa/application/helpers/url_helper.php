<?php

class Url_helper {
    
    private $url, $request_url, $script_url, $lang;
    
    function __construct(){
		if (isset($_SERVER['HTTP_X_ORIGINAL_URL'])){  //IIS chinese character
			$this->request_url = $_SERVER['HTTP_X_ORIGINAL_URL'];
		}else{
			$this->request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		}
		$this->script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
        if($this->request_url != $this->script_url){
            $this->url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $this->script_url)) .'/', '', $this->request_url, 1), '/');
			//$this->url = strtok($this->url, "?#");  //remove query string and hash
			$this->url = parse_url($this->url, PHP_URL_PATH);
			if(!$this->url) $this->url = '';
		}//var_dump($this->url);
	}

	function base_url(){
		global $config;
		return $config['base_url'];
	}
	
	function getCurrentPath(){
		$endCharacter = (isset($this->getSegmentsAry()[0]) && $this->getSegmentsAry()[0] != '')?'/':'';
		$tempAry = $this->getSegmentsAry();
		return implode('/', $tempAry) . $endCharacter;
	}

	function getProtocol(){
		return (!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off'))?'https:':'http:';
	}
	
	function getSegmentsAry(){
		global $config;
		
		$url = $this->url;
		$segments = explode('/', $url);
		$segments = array_filter($segments, function($value) { return !is_null($value) && $value !== ''; });  //remove empty value in array
		
		//Get route or language at first element, except default language
		$this->lang = $config['lang_default'];
		if(count($segments)){
			if( array_key_exists(strtolower(current($segments)), $config['lang_arr']) && current($segments) != $config['lang_default'] ){
				$this->lang = strtolower(current($segments));
				array_shift($segments);
			}
		}
		
		return $segments;
	}
	
	function getLang(){
		return $this->lang;
	}

	function getUrl(){
		return $this->url;
	}
	
	function segment($seg){
		if(!is_int($seg)) return false;
		
		//$parts = explode('/', $this->url);
		$parts = $this->getSegmentsAry();
		return isset($parts[$seg]) ? $parts[$seg] : false;
	}
	
	function segmentPath($seg){
		if(!is_int($seg)) return false;
		
		//$parts = explode('/', $this->url);
		$parts = $this->getSegmentsAry();
		//return (count($parts) > 0) ? join('/', array_slice($parts, $seg)) : false;
		return (count($parts) > 0) ? join('/', array_slice($parts, $seg, 1)) : false;
	}
	
}

?>