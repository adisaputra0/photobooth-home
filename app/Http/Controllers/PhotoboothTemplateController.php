<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoboothTemplateController extends Controller
{
    //
    public function index()
    {
        return view('photobooth.template');
    }
}
