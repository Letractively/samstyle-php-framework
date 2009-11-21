<?php
chdir('../');
include('app/inc/head.inc.php'); // include the core and engine

/* ****************************************************
*
*  Samstyle PHP Framework
*  Deck Data Controller - for handling all form post and get request and handling DB access
*  Created by: Sam Yong | Date/Time: 10:44am 30 June 2009 GMT+8
*
**************************************************** */
$c = $_GET['c'];
if(!validate::alnum($c)){exit;}
if(!file_exists($controller = 'app/controller/'.$c.'.ctrl.php')){exit;}

include($controller);

?>