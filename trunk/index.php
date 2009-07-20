<?php
include('inc/head.inc.php'); // include the core and engine

/* ****************************************************
*
*  Samstyle PHP Framework
*  Framework Welcome Page
*  Created by: Sam Yong | Date/Time: 7:07am 3rd July 2009 GMT+8
*
**************************************************** */

$_PAGE['title'] = 'Samstyle PHP Framework';

p(html::c('Samstyle PHP Framework'));

p(html::create('h1','Welcome to Samstyle PHP Framework'));
p(html::create('p','Version <$version$>'));

p('<$block:menubar$>');

p(html::create('p','The project homepage on Google Code is at<br/>'.html::create('a','http://code.google.com/p/samstyle-php-framework/',array('href'=>'http://code.google.com/p/samstyle-php-framework/')),array('style'=>'margin:120px 0;font-size:140%;')));
/* // old code: p('<p>The project homepage on Google Code is at <a href="http://code.google.com/p/samstyle-php-framework/">http://code.google.com/p/samstyle-php-framework/</a></p>'); */

p('<$block:footer$>');

p(html::c('Samstyle PHP Framework'));

include('inc/template.inc.php'); // process the buffer
echo $_PAGE['buffer']; // output buffer
?>