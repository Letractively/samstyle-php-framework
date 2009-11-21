<?php

if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  String Object
*  Created by: Sam Yong | Date/Time: 10:17pm 19th October 2009 GMT+8
*
**************************************************** */

class string extends base{

  private $os = '';

  function __construct($s=''){
    $this->os = $s;
  }
  
  public function substr($idx, $len = false){
    if($len === false){
       $this->os = substr($this->os, $idx);
    }else{
       $this->os = substr($this->os, $idx, $len);
    }
    return $this;
  }

  public function trim(){
    $this->os = trim($this->os);
    return $this;
  }

  public function ltrim(){
    $this->os = ltrim($this->os);
    return $this;
  }

  public function rtrim(){
    $this->os = rtrim($this->os);
    return $this;
  }

  public function split($d){
    return explode($d,$this->os);
  }

  public function rotate($by){
    $this->os = php::str_shift($this->os,$by);
    return $this;
  }

  public function indexOf($s){
    return strpos($this->os,$s);
  }

  public function lastIndexOf($s){
    return strrpos($this->os,$s);
  }

  public function match($regex){
    $matches = array();
    preg_match_all($regex,$this->os,$matches,PREG_SET_ORDER);
    return $matches;
  }

  public function replace($a, $b){
    $this->os = str_replace($a, $b, $this->os);
    return $this;
  }

  public function length(){
    return strlen($this->os);
  }

  public function tolower(){
    $this->os = strtolower($this->os);
    return $this;
  }

  public function toupper(){
    $this->os = strtoupper($this->os);
    return $this;
  }

  public function value(){
    return $this->os;
  }

  function __toString(){
    return $this->os;
  }




}

?>