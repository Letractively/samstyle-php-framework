<?php

/* *************************************************
*
*  dba.class.php
*  Samstyle PHP Framework
*  Database Access (DBA) Layer for MySQL, SQLite, and SQLite3
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

private $conn = false;
private $servertype = 'mysql';
private $server;
private $username;
private $password;
private $database;
private $options = array();

private $query = '';
private $actualQuery = '';
private $binds = array();
private $result;
private $lastError = '';

function init(){

}

// $dsn = 'mysql:host=localhost;dbname=dbapp;port=3306';
public function connect($dsn,$u='',$p=''){
    $a = $this->parseConnStr($dsn);
    $this->servertype = $a['servertype'];
    $this->server = $a['server'];
    $this->database = $a['database'];
    $this->options = $a['options'];
    $this->username = $u;
    $this->password = $p;
}

private function parseConnStr($s){
    $a = array();
    $dividerpos = strpos($s,':');
    $a['servertype'] = strtolower(substr($s,0,$dividerpos));
    if($a['servertype']!='uri'){
    $t = array();
    $e = explode(';',substr($s,$dividerpos+1));
    foreach($e as $ele){
        list($key,$value) = explode('=',$ele);
        $t[strtolower(trim($key))] = trim($value);
    }
    if(isset($t['port'])){
        $a['server'] = $t['host'].':'.$t['port'];
    }else{
        $a['server'] = $t['host'];
    }
    $a['database'] = $t['dbname'];
    unset($t['host'],$t['port'],$t['dbname']);
    $a['options'] = $t;
    }else{
         $a['server'] = substr($s,$dividerpos);
    }
    return $a;
}

public function prepare($q){
    $this->binds = array();
    return $this->query = $q;
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
switch($this->servertype){
case 'mysql':
  $this->conn = mysql_connect($this->server,$this->username,$this->password);
  if(!$this->conn){$this->setLastError();return false;}
  $ok = mysql_select_db($this->database);
  if(!$ok){$this->setLastError();return false;}
break;
case 'sqlite':
  $err = '';
  $this->conn = sqlite_open($this->server,0666,&$err);
  if($err != ''){$this->setLastError($err);return false;}
break;
case 'sqlite3':
  $err = '';
  if(isset($this->options['key'])){
      $this->conn = new SQLite3($this->server, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $this->options['key']);
  }else{
      $this->conn = new SQLite3($this->server, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
  }
  if(!$this->conn){$this->setLastError();return false;}
break;
}
}
return $this->conn;
}

private function prepareParam($d,$v){
switch($d){

case 'a': // auto detect
if(is_string($v)){
$value = $this->prepareParam('s',$v);
}elseif(is_numeric($v)){
$value = $this->prepareParam('d',$v);
}else{
$value = $v;
}
break;

case 's': // string
$value = '\''.$this->escapeString($v).'\'';
break;

case 'd': // digit - float or int
if(!is_numeric($v)){return false;}
$value = $v;
break;

case 'i': // integer
if(!is_int($v)){return false;}
$value = (int)$v;
break;

case 'f': // float
if(!is_float($v)){return false;}
$value = (float)$v;
break;

case 'r': // raw, can be SQL function
$value = $v;
break;

default:
return false;
break;
}
return $value;
}

public function getResult(){
return $this->result;
}

public function execute(){
if(!$this->query){return false;}
if($this->countVariable()!=count($this->binds)){return false;}
if(!$this->testConn()){return false;}
$q = $this->query;$t = '';
$i = 0;$l=0;$a=0;
while(($i = strpos($q,'?',$i)) !== false){
if($i>0 && (substr($q, $i-1,1)!='\\' || ($i>1 && substr($q,$i-2,2)=='\\\\'))){
$value = $this->prepareParam($this->binds[$a][0], $this->binds[$a][1]);
if($value === false){return false;}
$t .= substr($q,$l,$i-$l).$value;
$a++;
$l = $i+1;$i++;
}else{
$i++;
}
} // WHILE LOOP
$t.=substr($q,$l); // the rest of the query
$this->result = $this->query($t);
return $this;
}

private function query($q){
$this->actualQuery = $q;
switch($this->servertype){
case 'mysql':
  $r = mysql_query($q);
break;
case 'sqlite':
  $r = sqlite_query($q);
break;
case 'sqlite3':
  $r = $this->conn->query($q);
break;
}
if(!$r){$this->setLastError();}
return $r;
}

private function escapeString($s){
switch($this->servertype){
case 'mysql':
  return mysql_real_escape_string($s);
break;
case 'sqlite':
  return sqlite_escape_string($s);
break;
case 'sqlite3':
  return $this->conn->escapeString($s);
break;
}
}

private function setLastError($err = ''){
if($err != ''){
  $this->lastError = $err;
  return;
}
switch($this->servertype){
case 'mysql':
  if($err = mysql_error()){
    $this->lastError = $err;
  }
break;
case 'sqlite':
  $this->lastError = sqlite_error_string(sqlite_last_error($this->conn));
break;
case 'sqlite3':
  $this->lastError = $this->conn->lastErrorMsg();
break;
}
}

public function fetchNext($into = ''){
if(!$this->result){return false;}
$row = false;
switch($this->servertype){
case 'mysql':
if($into === '' || !class_exists($into)){
$row = mysql_fetch_assoc($this->result);
}else{
$row = mysql_fetch_object($this->result,$into);
}
break;
case 'sqlite':
if($into === '' || !class_exists($into)){
$row = sqlite_fetch_assoc($this->result,SQLITE_ASSOC);
}else{
$row = sqlite_fetch_object($this->result,$into);
}
break;
case 'sqlite3':
if($into === '' || !class_exists($into)){
$row = $this->result->fetchArray(SQLITE3_ASSOC);
}else{
$row = $this->result->fetchArray(SQLITE3_ASSOC);
$o = new $into();
foreach($row as $k => $v){
$o->$k = $v;
}
$row = $o;
unset($o);
}
break;
}
return $row;
}

public function fetch($into = ''){
if(!$this->result){return false;}
$table = array();
switch($this->servertype){
case 'mysql':
if($into === '' || !class_exists($into)){
while($row = mysql_fetch_assoc($this->result)){$table[] = $row;}
}else{
while($row = mysql_fetch_object($this->result,$into)){$table[] = $row;}
}
break;
case 'sqlite':
if($into === '' || !class_exists($into)){
while($row = sqlite_fetch_assoc($this->result,SQLITE_ASSOC)){$table[] = $row;}
}else{
while($row = sqlite_fetch_object($this->result,$into)){$table[] = $row;}
}
break;
case 'sqlite3':
if($into === '' || !class_exists($into)){
while($row = $this->result->fetchArray(SQLITE3_ASSOC)){$table[] = $row;}
}else{
while($row = $this->result->fetchArray(SQLITE3_ASSOC)){
$o = new $into();
foreach($row as $k => $v){
$o->$k = $v;
}
$table[] = $o;
}
}
break;
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
return $this->lastError;
}

public function lastInsertId(){
switch($this->servertype){
case 'mysql':
    return mysql_insert_id();
break;
case 'sqlite':
  return sqlite_last_insert_rowid($this->conn);
break;
case 'sqlite3':
  return $this->conn->lastInsertRowID();
break;
}
}

public function begin(){
return $this->query('BEGIN');
}

public function commit(){
return $this->query('COMMIT');
}

public function rollback(){
return $this->query('rollback');
}

}