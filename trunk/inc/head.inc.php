<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}
/* *************************************************
*
*  head.inc.php
*  Samstyle PHP Framework
*  Framework Main Engine
*
************************************************* */

/* ************************************************
*   include configuration file
************************************************ */
$c = @include_once('inc/config.inc.php');

/* ************************************************
* check if maintenance mode. check first to reduce load
************************************************ */
if($_SITE['maintenance']){
  echo $_SITE['maintenance'];
  exit; // exit after displaying maintenance information
}


/* ************************************************
*   include all required components
************************************************ */
if(count($_includes)>0){
  foreach($_includes as $inc){@include_once($inc);}
}


/* ************************************************
*   setting session
************************************************ */
$dn = get_domain($_SITE['approot']);
if(strtolower($dn) == 'localhost'){$dn='';} // a fix around localhost for cookies.
session_set_cookie_params((time()+$_SITE['session_length']), '/',$dn,false,true);
session_start();
unset($dn);


/* ************************************************
*   setting out headers
************************************************ */
header('cache-control: no-cache');
header('pragma:no-cache');
header('Expires:'.gmdate('r',time()+(20)));
header('X-Powered-By: '.$_SITE['name'].' v'.$_SITE['ver']);
header('Copyright: '.$_SITE['copyright']);
header('Vary: Accept');
header('Content-Type: text/html; charset=utf-8');

/* ************************************************
*   Enabling GZIP or not?
************************************************ */
if($_SITE['enablegzip']==true){
$acceptencoding = explode(',' ,$_SERVER['HTTP_ACCEPT_ENCODING']);
foreach($acceptencoding as $id=>$encode){$acceptencoding[$id] = trim($encode);}
 if(in_array('gzip',$acceptencoding)){ob_start('ob_gzhandler');header('Content-Encoding: gzip');} 
}else{
while(ob_get_level()){ob_end_flush();}
if(ob_get_length()===false){ob_start();}
}

/* ************************************************
*   Connecting to MySQL Database with the login information
************************************************ */
if($_SITE['mysql_info']){
$link = @mysql_connect($_SITE['mysql_info']['s'],$_SITE['mysql_info']['u'],$_SITE['mysql_info']['p']);
if(!$link){
echo '<div class="err"><p>Connection Error<br/>Techincal Info: '.mysql_error().'</p></div>';
exit();
}else{
$_SITE['mysql_info']['connection'] = $link;
if(!@mysql_select_db($_SITE['mysql_info']['udb'])){
echo'<div class="err"><p>Technical Error<br/>Techincal Info: '.mysql_error().'</p></div>';
exit();
}
}
}

/* ************************************************
* security stuff
************************************************ */
 // a CRC32 hash of the current session ID. can be used for security check
$session_hash = dechex(crc32(session_id()));

if($_SITE['autoparsehttpargs']){
$post = parse_http_args($_POST);
$get = parse_http_args($_GET);
}else{
$post = &$_POST;
$get = &$_GET;
}



?>