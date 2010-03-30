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
$page->addRule('title', 'Samstyle.PHP | Examples | CSRF Protection');
$page->addRule('approot', $_SITE['approot']);
$page->addRule('fwversion', $_SITE['fwver']);
$page->addRule('robots', 'index,follow');
$page->addRule('breadcrumb', 'Home &gt; Examples &gt; CSRF Protection &gt; Denied Example');

p(html::jsf('deck/ajax.php?genjs'));

CSRFProtect::disable();

p(html::js('function newUpdate(a){$("#updates").html("Latest Stable: <a href=\"http://code.google.com/p/samstyle-php-framework/downloads/list\">"+a.stable+"<"+"/a><b"+"r/>Current Development: "+a.dev);}$(function(){getVersions([],\'newUpdate\');});'));

p('<div class="pad5">The following form emulates an external cross-site request forgery (CSRF) form. This form has no token and will be denied when requesting to the controller that only <a href="'.url_route('examples-csrf').'">this form</a> has access to. </div>');

p('<form method="post" action="'.url_route('deckaction','csrfexample').'">Please enter your name: <input type="text" name="nme" /><input type="submit" value="Go" /></form>');

p(html::c('Samstyle PHP Framework'));

echo $page->render()->output(); // output buffer