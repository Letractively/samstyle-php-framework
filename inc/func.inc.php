<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* *************************************************
*
*  func.inc.php
*  Samstyle PHP Framework
*  Custom Functions Library
*
************************************************* */

// TODO: Enter all your custom functions below in this file.

/* ================================
AJAXCall() function
  Example function for the ajax deck
================================ */
function AJAXCall($t = false,$timeonly = false){
if(!$t){$t = time();}
if($timeonly){
return json_encode(array('time'=>gmdate('h:i a',$t)));
}
return json_encode(array('date'=>gmdate('jS F Y',$t),'time'=>gmdate('h:i a',$t)));
}

/* ================================
getVersions() function
  checking new versions from Google Code project homepage
================================ */
function getVersions(){
$text = file_get_contents('http://code.google.com/p/samstyle-php-framework/');
$stable = php::idx(return_between($text, '<strong>Current Stable Version: Samstyle PHP Framework ', '</strong>'),0);
$dev = php::idx(return_between($text, 'Current development version: <strong>', '</strong>'),0);
return json_encode(array('stable'=>$stable,'dev'=>$dev));
}

/* ================================
return_between() function
  custom function for getting version number
================================ */
function return_between($string, $start, $stop){
    $st = $string;
    $list = array();
    $sl = strlen($start);
    for($i=0;$i<strlen($string);$i++){
        $temp = strpos($st, $start);
        $str = substr($st, $temp+$sl);
        $split_here = strpos($str, $stop);
        $parsed_string = substr($str, 0, $split_here);
        if($parsed_string == '')
            break;
        $st = substr($str, $split_here+1);
        $list[] = $parsed_string;
    }
    return $list;
}


?>