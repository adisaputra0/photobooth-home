@extends('layouts.main')

@section('content')
<div class="container h-100 py-10">
    <div class="max-w-3xl mx-auto">
        @include('partials.header')

        <div class="grid md:grid-cols-2 mt-10" style="border-top-right-radius: 0.5rem !important; 
border-bottom-right-radius: 0.5rem !important;">
            <div class=" bg-cover rounded-l-md bg-center"
                style="background-image: url({{ asset('img/img-photobox.jpg') }})">
                {{-- <img src="{{ asset('img/favicon.png') }}" alt=""> --}}
            </div>
            <div class="bg-polymorphism px-10 py-10"
                style="border-top-right-radius: 0.5rem !important; 
border-bottom-right-radius: 0.5rem !important; border-top-left-radius: 0px !important; border-bottom-left-radius: 0px !important">
                <h1 class="font-bold text-3xl text-primary dark:text-white">IGNOS STUDIO</h1>
                <small class="font-normal text-gray-700 dark:text-gray-400">Silahkan lengkapi form
                    berikut</small>
                <form class="w-full mt-5" action="{{ route('strukBookingPhotobox') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("POST")
                    @if($errors->any())
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
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    @endif
                    <div class="mb-5">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                            @error('nama')
                            <span class="text-red-600">
                                ({{ $message }})
                            </span>
                            @enderror
                        </label>
                        <input type="text" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                            dark:focus:border-blue-500" placeholder="Masukkan nama anda" name="nama" autofocus required
                            value="{{ old('nama') }}" />
                    </div>
                    <div class="mb-5">
                        <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Jumlah
                            Orang
                            @error('jumlah_orang')
                            <span class="text-red-600">
                                ({{ $message }})
                            </span>
                            @enderror
                        </label>
                        <input type="number" min="2" max="5" id="jumlah"
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
                        <label for="waktu" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu
                            Booking
                            @error('waktu')
                            <span class="text-red-600">
                                ({{ $message }})
                            </span>
                            @enderror
                        </label>
                        <ul class="grid w-full gap-2 grid-cols-2 md:grid-cols-4 justify-center md:justify-between"
                            id="waktu">
                            @for($i = 8; $i <= 22; $i++)
                                <?php $nama = ($i < 10) ? "0$i:00" : "$i:00"; $nama3 = ($i < 10) ? "0$i:30" : "$i:30";?>
                                <li>
                                <input type='radio' id='{{ $nama }}' name='waktu' value='{{ $nama }}'
                                    class='hidden peer' />
                                <label for='{{ $nama }}'
                                    class='waktuPunya inline-flex items-center justify-center w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-blue-600 hover:border-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700'>
                                    <div class='block'>
                                        <div class='w-full text-sm font-semibold'>{{ $nama }}</div>
                                    </div>
                                </label>
                                </li>
                                <li>
                                    <input type='radio' id='{{ $nama3 }}' name='waktu' value='{{ $nama3 }}'
                                        class='hidden peer' />
                                    <label for='{{ $nama3 }}'
                                        class='waktuPunya inline-flex items-center justify-center w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-blue-600 hover:border-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700'>
                                        <div class='block'>
                                            <div class='w-full text-sm font-semibold'>{{ $nama3 }}</div>
                                        </div>
                                    </label>
                                </li>
                                @endfor

                        </ul>


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
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penambahan Waktu
                            @error('penambahan_waktu')
                            <span class="text-red-600">
                                ({{ $message }})
                            </span>
                            @enderror
                        </label>

                        <select id="penambahan_waktu"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            name="penambahan_waktu">
                            <option value="-" {{ old('penambahan_waktu') == '-' ? 'selected' : '' }}>-</option>
                            <option value="5 menit" {{ old('penambahan_waktu') == '5 menit' ? 'selected' : '' }}>
                                5 Menit</option>
                            <option value="10 menit" {{ old('penambahan_waktu') == '10 menit' ? 'selected' : '' }}>10
                                Menit
                            </option>
                        </select>
                        <small class="text-gray-700 dark:text-gray-400">
                            *Jika merasa waktunya kurang, Anda dapat menambah waktunya
                        </small>

                    </div>
                    <div class="mb-5">
                        <label for=""
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preview Photobox
                        </label>
                        <div class="bg-white shadow-md rounded-lg py-4 px-3 group mb-5 flex justify-center items-center">
                            <img src="{{ asset('img/img-photobox.jpg') }}" alt="" style="max-width: 100%;" class="w-full rounded-lg">
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="flex items-center">
                            <input id="tambahan_properti_bando" type="checkbox"
                                value="benar" name="tambahan_properti_bando"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                oninput="checkBando()" {{ old('tambahan_properti_bando') ? 'checked' : '' }}>
                            <label for="tambahan_properti_bando" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tambahan properti bando</label>
                        </div>
                    </div>

                    <div id="propertiBando" class="hidden">
                        <div class="mb-5">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar
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
                                value="{{ old('jumlah_bando', '1') }}" oninput="addForBando()" />
                        </div>
                        <div class="mb-5">
                            <label for="gambar_bando" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Wajah Untuk di
                                Bando
                                @error('gambar_bando')
                                <span class="text-red-600">
                                    ({{ $message }})
                                </span>
                                @enderror
                            </label>
                            <div id="inputContainer">
                                {{-- <div class="input-container">
                                    <input type="file" id="gambar_bando" class="border rounded" required name="gambar_bando"/>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="flex"><a href="{{ route('index') }}"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Kembali</a>
                        <button type="submit"
                            class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // waktuAction();
    dateAction();

    function dateAction() {
        //console.log("test");
        const dateElement = document.querySelector("#tanggal");
        const tanggal = dateElement.value;
        if (tanggal) {
            const url = "{{ route('timeBookingsPhotobox', ['date' => ':date']) }}".replace(':date', tanggal);
            $.ajax({
                url: url,
                success: function (result) {
                    $("#waktu").html(result);
                    // waktuAction();
                    packageAction();
                }
            });
        }
    }

    checkBando();
    const jumlah_bando = document.querySelector("#jumlah_bando");
    function addForBando(){
        removeAllBando();
        if(jumlah_bando.value > 5){
            jumlah_bando.value = 5;
        }
        for(let i = 1; i <= jumlah_bando.value; i++){
            addBando();
        }
    }
    addForBando();
    function addBando() {
        const container = document.getElementById('inputContainer');
        const newInputContainer = document.createElement('div');
        newInputContainer.className = 'input-container';

        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.className = 'border rounded';
        newInput.name = 'gambar_bando[]';

        newInputContainer.appendChild(newInput);
        container.appendChild(newInputContainer);
    }
    function removeAllBando() {
        const container = document.getElementById('inputContainer');
        container.innerHTML = '';
    }
    function checkBando(){
        const inputBando = document.querySelector("#tambahan_properti_bando");
        const bodyBando = document.querySelector("#propertiBando");
        if(inputBando.checked){
            bodyBando.classList.remove("hidden");
        }else{
            bodyBando.classList.add("hidden");
        }
    }

    // packageAction();
    // function packageAction() {
    //     const package = document.querySelector("#Package").value;
    //     const backgroundOptions = document.querySelectorAll("#background option");

    //     backgroundOptions.forEach(option => {
    //         option.classList.remove("hidden");
    //         option.disabled = false;
    //         document.querySelector("#background option[value='-']").disabled = true;
    //         document.querySelector("#background option[value='-']").classList.add("hidden");
    //     });

    //     if (package === "spotlight") {
    //         document.querySelector("#background option[value='wall']").classList.add("hidden");
    //         document.querySelector("#background option[value='orange']").classList.add("hidden");
    //         document.querySelector("#background option[value='gray']").classList.add("hidden");
    //         document.querySelector("#background option[value='peach']").classList.add("hidden");

    //         document.querySelector("#background option[value='wall']").disabled = true;
    //         document.querySelector("#background option[value='orange']").disabled = true;
    //         document.querySelector("#background option[value='gray']").disabled = true;
    //         document.querySelector("#background option[value='peach']").disabled = true;
    //         document.querySelector("#background option[value='-']").disabled = true;

    //         document.querySelector("#background option[value='white']").selected = true;
    //     } else if (package === "projector") {
    //         document.querySelector("#background option[value='wall']").classList.add("hidden");
    //         document.querySelector("#background option[value='white']").classList.add("hidden");
    //         document.querySelector("#background option[value='orange']").classList.add("hidden");
    //         document.querySelector("#background option[value='gray']").classList.add("hidden");
    //         document.querySelector("#background option[value='peach']").classList.add("hidden");

    //         document.querySelector("#background option[value='wall']").disabled = true;
    //         document.querySelector("#background option[value='white']").disabled = true;
    //         document.querySelector("#background option[value='orange']").disabled = true;
    //         document.querySelector("#background option[value='gray']").disabled = true;
    //         document.querySelector("#background option[value='peach']").disabled = true;

    //         document.querySelector("#background option[value='-']").classList.remove("hidden");
    //         document.querySelector("#background option[value='-']").disabled = false;
    //         document.querySelector("#background option[value='-']").selected = true;
    //     } else {
    //         // Jika paket bukan "spotlight" atau "projector", aktifkan opsi "white" dan nonaktifkan opsi "-"
    //         document.querySelector("#background option[value='white']").disabled = false;
    //         document.querySelector("#background option[value='-']").disabled = true;

    //         let old = {{old('background') ? 'true' : 'false'}};
    //         if (!old) {
    //             document.querySelector("#background option[value='white']").selected = true;
    //         }
    //     }
    // }


    function checkJumlahOrang() {
        let input = document.querySelector("#jumlah");
        if (input.value > 5) {
            input.value = 5;
        }
    }

    // function waktuAction() {
    //     document.querySelectorAll("#waktu input[name='waktu[]']").forEach((element, index) => {
    //         element.addEventListener("change", () => {
    //             const isChecked = element.checked;

    //             // Mengatur status disabled untuk semua input waktu
    //             document.querySelectorAll("#waktu input[name='waktu[]']").forEach(element2 => {
    //                 if (element2 !==
    //                     element) { // Tidak termasuk kotak centang yang sedang dipilih
    //                     element2.disabled = isChecked;
    //                 }
    //             });

    //             // Mengubah kelas untuk semua elemen waktuPunya menjadi yang dinonaktifkan
    //             document.querySelectorAll(".waktuPunya").forEach(element3 => {
    //                 if (!isChecked) {
    //                     // Jika kotak centang tidak lagi dipilih, panggil dateAction
    //                     dateAction();
    //                     element3.classList.remove('text-white', 'bg-red-500',
    //                         'dark:hover:text-gray-300', 'dark:border-red-700',
    //                         'dark:peer-checked:text-blue-500',
    //                         'dakr:peer-checked:bg-gray-500', 'dark:peer-checked:bg-gray-700',
    //                         'peer-checked:border-blue-600', 'peer-checked:bg-white',
    //                         'peer-checked:text-blue-600', 'dark:text-gray-400',
    //                         'dark:bg-red-800', 'dark:hover:bg-red-700');
    //                     element3.classList.add('text-gray-500', 'bg-white',
    //                         'dark:hover:text-gray-300', 'dark:border-gray-700',
    //                         'dark:peer-checked:text-blue-500',
    //                         'dakr:peer-checked:bg-gray-500', 'dark:peer-checked:bg-gray-700',
    //                         'peer-checked:border-blue-600', 'peer-checked:bg-white',
    //                         'peer-checked:text-blue-600', 'hover:text-blue-600',
    //                         'hover:border-blue-600', 'dark:text-gray-400',
    //                         'dark:bg-gray-800', 'dark:hover:bg-gray-700');
    //                 } else {
    //                     element3.classList.remove('text-gray-500', 'bg-white',
    //                         'dark:hover:text-gray-300', 'dark:border-gray-700',
    //                         'dark:peer-checked:text-blue-500',
    //                         'dakr:peer-checked:bg-gray-500', 'dark:peer-checked:bg-gray-700',
    //                         'peer-checked:border-blue-600', 'peer-checked:bg-white',
    //                         'peer-checked:text-blue-600', 'hover:text-blue-600',
    //                         'hover:border-blue-600', 'dark:text-gray-400',
    //                         'dark:bg-gray-800', 'dark:hover:bg-gray-700');
    //                     element3.classList.add('text-white', 'bg-red-500',
    //                         'dark:hover:text-gray-300', 'dark:border-red-700',
    //                         'dark:peer-checked:text-blue-500',
    //                         'dakr:peer-checked:bg-gray-500', 'dark:peer-checked:bg-gray-700',
    //                         'peer-checked:border-blue-600', 'peer-checked:bg-white',
    //                         'peer-checked:text-blue-600', 'dark:text-gray-400',
    //                         'dark:bg-red-800', 'dark:hover:bg-red-700');
    //                 }
    //             });
    //         });
    //     });
    // }

</script>
@endsection
