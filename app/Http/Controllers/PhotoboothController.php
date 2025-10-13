<?php

namespace App\Http\Controllers;

use App\Models\HargaPaket;
use Illuminate\Http\Request;
use App\Models\PhotoboothPhotos;

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
    public function store(Request $request)
    {
        // Handle file upload jika ada
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            foreach ($files as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/photobooth'), $filename);

                // Simpan informasi file ke database
                PhotoboothPhotos::create([
                    'file_path' => 'uploads/photobooth/' . $filename,
                ]);
            }
        }

        return redirect()->route('photobooth.template');
    }
    public function final()
    {
        $photos = PhotoboothPhotos::all();
        return view('photobooth.final', ['photos' => $photos]);
    }
}
