@extends('layouts.photobooth')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-800 via-gray-900 to-black p-4 sm:p-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl"
                x-data="gantunganKunci()">

                <!-- Header -->
                <div class="text-center mb-8">
                    <p class="text-sm text-gray-400 mb-1">Langkah 2 dari 3</p>
                    <h1 class="text-white text-2xl font-semibold mb-2">Pilih Gantungan Kunci</h1>
                    <p class="text-gray-400 text-sm">Tentukan bentuk gantungan dan pilih foto hasil sesi Anda</p>
                </div>

                <!-- Grid Utama -->
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Kiri -->
                    <div class="space-y-6">
                        <!-- Input Jumlah -->
                        <div class="space-y-2">
                            <label class="text-gray-300">Jumlah Gantungan Kunci</label>
                            <input type="number" min="1" x-model.number="jumlah"
                                class="w-full bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 rounded-xl px-4 py-3 text-white placeholder:text-gray-500 focus:outline-none focus:border-gray-500 transition-all duration-300" />
                        </div>

                        <!-- Pilihan Bentuk -->
                        <div class="space-y-2">
                            <label class="text-gray-300">Pilih Bentuk Gantungan</label>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <button type="button" @click="bentuk = 'love'"
                                    :class="bentuk === 'love' ? 'border-pink-500 bg-pink-500/20' : 'border-gray-600/50'"
                                    class="border rounded-xl p-4 text-white flex flex-col items-center gap-2 hover:border-pink-400 transition-all duration-300">
                                    <i class="fa-solid fa-heart text-pink-400 text-2xl"></i>
                                    <span>Love</span>
                                </button>

                                <button type="button" @click="bentuk = 'kotak'"
                                    :class="bentuk === 'kotak' ? 'border-blue-500 bg-blue-500/20' : 'border-gray-600/50'"
                                    class="border rounded-xl p-4 text-white flex flex-col items-center gap-2 hover:border-blue-400 transition-all duration-300">
                                    <i class="fa-regular fa-square text-blue-400 text-2xl"></i>
                                    <span>Kotak</span>
                                </button>
                            </div>
                        </div>

                        <!-- Pilihan Foto -->
                        <div class="space-y-2">
                            <label class="text-gray-300">Pilih Foto Anda</label>
                            <p class="text-sm text-gray-400 mb-2">Klik salah satu foto di bawah</p>
                            <div class="grid grid-cols-3 gap-3">
                                <template x-for="(foto, index) in fotoList" :key="index">
                                    <div class="relative group">
                                        <img :src="foto" @click="pilihFoto(foto)"
                                            class="w-full h-24 object-cover rounded-xl border-2 cursor-pointer transition-all duration-300"
                                            :class="fotoPreview === foto ? 'border-blue-500 ring-2 ring-blue-400/60' :
                                                'border-gray-600/50 hover:border-gray-400'" />
                                        <div x-show="fotoPreview === foto"
                                            class="absolute inset-0 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                            <i class="fa-solid fa-check text-white text-xl"></i>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Info Total -->
                        <div
                            class="bg-gradient-to-r from-gray-700/40 to-gray-800/40 backdrop-blur-sm border border-gray-600/50 rounded-xl p-4 text-center text-white mt-6">
                            <p class="text-sm text-gray-400">Total Pembayaran</p>
                            <p class="text-3xl font-semibold mt-1">Rp <span
                                    x-text="(jumlah * 25000).toLocaleString('id-ID')"></span></p>
                            <p class="text-xs text-gray-500 mt-1">(Rp 25.000 / pcs)</p>
                            <p class="text-xs text-gray-500 mt-1" x-text="bentuk"></p>

                        </div>
                    </div>

                    <!-- Kanan (Preview Gantungan) -->
                    <div class="flex justify-center items-center relative">
                        <div class="relative w-72 h-72 flex justify-center items-center">
                            <!-- Bentuk Love -->
                            <template x-if="bentuk === 'love'">
                                <div class="relative w-60 h-60 flex justify-center items-center animate-swing">
                                    <div class="relative w-56 h-56 bg-pink-500/10 border-4 border-pink-400/50 shadow-2xl overflow-hidden"
                                        style="clip-path: path('M 150 30 C 150 -20, 70 -20, 70 40 A 40 40 0 0 0 150 120 A 40 40 0 0 0 230 40 C 230 -20, 150 -20, 150 30 Z');">
                                        <img :src="fotoPreview" alt="Preview"
                                            class="w-full h-full object-cover transition-all duration-500" />
                                    </div>
                                </div>
                            </template>



                            <!-- Bentuk Kotak -->
                            <template x-if="bentuk === 'kotak'">
                                <div
                                    class="w-60 h-60 bg-blue-500/10 border-4 border-blue-400/50 rounded-2xl overflow-hidden flex justify-center items-center shadow-2xl animate-swing">
                                    <img :src="fotoPreview" alt="Preview"
                                        class="w-full h-full object-cover transition-all duration-500" />
                                </div>
                            </template>

                            <!-- Gantungan -->
                            <div class="absolute top-0 w-8 h-8 bg-gray-400 rounded-full border-4 border-gray-700"></div>
                            <div class="absolute -top-4 w-1 h-8 bg-gray-500 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end mt-8">
                    <button type="button"
                        class="bg-blue-600 border border-blue-700/50 rounded-xl px-6 py-3 text-white hover:bg-blue-700 transition-all duration-300 shadow-lg">
                        Lanjut ke Pembayaran →
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function gantunganKunci() {
            return {
                jumlah: 1,
                bentuk: 'kotak',
                fotoList: [
                    '/uploads/photobooth/IGS06546.JPG',
                    '/uploads/photobooth/IGS0s6546.JPG',
                    '/uploads/photobooth/IGS065s46.JPG',
                ],
                fotoPreview: '/uploads/photobooth/IGS06546.JPG',
                pilihFoto(foto) {
                    this.fotoPreview = foto;
                },
            }
        }
    </script>

    <style>
        /* Efek ayunan pelan */
        @keyframes swing {
            0% {
                transform: rotate(1deg);
            }

            50% {
                transform: rotate(-1deg);
            }

            100% {
                transform: rotate(1deg);
            }
        }

        .animate-swing {
            animation: swing 3s ease-in-out infinite;
            transform-origin: top center;
        }
    </style>
@endsection
