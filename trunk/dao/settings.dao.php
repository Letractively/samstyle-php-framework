<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

function settings_Create($key,$value){ if(trim($key) == '' || trim($value) == ''){ return false; }
$sql_query = sprintf('INSERT INTO `settings` (`key`, `value`) VALUES (\'%s\',\'%s\')',mysql_real_escape_string($key),mysql_real_escape_string($value));
$r = @mysql_query($sql_query);return mysql_retExec($r);}

function settings_Get($key){if(trim($key) == ''){return false;}
$sql_query = sprintf('SELECT `value` FROM `settings` WHERE `key` = \'%s\'',mysql_real_escape_string($key));
$r = @mysql_query($sql_query);return mysql_retValue($r,'value']);}

function settings_Delete($key){if(trim($key) == ''){return false;}
$sql_query = sprintf('DELETE FROM `settings` WHERE `key` = \'%s\'',mysql_real_escape_string($key));
$r = @mysql_query($sql_query);return mysql_retExec($r);}

function settings_Edit($key,$value){ if(trim($key) == '' || trim($value) == ''){ return false; }
$sql_query = sprintf('UPDATE `settings` SET `value` = \'%s\' WHERE `key` = \'%s\'',mysql_real_escape_string($value),mysql_real_escape_string($key));
$r = @mysql_query($sql_query); return mysql_retExec($r);}

function settings_GetAll(){$sql_query = 'SELECT * FROM `settings`';
$r = @mysql_query($sql_query);return mysql_retAllRows($r);}

function settings_Count(){$sql_query = 'SELECT Count(`key`) FROM `settings`';
$r = @mysql_query($sql_query);return (int)mysql_retValue($r,'Count(`key`)']);}

?>