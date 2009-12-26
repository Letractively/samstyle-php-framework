<?php
include_once('app/inc/head.inc.php'); // include the core and engine

/* ****************************************************
*
*  Samstyle PHP Framework
*  Framework Welcome Page
*  Created by: Sam Yong | Date/Time: 7:07am 3rd July 2009 GMT+8
*
**************************************************** */
$page = Page::getInstance();
$page->setTemplate('default.html');
$page->addRule('footer', 'app/blocks/footer.php');
$page->addRule('menubar', 'app/blocks/menubar.php');
$page->addRule('title', 'Samstyle PHP Framework');
$page->addRule('approot', $_SITE['approot']);
$page->addRule('fwversion', $_SITE['fwver']);
$page->addRule('robots', 'index,follow');

p(html::jsf('deck/ajax.php?genjs'));

p(html::c('Samstyle PHP Framework'));

p('<div id="updates" style="float:right;text-align:right"></div>');
p(html::js('function newUpdate(a){document.getElementById("updates").innerHTML = "Latest Stable: <a href=\"http://code.google.com/p/samstyle-php-framework/downloads/list\">"+a.stable+"<"+"/a><b"+"r/>Current Development: "+a.dev;}window.onload = function(){getVersions([],\'newUpdate\');};'));

p(html::tag('h1','Welcome to Samstyle PHP Framework'));
p(html::tag('p','Framework Version {fwversion}'));

p('{menubar}');

p('<div id="box">');
p('<nlbr>'.html::tag('div','Congratulations you have successfully run an application on Samstyle PHP Framework {fwversion}','style="padding:50px 0;font-size:220%;"').'</nlbr>');

p(html::tag('div','',array('id'=>'rbox')));
p(html::js('function showReply(a){document.getElementById("rbox").innerHTML = "Server reply: "+a.date+" "+a.time;}'));

p('<nlbr>'.html::tag('div','AJAX PHP function call<br/>'.html::tag('small','<a href="deck/ajax.php?f=AJAXCall&amp;p[]='.time().'&amp;p[]=0&amp;sh='.$session_hash.'">Actual Valid Call</a> | <a href="deck/ajax.php?f=AJAXCall&amp;p[]='.time().'&amp;p[]=0">Without Session</a> | <a href="#" onclick="AJAXCall([],\'showReply\');return false;">Javascript</a>'),array('style'=>'padding-bottom:120px;font-size:140%;')).'</nlbr>');

p('</div>');

p('{footer}');

p(html::c('Samstyle PHP Framework'));

echo $page->render()->output(); // output buffer
?>