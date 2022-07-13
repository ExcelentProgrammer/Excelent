<?php

namespace Excelent\Helpers;
use Excelent\Error\Error;
class View
{
    static public function file($file, array $vars = [])
    {
        $file = "../Excelent/View/" . $file . ".php";
        if (is_readable($file)) {
            if (!empty($vars)) {
                foreach ($vars as $key => $value) {
                    $$key = $value;
                }
            }
            return include_once $file;
        } else {
            $file = str_replace("..", "", $file);
            Error::error(["message" => "View classi File funcsiyasida funcsiyasida ko'rsatilgan $file.php fayili mavjud emas !!!", "trace" => [1 => ["file" => "$file.php"]]]);
            return false;
        }
    }
}
