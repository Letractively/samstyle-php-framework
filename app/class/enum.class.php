<?php

if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Enumerator
*  Created by: Sam Yong | Date/Time: 6:28pm 16th October 2009 GMT+8
*
**************************************************** */

class enum{
    protected $a = array();

    public function __construct(){
        $args = func_get_args();
        foreach($args as $i){
            $this->add($i);
        }
    }
   
    public function __get($name = null){
        return $this->a[$name];
    }
   
    public function add($name=null,$e = null){
        if(isset($e)){
            $this->a[$name] = $e;
        }else{
            $this->a[$name] = end($this->a) + 1;
        }
    }
}

class customenum extends enum{
    public function __construct($itms){
        foreach($itms as $name => $e){
            $this->add($name, $e);
        }
    }
}

class flagsenum extends enum{
    public function __construct(){
        $args = func_get_args();
        for($i=0, $n=count($args),$f=0x1;$i<$n; ++$i, $f *= 0x2 ){
            $this->add($args[$i], $f);
        }
    }
}

?>