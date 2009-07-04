<?php
include('inc/head.inc.php');

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
echo json_encode($return);
if($get['callback']){echo ');';}
?>