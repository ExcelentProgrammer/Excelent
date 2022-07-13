<?php

use Excelent\Error\Error;

function env($key, $default = "")
{
    if (!empty($_ENV[$key])) {
        return $_ENV[$key];
    } else {
        return $default;
    }
}

function view($file, $vars = [])
{
    $file = str_replace(".", "/", $file);
    $folder = "../App/View/";
    $file = $folder . $file;
    $_FILES['vars'] = $vars;
    if (!empty($vars)) {
        foreach ($vars as $key => $value) {
            $$key = $value;
        }
    }
    if (is_readable($file . ".php")) {
        include_once $file . ".php";
    } else {
        $file = str_replace("..", "", $file);
        Error::error(["message" => "view funcsiyasida ko'rsatilgan $file.php fayili mavjud emas !!!", "trace" => [1 => ["file" => "$file.php"]]]);
    }
}

function asset($file)
{
    $file = "//" . $_SERVER['SERVER_NAME'].":". $_SERVER['SERVER_PORT'].$_SERVER[''] . "/Assets/" . $file;
    return $file;
}

function dd($content)
{
    print_r($content);
    die();
}

