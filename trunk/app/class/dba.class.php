<?php

/* *************************************************
*
*  dba.class.php
*  Samstyle PHP Framework
*  Database Access (DBA) Layer for DB
*
************************************************* */

class DBA{

static private $___instance = NULL;
public static function getInstance(){
if(self::$___instance === NULL){
self::$___instance = new self();
}
return self::$___instance;
}

protected function __construct(){$this->init();}
protected function __clone(){}

private $conn;
private $server;
private $username;
private $password;
private $database;

private $query = '';
private $actualQuery = '';
private $binds = array();
private $result;

function init(){

}

public function connect($s, $u, $p, $d){
    $this->server = $s;
    $this->username = $u;
    $this->password = $p;
    $this->database = $d;
}

public function prepare($q){
    $this->query = $q;
}

private function countVariable(){
    $t = $this->query;
    $t = str_replace(array('\\\\','\\?'),'',$t);
    return substr_count($t,'?');
}

public function bind($type, $var){
    $this->binds[] = array($type,$var);
}

private function testConn(){
if(!$this->conn){
$this->conn = mysql_connect($this->server,$this->username,$this->password);
mysql_select_db($this->database);
}
return $this->conn;
}

public function execute(){
if(!$this->query){return false;}
if($this->countVariable()!=count($this->binds)){return false;}
if(!$this->testConn()){return false;}
if($this->result){mysql_free_result($this->result);}
$q = $this->query;$t = '';
$i = 0;$l=0;$a=0;
while(($i = strpos($q,'?',$i)) !== false){
if($i>0 && (substr($q, $i-1,1)!='\\' || ($i>1 && substr($q,$i-2,2)=='\\\\'))){
switch($this->binds[$a][0]){

case 's': // string
$value = '\''.mysql_real_escape_string($this->binds[$a][1]).'\'';
break;

case 'd': // digit - float or int
if(!is_numeric($this->binds[$a][1])){return false;}
$value = $this->binds[$a][1];
break;

case 'i': // integer
if(!is_int($this->binds[$a][1])){return false;}
$value = (int)$this->binds[$a][1];
break;

case 'f': // float
if(!is_float($this->binds[$a][1])){return false;}
$value = (float)$this->binds[$a][1];
break;

case 'r': // raw, can be SQL function
$value = $this->binds[$a][1];
break;

default:
return false;
break;
}
$t .= substr($q,$l,$i-$l).$value;
$a++;
$l = $i+1;$i++;
}else{
$i++;
}
} // WHILE LOOP
$t.=substr($q,$l); // the rest of the query
$this->result = mysql_query($t);
$this->actualQuery = $t;
return $this->result ? true : false;
}

public function fetch($into = '',$callback = false){
if(!$this->result){return false;}
$table = array();$usecb = ($callback !== false);
if($into !== '' && class_exists($into)){
while($row = mysql_fetch_object($this->result,$into)){$table[] = $row;if($usecb){call_user_func($callback,$row);}}
}else{
while($row = mysql_fetch_assoc($this->result)){$table[] = $row;if($usecb){call_user_func($callback,$row);}}
}
return $table;
}

public function fetchValue($column, $rowIndex = 0){
$table = $this->fetch();
return $table[$rowIndex][$column];
}

public function getLastQuery(){
return $this->query;
}

public function getLastActualQuery(){
return $this->actualQuery;
}

public function getLastError(){
return mysql_error();
}

public function lastInsertId(){
return mysql_insert_id();
}

public function begin(){
mysql_query('BEGIN');
}

public function commit(){
mysql_query('COMMIT');
}

public function rollback(){
mysql_query('rollback');
}

}

?>