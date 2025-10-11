@extends('layouts.main')

@section('content')
    <div class="container h-100  py-10">

        <div class="max-w-3xl mx-auto">
            @include('partials.header')
            <div class="bg-polymorphism mt-10">
                <h1 class="text-2xl font-bold text-center text-dark dark:text-white mt-7">PHOTO STUDIO</h1>
                <p class="font-normal text-gray-700 dark:text-gray-400 text-center mb-7 w-full md:w-9/12 mx-auto"
                    style="padding: 10px; margin-top: 0px; margin-bottom: 0px;">Silahkan lengkapi form
                    berikut</p>
                <div class="grid md:grid-cols-2 mb-10">
                    <div class="px-3 md:px-10">
                        <form class="w-full mt-5" action="{{ route('storeBooking') }}" method="POST" id="formBooking">
                            @csrf
                            @method('POST')
                            @if ($errors->any())
                                <div id="alert-border-2"
                                    class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800"
                                    role="alert">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <div class="ms-3 text-sm font-medium">
                                        Gagal memesan !
                                    </div>
                                    <button type="button"
                                        class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                                        data-dismiss-target="#alert-border-2" aria-label="Close">
                                        <span class="sr-only">Dismiss</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                            <div class="mb-5">
                                <label for="nama"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                    @error('nama')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                    @enderror
                                </label>
                                <input type="text" id="nama"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
                                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                                dark:focus:border-blue-500"
                                    placeholder="Masukkan nama anda" name="nama" autofocus required
                                    value="{{ old('nama') }}" />
                            </div>
                            <div class="mb-5">
                                <label for="jumlah"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Jumlah
                                    Orang
                                    @error('jumlah_orang')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                    @enderror
                                </label>
                                <input type="number" min="2" max="15" id="jumlah"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required placeholder="Masukkan jumlah orang" name="jumlah_orang"
                                    value="{{ old('jumlah_orang', '2') }}" oninput="checkJumlahOrang()" />
                            </div>
                            <div class="mb-5">
                                <label for="tanggal"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                    Booking
                                    @error('tanggal')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                    @enderror
                                </label>
                                <div class="relative max-w-sm">
                                    <input type="date"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="tanggal" name="tanggal" value="{{ old('tanggal') }}" oninput="dateAction()"
                                        required>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="waktu" class="block text-sm font-medium text-gray-900 dark:text-white">Waktu
                                    Booking
                                    @error('waktu')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                    @enderror
                                </label>
                                <small class="text-gray-700 dark:text-gray-400">
                                    Jam yang dipilih/booking adalah jam mulai fotonya
                                </small>
                                <ul class="mt-5 grid w-full gap-2 grid-cols-2 md:grid-cols-4 justify-center md:justify-between"
                                    id="waktu">
                                    @for ($i = 8; $i <= 22; $i++)
                                        <?php $nama = $i; ?> @if ($i < 10)
                                            <?php $nama = '0' . $i; ?>
                                            @endif <?php $nama = $nama . ':00'; ?> <?php $i2 = $i + 1; ?> <?php $nama2 = $i2; ?> @if ($i2 < 10)
                                                <?php $nama2 = '0' . $i2; ?>
                                            @endif <?php $nama2 = $nama2 . ':00'; ?>
                                            <?php $nama_range = $nama . '-' . $nama2; ?> <li>
                                                <input type="radio" id="{{ $nama_range }}" oninput="checkHarga()"
                                                    name="waktu[]" value="{{ $nama_range }}" class="hidden peer" />
                                                <label for="{{ $nama_range }}"
                                                    class="waktuPunya inline-flex items-center justify-center w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-blue-600 hover:border-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                    <div class="block">
                                                        <div class="w-full text-sm font-semibold">{{ $nama }}</div>
                                                    </div>
                                                </label>
                                            </li>
                                        @endfor
                                </ul>
                            </div>

                            <div class="hidden mb-5">
                                <label for="Package"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                                    Paket
                                    @error('package')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                    @enderror
                                </label>
                                <select id="Package"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="package" oninput="packageAction()">
                                    <option value="basic" {{ old('package') == 'basic' ? 'selected' : '' }}>Basic</option>
                                    <option value="spotlight" {{ old('package') == 'spotlight' ? 'selected' : '' }}>
                                        Spotlight
                                    </option>
                                    <option value="projector" {{ old('package') == 'projector' ? 'selected' : '' }}>
                                        Projector
                                    </option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="nomor_telp"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Nomor Whatsapp
                                    @error('nomor_telp')
                                        <span class="text-red-600">({{ $message }})</span>
                                    @enderror
                                </label>
                                <div class="flex">
                                    <span
                                        class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-white dark:border-gray-600">
                                        +62
                                    </span>
                                    <input type="text" id="nomor_telp"
                                        class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="8123456789" name="nomor_telp" />
                                </div>
                            </div>

                            <div class="mb-5">
                                <label for="background"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                                    Background
                                    @error('background')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                    @enderror
                                </label>
                                <select id="background" oninput="showBackground()"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="background">
                                    <option class="" value="white"
                                        {{ old('background') == 'white' ? 'selected' : '' }}>
                                        White</option>
                                    <option class="" value="wall"
                                        {{ old('background') == 'wall' ? 'selected' : '' }}>Wall
                                    </option>
                                    <option class="" value="orange"
                                        {{ old('background') == 'orange' ? 'selected' : '' }}>
                                        Orange</option>
                                    <option class="" value="gray"
                                        {{ old('background') == 'gray' ? 'selected' : '' }}>Gray
                                    </option>
                                    <option class="" value="peach"
                                        {{ old('background') == 'peach' ? 'selected' : '' }}>
                                        Peach</option>
                                    <option class="" value="american yearbook"
                                        {{ old('background') == 'american yearbook' ? 'selected' : '' }}>
                                        American Yearbook</option>
                                </select>
                            </div>

                            <div class="mb-5 hidden">
                                <label for="membawa_binatang"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Membawa Binatang
                                    @error('membawa_binatang')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                    @enderror
                                </label>
                                <div class="flex items-center">
                                    <input {{ old('membawa_binatang') == 'ya' ? 'checked' : '' }} id="ya"
                                        type="checkbox" value="ya"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        name="membawa_binatang">
                                    <label for="ya"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ya</label>
                                </div>
                            </div>

                            <div class="mb-5">

                                <label for="penambahan_waktu"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Penambahan Waktu
                                    @error('penambahan_waktu')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                    @enderror
                                </label>
                                <small class="text-gray-700 dark:text-gray-400">
                                    Jika merasa waktunya kurang, Anda dapat menambah waktunya
                                </small>

                                <select id="penambahan_waktu" oninput="checkHarga()"
                                    class="bg-gray-50 border mt-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="penambahan_waktu">
                                    <option value="-" {{ old('penambahan_waktu') == '-' ? 'selected' : '' }}>-
                                    </option>
                                    <option value="10 menit"
                                        {{ old('penambahan_waktu') == '10 menit' ? 'selected' : '' }}>
                                        10 Menit</option>
                                    <option value="20 menit"
                                        {{ old('penambahan_waktu') == '20 menit' ? 'selected' : '' }}>20 Menit
                                    </option>
                                </select>


                            </div>
                            <div class="mb-5">
                                <div class="flex items-center">
                                    <input id="tambahan_tirai" type="checkbox" oninput="showBackground()" value="pakai"
                                        name="tambahan_tirai"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        {{ old('tambahan_tirai') ? 'checked' : '' }}>
                                    <label for="tambahan_tirai"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tambahan Theater
                                        Room</label>
                                </div>
                            </div>
                            <div class="mb-5">
                                <div class="flex items-center">
                                    <input id="tambahan_spotlight" type="checkbox" oninput="showBackground()"
                                        value="pakai" name="tambahan_spotlight"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        {{ old('tambahan_spotlight') ? 'checked' : '' }}>
                                    <label for="tambahan_spotlight"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tambahan
                                        Spotlight</label>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for=""
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preview Photo
                                    Studio
                                </label>
                                <div class="bg-white shadow-md rounded-lg py-4 px-3 group mb-5 flex justify-center items-center"
                                    style="position: relative;">
                                    <img src="{{ asset('img/background-white.jpg') }}" alt=""
                                        style="object-fit: cover; width: 93%; height: 94%;"
                                        class=" img-background rounded-lg">
                                </div>
                            </div>
                            <div class="mb-5">

                                <label for="kendaraan"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Kendaraan
                                    @error('kendaraan')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                    @enderror
                                </label>
                                <small class="text-gray-700 dark:text-gray-400">
                                    Pilih jenis kendaraan agar kami bisa mengatur tempat parkir
                                </small>
                                <select id="kendaraan"
                                    class="bg-gray-50 border mt-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="kendaraan" required>
                                    <option value="" disabled selected>Pilih Kendaraan</option>
                                    <option value="Motor" {{ old('kendaraan') == 'Motor' ? 'selected' : '' }}>Motor</option>
                                    <option value="Gocar" {{ old('kendaraan') == 'Gocar' ? 'selected' : '' }}>Gocar</option>
                                    <option value="" disabled>
                                        TIDAK TERSEDIA PARKIR MOBIL – Mohon maaf sementara akses parkir mobil tidak tersedia
                                    </option>
                                </select>
                            </div>
                            <input type="text" name="totalHarga" class="hidden total-harga">

                            <div class="flex">
                                <a href="{{ route('index') }}"
                                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Kembali</a>
                                <button type="button" data-modal-target="modal-konfirmasi-1"
                                    data-modal-toggle="modal-konfirmasi-1"
                                    class="text-white flex justify-center items-center bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-gray-700 dark:border-gray-700"
                                    style="gap: 5px;">
                                    <img src="{{ asset('img/whatsapp-brands-solid.svg') }}" alt=""
                                        style="height: 20px">
                                    Booking Sekarang
                                </button>
                            </div>

                            <hr style="margin: 20px 0px 30px 0px;">
                        </form>
                    </div>
                    <div class="px-3 md:pr-10">
                        <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700"
                            id="dataBayar">

                        </div>
                        <h1 class="font-semibold text-dark dark:text-white mt-5 mb-2">Lokasi Studio :</h1>
                        <iframe class="w-full aspect-video rounded-lg"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.3005833517764!2d115.20913097373982!3d-8.567068786902686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23d004fd4fdf3%3A0xb4cbcfe9a27c17d5!2sIGNOS%20STUDIO%20SELF%20PHOTO%20STUDIO!5e0!3m2!1sid!2sid!4v1712905316828!5m2!1sid!2sid"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            let imgBg;
            showBackground();

            function showBackground() {
                imgBg = "{{ asset('img') }}" + "/background-" + document.querySelector("#background").value;
                if (document.querySelector("#background").value == "american yearbook") {
                    // Nonaktifkan checkbox
                    document.querySelector("#tambahan_tirai").disabled = true;
                    document.querySelector("#tambahan_spotlight").disabled = true;

                    // Hapus centang (uncheck)
                    document.querySelector("#tambahan_tirai").checked = false;
                    document.querySelector("#tambahan_spotlight").checked = false;
                } else {
                    document.querySelector("#tambahan_tirai").disabled = false;
                    document.querySelector("#tambahan_spotlight").disabled = false;
                }
                showProperti();
            }


            function showProperti() {
                if (document.querySelector("#tambahan_tirai").checked) {
                    imgBg += "-tirai";
                }
                if (document.querySelector("#tambahan_spotlight").checked) {
                    imgBg += "-spotlight";
                }

                checkHarga()
                imgBg += ".jpg";
                document.querySelector(".img-background").src = imgBg;
            }

            // waktuAction();
            dateAction();

            function dateAction() {
                //console.log("test");
                const dateElement = document.querySelector("#tanggal");
                const tanggal = dateElement.value;
                if (tanggal) {
                    const url = "{{ route('timeBookings', ['date' => ':date']) }}".replace(':date', tanggal);
                    $.ajax({
                        url: url,
                        success: function(result) {
                            $("#waktu").html(result);
                            // waktuAction();
                            packageAction();
                        }
                    });
                }
            }

            // function checkJumlahOrang() {
            //     let input = document.querySelector("#jumlah");
            //     if (input.value > 15) {
            //         input.value = 15;
            //     }
            // }

            // checkHarga();

            function checkJumlahOrang() {
                let input = document.querySelector("#jumlah");
                if (input.value > 15) {
                    input.value = 15;
                }
                checkHarga();
            }

            function checkJumlahOrang2() {
                let input = document.querySelector("#jumlah");
                if (input.value < 2) {
                    input.value = 2;
                }
                checkHarga();
            }
            checkHarga();

            function checkHarga() {

                const background = document.querySelector("#background");
                let tambahan_tirai = "tidak";
                if (document.querySelector("#tambahan_tirai").checked) {
                    tambahan_tirai = "benar";
                }
                let tambahan_spotlight = "tidak";
                if (document.querySelector("#tambahan_spotlight").checked) {
                    tambahan_spotlight = "benar";
                }

                var package = "basic";
                if (background.value == "spotlight") {
                    package = "spotlight";
                }

                const tambahWaktu = document.querySelector("#penambahan_waktu").value;
                const jumlah = document.querySelector("#jumlah").value;
                const url =
                    "{{ route('prosesCheckHarga', ['tambahWaktu' => ':tambahWaktu', 'package' => ':package', 'jumlah' => ':jumlah', 'tambahan_tirai' => ':tambahan_tirai', 'tambahan_spotlight' => ':tambahan_spotlight']) }}"
                    .replace(':tambahWaktu', tambahWaktu)
                    .replace(':package', package)
                    .replace(':jumlah', jumlah)
                    .replace(':tambahan_tirai', tambahan_tirai)
                    .replace(':tambahan_spotlight', tambahan_spotlight);
                $.ajax({
                    url: url,
                    success: function(result) {
                        $("#dataBayar").html(result);
                        runTotal();
                    }
                });

            }

            function runTotal() {
                document.querySelector(".total-harga").value = document.querySelector("#txt-totalHarga").value;
            }

            function openModalSudahPenuh(){
                document.querySelector("#modal-sudah-penuh").classList.remove("hidden");
                document.querySelector("#modal-sudah-penuh").classList.add("flex");
            }
            function closeModalSudahPenuh(){
                document.querySelector("#modal-sudah-penuh").classList.remove("flex");
                document.querySelector("#modal-sudah-penuh").classList.add("hidden");
            }
        </script>

        <!-- Modal Konfirmasi -->
        <div id="modal-konfirmasi-1" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 justify-center items-center w-full inset-0 h-full z-50">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Konfirmasi Booking
                        </h3>
                    </div>
                    <div class="p-4 space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <ul>
                            <li>Booking kamu akan langsung tercatat di sistem setelah klik tombol <b>"Ya, Booking
                                    Sekarang"</b>.
                            </li>
                            <li>❗Harap tidak mengubah jam booking saat mengirim pesan WhatsApp.</li>
                            <li>✅ Pastikan kamu kirim pesan bookingan-nya di WhatsApp agar booking kamu diproses.</li>
                        </ul>
                        <p>
                            Terima kasih! 😊
                        </p>
                    </div>
                    <div class="flex justify-end p-4 border-t border-gray-200 rounded-b dark:border-gray-600 gap-2">
                        <button data-modal-hide="modal-konfirmasi-1" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:ring-2 focus:ring-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white">
                            Batal
                        </button>
                        <button type="button" onclick="document.getElementById('formBooking').submit()"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Ya, Booking Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Sudah Penuh -->
        <div id="modal-sudah-penuh" style="background: rgba(0,0,0,0.5);"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 justify-center items-center w-full inset-0 h-full z-50">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Jam Sudah Terisi
                        </h3>
                    </div>
                    <div class="p-4 space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <p>Maaf, Jam yang kamu pilih sudah dibooking orang lain. Coba pilih jam lain ya 😊</p>
                    </div>
                    <div class="flex justify-end p-4 border-t border-gray-200 rounded-b dark:border-gray-600 gap-2">
                        <button type="button" onclick="closeModalSudahPenuh()"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:ring-2 focus:ring-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white">
                            Oke, Pilih jam lainnya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
