<?php
namespace Excelent\Helpers;

class Helpers{
    public function autoload($folder){
        foreach(glob($folder."/*") as $files){
            if(is_file($files)){
                $this->requireFiles[] = $files;
            }else{
                $this->autoload($files);
            }
        }
        return $this->requireFiles;
    }
    public function LoadController(){
        require_once "../App/Controller/Controller.php";
        $files = $this->autoload("../App/Controller/");
        foreach($files as $file){
            include_once $file;
        }
    }
    public function LoadModel(){
        require_once "../App/Model/Model.php";
        $files = $this->autoload("../App/Model/");
        foreach($files as $file){
            include_once $file;
        }
    }
    public function LoadConfig(){
        $files = $this->autoload("../Config");
        foreach($files as $file){
            include_once $file;
        }
    }
    public static function require_folder($folder){
        foreach(glob($folder."/*") as $files){
            if(is_file($files)){
                include_once $files;
            }else{
                self::require_folder($files);
            }
        }
    }
}