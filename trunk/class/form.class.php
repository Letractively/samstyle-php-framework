<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Include-only HTML Form helper class
*  Created by: Sam Yong | Date/Time: 10:35pm 23rd July 2009 GMT+8
*
**************************************************** */

class form{

public static function input($n,$t = 'text',$v = ''){
if($t == ''){$t = 'text';}
return '<input name="'.$n.'" '.($v?'value="'.$v.'"':'').'/>';
}

public static function select($arr,$n,$s=''){
$ret = '';
if(is_array($arr)){
foreach ($arr as $k => $v){
$a = array('value'=>$k);
if($s == $k){$a['selected']='yes';}
$ret .= html::create('option',$v,$a);
}
return html::create('select',$ret,($n != '' ? array('name'=>$n):array())); 
}
return false;
}

}

?>