@extends('layouts.main')

@section('content')

<div class="container max-w-4xl mb-8 pt-8">
    @include('partials.header')

    @if($success)
    <div id="alert-border-3"
        class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
        role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <div class="ms-3 text-sm font-medium">
            {{ $success }}
        </div>
        <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
            data-dismiss-target="#alert-border-3" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
    @endif
    
    @if($error)
        <div id="alert-border-error"
            class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800"
            role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM11 15a1 1 0 1 1-2 0V9a1 1 0 0 1 2 0v6ZM10 7a1.25 1.25 0 1 1 0-2.5A1.25 1.25 0 0 1 10 7Z" />
            </svg>
            <div class="ms-3 text-sm font-medium">
                {{ $error }}
            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-border-error" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif

    
    <div class="flex gap-2 justify-center items-center my-10" style="flex-wrap: wrap">
        <h2 class="text-dark dark:text-white text-3xl text-center font-bold">Waktu Tutup Studio (setiap hari)</h2>
        <div>
            <button onclick="addWaktuOperasional()" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
            font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700
            dark:focus:ring-red-900" style="height: max-content">+</button>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        @if(count($waktu_operasional))
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Hari</th>
                        <th scope="col" class="px-6 py-3">Jam</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1?>
                    @foreach($waktu_operasional as $data)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $no }}</th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $hariIndonesia[$data->hari] }}</th>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($data->waktu_awal == 0 && $data->waktu_akhir == 0)
                                    <span class=" text-green-500">Buka sepanjang hari</span>
                                @else
                                    {{ ($data->waktu_awal < 10)? "0":"" }}{{ $data->waktu_awal }}:00
                                    -
                                    {{ ($data->waktu_akhir < 10)? "0":"" }}{{ $data->waktu_akhir }}:00
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('deleteWaktuOperasional', ['id' => $data->id]) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 mt-1"
                                        type="submit" onclick="return confirm('Delete jam pada waktu operasional nomor {{ $no }}?')"><i
                                            class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php $no++?>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-white text-center w-full">Belum ada data</p>
        @endif
    </div>

    <div class="flex gap-2 justify-center items-center my-10" style="flex-wrap: wrap">
        <h2 class="text-dark dark:text-white text-3xl text-center font-bold">Waktu Buka Studio</h2>
        <div class="flex justify-center items-center gap-2">
            <button onclick="addWaktu('buka')" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
            font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700
            dark:focus:ring-red-900" style="height: max-content">+</button>
            <form action="{{ route('deleteWaktuBuka', ['id' => 0, 'deleteAll' => true, 'status' => 'buka']) }}" method="POST" class="flex">
                @csrf
                @method("DELETE")
                <button
                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                type="submit" onclick="return confirm('Delete semua jam pada waktu buka?')"><i
                    class="fa-solid fa-trash"></i></button>
            </form>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        @if(count($waktu_buka))
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Jam</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1?>
                    @foreach($waktu_buka as $data)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $no }}</th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $data->tanggal }}</th>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ ($data->waktu_awal < 10)? "0":"" }}{{ $data->waktu_awal }}:00
                                -
                                {{ ($data->waktu_akhir < 10)? "0":"" }}{{ $data->waktu_akhir }}:00
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('deleteWaktuBuka', ['id' => $data->id, 'deleteAll' => 0, 'status' => 'buka']) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 mt-1"
                                        type="submit" onclick="return confirm('Delete jam pada waktu buka nomor {{ $no }}?')"><i
                                            class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php $no++?>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-white text-center w-full">Belum ada data</p>
        @endif
    </div>

    <div class="flex gap-2 justify-center items-center my-10" style="flex-wrap: wrap">
        <h2 class="text-dark dark:text-white text-3xl text-center font-bold">Waktu Tutup Studio</h2>
        <div class="flex justify-center items-center gap-2">
            <button onclick="addWaktu('tutup')" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
            font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700
            dark:focus:ring-red-900" style="height: max-content">+</button>
            <form action="{{ route('deleteWaktuBuka', ['id' => 0, 'deleteAll' => true, 'status' => 'tutup']) }}" method="POST">
                @csrf
                @method("DELETE")
                <button
                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                type="submit" onclick="return confirm('Delete semua jam pada waktu tutup?')"><i
                    class="fa-solid fa-trash"></i></button>
            </form>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        @if (count($waktu_tutup))
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Jam</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1?>
                    @foreach($waktu_tutup as $data)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $no }}</th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $data->tanggal }}</th>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ ($data->waktu_awal < 10)? "0":"" }}{{ $data->waktu_awal }}:00
                                -
                                {{ ($data->waktu_akhir < 10)? "0":"" }}{{ $data->waktu_akhir }}:00
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('deleteWaktuBuka', ['id' => $data->id, 'deleteAll' => 0, 'status' => 'tutup']) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 mt-1"
                                        type="submit" onclick="return confirm('Delete jam pada waktu tutup nomor {{ $no }}?')"><i
                                            class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php $no++?>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-white text-center w-full">Belum ada data</p>
        @endif
    </div>
    <div class="flex justify-end gap-x-2">
        <a href="{{ route('indexAdmin') }}" class="inline-block focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
        font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700
        dark:focus:ring-red-900 mt-10"><i class="fa-solid fa-backward mr-2"></i>Kembali</a>
        <a href="{{ route('logout') }}" onclick="return confirm('Yakin ingin logout?')" class="inline-block focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300
        font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-red-600 dark:hover:bg-red-700
        dark:focus:ring-red-900 mt-10"><i class="fa-solid fa-right-from-bracket mr-2"></i>Logout</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addWaktu(status) {
        Swal.fire({
            title: "Waktu " + status,
            html: `
                <form id="addWaktuForm" action="{{ route('addWaktuBuka') }}" method="POST" class="text-black">
                    @csrf
                    @method('POST')
                    <label for="tanggal">Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" class="border rounded px-2 py-1 w-full mb-2" required>
                    <label for="waktu_awal">Mulai dari:</label>
                    <select id="waktu_awal" name="waktu_awal" class="border rounded px-2 py-1 w-full mb-2" required>
                        <option value="8">08:00</option>
                        <option value="9">09:00</option>
                        <option value="10">10:00</option>
                        <option value="11">11:00</option>
                        <option value="12">12:00</option>
                        <option value="13">13:00</option>
                        <option value="14">14:00</option>
                        <option value="15">15:00</option>
                        <option value="16">16:00</option>
                        <option value="17">17:00</option>
                        <option value="18">18:00</option>
                        <option value="19">19:00</option>
                        <option value="20">20:00</option>
                        <option value="21">21:00</option>
                        <option value="22">22:00</option>
                    </select>
                    <label for="waktu_akhir">Sampai jam:</label>
                    <select id="waktu_akhir" name="waktu_akhir" class="border rounded px-2 py-1 w-full mb-2" required>
                        <option value="8">08:00</option>
                        <option value="9">09:00</option>
                        <option value="10">10:00</option>
                        <option value="11">11:00</option>
                        <option value="12">12:00</option>
                        <option value="13">13:00</option>
                        <option value="14">14:00</option>
                        <option value="15">15:00</option>
                        <option value="16">16:00</option>
                        <option value="17">17:00</option>
                        <option value="18">18:00</option>
                        <option value="19">19:00</option>
                        <option value="20">20:00</option>
                        <option value="21">21:00</option>
                        <option value="22">22:00</option>
                    </select>
                    <input type="hidden" id="status" name="status" value="${status}">
                </form>
            `,
            showCancelButton: true,
            cancelButtonText: "Cancel",
            buttonsStyling: false,
            customClass: {
                confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded mr-2',
                cancelButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded'
            },
            preConfirm: () => {
                const form = document.getElementById('addWaktuForm');
                if (form) {
                    if(document.getElementById('tanggal').value == ""){
                        alert("isi tanggal dulu");
                    }else{
                        form.submit();
                    }
                }
            }
        });
    }
    
    function addWaktuOperasional() {
        Swal.fire({
            title: "Hari tutup",
            html: `
                <form id="addWaktuOperasionalForm" action="{{ route('addWaktuOperasional') }}" method="POST" class="text-black">
                    @csrf
                    @method('POST')
                    <label for="hari">Hari:</label> 
                    <select id="hari" name="hari" class="border rounded px-2 py-1 w-full mb-2" required>
                        <option value="Monday">Senin</option>
                        <option value="Tuesday">Selasa</option>
                        <option value="Wednesday">Rabu</option>
                        <option value="Thursday">Kamis</option>
                        <option value="Friday">Jumat</option>
                        <option value="Saturday">Sabtu</option>
                        <option value="Sunday">Minggu</option>
                    </select>
                    <label for="waktu_awal">Mulai dari:</label>
                    <select id="waktu_awal" name="waktu_awal" class="border rounded px-2 py-1 w-full mb-2" required>
                        <option value="0">Buka sepanjang hari</option>
                        <option value="8">08:00</option>
                        <option value="9">09:00</option>
                        <option value="10">10:00</option>
                        <option value="11">11:00</option>
                        <option value="12">12:00</option>
                        <option value="13">13:00</option>
                        <option value="14">14:00</option>
                        <option value="15">15:00</option>
                        <option value="16">16:00</option>
                        <option value="17">17:00</option>
                        <option value="18">18:00</option>
                        <option value="19">19:00</option>
                        <option value="20">20:00</option>
                        <option value="21">21:00</option>
                        <option value="22">22:00</option>
                    </select>
                    <label for="waktu_akhir">Sampai jam:</label>
                    <select id="waktu_akhir" name="waktu_akhir" class="border rounded px-2 py-1 w-full mb-2" required>
                        <option value="0">Buka sepanjang hari</option>
                        <option value="8">08:00</option>
                        <option value="9">09:00</option>
                        <option value="10">10:00</option>
                        <option value="11">11:00</option>
                        <option value="12">12:00</option>
                        <option value="13">13:00</option>
                        <option value="14">14:00</option>
                        <option value="15">15:00</option>
                        <option value="16">16:00</option>
                        <option value="17">17:00</option>
                        <option value="18">18:00</option>
                        <option value="19">19:00</option>
                        <option value="20">20:00</option>
                        <option value="21">21:00</option>
                        <option value="22">22:00</option>
                    </select>
                </form>
            `,
            showCancelButton: true,
            cancelButtonText: "Cancel",
            confirmButtonText: "Simpan",
            buttonsStyling: false,
            customClass: {
                confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded mr-2',
                cancelButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded'
            },
            preConfirm: () => {
                const form = document.getElementById('addWaktuOperasionalForm');
                if (form) {
                        form.submit();
                    
                }
            }
        });
    }


    // function addWaktu(status) {
    //     Swal.fire({
    //         title: "Waktu " + status,
    //         html: `
    //             <form id="addWaktuForm" action="{{ route('addWaktuBuka') }}" method="POST" class="flex justify-start" style="flex-direction: column;">
    //                 @csrf
    //                 @method('POST')
    //                 <label for="tanggal">Tanggal:</label>
    //                 <input type="date" id="tanggal" name="tanggal" class="border rounded px-2 py-1 w-full mb-2" required>
    //                 <label for="waktu_awal">Waktu Awal:</label>
    //                 <select id="waktu_awal" name="waktu_awal" class="border rounded px-2 py-1 w-full mb-2" required>
    //                     <option value="8">08:00</option>
    //                     <option value="9">09:00</option>
    //                     <option value="10">10:00</option>
    //                     <option value="11">11:00</option>
    //                     <option value="12">12:00</option>
    //                     <option value="13">13:00</option>
    //                     <option value="14">14:00</option>
    //                     <option value="15">15:00</option>
    //                     <option value="16">16:00</option>
    //                     <option value="17">17:00</option>
    //                     <option value="18">18:00</option>
    //                     <option value="19">19:00</option>
    //                     <option value="20">20:00</option>
    //                     <option value="21">21:00</option>
    //                     <option value="22">22:00</option>
    //                 </select>
    //                 <label for="waktu_akhir">Waktu Akhir:</label>
    //                 <select id="waktu_akhir" name="waktu_akhir" class="border rounded px-2 py-1 w-full mb-2" required>
    //                     <option value="8">08:00</option>
    //                     <option value="9">09:00</option>
    //                     <option value="10">10:00</option>
    //                     <option value="11">11:00</option>
    //                     <option value="12">12:00</option>
    //                     <option value="13">13:00</option>
    //                     <option value="14">14:00</option>
    //                     <option value="15">15:00</option>
    //                     <option value="16">16:00</option>
    //                     <option value="17">17:00</option>
    //                     <option value="18">18:00</option>
    //                     <option value="19">19:00</option>
    //                     <option value="20">20:00</option>
    //                     <option value="21">21:00</option>
    //                     <option value="22">22:00</option>
    //                 </select>
    //                 <input type="hidden" id="status" name="status" value="${status}">

    //                 <div>
    //                     <button
    //                         type="submit"
    //                         class="inline-block focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
    //                             font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-red-900 mt-2">
    //                         Submit
    //                     </button>
    //                     <button
    //                         type="button"
    //                         class="inline-block focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300
    //                         font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-red-600 dark:hover:bg-red-700
    //                         dark:focus:ring-red-900 mt-10">
    //                         Cancel
    //                     </button>
    //                 </div>
    //             </form>
    //         `,
    //         showConfirmButton: false
    //     });
    // }
</script>


@endsection
