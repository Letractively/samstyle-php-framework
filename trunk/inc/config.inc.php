<?php

if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

$_SITE = array(
'name' => 'Samstyle Application',
'ver' => '1.0.0',
'domain_name' => '',
'copyright' => 'Copyright (c) CompanyName 2008-'.gmdate('Y',strtotime('+1 year')).'. All Rights Reserved.',
// 'mysql_info' => array('s'=>'localhost','u'=>'root','p'=>'password','udb'=>'table','connection'=>null),
'enablegzip'=>true,
'approot'=>'http://localhost/s2s/'
);

$_PAGE = array(
'title' => $_SITE['name'],
'keywords' => '',
'description' => '',
'header' => '',
'logourl' => '',
'filename' => basename($_SERVER['PHP_SELF']),
'css' => '',
'template' => 'templates/default.html',
'content' => '',
'buffer' =>'',
'footer' => $_SITE['copyright'],
'robots' => 'index,follow',
blocks => array('memberbar'=>'blocks/memberbar.php','menubar'=>'blocks/menubar.php','footer'=>'blocks/footer.php')
);

$includes = array(
'inc/functions.inc.php'
);

?>