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
$page->addRule('breadcrumb', 'Home &gt; Examples &gt; fontreplace (FLIR)');

p(html::jsf('deck/ajax.php?genjs'));

p(html::js('function newUpdate(a){$("#updates").html("Latest Stable: <a href=\"http://code.google.com/p/samstyle-php-framework/downloads/list\">"+a.stable+"<"+"/a><b"+"r/>Current Development: "+a.dev);}$(function(){getVersions([],\'newUpdate\');});'));

p('<div class="replace" style="text-align:center;font-size:30px;color:#000;background:#FFF;margin:20px 10px;padding:10px;"><span>Text replaced as image with custom font.</span></div>');

p('fontreplace original release:<br /><a href="http://thephpcode.blogspot.com/2009/12/fontreplace-phpjquery-font-replacement.html" target="_blank">http://thephpcode.blogspot.com/2009/12/fontreplace-phpjquery-font-replacement.html</a>');

echo $page->render()->output(); // output buffer
