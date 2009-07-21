<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}
/* *************************************************
*
*  config.inc.php
*  Samstyle PHP Framework
*  Framework Configuration
*
************************************************* */

/* *************************************************
*
*  $_SITE
*  Website information: Application name, Version, Copyright,
*  	MySQL information, GZip, application root
*
************************************************* */
$_SITE = array(
'name' => 'Samstyle Framework Test Application',
/* Application name */

'ver' => '1.2.1',
/* Application version */

'copyright' => 'Copyright (c) Sam Yong 2008-'.gmdate('Y',strtotime('+1 year')).'. All Rights Reserved.',
/* Copyright Information */

'mysql_info' => array('s'=>'localhost','u'=>'root','p'=>'password','udb'=>'dbapp','connection'=>null),
/* MySQL login information */

'enablegzip'=>true,
/* Enable GZIP or not */

'approot'=>'http://localhost/ssphpfw/',
 /* Application root URL - for use at base tag and referencing */

'autoparsehttpargs'=>true 
/* specify whether will auto parse HTTP arguments ($_GET or $_POST)
into $get and $post to prevent injection/XSS or other threats */
);

/* *************************************************
*
*  $_PAGE
*  Page information
*
************************************************* */
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
blocks => array('menubar'=>'blocks/menubar.php','footer'=>'blocks/footer.php')
);

/* *************************************************
*
*  $includes
*  files that will be included
*
************************************************* */
$includes = array(
'inc/library.inc.php',
'class/validate.class.php',
'class/http.class.php',
'class/php.class.php',
'class/html.class.php',
'inc/func.inc.php',
'inc/dao.inc.php', // mysql DAO management
'inc/cache.inc.php' // cache
);

?>