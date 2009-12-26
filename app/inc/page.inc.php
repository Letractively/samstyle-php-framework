<?php

class Page{

static private $___instance = NULL;

private $_template = '';
private $_rules = array();
private $_buffer = '';

public static function getInstance(){
if(self::$___instance === NULL){
self::$___instance = new self();
}
return self::$___instance;
}

protected function __construct(){}
protected function __clone(){}

public function setTemplate($file){
$file = 'app/templates/'.basename($file);
if(file_exists($file)){
$this->_template = $file;
return $this;
}else{
return false;
}
}

public function getTemplate(){
return $this->_template;
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
}else{
return $this->_rules[$k];
}
}

public function removeRule($k){
if(is_array($k)){
foreach($k as $d){unset($this->_rules[$d]);}
}else{
unset($this->_rules[$k]);
}
}

public function render(){
if(file_exists($this->_template)){
$this->buffer = file_get_contents($this->_template);
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
$d = file_exists($d) ? $this->parseFile($d) : $d;
$a[] = '{'.$k.'}';$b[] = $d;
}
$this->buffer = str_replace($a,$b,$this->buffer);
}
return $this;
}

private function parseFile($f){
$tmp = $this->getRule('content');
$this->removeRule('content');
include($f);
$buff = $this->getRule('content');
$this->addRule('content',$tmp);
return $buff;
}

public function output(){
return $this->buffer;
}

}


?>