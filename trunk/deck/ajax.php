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

$_PAGE['content']='';
if(isset($_GET['genjs'])){

header('Content-Type: text/javascript; charset=utf-8');
header('Expires: '.gmdate('r',time()+15552000));
header('Cache-Control: max-age=15552000');
header('ETag: '.dechex(crc32('genjs')).'-'.substr(dechex(crc32($_SERVER['REQUEST_URI'])),-5));
header('Last-Modified: '.gmdate('r',10));
header('Pragma: public');

p('/* Generated with Samstyle PHP Framework */');
p('var __d=document; var __h = __d.getElementsByTagName("head").item(0); function sc(a,b){var s = __d.createElement("script");s.setAttribute("src", a);s.id=b||"";__h.appendChild(s);}');
p('function ats(a){var s="";var v = new Array();for(b in a){v[v.length]="p[]="+escape(b);}s=v.join("&");if(typeof s == "undefined"){s = ""}return s;}');
foreach($_ajax['func'] as $func){
p('function '.$func.'(a,c){if(a==null||c==""){return;}var s=ats(a);sc("'.$_SITE['approot'].'deck/ajax.php?f='.$func.'"+(s!=""?"&"+s:"")+"'.($_ajax['sessCheck']?'&sh='.$session_hash:'').'&callback="+escape(c),"'.$func.'");}');
}

echo $_PAGE['content']; // output buffer from $_PAGE['content'] only
/* reason being that we do not want to render template into it */

}else{

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
if(isset($get['p'])){
   $p = $get['p'];
   if(!isset($get['p'])){
      $p = array();
   }
   if(!is_array($p)){
      $p = array($p);
   }
}else{
   $p = array();
}
   $ret = call_user_func_array($func, $p);
   p($ret);
}
}
}


if(isset($get['callback'])){echo html::encode($get['callback']).'(';}elseif($_ajax['callback']){echo $_ajax['callback'].'(';}
echo $_PAGE['content']; // output buffer from $_PAGE['content'] only
if(isset($get['callback'])){echo ');';}elseif($_ajax['callback']){echo ');';}
/* reason being that we do not want to render template into it */
}

?>