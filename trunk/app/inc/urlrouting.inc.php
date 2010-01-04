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

$_routes['examples'] = array(
'rewrite'=> 'examples/',
'actual'=>'examples/index.php',
'params' => array()
);

$_routes['examples-ajax'] = array(
'rewrite'=> 'examples/ajax',
'actual'=>'examples/ajax.php',
'params' => array()
);

$_routes['examples-fontreplace'] = array(
'rewrite'=> 'examples/fontreplace',
'actual'=>'examples/fontreplace.php',
'params' => array()
);

$_routes['examples-pagingwithnumbers'] = array(
'rewrite'=> 'examples/page/$1',
'actual'=>'examples/page.php?p=$1',
'params' => array('$1'=>'([0-9]+)')
);

$_routes['examples-pagingwithoutnumbers'] = array(
'rewrite'=> 'examples/page',
'actual'=>'examples/page.php',
'params' => array()
);

?>