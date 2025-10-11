<?php

namespace App\Http\Controllers;

use App\Models\Waktu;
use Illuminate\Http\Request;
use App\Models\WaktuOperasional;
use Illuminate\Support\Facades\Session;

class WaktuController extends Controller
{
    //
    public function index()
    {
        $success = false;
        if (Session::get("success")) {
            $success = Session::get("success");
        }
        $error = false;
        if (Session::get("error")) {
            $error = Session::get("error");
        }

        $waktu_buka = Waktu::where("status", "buka")->get();
        $waktu_tutup = Waktu::where("status", "tutup")->get();

        $waktu_operasional = WaktuOperasional::all();
        // Array referensi untuk urutan hari
        $order = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Ubah koleksi menjadi array dan urutkan berdasarkan referensi
        $waktu_operasional = $waktu_operasional->sortBy(function ($item) use ($order) {
            return array_search($item->hari, $order);
        });

        // Mapping nama hari ke bahasa Indonesia
        $hariIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return view("admin/waktuBukaStudio")->with([
            "waktu_buka" => $waktu_buka,
            "waktu_tutup" => $waktu_tutup,
            "hariIndonesia" => $hariIndonesia,
            "waktu_operasional" => $waktu_operasional,
            "success" => $success,
            "error" => $error,
        ]);
    }
    public function deleteWaktuBuka($id, $deleteAll=false, $status="buka")
    {
        if($deleteAll){
            $waktu = Waktu::where("status", $status)->delete();
            Session::flash("success", "Success delete waktu");
        }else{
            $waktu = Waktu::where("id", $id)->first();
            $waktu->delete();
            Session::flash("success", "Success delete waktu");
        }
        return redirect(route('waktuBukaStudio'));
    }
    public function addWaktuBuka(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'waktu_awal' => 'required',
            'waktu_akhir' => 'required',
            'status' => 'required',
        ]);

        // Cek apakah data dengan tanggal, waktu_awal, dan waktu_akhir sudah ada
        $cek_tanggal = Waktu::where('tanggal', $request->tanggal)
            ->where('waktu_awal', $request->waktu_awal)
            ->where('waktu_akhir', $request->waktu_akhir)
            ->exists();

        if (!$cek_tanggal) {
            // Simpan data ke database
            Waktu::create($validated);

            // Flash pesan sukses
            Session::flash('success', 'Berhasil menambahkan waktu.');
        } else {
            // Flash pesan error jika data sudah ada
            Session::flash('error', 'Data sudah ada.');
        }

        // Redirect kembali ke halaman sebelumnya
        return redirect()->route('waktuBukaStudio');
    }
    public function deleteWaktuOperasional($id)
    {
        $waktu = WaktuOperasional::where("id", $id)->first();
        $waktu->delete();
        Session::flash("success", "Success delete waktu");
        return redirect(route('waktuBukaStudio'));
    }
    public function addWaktuOperasional(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'hari' => 'required',
            'waktu_awal' => 'required',
            'waktu_akhir' => 'required',
        ]);

        // Cek apakah data dengan hari, waktu_awal, dan waktu_akhir sudah ada
        $cek_tanggal = WaktuOperasional::where('hari', $request->hari)
            ->where('waktu_awal', $request->waktu_awal)
            ->where('waktu_akhir', $request->waktu_akhir)
            ->exists();

        if (!$cek_tanggal) {
            // Simpan data ke database
            WaktuOperasional::create($validated);

            // Flash pesan sukses
            Session::flash('success', 'Berhasil menambahkan waktu.');
        } else {
            // Flash pesan error jika data sudah ada
            Session::flash('error', 'Data sudah ada.');
        }

        // Redirect kembali ke halaman sebelumnya
        return redirect()->route('waktuBukaStudio');
    }
}
