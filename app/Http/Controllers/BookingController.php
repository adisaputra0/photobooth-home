<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Waktu;
use App\Models\Booking;
use App\Models\Photobox;
use App\Models\HargaPaket;
use Illuminate\Http\Request;
use App\Models\HargaPerOrang;
use App\Models\WaktuOperasional;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        return view("home");
    }

    public function adminCashier()
    {
        $hargaPaket = HargaPaket::where("nama_paket", "basic")->first()->harga;
        $hargaSpotlight = HargaPaket::where("nama_paket", "spotlight")->first()->harga;
        $hargaTirai = HargaPaket::where("nama_paket", "tirai")->first()->harga;
        $hargaPerOrang = HargaPerOrang::find(1)->harga;
        return view('cashierAdmin')->with([
            "hargaPaket" => $hargaPaket,
            "hargaSpotlight" => $hargaSpotlight,
            "hargaTirai" => $hargaTirai,
            "hargaPerOrang" => $hargaPerOrang
        ]);
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
            "nomor_telp" => "required",
            "kendaraan" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->route("booking")->withErrors($validator)->withInput();
        }
        if ($request->background == "spotlight") {
            $request["package"] = "spotlight";
        } else {
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

        $request["waktu"] = $semuaWaktu;

        // Periksa jam yang dipilih sudah lewat
        $waktu_sekarang = now()->setTimezone('Asia/Makassar')->format('H:i');

        // Membandingkan waktu awal dengan waktu sekarang
        if ($request->tanggal == now()->format('Y-m-d') && $request->waktu < $waktu_sekarang) {
            return redirect()->route("booking")->withErrors(["waktu" => "Waktunya sudah lewat"])->withInput();
        }
        if (!isset($request->penambahan_waktu)) {
            $request["penambahan_waktu"] = "-";
        }
        if (!isset($request->tambahan_tirai)) {
            $request["tambahan_tirai"] = "-";
        }
        if (!isset($request->tambahan_spotlight)) {
            $request["tambahan_spotlight"] = "-";
        }

        //Rapikan Nomor WA
        $nomor = preg_replace('/[^0-9]/', '', $request->nomor_telp); // Hilangkan semua karakter non-angka
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        } else {
            $nomor = '62' . $nomor;
        }
        $nomor = '+' . $nomor;

        $booking = Booking::create([
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
            "nomor_telp" => $nomor,
            "kendaraan" => $request->kendaraan,
        ]);

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
        $messageBot = "Hallo kakak $booking->nama, $ucapan ☺️ 🙌\n";
        $messageBot .= "Terimakasih sudah booking di IGNOS STUDIO, untuk sesi yg kakak pilih masih tersedia iya kak🤗\n\n";
        $messageBot .= "*Total harga untuk $booking->jumlah_orang orang ";

        if ($request->penambahan_waktu && $request->penambahan_waktu !== '-') {
            $messageBot .= "dengan penambahan waktu $request->penambahan_waktu, ";
        }
        if ($request->tambahan_tirai && $request->tambahan_tirai !== '-') {
            $messageBot .= "tambahan tirai, ";
        }
        if ($request->tambahan_spotlight && $request->tambahan_spotlight !== '-') {
            $messageBot .= "dan tambahan spotlight ";
        }

        // $harga = number_format($request->totalHarga, 0, ',', '.');
        $messageBot .= "harganya Rp $request->totalHarga iya kakak*, bisa melakukan pembayaran full atau DP 50% ya kak agar bookingan bisa di-confirm 🤗\n\n";
        $messageBot .= "Untuk pembayaran bisa scan barcode yang ada di profile WA kita kak atau bisa juga melalui rekening berikut ya kak☺️✨\n";
        $messageBot .= "- Bank Mandiri 1750003024931 An I GUSTI NGURAH OKA S\n\n";
        $messageBot .= "Jika sudah melakukan pembayaran, tolong kirim bukti pembayarannya disini ya kak☺️\n\n";
        $messageBot .= "Terimakasih kakak $booking->nama 🥰✨";

        $response = Http::withHeaders([
            'Authorization' => 'uanYgetzgqJ6mCKZUwXt'
        ])->post('https://api.fonnte.com/send', [
            'target' => $booking->nomor_telp,
            'message' => $messageBot,
        ]);

        $jam = explode('-', $request->waktu)[0];
        $message = "FORM BOOKING PHOTO STUDIO \n\nNama : $request->nama \nJumlah Orang : $request->jumlah_orang \nTanggal Booking : $request->tanggal \nJam Booking : $jam \nBackground : $request->background";
        if ($request->penambahan_waktu) {
            $message .= "\nPenambahan Waktu : $request->penambahan_waktu ";
        }
        if ($request->tambahan_tirai != "-") {
            $message .= "\nTambahan Tirai : $request->tambahan_tirai ";
        }
        if ($request->tambahan_spotlight != "-") {
            $message .= "\nTambahan Spotlight : $request->tambahan_spotlight ";
        }
        $message .= "\nKendaraan : $request->kendaraan ";
        $message .= "\nTotal Harga : $request->totalHarga \n\nDetail Lokasi : \nJln. Raya Gerih Blumbungan, Sibang Kaja, Abiansemal, Badung(https://maps.app.goo.gl/8teVU4jD3afBMNfX7?g_st=iw) \n\nNote : \n- Mohon untuk datang tepat waktu(lebih baik 15 menit sebelum jam booking), apabila terlambat mohon maaf kami tidak ada penambahan waktu. \n- Tidak bisa cancel mendadak iya kak, jika cancel kena denda karena sudah masuk di sistem kita";

        $whatsappLink = 'https://wa.me/6281529751265?text=' . urlencode($message);
        echo "
            <script>
                var whatsappLink = '$whatsappLink';
                window.open(whatsappLink, '_self');
            </script>
        ";
    }

    // public function sendReminder()
    // {
    //     $bookings = Booking::all();
    //     $now = Carbon::now(); // waktu saat ini

    //     foreach ($bookings as $booking) {
    //         $bookingDate = Carbon::parse($booking->tanggal);

    //         // H-2 dan H-1
    //         if ($bookingDate->isSameDay($now->copy()->addDays(1)) || $bookingDate->isSameDay($now->copy()->addDays(2))) {

    //             // Format waktu sapaan berdasarkan waktu saat ini
    //             $hour = $now->format('H');
    //             if ($hour < 11) {
    //                 $greeting = 'Pagi';
    //             } elseif ($hour < 15) {
    //                 $greeting = 'Siang';
    //             } elseif ($hour < 18) {
    //                 $greeting = 'Sore';
    //             } else {
    //                 $greeting = 'Malam';
    //             }

    //             // Format nama hari
    //             $hari = $bookingDate->locale('id')->isoFormat('dddd');
    //             $jam = $booking->waktu;

    //             // Buat isi pesan
    //             $message = "Hi kakak {$booking->nama}, Selamat {$greeting}, Mohon maaf menganggu waktunya kakak, *mengingatkan bookingan Photo Studio/Photobox kakak di hari {$hari} jam {$jam}* dengan jumlah {$booking->jumlah_orang} orang atas nama {$booking->nama}, Mohon datang sebelum jam booking iya kakak, jam {$jam} kita sudah mulai foto iya kakak.\n\n" .
    //                 "*Note:*\n" .
    //                 "* Mohon untuk datang lebih awal untuk menghindari macet (lebih baik 20 menit sebelum jam booking sudah distudio), apabila terlambat mohon maaf kami tidak ada penambahan waktu iya kak.\n" .
    //                 "* ⁠Parkir Mobil sebelah timur studio, parkir motor masuk/ disamping studio, maaf studio masih masuk kedalam gang, mobil bisa masuk iya kak.\n" .
    //                 "* ⁠Tidak bisa cancel mendadak iya kak, jika cancel kena denda karena sudah masuk di sistem kita\n" .
    //                 "* ⁠Bisa bayar cash/qr distudio iya kakak\n\n" .
    //                 "Detail Lokasi:\n" .
    //                 "Jln. Raya Gerih Blumbungan, Sibang Kaja, Abiansemal, Badung\n(https://maps.app.goo.gl/8teVU4jD3afBMNfX7?g_st=iw)\n\n" .
    //                 "Terimakasih kakak, See You🥰✨";

    //             // Kirim pesan via Fonnte
    //             Http::withHeaders([
    //                 'Authorization' => 'uanYgetzgqJ6mCKZUwXt',
    //             ])->post('https://api.fonnte.com/send', [
    //                 'target' => $booking->nomor_telp,
    //                 'message' => $message,
    //             ]);
    //         }
    //     }

    //     return response()->json(['status' => 'Reminder sent (H-2 / H-1) if any.']);
    // }

    // REMINDER USERS
    public function sendReminder()
    {
        $now = Carbon::now('Asia/Makassar'); // WITA
        $bookings = Booking::all();
        $photoboxes = Photobox::all();

        foreach ($bookings as $booking) {
            $this->checkAndSendReminder($booking, $now, 'PHOTO STUDIO');
        }

        foreach ($photoboxes as $photobox) {
            $this->checkAndSendReminder($photobox, $now, 'PHOTOBOX');
        }

        return response()->json(['status' => 'Reminder sent (Booking & Photobox) if any.']);
    }

    private function checkAndSendReminder($item, $now, $type)
    {
        $bookingDate = Carbon::parse($item->tanggal);

        if (
            $bookingDate->isSameDay($now) ||
            $bookingDate->isSameDay($now->copy()->addDays(1)) ||
            $bookingDate->isSameDay($now->copy()->addDays(2))
        ) {
            $hour = $now->format('H');
            if ($hour < 11) {
                $greeting = 'Pagi';
            } elseif ($hour < 15) {
                $greeting = 'Siang';
            } elseif ($hour < 18) {
                $greeting = 'Sore';
            } else {
                $greeting = 'Malam';
            }

            $hari = $bookingDate->locale('id')->isoFormat('dddd');

            // Ambil jam awal saja (untuk PhotoStudio yang formatnya 22:00-23:00)
            $jam = $item->waktu;
            if (strpos($jam, '-') !== false) {
                $jam = explode('-', $jam)[0];
            }

            $message = "Hi kakak {$item->nama}, Selamat {$greeting}, Mohon maaf menganggu waktunya iya kakak☺️🙏🏻,\n\n" .
                "*Izin mau mengingatkan bookingan {$type} kakak di hari {$hari}, {$item->tanggal} jam {$jam}* dengan jumlah {$item->jumlah_orang} orang atas nama {$item->nama}, Mohon datang 15 Menit sebelum jam booking iya kakak, jam {$jam} kita sudah mulai foto iya kakak.\n\n" .
                "*Note:*\n" .
                "* Mohon untuk datang lebih awal untuk menghindari macet (lebih baik 15 menit sebelum jam booking sudah distudio), apabila terlambat mohon maaf kami tidak ada penambahan waktu iya kakak\n\n" .
                "* ⁠Tidak bisa cancel mendadak iya kak, jika cancel kena denda karena sudah masuk di sistem kita iya kak\n\n" .
                "Detail Lokasi:\n" .
                "Jln. Raya Gerih Blumbungan, Sibang Kaja, Abiansemal, Badung\n" .
                "(https://maps.app.goo.gl/8teVU4jD3afBMNfX7?g_st=iw)\n\n" .
                "Terimakasih kakak, See You🥰✨";

            Http::withHeaders([
                'Authorization' => 'uanYgetzgqJ6mCKZUwXt',
            ])->post('https://api.fonnte.com/send', [
                'target' => $item->nomor_telp,
                'message' => $message,
            ]);
        }
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

            // Cek apakah tanggal yang dipilih lebih lama atau lebih baru dari hari ini (kemarin atau di masa depan)
            $tanggalTerpilih = Carbon::parse($date);
            $sekarang = Carbon::now();
            $selisihHari = $tanggalTerpilih->diffInDays($sekarang);
            $selisihHariNegatif = $tanggalTerpilih->diffInDays($sekarang, false); // Menghitung dengan selisih negatif jika di masa depan
            if ($selisihHari > 0) {
                // Jika lebih dari 0 hari, berarti tanggal yang dipilih adalah di masa lalu (kemarin, minggu lalu, tahun lalu)
                $found = false;
            }
            // Cek jika tanggal yang dipilih lebih depan
            if ($selisihHariNegatif > 0) {
                // Jika tanggal lebih besar dari hari ini, berarti di masa depan
                $found = true;  // Biarkan waktu tersedia
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



            //Sekarang cek tanggal libur
            $hari = Carbon::parse($date)->setTimezone('Asia/Makassar')->format('l');

            $waktu_tutup_operasional = WaktuOperasional::where("hari", $hari)->get();
            if ($waktu_tutup_operasional) {
                foreach ($waktu_tutup_operasional as $data_operasional) {
                    for ($x = $data_operasional->waktu_awal; $x <= $data_operasional->waktu_akhir; $x++) {
                        $cekNama = ($x < 10) ? "0$x:00" : "$x:00";

                        if ($cekNama == $namaTampil) {
                            $found = true;
                        }
                    }
                }
            }


            $waktu_model = Waktu::where("tanggal", $date)->where("status", "buka")->get();
            if ($waktu_model) {
                foreach ($waktu_model as $data) {
                    for ($j = $data->waktu_awal; $j <= $data->waktu_akhir; $j++) {
                        if ($j == $i) {
                            $found = false;
                        }
                    }
                }
            }
            $waktu_model = Waktu::where("tanggal", $date)->where("status", "tutup")->get();
            if ($waktu_model) {
                foreach ($waktu_model as $data) {
                    for ($j = $data->waktu_awal; $j <= $data->waktu_akhir; $j++) {
                        if ($j == $i) {
                            $found = true;
                        }
                    }
                }
            }

            foreach ($semuaWaktu as $waktu) {
                if ($nama == $waktu) {
                    $found = true;
                    break;
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
                        <button type='button' id='$nama' value='$nama' class='hidden peer' onclick='openModalSudahPenuh()'></button>
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

        if ($request->background == "spotlight") {
            $request["package"] = "spotlight";
        } else {
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
        if ($request->tambahan_tirai) {
            $totalHarga += $paketTirai->harga;
            $biayaTirai = number_format($paketTirai->harga, 0, ',', '.');
        }

        //Paket Spotlight
        $paketSpotlight = HargaPaket::where("nama_paket", "spotlight")->first();
        $biayaSpotlight = 0;
        if ($request->tambahan_spotlight) {
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
    public function checkHarga()
    {
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
    public function prosesCheckHarga($tambahWaktu, $package, $jumlah, $tambahan_tirai, $tambahan_spotlight)
    {
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
        if ($tambahan_tirai == "benar") {
            $totalHarga += $paketTirai->harga;
            $biayaTirai = number_format($paketTirai->harga, 0, ',', '.');
        }

        $paketSpotlight = HargaPaket::where("nama_paket", "spotlight")->first();
        $biayaSpotlight = 0;
        if ($tambahan_spotlight == "benar") {
            $totalHarga += $paketSpotlight->harga;
            $biayaSpotlight = number_format($paketSpotlight->harga, 0, ',', '.');
        }

        $hargaPackage = number_format($hargaPackage, 0, ',', '.');
        $totalHarga = number_format($totalHarga, 0, ',', '.');
        $biayaPerOrang = number_format($hargaPerOrang->harga, 0, ',', '.');

        echo '
        <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400 uppercase">Total Pembayaran
        </h5>
        <input type="text" id="txt-totalHarga" class="hidden" value="' . $totalHarga . '">
        <div class="flex items-baseline text-gray-900 dark:text-white">
            <span class="text-3xl font-semibold">Rp.</span>
            <span class="text-5xl font-extrabold tracking-tight">' . $totalHarga . '</span>
            <span class="ms-1 text-xl font-normal text-gray-500 dark:text-gray-400">/sesi</span>
        </div>
        <ul role="list" class="space-y-5 my-7">
        ';
        if ($tambahWaktu == "10 menit") {
            echo '
                <li class="flex">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span
                        class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">40
                        Menit Durasi Foto</span>
                </li>
            ';
        } else if ($tambahWaktu == "20 menit") {
            echo '
                <li class="flex">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span
                        class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">50
                        Menit Durasi Foto</span>
                </li>
            ';
        } else {
            echo '
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
            ';
        }
        echo
        '
            <li class="flex">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span
                    class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">' . $jumlah . '
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
                    All Softcopy File  <br><b>* Free(follow + mention @ignos.studio)/ +10k</b></span>
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
        if ($hargaTambahanWaktu > 0) {
            echo '
                <li class="flex">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Tambahan Waktu ' . $tambahWaktu . ' :
                        Rp.' . $hargaTambahanWaktu . '</span>
                </li>
            ';
        }
        if ($biayaTirai) {
            echo '
                <li class="flex">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Tambahan Tirai :
                        Rp.' . $biayaTirai . '</span>
                </li>
            ';
        }
        if ($biayaSpotlight) {
            echo '
                <li class="flex">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Tambahan Spotlight :
                        Rp.' . $biayaSpotlight . '</span>
                </li>
            ';
        }
        if ($jumlah <= 7) {
            echo '
                <li class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span
                        class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">2
                        orang : Rp. ' . $hargaPackage . '</span>
                </li>
            ';
        }

        if ($hargaOrang > 0) {
            echo '
            <li class="flex">
                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
            ';
            if ($jumlah > 7) {
                echo '
                        <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Karena lebih dari 7 orang, setiap orang dikenakan biaya Rp.
                        ' . $biayaPerOrang . '</span>
                    ';
            } else {
                echo '
                        <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                        ms-3">Tambahan untuk ' . $jumlah - 2 . ' Orang :
                        ' . $hargaOrang . '</span>
                    ';
            }

            echo '</li>';
        }
        echo '</ul>';
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
    public function addNote(Request $request, $id)
    {
        Booking::where('id', $id)->update([
            'note' => $request->note,
        ]);

        return back()->with('success', 'Berhasil tambahkan note');
    }
}
