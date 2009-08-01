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

public static function link($h, $t = ''){return self::create('a',(!$t?$h:$t),array('href'=>$h));}

public static function create($tag, $content = '', $attr = array()){
$a = '';foreach($attr as $k=>$v){$a.=" $k=\"$v\"";}
return "<$tag$a>$content</$tag>";}

/* alias of create() function */
public static function tag($tag, $content = '', $attr = array()){
return self::create($tag,$content,$attr);
}

public static function encode($s){return htmlentities($s,ENT_NOQUOTES);}

public static function decode($s){return html_entity_decode($s,ENT_NOQUOTES);}

}

?>