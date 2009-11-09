<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Include-only HTML helper class
*  Created by: Sam Yong | Date/Time: 7:15am 20th July 2009 GMT+8
*
**************************************************** */

class html{

/* returns a HTML js string with script tag: pre-formatted for XHTML, HTML OK */
public static function js($s){return self::create('script','/*<![CDATA[*/ '.$s.' /*]]>*/',array('type'=>'text/javascript'));}

/* returns a HTML script tag with src link to file: pre-formatted for XHTML, HTML OK */
public static function jsf($f){return self::create('script','',array('type'=>'text/javascript','src'=>$f));}

/* returns a HTML css string with style tag: pre-formatted for XHTML, HTML OK */
public static function css($s){return self::create('style',self::c($s),array('type'=>'text/css'));}

/* returns a HTML comment string */
public static function c($s){return '<!-- '.$s.' -->';}

/* returns a HTML string with img tag: pre-formatted for XHTML, HTML OK */
public static function img($s,$a = '',$id=''){return str_replace('></img>',' />',self::create('img','',array('alt'=>$a,'src'=>$s,'id'=>$id)));}

public static function link($h, $t = ''){return self::create('a',(!$t?$h:$t),array('href'=>$h));}

public static function create($tag, $content = '', $attr = array()){
if(is_array($attr)){
$a = '';foreach($attr as $k=>$v){$a.=" $k=\"$v\"";}
}else{
$a = ' '.$attr;
}
return "<$tag$a>$content</$tag>";}

/* alias of create() function */
public static function tag($tag, $content = '', $attr = array()){
return self::create($tag,$content,$attr);
}

public static function encode($s){return htmlentities($s,ENT_NOQUOTES);}

public static function decode($s){return html_entity_decode($s,ENT_NOQUOTES);}

public static function flash($file,$width,$height){
return '<!--[if !IE]> -->'.
'<object type="application/x-shockwave-flash" data="'.$file.'" width="'.$width.'" height="'.$height.'"><param name="wmode" value="opaque" /></object>'.
'<!-- <![endif]-->'.
'<!--[if IE]>'.
'<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'.$width.'" height="'.$height.'">'.
'<param name="movie" value="'.$file.'" /><param name="wmode" value="opaque" />'.
'</object>'.
'<![endif]-->';
}

public static function control($field,$options){
$s = '$(window).ready(function(){var obj=$("#'.$field.'");if(obj.length>0){';
if(isset($options['maxlength']) && $options['maxlength'] > 0){
$s .= 'obj.attr("maxlength",'.(int)$options['maxlength'].');';
if(isset($options['remaining'])){
$s2 = '$("#'.$options['remaining'].'").html('.(int)$options['maxlength'].'-$("#'.$field.'").val().length);';
$s .= 'obj.keypress(function(e){'.$s2.'});'.$s2;
}
}
if(isset($options['counter'])){
$s2 = '$("#'.$options['counter'].'").html($("#'.$field.'").val().length);';
$s .= 'obj.keypress(function(e){'.$s2.'});'.$s2;
}
if(isset($options['numeric'])){
$s .= 'obj.keypress(function(e){var charCode = (e.which) ? e.which : event.keyCode;if (charCode > 31 && (charCode < 48 || charCode > 57)){return false;}return true;});';
}
$s .= '}});';
return self::js($s);
}

public static function img_swap($id, $hover){
$s = 'var imgobj = new Image();imgobj.src = "'.$hover.'";$(window).ready(function(){$("#'.$id.'").data("ori-img",$("#'.$id.'").attr("src")).hover(function(){this.src = "'.$hover.'";},function(){this.src = $(this).data("ori-img");});});';
return self::js($s);
}

}

?>