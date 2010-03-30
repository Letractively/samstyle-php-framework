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

$_routes['deckaction'] = array(
'rewrite'=> 'deck/action/$1',
'actual'=>'deck/action.php?c=$1',
'params' => array('$1'=>'([a-zA-Z0-9]*)')
);

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

$_routes['examples-csrf'] = array(
'rewrite'=> 'examples/csrf-protection',
'actual'=>'examples/csrf.php',
'params' => array()
);

$_routes['examples-csrffail'] = array(
'rewrite'=> 'examples/csrf-fail',
'actual'=>'examples/csrf-fail.php',
'params' => array()
);


?>