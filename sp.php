<?php
/* ****************************************************
*
*  Samstyle PHP Framework
*  Framework Javascript and Stylesheet Pre-processor
*  Created by: Sam Yong | Date/Time: 2:46pm 14th July 2009 GMT+8
*
**************************************************** */

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

if(!$types[$_GET['t']]){exit;}

header('Content-Type: '.$types[$_GET['t']]);

// checks whether to do client caching it or not
if(isset($_GET['cache'])){
header('Expires: '.gmdate('r',time()+(3600*24*30)));
header('Cache-Control: max-age=7800, must-revalidate');
header('ETag: '.dechex(crc32($_GET['s'])).'-'.substr(dechex(crc32($_SERVER['REQUEST_URI'])),-5));
}else{
header('Expires: '.gmdate('r',time()-(3600*24*30)));
header('Cache-Control: no-cache');
header('ETag: '.dechex(crc32($_GET['s'])).'-'.substr(dechex(crc32($_SERVER['REQUEST_URI'])),-5));
header('Last-Modified: '.gmdate('r'));
}

$folder = '';
switch($_GET['t']){
case 0:
$folder = 'styles/';
break;
case 1:
$folder = 'scripts/';
break;
}

// if wanna gzip
if(isset($_GET['g'])){
$acceptencoding = explode(',' ,$_SERVER['HTTP_ACCEPT_ENCODING']);
foreach($acceptencoding as $id=>$encode){$acceptencoding[$id] = trim($encode);}
 if(in_array('gzip',$acceptencoding)){ob_start('ob_gzhandler');header('Content-Encoding: gzip');} 
}

// initialize buffer
$buffer = '';

// outputs data. get all file names
$files = explode(';',$_GET['s']);
foreach($files as $f){
// do not allow slashes in filename
if(count(explode('/',$f)) > 1){$buffer.='// Err:Denied1'."\r\n";continue;}
if(strpos('.php',strtolower($f)) >0){$buffer.='// Err:Denied2'."\r\n";continue;}
$c = @file_get_contents($folder.basename($f));
if(!$c){$buffer.='// Err:Missing'."\r\n";continue;}
$buffer .= str_ireplace("\r\n","\n",$c);

}

// strip off comments
if(isset($_GET['c'])){
$regex = array('`\/\*(.*?)\*\/`ism'=>'','`^(\s|)([\/]{2})(.*?)[\n]`ism'=>'',"/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/"=>"\n","`\Z\t`is"=>'');
$buffer = preg_replace(array_keys($regex),$regex,$buffer);
}

// output buffer
echo $buffer;
?>