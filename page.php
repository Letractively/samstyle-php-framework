<?php
include('inc/head.inc.php'); // include the core and engine

/* ****************************************************
*
*  Samstyle PHP Framework
*  Framework Paging Example Page
*  Created by: Sam Yong | Date/Time: 11:11pm 21st July 2009 GMT+8
*
**************************************************** */

p(html::c('Samstyle PHP Framework - Paging Example'));

p(html::create('h1','Welcome to Samstyle PHP Framework'));
p(html::create('p','Version <$version$> | Paging Example'));

p('<$block:menubar$>');

$cur = (int)$_GET['p'];$total = 20;if(!$cur){$cur = 1;}
$arr = php::paging('page.php?p=%d',$cur, $total); // do paging calcs

p(html::create('div','The project homepage on Google Code is at<br/>'.html::create('a','http://code.google.com/p/samstyle-php-framework/',array('href'=>'http://code.google.com/p/samstyle-php-framework/')),array('style'=>'margin-top:120px;font-size:140%;')));

p('<div style="margin-bottom:100px;margin-top:10px;">');
p('You are on page '.$cur.' of '.$total.' pages.<br/>');
/* do paging display */
foreach($arr as $a){
if(is_array($a)){
if($a[1]==$cur){p('<b>');}// bold number if is current page
p(html::link($a[0],$a[1])); // show link and number
if($a[1]==$cur){p('</b>');} // bold number if is current page
}else{
p($a); // is a "..."
}
p('&nbsp;');
}
/* do paging display */
p('</div>');

p('<$block:footer$>');


include('inc/template.inc.php'); // process the buffer
echo $_PAGE['buffer']; // output buffer
?>