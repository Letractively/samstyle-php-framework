<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Include-only LastFormHandler class
*  Created by: Sam Yong | Date/Time: 11:56pm 18th Dec 2009 GMT+8
*
**************************************************** */

class LastFormHandler{

static private $___instance = NULL;
private $key = '__sslastformobj';
private $data = array();
private $error = array();

public static function getInstance(){
if(self::$___instance === NULL){
self::$___instance = new self();
}
return self::$___instance;
}

protected function __construct(){$this->init();}
protected function __clone(){}

private function init(){
if(!is_array($_SESSION[$this->key])){
$_SESSION[$this->key] = array('dat'=>array(),'err'=>array());
}else{
$this->load();
}
}

public function addFormSet($formkey,$d,$e){
$this->data[$formkey] = $d;
$this->error[$formkey] = $e;
return self::$___instance;
}

public function removeFormSet($formkey){
unset($this->data[$formkey]);
unset($this->error[$formkey]);
return self::$___instance;
}

public function addFormData($formkey, $d){
$this->data[$formkey] = $d;
return self::$___instance;
}

public function removeFormData($formkey){
unset($this->data[$formkey]);
return self::$___instance;
}

public function addFormError($formkey, $d){
$this->error[$formkey] = $d;
return self::$___instance;
}

public function removeFormError($formkey){
unset($this->error[$formkey]);
return self::$___instance;
}

public function getFormData($formkey){
return idx($this->data, $formkey);
}

public function getFormError($formkey){
return idx($this->error, $formkey);
}

public function load(){
$this->data = $_SESSION[$this->key]['dat'];
$this->error = $_SESSION[$this->key]['err'];
return self::$___instance;
}

public function commit(){
$_SESSION[$this->key]['dat'] = $this->data;
$_SESSION[$this->key]['err'] = $this->error;
return self::$___instance;
}

public function deterValue($default='',$postback=''){
if($postback !== '' && isset($postback)){
return $postback;
}elseif($default !== '' && isset($default)){
return $default;
}else{
return '';
}
}

}