<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* *************************************************
*
*  menubar.php
*  Samstyle PHP Framework
*  Menubar block
*
************************************************* */

p('<ul class="menu">');
p('<li><a href="{approot}">Home</a></li>');
p('<li><a href="'.url_route('examples').'">Examples</a></li>');
p('<li><a href="http://code.google.com/p/samstyle-php-framework/" target="_blank">Project</a></li>');
p('<li><a href="http://thephpcode.blogspot.com/" target="_blank">thephpcode</a></li>');
p('</ul>');
