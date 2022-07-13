<?php

use Pecee\SimpleRouter\SimpleRouter as Route;
use Pecee\Http\Request;
use Excelent\Error\Error;
use App\Controller\Controller;
use App\Controller\FilmController;
use App\Controller\HomeController;
use App\Controller\WatchController;

/**
 * Routerlar uchun asosiy example
 * Routelarni boshqarish haqida to'liq malumot https://Excelent.ga/docs#route
 */
Route::get("/",function(){
    return view("welcome");
});

/**
 * Errorlar uchun bu ko'dlarni o'chirish mumkun emas
 * o'zgartirish mumkun error sahifani o'zgartish uchun
 * lekin o'chirib tashlansa sahifa topilmaganda xatolik yuz beradi
 */


Route::get("/error/{code}",[Controller::class,"error"])->name("error");
Route::error(function(Request $request, \Exception $exception) {

    switch($exception->getCode()) {
        // Page not found
        case 404:
            response()->redirect(route("error",['code'=>"404"]));
        // Forbidden
        case 403:
            response()->redirect(route("error",['code'=>"403"]));
    }
    
});