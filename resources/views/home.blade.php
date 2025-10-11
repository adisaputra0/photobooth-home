@extends('layouts.main')

@section('content')
    <div class="container h-100 py-10">
        <div class="max-w-3xl mx-auto ">
            @include('partials.header')
            <img src="{{ asset('img/favicon.png') }}" alt="" class="mx-auto w-[96px] mt-7 mb-3">
            <div class="mb-10">
                <h1 class="uppercase text-xl font-bold text-center text-dark dark:text-white">ignos studio</h1>
                <p class="text-center text-base text-gray-500 ">Self Photo Studio
                </p>

                {{-- <p class="text-center text-base text-gray-500 ">Setiap hari | 08.00 - 23.00
            </p> --}}
                <p class="text-center text-base text-gray-500 ">Setiap hari | Wajib booking
                </p>
                <div id="popup-modal" tabindex="-1"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button"
                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="popup-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>

                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">

                                <svg class="mx-auto text-gray-400 w-16 h-16 dark:text-gray-200" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                        d="M4 18V8a1 1 0 0 1 1-1h1.5l1.707-1.707A1 1 0 0 1 8.914 5h6.172a1 1 0 0 1 .707.293L17.5 7H19a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Z" />
                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>

                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Silahkan pilih menu
                                    cek harga dibawah ini!</h3>
                                <a href="{{ route('checkHarga') }}"
                                    class="inline-block focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4
                                focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2
                                dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    Cek Photo Studio
                                </a>
                                <a href="{{ route('checkHargaPhotobox') }}"
                                    class="inline-block focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4
                                focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2
                                dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    Cek Photobox
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <a href="{{ route('booking') }}"
                class="flex justify-between items-center bg-white shadow-md rounded-full py-2 px-2 cursor-pointer group mb-5 group">
                <img src="{{ asset('img/img-4.JPG') }}" alt="" class="rounded-full h-[40px] w-[40px] object-cover">
                <h1 class=" font-semibold group-hover:text-blue-700 ease-in duration-200">Booking Photo Studio</h1>
                <i class="fa-solid fa-ellipsis group-hover:text-blue-700 ease-in duration-200 mr-1"></i>
            </a>
            <a href="{{ route('booking-photobox') }}"
                class="flex justify-between items-center bg-white shadow-md rounded-full py-2 px-2 cursor-pointer group mb-5 group">
                <img src="{{ asset('img/img-photobox.JPG') }}" alt=""
                    class="rounded-full h-[40px] w-[40px] object-cover">
                <h1 class=" font-semibold group-hover:text-blue-700 ease-in duration-200">Booking Photobox</h1>
                <i class="fa-solid fa-ellipsis group-hover:text-blue-700 ease-in duration-200 mr-1"></i>
            </a>
            <buton data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                class="flex justify-between items-center bg-white shadow-md rounded-full py-2 px-2 cursor-pointer group mb-5 group">
                <img src="{{ asset('img/img-1.jpg') }}" alt="" class="rounded-full h-[40px] w-[40px] object-cover">
                <h1 class=" font-semibold group-hover:text-blue-700 ease-in duration-200">Cek Harga</h1>
                <i class="fa-solid fa-ellipsis group-hover:text-blue-700 ease-in duration-200 mr-1"></i>
            </buton>
            <a href="https://wa.me/6281529751265" target="__blank"
                class="flex justify-between items-center bg-white shadow-md rounded-full py-2 px-2 cursor-pointer group mb-5 group">
                <img src="{{ asset('img/logo-wa.jpg') }}" alt=""
                    class="rounded-full h-[40px] w-[40px] object-cover">
                <h1 class=" font-semibold group-hover:text-blue-700 ease-in duration-200">WhatsApp</h1>
                <i class="fa-solid fa-ellipsis group-hover:text-blue-700 ease-in duration-200 mr-1"></i>
            </a>
            <a href="https://www.tiktok.com/@ignos.studio" target="__blank"
                class="flex justify-between items-center bg-white shadow-md rounded-full py-2 px-2 cursor-pointer group mb-5 group">
                <img src="{{ asset('img/tiktok-logo.png') }}" alt=""
                    class="rounded-full h-[40px] w-[40px] object-cover">
                <h1 class=" font-semibold group-hover:text-blue-700 ease-in duration-200">Tiktok</h1>
                <i class="fa-solid fa-ellipsis group-hover:text-blue-700 ease-in duration-200 mr-1"></i>
            </a>
            <a href="https://maps.app.goo.gl/Qfpq9FF3gAGVb5xU6" target="__blank"
                class="flex justify-between items-center bg-white shadow-md rounded-full py-2 px-2 cursor-pointer group mb-5 group">
                <img src="{{ asset('img/maps-ignos.jpg') }}" alt=""
                    class="rounded-full h-[40px] w-[40px] object-cover">
                <h1 class=" font-semibold group-hover:text-blue-700 ease-in duration-200">Google Maps</h1>
                <i class="fa-solid fa-ellipsis group-hover:text-blue-700 ease-in duration-200 mr-1"></i>
            </a>
            {{-- <a href="{{ route('booking') }}"
        class="block bg-white shadow-md rounded-lg py-4 px-3 cursor-pointer group mb-5">
        <h1 class="text-center font-semibold group-hover:text-blue-700 ease-in duration-200"><i
                class="fa-solid fa-globe mr-2"></i>Booking Now</h1>
        </a> --}}
            {{-- <a href="https://wa.me/6281529751265" target="__blank"
            class="bg-white block shadow-md rounded-lg py-4 px-3 cursor-pointer group mb-5">
            <h1 class="text-center font-semibold group-hover:text-blue-700 ease-in duration-200"><i
                    class="fa-brands fa-whatsapp mr-2"
                    style="font-size: 20px !important; font-weight: 600 !important;"></i>WhatsApp</h1>
        </a> --}}
            {{-- <a href="https://www.tiktok.com/@ignos.studio" target="__blank"
            class="bg-white block shadow-md rounded-lg py-4 px-3 cursor-pointer group mb-5">
            <h1 class="text-center font-semibold group-hover:text-blue-700 ease-in duration-200"><i
                    class="fa-brands fa-tiktok mr-2"></i>Tiktok</h1>
        </a> --}}
            {{-- <a href="https://maps.app.goo.gl/Qfpq9FF3gAGVb5xU6" target="__blank"
            class="block bg-white shadow-md rounded-lg py-4 px-3 cursor-pointer group mb-5">
            <h1 class="text-center font-semibold group-hover:text-blue-700 ease-in duration-200"><i
                    class="fa-solid fa-location-dot mr-2"></i>Google Maps</h1>
        </a> --}}
            <div class="bg-white shadow-md rounded-lg py-4 px-3 cursor-pointer group mb-5 h-[500px] md:h-[650px]">
                <div id="default-carousel" class="relative w-full h-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative overflow-hidden rounded-lg h-full">
                        <!-- Item 1 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-10.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 2 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-2.JPG') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 3 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-3.JPG') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 4 -->
                        {{-- <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('img/img-4.JPG') }}"
                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div> --}}
                        <!-- Item 5 -->
                        {{-- <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('img/img-5.JPG') }}"
                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div> --}}
                        <!-- Item 6 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-7.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 7 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-1.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 8 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-9.JPG') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 9 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-8.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 10 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-11.JPG') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 11 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-12.JPG') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 12 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-13.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 13 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-14.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                        <!-- Item 14 -->
                        {{-- <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('img/img-15.jpg') }}"
                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div> --}}
                        <!-- Item 15 -->
                        {{-- <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('img/img-16.jpg') }}"
                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
        </div> --}}
                        <!-- Item 16 -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('img/img-17.jpg') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        @for ($i = 0; $i < 12; $i++)
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="false"
                                aria-label="Slide {{ $i + 1 }}"
                                data-carousel-slide-to="{{ $i }}"></button>
                        @endfor
                    </div>
                    <!-- Slider controls -->
                    <button type="button"
                        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button"
                        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endsection
