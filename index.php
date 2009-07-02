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
p('<h1>Welcome to Samstyle PHP Framework</h1>');
p('<p>Version <$version$></p>');

p('<p>The project homepage on Google Code is at <a href="http://code.google.com/p/samstyle-php-framework/">http://code.google.com/p/samstyle-php-framework/</a></p>');


include('inc/template.inc.php'); // process the buffer
echo $_PAGE['buffer']; // output buffer
?>