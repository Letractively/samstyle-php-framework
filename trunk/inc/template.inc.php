<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}
/* *************************************************
*
*  template.inc.php
*  Samstyle PHP Framework
*  Framework Template Parser
*
************************************************* */

$t=php::tmp_var($_PAGE['content']);
/* *********************************************
* new code for rendering blocks
********************************************** */
preg_match_all('`(<\$block\:)([a-zA-Z0-9]+)(\$>)`is', $$t, $arr, PREG_SET_ORDER); // find all block occurance in the file
foreach($arr as $m){
$block = $_PAGE['blocks'][$m[2]]; // get the block content from $_PAGE['block']
if($block==""){continue;} // continue if empty
if(strpos($block,'.php')>0 && @file_exists($block)){ // check if block is a file
$_PAGE['content'] = '';
@include($block);
$$t = str_replace($m[0],$_PAGE['content'],$$t);
}else{
$$t = str_replace($m[0],$block,$$t);
}
}

/* *********************************************
* new code for rendering blocks
********************************************** */
$_PAGE['content'] = $$t;
unset($$t);unset($t);

$template = @file_get_contents("templates/".basename($_PAGE['template']));

$_TEMPLATE = array(
'<$content$>'=>$_PAGE['content'],
'<$title$>'=>$_PAGE['title'],
'<$copyright$>' => $_SITE['copyright'],
'<$cssurl$>' => $_PAGE['css'],
'<$baseurl$>' => $_SITE['approot'],
'<$robots$>' => $_PAGE['robots'],
'<$header$>' => $_PAGE['header'],
'<$metarevisit$>' => '1',
'<$pagekeywords$>' => $_PAGE['keywords'],
'<$pagedescription$>' => $_PAGE['description'],
'<$logourl$>'=>$_PAGE['logourl'],
'<$content$>'=>$_PAGE['content'],
'<$version$>' => $_SITE['ver'],
'<$fwversion$>' => $_SITE['fwver'],
'<$footer$>' => $_PAGE['footer'],
'<$sitename$>' => $_SITE['name'],
'<$approot$>'=>$_SITE['approot'],
'<$sitelang$>'=>'en-gb',
'<$sessid$>' => session_id(),
'<$self$>' => $_SERVER['PHP_SELF']
);
$_PAGE['buffer'] = str_replace(array_keys($_TEMPLATE),$_TEMPLATE,$template);

/* /////// OLD BLOCK RENDERING CODE ///////// 
//foreach($_PAGE['blocks'] as $name => $block){
//if(@file_exists($block)){
//$content = '';
//@include($block);
//$_TEMPLATE['<$block:'.$name.'$>'] = str_ireplace(array_keys($_TEMPLATE),$_TEMPLATE,$content);
//}else{
//$_TEMPLATE['<$block:'.$name.'$>'] = str_ireplace(array_keys($_TEMPLATE),$_TEMPLATE,$block);
//}
//}
/////// OLD BLOCK RENDERING CODE ///////// */


/* *********************************************
* code for rendering custom html tags
********************************************** */

/* *****************************
*
* <nohtml> html codes </nohtml>
*  disable all html between the tags
*
***************************** */
preg_match_all('`(\<nohtml)([^\>]*)(\>)(.+?)(\<\/nohtml\>)`is', $_PAGE['buffer'], $arr, PREG_SET_ORDER);
foreach($arr as $m){
$_PAGE['buffer'] = str_replace($m[0],html::encode($m[4]),$_PAGE['buffer']);
}

/* *****************************
*
* <php> php codes </php>
*  highlights php codes in colour
*
***************************** */
preg_match_all('`(\<php)([^\>]*)(\>)(.+?)(\<\/php\>)`is', $_PAGE['buffer'], $arr, PREG_SET_ORDER);
foreach($arr as $m){
$_PAGE['buffer'] = str_replace($m[0],highlight_string($m[4],true),$_PAGE['buffer']);
}

/* *****************************
*
* <nlbr> string </nlbr>
*  converts all new line characters \n to <br/>
*
***************************** */
preg_match_all('`(\<nlbr)([^\>]*)(\>)(.+?)(\<\/nlbr\>)`is', $_PAGE['buffer'], $arr, PREG_SET_ORDER);
foreach($arr as $m){
$_PAGE['buffer'] = str_replace($m[0],nl2br($m[4]),$_PAGE['buffer']);
}

/* *********************************************
* code for rendering custom html tags
********************************************** */

?>