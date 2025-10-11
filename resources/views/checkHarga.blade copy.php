@extends('layouts.main')

@section('content')


<div class="container h-100  py-10">

    <div class="max-w-3xl mx-auto">
        @include('partials.header')
        <div class="bg-polymorphism mt-10">
            <h1 class="text-2xl font-bold text-center text-dark dark:text-white mt-7">Cek Harga</h1>
            <p class="font-normal text-gray-700 dark:text-gray-400 text-center mb-7 w-full md:w-9/12 mx-auto"
                style="padding: 10px;">Anda dapat mengecek harga disini sebelum booking</p>
            <div class="grid md:grid-cols-2 mb-10">
                <div class="px-3 md:px-10">
                    <form action="{{ route('backToBooking') }}" method="POST">
                        @csrf
                        @method("POST")
                        <div class="mb-5">
                            <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Jumlah
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
                                value="{{ old('jumlah_orang', '2') }}" oninput="checkJumlahOrang()" onchange="checkJumlahOrang2()" />
                        </div>
                        {{-- <div class="mb-5">
                            <label for="Package" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                                Paket
                                @error('package')
                                <span class="text-red-600">
                                    ({{ $message }})
                                </span>
                                @enderror
                            </label>
                            <select id="Package"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="package" oninput="checkHarga();">
                                <option value="basic" {{ old('package') == 'basic' ? 'selected' : '' }}>Basic</option>
                                <option value="spotlight" {{ old('package') == 'spotlight' ? 'selected' : '' }}>Spotlight
                                </option>
                                <option value="projector" {{ old('package') == 'projector' ? 'selected' : '' }}>Projector
                                </option>
                            </select>
                        </div> --}}
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
                                name="background" oninput="checkHarga()">
                                <option class="" value="white" {{ old('background') == 'white' ? 'selected' : '' }}>
                                    White</option>
                                <option class="" value="wall" {{ old('background') == 'wall' ? 'selected' : '' }}>Wall
                                </option>
                                <option class="" value="orange" {{ old('background') == 'orange' ? 'selected' : '' }}>
                                    Orange</option>
                                <option class="" value="gray" {{ old('background') == 'gray' ? 'selected' : '' }}>Gray
                                </option>
                                <option class="" value="peach" {{ old('background') == 'peach' ? 'selected' : '' }}>
                                    Peach</option>
                                {{-- <option class="" value="spotlight" {{ old('background') == 'spotlight' ? 'selected' : '' }}>
                                    Spotlight</option> --}}
                                {{-- <option class="" value="-" {{ old('background') == '-' ? 'selected' : '' }}>-</option> --}}
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
                                <input {{ old('membawa_binatang') == 'ya' ? 'checked' : '' }} id="ya" type="checkbox"
                                    value="ya"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    name="membawa_binatang">
                                <label for="ya" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ya</label>
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
                            <select id="penambahan_waktu"
                                class="bg-gray-50 border mt-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="penambahan_waktu" oninput="checkHarga()">
                                <option value="-" {{ old('penambahan_waktu') == '-' ? 'selected' : '' }}>-</option>
                                <option value="10 menit" {{ old('penambahan_waktu') == '10 menit' ? 'selected' : '' }}>
                                    10 Menit</option>
                                <option value="20 menit" {{ old('penambahan_waktu') == '20 menit' ? 'selected' : '' }}>20 Menit
                                </option>
                            </select>
    
                        </div>    
                        <div class="mb-5">
                            <div class="flex items-center">
                                <input id="tambahan_tirai" type="checkbox" oninput="showBackground()"
                                    value="true" name="tambahan_tirai"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="tambahan_tirai" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tambahan Theater Room</label>
                            </div>
                            {{-- <img src="{{ asset('img/tirai.jpg') }}" alt="" style="max-width: 100%;" class="mt-5 rounded-lg img_tirai"> --}}
                        </div>
                        <div class="mb-5">
                            <div class="flex items-center">
                                <input id="tambahan_spotlight" type="checkbox" oninput="showBackground()"
                                    value="benar" name="tambahan_spotlight"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('tambahan_spotlight') ? 'checked' : '' }}>
                                <label for="tambahan_spotlight" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tambahan Spotlight</label>
                            </div>
                            {{-- <img src="{{ asset('img/spotlight.jpg') }}" alt="" style="max-width: 100%;" class="mt-5 rounded-lg img_spotlight"> --}}
                        </div>
                        <div class="mb-5" style="display: none;">
                            <label for=""
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preview Self Photo
                            </label>
                            <div class="bg-white shadow-md rounded-lg py-4 px-3 group mb-5 flex justify-center items-center" style="position: relative;">
                                <img src="{{ asset('img/background-white.jpg') }}" alt="" style="object-fit: cover; width: 93%; height: 94%;" class=" img-background rounded-lg">
                                {{-- <img src="{{ asset('img/preview-gambar.png') }}" alt="" style="max-width: 100%; z-index: 1;" class="w-full rounded-lg"> --}}
                                {{-- <img src="{{ asset('img/tirai2.png') }}" alt="" style="position: absolute; z-index: 1; top: -5px; left: 10px; width: 93%; height: 94%;" class="mt-5 rounded-lg img_tirai"> --}}
                                {{-- <img src="{{ asset('img/spotlight2.png') }}" alt="" style="position: absolute; z-index: 1; top: -5px; left: 10px; width: 93%; height: 94%; opacity: 80%;" class="mt-5 rounded-lg img_spotlight"> --}}
                            </div>
                        </div>
    
                        <div class="flex">
                            <a href="{{ route('index') }}"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Kembali</a>
                            <button type="submit"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Booking sekarang</button>
                        </div>
                    </form>
                </div>
                <div class="px-3 md:pr-10">
                    <div
                        class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700" id="dataBayar">
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // showProperti();
    // function showProperti(){
    //     document.querySelector(".img_tirai").style.display = "none";
    //     document.querySelector(".img_spotlight").style.display = "none";
    //     // if(document.querySelector("#tambahan_tirai").checked){
    //     //     document.querySelector(".img_tirai").style.display = "inline-block";
    //     // }
    //     // if(document.querySelector("#tambahan_spotlight").checked){
    //     //     document.querySelector(".img_spotlight").style.display = "inline-block";
    //     // }
    //     checkHarga()
    // }

    let imgBg;
    //Background
    showBackground();
        // function showBackground() {
        //     let imgBg = "{{ asset('img') }}";
        //     imgBg += "/background-" + document.querySelector("#background").value + ".jpg";
        //     document.querySelector(".img-background").src = imgBg;
        // }
        
        function showBackground() {
            imgBg = "{{ asset('img') }}" + "/background-" + document.querySelector("#background").value;
            showProperti();
        }
        // function showProperti(){
        //     document.querySelector(".img_tirai").style.display = "none";
        //     document.querySelector(".img_spotlight").style.display = "none";
        //     if(document.querySelector("#tambahan_tirai").checked){
        //         document.querySelector(".img_tirai").style.display = "inline-block";
        //     }
        //     if(document.querySelector("#tambahan_spotlight").checked){
        //         document.querySelector(".img_spotlight").style.display = "inline-block";
        //     }
        // }
        
        function showProperti(){
            if(document.querySelector("#tambahan_tirai").checked){
                imgBg += "-tirai";
            }
            if(document.querySelector("#tambahan_spotlight").checked){
                imgBg += "-spotlight";
            }
            
            checkHarga()
            imgBg += ".jpg";
            document.querySelector(".img-background").src = imgBg;
        }

    checkHarga();
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
    function checkHarga() {
        const background = document.querySelector("#background");
        let tambahan_tirai = "tidak";
        if(document.querySelector("#tambahan_tirai").checked){
            tambahan_tirai = "benar";
        }
        let tambahan_spotlight = "tidak";
        if(document.querySelector("#tambahan_spotlight").checked){
            tambahan_spotlight = "benar";
        }
        
        var package = "basic";
        if(background.value=="spotlight"){
            package = "spotlight";
        }

        const tambahWaktu = document.querySelector("#penambahan_waktu").value;
        const jumlah = document.querySelector("#jumlah").value;
        // const package = document.querySelector("#Package").value;
        const url = "{{ route('prosesCheckHarga', ['tambahWaktu' => ':tambahWaktu', 'package' => ':package', 'jumlah' => ':jumlah', 'tambahan_tirai' => ':tambahan_tirai', 'tambahan_spotlight' => ':tambahan_spotlight']) }}"
                        .replace(':tambahWaktu', tambahWaktu)
                        .replace(':package', package)
                        .replace(':jumlah', jumlah)
                        .replace(':tambahan_tirai', tambahan_tirai)
                        .replace(':tambahan_spotlight', tambahan_spotlight);
        $.ajax({
            url: url,
            success: function (result) {
                $("#dataBayar").html(result);
            }
        });
    }


</script>

@endsection
