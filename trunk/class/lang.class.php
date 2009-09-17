<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Include-only Language/Translator helper class
*  Created by: Sam Yong | Date/Time: 6:57am 20th July 2009 GMT+8
*
**************************************************** */

class lang{

public static function translate($parse_str){
  global $_SITE;
  $strs = php::str_between($parse_str,'<#','#>');
  if(count($strs) == 0){return $parse_str;}
  $sdict = @file_get_contents('lang/'.$_SITE['language'].'.txt');
  $ddict = @file_get_contents('lang/'.$_SITE['lang_translate'].'.txt');
  if(!$ddict || !$sdict){return $parse_str;}
    $sdict = array_map('trim',explode("\n",$sdict));$ddict = array_map('trim',explode("\n",$ddict));
  foreach($strs as $s){
    $found = false;
    if($_SITE['language'] != $_SITE['lang_translate']){
    foreach($sdict as $i=>$d){
      if(strtolower($d) == strtolower($s)){
          $parse_str = str_replace('<#'.$s.'#>',$ddict[$i],$parse_str);
          $found = true;
          break;
      }
    }
    }
    if(!$found){
      $parse_str = str_replace('<#'.$s.'#>',$s,$parse_str);
    }
  }
  return $parse_str;
}

}

?>