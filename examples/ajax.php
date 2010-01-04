<?php
chdir('../');
include_once('app/inc/head.inc.php'); // include the core and engine

/* ****************************************************
*
*  Samstyle PHP Framework
*  Framework Examples
*  Created by: Sam Yong | Date/Time: 7:07am 3rd July 2009 GMT+8
*
**************************************************** */
$page = Page::getInstance();
$page->setTemplate('default.html');
$page->addRule('footer', 'app/blocks/footer.php');
$page->addRule('menubar', 'app/blocks/menubar.php');
$page->addRule('title', 'Samstyle.PHP | Examples | AJAX');
$page->addRule('approot', $_SITE['approot']);
$page->addRule('fwversion', $_SITE['fwver']);
$page->addRule('robots', 'index,follow');
$page->addRule('breadcrumb', 'Home &gt; Examples &gt; AJAX');

p(html::jsf('deck/ajax.php?genjs'));

p(html::js('function newUpdate(a){$("#updates").html("Latest Stable: <a href=\"http://code.google.com/p/samstyle-php-framework/downloads/list\">"+a.stable+"<"+"/a><b"+"r/>Current Development: "+a.dev);}$(function(){getVersions([],\'newUpdate\');});'));

p(html::tag('div','',array('id'=>'rbox')));
p(html::js('function showReply(a){document.getElementById("rbox").innerHTML = "Server reply: "+a.date+" "+a.time;}'));

p('<nlbr>'.html::tag('div','AJAX PHP function call<br/>'.html::tag('small','<a href="deck/ajax.php?f=AJAXCall&amp;p[]='.time().'&amp;p[]=0&amp;sh='.$session_hash.'">Actual Valid Call</a> | <a href="deck/ajax.php?f=AJAXCall&amp;p[]='.time().'&amp;p[]=0">Without Session</a> | <a href="#" onclick="AJAXCall([],\'showReply\');return false;">Javascript (AJAX)</a>'),array('style'=>'padding:50px 5px;font-size:140%;')).'</nlbr>');

p(html::c('Samstyle PHP Framework'));

echo $page->render()->output(); // output buffer