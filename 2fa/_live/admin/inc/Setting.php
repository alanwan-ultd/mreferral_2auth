<?php
header('P3P: CP="CAO PSA OUR"'); // fix ie iframe problem
define('SESSION_TIMEOUT_SECONDS', 60*45);
ini_set('session.gc_maxlifetime', SESSION_TIMEOUT_SECONDS);
session_start();

if(!defined('ROOT_DIR')){  //admin cms use
	define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
	date_default_timezone_set('Asia/Hong_Kong');  //Asia/Hong_Kong, America/New_York
}

class Setting{
	//website
	public $ROOT_DIR = '/2fa/';
	public $CMS_DIR = '/2fa/admin/';
	public $LANG = array('en' => array('EN'), 'tc' => array('繁'), 'sc' => array('简'));  //array('en' => array('EN'), 'tc' => array('繁'), 'sc' => array('简'))
	public $STAGING = true;
	public $LOCAL_TESTING = true;

	// for export file_get_content if any htacess password protect
	public $PAGE_PROTECT = false;
	public $PAGE_PROTECT_NAME = 'admin';
	public $PAGE_PROTECT_PASSWORD = 'Ult@123';
	
	//html
	public $HTML_TITLE = "TITLE";
	public $HTML_DESC = "DESC";
	public $HTML_KEYWORDS= "KEYWORDS";
	public $HTML_HEADER_IMG = '';
	
	//db
	public $DB_URL = "192.168.10.63";  //db, localhost
	public $DB_PORT = "3306";  //3306
	public $DB_USERNAME = "mreferraldb";  //root
	public $DB_PASSWORD = "jKy8e~{qK^B8`B9P";  //example, 123456
	public $DB_TABLE = "mreferral2020";  //mreferral, cms
	public $DB_PREFIX = '2fa_';  //mreferral2020_, cms2020_
	public $DB_NEED = true;
	
	//cms
	public $CMS_HTML_TITLE = "Content Management System (CMS)";
	public $CMS_HTML_DESC = "Content Management System (CMS)";
	public $CMS_HTML_KEYWORDS= "Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard";
	//public $CMS_HTML_HEADER_IMG = '';
	public $CMS_COMPANY_NAME = "mReferral Corporation (HK) Limited";
	public $CMS_COPYRIGHT_YEAR = "2024";
	public $CMS_ITEM_PAGE = 100;  //20
	public $CMS_LIVE_LINK = '/2fa/';
	public $CMS_CKEDITOR_LINK;
	public $CMS_CKFINDER_LINK;
	public $CMS_CKFINDER_OUTPUTLINK;
	
	//date
	public $D_TODAY;
	public $D_COMPARE;

	// google 2fa
	public $GOOGLE_2FA_SITE_NAME = 'Mreferral 2FA';
	public $GOOGLE_2FA_SITE_DOMAIN = 'www.mreferral.com';
	
	//mail
	public $MAIL_HOST = "smtp.gmail.com";
	public $MAIL_PORT = 587;
	public $MAIL_SMTP_SECURE = "tls"; //tls:587, ssl:465
	public $MAIL_SMTP_AUTH = true;
	public $MAIL_SMTP_USERNAME = "";
	public $MAIL_SMTP_PWD = "";
	public $MAIL_CONTACT_FROM = [
        'email'=>'test@test.com',
        'name'=>'test'
    ];
    public $MAIL_CONTACT_TO = [
        'email'=>'test@test.com',
        'name'=>'test'
    ];

	public $MAIL_CONTACT_TO_BCC = array(
		/*array(
			'email'=>'xxxx@xxxxx',
			'name'=>'xxxxxx'
		),
		array(
			'email'=>'xxxx@xxxxx',
			'name'=>'xxxxxx'
		)*/
  	);	
	
	public function __construct($dbNeed = true) {
		$this->DB_NEED = $dbNeed;
		$this->D_TODAY = new DateTime(date("Y-m-d H:i:s"));
		$this->CMS_COPYRIGHT_YEAR = date("Y");
	}
	
	public function cms($page){
		$this->CMS_ITEM_PAGE = $page;
		$this->CMS_CKEDITOR_LINK = $this->CMS_DIR.'lib/ckfinder3/3.5.1.1/';
		$this->CMS_CKFINDER_LINK = $this->ROOT_DIR.'media/';
		$this->CMS_CKFINDER_OUTPUTLINK = $this->ROOT_DIR.'media/';  //no need to input if use the root of $ckfinderLink, live folder use
		// $this->CMS_CKFINDER_OUTPUTLINK = '/media/';  //no need to input if use the root of $ckfinderLink, staging folder use
	}
	
	/*
	$day variable format
	$day = array(
		'p1'=>array('start'=>new DateTime('2015-01-01 10:00:00'), 'end'=>new DateTime('2015-01-01 10:00:00')),
		'p2'=>array('start'=>new DateTime('2015-12-31 10:00:00'), 'end'=>new DateTime('2015-12-31 23:59:59'))
	);
	*/
	public function day($day){
		$this->D_COMPARE = $day;
	}
	public function dayCompare($index, $period){
		return ($this->D_TODAY >= $this->D_COMPARE[$index][$period])?true:false;
	}
	
	public function setMail($email, $name){
		array_push($this->MAIL_CONTACT, array('email'=>$email, 'name'=>$name));
	}
}

?>