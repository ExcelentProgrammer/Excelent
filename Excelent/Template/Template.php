<?php

use Excelent\Error\Error;

class File
{
    public static function yield($content)
    {
        if (!empty($_FILES[$content])) {
            $vars = (object) $_FILES['vars'];
            foreach ($vars as $key => $value) {
                global $$key;
                $$key = $value;
            }
            print_r(call_user_func($_FILES[$content], $vars));
        }
    }
    public static function section($content, object $function)
    {
        $code = $function;
        $_FILES[$content] = $code;
    }
    public static function extends($file)
    {
        $file = str_replace(".", "/", $file);
        $file = "../App/View/" . $file . ".php";
        if (file_exists($file)) {
            $vars = (object) $_FILES['vars'];
            require_once $file;
        } else {
            echo "Extends Qilingan Fayil Topilmadi";
        }
    }
    public static function include($file){
        $file = str_replace(".","/",$file).".php";
        $file = "../App/View/".$file;
        if(is_readable($file)){
            include $file;
        }else{
            $file = str_replace("..","",$file);
            Error::error(['message'=>"include Qilmoqchi bo'linga fayil topilmadi $file","trace"=>[['file'=>$file]]]);
        }
    }
}
