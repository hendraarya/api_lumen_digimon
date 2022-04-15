<?php

namespace App\Http\Controllers;

class ExcelController extends Controller
{
    public function index(){
        return response()->json([
            'status' => 'succes'
        ]);
    }
}
