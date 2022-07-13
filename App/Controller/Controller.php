<?php

namespace App\Controller;

use Excelent\Helpers\View;

class Controller
{
    public function error($code)
    {
        if ($code == 404)
        $message = "Sahifa topiladi";
        View::file("404", ['code' => $code, "message" => $message]);
    }
}
