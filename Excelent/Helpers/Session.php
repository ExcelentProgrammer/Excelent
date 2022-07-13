<?php
namespace Excelent\Helpers;
session_start();
class Session{
    static public function create($key,$value){
        $_SESSION[$key] = $value;
    }
    static public function get($key){
        return $_SESSION[$key];
    }
    static public function destroy(){
        session_destroy();
    }
    static public function del($key){
        unset($_SESSION[$key]);
        return true;
    }
}