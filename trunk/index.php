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
$page->addRule('breadcrumb', 'Home');

p(html::jsf('deck/ajax.php?genjs'));

p(html::js('function newUpdate(a){document.getElementById("updates").innerHTML = "Latest Stable: <a href=\"http://code.google.com/p/samstyle-php-framework/downloads/list\">"+a.stable+"<"+"/a><b"+"r/>Current Development: "+a.dev;}window.onload = function(){getVersions([],\'newUpdate\');};'));

p('<nlbr>'.html::tag('div','Congratulations, you are now running on<br/>Samstyle PHP Framework {fwversion}','style="padding:50px 0;font-size:220%;text-align:center;"').'</nlbr>');

p(html::c('Samstyle PHP Framework'));

echo $page->render()->output(); // output buffer