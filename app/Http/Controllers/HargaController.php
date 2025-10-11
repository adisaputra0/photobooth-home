<?php

namespace App\Http\Controllers;

use App\Models\HargaPaket;
use App\Models\HargaPerOrang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HargaController extends Controller
{
    public function index()
    {
        $success = false;
        if (Session::get("success")) {
            $success = Session::get("success");
        }

        $hargaPaket = HargaPaket::all();
        $hargaPerOrang = HargaPerOrang::find(1);

        return view("admin/harga")->with([
            "hargaPaket" => $hargaPaket,
            "hargaPerOrang" => $hargaPerOrang,
            "success" => $success,
        ]);
    }
    public function updateHargaPaket(Request $request)
    {
        $harga = HargaPaket::find($request->id);
        $harga->update([
            "harga" => $request->harga,
        ]);
        $message = "Success update harga paket " . number_format($request->harga, 0, ',', '.');
        Session::flash("success", $message);
        return redirect(route('harga'));
    }
    public function updateHargaPerOrang(Request $request)
    {
        $harga = HargaPerOrang::find($request->id);
        $harga->update([
            "harga" => $request->harga,
        ]);
        $message = "Success update harga per orang " . number_format($request->harga, 0, ',', '.');
        Session::flash("success", $message);
        return redirect(route('harga'));
    }
}
