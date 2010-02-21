<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Include-only Password with salting helper class
*  Created by: Sam Yong | Date/Time: 7:15am 20th July 2009 GMT+8
*
**************************************************** */

class pwd{

/*
* function hash($pwd) - creates a string of 72 alphanumeric characters
*   $pwd - the password to hash
* returns a string.
*/
public static function hash($pwd){
$hash = '';
$base = md5($pwd);
$salt = md5(uniqid(mt_rand(), true).time());
$ctrl = strlen($pwd)>0?substr($pwd,0,1):chr(0);
if(bit::query($ctrl,1)){
if(bit::query($ctrl,2)){$hash = md5($base.$salt).str_rot13(php::crc(php::mtime())).$salt;}else{$hash = md5($salt.$base).php::crc(php::mtime()).$salt;}
}else{
if(bit::query($ctrl,2)){$hash = $salt.php::crc(php::mtime()).md5($base.$salt);}else{$hash = $salt.str_rot13(php::crc(php::mtime())).md5($salt.$base);}
}
return $hash;
}

/*
* function compare($hash,$pwd) - checks whether password matches the hash
*   $hash - the hash of the password that was created with pwd::hash()
*   $pwd - the password to check and verify
* returns a boolean
*/
public static function compare($hash,$pwd){
if(!self::verify($hash)){return false;}
$base = md5($pwd);
$ctrl = strlen($pwd)>0?substr($pwd,0,1):chr(0);
if(bit::query($ctrl,1)){
$salt = substr($hash,40,32);$basehash=substr($hash,0,32);
if(bit::query($ctrl,2)){$cmphash = md5($base.$salt);}else{$cmphash = md5($salt.$base);}
}else{
$salt = substr($hash,0,32);$basehash=substr($hash,40,32);
if(bit::query($ctrl,2)){$cmphash = md5($base.$salt);}else{$cmphash = md5($salt.$base);}
}
return ($cmphash == $basehash);
}

/*
* function verify($hash) - verifies whether $hash is a hash created by pwd::hash()
*   $hash - the hash to verify
* returns a boolean
*/
public static function verify($hash){
return validate::alnum(substr($hash,32,8)) && validate::hex(substr($hash,0,32).substr($hash,40,32)) && (strlen($hash) == 72);
}

}
