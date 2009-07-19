<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

class http{

public static function redirect($u){
header('Location: '.$u);exit;
}

public static function domain($u){
$i=parse_url($u);if(isset($i['host'])){return $i['host'];}return $i['path'];
}

function exists($u) {
if(function_exists('curl_init')){ // preferring curl over get_headers. check whether curl is supported or not
    // Version 4.x supported
    $handle   = curl_init($url);
    if (false === $handle)
    {
        return false;
    }
    curl_setopt($handle, CURLOPT_HEADER, false);
    curl_setopt($handle, CURLOPT_FAILONERROR, true); 
    curl_setopt($handle, CURLOPT_HTTPHEADER, array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") );
    curl_setopt($handle, CURLOPT_NOBODY, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
    $c = curl_exec($handle);
    curl_close($handle);  
    return $c;
}else{
return (bool)get_headers($u);
}
}

}

?>