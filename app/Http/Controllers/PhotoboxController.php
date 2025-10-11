<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Waktu;
use App\Models\Booking;
use App\Models\Photobox;
use App\Models\HargaPaket;
use App\Models\GambarBando;
use Illuminate\Http\Request;
use App\Models\HargaPerOrang;
use App\Models\WaktuOperasional;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PhotoboxController extends Controller
{
    public function index()
    {
        $hargaPhotobox = HargaPaket::where("nama_paket", "photobox")->first();
        $hargaBando = 5000;
        $hargaTambahanWaktu = 15000;
        return view("photobox/index", [
            "hargaPhotobox" => $hargaPhotobox->harga,
            "hargaBando" => $hargaBando,
            "hargaTambahanWaktu" => $hargaTambahanWaktu,
        ]);
    }

    public function cashierPhotobox()
    {
        $hargaPerOrang = HargaPaket::where("nama_paket", "photobox")->first()->harga;
        return view("cashierAdminPhotobox")->with([
            "hargaPerOrang" => $hargaPerOrang
        ]);
    }

    public function time($date)
    {
        $data = Photobox::where("tanggal", $date)->get();

        for ($i = 8; $i <= 22; $i++) {
            $nama = ($i < 10) ? "0$i:00" : "$i:00";
            $nama3 = ($i < 10) ? "0$i:30" : "$i:30";
            $condition1 = true;
            $condition3 = true;


            // Cek apakah tanggal yang dipilih lebih lama atau lebih baru dari hari ini (kemarin atau di masa depan)
            $tanggalTerpilih = Carbon::parse($date);
            $sekarang = Carbon::now();
            $selisihHari = $tanggalTerpilih->diffInDays($sekarang);
            $selisihHariNegatif = $tanggalTerpilih->diffInDays($sekarang, false); // Menghitung dengan selisih negatif jika di masa depan
            if ($selisihHari > 0) {
                // Jika lebih dari 0 hari, berarti tanggal yang dipilih adalah di masa lalu (kemarin, minggu lalu, tahun lalu)
                $condition1 = true;
                $condition3 = true;
            }
            // Cek jika tanggal yang dipilih lebih depan
            if ($selisihHariNegatif > 0) {
                // Jika tanggal lebih besar dari hari ini, berarti di masa depan
                $condition1 = false;  // Biarkan waktu tersedia
                $condition3 = false;  // Biarkan waktu tersedia
            }


            if ($date == now()->format('Y-m-d')) {
                // Periksa jam yang dipilih sudah lewat
                $waktu_sekarang = Carbon::now()->setTimezone('Asia/Makassar')->format('H:i');
                $waktu_sekarang1 = explode(":", $waktu_sekarang)[0];
                $waktu_sekarang2 = explode(":", $waktu_sekarang)[1];

                $nama_1 = explode(":", $nama)[0];
                $nama_2 = explode(":", $nama)[1];

                $nama3_1 = explode(":", $nama3)[0];
                $nama3_2 = explode(":", $nama3)[1];

                if ($nama_1 < $waktu_sekarang1) {
                    $condition1 = false;
                } else if ($nama_1 == $waktu_sekarang1 && $nama_2 < $waktu_sekarang2) {
                    $condition1 = false;
                }

                if ($nama3_1 < $waktu_sekarang1) {
                    $condition3 = false;
                } else if ($nama3_1 == $waktu_sekarang1 && $nama3_2 < $waktu_sekarang2) {
                    $condition3 = false;
                }
            }

            //Sekarang cek untuk harinya
            // if($condition1 || $condition3){
            //     $hari = Carbon::parse($date)->setTimezone('Asia/Makassar')->format('l');
            //     if($hari != "Saturday" && $hari != "Sunday"){
            //         for($x = 8; $x <= 13; $x++){
            //             $cekNama = ($x < 10) ? "0$x" : "$x";
            //             $nama_1 = explode(":", $nama)[0];
            //             if($cekNama == $nama_1){
            //                 $condition1 = false;
            //                 $condition3 = false;
            //             }
            //         }
            //     }
            // }

            //Sekarang cek tanggal libur
            if ($condition1) {
                $hari = Carbon::parse($date)->setTimezone('Asia/Makassar')->format('l');
                $waktu_tutup_operasional = WaktuOperasional::where("hari", $hari)->get();
                if ($waktu_tutup_operasional) {
                    foreach ($waktu_tutup_operasional as $data_operasional) {
                        for ($x = $data_operasional->waktu_awal; $x <= $data_operasional->waktu_akhir; $x++) {
                            $cekNama = ($x < 10) ? "0$x" : "$x";
                            $nama_1 = explode(":", $nama)[0];
                            if ($cekNama == $nama_1) {
                                $condition1 = false;
                            }
                        }
                    }
                }
                // if($hari == "Tuesday" || $hari == "Thursday"){
                //     for($x = 8; $x <= 13; $x++){
                //         $cekNama = ($x < 10) ? "0$x" : "$x";
                //         $nama_1 = explode(":", $nama)[0];
                //         if($cekNama == $nama_1){
                //             $condition1 = false;
                //         }
                //     }
                // }else if($hari == "Friday" || $hari == "Wednesday"){
                //     for($x = 8; $x <= 11; $x++){
                //         $cekNama = ($x < 10) ? "0$x" : "$x";
                //         $nama_1 = explode(":", $nama)[0];
                //         if($cekNama == $nama_1){
                //             $condition1 = false;
                //         }
                //     }
                // }
            }
            if ($condition3) {
                $hari = Carbon::parse($date)->setTimezone('Asia/Makassar')->format('l');

                $waktu_tutup_operasional = WaktuOperasional::where("hari", $hari)->get();
                if ($waktu_tutup_operasional) {
                    foreach ($waktu_tutup_operasional as $data_operasional) {
                        for ($x = $data_operasional->waktu_awal; $x <= $data_operasional->waktu_akhir; $x++) {
                            $cekNama = ($x < 10) ? "0$x" : "$x";
                            $nama_1 = explode(":", $nama)[0];
                            if ($cekNama == $nama_1) {
                                $condition3 = false;
                            }
                        }
                    }
                }
                // if($hari == "Tuesday" || $hari == "Thursday"){
                //     for($x = 8; $x <= 13; $x++){
                //         $cekNama = ($x < 10) ? "0$x" : "$x";
                //         $nama_1 = explode(":", $nama)[0];
                //         if($cekNama == $nama_1){
                //             $condition3 = false;
                //         }
                //     }
                // }else if($hari == "Friday" || $hari == "Wednesday"){
                //     for($x = 8; $x <= 11; $x++){
                //         $cekNama = ($x < 10) ? "0$x" : "$x";
                //         $nama_1 = explode(":", $nama)[0];
                //         if($cekNama == $nama_1){
                //             $condition3 = false;
                //         }
                //     }
                // }
            }

            $waktu_model = Waktu::where("tanggal", $date)->where("status", "buka")->get();
            if ($waktu_model) {
                foreach ($waktu_model as $data_waktu) {
                    for ($j = $data_waktu->waktu_awal; $j <= $data_waktu->waktu_akhir; $j++) {
                        if ($j == $i) {
                            $condition1 = true;
                            $condition3 = true;
                        }
                    }
                }
            }
            $waktu_model = Waktu::where("tanggal", $date)->where("status", "tutup")->get();
            if ($waktu_model) {
                foreach ($waktu_model as $data_waktu) {
                    for ($j = $data_waktu->waktu_awal; $j <= $data_waktu->waktu_akhir; $j++) {
                        if ($j == $i) {
                            $condition1 = false;
                            $condition3 = false;
                        }
                    }
                }
            }

            // if($date != "2024-12-25" && $date != "2024-12-26" && $date != "2024-12-31" && $date != "2025-01-01"){
            //     //Sekarang cek untuk harinya
            //     if($condition1){
            //         $hari = Carbon::parse($date)->setTimezone('Asia/Makassar')->format('l');
            //         if($hari == "Tuesday" || $hari == "Thursday"){
            //             for($x = 8; $x <= 13; $x++){
            //                 $cekNama = ($x < 10) ? "0$x" : "$x";
            //                 $nama_1 = explode(":", $nama)[0];
            //                 if($cekNama == $nama_1){
            //                     $condition1 = false;
            //                 }
            //             }
            //         }else if($hari == "Friday" || $hari == "Wednesday"){
            //             for($x = 8; $x <= 11; $x++){
            //                 $cekNama = ($x < 10) ? "0$x" : "$x";
            //                 $nama_1 = explode(":", $nama)[0];
            //                 if($cekNama == $nama_1){
            //                     $condition1 = false;
            //                 }
            //             }
            //         }
            //     }
            //     if($condition3){
            //         $hari = Carbon::parse($date)->setTimezone('Asia/Makassar')->format('l');
            //         if($hari == "Tuesday" || $hari == "Thursday"){
            //             for($x = 8; $x <= 13; $x++){
            //                 $cekNama = ($x < 10) ? "0$x" : "$x";
            //                 $nama_1 = explode(":", $nama)[0];
            //                 if($cekNama == $nama_1){
            //                     $condition3 = false;
            //                 }
            //             }
            //         }else if($hari == "Friday" || $hari == "Wednesday"){
            //             for($x = 8; $x <= 11; $x++){
            //                 $cekNama = ($x < 10) ? "0$x" : "$x";
            //                 $nama_1 = explode(":", $nama)[0];
            //                 if($cekNama == $nama_1){
            //                     $condition3 = false;
            //                 }
            //             }
            //         }
            //     }
            // }

            if (count($data)) {
                foreach ($data as $dataTable) {
                    if ($dataTable->waktu == $nama) {
                        $condition1 = false;
                    }
                    if ($dataTable->waktu == $nama3) {
                        $condition3 = false;
                    }
                }
            }
            if ($condition1) {
                //Abu-abu
                echo "
                <li>
                    <input type='radio' id='$nama' name='waktu' value='$nama' class='hidden peer' />
                    <label for='$nama' class='waktuPunya inline-flex items-center justify-center w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-blue-600 hover:border-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700'>
                        <div class='block'>
                            <div class='w-full text-sm font-semibold'>$nama</div>
                        </div>
                    </label>
                </li>
                ";
            } else {
                //Merah
                echo "
                    <li>
                        <button type='button' id='$nama' name='waktu' value='$nama' class='hidden peer' onclick='openModalSudahPenuh()' ></button>
                        <label for='$nama' class='waktuPunya inline-flex items-center justify-center w-full p-3 text-white bg-red-500 border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-red-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:text-gray-400 dark:bg-red-800 dark:hover:bg-red-700'>
                            <div class='block'>
                                <div class='w-full text-sm font-semibold'>$nama</div>
                            </div>
                        </label>
                    </li>
                ";
            }
            if ($condition3) {
                echo "
                <li>
                    <input type='radio' id='$nama3' name='waktu' value='$nama3' class='hidden peer' />
                    <label for='$nama3' class='waktuPunya inline-flex items-center justify-center w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-blue-600 hover:border-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700'>
                        <div class='block'>
                            <div class='w-full text-sm font-semibold'>$nama3</div>
                        </div>
                    </label>
                </li>
                ";
            } else {
                echo "
                    <li>
                        <button type='button' id='$nama3' name='waktu' value='$nama3' class='hidden peer' onclick='openModalSudahPenuh()' ></button>
                        <label for='$nama3' class='waktuPunya inline-flex items-center justify-center w-full p-3 text-white bg-red-500 border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-red-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:text-gray-400 dark:bg-red-800 dark:hover:bg-red-700'>
                            <div class='block'>
                                <div class='w-full text-sm font-semibold'>$nama3</div>
                            </div>
                        </label>
                    </li>
                ";
            }
        }
    }

    public function strukBookingPhotobox(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required|max:50",
            "jumlah_orang" => "required|integer|between:2,5",
            "tanggal" => "required|date|after_or_equal:today|max:50",
            "waktu" => "required",
            "penambahan_waktu" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->route("booking-photobox")->withErrors($validator)->withInput();
        }

        $nama_gambar = [];
        if (isset($request->tambahan_properti_bando)) {
            $validator2 = Validator::make($request->all(), [
                "jumlah_bando" => "required|integer|between:1,5",
                "gambar_bando" => "required",
                "gambar_bando.*" => "required|file|mimes:jpeg,png,jpg"
            ]);
            if ($validator2->fails()) {
                return redirect()->route("booking-photobox")->withErrors($validator2)->withInput();
            }
            foreach ($request->gambar_bando as $gambar) {
                $name_image = uniqid() . "." . $gambar->extension();
                $gambar->move("temp_photos/", $name_image);
                $nama_gambar[] = $name_image;
            }
        }

        $found = Photobox::where("tanggal", $request->tanggal)->where("waktu", $request->waktu)->first();
        if ($found) {
            return redirect()->route("booking-photobox")->withErrors(["waktu" => "Waktu sudah ada yang memesan."])->withInput();
        }

        $paketPhotobox = HargaPaket::where("nama_paket", "photobox")->first();
        $totalHarga = 0;
        $hargaOrang = $paketPhotobox->harga * $request->jumlah_orang;
        $hargaTambahanWaktu = 0;
        if ($request->penambahan_waktu == "5 menit") {
            $hargaTambahanWaktu = 15000;
        }
        if ($request->penambahan_waktu == "10 menit") {
            $hargaTambahanWaktu = 15000 * 2;
        }

        $hargaBando = 0;
        if (isset($request->tambahan_properti_bando)) {
            $hargaBando = $request->jumlah_bando * 5000;
        }
        $totalHarga += $hargaOrang + $hargaTambahanWaktu + $hargaBando;

        $hargaOrang = number_format($hargaOrang, 0, ',', '.');
        $hargaTambahanWaktu = number_format($hargaTambahanWaktu, 0, ',', '.');
        $totalHarga = number_format($totalHarga, 0, ',', '.');
        $hargaBando = number_format($hargaBando, 0, ',', '.');

        return view("photobox/strukBooking", [
            "data" => $request->all(),
            "hargaOrang" => $hargaOrang,
            "hargaTambahanWaktu" => $hargaTambahanWaktu,
            "totalHarga" => $totalHarga,
            "hargaBando" => $hargaBando,
            "nama_gambar" => $nama_gambar
        ]);
    }
    public function backToBooking()
    {
        return redirect()->route("booking-photobox")->withInput();
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required|max:50",
            "jumlah_orang" => "required|integer|between:2,5",
            "tanggal" => "required|date|after_or_equal:today|max:50",
            "waktu" => "required",
            "penambahan_waktu" => "required",
            "nomor_telp" => "required",
            "kendaraan" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->route("booking-photobox")->withErrors($validator)->withInput();
        }

        //Rapikan Nomor WA
        $nomor = preg_replace('/[^0-9]/', '', $request->nomor_telp); // Hilangkan semua karakter non-angka
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        } else {
            $nomor = '62' . $nomor;
        }
        $nomor = '+' . $nomor;

        $nama_gambar = [];
        if (isset($request->tambahan_properti_bando)) {
            $validator2 = Validator::make($request->all(), [
                "jumlah_bando" => "required|integer|between:1,5",
                "gambar_bando" => "required",
                "gambar_bando.*" => "required|file|mimes:jpeg,png,jpg"
            ]);
            if ($validator2->fails()) {
                return redirect()->route("booking-photobox")->withErrors($validator2)->withInput();
            }
            foreach ($request->gambar_bando as $gambar) {
                $name_image = uniqid() . "." . $gambar->extension();
                $gambar->move("temp_photos/", $name_image);
                $nama_gambar[] = $name_image;
            }
        }

        $found = Photobox::where("tanggal", $request->tanggal)->where("waktu", $request->waktu)->first();
        if ($found) {
            return redirect()->route("booking-photobox")->withErrors(["waktu" => "Waktu sudah ada yang memesan."])->withInput();
        }

        if (isset($request->jumlah_bando)) {
            $photobox_id = Photobox::create([
                "nama" => $request->nama,
                "jumlah_orang" => $request->jumlah_orang,
                "tanggal" => $request->tanggal,
                "waktu" => $request->waktu,
                "penambahan_waktu" => $request->penambahan_waktu,
                "jumlah_bando" => $request->jumlah_bando,
                "nomor_telp" => $nomor,
                "kendaraan" => $request->kendaraan,
            ]);
            foreach ($nama_gambar as $gambar) {
                GambarBando::create([
                    "nama" => $gambar,
                    "photobox_id" => $photobox_id->id
                ]);
                // Move the file from 'temp_photos/' to 'photos/'
                rename('temp_photos/' . $gambar, 'photos/' . $gambar);
            }
        } else {
            Photobox::create([
                "nama" => $request->nama,
                "jumlah_orang" => $request->jumlah_orang,
                "tanggal" => $request->tanggal,
                "waktu" => $request->waktu,
                "penambahan_waktu" => $request->penambahan_waktu,
                "nomor_telp" => $nomor,
                "kendaraan" => $request->kendaraan,
            ]);
        }

        //BOT
        // Hitung waktu salam
        $jam = Carbon::now('Asia/Makassar')->format('H');
        $ucapan = 'Selamat ';
        if ($jam >= 5 && $jam < 11) {
            $ucapan .= 'Pagi';
        } elseif ($jam >= 11 && $jam < 15) {
            $ucapan .= 'Siang';
        } elseif ($jam >= 15 && $jam < 18) {
            $ucapan .= 'Sore';
        } else {
            $ucapan .= 'Malam';
        }

        // Mulai buat pesan WhatsApp
        $messageBot = "Hallo kakak $request->nama, $ucapan ☺️ 🙌\n";
        $messageBot .= "Terimakasih sudah booking di IGNOS STUDIO, untuk sesi yg kakak pilih masih tersedia iya kak🤗\n\n";
        $messageBot .= "*Total harga untuk $request->jumlah_orang orang ";

        if ($request->penambahan_waktu && $request->penambahan_waktu !== '-') {
            $messageBot .= "dengan penambahan waktu $request->penambahan_waktu, ";
        }
        if ($request->jumlah_bando && $request->jumlah_bando !== '-' && $request->jumlah_bando !== '0') {
            $messageBot .= "dan jumlah bando $request->jumlah_bando ";
        }

        // $harga = number_format($request->totalHarga, 0, ',', '.');
        $messageBot .= "harganya Rp $request->totalHarga iya kakak*, bisa melakukan pembayaran full atau DP 50% ya kak agar bookingan bisa di-confirm 🤗\n\n";
        $messageBot .= "Untuk pembayaran bisa scan barcode yang ada di profile WA kita kak atau bisa juga melalui rekening berikut ya kak☺️✨\n";
        $messageBot .= "- Bank Mandiri 1750003024931 An I GUSTI NGURAH OKA S\n\n";
        $messageBot .= "Jika sudah melakukan pembayaran, tolong kirim bukti pembayarannya disini ya kak☺️\n\n";
        $messageBot .= "Terimakasih kakak $request->nama 🥰✨";

        $response = Http::withHeaders([
            'Authorization' => 'uanYgetzgqJ6mCKZUwXt'
        ])->post('https://api.fonnte.com/send', [
            'target' => $nomor,
            'message' => $messageBot,
        ]);

        $message = "FORM BOOKING PHOTOBOX \n\nNama : $request->nama \nJumlah Orang : $request->jumlah_orang \nTanggal Booking : $request->tanggal \nJam Booking : $request->waktu";
        if ($request->penambahan_waktu) {
            $message .= "\nPenambahan Waktu : $request->penambahan_waktu ";
        }
        if ($request->jumlah_bando) {
            $message .= "\nJumlah Bando : $request->jumlah_bando ";
        }
        $message .= "\nKendaraan : $request->kendaraan ";
        $message .= "\nTotal Harga : $request->totalHarga
        \n\nDetail Lokasi : \nJln. Raya Gerih Blumbungan, Sibang Kaja, Abiansemal, Badung(https://maps.app.goo.gl/8teVU4jD3afBMNfX7?g_st=iw)
        \n\nNote : \n- Mohon untuk datang tepat waktu(lebih baik 15 menit sebelum jam booking), apabila terlambat mohon maaf kami tidak ada penambahan waktu. \n- Tidak bisa cancel mendadak iya kak, jika cancel kena denda karena sudah masuk di sistem kita";

        $whatsappLink = 'https://wa.me/6281529751265?text=' . urlencode($message);
        echo "
            <script>
                var whatsappLink = '$whatsappLink';
                window.open(whatsappLink, '_self');
            </script>
        ";
    }
    public function destroy(Request $request)
    {
        $bookings = Photobox::where("tanggal", $request->date)->get();
        foreach ($bookings as $booking) {
            $gambarBando = GambarBando::where("photobox_id", $booking->id)->get();
            foreach ($gambarBando as $gambar) {
                $filePath = public_path("photos/" . $gambar->nama);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $gambar->delete();
            }
            $booking->delete();
        }
        Session::flash("success", "Success delete");
        return redirect(route('indexAdminPhotobox'));
    }
    public function destroyOne(Request $request)
    {
        $booking = Photobox::find($request->id);
        $gambarBando = GambarBando::where("photobox_id", $booking->id)->get();
        foreach ($gambarBando as $gambar) {
            $filePath = public_path("photos/" . $gambar->nama);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $gambar->delete();
        }
        $booking->delete();
        Session::flash("success", "Success delete");
        return redirect(route('indexAdminPhotobox'));
    }
    public function indexAdmin()
    {
        $success = false;
        if (Session::get("success")) {
            $success = Session::get("success");
        }
        $tanggal = [];
        $data = [];
        $bookings = Photobox::orderBy('tanggal')->orderByRaw("SUBSTRING_INDEX(waktu, '-', 1)")->get();

        foreach ($bookings as $booking) {
            if (!in_array($booking->tanggal, $tanggal)) {
                $tanggal[] = $booking->tanggal;
            }
        }

        foreach ($tanggal as $x) {
            $bookings2 = Photobox::where('tanggal', $x)->orderByRaw("SUBSTRING_INDEX(waktu, '-', 1)")->get();
            $data[$x] = $bookings2;
        }


        return view('admin/photobox')->with([
            "data" => $data,
            "gambar" => GambarBando::all(),
            "success" => $success,
        ]);
    }
    public function downloadPhoto($id)
    {
        $gambar = GambarBando::find($id);
        $filePath = public_path('photos/' . $gambar->nama);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    }
    public function checkHarga()
    {
        $hargaPhotobox = HargaPaket::where("nama_paket", "photobox")->first();
        $hargaBando = 5000;
        $hargaTambahanWaktu = 15000;
        return view("photobox/checkHarga", [
            "hargaPhotobox" => $hargaPhotobox->harga,
            "hargaBando" => $hargaBando,
            "hargaTambahanWaktu" => $hargaTambahanWaktu,
        ]);
    }
    public function hapusSampah()
    {
        $folderPath = public_path('temp_photos');
        $files = glob($folderPath . '/*');
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file);
        }
        Session::flash("success", "Success delete cache");
        return redirect(route('indexAdminPhotobox'));
    }
    
    public function addNote(Request $request, $id)
    {
        Photobox::where('id', $id)->update([
            'note' => $request->note,
        ]);

        return back()->with('success', 'Berhasil tambahkan note');
    }
}
