<?php
$link = $_SERVER['REQUEST_URI'];
$link = explode('/', $link);
$valid = $link[count($link)-1];
$validArray = explode('?', $valid);  //remove query string
$valid = $validArray[0];
$search_array = array('', 'index.php','login.php','login.php?status=f','login.php?status=e', '404.php');

if(isset($name)){
    $sectionModel = new Section($name, (isset($group))?$group:'');
    $sectionPermission = $sectionModel->getPermissionBySection($name);
    $mySection = $sectionModel->run();
    if(isset($_SESSION['groupId']) && $_SESSION['groupId'] > 0){  //not login
		//var_dump($sectionPermission);//exit();
		if(!$sectionModel->checkCanView($sectionPermission)){  //all permissions are 0, read write, approve
			if(isset($sectionPermissionByPass) && $sectionPermissionByPass === true
				&& isset($_SESSION['id']) && $_SESSION['id'] == $util->returnDataNum('id', 'request')
			){
				//admin_edit.php for same id user
			}elseif($mode == 'js'){
				//xxx_edit.php mode is "js"
			}else{
				echo renderPermissionLogin(); exit();
			}
		}else if($mySection === false){
			echo 'Error: no this section.'; exit();
		}
    }else{
        echo renderPermissionLogin(); exit();
    }

}else{
    $checkingSearchResult = array_search($valid, $search_array);
    if($checkingSearchResult == 0 || $checkingSearchResult == 1){
        if(isset($_SESSION['id']) && intval($_SESSION['id']) > 0){
            //do nothing
        }else{  //login fail or no session
            header('Location: '.$setting->CMS_DIR.'login.php?status=f'); exit();
        }
    }elseif($checkingSearchResult >= 2){  //login page
        //do nothing
    }else{
        header('Location: '.$setting->CMS_DIR.'login.php?status=e'); exit();
    }
}
?>
