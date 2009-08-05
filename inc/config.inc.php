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
/* Application name */
'name' => 'Samstyle Framework Test Application',

/* Application version */
'ver' => '1.0.0',

/* Framework version */
'fwver' => '1.2.8',

/* Copyright Information */
'copyright' => 'Copyright (c) Company 2008-'.gmdate('Y',strtotime('+1 year')).'. All Rights Reserved.',

/* MySQL login information: s - server; u - username; p - password; udb - default database/schema */
'mysql_info' => array('s'=>'localhost','u'=>'root','p'=>'password','udb'=>'dbapp','connection'=>null),

/* Enable GZIP or not - boolean */
'enablegzip'=>true,

 /* Application root URL - for use at base tag and referencing */
'approot'=>'http://localhost/ssphpfw/',

/* specify whether will auto parse HTTP arguments ($_GET or $_POST)
into $get and $post to prevent injection/XSS or other threats */
'autoparsehttpargs'=>true,

/* the length of the session in seconds */
'session_length' => 36000,

/* maintenance mode - false or message string */
'maintenance' => false,
/* hint: you can use 'maintenance' from a static HTML file
    i.e. 'maintenance'=>file_get_contents('path/to/my.html')
*/

/* whether or not to automatically register all PHP-JS enabled functions. boolean*/
'autoregisterjsfunction' => true
/* NOTE: only works when $_ajax is not set to false */
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
*  $_includes
*  files that will be included at head.inc.php
*
************************************************* */
$_includes = array(
'inc/library.inc.php',
'class/validate.class.php',
'class/http.class.php',
'class/php.class.php',
'class/html.class.php',
'class/form.class.php',
'class/bit.class.php',
'inc/func.inc.php',
'inc/dao.inc.php', // mysql DAO management
'inc/cache.inc.php', // cache
'dao/settings.dao.php' // settings dao
);
// $_includes = false; /* Set $_includes = false; to disable all includes for debugging */


/* *************************************************
*
*  $_ajax
*  information about the ajax deck
*
************************************************* */
$_ajax = array(

/*
*   $_ajax['callback'] is a string of the Javascript callback function to call
*/
'callback'=>'',

/*
*   $_ajax['func'] is an array of string which all are name of functions
*   which are allowed to call from Javascript. Functions not listed on this
*   list will be disabled.
*/
'func'=>array( 
'AJAXCall',
'getVersions'
),

/*
*   $_ajax['err'] is an array of error messages to display
*/
'err'=>array(
'funcNotFound'=>'{\'err\':\'Function not found or disabled.\'}',
'sessionFail'=>'{\'err\':\'Session is invalid.\'}',
'invalidRef'=>'{\'err\':\'Call was from a non-local domain.\'}'
),

/*
*   whether to check $get['sh'] against $session_hash to see
*   if calling from same session.
*/
'sessCheck'=>true,

/*
*   whether to check HTTP_REFERER against $_SITE['app_root'] to
*   see if call was from own domain or not.
*/
'refCheck'=>false

);
// $_ajax = false; /* Set $_ajax to false to disable AJAX to call PHP functions */

?>