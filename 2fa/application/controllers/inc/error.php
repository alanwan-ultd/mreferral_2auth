<?php
http_response_code(404);	//php 5.4 or above

$smarty->assign('CURRENT_LINK', '404/');
$smarty->assign('URL_CURRENT', '404/');
$smarty->assign('EXTRA_CSS', $this->getCSSTag('css/404'));
$smarty->assign('EXTRA_JS', '');

$smarty->display('error404.tpl');
exit();

?>