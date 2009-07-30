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

public static function ver($s = ''){
return phpversion($s);
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
if($max <= $min){return false;}
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

/*
* function redirect($u) - sends a redirect header and exit script
*  $u - the new URL. cannot be empty.
*/
public static function redirect($u){
if(!$u){return false;}
header('Location: '.$u);exit();
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
* function dump($v [, $t = true]) - returns or outputs a nicely formatted var_dump/var_export
*   $v - the variable to dump
*   $t - if true, the function returns the string, else dump to output buffer.
* returns a HTML string of intormation about variable $v with html tag if $t is not specified or true.
*/
public static function dump($v,$t = true){
if($t){
$ret = '';
$ret .= '<pre>';$ret .= var_export($v,$true);$ret .= '</pre>';
return $ret;
}else{
echo '<pre>';var_dump($v);echo '</pre>';
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
return (strlen($str) > $len ? substr($str,0,$len-3).$append : $str);
}

}

?>