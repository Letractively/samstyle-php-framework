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
'<$baseurl$>' => $s_http[0],
'<$robots$>' => $_PAGE['robots'],
'<$header$>' => $_PAGE['header'],
'<$metarevisit$>' => '1',
'<$pagekeywords$>' => $_SITE['keywords'],
'<$pagedescription$>' => $_SITE['description'],
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

foreach($_PAGE['blocks'] as $name => $block){
if(@file_exists($block)){
$content = '';
@include($block);
$_TEMPLATE['<$block:'.$name.'$>'] = str_ireplace(array_keys($_TEMPLATE),$_TEMPLATE,$content);
}else{
$_TEMPLATE['<$block:'.$name.'$>'] = str_ireplace(array_keys($_TEMPLATE),$_TEMPLATE,$block);
}
}

$_PAGE['buffer'] = str_ireplace(array_keys($_TEMPLATE),$_TEMPLATE,$template);

}else{
echo 'Sorry, website currently unavailable. Please try again later.<br/>'."\r\n".'8<br/>'."\r\n".'Site: '.$s_http[0];
exit;
}

?>