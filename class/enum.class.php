<?php

if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Enumerator
*  Created by: Sam Yong | Date/Time: 6:28pm 16th October 2009 GMT+8
*
**************************************************** */

class enum {
    protected $self = array();
    public function __construct() {
        $args = func_get_args();
        for( $i=0, $n=count($args);$i<$n;++$){
            $this->add($args[$i]);
        }
    }
   
    public function __get($name = null ) {
        return $this->self[$name];
    }
   
    public function add($name = null, $enum = null ) {
        if(isset($enum)){
            $this->self[$name] = $enum;
        }else{
            $this->self[$name] = end($this->self) + 1;
        }
    }
}

class customenum extends enum {
    public function __construct($itms) {
        foreach($itms as $name => $enum){
            $this->add($name, $enum);
        }
    }
}

class flagsEnum extends enum {
    public function __construct() {
        $args = func_get_args();
        for($i=0, $n=count($args),$f=0x1;$i<$n; ++$i, $f *= 0x2 ){
            $this->add($args[$i], $f);
        }
    }
}

?>