<?php
use Pecee\SimpleRouter\SimpleRouter as Route;
use Pecee\Http\Request;

use Excelent\Helpers\View;



Route::error(function (Request $request, \Exception $exception) {

    switch ($exception->getCode()) {
        // Page not found
        case 404:
            View::file("404", ['code' => "404", "message" => "Sahifa topilmadi"]);
            break;
        // Forbidden
        case 403:
            View::file("404", ['code' => "403", "message" => "Forbidden"]);
            break;

    }
});