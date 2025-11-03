<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhotoboothPhoto;
use App\Models\PhotoboothTemplate;

class PhotoboothController extends Controller
{
    //
    public function index()
    {
        // $photos = PhotoboothPhoto::all();
        // if($photos){
        //     $this->destroyAll();
        // }
        $hargaPhotobox = 30000;
        $hargaBando = 5000;
        $hargaTambahanWaktu = 15000;
        $hargaTambahanWaktuStudio = 35000;
        $hargaPacketStudio = 90000;
        $hargaStudio = 35000;
        $hargaTirai = 40000;
        $hargaSpotlight = 40000;
        return view("photobooth.index", [
            "hargaPhotobox" => $hargaPhotobox,
            "hargaBando" => $hargaBando,
            "hargaPacketStudio" => $hargaPacketStudio,
            "hargaStudio" => $hargaStudio,
            "hargaTirai" => $hargaTirai,
            "hargaSpotlight" => $hargaSpotlight,
            "hargaTambahanWaktu" => $hargaTambahanWaktu,
            "hargaTambahanWaktuStudio" => $hargaTambahanWaktuStudio,
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
    public function final()
    {
        // $photos = PhotoboothPhoto::all();
        $templates = PhotoboothTemplate::all()->keyBy('id')->map(function ($template) {
            return [
                'id' => $template->id,
                'name' => $template->name,
                'file_path' => asset($template->file_path), // Pastikan asset() digunakan
                'slots' => $template->slots
            ];
        });
        // return view('photobooth.final', ['photos' => $photos, 'templates' => $templates]);
        return view('photobooth.final', ['templates' => $templates]);
    }
    public function savePhoto(Request $request)
    {
        try {
            $image = $request->input('image');
            $filename = $request->input('filename', 'photo.jpg');

            // 🔹 Hapus prefix base64
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageData = base64_decode($image);

            // 🔹 Path tujuan penyimpanan
            $path = public_path('uploads/photobooth/' . $filename);

            // 🔹 Pastikan folder ada
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0777, true);
            }

            // 🔹 Simpan file ke folder public/uploads/photobooth
            file_put_contents($path, $imageData);

            return response()->json(['success' => true, 'path' => $path]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function gantunganKunci()
    {
        return view('photobooth.gantungan_kunci');
    }
}
