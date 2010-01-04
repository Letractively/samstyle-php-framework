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
$page->addRule('breadcrumb', 'Home &gt; Examples');

p(html::jsf('deck/ajax.php?genjs'));

p(html::js('function newUpdate(a){$("#updates").html("Latest Stable: <a href=\"http://code.google.com/p/samstyle-php-framework/downloads/list\">"+a.stable+"<"+"/a><b"+"r/>Current Development: "+a.dev);}$(function(){getVersions([],\'newUpdate\');});'));

p('<ul class="example">');
p('<li><a href="'.url_route('examples-ajax').'">AJAX and PHP Function Calls</a><br/><span>Calling PHP functions directly from Javascript</span></li>');
p('<li><a href="'.url_route('examples-pagingwithoutnumbers').'">Pagination</a><br/><span>Easy pagination with our built-in function.</span></li>');
p('<li><a href="'.url_route('examples-fontreplace').'">fontreplace (FLIR)</a><br/><span>a technique based on sIFR and FLIR to display fonts dynamically in cases where the user does not have that particular font.</span></li>');
p('</ul>');

p(html::c('Samstyle PHP Framework'));

echo $page->render()->output(); // output buffer