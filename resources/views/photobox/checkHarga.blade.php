@extends('layouts.main')

@section('content')


<div class="container h-100  py-10">

    <div class="max-w-3xl mx-auto">
        @include('partials.header')
        <div class="bg-polymorphism mt-10">
            <h1 class="text-2xl font-bold text-center text-dark dark:text-white mt-7">Cek Harga Photobox</h1>
            <div class="grid md:grid-cols-2 mb-10">
                <div class="px-3 md:px-10">
                    <form action="{{ route('backToBookingPhotobox') }}" method="POST">
                        @method("POST")
                        @csrf
                        <div class="mb-5">
                            <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Jumlah
                                Orang
                                @error('jumlah_orang')
                                <span class="text-red-600">
                                    ({{ $message }})
                                </span>
                                @enderror
                            </label>
                            <input type="number" min="2" max="5" id="jumlah_orang"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required placeholder="Masukkan jumlah orang" name="jumlah_orang"
                                value="{{ old('jumlah_orang', '2') }}" oninput="checkJumlahOrang(); cekSemuaHarga();" />
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
                            <select id="penambahan_waktu" oninput="cekSemuaHarga()"
                                class="bg-gray-50 border mt-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="penambahan_waktu">
                                <option value="-" {{ old('penambahan_waktu') == '-' ? 'selected' : '' }}>-</option>
                                <option value="5 menit" {{ old('penambahan_waktu') == '5 menit' ? 'selected' : '' }}>
                                    5 Menit</option>
                                <option value="10 menit" {{ old('penambahan_waktu') == '10 menit' ? 'selected' : '' }}>10
                                    Menit
                                </option>
                            </select>
    
                        </div>
    <div class="mb-5">
                                <label for=""
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preview Photobox
                                </label>
                                <div
                                    class="bg-white shadow-md rounded-lg py-4 px-3 group mb-5 flex justify-center items-center">
                                    <img src="{{ asset('img/img-photobox.JPG') }}" alt=""
                                        style="max-width: 100%;" class="w-full rounded-lg">
                                </div>
                            </div>
                        <div class="mb-5">
                            <div class="flex items-center">
                                <input id="tambahan_properti_bando" type="checkbox"
                                    value="benar" name="tambahan_properti_bando"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    oninput="checkBando(); cekSemuaHarga()" {{ old('tambahan_properti_bando') ? 'checked' : '' }}>
                                <label for="tambahan_properti_bando" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tambahan properti bando</label>
                            </div>
                        </div>
    
                        <div id="propertiBando" class="hidden">
                            <div class="mb-5">
                                <label
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Wajah Untuk di Bando
                                </label>
                                <img src="{{ asset('img/bando.jpg') }}" alt="" style="max-width: 100%;">
                            </div>
                            <div class="mb-5">
                                <label for="jumlah_bando" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                    Bando
                                    @error('jumlah_bando')
                                    <span class="text-red-600">
                                        ({{ $message }})
                                    </span>
                                    @enderror
                                </label>
                                <input type="number" min="1" max="5" id="jumlah_bando"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Masukkan jumlah orang" name="jumlah_bando"
                                    value="{{ old('jumlah_bando', '1') }}" oninput="addForBando(); cekSemuaHarga()" />
                            </div>
                        </div>
                        
                        <div class="flex">
                            <a href="{{ route('index') }}"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Kembali</a>
                            <button type="submit"
                            class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Booking Sekarang</button>
                        </div>
                    </form>
            </div>
            <div class="px-3 md:pr-10 mt-5 order-1 md:order-2">
                <div
                    class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400 uppercase ">Total
                        Pembayaran
                    </h5>
                    <div class="flex items-baseline text-gray-900 dark:text-white">
                        <span class="text-3xl font-semibold">Rp.</span>
                        <span class="text-5xl font-extrabold tracking-tight uang_totalPembayaran">60.000</span>
                        <span class="ms-1 text-xl font-normal text-gray-500 dark:text-gray-400">/sesi</span>
                    </div>
                    <ul role="list" class="space-y-5 my-7">
                        {{-- <li class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span
                                class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Paket
                                Photobox
                            </span>
                        </li> --}}
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3"><span id="durasiFoto">15</span>
                                Menit Durasi Foto</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">15
                                Menit Seleksi Foto</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span
                                class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3"><span id="orang4r">0</span>
                                Print Ukuran 4r</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">All
                                Softcopy File <br><b>* Free(follow + mention @ignos.studio)/ +10k</b></span>
                        </li>

                        <li class="flex hidden" id="grupTambahanWaktu">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                                    ms-3">Tambahan Waktu <span id="tambahanWaktu">0</span> :
                                Rp. <span class="uang_tambahanWaktu">0</span></span>
                        </li>
                        
                        
                            <li class="flex" id="grupBando">
                                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                                        ms-3"><span id="bando">2</span> Bando :
                                    Rp. <span class="uang_bando">0</span></span>
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
                        <li class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3"><span id="orang">2</span>
                                orang : Rp. <span class="uang_orang">60.000</span></span>
                            </li>
                        



                    </ul>
                    {{-- <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                            focus:ring-blue-200 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900
                             rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full
                            text-center font-bold ">Total Pembayaran : Rp.90.000</button> --}}
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
<script>
    checkBando();
    let hargaPhotobox = {{ $hargaPhotobox }};
    let hargaBando = {{ $hargaBando }};
    let hargaTambahanWaktu = {{ $hargaTambahanWaktu }};

    const jumlah_bando = document.querySelector("#jumlah_bando");
    const jumlah_orang = document.querySelector("#jumlah_orang");
    const penambahan_waktu = document.querySelector("#penambahan_waktu");

    const orang4r = document.querySelector("#orang4r");
    const tambahanWaktu = document.querySelector("#tambahanWaktu");
    const bando = document.querySelector("#bando");
    const orang = document.querySelector("#orang");

    function durasiFotoCheck(){
        let durasi = 15;
        if(penambahan_waktu.value == "5 menit"){
            document.querySelector("#durasiFoto").textContent = durasi+5;
        }else if(penambahan_waktu.value == "10 menit"){
            document.querySelector("#durasiFoto").textContent = durasi+10;
        }else{
            document.querySelector("#durasiFoto").textContent = durasi;
        }
    }

    let tambahanWaktuValue;
    let jumlahBandoValue;
    function cekSemuaHarga(){
        durasiFotoCheck();
        orang4r.textContent = jumlah_orang.value;
        tambahanWaktu.textContent = penambahan_waktu.value;
        bando.textContent = jumlah_bando.value;
        orang.textContent = jumlah_orang.value;

        if(penambahan_waktu.value == "-"){
            document.querySelector("#grupTambahanWaktu").classList.add("hidden");
        }else{
            document.querySelector("#grupTambahanWaktu").classList.remove("hidden")
        }
        
        if(penambahan_waktu.value == "5 menit"){
            tambahanWaktuValue = 1;
        }else if(penambahan_waktu.value == "10 menit"){
            tambahanWaktuValue = 2;
        }else{
            tambahanWaktuValue = 0
        }

        const inputBando = document.querySelector("#tambahan_properti_bando");
        if(inputBando.checked){
            jumlahBandoValue = jumlah_bando.value
        }else{
            jumlahBandoValue = 0;
        }

        let temp_bando = hargaBando * jumlahBandoValue;
        let temp_orang = hargaPhotobox * jumlah_orang.value;
        let temp_totalPembayaran = hargaTambahanWaktu * tambahanWaktuValue + hargaBando * jumlahBandoValue + hargaPhotobox * jumlah_orang.value;
        document.querySelector(".uang_tambahanWaktu").textContent = (hargaTambahanWaktu * tambahanWaktuValue).toLocaleString('id-ID');
        document.querySelector(".uang_bando").textContent = (temp_bando).toLocaleString('id-ID');
        document.querySelector(".uang_orang").textContent = (temp_orang).toLocaleString('id-ID');
        document.querySelector(".uang_totalPembayaran").textContent = (temp_totalPembayaran).toLocaleString('id-ID');
    }
    
    function checkBando(){
        const inputBando = document.querySelector("#tambahan_properti_bando");
        const bodyBando = document.querySelector("#propertiBando");
        if(inputBando.checked){
            bodyBando.classList.remove("hidden");
            document.querySelector("#grupBando").classList.remove("hidden")
        }else{
            bodyBando.classList.add("hidden");
            document.querySelector("#grupBando").classList.add("hidden")
        }
    }
    
    function addForBando(){
        if(jumlah_bando.value > 5){
            jumlah_bando.value = 5;
        }
    }
    function checkJumlahOrang() {
        let input = document.querySelector("#jumlah_orang");
        if (input.value > 5) {
            input.value = 5;
        }
    }
    cekSemuaHarga();
</script>

@endsection
