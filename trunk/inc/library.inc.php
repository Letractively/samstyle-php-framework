<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* *************************************************
*
*  library.inc.php
*  Samstyle PHP Framework
*  Framework Functions Library
*
************************************************* */

/* output buffering */
function p($s){
global $_PAGE;
$tr = '';
$argc = func_num_args();
if ($argc > 1) {
$argv = func_get_args();
foreach($argv as $p){$tr .= $p;}
}else{
$tr = $s;
}
$_PAGE['content'] .= $tr;
}

/*
*  function cblock() - REMOVED
*    allows you to define and call and block easily
*    $b - the block identifier
*    $c - the content/file of the block
*/
//function cblock($b,$c){if($b == '' || !is_string($b)){return false;}global $_PAGE;$_PAGE['blocks'][$b] = $c;
//if(@file_exists($c)){$content = '';@include($c);p($content);}else{p($c);}}

/*
*  function g($k, [$v])
*    allows you to get a variable which is currently defined in the global scope of the script using $GLOBALS
*    $k - the name of the variable
*    $v - Optional. set the value of the 
* HINT: you can use (php::var_name($var) == 'var') to get the variable name of a variable
*/
function g($k,$v=''){
if(func_num_args()>=2){$GLOBALS[$k]=$v;}
return $GLOBALS[$k];
}

/*
* Email validation
*/
function emailvalidate($email){
$email = trim($email);
$return = preg_match("/^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i", $email);
return $return;
}

function timeAgo($tzSince){
$years = floor($tzSince/(60*60*24*365));
if($years>=0){$tzSince = $tzSince - ($year*60*60*24*365);}
$mths = floor($tzSince/(60*60*24*30));
if($mths>=0){$tzSince = $tzSince - ($mths*60*60*24*30);}
$days = floor($tzSince/(60*60*24));
if($days>0){$tzSince = $tzSince - ($days*60*60*24);}
$hours = floor($tzSince/(60*60));
if($hours>0){$tzSince = $tzSince - ($hours*60*60);}
$minutes= floor($tzSince/(60));
if($minutes>0){$tzSince = $tzSince - ($minutes*60);}
$sec= floor($tzSince);
$Arr_Since = array(
'years' => $years,
'months' => $mths,
'days' => $days,
'hours' => $hours,
'minutes' => $minutes,
'seconds' => $sec
);
return $Arr_Since;
}

/* string comparison */
function str_compare($str1, $str2){
$arr1 = array_unique(explode(' ',strtolower(preg_replace('`[\.|\,|\!|\"\|\\|\/|\'|\@|\&|\:|\;|\]|\[|\=|\+|\-|\*|\?|\(|\)]`is', ' ', strip_tags($str1)))));
$arr2 = array_unique(explode(' ',strtolower(preg_replace('`[\.|\,|\!|\"\|\\|\/|\'|\@|\&|\:|\;|\]|\[|\=|\+|\-|\*|\?|\(|\)]`is', ' ', strip_tags($str2)))));

    if(count($arr1)>count($arr2)) {
        $tmp = $arr1;
        $arr1 = $arr2;
        $arr2 = $tmp;
        unset($tmp);
    }

    foreach($arr1 as $needle){
      if(in_array($needle,$arr2)){
foreach($arr2 as $haystack){
if(strtolower($needle) == strtolower($haystack)){$count++;}
}
      }
    }

    return $count/count($arr2) * 100 ;
}

/* making str_ireplace available for old versions */
function make_pattern(&$pat, $key) {$pat = '/'.preg_quote($pat, '/').'/i';}
if(!function_exists('str_ireplace')){
    function str_ireplace($search, $replace, $subject){
        if(is_array($search)){
            array_walk($search, 'make_pattern');
        }else{
            $search = '/'.preg_quote($search, '/').'/i';
        }
        return preg_replace($search, $replace, $subject);
    }
} 

/* do a proper redirect */
function redirect($url){
header('Location: '.$url);
exit;
}

/**
 *  Returns $arr[$idx], because php doesn't let you index into
 *  arrays returned from a function.
 *
 *  a()[0] doesn't work
 *
 *  idx(a(), 0) does.
 *
 *  PHP is a pretty stupid language.
 *
 *  @param    array to index into
 *  @param    index. if negative, start at the end.
 *  @param    default to return if $arr[$idx] is not set
 *  @return   array[index]
 */
function idx($arr, $idx, $default=null) {
  if ($idx === null || !is_array($arr)) {
    return $default;
  }
  $idx = $idx >= 0 ? $idx : count($arr) + $idx;
  return array_key_exists($idx, $arr) ? $arr[$idx] : $default;
}

/*
 * Extract the domain from a relatively-well-formed URL
 */
function get_domain($url){$i=parse_url($url);if(isset($i['host'])){return $i['host'];}return $i['path'];}

function no_magic_quotes($val) {
if(is_array($val)){
foreach($val as $k=> $v){$val[$k] = no_magic_quotes($v);}
return $val;
}else{
  if (get_magic_quotes_gpc()) {
    return stripslashes($val);
  } else {
    return $val;
  }
}
}

function parse_http_args($http_params, $keys=array()) {
  $result = array();
if(count($keys)>0){
  foreach ($keys as $key) {
    $result[$key] = no_magic_quotes(idx($http_params, $key));
  }
}else{
foreach($http_params as $k => $v){
$result[$k] = no_magic_quotes($v);
}
}
  return $result;
}

/* sending email wtih a html body */
function html_mail($to, $subject, $html_message, $from_address, $from_display_name=''){
$email_from_addr = $from_address;$email_from_name = $from_display_name;
$email_subject =  $subject;$email_txt = $html_message;$email_to = $to;
$headers = $email_from_name == '' ? "From: ".$email_from_addr : "From: ".$email_from_name." <".$email_from_addr.">";
$semi_rand = md5(time()); $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
$email_message .= "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type:text/html; charset=\"utf-8\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . 
$email_txt . "\n\n\n";
$ok = @mail($email_to, $email_subject, $email_message, $headers,'-odb'); 
return $ok;}

/* enable htmlspecialchars_decode() for older versions */
if (!function_exists("htmlspecialchars_decode")) {function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT) {
return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));}} 

/* extended get_headers() function */
function get_headers_x($url,$format=0, $user='', $pass='', $referer='') {
        if (!empty($user)) {
            $authentification = base64_encode($user.':'.$pass);
            $authline = "Authorization: Basic $authentification\r\n";
        }

        if (!empty($referer)) {
            $refererline = "Referer: $referer\r\n";
        }

        $url_info=parse_url($url);
        $port = isset($url_info['port']) ? $url_info['port'] : 80;
        $fp=fsockopen($url_info['host'], $port, $errno, $errstr, 30);
        if($fp) {
            $head = "GET ".@$url_info['path']."?".@$url_info['query']." HTTP/1.0\r\n";
            if (!empty($url_info['port'])) {
                $head .= "Host: ".@$url_info['host'].":".$url_info['port']."\r\n";
            } else {
                $head .= "Host: ".@$url_info['host']."\r\n";
            }
            $head .= "Connection: Close\r\n";
            $head .= "Accept: */*\r\n";
            $head .= $refererline;
            $head .= $authline;
            $head .= "\r\n";

            fputs($fp, $head);       
            while(!feof($fp) or ($eoheader==true)) {
                if($header=fgets($fp, 1024)) {
                    if ($header == "\r\n") {
                        $eoheader = true;
                        break;
                    } else {
                        $header = trim($header);
                    }

                    if($format == 1) {
                    $key = array_shift(explode(':',$header));
                        if($key == $header) {
                            $headers[] = $header;
                        } else {
                            $headers[$key]=substr($header,strlen($key)+2);
                        }
                    unset($key);
                    } else {
                        $headers[] = $header;
                    }
                } 
            }
            return $headers;

        } else {
            return false;
        }
    }


/* getallheaders() for old version */
if(!function_exists('getallheaders')){
function getallheaders() {
    foreach($_SERVER as $h=>$v){if(ereg('HTTP_(.+)',$h,$hp)){  $headers[$hp[1]]=$v;}}
    return $headers;
}
}

/* grabbing all URL on a web page that is found in the <a> tag. */
function arr_grablinks($url){
  $matches = array();
  if(strtolower(substr($url,0,7)) == 'http://'){
  $original_file = trim(@file_get_contents($url));
  $stripped_file = strip_tags($original_file, "<a>");
  preg_match_all("/<a(?:[^>]*)href=\"([^\"]*)\"(?:[^>]*)>([^\"]*)<\/a>/is", $stripped_file, $matches);
  return $matches;}else{return array();}
}

/* creates an array of numbers between $r1 and $r2, increasing order. */
function arr_range($r1,$r2){
$r1 = (int)$r1;$r2 = (int)$r2;
if($r2 < $r1){$t = $r1;$r1 = $r2;$r2 = $t;unset($t);}
$r = array();$i = 0;
for($i = $r1;$i<=$r2;$i++){$r[] = $i;}
return $r;
}

/* http_build_query() for old versions */
if(!function_exists('http_build_query')) {
function http_build_query($data,$prefix=null,$sep='',$key=''){
$ret = array();
foreach((array)$data as $k => $v) {
$k = urlencode($k);
if(is_int($k) && $prefix != null) {$k = $prefix.$k;}
if(!empty($key)) {$k = $key."[".$k."]";}
if(is_array($v) || is_object($v)) {array_push($ret,http_build_query($v,"",$sep,$k));}else {array_push($ret,$k."=".urlencode($v));}
}
if(empty($sep)) {$sep = ini_get("arg_separator.output");}
return implode($sep, $ret);
}
}

/* function to get secondary IP */
function getIP() {
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

/* unicode version of chr() */
function unichr($c) {
    if ($c <= 0x7F) {
        return chr($c);
    } else if ($c <= 0x7FF) {
        return chr(0xC0 | $c >> 6) . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0xFFFF) {
        return chr(0xE0 | $c >> 12) . chr(0x80 | $c >> 6 & 0x3F)
                                    . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0x10FFFF) {
        return chr(0xF0 | $c >> 18) . chr(0x80 | $c >> 12 & 0x3F)
                                    . chr(0x80 | $c >> 6 & 0x3F)
                                    . chr(0x80 | $c & 0x3F);
    } else {
        return false;
    }
}


/* up one level of the url */
/* i.e. http://example.com/test/folder/ becomes http://example.com/test/ */
function URL_UpLevel($url){
$t_url = $url;

$parts = explode('?',$t_url); // save the GET datas!
$c_url = $parts[0]; // save the URL
unset($parts[0]); // remove the URL, only want the GET DATA!!
$get_datas = implode('?',$parts); // merge the GET!
unset($parts);

$c_url = rtrim($c_url,'/?&'); // clean up the end of the url!
$parts = explode('/',$c_url); // save the GET datas!
unset($parts[count($parts)-1]);
$c_url = implode('/',$parts);
unset($parts);

return rtrim($c_url.'/?'.$get_datas,'?&');
}

/* see if it is bot or not. */
function isbot($agent="")
    {
    //Handfull of Robots
    $bot_array      =array("jeevesteoma",
                                   "msnbot",
                                   "slurp",
                                   "jeevestemoa",
                                   "gulper",
                                   "googlebot",
                                   "linkwalker",
                                   "validator",
                                   "webaltbot",
                                   "wget");
    //no agent given => read from globals
    if ($agent=="")
        {
        @$agent=$_SERVER["HTTP_USER_AGENT"];
        }
    //replace all but alphabets
    $agent=strtolower(preg_replace("/[^a-zA-Z _]*/","",$agent));
    //check für intersections
    return((BOOL)count(array_intersect(explode(" ",$agent),$bot_array)));
    }

function rewrite_clean($url){
$a_url = explode('-',strtolower(preg_replace('`[^a-zA-Z_]`','-',htmlspecialchars_decode($url))));
$url = '';foreach($a_url as $p_url){if($p_url != ''){$url .= $p_url . '-';}}
return trim($url,'-');
}

function cTimezone($time = false, $tzHours = +8, $dst = false){

if(!is_int($tzHours)){$tzHours = intval($tzHours);}
$timearray = array();
$h = $tzHours;

if ($dst) {
    $daylight_saving = date('I');
    if ($daylight_saving){
        if ($h < 0){ $h=$h+1;  } else { $h=$h-1; }
    }
}

if(!$time){$time = time();}

$ms = $h * 3600;
$timestamp = ($time+($ms)); 

$timearray = array(
'h' => gmdate("G",$timestamp),
'm' => gmdate("m",$timestamp),
'j' => gmdate("j",$timestamp),
'n' => gmdate("n",$timestamp),
'Y' => gmdate("Y",$timestamp),
's' => gmdate("s",$timestamp),
'GMT' => $h,
'0' => gmdate("U",$timestamp)
);
return $timearray;
}


function dirsize($dirname) {
    if (!is_dir($dirname) || !is_readable($dirname)) {
        return false;
    }

    $dirname_stack[] = $dirname;
    $size = 0;

    do {
        $dirname = array_shift($dirname_stack);
        $handle = opendir($dirname);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..' && is_readable($dirname . DIRECTORY_SEPARATOR . $file)) {
                if (is_dir($dirname . DIRECTORY_SEPARATOR . $file)) {
                    $dirname_stack[] = $dirname . DIRECTORY_SEPARATOR . $file;
                }
                $size += filesize($dirname . DIRECTORY_SEPARATOR . $file);
            }
        }
        closedir($handle);
    } while (count($dirname_stack) > 0);

    return $size;
}

function mime2ext($mime){
$m = explode('/',$mime);
$mime = $m[count($m)-1];
switch($mime){
case 'jpg': return 'jpg'; break;
case 'jpeg': return 'jpg'; break;
case 'png': return 'png'; break;
case 'gif': return 'gif'; break;
}
return '';
}
?>