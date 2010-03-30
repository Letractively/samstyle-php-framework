<?php

if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){exit();}

/* ****************************************************
*
*  Samstyle PHP Framework
*  Base object
*  Created by: Sam Yong | Date/Time: 10:17pm 19th October 2009 GMT+8
*
**************************************************** */

class CSRFProtect{

    private static $key = '_?:csrfprotect';
    public static $error_handler = '';
    private static $enabled = false;

    static function is_enabled(){
        return self::$enabled;
    }

    static function generate_token(){
        return sha1(session_id().$_SERVER['REQUEST_TIME'].self::$key);
    }

    static function get_field_name(){
        return '_csrf_'.dechex(crc32(session_id())).'_token';
    }

    public static function create_form_token($expire = 0){
        $token = self::generate_token();
        if(!is_array($_SESSION[self::$key])){
            $_SESSION[self::$key] = array();
        }
        $_SESSION[self::$key][] = array($token,($expire<=0?0:(time()+$expire)));
        return $token;
    }

    private static function gc_handler(){
        if(!is_array($_SESSION[self::$key])){
            $_SESSION[self::$key] = array();
        }
        foreach($_SESSION[self::$key] as &$a){
            if($a[1] > 0 && $a[1] < time()){
                unset($a);
            }
        }
    }

    private static function call_error_handler(){
        if(!self::$error_handler){
            die('A CSRF attack has been detected.');
        }else{
            call_user_func(self::$error_handler);
            exit();
        }
    }

    public static function enable(){
        self::$enabled = true;
        $field = self::get_field_name();
        self::gc_handler();
        if(count($_POST)>0){
            // there's some post content incoming
            if(!isset($_POST[$field])){
                self::call_error_handler();
            }else{
                foreach($_SESSION[self::$key] as $a){
                    if($_POST[$field] == $a[0]){
                        return true;
                        break;
                    }
                }
                self::call_error_handler();
            }
        }
    }

    public static function disable(){
        self::$enabled = false;
    }

    static function ob_rewrite($html){
        $matches = array();
        $field = self::get_field_name();

        $hidden = '<div style="display: none;"><input type="hidden" name="';
        $hidden .= $field . '" value="' . self::create_form_token();
        $hidden .= '" /></div>';

        return preg_replace(
            '/(<form\W[^>]*\bmethod=(\'|"|)POST(\'|"|)\b[^>]*>)/i',
            '\\1'.$hidden,
            $html
        );
   }
}
