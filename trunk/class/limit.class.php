<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Include-only Feature Limiting class
*  Created by: Sam Yong | Date/Time: 11:08am 19th July 2009 GMT+8
*
**************************************************** */

class limit{

private static $sesskey = 'ssphpfw_limitingclass';

private static function init(){
  if(!isset($_SESSION[self::$sesskey]) && !is_array($_SESSION[self::$sesskey])){
    $_SESSION[self::$sesskey] = array();
  }
}

public static function set($f,$n,$t){
  self::init();
  $k = dechex(crc32($f));
  if(!isset($_SESSION[self::$sesskey][$k])){
    $_SESSION[self::$sesskey][dechex(crc32($f))] = array('feature'=>$f,'max_counts'=>$n,'clearinterval'=>$t,'counts'=>0,'lastclear'=>time());
  }
}

public static function add_count($f){
  self::init();
  $k = dechex(crc32($f));
  if(isset($_SESSION[self::$sesskey][$k])){
    self::checkreset($f);
    $_SESSION[self::$sesskey][$k]['counts']++;
  }
}

private static function checkreset($f){
  self::init();
  $k = dechex(crc32($f));
  if(isset($_SESSION[self::$sesskey][$k]) && $_SESSION[self::$sesskey][$k]['clearinterval'] > 0 && ($_SESSION[self::$sesskey][$k]['clearinterval']+$_SESSION[self::$sesskey][$k]['lastclear'] < time())){
    $_SESSION[self::$sesskey][$k]['counts']=0;
    $_SESSION[self::$sesskey][$k]['lastclear']=time();
  }
}

public static function reset($f){
  self::init();
  $k = dechex(crc32($f));
  if(isset($_SESSION[self::$sesskey][$k])){
     unset($_SESSION[self::$sesskey][$k]);
  }
}

public static function check($f){
  self::init();
  $k = dechex(crc32($f));
  if(isset($_SESSION[self::$sesskey][$k])){
    self::checkreset($f);
    if($_SESSION[self::$sesskey][$k]['counts']>=$_SESSION[self::$sesskey][$k]['max_counts']){
       return false;
    }
  }
  return true;
}

}

?>