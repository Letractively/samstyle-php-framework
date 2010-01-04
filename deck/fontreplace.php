<?php

/*

    fontreplace FLIR
    By Sam Yong
    http://thephpcode.blogspot.com/

    This script is the backend controller of the fontrepalcce
    Image Replacement feature. It will serve the transparent PNGs according
    to the parameters passed. There is no need for 

    PHP GD image manipulation library is documentated at
    http://www.php.net/image/

    License:
    http://creativecommons.org/licenses/by-sa/3.0/

*/

// where the fonts are stored. do add trailing slashes and leave empty for current directory
$fontdir = 'fonts/';


// adds space to bottom for fixing problems with Windows platform
$bottompad = 10; // in pixels






/******************************************************
  do not edit anything that is below
******************************************************/


ob_start();

$str = $_GET['t'];
$font = $_GET['f'];
$color = $_GET['c'];
$size = $_GET['s'];

if(substr($size,-2)=='px'){
$size = substr($size,0,strlen($size)-2)/1.3333333;
}elseif(substr($size,-2)=='pt'){
$size = substr($size,0,strlen($size)-2);
}elseif(substr($size,-2)=='em'){
$size = substr($size,0,strlen($size)-2) * 16;
}else{
}
$size = (int)$size;

if(get_magic_quotes_gpc()){
    $str = stripslashes($str);
}
$str = javascript2html($str);

if(is_readable($fontdir.$font.'.otf')){
$font = $fontdir.$font.'.otf';
}elseif(is_readable($fontdir.$font.'.ttf')){
$font = $fontdir.$font.'.ttf';
}

// create image
$dip = get_dip($font,$size) ;
$box = imagettfbbox($size,0,$font,$str) ;

$width = abs($box[2]-$box[0]);
$height = abs($box[5]-$dip)+$bottompad;

$im = imagecreate($width,$height) ;
imagesavealpha($im, true);
$bg = imagecolorallocatealpha($im, 255, 255, 255, 0);
imagefill($im, 0, 0 , $bg);
imagecolortransparent($im,$bg);
imageantialias($im,true);

// allocate colors and draw text
$color = html2rgb($color);
$c = imagecolorallocatealpha($im,$color[0],$color[1],$color[2],$color[3]);
imagettftext($im,$size,0,-$box[0],abs($box[5]-$box[3])-$box[1],
    $c,$font,$str) ;

if(ob_get_contents()==''){
header('Content-Type: image/png');
imagepng($im);
}
imagedestroy($im);

function get_dip($font,$size){
$test = 'abcdefghijklmnopqrstuvwxyz' .
'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
'1234567890' .
'!@#$%^&*()\'"\\/;.,`~<>[]{}-+_-=' ;
$box = @imagettfbbox($size,0,$font,$test);
return $box[3];
}

function html2rgb($color){
    if (substr($color,0,1) == '#'){
        $color = substr($color, 1);
    }

    if (strlen($color) == 6){
        list($r, $g, $b) = array(substr($color,1,2),
                                 substr($color,3,2),
                                 substr($color,5,2));
        $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
        $a = 255;
    }elseif (strlen($color) == 3){
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
        $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
        $a = 255;
    }elseif(substr($color,0,4)=='rgb('){
        $arr = explode(',',substr($color,4,strlen($color)-5));
        $r = (int)$arr[0];
        $g = (int)$arr[1];
        $b = (int)$arr[2];
        $a = 255;
    }elseif(substr($color,0,5)=='rgba('){
        $arr = explode(',',substr($color,5,strlen($color)-6));
        $r = (int)$arr[0];
        $g = (int)$arr[1];
        $b = (int)$arr[2];
        $a = (int)$arr[3];
    }else{
        return false;
    }

    return array($r, $g, $b, $a);
}

function javascript2html($text){
    $matches = null;
    preg_match_all('/%u([0-9A-F]{4})/i',$text,$matches);
    if(!empty($matches)){
        for($i=0;$i<sizeof($matches[0]);$i++){
            $text = str_replace($matches[0][$i], '&#'.hexdec($matches[1][$i]).';',$text);
        }
    }

    return $text;
}

?>