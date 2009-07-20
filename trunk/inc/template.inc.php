<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}
/* *************************************************
*
*  template.inc.php
*  Samstyle PHP Framework
*  Framework Template Parser
*
************************************************* */

$t = dechex(crc32(mt_rand().time()));
$$t = $_PAGE['content'];
/* *********************************************
* new code for rendering blocks
********************************************** */
preg_match_all('`(<\$block\:)([a-zA-Z0-9]+)(\$>)`', $$t, $arr, PREG_SET_ORDER); // find all block occurance in the file
foreach($arr as $m){
$block = $_PAGE['blocks'][$m[2]]; // get the block content from $_PAGE['block']
if($block==""){continue;} // continue if empty
if(strpos($block,'.php')>0 && @file_exists($block)){ // check if block is a file
$_PAGE['content'] = '';
@include($block);
$$t = str_ireplace($m[0],$_PAGE['content'],$$t);
}else{
$$t = str_ireplace($m[0],$block,$$t);
}
}
/* *********************************************
* new code for rendering blocks
********************************************** */
$_PAGE['content'] = $$t;

$template = @file_get_contents($_PAGE['template']);
if($template !== false){
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
'<$footer$>' => $_PAGE['footer'],
'<$sitename$>' => $_SITE['name'],
'<$approot$>'=>$_SITE['approot'],
'<$sitelang$>'=>'en-gb',
'<$sessid$>' => session_id(),
'<$self$>' => $_SERVER['PHP_SELF']
);
$_PAGE['buffer'] = str_ireplace(array_keys($_TEMPLATE),$_TEMPLATE,$template);

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

}else{
echo 'Sorry, website currently unavailable. Please try again later.<br/>'."\r\n".'8<br/>'."\r\n".'Site: '.$_SITE['approot'];
exit;
}

?>