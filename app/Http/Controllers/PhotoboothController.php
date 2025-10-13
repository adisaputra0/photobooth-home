<?php

namespace App\Http\Controllers;

use App\Models\HargaPaket;
use Illuminate\Http\Request;
use App\Models\PhotoboothPhoto;
use App\Models\PhotoboothTemplate;

class PhotoboothController extends Controller
{
    //
    public function index()
    {
        $photos = PhotoboothPhoto::all();
        if($photos){
            $this->destroyAll();
        }
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
                PhotoboothPhoto::create([
                    'file_path' => 'uploads/photobooth/' . $filename,
                ]);
            }
        }

        return redirect()->route('photobooth.template');
    }
    //destroy all photos
    public function destroyAll()
    {
        $photos = PhotoboothPhoto::all();
        foreach ($photos as $photo) {
            // Hapus file fisik jika ada
            if (file_exists(public_path($photo->file_path))) {
                unlink(public_path($photo->file_path));
            }
            // Hapus data dari database
            $photo->delete();
        }  
        return redirect()->route('photobooth');
    }
    public function final() {
        $photos = PhotoboothPhoto::all();
        $templates = PhotoboothTemplate::all()->keyBy('id');
        return view('photobooth.final', ['photos' => $photos, 'templates' => $templates]);
    }
}
