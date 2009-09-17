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
$stable = php::idx(php::str_between($text, '<strong>Current Stable Version: Samstyle PHP Framework ', '</strong>'),0);
$dev = php::idx(php::str_between($text, 'Current development version: <strong>', '</strong>'),0);
return json_encode(array('stable'=>$stable,'dev'=>$dev));
}



?>