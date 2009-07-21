<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* *************************************************
*
*  menubar.php
*  Samstyle PHP Framework
*  Menubar block
*
************************************************* */

p(html::link('<$approot$>','AppRoot').' | '.html::link('<$approot$>page.php','Paging Example').' | '.html::link('http://code.google.com/p/samstyle-php-framework','Project Home').' | '.html::link('http://thephpcode.blogspot.com','thephpcode'));
p('<hr/>');

?>