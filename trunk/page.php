<?php
include_once('app/inc/head.inc.php'); // include the core and engine

/* ****************************************************
*
*  Samstyle PHP Framework
*  Framework Paging Example Page
*  Created by: Sam Yong | Date/Time: 11:11pm 21st July 2009 GMT+8
*
**************************************************** */

$_PAGE['title'] = 'Samstyle PHP Framework - Paging Example';


p(html::c('Samstyle PHP Framework - Paging Example'));

p('<div id="updates" style="float:right;text-align:right"></div>');
p(html::js('function newUpdate(a){document.getElementById("updates").innerHTML = "Latest Stable: <a href=\"http://code.google.com/p/samstyle-php-framework/downloads/list\">"+a.stable+"<"+"/a><br"+"/>Current Development: "+a.dev;}window.onload = function(){getVersions(new Array(),\'newUpdate\');};'));

p(html::tag('h1','Welcome to Samstyle PHP Framework'));
p(html::tag('p','Framework Version <$fwversion$> | Paging Example'));
p('<$block:menubar$>');

p('<div id="box">');
$cur = isset($_GET['p'])?(int)$_GET['p']:1;$total = 20;if(!$cur){$cur = 1;}
$arr = php::paging(url_route('pagingwithnumbers','%d'),$cur, $total); // do paging calcs

p(html::tag('div','The project homepage on Google Code is at<br/>'.html::tag('a','http://code.google.com/p/samstyle-php-framework/',array('href'=>'http://code.google.com/p/samstyle-php-framework/')),array('style'=>'padding-top:120px;font-size:140%;')));

p('<div style="padding-bottom:100px;padding-top:10px;">');
p('You are on page '.$cur.' of '.$total.' pages.<br/>');
/* do paging display */
foreach($arr as $a){
if(is_array($a)){
if($a[1]==$cur){p('<b>');}// bold number if is current page
p(html::link($a[0],''.$a[1].'')); // show link and number
if($a[1]==$cur){p('</b>');} // bold number if is current page
}else{
p($a); // is a "..."
}
p('&nbsp;');
}
/* do paging display */
p('</div>');

p('</div>');

p('<$block:footer$>');


include('app/inc/template.inc.php'); // process the buffer
echo $_PAGE['buffer']; // output buffer
?>