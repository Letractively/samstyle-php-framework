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
if(file_exists('app/inc/config.inc.php')){
    $c = include_once('app/inc/config.inc.php');
}else{
    // configuration file does not exists
    // do installation procedure
    $c = include_once('app/inc/installation.inc.php');
    exit;  
}

/* ************************************************
* timezone and datetime setting
************************************************ */
date_default_timezone_set($_SITE['timezone']);

/* ************************************************
*   set INI settings based on website activity
************************************************ */
ini_set('session.gc_divisor',100);
if($_SITE['site_activity'] > 0){
    ini_set('session.gc_probability',((11-$_SITE['site_activity'])/10 * 100));
}


/* ************************************************
* make sure that approot is added with a slash at the back
************************************************ */
if(substr($_SITE['approot'],-1) != '/'){
     $_SITE['approot'].='/';
}


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
    foreach($_includes as $inc){
        include($inc);
    }
    unset($inc);
}

/* ************************************************
*   setting session
************************************************ */

$dn = get_domain($_SITE['approot']);
if(strtolower($dn) == 'localhost'){$dn='';} // a fix around localhost for cookies.
session_name(dechex(crc32($_SITE['approot'])));
session_set_cookie_params($_SITE['session_length'],'/');
ini_set('session.gc_maxlifetime', $_SITE['session_length']);
ini_set('session.hash_function', '1'); // use SHA1 over MD5 for hashing session ID
$_sessstart = @session_start();
if(!$_sessstart){
  session_regenerate_id(true); // replace the Session ID
  session_start(); // restart the session (since previous start failed)
}
unset($dn);unset($_sessstart); // remove vars

/* ************************************************
*   setting out headers
************************************************ */
$page = Page::getInstance();
$page->addHeader('Cache-Control', 'no-cache');
$page->addHeader('Pragma', 'no-cache');
$page->addHeader('Expires', gmdate('r',time()+(20)));
$page->addHeader('X-Powered-By', $_SITE['name'].' v'.$_SITE['ver']);
$page->addHeader('Copyright', $_SITE['copyright']);
$page->addHeader('Vary', 'Accept');
$page->addHeader('Content-Type', 'text/html; charset='.$_SITE['charset']);
unset($page);

/* ************************************************
*   Enabling GZIP or not?
************************************************ */
if($_SITE['enablegzip']){
  ini_set('zlib.output_compression', '1');
}


/* ************************************************
*   Connecting to MySQL Database with the login information
************************************************ */
if($_SITE['mysql_info']){
    $dba = DBA::getInstance();
    $dba->connect($_SITE['mysql_info']['s'],$_SITE['mysql_info']['u'],$_SITE['mysql_info']['p']);
    unset($dba);
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

CSRFProtect::enable();

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
unset($route);

$urlparts = explode('?', preg_replace(array_keys($ur),$ur,$_GET[$_routingkey]));
unset($ur);
$file = array_shift($urlparts);
$query = implode('',$urlparts);
unset($urlparts);
unset($_GET[$_routingkey]);
$tmp = array();
parse_str($query,$tmp);
$_GET = array_merge($_GET,$tmp);

// emulation
$_SERVER['QUERY_STRING'] = http_build_query($_GET);
$_SERVER['PHP_SELF'] = dirname($_SERVER['PHP_SELF']).'/'.$file;
$dir = dirname($file);
if($dir != '' && $dir != '.'){
chdir($dir);
}
$ok = include(basename($file));
if(!$ok){header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');}
exit;

}elseif($_routingkey && $_routes){
// clean request URL
$_u = 'http';
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
$_u.='s';
}
$_u.='://'.$_SERVER['SERVER_NAME'].idx(parse_url($_SERVER['REQUEST_URI']),'path').(strpos($_SERVER['REQUEST_URI'],'?')!==false?'?'.idx(parse_url($_SERVER['REQUEST_URI']),'query'):'');
$_u = str_replace($_SITE['approot'],'',$_u);
foreach($_routes as $key => $route){
$s = '`^'.str_replace(array_keys($route['params']),$route['params'],str_replace(array('.','?','(',')','[',']'),array('\\.','\\?','\\(','\\)','\\[','\\]'),$route['actual'])).'$`is';

if(preg_match($s,$_u)){
$url = call_user_func_array('url_route',array_merge(array($key),$_GET));
redirect($url);
}
}
unset($_u);
unset($ur);
}

?>