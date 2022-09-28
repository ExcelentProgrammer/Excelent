<?php

use Excelent\Helpers\View;
use Pecee\SimpleRouter\SimpleRouter as Route;
use Pecee\Http\Request;
use Excelent\Error\Error;
use App\Controller\Controller;

/**
 * Routerlar uchun asosiy example
 * Routelarni boshqarish haqida to'liq malumot https://Excelent.ga/docs#route
 */
Route::get("/", function () {
    return view("welcome");
})->name("Home");


