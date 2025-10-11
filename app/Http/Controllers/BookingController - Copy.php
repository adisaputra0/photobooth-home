<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\HargaPaket;
use Illuminate\Http\Request;
use App\Models\HargaPerOrang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        return view("home");
    }

    public function booking()
    {
        return view("booking");
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required|max:50",
            "jumlah_orang" => "required|integer|between:2,15",
            "tanggal" => "required|date|after_or_equal:today|max:50",
            "waktu" => "required",
            "package" => "required|max:50",
            "background" => "required|max:50",
        ]);

        if ($validator->fails()) {
            return redirect()->route("booking")->withErrors($validator)->withInput();
        }

        $existingBooking = Booking::where('tanggal', $request->tanggal)->where('waktu', $request->waktu)->exists();

        if ($existingBooking) {
            return redirect()->route("booking")->withErrors(["waktu" => "Waktu sudah ada yang memesan."])->withInput();
        }

        // Periksa jam yang dipilih sudah lewat
        $waktu_sekarang = now()->setTimezone('Asia/Makassar')->format('H:i');

        // Membandingkan waktu awal dengan waktu sekarang
        if ($request->tanggal == now()->format('Y-m-d') && $request->waktu < $waktu_sekarang) {
            return redirect()->route("booking")->withErrors(["waktu" => "Waktunya sudah lewat"])->withInput();
        }
        if(!isset($request->penambahan_waktu)){
            $request["penambahan_waktu"] = "-";
        }
        if(!isset($request->tambahan_tirai)){
            $request["tambahan_tirai"] = "-";
        }
        if(!isset($request->tambahan_spotlight)){
            $request["tambahan_spotlight"] = "-";
        }
        Booking::create([
            "nama" => $request->nama,
            "jumlah_orang" => $request->jumlah_orang,
            "tanggal" => $request->tanggal,
            "waktu" => $request->waktu,
            "package" => $request->package,
            "background" => $request->background,
            "membawa_binatang" => $request->membawa_binatang,
            "penambahan_waktu" => $request->penambahan_waktu,
            "tirai" => $request->tambahan_tirai,
            "spotlight" => $request->tambahan_spotlight,
        ]);

        $jam = explode('-', $request->waktu)[0];
        $message = "FORM BOKING SELF PHOTO \n\nNama : $request->nama \nJumlah Orang : $request->jumlah_orang \nTanggal Booking : $request->tanggal \nJam Booking : $jam \nBackground : $request->background";
        if ($request->membawa_binatang) {
            $message .= "\nMembawa Binatang";
        }
        if ($request->penambahan_waktu) {
            $message .= "\nPenambahan Waktu : $request->penambahan_waktu ";
        }
        if ($request->tambahan_tirai != "-") {
            $message .= "\nTambahan Tirai : $request->tambahan_tirai ";
        }
        if ($request->tambahan_spotlight != "-") {
            $message .= "\nTambahan Spotlight : $request->tambahan_spotlight ";
        }
        $message .= "\nTotal Harga : $request->totalHarga \n\nDetail Lokasi : \nJln. Raya Gerih Blumbungan, Sibang Kaja, Abiansemal, Badung(https://maps.app.goo.gl/8teVU4jD3afBMNfX7?g_st=iw) \n\nNote : \n- Mohon untuk datang tepat waktu(lebih baik 15 menit sebelum jam booking), apabila terlambat mohon maaf kami tidak ada penambahan waktu.";

        $whatsappLink = 'https://wa.me/6281529751265?text=' . urlencode($message);
        echo "
            <script>
                var whatsappLink = '$whatsappLink';
                window.open(whatsappLink, '_self');
            </script>
        ";
    }
    public function time($date)
    {
        $data = Booking::where("tanggal", $date)->get();

        $semuaWaktu = [];
        foreach ($data as $booking) {
            $times = explode(" & ", $booking->waktu);
            foreach ($times as $time) {
                $semuaWaktu[] = $time;
            }
        }

        for ($i = 8; $i <= 22; $i++) {
            $nama = ($i < 10) ? "0$i:00" : "$i:00";
            $i2 = $i + 1;
            $nama2 = ($i2 < 10) ? "0$i2:00" : "$i2:00";

            $nama = $nama . "-" . $nama2;
            $found = false;

            foreach ($semuaWaktu as $waktu) {
                if ($nama == $waktu) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                // Periksa jam yang dipilih sudah lewat
                $waktu_sekarang = now()->setTimezone('Asia/Makassar')->format('H:i');

                // Memecah waktu terpilih menjadi waktu awal dan akhir
                $jam_terpisah = explode("-", $nama);
                $waktu_awal = trim($jam_terpisah[0]);
                $waktu_akhir = trim($jam_terpisah[1]);

                // Membandingkan tanggal dan waktu
                if ($date == now()->format('Y-m-d') && $waktu_awal < $waktu_sekarang) {
                    $found = true;
                }
            }

            $namaTampil = ($i < 10) ? "0$i:00" : "$i:00";

            //Sekarang cek untuk harinya
            // if(!$found){
            //     $hari = Carbon::parse($date)->setTimezone('Asia/Makassar')->format('l');
            //     if($hari != "Saturday" && $hari != "Sunday"){
            //         for($x = 8; $x <= 13; $x++){
            //             $cekNama = ($x < 10) ? "0$x:00" : "$x:00";

            //             if($cekNama == $namaTampil){
            //                 $found = true;
            //             }
            //         }
            //     }
            // }

            //Sekarang cek untuk harinya
            if(!$found){
                $hari = Carbon::parse($date)->setTimezone('Asia/Makassar')->format('l');
                if($hari == "Tuesday" || $hari == "Thursday"){
                    for($x = 8; $x <= 13; $x++){
                        $cekNama = ($x < 10) ? "0$x:00" : "$x:00";

                        if($cekNama == $namaTampil){
                            $found = true;
                        }
                    }
                }else if($hari == "Friday" || $hari == "Wednesday"){
                    for($x = 8; $x <= 11; $x++){
                        $cekNama = ($x < 10) ? "0$x:00" : "$x:00";

                        if($cekNama == $namaTampil){
                            $found = true;
                        }
                    }
                }
            }

            if (!$found) {
                echo "
                <li>
                    <input type='radio' id='$nama' name='waktu[]' value='$nama' class='hidden peer' />
                    <label for='$nama' class='waktuPunya inline-flex items-center justify-center w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-blue-600 hover:border-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700'>                           
                        <div class='block'>
                            <div class='w-full text-sm font-semibold'>$namaTampil</div>
                        </div>
                    </label>
                </li>
                ";
            } else {
                echo "
                    <li>
                        <input type='radio' id='$nama' name='waktu[]' value='$nama' class='hidden peer' disabled />
                        <label for='$nama' class='waktuPunya inline-flex items-center justify-center w-full p-3 text-white bg-red-500 border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-red-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 dark:text-gray-400 dark:bg-red-800 dark:hover:bg-red-700'>                           
                            <div class='block'>
                                <div class='w-full text-sm font-semibold'>$namaTampil</div>
                            </div>
                        </label>
                    </li>
                ";
            }
        }
    }
    public function strukBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required|max:50",
            "jumlah_orang" => "required|integer|between:2,15",
            "tanggal" => "required|date|after_or_equal:today|max:50",
            "waktu" => "required",
            "package" => "required|max:50",
            "background" => "required|max:50",
        ]);

        if ($validator->fails()) {
            return redirect()->route("booking")->withErrors($validator)->withInput();
        }

        if($request->background=="spotlight"){
            $request["package"] = "spotlight";
        }else{
            $request["package"] = "basic";
        }
        $semuaWaktu = "";
        if (is_array($request->waktu) && !empty($request->waktu)) {
            $batas = count($request->waktu);
            foreach ($request->waktu as $time) {
                $semuaWaktu .= $time;
                if ($batas > 1) {
                    $semuaWaktu .= " & ";
                }
                $batas -= 1;
            }
        } else {
            return redirect()->route("booking")->withErrors(["waktu" => "Tolong pilih waktunya terlebih dahulu"])->withInput();
        }

        $existingBooking = Booking::where('tanggal', $request->tanggal)->get();

        if ($existingBooking) {
            foreach ($existingBooking as $booking) {
                $times = explode(" & ", $booking->waktu);
                foreach ($times as $time) {
                    foreach ($request->waktu as $w) {
                        if ($time == $w) {
                            return redirect()->route("booking")->withErrors(["waktu" => "Waktu sudah ada yang memesan."])->withInput();
                        }
                    }
                }
            }
        }

        // Periksa jam yang dipilih sudah lewat
        $waktu_sekarang = now()->setTimezone('Asia/Makassar')->format('H:i');
        $selectedTimes = explode(" & ", $semuaWaktu);

        foreach ($selectedTimes as $selectedTime) {
            // Memecah waktu awal dan waktu akhir
            $jam_terpisah = explode("-", $selectedTime);
            $waktu_awal = trim($jam_terpisah[0]);
            $waktu_akhir = trim($jam_terpisah[1]);

            // Membandingkan waktu awal dengan waktu sekarang
            if ($request->tanggal == now()->format('Y-m-d') && $waktu_awal < $waktu_sekarang) {
                return redirect()->route("booking")->withErrors(["waktu" => "Waktunya sudah lewat"])->withInput();
            }
        }

        $totalHarga = 0;
        $hargaPackage = 0;
        $hargaOrang = 0;
        $hargaTambahanWaktu = 0;

        $hargaPaketTabel = HargaPaket::all();
        $hargaPerOrang = HargaPerOrang::find(1);

        foreach ($hargaPaketTabel as $harga) {
            //Benefit yang pasti didapat
            if ($request->jumlah_orang <= 7) {
                if ($request->package == $harga->nama_paket) {
                    $hargaPackage = $harga->harga * count($request->waktu);
                    $totalHarga += $hargaPackage;
                }
            }
        }
        
        //Benefit tambahan
        if ($request->jumlah_orang > 2 && $request->jumlah_orang <= 7) {
            $hargaOrang = $hargaPerOrang->harga * ($request->jumlah_orang - 2);
            $totalHarga += $hargaOrang;
            $hargaOrang = number_format($hargaOrang, 0, ',', '.');
        } else if ($request->jumlah_orang > 7) {
            $hargaOrang = $hargaPerOrang->harga * $request->jumlah_orang;
            $totalHarga += $hargaOrang;
            $hargaOrang = number_format($hargaOrang, 0, ',', '.');
        }
        if ($request->penambahan_waktu) {
            if ($request->penambahan_waktu == "10 menit") {
                $hargaTambahanWaktu = 35000;
            } else if ($request->penambahan_waktu == "20 menit") {
                $hargaTambahanWaktu = 70000;
            }
            $totalHarga += $hargaTambahanWaktu;
            $hargaTambahanWaktu = number_format($hargaTambahanWaktu, 0, ',', '.');
        }

        //Paket Tirai
        $paketTirai = HargaPaket::where("nama_paket", "tirai")->first();
        $biayaTirai = 0;
        if($request->tambahan_tirai){
            $totalHarga += $paketTirai->harga;
            $biayaTirai = number_format($paketTirai->harga, 0, ',', '.');
        }

        //Paket Spotlight
        $paketSpotlight = HargaPaket::where("nama_paket", "spotlight")->first();
        $biayaSpotlight = 0;
        if($request->tambahan_spotlight){
            $totalHarga += $paketSpotlight->harga;
            $biayaSpotlight = number_format($paketSpotlight->harga, 0, ',', '.');
        }

        $hargaPackage = number_format($hargaPackage, 0, ',', '.');
        $totalHarga = number_format($totalHarga, 0, ',', '.');
        $biayaPerOrang = number_format($hargaPerOrang->harga, 0, ',', '.');

        return view("strukBooking")->with([
            "data" => $request->all(),
            "waktu" => $semuaWaktu,
            "hargaPackage" => $hargaPackage,
            "hargaOrang" => $hargaOrang,
            "hargaTambahanWaktu" => $hargaTambahanWaktu,
            "totalHarga" => $totalHarga,
            "biayaPerOrang" => $biayaPerOrang,
            "biayaTirai" => $biayaTirai,
            "biayaSpotlight" => $biayaSpotlight,
        ]);
    }
    public function backToBooking(Request $request)
    {
        return redirect()->route("booking")->withInput();
    }
    public function checkHarga(){
        $hargaPackage = HargaPaket::find(1);
        $hargaPackage2 = HargaPaket::find(2);
        $hargaPackage3 = HargaPaket::find(3);
        $biayaPerOrang = HargaPerOrang::find(1);
        $hargaTambahanWaktu = 35000;
        return view("checkHarga", [
            "hargaPackage" => $hargaPackage->harga,
            "hargaPackage2" => $hargaPackage2->harga,
            "hargaPackage3" => $hargaPackage3->harga,
            "hargaTambahanWaktu" => $hargaTambahanWaktu,
            "biayaPerOrang" => $biayaPerOrang->harga,
        ]);
        
    }
    public function prosesCheckHarga($tambahWaktu ,$package, $jumlah, $tambahan_tirai, $tambahan_spotlight){
        $totalHarga = 0;
        $hargaPackage = 0;
        $hargaOrang = 0;
        $hargaTambahanWaktu = 0;

        $hargaPaketTabel = HargaPaket::all();
        $hargaPerOrang = HargaPerOrang::find(1);
        foreach ($hargaPaketTabel as $harga) {
            if ($jumlah <= 7) {
                //Benefit yang pasti didapat
                if ($package == $harga->nama_paket) {
                    $hargaPackage = $harga->harga;
                    $totalHarga += $hargaPackage;
                }
            }
        }
        //Benefit tambahan
        if ($jumlah > 2 && $jumlah <= 7) {
            $hargaOrang = $hargaPerOrang->harga * ($jumlah - 2);
            $totalHarga += $hargaOrang;
            $hargaOrang = number_format($hargaOrang, 0, ',', '.');
        } else if ($jumlah > 7) {
            $hargaOrang = $hargaPerOrang->harga * $jumlah;
            $totalHarga += $hargaOrang;
            $hargaOrang = number_format($hargaOrang, 0, ',', '.');
        }
        if ($tambahWaktu) {
            if ($tambahWaktu == "10 menit") {
                $hargaTambahanWaktu = 35000;
            } else if ($tambahWaktu == "20 menit") {
                $hargaTambahanWaktu = 70000;
            }
            $totalHarga += $hargaTambahanWaktu;
            $hargaTambahanWaktu = number_format($hargaTambahanWaktu, 0, ',', '.');
        }
        $paketTirai = HargaPaket::where("nama_paket", "tirai")->first();
        $biayaTirai = 0;
        if($tambahan_tirai == "benar"){
            $totalHarga += $paketTirai->harga;
            $biayaTirai = number_format($paketTirai->harga, 0, ',', '.');
        }

        $paketSpotlight = HargaPaket::where("nama_paket", "spotlight")->first();
        $biayaSpotlight = 0;
        if($tambahan_spotlight == "benar"){
            $totalHarga += $paketSpotlight->harga;
            $biayaSpotlight = number_format($paketSpotlight->harga, 0, ',', '.');
        }

        $hargaPackage = number_format($hargaPackage, 0, ',', '.');
        $totalHarga = number_format($totalHarga, 0, ',', '.');
        $biayaPerOrang = number_format($hargaPerOrang->harga, 0, ',', '.');

        echo '
        <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400 uppercase">Total Pembayaran
        </h5>
        <div class="flex items-baseline text-gray-900 dark:text-white">
            <span class="text-3xl font-semibold">Rp.</span>
            <span class="text-5xl font-extrabold tracking-tight">'. $totalHarga .'</span>
            <span class="ms-1 text-xl font-normal text-gray-500 dark:text-gray-400">/sesi</span>
        </div>
        <ul role="list" class="space-y-5 my-7">
            <li class="flex">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span
                    class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">30
                    Menit Durasi Foto</span>
            </li>
            <li class="flex">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span
                    class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">20
                    Menit Seleksi Foto</span>
            </li>
            <li class="flex">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span
                    class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">'.$jumlah.'
                    Print Ukuran 4r</span>
            </li>
            <li class="flex">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span
                    class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Free
                    All Softcopy File</span>
            </li>
            <li class="flex">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span
                    class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Free
                    Costume & Accessories</span>
            </li>
        ';
        if ($hargaTambahanWaktu > 0){
            echo '
                <li class="flex">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Tambahan Waktu '. $tambahWaktu .' :
                        Rp.'.$hargaTambahanWaktu.'</span>
                </li>
            ';
        }
        if($biayaTirai){
            echo '
                <li class="flex">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Tambahan Tirai :
                        Rp.'.$biayaTirai.'</span>
                </li>
            ';
        }
        if($biayaSpotlight){
            echo '
                <li class="flex">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Tambahan Spotlight :
                        Rp.'.$biayaSpotlight.'</span>
                </li>
            ';
        }
        if($jumlah <= 7){
            echo '
                <li class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span
                        class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">2
                        orang : Rp. '. $hargaPackage .'</span>
                </li>
            ';
        }
        
        if ($hargaOrang > 0){
            echo '
            <li class="flex">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
            ';
                if($jumlah > 7){
                    echo '
                        <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Karena lebih dari 7 orang, setiap orang dikenakan biaya Rp.
                        '. $biayaPerOrang .'</span>
                    ';
                }
                else{
                    echo '
                        <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Tambahan untuk '. $jumlah-2 .' Orang :
                        '. $hargaOrang .'</span>
                    ';
                }
                
            echo '</li>';
        }
        echo '</ul>';
            

        echo '
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
            focus:ring-blue-200 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900
            rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full
            text-center font-bold">Total Pembayaran : '. $totalHarga .'</button>
        ';
    }
    
    public function indexAdmin()
    {
        $success = false;
        if (Session::get("success")) {
            $success = Session::get("success");
        }

        $tanggal = [];
        $data = [];
        $bookings = Booking::orderBy('tanggal')->orderByRaw("SUBSTRING_INDEX(waktu, '-', 1)")->get();

        foreach ($bookings as $booking) {
            if (!in_array($booking->tanggal, $tanggal)) {
                $tanggal[] = $booking->tanggal;
            }
        }

        foreach ($tanggal as $x) {
            $bookings2 = Booking::where('tanggal', $x)->orderByRaw("SUBSTRING_INDEX(waktu, '-', 1)")->get();
            $data[$x] = $bookings2;
        }

        return view('admin/index')->with([
            "data" => $data,
            "success" => $success,
        ]);
    }
    public function destroy(Request $request)
    {
        $booking = Booking::where("tanggal", $request->date);
        $booking->delete();
        Session::flash("success", "Success delete booking");
        return redirect(route('indexAdmin'));
    }
    public function destroyOne(Request $request)
    {
        $booking = Booking::find($request->id);
        $booking->delete();
        Session::flash("success", "Success delete booking");
        return redirect(route('indexAdmin'));
    }
}
