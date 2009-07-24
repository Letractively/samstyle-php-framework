<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* *************************************************
*
*  dao.inc.php
*  Samstyle PHP Framework
*  Data Access (DAO) Support for MySQL
*
************************************************* */


/* *************************************************
*
*  function mysql_squeryf()
*  format properly a mysql string with an array of values with
*  SQL injection prevention
*
************************************************* */

function mysql_squeryf($sq /*, args ... */) {
$argv = func_get_args();$argc = count($argv);$p = array();

if ($argc > 1) {
for($x=1;$x<$argc;$x++) { 
if(is_string($argv[$x])){
$p[]='\''.mysql_real_escape_string($argv[$x]).'\'';
}elseif(is_scalar($argv[$x])){
$p[]=$argv[$x];
}else{return false;}
}
$ok=vsprintf($sq, $p);
if(trim($ok)==''){return false;}
}else{
$ok=str_replace('%%','%',$sq);
}
return $ok;
}

/* *************************************************
*
*  function mysql_cvConstruct()
*  constructs a nice `column1`='value1',`column2`=25 string from an array
*
************************************************* */

function mysql_cvConstruct($a){if(!$a || !is_array($a)){return false;}$cols = array();$vals= array();
foreach($a as $k => $v){$c='`'.$k.'`';if(is_string($v)){$c.='=%s';}elseif(is_scalar($v)){$c.='=%d';}else{continue;}$vals[]=$v;$cols[]=$c;}
array_unshift($vals,implode(',',$cols));$s = call_user_func_array('mysql_squeryf', $vals);return $s;}


/* *************************************************
*
*  function mysql_logerror($r)
*  logs an error if there is an MySQL error.
*
************************************************* */

function mysql_logerror(){$err = mysql_error();if($err != ''){error_log("Application MySQL Error [t=".time()."]: ".$err);}}

/* *************************************************
*
*  function mysql_retExec($r)
*  returns true on successful query, false on failure
*
************************************************* */
function mysql_retExec($r){mysql_logerror();if(!$r){return false;}return true;}

/* *************************************************
*
*  function mysql_retSRow($r)
*  returns a single Row on successful query, false on failure
*
************************************************* */
function mysql_retSRow($r){mysql_logerror();return @mysql_fetch_assoc($r);}

/* *************************************************
*
*  function mysql_retAllRows($r)
*  returns an array of Rows on successful query, false on failure
*
************************************************* */
function mysql_retAllRows($r){mysql_logerror();$a=array();while($v=mysql_retSRow($r)){if($v){$a[]=$v;}}return $a;}

/* *************************************************
*
*  function mysql_retValue($r,$col)
*  returns a value of a specific column in single Row on successful query, false on failure
*
************************************************* */
function mysql_retValue($r,$col){mysql_logerror();$v=mysql_retSRow($r);if(!$v){return false;}return isset($v['`'.$col.'`'])?$v['`'.$col.'`']:$v[$col];}

/* *************************************************
*
*  function mysql_retAllValues($r,$col)
*  returns an array of values of a specific column in single Row on successful query, false on failure
*
************************************************* */
function mysql_retAllValues($r,$col){mysql_logerror();$a=array();while($v=mysql_retvalue($r,$col)){if($v){$a[]=$v;}}return $a;}

?>