<?php

namespace Excelent\Error;
use Excelent\Helpers\View;
use Pecee\SimpleRouter\SimpleRouter;

class Error
{
    static public function error($data)
    {
        if (empty($_FILES['Error'])) {
            $_FILES['Error'] = $data;
        }
    }
    static public function get()
    {
        if (!empty($_FILES['Error'])) {
            return $_FILES['Error'];
        } else {
            return false;
        }
    }
    static public function view()
    {
        if ($_FILES['Error'] and env("DEBUG") == "true") {
            ob_clean();
            $Error = (object) self::get();
            return View::file("error",["Error"=>$Error]);
        }
    }
    static public function destroy()
    {
        unset($_FILES['Error']);
    }
   
}
