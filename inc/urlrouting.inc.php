<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}
/* *************************************************
*
*  urlrouting.inc.php
*  Samstyle PHP Framework
*  URL routing table configuration file
*
************************************************* */

$_routingkey = '_urlrouting_';
//$_routingkey = false; // set $_routingkey to false to disable routing

$_routes = array();

$_routes['pagingwithnumbers'] = array(
'rewrite'=> 'page/$1',
'actual'=>'page.php?p=$1',
'params' => array('$1'=>'([0-9]+)')
);

$_routes['pagingwithoutnumbers'] = array(
'rewrite'=> 'page',
'actual'=>'page.php',
'params' => array()
);

?>