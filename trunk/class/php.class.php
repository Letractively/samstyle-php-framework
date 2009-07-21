<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Include-only PHP helper class
*  Created by: Sam Yong | Date/Time: 6:57am 20th July 2009 GMT+8
*
**************************************************** */

class php{

public static function inc_only(){
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}
}

public static function no_inc(){
if(basename(__FILE__) != basename($_SERVER['PHP_SELF'])){exit();}
}

public static function is_inc(){
if(basename(__FILE__) != basename($_SERVER['PHP_SELF'])){return true;} return false;
}

public static function ip() {
$IP = '';
if (getenv('HTTP_CLIENT_IP')) {$IP =getenv('HTTP_CLIENT_IP');}
elseif (getenv('HTTP_X_FORWARDED_FOR')) {$IP =getenv('HTTP_X_FORWARDED_FOR');}
elseif (getenv('HTTP_X_FORWARDED')) {$IP =getenv('HTTP_X_FORWARDED');}
elseif (getenv('HTTP_FORWARDED_FOR')) {$IP =getenv('HTTP_FORWARDED_FOR');}
elseif (getenv('HTTP_FORWARDED')) {$IP = getenv('HTTP_FORWARDED');}
else {
$IP = $_SERVER['REMOTE_ADDR'];
}
return $IP;
}

public static function var_name(&$var, $scope=0)
{
    $old = $var;
    if (($key = array_search($var = 'unique'.rand().'value', !$scope ? $GLOBALS : $scope)) && $var = $old) return $key; 
}

/*
* function tmp_var($v) - creates a safe temporary variable.
*  $v - the value of the variable.
* returns the name of the temporary variable in the global scope.
*/
public static function tmp_var($v){
$t = 'tv_'.dechex(crc32(mt_rand().time())); // creates the variable name.
g($t,$v);
return $t;
}

public static function idx($a,$k){
if(is_array($a)){return $a[$k];}
return $a;
}

}

?>