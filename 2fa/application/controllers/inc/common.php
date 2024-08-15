<?php

$smarty->configLoad('common.conf');
$smarty->configLoad($lang . '.conf', $smartyConfSection);

//LANG
$smarty->assign('LANG', $lang);
if($lang == $config['lang_default']){
	$langFolder =  '';
}else{
	$langFolder =  $lang.'/';
}
$smarty->assign('LANG_FOLDER', $langFolder);
$smarty->assign('LANG_ARRAY', $config['lang_arr']);
$smarty->assign('LANG_DEFAULT', $config['lang_default']);

//PATH
$smarty->assign('HTML_PROTOCOL', $urlModel->getProtocol());
$smarty->assign('HTML_BASE', $config['base_url']);
$smarty->assign('CURRENT_LINK', $urlModel->getCurrentPath());
$smarty->assign('URL_CURRENT', $urlModel->segment(0));
$smarty->assign('URL_CURRENT_SEGMENT', $urlModel->segment(1));

//META
$smarty->assign('HTML_IMG', $config['base_url'].$smarty->getConfigVars('HTML_IMG'));

//OTHER
$staging_media = ($config['staging'])?'../':'';
$smarty->assign('MEDIA_FOLDER', $staging_media);
$smarty->assign('MIN_FOLDER', $config['minifyFolder']);
$smarty->assign('MIN_FILENAME', $config['minifyFile']);

//if have CMS, overwrite below

//if have CMS, overwrite below end

?>
