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

/*
* function input($n [, $t = 'text' [, $v = ''] ] ) - creates a form input
*  $n - name of the field (required)
*  $t - type of the field - default is "text".
*  $v - the value of the input box
* returns a html string of the input box
*/
public static function input($n,$t = 'text',$v = ''){
if($t == ''){$t = 'text';}
return '<input name="'.$n.'" type="'.$t.'" '.($v?'value="'.$v.'"':'').'/>';
}

/*
* function select($arr, $n [, $s = ''] ) - creates a form list box
*  $arr - array of options
*  $n - name of the field
*  $s - a string of the selected value or an array of selected values
* returns a html string of the select list box
*/
public static function select($arr,$n,$s=''){
$ret = '';
if(is_array($arr)){
foreach ($arr as $k => $v){
$a = array('value'=>$k);
if($s == $k || (is_array($s) && in_array($k,$s))){$a['selected']='yes';}
$ret .= html::create('option',$v,$a);
}
return html::create('select',$ret,($n != '' ? array('name'=>$n):array())); 
}
return false;
}

/*
* function counter($domID [, $maxlength = 0 ] ) - creates a counter for input boxes with length
*  $domID - the string ID of the input DOM object aka the ID used in document.getElementById("domID") or $("#domID")
*  $maxlength - a number that defines the maximum length of the input box
* returns a html string of the counter
*
*  NOTICE: this function requires jQuery
*/
public static function counter($domID,$maxlength=0){
$maxlength = (int)$maxlength;
$s = '';
$s.='<span id="'.$domID.'c">0</span> characters';
if($maxlength <= 0){
$s .= html::js('function '.$domID.'f(e){$("#'.$domID.'c").html($("#'.$domID.'").val().length);}$("#'.$domID.'").keyup(function(e){return '.$domID.'f(e);});$(document).ready(function(){'.$domID.'f(null);});');
}else{
$s.=' remaining';
$s .= html::js('var '.$domID.'m = '.$maxlength.';function '.$domID.'f(e){var l = '.$domID.'m-$("#'.$domID.'").val().length;var b = (e == null || (e?e.which:e.keyCode)!=8);if(l <= 0 && b){return false;}$("#'.$domID.'c").html(l);return true;}$("#'.$domID.'").keyup(function(e){return '.$domID.'f(e);});$(document).ready(function(){'.$domID.'f(null);});');
}
return $s;
}

/*
* function security($kid) - creates 2 hidden boxes for checking security
*  $kid - the Key Identifier used to identify your form. please use site-wide unique keys for your forms.
* returns a html string of the 2 security hidden fields
*/
public static function security($kid){global $session_hash;
$n = crc32(time().$kid);$s = dechex($n);$k = md5(mt_rand().$kid.time());
if(!is_array($_SESSION['fwfrmsec'])){$_SESSION['fwfrmsec'] = array();}
$_SESSION['fwfrmsec'][$kid] = $k;
return self::input($session_hash,'hidden',$s).self::input(str_rot13($s),'hidden',(bit::query($n,1)?$k.$s:$s.$k));
}

/*
* function chksecurity($kid) - checks for the security fields
*  $kid - the Key Identifier that you have previously used for form::security()
* returns true on valid submission, and false on invalid submission
*/
public static function chksecurity($kid){global $session_hash;
$s = $_POST[$session_hash];$n = hexdec($s);$k = $_POST[str_rot13($s)];
if(bit::query($n,1)){$k = substr($k,0,strlen($k)-strlen($s));}else{$k = substr($k,strlen($s));}
$nk = $_SESSION['fwfrmsec'][$kid];unset($_SESSION['fwfrmsec'][$kid]);
return ($nk == $k);
}

}