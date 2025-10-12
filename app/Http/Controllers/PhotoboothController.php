<?php

namespace App\Http\Controllers;

use App\Models\HargaPaket;
use Illuminate\Http\Request;

class PhotoboothController extends Controller
{
    //
    public function index()
    {
        $hargaPhotobox = HargaPaket::where("nama_paket", "photobox")->first();
        $hargaBando = 5000;
        $hargaTambahanWaktu = 15000;
        return view("photobooth.index", [
            "hargaPhotobox" => $hargaPhotobox->harga,
            "hargaBando" => $hargaBando,
            "hargaTambahanWaktu" => $hargaTambahanWaktu,
        ]);
    }
    public function final()
    {
        return view('photobooth.final');
    }
}
