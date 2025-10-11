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
                <form class="mt-5" action="{{ route('backToBookingPhotobox') }}" method="POST">
                    @csrf
                    @method("POST")
                    <input type="text" class="hidden" name="nama" value="{{ $data['nama'] }}">
                    <input type="text" class="hidden" name="jumlah_orang" value="{{ $data['jumlah_orang'] }}">
                    <input type="text" class="hidden" name="tanggal" value="{{ $data['tanggal'] }}">
                    <input type="text" class="hidden" name="waktu" value="{{ $data['waktu'] }}">
                    <input type="text" class="hidden" name="penambahan_waktu" value="{{ $data['penambahan_waktu'] }}">
                    @if ($hargaBando > 0)
                    <input type="text" class="hidden" name="jumlah_bando" value="{{ $data['jumlah_bando'] }}">
                    @endif
                    <button type="submit"
                        class="text-white bg-primary hover:bg-primary/50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary/hover:bg-primary/50"
                        type="submit">
                        < Edit </button> </form> {{-- SUBMIT --}} {{-- Untuk submmit agar inputannya ada --}} <form
                            class="mt-5" action="{{ route('storeBookingPhotobox') }}" method="POST">
                            @csrf
                            @method("POST")
                            <input type="text" class="hidden" name="nama" value="{{ $data['nama'] }}">
                            <input type="text" class="hidden" name="jumlah_orang" value="{{ $data['jumlah_orang'] }}">
                            <input type="text" class="hidden" name="tanggal" value="{{ $data['tanggal'] }}">
                            <input type="text" class="hidden" name="waktu" value="{{ $data['waktu'] }}">
                            <input type="text" class="hidden" name="penambahan_waktu"
                                value="{{ $data['penambahan_waktu'] }}">
                            @if ($hargaBando > 0)
                            <input type="text" class="hidden" name="jumlah_bando" value="{{ $data['jumlah_bando'] }}">
                            @foreach ($nama_gambar as $item)
                            <input type="text" class="hidden" name="gambar_bando[]" value="{{ $item }}">
                            @endforeach
                            @endif
                            <input type="text" class="hidden" name="totalHarga" value="{{ $totalHarga }}">
                            <button type="submit"
                                class="text-white bg-primary hover:bg-primary/50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary/hover:bg-primary/50"
                                type="submit">
                                Konfirmasi ke Whatsapp
                            </button>
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
                            placeholder="Masukkan nama anda" name="nama" disabled value="{{ $data['waktu'] }}" />
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
                @if ($hargaBando > 0)
                <div class="mb-5">
                    <label for="Jumlah Bando"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Bando
                    </label>
                    <input type="text" id="Jumlah Bando"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan nama anda" name="nama" disabled value="{{ $data['jumlah_bando'] }}" />
                </div>
                @endif
                @if ($nama_gambar)
                @foreach ($nama_gambar as $item)
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preview gambar bando :
                </label>
                <img src="{{ asset('temp_photos/' . $item) }}" alt=""
                    style="width: 300px; height: 300px; object-fit: cover">
                @endforeach
                @endif
                <div class="hidden md:flex gap-3">

                    {{-- KEMBALI --}}
                    {{-- Untuk kembalinya agar inputannya masih ada --}}
                    <form class="mt-5" action="{{ route('backToBookingPhotobox') }}" method="POST">
                        @csrf
                        @method("POST")
                        <input type="text" class="hidden" name="nama" value="{{ $data['nama'] }}">
                        <input type="text" class="hidden" name="jumlah_orang" value="{{ $data['jumlah_orang'] }}">
                        <input type="text" class="hidden" name="tanggal" value="{{ $data['tanggal'] }}">
                        <input type="text" class="hidden" name="waktu" value="{{ $data['waktu'] }}">
                        <input type="text" class="hidden" name="penambahan_waktu"
                            value="{{ $data['penambahan_waktu'] }}">
                        @if ($hargaBando > 0)
                        <input type="text" class="hidden" name="jumlah_bando" value="{{ $data['jumlah_bando'] }}">
                        @endif
                        <button type="submit"
                            class="text-white bg-primary hover:bg-primary/50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary/hover:bg-primary/50"
                            type="submit">
                            < Edit </button> </form> {{-- SUBMIT --}} {{-- Untuk submmit agar inputannya ada --}} <form
                                class="mt-5" action="{{ route('storeBookingPhotobox') }}" method="POST">
                                @csrf
                                @method("POST")
                                <input type="text" class="hidden" name="nama" value="{{ $data['nama'] }}">
                                <input type="text" class="hidden" name="jumlah_orang"
                                    value="{{ $data['jumlah_orang'] }}">
                                <input type="text" class="hidden" name="tanggal" value="{{ $data['tanggal'] }}">
                                <input type="text" class="hidden" name="waktu" value="{{ $data['waktu'] }}">
                                <input type="text" class="hidden" name="penambahan_waktu"
                                    value="{{ $data['penambahan_waktu'] }}">
                                @if ($hargaBando > 0)
                                <input type="text" class="hidden" name="jumlah_bando"
                                    value="{{ $data['jumlah_bando'] }}">
                                @foreach ($nama_gambar as $item)
                                <input type="text" class="hidden" name="gambar_bando[]" value="{{ $item }}">
                                @endforeach
                                @endif
                                <input type="text" class="hidden" name="totalHarga" value="{{ $totalHarga }}">
                                <button type="submit"
                                    class="text-white bg-primary hover:bg-primary/50 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary dark:hover:bg-primary dark:focus:ring-primary/hover:bg-primary/50"
                                    type="submit">
                                    Konfirmasi ke Whatsapp
                                </button>
                    </form>
                </div>
            </div>
            <div class="px-3 md:pr-10 mt-5 order-1 md:order-2">
                <div
                    class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400 uppercase ">Total
                        Pembayaran
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
                                Photobox
                            </span>
                        </li> --}}
                        @if ($data['penambahan_waktu'] == "5 menit")
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">20
                                Menit Durasi Foto</span>
                        </li>
                        @elseif($data['penambahan_waktu'] == "10 menit")
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">25
                                Menit Durasi Foto</span>
                        </li>
                        @else
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">15
                                Menit Durasi Foto</span>
                        </li>
                        @endif
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

                        @if($hargaBando > 0)
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400
                                        ms-3">{{ ($data['jumlah_bando']) }} Bando :
                                Rp.{{ $hargaBando }}</span>
                        </li>
                        <li class="flex">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">Bando tidak dibawa pulang(hanya untuk foto)</span>
                        </li>
                        @endif
                        @if($data['jumlah_orang'] <= 7) <li class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span
                                class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400 ms-3">{{ $data["jumlah_orang"] }}
                                orang : Rp.{{ $hargaOrang }}</span>
                            </li>
                            @endif



                    </ul>
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                            focus:ring-blue-200 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900
                             rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full
                            text-center font-bold ">Total Pembayaran : Rp.{{$totalHarga}}</button>
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
