<?php
chdir('../');
include('inc/head.inc.php'); // include the core and engine

/* ****************************************************
*
*  Samstyle PHP Framework
*  Deck AJAX Controller/Handler
*  Created by: Sam Yong | Date/Time: 10:44am 30 June 2009 GMT+8
*
**************************************************** */
 
if(!$_ajax){exit;} // end if AJAX is false;

/* ****************************
*
* file GET params
*    sh - the session hash you get with $session_hash
*    f - the name of the PHP function
*
**************************** */

/*
*   check security session if required
*/
if($_ajax['sessCheck'] && $get['sh']!=$session_hash){
   p($_ajax['err']['sessionFail']);
}else{

/*
*   check if call was from own domain
*/
if($_ajax['refCheck'] && http::domain($_SERVER['HTTP_REFERER'])!=http::domain($_SITE['approot'])){
   p($_ajax['err']['invalidRef']);
}else{

$func = $get['f'];
/*
*   check if function name allowed
*/
if(!in_array($func,$_ajax['func'])){
   p($_ajax['err']['funcNotFound']);
}else{
   $p = $get['p'];
   if(!isset($get['p'])){
      $p = array();
   }
   if(!is_array($p)){
      $p = array($p);
   }
   $ret = call_user_func_array($func, $p);
   p($ret);

}
}
}

if($_ajax['callback']){echo $_ajax['callback'].'(';}
echo $_PAGE['content']; // output buffer from $_PAGE['content'] only
if($_ajax['callback']){echo ');';}
/* reason being that we do not want to render template into it */
?>