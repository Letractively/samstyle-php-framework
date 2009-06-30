<?php

if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

$c = @include_once('inc/config.inc.php');

// include all required components
if(count($includes)>0){
foreach($includes as $inc){@include_once($inc);}
}

// setting session
session_set_cookie_params((time()+36000), '/',$_SITE['domain_name'],false,true);
session_start();

// setting out headers
header('cache-control: no-cache');
header('pragma:no-cache');
header('Expires:'.gmdate('r',time()+(20)));
header('X-Powered-By: '.$_SITE['name'].' v'.$_SITE['ver']);
header('Copyright: '.$_SITE['copyright']);
header('Vary: Accept');
header('Content-Type: text/html; charset=utf-8');

// check for enable gzip
if($_SITE['enablegzip']==true){
$acceptencoding = explode(',' ,$_SERVER['HTTP_ACCEPT_ENCODING']);
foreach($acceptencoding as $id=>$encode){$acceptencoding[$id] = trim($encode);}
 if(in_array('gzip',$acceptencoding)){ob_start('ob_gzhandler');header('Content-Encoding: gzip');} 
}else{
while(ob_get_level()){ob_end_flush();}
if(ob_get_length()===false){ob_start();}
}

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

// create a session hash for security usage.
$session_hash = dechex(crc32(session_id()));
?>