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
$_SITE = array();

/* Application name */
$_SITE['name'] = 'Samstyle Framework Test Application';

/* Application version */
$_SITE['ver'] = '1.0.0';

/* Framework version */
$_SITE['fwver'] = '1.3.2 Beta';

/* Copyright Information */
$_SITE['copyright'] = 'Copyright (c) Company 2009-'.gmdate('Y',strtotime('+1 year')).'. All Rights Reserved.';

/* MySQL login information: s - server; u - username; p - password; udb - default database/schema */
$_SITE['mysql_info'] = array('s'=>'mysql:host=localhost;dbname=dbapp','u'=>'root','p'=>'password');

/* Enable GZIP or not - boolean */
$_SITE['enablegzip'] = true;

 /* Application root URL - for use at base tag and referencing */
$_SITE['approot'] = 'http://localhost/ssphpfw/';

/* whether in https or not */
$_SITE['https'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off');

/* specify whether will auto parse HTTP arguments ($_GET or $_POST)
into $get and $post to prevent injection/XSS or other threats */
$_SITE['autoparsehttpargs'] = true;

/* the length of the session in seconds */
$_SITE['session_length'] = 36000;

/* website activity level, integer from 0 to 10 */
// 0 to use server detault
$_SITE['site_activity'] = 0;

/* maintenance mode - false or message string */
$_SITE['maintenance'] = false;
/* hint: you can use 'maintenance' from a static HTML file
    i.e. $_SITE['maintenance'] = file_get_contents('path/to/my.html');
*/

/* the website's default charset */
$_SITE['charset'] = 'utf-8';

/* the website's default timezone for Date time operations as well as database*/
$_SITE['timezone'] = 'GMT';
// supported timezones:
//    http://www.php.net/manual/en/timezones.php

/* the website's language */
$_SITE['language'] = 'en';

/* error handling settings */
$_SITE['error'] = array(
'level' => E_ALL & ~E_NOTICE,
'handler_func' => '',
'display'=>true,
'log'=>true,
'logfile' => 'error.log'
);
/* To disable error handling, set $_SITE['error'] to false */
/* error handling settings */


/* *************************************************
*
*  $_CONF
*  Configuration information, your configuration like API keys and so on
*
************************************************* */
$_CONF = array();

/* EXAMPLE
// $_CONF['fb_api'] = array('key'=>'39ab360839e0c5b858c69da01060e25','secret'=>'39ab360839e0c5b858c69da01060e25');
*  EXAMPLE */

/* *************************************************
*
*  $_PAGE
*  Page information
*
************************************************* */
$_PAGE = array();
$_PAGE['title'] = $_SITE['name'];
$_PAGE['keywords'] = '';
$_PAGE['description'] = '';
$_PAGE['header'] = '';
$_PAGE['logourl'] = '';
$_PAGE['filename'] = basename($_SERVER['PHP_SELF']);
$_PAGE['css'] = '';
$_PAGE['template'] = 'app/templates/default.html';
$_PAGE['content'] = '';
$_PAGE['buffer'] ='';
$_PAGE['footer'] = $_SITE['copyright'];
$_PAGE['robots'] = 'index,follow';
$_PAGE['blocks'] = array('menubar'=>'app/blocks/menubar.php','footer'=>'app/blocks/footer.php');


/* *************************************************
*
*  $_includes
*  files that will be included at head.inc.php
*  pathnames must be relative from the application root folder.
*
************************************************* */
$_includes = array(
'app/inc/page.inc.php',
'app/inc/library.inc.php',
'app/inc/urlrouting.inc.php',
'app/class/csrfprotect.class.php',
'app/class/dba.class.php',
'app/class/base.class.php',
'app/class/string.class.php',
'app/class/firebug.class.php',
'app/class/validate.class.php',
'app/class/lastformhandler.class.php',
'app/class/http.class.php',
'app/class/php.class.php',
'app/class/html.class.php',
'app/class/form.class.php',
'app/class/bit.class.php',
'app/class/pwd.class.php',
'app/class/limit.class.php',
'app/class/enum.class.php',
'app/class/rss.class.php',
'app/inc/func.inc.php',
'app/inc/cache.inc.php', // cache
'app/dao/settings.dao.php' // settings dao
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