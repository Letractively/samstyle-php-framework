<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Include-only validation class
*  Created by: Sam Yong | Date/Time: 11:08am 19th July 2009 GMT+8
*
**************************************************** */

class validate{

public static $email_regex = "`^[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$`i";
public static $url_regex = "`^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?\&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/\&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$`i"; 

public static function email($e){
return (bool)preg_match(self::$email_regex, trim($e));
}

public static function url($u){
return (bool)preg_match(self::$url_regex, trim($u));
}

public static function num($v){
if($v==""){return false;}
return ctype_digit($v);
}

public static function alnum($v){
if($v==""){return false;}
return ctype_alnum($v);
}

public static function hex($v){
return (bool)preg_match('`^([a-fA-F0-9]+)$`is',$v);
}

public static function len($t,$h,$l=0){
if($l > $h){$m = $h;$h = $l;$l=$m;unset($m);}
if(strlen($t)>=(int)$l && strlen($t)<=(int)$h){return true;}
return false;
}

public static function pattern($v, $p){
$r = array(
' ' => '([ ]{1})',
'0' => '([0]{1})',
'.' => '([\.]{1})',
'!@' => '([^a-zA-Z0-9]{1})',
'!#' => '([^0-9]{1})',
'@' => '([a-zA-Z0-9]{1})',
'#' => '([0-9]{1})',
'*' => '(*{1})',
'`'=>'\`'
);
$pat = '`^'.str_ireplace(array_keys($r),$r,$p).'$`is';
return (bool)preg_match($pat, $v);
}

}

?>