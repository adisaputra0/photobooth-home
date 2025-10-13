<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhotoboothTemplate;

class PhotoboothTemplateController extends Controller
{
    //
    public function index()
    {
        $templates = PhotoboothTemplate::all();
        return view('photobooth.template', ['templates' => $templates]);
    }
}
