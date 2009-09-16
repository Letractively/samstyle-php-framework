<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Include-only Firebug PHP debugging class
*  Created by: Sam Yong | Date/Time: 12:25pm 19th July 2009 GMT+8
*
**************************************************** */

class firebug{

private $buffer = '';
private $timers = array();
private $grouped = false;

private function prepare($arr){
$c = array();
foreach($arr as $p){
if(is_array($p) || is_object($p)){
$p = json_encode($p);
$c[]=$p;
}else{
$c[]='"'.php::dump($p,true,false).'"';
}
}
return $c;
}

public function firebug($s = ''){
if($s){
$this->group('Samstyle PHP Framework',$s);
$this->grouped = true;
}
}

public function dump(/*, $args */){
$c = array();
$argv = func_get_args();
$c = $this->prepare($argv);
$this->buffer.='console.log('.implode(',',$c).');';
}

public function group(/*, $args */){
$c = array();
$argv = func_get_args();
$c = $this->prepare($argv);
$this->buffer.='console.group('.implode(',',$c).');';
}

public function group_end(){
$this->buffer.='console.groupEnd();';
}


/* alias of dump() */
public function log(/*, $args */){
$this_args = func_get_args();
call_user_func_array(array($this,'dump'),$this_args);
}

public function debug(/*, $args */){
$c = array();
$argv = func_get_args();
$c = $this->prepare($argv);
$this->buffer.='console.debug('.implode(',',$c).');';
}

public function error(/*, $args */){
$c = array();
$argv = func_get_args();
$c = $this->prepare($argv);
$this->buffer.='console.error('.implode(',',$c).');';
}

public function warn(/*, $args */){
$c = array();
$argv = func_get_args();
$c = $this->prepare($argv);
$this->buffer.='console.warn('.implode(',',$c).');';
}

public function timer_start($timer_id){
$this->timer[$timer_id] = php::mtime();
}

public function timer_stop($timer_id){
if(!isset($this->timer[$timer_id])){return;}
$tnow = php::mtime();
$diff = ((float)$tnow-(float)$this->timer[$timer_id]);
$this->buffer .= 'console.log("Timer '.$timer_id.'\n'.$diff.' seconds");';
unset($this->timer[$timer_id]);
return $diff;
}

public function commit(){
p(html::js('if(window.console && window.console.firebug){'.$this->buffer.($this->grouped?'console.groupEnd();':'').'}else{alert("Firebug is not installed. Thus you are unable to use Samstyle PHP Framework Firebug extension features.");}'));
$this->buffer = '';
}

}


?>