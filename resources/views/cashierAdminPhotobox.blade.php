@extends('layouts.main')

@section('content')
    <div class="container h-100 py-10">
        <div class="max-w-4xl mx-auto">
            @include('partials.header')

            <div class="bg-polymorphism mt-10">
                <h1 class="text-2xl font-bold text-center text-dark dark:text-white mt-7">Kasir Photobox</h1>
                <p class="text-center text-gray-700 dark:text-gray-400 mb-7">Masukkan data pesanan pelanggan dan cetak struk
                    pembayaran</p>

                <div class="grid md:grid-cols-2 gap-5">
                    <!-- Form -->
                    <div class="px-3 md:px-10">
                        <form onsubmit="event.preventDefault(); cetakStruk();">
                            <div class="mb-4">
                                <label class="block mb-1 font-medium text-gray-900 dark:text-white">Nama Pelanggan</label>
                                <input type="text" id="nama" required
                                    class="w-full rounded-lg p-2.5 bg-gray-50 border text-sm dark:bg-gray-700 dark:text-white"
                                    placeholder="Nama pelanggan">
                            </div>

                            <div class="mb-4">
                                <label class="block mb-1 font-medium text-gray-900 dark:text-white">Admin yang
                                    Melayani</label>
                                <select id="admin"
                                    class="w-full rounded-lg p-2.5 bg-gray-50 border text-sm dark:bg-gray-700 dark:text-white">
                                    <option value="Admin A">Admin A</option>
                                    <option value="Admin B">Admin B</option>
                                    <option value="Admin C">Admin C</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-1 font-medium text-gray-900 dark:text-white">Meteode
                                    Pembayaran</label>
                                <select id="metode_pembayaran"
                                    class="w-full rounded-lg p-2.5 bg-gray-50 border text-sm dark:bg-gray-700 dark:text-white">
                                    <option value="Cash">Cash</option>
                                    <option value="QRIS">QRIS</option>
                                    <option value="DP & Cash">DP & Cash</option>
                                    <option value="DP & QRIS">DP & QRIS</option>
                                </select>
                            </div>

                            <!-- Produk -->
                            <h2 class="font-semibold mt-6 mb-2 text-gray-800 dark:text-white">Produk</h2>
                            @php
                                $produk = [
                                    'Bingkai 4R' => 20000,
                                    'Cetak 4R' => 10000,
                                    'Keychain' => 15000,
                                    'Cetak 10R + Bingkai' => 80000,
                                    'Pas Foto' => 35000,
                                ];

                                $paket = [
                                    'Photobox (Rp60.000)' => 60000,
                                    // tambahkan pilihan lain di sini jika perlu
                                ];
                            @endphp

                            {{-- Select Paket --}}
                            <div class="mb-4">
                                <label for="selectPaket" class="block text-sm text-gray-900 dark:text-white mb-1">Pilih
                                    Paket</label>
                                <select id="selectPaket"
                                    class="form-produk w-full rounded-lg p-2.5 bg-gray-50 border text-sm dark:bg-gray-700 dark:text-white"
                                    data-harga="{{ array_values($paket)[0] }}" data-nama="{{ array_keys($paket)[0] }}">
                                    @foreach ($paket as $namaPaket => $hargaPaket)
                                        <option value="{{ $hargaPaket }}" data-nama="{{ $namaPaket }}">
                                            {{ $namaPaket }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Input Produk Lain --}}
                            @foreach ($produk as $nama => $harga)
                                <div class="mb-3">
                                    <label class="block text-sm text-gray-900 dark:text-white">{{ $nama }} (Rp
                                        {{ number_format($harga) }})</label>
                                    <input type="number" min="0" value="0"
                                        class="form-produk w-full rounded-lg p-2.5 bg-gray-50 border text-sm dark:bg-gray-700 dark:text-white"
                                        data-harga="{{ $harga }}" data-nama="{{ $nama }}"
                                        id="{{ $nama }}">
                                </div>
                            @endforeach


                            <!-- Layanan tambahan -->
                            <h2 class="font-semibold mt-6 mb-2 text-gray-800 dark:text-white">Layanan Tambahan</h2>
                            <div class="mb-3">
                                <label class="block text-sm text-gray-900 dark:text-white">Penambahan Waktu</label>
                                <select id="penambahan_waktu"
                                    class="w-full rounded-lg p-2.5 bg-gray-50 border text-sm dark:bg-gray-700 dark:text-white"
                                    onchange="updateStruk()">
                                    <option value="-" data-harga="0">-</option>
                                    <option value="5 menit" data-harga="15000">5 Menit (+Rp 15.000)</option>
                                    <option value="10 menit" data-harga="30000">10 Menit (+Rp 30.000)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="block text-sm text-gray-900 dark:text-white">Penambahan Orang (Rp {{ number_format($hargaPerOrang, 0, ',', '.') }} per
                                    orang setelah 2 orang)</label>
                                <input type="number" min="2" id="jumlah_orang"
                                    class="w-full rounded-lg p-2.5 bg-gray-50 border text-sm dark:bg-gray-700 dark:text-white"
                                    value="2" onchange="updateStruk()">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm text-gray-900 dark:text-white">Penambahan Bando (Rp 5.000 per
                                    bando)</label>
                                <input type="number" value="0" id="jumlah_bando"
                                    class="w-full rounded-lg p-2.5 bg-gray-50 border text-sm dark:bg-gray-700 dark:text-white"
                                    onchange="updateStruk()">
                            </div>
                            <div>
                                <div class="hidden items-center mb-3 text-white">
                                    <input type="checkbox" id="tambahan_tirai" class="mr-2" onchange="updateStruk()">
                                    Tirai
                                    (+Rp 15.000)
                                </div>
                                <div class="hidden items-center mb-3 text-white">
                                    <input type="checkbox" id="tambahan_spotlight" class="mr-2" onchange="updateStruk()">
                                    Spotlight (+Rp 15.000)
                                </div>
                                <div class="flex items-center mb-6 text-white">
                                    <input type="checkbox" id="tidak_membuat_story" class="mr-2" onchange="updateStruk()">
                                    Tidak membuat story (+Rp 10.000)
                                </div>
                            </div>
                            
                            {{-- Menu Data --}}
                            <input type="hidden" id="type-photo" class="mr-2" value="Photobox">

                            <div class="flex gap-x-2 mb-5">
                                <a href="{{ route('kasirSelfPhoto') }}"
                                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg px-5 py-3 flex gap-x-2 items-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"><svg
                                        xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                        width="20px" fill="#fff">
                                        <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
                                    </svg>Kasir
                                    Self Photo</a>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg flex gap-x-2 items-center"><svg
                                        xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#fff">
                                        <path
                                            d="M280-640q-33 0-56.5-23.5T200-720v-80q0-33 23.5-56.5T280-880h400q33 0 56.5 23.5T760-800v80q0 33-23.5 56.5T680-640H280Zm0-80h400v-80H280v80ZM160-80q-33 0-56.5-23.5T80-160v-40h800v40q0 33-23.5 56.5T800-80H160ZM80-240l139-313q10-22 30-34.5t43-12.5h376q23 0 43 12.5t30 34.5l139 313H80Zm260-80h40q8 0 14-6t6-14q0-8-6-14t-14-6h-40q-8 0-14 6t-6 14q0 8 6 14t14 6Zm0-80h40q8 0 14-6t6-14q0-8-6-14t-14-6h-40q-8 0-14 6t-6 14q0 8 6 14t14 6Zm0-80h40q8 0 14-6t6-14q0-8-6-14t-14-6h-40q-8 0-14 6t-6 14q0 8 6 14t14 6Zm120 160h40q8 0 14-6t6-14q0-8-6-14t-14-6h-40q-8 0-14 6t-6 14q0 8 6 14t14 6Zm0-80h40q8 0 14-6t6-14q0-8-6-14t-14-6h-40q-8 0-14 6t-6 14q0 8 6 14t14 6Zm0-80h40q8 0 14-6t6-14q0-8-6-14t-14-6h-40q-8 0-14 6t-6 14q0 8 6 14t14 6Zm120 160h40q8 0 14-6t6-14q0-8-6-14t-14-6h-40q-8 0-14 6t-6 14q0 8 6 14t14 6Zm0-80h40q8 0 14-6t6-14q0-8-6-14t-14-6h-40q-8 0-14 6t-6 14q0 8 6 14t14 6Zm0-80h40q8 0 14-6t6-14q0-8-6-14t-14-6h-40q-8 0-14 6t-6 14q0 8 6 14t14 6Z" />
                                    </svg>Cetak
                                    Struk</button>

                            </div>

                        </form>
                    </div>

                    <!-- Struk Preview -->
                    <div class="px-3 md:px-5">
                        <!-- STRUK AREA - CETAK -->
                        <div id="struk-area"
                            class="bg-white p-5 rounded-lg shadow print:border-none max-w-2xl mx-auto text-gray-800 print:text-black">
                            <div class="flex items-center mb-4">
                                <img src="{{ asset('img/favicon.png') }}" alt="Logo" class="w-12 h-12 mr-3">
                                <div>
                                    <h2 class="text-xl font-bold">INVOICE PEMBAYARAN</h2>
                                    <p class="text-sm text-gray-500">INV-<span
                                            id="invoice-number">{{ date('YmdHis') }}</span></p>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="flex justify-between text-sm mb-4">
                                <div>
                                    <p class="font-semibold">Untuk:</p>
                                    <p id="struk-nama">-</p>
                                </div>
                                <div>
                                    <p class="font-semibold">Dilayani oleh:</p>
                                    <p id="struk-admin">-</p>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="mb-4">
                                <h3 class="text-sm font-semibold mb-2">Detail Produk / Layanan</h3>
                                <table class="w-full text-sm table-auto border-collapse">
                                    <thead class="border-b">
                                        <tr>
                                            <th class="text-left py-1">Deskripsi</th>
                                            <th class="text-right py-1">Harga</th>
                                            <th class="text-center py-1">Qty</th>
                                            <th class="text-right py-1">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="struk-produk"></tbody>
                                </table>
                            </div>

                            <hr class="my-4">

                            <div class="mb-4">
                                <h3 class="text-sm font-semibold mb-2">Tambahan</h3>
                                <ul class="text-sm" id="struk-tambahan"></ul>
                            </div>

                            <hr class="my-4">

                            <div class="text-sm text-right">
                                <p class="mb-1">Subtotal: <span id="subtotal">Rp 0</span></p>
                                <p class="font-bold text-lg">Total: <span id="struk-total">Rp 0</span></p>
                            </div>

                            <hr class="my-4">


                            <div class="text-xs mt-4">
                                <p class="font-semibold">Metode Pembayaran:</p>
                                <p id="struk-metode"></p>
                                <p class="mt-2 text-gray-500">Terima kasih telah menggunakan layanan kami.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Script -->
                <script>
                    function updateStruk() {
                        const nama = document.getElementById("nama").value || "-";
                        const admin = document.getElementById("admin").value || "-";
                        const metode_pembayaran = document.getElementById("metode_pembayaran").value;
                        const waktu = document.getElementById("penambahan_waktu");
                        const orang = parseInt(document.getElementById("jumlah_orang").value) || 2;
                        const bando = parseInt(document.getElementById("jumlah_bando").value) || 0;
                        const tirai = document.getElementById("tambahan_tirai").checked;
                        const spotlight = document.getElementById("tambahan_spotlight").checked;
                        const tanpaStory = document.getElementById("tidak_membuat_story").checked;

                        let total = 0;
                        let rows = "";

                        document.querySelectorAll(".form-produk").forEach(input => {
                            const nama = input.dataset.nama;
                            const harga = parseInt(input.dataset.harga);

                            // Tangani <select> untuk paket
                            if (input.tagName === 'SELECT') {
                                const selectedOption = input.options[input.selectedIndex];
                                const namaPaket = selectedOption.dataset.nama || nama;
                                const hargaPaket = parseInt(selectedOption.value);

                                rows += `<tr>
            <td class="py-1">${namaPaket}</td>
            <td class="py-1 text-right">Rp ${hargaPaket.toLocaleString('id-ID')}</td>
            <td class="py-1 text-center">1</td>
            <td class="py-1 text-right">Rp ${hargaPaket.toLocaleString('id-ID')}</td>
        </tr>`;
                                total += hargaPaket;

                            } else {
                                const qty = parseInt(input.value) || 0;
                                if (qty > 0) {
                                    const subtotal = qty * harga;
                                    rows += `<tr>
                <td class="py-1">${nama}</td>
                <td class="py-1 text-right">Rp ${harga.toLocaleString('id-ID')}</td>
                <td class="py-1 text-center">${qty}</td>
                <td class="py-1 text-right">Rp ${subtotal.toLocaleString('id-ID')}</td>
            </tr>`;
                                    total += subtotal;
                                }
                            }
                        });


                        let tambahan = "";
                        if (orang > 2) {
                            let tambahanOrang = (orang - 2) * {{ $hargaPerOrang }};
                            tambahan += `<li>+ ${orang - 2} Orang Tambahan: Rp ${tambahanOrang.toLocaleString('id-ID')}</li>`;
                            total += tambahanOrang;
                        }

                        if (bando) {
                            let tambahanBando = bando * 5000;
                            tambahan += `<li>+ ${bando} Bando tambahan: Rp ${tambahanBando.toLocaleString('id-ID')}</li>`;
                            total += tambahanBando;
                        }

                        const waktuHarga = parseInt(waktu.selectedOptions[0].dataset.harga);
                        if (waktu.value != "-") {
                            tambahan += `<li>+ Tambahan Waktu (${waktu.value}): Rp ${waktuHarga.toLocaleString('id-ID')}</li>`;
                            total += waktuHarga;
                        }

                        if (tirai) {
                            tambahan += `<li>+ Tirai: Rp 15.000</li>`;
                            total += 15000;
                        }

                        if (spotlight) {
                            tambahan += `<li>+ Spotlight: Rp 15.000</li>`;
                            total += 15000;
                        }

                        if (tanpaStory) {
                            tambahan += `<li>+ Tidak Membuat Story: Rp 10.000</li>`;
                            total += 10000;
                        }

                        if (!metode_pembayaran) {
                            alert("Pilih metode pembayaran terlebih dahulu!");
                            return;
                        }

                        // Isi elemen struk
                        document.getElementById("struk-nama").innerText = nama;
                        document.getElementById("struk-admin").innerText = admin;
                        document.getElementById("struk-metode").innerText = metode_pembayaran;
                        document.getElementById("struk-produk").innerHTML = rows ||
                            `<tr><td colspan="4" class="text-center py-2">Tidak ada produk dipilih</td></tr>`;
                        document.getElementById("struk-tambahan").innerHTML = tambahan || "<li>-</li>";
                        document.getElementById("struk-total").innerText = `Rp ${total.toLocaleString('id-ID')}`;
                        document.getElementById("subtotal").innerText = `Rp ${total.toLocaleString('id-ID')}`;
                    }

                    // Update struk saat halaman dimuat
                    updateStruk();

                    document.querySelectorAll("input, select").forEach(el => {
                        el.addEventListener("input", updateStruk);
                    });
                </script>

                <style>
                    @media print {
                        body * {
                            visibility: hidden;
                        }

                        #struk-area,
                        #struk-area * {
                            visibility: visible;
                        }

                        #struk-area {
                            position: absolute;
                            top: 0;
                            left: 50%;
                            transform: translateX(-50%);
                            width: 100%;
                            padding: 20px;
                            background-color: white;
                        }
                    }
                </style>
            </div>
        </div>
    </div>
@endsection
