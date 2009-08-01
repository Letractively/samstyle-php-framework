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

p(html::tag('h1','Welcome to Samstyle PHP Framework'));
p(html::tag('p','Framework Version <$fwversion$>'));

p('<$block:menubar$>');

p('<nlbr>'.html::tag('div','The project homepage on Google Code is at'."\n".html::tag('a','http://code.google.com/p/samstyle-php-framework/',array('href'=>'http://code.google.com/p/samstyle-php-framework/')),array('style'=>'margin:120px 0;font-size:140%;')).'</nlbr>');

p(html::tag('div','',array('id'=>'rbox')));
p(html::js('function showReply(a){document.getElementById("rbox").innerHTML = "Server reply: "+a.date+" "+a.time;}'));

p('<nlbr>'.html::tag('div','AJAX PHP function call<br/>'.html::tag('small','<a href="deck/ajax.php?f=AJAXCall&p[]='.time().'&amp;p[]=0&amp;sh='.$session_hash.'">Actual Valid Call</a> | <a href="deck/ajax.php?f=AJAXCall&p[]='.time().'&amp;p[]=0">Without Session</a> | <a href="#" onclick="AJAXCall(new Array(),\'showReply\');return false;">Javascript</a>'),array('style'=>'margin-bottom:120px;font-size:140%;')).'</nlbr>');

p('<$block:footer$>');

p(html::c('Samstyle PHP Framework'));

include('inc/template.inc.php'); // process the buffer
echo $_PAGE['buffer']; // output buffer
?>