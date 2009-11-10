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
$c = include_once('inc/config.inc.php');


/* ************************************************
* make sure that approot is added with a slash at the back
************************************************ */
if(substr($_SITE['approot'],-1) != '/'){$_SITE['approot'].='/';}


/* ************************************************
* error setting
************************************************ */
if(isset($_SITE['error'])&&is_array($_SITE['error'])){
$err = $_SITE['error'];
error_reporting($err['level']);
ini_set('display_errors',$err['display']?'on':'off');
ini_set('log_errors',$err['log']?'on':'off');
ini_set('error_log',$err['logfile']);
if($err['handler_func']!=''){
set_error_handler($err['handler_func']);
}
}else{
error_reporting(0);
ini_set('display_errors','off');
ini_set('log_errors','off');
}


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
  foreach($_includes as $inc){include_once($inc);}
}


/* ************************************************
*   setting session
************************************************ */
$dn = get_domain($_SITE['approot']);
if(strtolower($dn) == 'localhost'){$dn='';} // a fix around localhost for cookies.
session_name(dechex(crc32($_SITE['approot'])));
session_set_cookie_params($_SITE['session_length'],'/');
ini_set('session.gc_maxlifetime', $_SITE['session_length']);
$_sessstart = @session_start();
if(!$_sessstart){
  session_regenerate_id(true); // replace the Session ID
  session_start(); // restart the session (since previous start failed)
}
unset($dn);unset($_sessstart); // remove vars

/* ************************************************
*   setting out headers
************************************************ */
header('Cache-Control: no-cache');
header('Pragma: no-cache');
header('Expires: '.gmdate('r',time()+(20)));
header('X-Powered-By: '.$_SITE['name'].' v'.$_SITE['ver']);
header('Copyright: '.$_SITE['copyright']);
header('Vary: Accept');
header('Content-Type: text/html; charset='.$_SITE['charset']);


/* ************************************************
*   Enabling GZIP or not?
************************************************ */
if($_SITE['enablegzip']){
  if(!ob_start("ob_gzhandler")){
    ob_start();
  }
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


/* ************************************************
* whether auto register php-js enabled functions or not
************************************************ */
if($_ajax && $_SITE['autoregisterjsfunction']){
p(html::jsf('deck/ajax.php?genjs'));
}


/* ************************************************
* URL routing
************************************************ */

if($_routingkey && isset($_GET[$_routingkey]) && $_routes){

$ur = array(
'`/$`' => '' // remove trailing slash
);
foreach($_routes as $route){
$ur['`^'.str_replace(array_keys($route['params']),$route['params'],$route['rewrite']).'$`'] = $route['actual'];
}

$urlparts = explode('?', preg_replace(array_keys($ur),$ur,$_GET[$_routingkey]));
unset($ur);
$file = array_shift($urlparts);
$query = implode('',$urlparts);
unset($urlparts);
unset($_GET[$_routingkey]);
$tmp = array();
parse_str($query,$tmp);
$_GET = array_merge($_GET,$tmp);
$ok = @include_once($file);
if(!$ok){header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');}
exit;

}elseif($_routingkey && $_routes){

foreach($_routes as $key => $route){
$s = '`'.str_replace(array_keys($route['params']),$route['params'],str_replace(array('.','?','(',')','[',']'),array('\\.','\\?','\\(','\\)','\\[','\\]'),$route['actual'])).'$`is';

if(preg_match($s,$_SERVER['REQUEST_URI'])){
$url = call_user_func_array('url_route',array_merge(array($key),$_GET));
redirect($url);
}
}

}

?>