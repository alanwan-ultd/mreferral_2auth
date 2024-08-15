<?php
function changeLangURL($arg = null){
    $output = '?';
    foreach($_GET as $key => $value){
        $output .= ($output!='?')?'&':'';
        if($arg=='en' && $key=='lang'){
            $output .= $key.'=en';
		}elseif ($arg=='es' && $key=='lang'){
            $output .= $key.'=es';
		}elseif ($arg=='sc' && $key=='lang'){
            $output .= $key.'=sc';
		}elseif ($arg=='tc' && $key=='lang'){
            $output .= $key.'=tc';
		}else{
            $output .= $key.'='.$value;
		}
    }
    if(!strstr($output, 'lang')){
        $output .= ($output!='?')?'&lang='.$arg:'lang='.$arg;
    }
    return $output;
}

function dateFormat($date, $type = 0){
    switch($type){
        case 1: return date('d.m.Y', strtotime($date)); break;
        case 2: return date('F d, Y', strtotime($date)); break;
        case 3: return date('d F, Y', strtotime($date)); break;
        case 4: return date('Y-m-d H:i:s', strtotime($date)); break;
        default: return date('d.m.Y', strtotime($date));
    }
    //return date('F d ,Y @g:ha', strtotime($date));
}

function getCMSPermission($db, $loginGroupId, $cat){
    global $setting, $section;
    //$section; //form sectionSetup.php
    if($db == null){
        if(!isset($section[$cat]['permission'])){
            return array(1,1,1); //read, write, approve
        }else{
            return $section[$cat]['permission'][$loginGroupId];
        }
    }else{
        $rst = $db->select($setting->DB_PREFIX."section_permission", "section=:section AND adminuser_groupId=:gid AND status='A' AND deleted='N'"
        , array(':section'=>$cat, ':gid'=>$loginGroupId)
        , "*");
        
        //echo $db->getSql();
        if($rst != false && count($rst) > 0){
            foreach ($rst as $row){
                return array(intval($row['read_']),intval($row['write_']),intval($row['approve_'])); //read, write, approve
            }
        }else{
            return array(0,0,0); //read, write, approve
        }
    }
}

function getCMSPermissionList($db, $cat){
    global $setting, $section;
    //$section; //form sectionSetup.php
    if($db == null){
        return array(
            1 => array(1,1,1)  //read, write, approve
        );
    }else{
        $rst = $db->select($setting->DB_PREFIX."section_permission", "section=:section AND status='A' AND deleted='N' ORDER BY adminuser_groupId ASC"
        , array(':section'=>$cat)
        , "*");
        
        //echo $db->getSql();
        $output = array();
        if($rst != false && count($rst) > 0){
            foreach ($rst as $row){
                $output[$row['adminuser_groupId']] = array(intval($row['read_']),intval($row['write_']),intval($row['approve_']));  //read, write, approve
            }
            return $output;
        }else{
            return array(
                1 => array(1,1,1)  //read, write, approve
            );
        }
    }
}

/*function getCurrentSection(){
    $section = 'index';
    if(stripos($_SERVER["REQUEST_URI"], "index") || substr($_SERVER["REQUEST_URI"], -1, 1) == "/"){
        $section = 'index';
    }elseif(stripos($_SERVER["REQUEST_URI"], "about")){
        $section = 'about';
    }elseif(stripos($_SERVER["REQUEST_URI"], "articles")){
        $section = 'articles';
    }elseif(stripos($_SERVER["REQUEST_URI"], "contact")){
        $section = 'contact';
    }
    return $section;
}*/
function getCurrentSection($index){
    global $pageArray;
    $temp = array_keys($pageArray);
    return $temp[$index];
}

function getTagContent($attr = 'id', $value = '', $html = false) {
    if($html == false || $html == '') return '';
    $attr = preg_quote($attr);
    $value = preg_quote($value);
    $tagRegex = "/<div[^>]*".$attr."=\"".$value."\">(.*?)<\\/div><!--/si";
    
    if(preg_match($tagRegex, $html, $matches)){
        return $matches[1];
    }else{
        return '';
    }
}

function returnSEOText($s){
    $s = str_replace("_", "-", $s);
    $s = str_replace(" ", "-", $s);
    return $s;
}

  
?>