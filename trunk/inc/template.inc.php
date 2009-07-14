<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}
/* *************************************************
*
*  template.inc.php
*  Samstyle PHP Framework
*  Framework Template Parser
*
************************************************* */

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

/* /////// OLD BLOCK RENDERING CODE ///////// 
foreach($_PAGE['blocks'] as $name => $block){
if(@file_exists($block)){
$content = '';
@include($block);
$_TEMPLATE['<$block:'.$name.'$>'] = str_ireplace(array_keys($_TEMPLATE),$_TEMPLATE,$content);
}else{
$_TEMPLATE['<$block:'.$name.'$>'] = str_ireplace(array_keys($_TEMPLATE),$_TEMPLATE,$block);
}
}
/////// OLD BLOCK RENDERING CODE ///////// */

/* *********************************************
* code for rendering blocks
********************************************** */
$_PAGE['buffer'] = str_ireplace(array_keys($_TEMPLATE),$_TEMPLATE,$template);
preg_match_all('`(<\$block\:)(.*[^ -/$.&*])(\$>)`', $_PAGE['buffer'], $arr, PREG_SET_ORDER); // find all block occurance in the file
foreach($arr as $m){
$block = $_PAGE['blocks'][$m[2]]; // get the block content from $_PAGE['block']
if($block==""){continue;} // continue if empty
if(strpos('.php',$block)>0 && @file_exists($block)){ // check if block is a file
$content = '';
@include($block);
$_PAGE['buffer'] = str_ireplace($m[0],$content,$_PAGE['buffer']);
}else{
$_PAGE['buffer'] = str_ireplace($m[0],$block,$_PAGE['buffer']);
}
}

}else{
echo 'Sorry, website currently unavailable. Please try again later.<br/>'."\r\n".'8<br/>'."\r\n".'Site: '.$_SITE['approot'];
exit;
}

?>