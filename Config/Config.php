<?php

if(env("DEBUG") == "false"){
    error_reporting(0);
}

class Config{
    static public function get($key){
        $app = include "../Config/app.php";
        return $app[$key];
    }
}