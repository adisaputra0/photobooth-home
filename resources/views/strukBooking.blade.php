@extends('layouts.main')

@section('content')


<div class="container h-100  py-10">

    <div class="max-w-3xl mx-auto">
        @include('partials.header')
        <div class="bg-polymorphism mt-10">
            <h1 class="text-2xl font-bold text-center text-dark dark:text-white mt-7">Detail Pesanan Anda</h1>
            <p class="font-normal text-gray-700 dark:text-gray-400 text-center w-full md:w-9/12 mx-auto"
                style="padding: 10px;">Berikut
                adalah
                detail
                pesanan anda,
                pastikan klik tombol <b>"Konfirmasi ke Whatsapp"</b> untuk melanjutkan bookingan anda.
            </p>
            <div class="flex md:hidden gap-3 px-5">

                {{-- KEMBALI --}}
                {{-- Untuk kembalinya agar inputannya masih ada --}}
                <form class="mt-5" action="{{ route('backToBooking') }}" method="POST">
                    @csrf
                    @method("POST")
                    <div class="hidden">
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
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Masukkan nama anda" name="nama" autofocus required
                                value="{{ $data['nama'] }}" />
                        </div>
                        <div class="mb-5">
                            <label for="jumlah"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                Orang (max: 15)
                                @error('jumlah_orang')
                                <span class="text-red-600">
                                    ({{ $message }})
                                </span>
                                @enderror
                            </label>
                            <input type="number" min="2" max="15" id="jumlah"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required placeholder="Masukkan jumlah orang" name="jumlah_orang"
                                value="{{ $data['jumlah_orang'] }}" />
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
                                {{-- <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input datepicker type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Pilih tanggal" id="tanggal" name="tanggal" oninput="dateAction()"> --}}

                                {{-- Menurutku pake ini aja bang, karena typenya date, kalau pakai yang diatas itu bagus cuma gabunginnya susah --}}
                                <input type="date" class="form-control w-full ps-5" id="tanggal" name="tanggal"
                                    value="{{ $data['tanggal'] }}" oninput="dateAction()" required>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label for="waktu"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu
                                Booking
                                @error('waktu')
                                <span class="text-red-600">
                                    ({{ $message }})
                                </span>
                                @enderror
                            </label>
                        </div>

                        <div class="mb-5">
                            <label for="Package"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                                Package
                                @error('package')
                                <span class="text-red-600">
                                    ({{ $message }})
                                </span>
                                @enderror
                            </label>
                            <select id="Package"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="package">
                                <option value="basic" {{ $data['package'] == 'basic' ? 'selected' : '' }}>
                                    Basic</option>
                                <option value="spotlight" {{ $data['package'] == 'spotlight' ? 'selected' : '' }}>
                                    Spotlight
                                </option>
                                <option value="projector" {{ $data['package'] == 'projector' ? 'selected' : '' }}>
                                    Projector
                                </option>
                            </select>
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
                            <select id="background"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="background">
                                <option value="wall" {{ $data['background'] == 'wall' ? 'selected' : '' }}>
                                    Wall</option>
                                <option value="white" {{ $data['background'] == 'white' ? 'selected' : '' }}>
                                    White</option>
                                <option value="orange" {{ $data['background'] == 'orange' ? 'selected' : '' }}>
                                    Orange</option>
                                <option value="gray" {{ $data['background'] == 'gray' ? 'selected' : '' }}>
                                    Gray</option>
                                <option value="peach" {{ $data['background'] == 'peach' ? 'selected' : '' }}>
                                    Peach</option>
                                <option value="-" {{ $data['background'] == '-' ? 'selected' : '' }}>-
                                </option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="membawa_binatang"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Membawa
                                Binatang
                                @error('membawa_binatang')
                                <span class="text-red-600">
                                    ({{ $message }})
                                </span>
                                @enderror
                            </label>
                            <div class="flex items-center">
                                <input
                                    {{ (isset($data['membawa_binatang']) && $data['membawa_binatang']) ? 'checked' : '' }}
                                    id="ya" type="checkbox" value="ya"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    name="membawa_binatang">
                                <label for="ya"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ya</label>

                            </div>
                        </div>

                        <div class="mb-5">

                            <label for="penambahan_waktu"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penambahan
                                Waktu
                                @error('penambahan_waktu')
                                <span class="text-red-600">
                                    ({{ $message }})
                                </span>
                                @enderror
                            </label>
                            <div class="flex items-center mb-1">
                                <input
                                    {{ isset($data['penambahan_waktu']) && $data['penambahan_waktu'] == '10 menit' ? ( $data['penambahan_waktu'] == '10 menit' ? 'checked' : '' ) : '' }}
                                    id="10menit" type="radio" value="10 menit" name="penambahan_waktu"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="10menit"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">10
                                    Menit</label>
                            </div>
                            <div class="flex items-center mb-1">
                                <input
                                    {{ isset($data['penambahan_waktu']) && $data['penambahan_waktu'] == '20 menit' ? ($data['penambahan_waktu'] == '20 menit' ? 'checked' : '') : '' }}
                                    id="20menit" type="radio" value="20 menit" name="penambahan_waktu"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="20menit"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">20
                                    Menit</label>
                            </div>
                            <small class="text-gray-500">
                                *Jika merasa waktunya kurang, Anda dapat menambah waktunya
                            </small>

                        </div>
                    </div>

                    <button type="submit"
                        class="text-white bg-primary hover:bg-primary/50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary/hover:bg-primary/50"
                        type="submit">
                        < Edit </button> </form> {{-- SUBMIT --}} {{-- Agar dapat submit inputan sebelumnya --}}
                            <form class="mt-5" action="{{ route('storeBooking') }}" method="POST"
                            onsubmit="return confirm('Yakin dengan pesanan anda?')">
                            @csrf
                            @method("POST")
                            <div class="hidden">
                                @if($errors->any())
                                <div id="alert-border-2"
                                    class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800"
                                    role="alert">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
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
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Masukkan nama anda" name="nama" autofocus required
                                        value="{{ $data['nama'] }}" />
                                </div>
                                <div class="mb-5">
                                    <label for="jumlah"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                        Orang (max: 15)
                                        @error('jumlah_orang')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                        @enderror
                                    </label>
                                    <input type="number" min="2" max="15" id="jumlah"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required placeholder="Masukkan jumlah orang" name="jumlah_orang"
                                        value="{{ $data['jumlah_orang'] }}" />
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
                                        {{-- <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input datepicker type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Pilih tanggal" id="tanggal" name="tanggal" oninput="dateAction()"> --}}

                                        {{-- Menurutku pake ini aja bang, karena typenya date, kalau pakai yang diatas itu bagus cuma gabunginnya susah --}}
                                        <input type="date" class="form-control w-full ps-5" id="tanggal"
                                            name="tanggal" value="{{ $data['tanggal'] }}" oninput="dateAction()"
                                            required>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label for="waktu"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu
                                        Booking
                                        @error('waktu')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                        @enderror
                                    </label>

                                    <input type="text" name="waktu" value="{{ $waktu }}">
                                </div>
                                <input type="text" name="totalHarga" value="{{$totalHarga}}">

                                <div class="mb-5">
                                    <label for="Package"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                                        Package
                                        @error('package')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                        @enderror
                                    </label>
                                    <select id="Package"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        name="package">
                                        <option value="basic" {{ $data['package'] == 'basic' ? 'selected' : '' }}>
                                            Basic
                                        </option>
                                        <option value="spotlight"
                                            {{ $data['package'] == 'spotlight' ? 'selected' : '' }}>
                                            Spotlight</option>
                                        <option value="projector"
                                            {{ $data['package'] == 'projector' ? 'selected' : '' }}>
                                            Projector</option>
                                    </select>
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
                                    <select id="background"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        name="background">
                                        <option value="wall" {{ $data['background'] == 'wall' ? 'selected' : '' }}>
                                            Wall
                                        </option>
                                        <option value="white"
                                            {{ $data['background'] == 'white' ? 'selected' : '' }}>White
                                        </option>
                                        <option value="orange"
                                            {{ $data['background'] == 'orange' ? 'selected' : '' }}>Orange
                                        </option>
                                        <option value="gray" {{ $data['background'] == 'gray' ? 'selected' : '' }}>
                                            Gray
                                        </option>
                                        <option value="peach"
                                            {{ $data['background'] == 'peach' ? 'selected' : '' }}>Peach
                                        </option>
                                        <option value="spotlight"
                                            {{ $data['background'] == 'spotlight' ? 'selected' : '' }}>spotlight
                                        </option>
                                        <option value="-" {{ $data['background'] == '-' ? 'selected' : '' }}>-
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label for="membawa_binatang"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Membawa
                                        Binatang
                                        @error('membawa_binatang')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                        @enderror
                                    </label>
                                    <div class="flex items-center">
                                        <input
                                            {{ (isset($data['membawa_binatang']) && $data['membawa_binatang']) ? 'checked' : '' }}
                                            id="ya" type="checkbox" value="ya"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                            name="membawa_binatang">
                                        <label for="ya"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ya</label>

                                    </div>
                                </div>

                                <div class="mb-5">

                                    <label for="penambahan_waktu"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penambahan
                                        Waktu
                                        @error('penambahan_waktu')
                                        <span class="text-red-600">
                                            ({{ $message }})
                                        </span>
                                        @enderror
                                    </label>
                                    <div class="flex items-center mb-1">
                                        <input
                                            {{ isset($data['penambahan_waktu']) && $data['penambahan_waktu'] == '10 menit' ? ( $data['penambahan_waktu'] == '10 menit' ? 'checked' : '' ) : '' }}
                                            id="10menit" type="radio" value="10 menit" name="penambahan_waktu"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="10menit"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">10
                                            Menit</label>
                                    </div>
                                    <div class="flex items-center mb-1">
                                        <input
                                            {{ isset($data['penambahan_waktu']) && $data['penambahan_waktu'] == '20 menit' ? ($data['penambahan_waktu'] == '20 menit' ? 'checked' : '') : '' }}
                                            id="20menit" type="radio" value="20 menit" name="penambahan_waktu"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="20menit"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">20
                                            Menit</label>
                                    </div>
                                    <small class="text-gray-500">
                                        *Jika merasa waktunya kurang, Anda dapat menambah waktunya
                                    </small>

                                </div>
                            </div>

                            <button type="submit"
                                class="text-white bg-primary hover:bg-primary/50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary/hover:bg-primary/50"
                                type="submit">Konfirmasi ke Whatsapp</button>
                </form>
            </div>
            <div class="grid md:grid-cols-2 mb-10">
                <div class="px-3 md:px-10 order-2 md:order-1">
                    <div class="mb-5">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                        </label>
                        <input type="text" id="nama"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 uppercase"
                            placeholder="Masukkan nama anda" name="nama" disabled value="{{ $data['nama'] }}" />
                    </div>
                    <div class="mb-5">
                        <label for="Jumlah Orang"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Orang
                        </label>
                        <input type="text" id="Jumlah Orang"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukkan nama anda" name="nama" disabled value="{{ $data['jumlah_orang'] }}" />
                    </div>
                    <div class="mb-5">
                        <label for="Tanggal Booking"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Booking
                        </label>
                        <input type="text" id="Tanggal Booking"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukkan nama anda" name="nama" disabled value="{{ $data['tanggal'] }}" />
                    </div>
                    <div class="mb-5">
                        <label for="Waktu Booking"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu Booking
                        </label>
                        <input type="text" id="Waktu Booking"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukkan nama anda" name="nama" disabled
                            value="{{ explode('-',$waktu)[0] }}" />
                    </div>
                    {{-- <div class="mb-5">
                        <label for="Package" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Paket
                        </label>
                        <input type="text" id="Package" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                            dark:focus:border-blue-500 uppercase" placeholder="Masukkan nama anda" name="nama" disabled
                            value="{{ $data['package'] }}" />
                    </div> --}}
                <div class="mb-5">
                    <label for="Background"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Background
                    </label>
                    <input type="text" id="Background"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 uppercase"
                        placeholder="Masukkan nama anda" name="nama" disabled value="{{ $data['background'] }}" />
                </div>
                @if (isset($data['membawa_binatang']))
                <div class="mb-5">
                    <label for="membawa_binatang"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Membawa Peliharaan
                    </label>
                    <div class="flex items-center">
                        <input checked id="ya" type="checkbox" value="ya"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            name="membawa_binatang" disabled>
                        <label for="ya" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ya</label>
                    </div>
                </div>
                @endif
                @if (isset($data['penambahan_waktu']))
                <div class="mb-5">
                    <label for="Tambahan Waktu"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tambahan Waktu
                    </label>
                    <input type="text" id="Tambahan Waktu"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan nama anda" name="nama" disabled value="{{ $data['penambahan_waktu'] }}" />
                </div>
                @endif
                @if(isset($data["tambahan_tirai"]))
                    <div class="mb-5">
                        <div class="flex items-center">
                            <input id="tambahan_tirai" type="checkbox"
                                value="benar" name="tambahan_tirai" disabled
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" checked>
                            <label for="tambahan_tirai" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tambahan Tirai</label>
                        </div>
                        <img src="{{ asset('img/tirai.jpg') }}" alt="" style="max-width: 100%;" class="mt-5 rounded-lg img_tirai">
                    </div>
                @endif
                @if(isset($data["tambahan_spotlight"]))
                <div class="mb-5">
                    <div class="flex items-center">
                        <input id="tambahan_spotlight" type="checkbox"
                            value="benar" name="tambahan_spotlight" disabled
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" checked>
                        <label for="tambahan_spotlight" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tambahan Spotlight</label>
                    </div>
                    <img src="{{ asset('img/spotlight.jpg') }}" alt="" style="max-width: 100%;" class="mt-5 rounded-lg img_spotlight">
                </div>
                @endif
                <div class="hidden md:flex gap-3">

                    {{-- KEMBALI --}}
                    {{-- Untuk kembalinya agar inputannya masih ada --}}
                    <form class="mt-5" action="{{ route('backToBooking') }}" method="POST">
                        @csrf
                        @method("POST")
                        <div class="hidden">
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
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Masukkan nama anda" name="nama" autofocus required
                                    value="{{ $data['nama'] }}" />
                            </div>
                            <div class="mb-5">
                                <label for="jumlah"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                    Orang (max: 15)
                                    @error('jumlah_orang')
                                    <span class="text-red-600">
                                        ({{ $message }})
                                    </span>
                                    @enderror
                                </label>
                                <input type="number" min="2" max="15" id="jumlah"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required placeholder="Masukkan jumlah orang" name="jumlah_orang"
                                    value="{{ $data['jumlah_orang'] }}" />
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
                                    {{-- <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input datepicker type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Pilih tanggal" id="tanggal" name="tanggal" oninput="dateAction()"> --}}

                                    {{-- Menurutku pake ini aja bang, karena typenya date, kalau pakai yang diatas itu bagus cuma gabunginnya susah --}}
                                    <input type="date" class="form-control w-full ps-5" id="tanggal" name="tanggal"
                                        value="{{ $data['tanggal'] }}" oninput="dateAction()" required>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="waktu"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu
                                    Booking
                                    @error('waktu')
                                    <span class="text-red-600">
                                        ({{ $message }})
                                    </span>
                                    @enderror
                                </label>
                            </div>

                            <div class="mb-5">
                                <label for="Package"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                                    Package
                                    @error('package')
                                    <span class="text-red-600">
                                        ({{ $message }})
                                    </span>
                                    @enderror
                                </label>
                                <select id="Package"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="package">
                                    <option value="basic" {{ $data['package'] == 'basic' ? 'selected' : '' }}>
                                        Basic</option>
                                    <option value="spotlight" {{ $data['package'] == 'spotlight' ? 'selected' : '' }}>
                                        Spotlight
                                    </option>
                                    <option value="projector" {{ $data['package'] == 'projector' ? 'selected' : '' }}>
                                        Projector
                                    </option>
                                </select>
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
                                <select id="background"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    name="background">
                                    <option value="wall" {{ $data['background'] == 'wall' ? 'selected' : '' }}>
                                        Wall</option>
                                    <option value="white" {{ $data['background'] == 'white' ? 'selected' : '' }}>
                                        White</option>
                                    <option value="orange" {{ $data['background'] == 'orange' ? 'selected' : '' }}>
                                        Orange</option>
                                    <option value="gray" {{ $data['background'] == 'gray' ? 'selected' : '' }}>
                                        Gray</option>
                                    <option value="peach" {{ $data['background'] == 'peach' ? 'selected' : '' }}>
                                        Peach</option>
                                    <option value="-" {{ $data['background'] == '-' ? 'selected' : '' }}>-
                                    </option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="membawa_binatang"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Membawa
                                    Binatang
                                    @error('membawa_binatang')
                                    <span class="text-red-600">
                                        ({{ $message }})
                                    </span>
                                    @enderror
                                </label>
                                <div class="flex items-center">
                                    <input
                                        {{ (isset($data['membawa_binatang']) && $data['membawa_binatang']) ? 'checked' : '' }}
                                        id="ya" type="checkbox" value="ya"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        name="membawa_binatang">
                                    <label for="ya"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ya</label>

                                </div>
                            </div>

                            <div class="mb-5">

                                <label for="penambahan_waktu"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penambahan
                                    Waktu
                                    @error('penambahan_waktu')
                                    <span class="text-red-600">
                                        ({{ $message }})
                                    </span>
                                    @enderror
                                </label>
                                <div class="flex items-center mb-1">
                                    <input
                                        {{ isset($data['penambahan_waktu']) && $data['penambahan_waktu'] == '10 menit' ? ( $data['penambahan_waktu'] == '10 menit' ? 'checked' : '' ) : '' }}
                                        id="10menit" type="radio" value="10 menit" name="penambahan_waktu"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="10menit"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">10
                                        Menit</label>
                                </div>
                                <div class="flex items-center mb-1">
                                    <input
                                        {{ isset($data['penambahan_waktu']) && $data['penambahan_waktu'] == '20 menit' ? ($data['penambahan_waktu'] == '20 menit' ? 'checked' : '') : '' }}
                                        id="20menit" type="radio" value="20 menit" name="penambahan_waktu"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="20menit"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">20
                                        Menit</label>
                                </div>
                                <small class="text-gray-500">
                                    *Jika merasa waktunya kurang, Anda dapat menambah waktunya
                                </small>

                            </div>
                        </div>

                        <button type="submit"
                            class="text-white bg-primary hover:bg-primary/50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary/hover:bg-primary/50"
                            type="submit">
                            < Edit </button> </form> {{-- SUBMIT --}} {{-- Agar dapat submit inputan sebelumnya --}}
                                <form class="mt-5" action="{{ route('storeBooking') }}" method="POST"
                                onsubmit="return confirm('Yakin dengan pesanan anda?')">
                                @csrf
                                @method("POST")
                                <div class="hidden">
                                    @if($errors->any())
                                    <div id="alert-border-2"
                                        class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800"
                                        role="alert">
                                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
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
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Masukkan nama anda" name="nama" autofocus required
                                            value="{{ $data['nama'] }}" />
                                    </div>
                                    
                                    <input id="tambahan_tirai" type="checkbox"
                            value="pakai" name="tambahan_tirai"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $biayaTirai ? 'checked' : '' }}><input id="tambahan_tirai" type="checkbox"
                            value="pakai" name="tambahan_spotlight"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $biayaSpotlight ? 'checked' : '' }}>
                                    <div class="mb-5">
                                        <label for="jumlah"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
                                            Orang (max: 15)
                                            @error('jumlah_orang')
                                            <span class="text-red-600">
                                                ({{ $message }})
                                            </span>
                                            @enderror
                                        </label>
                                        <input type="number" min="2" max="15" id="jumlah"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required placeholder="Masukkan jumlah orang" name="jumlah_orang"
                                            value="{{ $data['jumlah_orang'] }}" />
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
                                            {{-- <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input datepicker type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Pilih tanggal" id="tanggal" name="tanggal" oninput="dateAction()"> --}}

                                            {{-- Menurutku pake ini aja bang, karena typenya date, kalau pakai yang diatas itu bagus cuma gabunginnya susah --}}
                                            <input type="date" class="form-control w-full ps-5" id="tanggal"
                                                name="tanggal" value="{{ $data['tanggal'] }}" oninput="dateAction()"
                                                required>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label for="waktu"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu
                                            Booking
                                            @error('waktu')
                                            <span class="text-red-600">
                                                ({{ $message }})
                                            </span>
                                            @enderror
                                        </label>

                                        <input type="text" name="waktu" value="{{ $waktu }}">
                                    </div>
                                    <input type="text" name="totalHarga" value="{{$totalHarga}}">

                                    <div class="mb-5">
                                        <label for="Package"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                                            Package
                                            @error('package')
                                            <span class="text-red-600">
                                                ({{ $message }})
                                            </span>
                                            @enderror
                                        </label>
                                        <select id="Package"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            name="package">
                                            <option value="basic" {{ $data['package'] == 'basic' ? 'selected' : '' }}>
                                                Basic
                                            </option>
                                            <option value="spotlight"
                                                {{ $data['package'] == 'spotlight' ? 'selected' : '' }}>
                                                Spotlight</option>
                                            <option value="projector"
                                                {{ $data['package'] == 'projector' ? 'selected' : '' }}>
                                                Projector</option>
                                        </select>
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
                                        <select id="background"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            name="background">
                                            <option value="wall" {{ $data['background'] == 'wall' ? 'selected' : '' }}>
                                                Wall
                                            </option>
                                            <option value="white"
                                                {{ $data['background'] == 'white' ? 'selected' : '' }}>White
                                            </option>
                                            <option value="orange"
                                                {{ $data['background'] == 'orange' ? 'selected' : '' }}>Orange
                                            </option>
                                            <option value="gray" {{ $data['background'] == 'gray' ? 'selected' : '' }}>
                                                Gray
                                            </option>
                                            <option value="peach"
                                                {{ $data['background'] == 'peach' ? 'selected' : '' }}>Peach
                                            </option>
                                            <option value="spotlight"
                                                {{ $data['background'] == 'spotlight' ? 'selected' : '' }}>spotlight
                                            </option>
                                            <option value="-" {{ $data['background'] == '-' ? 'selected' : '' }}>-
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-5">
                                        <label for="membawa_binatang"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Membawa
                                            Binatang
                                            @error('membawa_binatang')
                                            <span class="text-red-600">
                                                ({{ $message }})
                                            </span>
                                            @enderror
                                        </label>
                                        <div class="flex items-center">
                                            <input
                                                {{ (isset($data['membawa_binatang']) && $data['membawa_binatang']) ? 'checked' : '' }}
                                                id="ya" type="checkbox" value="ya"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                name="membawa_binatang">
                                            <label for="ya"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ya</label>

                                        </div>
                                    </div>

                                    <div class="mb-5">

                                        <label for="penambahan_waktu"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penambahan
                                            Waktu
                                            @error('penambahan_waktu')
                                            <span class="text-red-600">
                                                ({{ $message }})
                                            </span>
                                            @enderror
                                        </label>
                                        <div class="flex items-center mb-1">
                                            <input
                                                {{ isset($data['penambahan_waktu']) && $data['penambahan_waktu'] == '10 menit' ? ( $data['penambahan_waktu'] == '10 menit' ? 'checked' : '' ) : '' }}
                                                id="10menit" type="radio" value="10 menit" name="penambahan_waktu"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="10menit"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">10
                                                Menit</label>
                                        </div>
                                        <div class="flex items-center mb-1">
                                            <input
                                                {{ isset($data['penambahan_waktu']) && $data['penambahan_waktu'] == '20 menit' ? ($data['penambahan_waktu'] == '20 menit' ? 'checked' : '') : '' }}
                                                id="20menit" type="radio" value="20 menit" name="penambahan_waktu"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="20menit"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">20
                                                Menit</label>
                                        </div>
                                        <small class="text-gray-500">
                                            *Jika merasa waktunya kurang, Anda dapat menambah waktunya
                                        </small>

                                    </div>
                                </div>

                                <button type="submit"
                                    class="text-white bg-primary hover:bg-primary/50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary/hover:bg-primary/50"
                                    type="submit">Konfirmasi ke Whatsapp</button>
                    </form>
                </div>
            </div>
            <div class="px-3 md:pr-10 mt-5 order-1 md:order-2">
                <div
                    class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400 uppercase">Total Pembayaran
                    </h5>
                    <div class="flex items-baseline text-gray-900 dark:text-white">
                        <span class="text-3xl font-semibold">Rp.</span>
                        <span class="text-5xl font-extrabold tracking-tight">{{$totalHarga}}</span>
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
                                {{ $data['package'] }}
                                : Rp.{{ $hargaPackage }}
                            </span>
                        </li> --}}
                        
                        @if ($data['penambahan_waktu'] == "10 menit")
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">40
                                Menit Durasi Foto</span>
                        </li>
                        @elseif($data['penambahan_waktu'] == "20 menit")
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">50
                                Menit Durasi Foto</span>
                        </li>
                        @else
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">30
                                Menit Durasi Foto</span>
                        </li>
                        @endif
                        {{-- <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">30
                                Menit Durasi Foto</span>
                        </li> --}}
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span
                                class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">{{ $data['jumlah_orang'] }}
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
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Free
                                Costume & Accessories</span>
                        </li>
                        @if ($hargaTambahanWaktu > 0)
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                                    ms-3">Tambahan Waktu {{ ($data['penambahan_waktu']) }} :
                                Rp.{{ $hargaTambahanWaktu }}</span>
                        </li>
                        @endif
                        @if ($biayaTirai)
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                                    ms-3">Tambahan Tirai :
                                Rp.{{ $biayaTirai }}</span>
                        </li>
                        @endif
                        @if ($biayaSpotlight)
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                                    ms-3">Tambahan Spotlight :
                                Rp.{{ $biayaSpotlight }}</span>
                        </li>
                        @endif
                        @if($data['jumlah_orang'] <= 7) <li class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">2
                                orang : {{ $hargaPackage }}</span>
                            </li>
                            @endif

                            @if ($hargaOrang > 0)
                            <li class="flex">
                                <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                @if($data['jumlah_orang'] > 7)
                                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                                    ms-3">Karena lebih dari 7 orang, setiap orang dikenakan biaya Rp.
                                    {{ $biayaPerOrang }}</span>
                                @else
                                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                                        ms-3">Tambahan untuk {{ ($data['jumlah_orang']-2) }} Orang :
                                    {{ $hargaOrang }}</span>
                                @endif
                            </li>
                            @endif

                    </ul>
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                            focus:ring-blue-200 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900
                             rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full
                            text-center font-bold">Total Pembayaran : Rp.{{$totalHarga}}</button>
                </div>

                <h1 class="font-semibold text-dark dark:text-white mt-5 mb-2">Lokasi Studio :</h1>
                <iframe class="w-full aspect-video rounded-lg"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.3005833517764!2d115.20913097373982!3d-8.567068786902686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23d004fd4fdf3%3A0xb4cbcfe9a27c17d5!2sIGNOS%20STUDIO%20SELF%20PHOTO%20STUDIO!5e0!3m2!1sid!2sid!4v1712905316828!5m2!1sid!2sid"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>



                {{-- <p>
                        Note :
                        <br>* Mohon untuk datang tepat waktu(lebih baik 15 menit sebelum jam booking), apabila terlambat
                        mohon maaf kami tidak ada penambahan waktu.
                    </p>
                    <p>
                        Terimakasih sudah reservasi, see you kak
                    </p> --}}

            </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

@endsection
