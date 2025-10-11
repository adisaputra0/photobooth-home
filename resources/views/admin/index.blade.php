@extends('layouts.main')

@section('content')
    <div class="container max-w-4xl mb-8 pt-8">
        @include('partials.header')

        @if ($success)
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
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        @if (count($data) == 0)
            <p>Belum ada yang booking</p>
        @endif

        @foreach ($data as $tanggal => $bookings)
            <form action="{{ route('destroyBooking', ['date' => $tanggal]) }}" method="POST"
                class="flex justify-center items-center gap-3 my-10">
                @csrf
                @method('DELETE')
                <h2 class="text-dark dark:text-white text-3xl text-center font-bold">{{ $tanggal }}</h2>
                <button
                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 mt-1"
                    type="submit" onclick="return confirm('Delete seluruh pesanan pada tanggal {{ $tanggal }}?')"><i
                        class="fa-solid fa-trash"></i></button>
            </form>
            {{-- <form action="{{ route('destroyBooking', ['date' => $tanggal]) }}" method="POST">
    @csrf
    @method("DELETE")
    <button type="submit" onclick="return confirm('Delete seluruh pesanan pada {{ $tanggal }}?')"><i
            class="fa-solid fa-trash"></i></button>
    </form> --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Nama</th>
                            <th scope="col" class="px-6 py-3">Jumlah Orang</th>
                            <th scope="col" class="px-6 py-3">Waktu</th>
                            <th scope="col" class="px-6 py-3">Package</th>
                            <th scope="col" class="px-6 py-3">Background</th>
                            <th scope="col" class="px-6 py-3">Penambahan Waktu</th>
                            <th scope="col" class="px-6 py-3">Tirai</th>
                            <th scope="col" class="px-6 py-3">Spotlight</th>
                            <th scope="col" class="px-6 py-3">Nomor Telpon</th>
                            <th scope="col" class="px-6 py-3">Kendaraan</th>
                            <th scope="col" class="px-6 py-3">Tanggal Booking</th>
                            <th scope="col" class="px-6 py-3">Catatan</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($bookings as $booking)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $no }}</th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $booking->nama }}</th>
                                <td class="px-6 py-4">{{ $booking->jumlah_orang }} orang</td>
                                <td class="px-6 py-4">{{ $booking->waktu }}</td>
                                <td class="px-6 py-4">{{ $booking->package }}</td>
                                <td class="px-6 py-4">{{ $booking->background }}</td>
                                <td class="px-6 py-4">
                                    {{ $booking->penambahan_waktu ? $booking->penambahan_waktu : 'Tidak ada data yang terekam' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $booking->tirai ? $booking->tirai : 'Tidak ada data yang terekam' }}</td>
                                <td class="px-6 py-4">
                                    {{ $booking->spotlight ? $booking->spotlight : 'Tidak ada data yang terekam' }}</td>
                                <td class="px-6 py-4">
                                    @if ($booking->nomor_telp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->nomor_telp) }}"
                                            target="_blank" class="text-blue-600 hover:underline">
                                            {{ $booking->nomor_telp }}
                                        </a>
                                    @else
                                        Tidak ada data yang terekam
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    {{ $booking->kendaraan ? $booking->kendaraan : 'Tidak ada data yang terekam' }}</td>
                                <td class="px-6 py-4">{{ $booking->created_at }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('booking.addNote', $booking->id) }}" method="POST">
                                        @csrf
                                        <textarea 
                                            name="note" 
                                            placeholder="Tulis catatan..."
                                            class="bg-transparent"
                                            onkeydown="if(event.key === 'Enter'){ event.preventDefault(); this.form.submit(); }"
                                        >{{ $booking->note }}</textarea>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('destroyOneBooking', ['id' => $booking->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="font-medium text-red-600 dark:text-red-500 hover:underline"
                                            type="submit"
                                            onclick="return confirm('Delete data pada tanggal {{ $tanggal }} nomor {{ $no }}?')"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
        <div class="flex justify-end gap-x-2">
            <a href="{{ route('harga') }}"
                class="inline-block focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
        font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700
        dark:focus:ring-red-900 mt-10"><i
                    class="fa-solid fa-tag mr-2"></i>Edit Harga</a>
            <a href="{{ route('indexAdminPhotobox') }}"
                class="inline-block focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
        font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700
        dark:focus:ring-red-900 mt-10"><i
                    class="fa-solid fa-tag mr-2"></i>Photobox</a>
            <a href="{{ route('waktuBukaStudio') }}"
                class="inline-block focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300
        font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700
        dark:focus:ring-red-900 mt-10"><i
                    class="fa-solid fa-tag mr-2"></i>Waktu Buka Studio</a>
            <a href="{{ route('logout') }}" onclick="return confirm('Yakin ingin logout?')"
                class="inline-block focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300
        font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-red-600 dark:hover:bg-red-700
        dark:focus:ring-red-900 mt-10"><i
                    class="fa-solid fa-right-from-bracket mr-2"></i>Logout</a>
        </div>
    </div>
@endsection
