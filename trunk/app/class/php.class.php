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

/*
* function inc_only() - exits script if the file was not called by incude
*/
public static function inc_only(){
if(!self::is_inc()){exit();}
}

/*
* function no_inc() - exits script if the file has been included
*/
public static function no_inc(){
if(self::is_inc()){exit();}
}

/*
* function is_inc() - returns true or false whether the file has been included
* returns a boolean telling whether the current script is included or not.
*/
public static function is_inc(){
$f = php::idx(reset(debug_backtrace()),'file');
return (realpath($f) != realpath($_SERVER['SCRIPT_FILENAME']));
}

/*
* function ip() - returns a string
* returns the secondary IP address of the client
*/
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

/*
* function var_name() - returns a string
*  &$var - the variable to get the name
*  $scope - the array to look for, default is $GLOBALS. can be $_POST, $_SESSION, $_GET or any other array.
* returns the variable name of a variable.
*/
public static function var_name(&$var, $scope=0)
{
    $old = $var;
    if(($key = array_search($var = 'unique'.rand().'value', !$scope ? $GLOBALS : $scope)) && $var = $old) return $key; 
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

/*
* function crc($o) - generates the crc32 string in hexadecimal
*  $o - the data to generate crc32 string
* returns a crc32 hash of the data
*/
public static function crc($o){
  $value = crc32($o);
  $value &= 0xffffffff;
  return str_pad(dechex($value), 8, "0", STR_PAD_LEFT);
}

/*
* function idx($array, $key) - gets the value of $array[$key]
*       useful for something like $v = idx(funcArray(),'key');
*       since PHP does not allow funcArray()['key']
*  $array - the array
*  $key - the key to get the value
* returns $array[$key]
*/
public static function idx($a,$k){
if(is_array($a)){return $a[$k];}
return $a;
}

/*
* function str_between($string, $start,$stop) - gets the string between 2 strings
*  $string - the string to parse
*  $start - starting point
*  $stop - ending point
* returns an array of strings
*/
public static function str_between($string, $start, $stop){
    $st = $string;
    $list = array();
    $sl = strlen($start);
    for($i=0;$i<strlen($string);$i++){
        $temp = strpos($st, $start);
        $str = substr($st, $temp+$sl);
        $split_here = strpos($str, $stop);
        $parsed_string = substr($str, 0, $split_here);
        if($parsed_string == ''){
            break;}
        $st = substr($str, $split_here+1);
        $list[] = $parsed_string;
    }
    return $list;
}

/*
* function ver($s) - gets the PHP or extension version
*  $s - an extension to get the version
* returns a string
*/
public static function ver($s = ''){
if($s){
return phpversion($s);
}else{
return phpversion();
}
}

/*
* function func_name() - gets the current function name
*        to be called in a function
* returns a string
*/
public static function func_name(){
$bt = next(debug_backtrace());
$ret = '';
if(isset($bt) && isset($bt['function'])){
$ret = $bt['function'];
}
return $ret;
}

/*
* function paging($urlpat,$current, $max, [$min = 1 [, $show = 3]]) - creates an array with appropriate paging
*   $urlpat - a string of the URL. use %d for replacement of the page number.
*   $current - the current page number. not index.
*   $max - the maximum page. required.
*   $min - Optional. minimum page, default 1.
*   $show - number of pages to show left and right of current page. default 3.
*/
public static function paging($urlpat,$current, $max, $min = 1,$show = 3){
if($current < $min || $current > $max){$current = $min;}
if($max < $min){return false;}
if(!strpos($urlpat,'%d')){return false;}
$current = (int)$current;$max = (int)$max;$min = (int)$min;$show = (int)$show;

$ret = array();

if($current > $min){$ret[] = array(sprintf($urlpat,$current-1),'Previous');}

// show minimum
if($current - $show > $min){$ret[] = array(sprintf($urlpat,$min),$min);
if($current - ($show+1) > $min){$ret[]='...';}}

for($x=($current-$show > 0 ? $current-$show: $min); $x>=$min && $x <= $max && ($x < $current);$x++){$ret[] = array(sprintf($urlpat,$x),$x);}

$ret[] = array(sprintf($urlpat,$current),$current);

for($x=($current+1); $x>=$min && $x <= $max && ($x <= $current + $show);$x++){$ret[] = array(sprintf($urlpat,$x),$x);}

if($current + $show < $max){if($current+($show+1)<$max){$ret[]='...';}

$ret[] = array(sprintf($urlpat,$max),$max);

}
if($current < $max){$ret[] = array(sprintf($urlpat,$current+1),'Next');}

return $ret;
}

public static function file_upload($name,$dest){

$ok = true;
if(is_array($name) && is_array($dest) && count($name) == count($dest)){

foreach($name as $i=>$n){
  self::file_upload($n,$dest[$i]);
}

}elseif(is_string($name) && substr($name,-2)=='[]' && (is_string($dest)|| is_array($dest)) ){
$name = substr($name,0,strlen($name)-2);
if(is_array($dest)){
foreach($dest as $i =>$d){
$keys = array_keys($_FILES[$name]);
$a = array();
foreach($keys as $k){
$a['%'.$k.'%'] = $_FILES[$name][$k][$i];
}
$d = str_replace(array_keys($a),$a,$d);
$ok = $ok && move_uploaded_file($_FILES[$name]['tmp_name'][$i],$d);

}
}else{

$c = count($_FILES[$name]['name']);
$i = -1;
while($i++ < $c){

$keys = array_keys($_FILES[$name]);
$a = array();
foreach($keys as $k){
$a['%'.$k.'%'] = $_FILES[$name][$k][$i];
}
$d = str_replace(array_keys($a),$a,$dest);
$ok = $ok && move_uploaded_file($_FILES[$name]['tmp_name'][$i],$d);

}

}

}elseif(is_string($name) && is_string($dest)){

$keys = array_keys($_FILES[$name]);
$a = array();
foreach($keys as $k){
$a['%'.$k.'%'] = $_FILES[$name][$k];
}
$dest = str_replace(array_keys($a),$a,$dest);
$ok = move_uploaded_file($_FILES[$name]['tmp_name'],$dest);

}else{
return false;
}

return $ok;
}

/*
* function mtime() - gets the current microtime in float
* returns a float of microtime.
*/
public static function mtime(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

/*
* function dump($v [, $t = true [, $preformat = true]]) - returns or outputs a nicely formatted var_dump/var_export
*   $v - the variable to dump
*   $t - if true, the function returns the string, else dump to output buffer.
*   $preformat - whether <pre> tags are wrapped around the variable dump
* returns a HTML string of intormation about variable $v with html tag if $t is not specified or true.
*/
public static function dump($v,$t = true,$preformat = true){
if($t){
$ret = '';
if($preformat){$ret .= '<pre>';}
$ret .= var_export($v,true);
if($preformat){$ret .= '</pre>';}
return $ret;
}else{
if($preformat){echo '<pre>';}
var_dump($v);
if($preformat){echo '</pre>';}
}
}

/*
* function str_slice($str, $len [, $append = '...']) - returns a string sliced if too long
*   $str - the string to check
*   $len - maximum length
*   $append - the string to append behind if too long
* returns a string.
*/
public static function str_slice($str,$len,$append = '...'){
$str = trim($str);
return (strlen($str) > $len ? substr($str,0,$len-strlen($append)).$append : $str);
}


/*
* function parse_backtrace($r) - returns a string formatted properly like debug_print_backtrace()
*   $r - the array returned by debug_backtrace()
* returns a string.
*/
public static function parse_backtrace($r){
$o='';       
foreach($r as $e){$o .= "\n".$e['function'].'('.(count($e['args'])>0?implode(', ',$e['args']):'').') was called at ['.$e['file'].':'.$e['line'].']';}
return $o;
} 

/*
* function xml($a) - returns either a XML string or Array (created from XML)
*   $a - an XML string or array to be converted
* if $a is an array, it will be parsed and converted into an XML string
* if $a is a string, it will be parsed and converted back into a PHP array
*/
public static function xml($a) {
if(is_array($a)){
$x = '';
foreach ($a as $k=>$v){
$k=strtolower($k);
if(is_array($v)){
$x .='<'.$k.'>'."\n";$x .=self::xml($v);$x .='</'.$k.'>'."\n";
}else{
if(trim($v)!=''){
if(htmlspecialchars($v)!=$v){
$x .= '<'.$k.'><![CDATA['.$v.']]></'.$k.'>'."\n";
}else{
$x .= '<'.$k.'>'.$v.'</'.$k.'>'."\n";
}
}else{
$x .='<'.$k.' />';
}
}
}
}else{
$x = array();
@preg_match_all('`<([A-Z][A-Z0-9]*)\b[^>]*>(.*?)</\1>`is',$a,$m,PREG_SET_ORDER);
if(count($m)){
foreach($m as $i){
$x[$i[1]]=self::xml($i[2]);
}
}else{
$x=str_replace(array('<![CDATA[',']]>'),'',$a);
}
}
return $x;
}

/*
* function browser() - gets the current browser the client is using
* returns a string
*/
public static function browser(){
$useragent = $_SERVER['HTTP_USER_AGENT'];
if(preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)){
    $browser_version=$matched[1];
    $browser = 'Opera ';
}elseif(preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)){
    $browser_version=$matched[1];
    $browser = 'IE ';
}elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)){
        $browser_version=$matched[1];
        $browser = 'Firefox ';
}elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)){
        $browser_version=$matched[1];
        $browser = 'Safari ';
}else{
        // browser not recognized!
    $browser_version = '';
    $browser= '';
}
$ret = $browser.$browser_version;
return $ret;
}

/*
* function platform() - gets the current platform the client is using
* returns a string
*/
public static function platform(){
$useragent = $_SERVER['HTTP_USER_AGENT'];
if (strstr($useragent,'Win')) {
    $os='Windows';
} else if (strstr($useragent,'Mac')) {
    $os='Mac';
} else if (strstr($useragent,'Linux')) {
    $os='Linux';
} else if (strstr($useragent,'Unix')) {
    $os='UNIX';
} else {
    $os='';
}
$ret = $os;
return $ret;
}

/*
* function str_parse($string, $funcs) - parses $string with all function of $funcs
*   $string - a string to be parsed
*   $funcs - an array of function names or a string of function names seperated by commas
* returns a string
*/
public static function str_parse($s,$f=array()){
self::arg_check(func_num_args(),2,1);
if(!is_array($f)){
$fs = explode(',',$f);
}else{
$fs = $f;
}
foreach($fs as $a){
$a = trim($a);
if(function_exists($a)){$s = $a($s);}
}
return $s;
}

/*
* function str_shift($string, $shift) - shift all characters in $string by $shift
*   $string - the string to be shifted
*   $shift - the amount of shift in number
* returns a string
*/
public static function str_shift($s, $n){
php::arg_check(func_num_args(),2,2);
$nw = '';$l = strlen($s);
for ($i = 0; $i<$l; ++$i){$nw .= chr(ord($s[$i])+$n);}
return $nw;
}

/*
* function str_loop($string, $func) - loop through the string with a function
*   $string - the string to be looped
*   $func - the function to handle the character
*             $func must take in only 1 parameter, which is the character.
*/
public static function str_loop($s,$fn){
$l = strlen($s);
$i = -1;
while(++$i <= $l){
$fn(substr($s,$i,1));
}
}

/*
* function arg_check($n, $max[, $min = 0]) - checks whether number of argument in function is valid or not
*   $n - the number returned by func_num_args()
*   $max - the maximum number of arguments
*   $min - the minimum number of arguments, default is $max.
* if $n is not between $max and $min, it will trigger an error and return false.
* else returns true;
*/
public static function arg_check($n, $h, $l = -1){
if($l < 0){$l=$h;}
if($l > $h){
$b = ($n > $l || $n < $h);
}else{
$b = ($n > $h || $n < $l);
}
if($b){
$bt = next(debug_backtrace());
$ei = '';
if(isset($bt) && isset($bt['function'])){
$ei = '<br/> at <b>'.$bt['function'].'()</b> in file <b>'.$bt['file'].'</b> in line '.$bt['line'].'';
}

trigger_error('Wrong parameter count. Expected '.($h==$l ? $h : 'between '.$h.' and '.$l).' parameters, given '.$n.$ei, E_USER_WARNING);
}
return !$b;
}

}

?>