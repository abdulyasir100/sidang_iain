<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function Show($filename){
        $path = storage_path('app\file\\').$filename.".pdf";
        $header = [
            'Content-Type','text/plain'
        ];
        return response()->file($path,$header);
    }
}
