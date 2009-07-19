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
public static function js($s){return '<script type="text/javascript">/*<![CDATA[*/ '.$s.' /*]]>*/</script>';}

/* returns a HTML css string with style tag: pre-formatted for XHTML, HTML OK */
public static function css($s){return '<style type="text/css"><!-- '.$s.' --></style>';}

/* returns a HTML comment string */
public static function c($s){return '<!-- '.$s.' -->';}

public static function create($tag, $content = '', $attr = array()){
$a = '';foreach($attr as $k=>$v){$a.=" $k=\"$v\"";}
return "<$tag$a>$content</$tag>";}

}

?>