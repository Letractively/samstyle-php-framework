<?php

class Page{

static private $___instance = NULL;

private $_template = '';
private $_headers = array();
private $_rules = array();
private $_buffer = '';
private $_file = '';

public static function getInstance(){
if(self::$___instance === NULL){
self::$___instance = new self();
}
return self::$___instance;
}

protected function __construct(){}
protected function __clone(){}

public function setTemplate($file){
$this->_template = $file;
}

public function getTemplate(){
return $this->_template;
}

public function setFileOutput($f){
if(is_writable($f)){
$this->_file = $f;
}else{
return false;
}
}

public function getFileOutput(){
return $this->_file;
}

public function addHeader($k,$v){
$this->_headers[$k] = $v;
}

public function removeHeader($k){
unset($this->_headers[$k]);
}

public function getHeader($k){
return $this->_headers[$k];
}

public function addRule($k, $v = false){
if($v === false && is_array($k)){
$this->_rules = array_merge($this->_rules,$k);
}else{
$this->_rules[$k] = $v;
}
return $this;
}

public function getRule($k=false){
if($k === false){
return $this->_rules;
}elseif(isset($this->_rules[$k])){
return $this->_rules[$k];
}
}

public function removeRule($k){
    if(is_array($k)){
        foreach($k as $d){
            unset($this->_rules[$d]);
        }
    }else{
        unset($this->_rules[$k]);
    }
}

public function render(){
if(@file_exists('app/templates/'.$this->_template) && is_file('app/templates/'.$this->_template)){
    $this->buffer = file_get_contents('app/templates/'.$this->_template);
}else{
    $this->buffer = '{content}';
}
if(isset($this->_rules['content'])){
    $this->buffer = str_replace('{content}',$this->_rules['content'],$this->buffer);
    unset($this->_rules['content']);
}
if(count($this->_rules)>0){
    $a = array();$b = array();
    foreach($this->_rules as $k => $d){
        $d = file_exists($d) && is_file($d) ? $this->parseFile($d) : $d;
        $a[] = '{'.$k.'}';
        $b[] = $d;
    }
    $this->buffer = str_replace($a,$b,$this->buffer);
}

if(CSRFProtect::is_enabled()){
    $this->buffer = CSRFProtect::ob_rewrite($this->buffer);
}

foreach($this->_headers as $k => $v){
    header($k.': '.$v);
}

return $this;
}

private function parseFile($_file){
$tmp = $this->getRule('content');
$this->removeRule('content');
foreach($GLOBALS as $k => $v){
if(in_array($k,array('tmp','_file','this','buff'))){continue;}
global $$k;
}
include($_file);
$buff = $this->getRule('content');
$this->addRule('content',$tmp);
return $buff;
}

public function output(){
if($this->_file){
file_put_contents($this->_file,$this->buffer);
return 'File output to '.$this->_file;
}else{
return $this->buffer;
}
}

}


?>