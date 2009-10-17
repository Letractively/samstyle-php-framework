<?php
chdir('../');
include('inc/head.inc.php'); // include the core and engine

/* ****************************************************
*
*  Samstyle PHP Framework
*  Deck Data Controller - for handling all form post and get request and handling DB access
*  Created by: Sam Yong | Date/Time: 10:44am 30 June 2009 GMT+8
*
**************************************************** */

// for ajax returns
$result = array();

if(count($post) == 0 && count($get)== 0){redirect('index.php');}

if(count($post) > 0  && count($get) > 0){
// get and post

}else if(count($_POST) > 0){
// post only

switch(strtolower($post['action'])){

}


}else{
// get only

switch(strtolower($get['a'])){
}

}


if($get['callback']){echo $get['callback'].'(';}
echo json_encode($result);
if($get['callback']){echo ');';}
?>