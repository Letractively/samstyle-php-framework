<?php
chdir('../');
include_once('app/inc/head.inc.php'); // include the core and engine

/* ****************************************************
*
*  Samstyle PHP Framework
*  Framework Examples
*  Created by: Sam Yong | Date/Time: 11:11pm 21st July 2009 GMT+8
*
**************************************************** */

$page = Page::getInstance();
$page->setTemplate('default.html');
$page->addRule('footer', 'app/blocks/footer.php');
$page->addRule('menubar', 'app/blocks/menubar.php');
$page->addRule('title', 'Samstyle PHP Framework - Paging Example');
$page->addRule('fwversion', $_SITE['fwver']);
$page->addRule('approot', $_SITE['approot']);
$page->addRule('robots', 'index,follow');
$page->addRule('breadcrumb', 'Home &gt; Examples &gt; Pagination');

p(html::jsf('deck/ajax.php?genjs'));

p(html::js('function newUpdate(a){$("#updates").html("Latest Stable: <a href=\"http://code.google.com/p/samstyle-php-framework/downloads/list\">"+a.stable+"<"+"/a><b"+"r/>Current Development: "+a.dev);}$(function(){getVersions([],\'newUpdate\');});'));

$cur = isset($_GET['p'])?(int)$_GET['p']:1;$total = 20;if(!$cur){$cur = 1;}
$arr = php::paging(url_route('examples-pagingwithnumbers','%d'),$cur, $total); // do paging calcs

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


echo $page->render()->output(); // output buffer
