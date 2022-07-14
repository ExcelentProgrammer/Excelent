<?php

namespace App\Controller;
use Pecee\Http\Request;
use Excelent\Database\DB;

class ControllerName extends Controller
{
    /**
     * index
     *
     * @return void
     * barcha malumotlarni ko'rsating
     */
    public function index(Request $request)
    {
        //code
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     * bitta malumotni ko'rsating
     */
    public function show(Request $request,$id)
    {
        // code
    }
    
    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     * Malumotni o'zgartirish
     */
    public function edit(Request $request, $id)
    {
        // code
    }
    
    /**
     * destory
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     * malumotni o'chirish
     */
    public function destory(Request $request, $id)
    {
        // code
    }
}
