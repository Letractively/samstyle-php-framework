<?php
/* ****************************************************
*
*  Samstyle PHP Framework
*  Framework Javascript and Stylesheet Pre-processor
*  Created by: Sam Yong | Date/Time: 2:46pm 14th July 2009 GMT+8
*
**************************************************** */

include_once('app/inc/head.inc.php');

/*

GET Parameters:
  t - Can be 0 or 1: 0 is CSS, 1 is Javascript
  cache - if set, client-side caching will be done.
  s - a list of filenames delimited by ';'.
  c - if set, comments and formatting will be stripped off.

Usage in HTML code:

<script src="scripts/sp.php?t=1&amp;cache&amp;s=script1.js;script2.js;script5.js;jsscript.js" type="text/javascript"></script>
<!--
The above code compresses and combines 4 javascript files into as 1 file
this reduces number of requests to the server and thus decreasing load time
and increasing load speed.

cache parameter is set such that the script returns headers to browsers
for it to cache the data of this URL. useful if the scripts do not change that frequently.

when files are cached, browsers do not request for the same files again so that
it increases your loading speed.
-->

<link rel="stylesheet" type="text/css" href="css/sp.php?t=0&amp;s=theme.css;default.css;controls.css" />
<!--
same here,  the above code compresses and combines 3 CSS files into one file.
same rationale, it reduces number of requests to the server and thus decreasing load time and increasing load speed.

cache is not set here. thus everytime the browser would have to request from the server.
-->

WARNING:
Do not include this file from other PHP files: it will not work and
will only leave security vulnerabilities to your application.
*/

// possible type of files that can be processed
$types = array('text/css; charset=utf-8',
'text/javascript; charset=utf-8');

if(!isset($_GET['t']) || !isset($types[$_GET['t']])){exit;}

header('Content-Type: '.$types[$_GET['t']]);

// checks whether to do client caching it or not
if(isset($_GET['cache'])){
header('Expires: '.gmdate('r',time()+15552000));
header('Cache-Control: max-age=15552000');
header('ETag: '.dechex(crc32($_GET['s'])).'-'.substr(dechex(crc32($_SERVER['REQUEST_URI'])),-5));
header('Last-Modified: '.gmdate('r',10));
header('Expires-Active: On');
header('Pragma: ');
header('Vary: ');
}else{
header('Expires: '.gmdate('r',time()-15552000));
header('Cache-Control: no-cache');
header('ETag: '.dechex(crc32($_GET['s'])).'-'.substr(dechex(crc32($_SERVER['REQUEST_URI'])),-5));
header('Last-Modified: '.gmdate('r'));
header('Pragma: no-cache');
}

// initialize buffer
$buffer = '';
$id = 'sp'.dechex(crc32($_SERVER['QUERY_STRING']));

$tmpvar = '';
if(isset($_GET['cache']) && $tmpvar = cache_retrieve($id,1296000)){
$buffer = $tmpvar;
}

if($buffer == ''){
$folder = '';
switch($_GET['t']){
case 0:
$folder = 'styles/';
break;
case 1:
$folder = 'scripts/';
break;
}

// outputs data. get all file names
$files = explode(';',$_GET['s']);
foreach($files as $f){
// do not allow slashes in filename
if(count(explode('/',$f)) > 1){$buffer.='// Err:Denied1'."\r\n";continue;}
if(strpos('.php',strtolower($f)) >0){$buffer.='// Err:Denied2'."\r\n";continue;}
$c = @file_get_contents($folder.basename($f));
if(!$c){$buffer.='// Err:Missing'."\n";continue;}
$buffer .= $c;
}

if(isset($_GET['c'])){
if($_GET['t']==1){
$regex = array(
"`^([\t\s]+)`ism"=>'',
"`^\/\*(.+?)\*\/`ism"=>"",
"`([\n\A;]+)\/\*(.+?)\*\/`ism"=>"$1",
"`([\n\A;\s]+)//(.+?)[\n\r]`ism"=>"$1\n",
"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
);
$buffer = preg_replace(array_keys($regex),$regex,$buffer);
}else{
$regex = array(
"`^([\t\s]+)`ism"=>'',
"`([:;}{]{1})([\t\s]+)(\S)`ism"=>'$1$3',
"`(\S)([\t\s]+)([:;}{]{1})`ism"=>'$1$3',
"`\/\*(.+?)\*\/`ism"=>"",
"`([\n|\A|;]+)\s//(.+?)[\n\r]`ism"=>"$1\n",
"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
);
$buffer = preg_replace(array_keys($regex),$regex,$buffer);
}

$buffer = trim(str_ireplace("\r\n","\n",$buffer),"\r\n");
}

if(isset($_GET['cache'])){
cache_save($id,$buffer);
}
}

echo $buffer;