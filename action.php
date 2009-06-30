<?php
include('inc/head.inc.php');

// for ajax returns
$result = array();
$post = parse_http_args($_POST, array());
$get = parse_http_args($_GET, array());

if(count($_POST) == 0 && count($_GET)== 0){header('Location: index.php');exit();}

if(count($_POST) > 0  && count($_GET) > 0){
// get and post

}else if(count($_POST) > 0){
// post only

switch(strtolower($_POST['action'])){

}


}else{
// get only

switch(strtolower($_GET['a'])){
}

}


if($get['callback']){echo $get['callback'].'(';}
echo json_encode($return);
if($get['callback']){echo ');';}
?>