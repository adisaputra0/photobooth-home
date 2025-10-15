@extends('layouts.photobooth')

@section('content')
    <div x-data="{
        numPeople: 2,
        numBando: 0,
        timeAddition: '-',
        showTutorials: false,
        bonusModalOpen: false,
        confirmModalOpen: false,
        bonusAccepted: false,
        pricePerPerson: {{ $hargaPhotobox }},
        hargaBando: {{ $hargaBando }},
        hargaTambahanWaktu: {{ $hargaTambahanWaktu }},
        get totalPrice() {
            let total = this.numPeople * this.pricePerPerson;
    
            // Tambahan waktu
            if (this.timeAddition === '5') total += this.hargaTambahanWaktu;
            else if (this.timeAddition === '10') total += this.hargaTambahanWaktu * 2;
    
            // Tambahan bando
            total += this.numBando * this.hargaBando;
    
            return total;
        },
        handleBonusAccept() {
            this.bonusAccepted = true;
            this.bonusModalOpen = false;
            localStorage.setItem('bonusAccepted', this.bonusAccepted);
        },
        resetBonusAccept() {
            this.bonusAccepted = false;
            this.bonusModalOpen = false;
            localStorage.setItem('bonusAccepted', this.bonusAccepted);
        },
        {{-- handleContinue() {
            window.location.href = `{{ route('photobooth.template') }}`;
        }, --}}
        updateNumPeople() {
            localStorage.setItem('numPeople', this.numPeople);
        }
    }" x-init="updateNumPeople();
    resetBonusAccept()" x-effect="updateNumPeople();"
        class="min-h-screen bg-gradient-to-br from-gray-800 via-gray-900 to-black p-4 sm:p-8">
        <div class="max-w-5xl mx-auto">
            <!-- Main Card -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl">
                <!-- Input Durasi (pojok kanan atas) -->
                <div
                    class="absolute top-4 right-4 flex items-center gap-2 bg-gray-700/60 border border-gray-600/50 rounded-xl px-3 py-2">
                    <label for="sessionDuration" class="text-gray-300 text-sm whitespace-nowrap">
                        Durasi Sesi:
                    </label>
                    <button type="button" class="text-gray-400 text-sm hidden cursor-pointer" id="resetSessionDuration"
                        onclick="resetSessionDuration()"><i class="fa-solid fa-reply"></i></button>
                    <input type="number" id="sessionDuration" x-model.number="sessionDuration" min="5"
                        class="w-16 bg-gray-800/70 text-white text-sm border border-gray-600/50 rounded-lg px-2 py-1 focus:outline-none focus:border-gray-400 transition-all duration-200"
                        placeholder="0" onchange="updateSessionDuration()" />
                    <span class="text-gray-400 text-sm">menit</span>
                </div>

                <!-- Header -->
                <div class="text-center mb-8">
                    <p class="text-sm text-gray-400 mb-1">Langkah 1 dari 3</p>
                    <h1 class="text-white text-2xl font-semibold mb-2">
                        Pilih Paket & Upload Foto
                    </h1>
                    <p class="text-gray-400 text-sm">
                        Tentukan paket Anda dan unggah foto hasil sesi Anda
                    </p>
                </div>

                <form action="{{ route('photobooth.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <!-- Main Content Grid -->
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <!-- Left -->
                        <div class="space-y-6" x-data="{
                            files: [],
                            handleFileUpload(e) {
                                this.files = Array.from(e.target.files);
                            },
                            cancelUpload() {
                                this.files = [];
                                $refs.fileInput.value = '';
                            }
                        }">
                            <!-- Jumlah Orang -->
                            <div>
                                <label class="text-gray-300 mb-3">Masukkan Jumlah Orang</label>
                                <input type="number" x-model.number="numPeople" @change="updateNumPeople()" min="1"
                                    id="numPeople"
                                    class="w-full bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 rounded-xl px-4 py-3 text-white placeholder:text-gray-500 focus:outline-none focus:border-gray-500 transition-all duration-300" />
                            </div>

                            <!-- Jumlah Bando -->
                            <div class="space-y-3">
                                <label class="text-gray-300">Jumlah Bando</label>
                                <p class="text-sm text-gray-400">
                                    Tambahkan berapa banyak bando yang digunakan (Rp.
                                    {{ number_format($hargaBando, 0, ',', '.') }} / pcs)
                                </p>
                                <input type="number" x-model.number="numBando" min="0"
                                    class="w-full bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 rounded-xl px-4 py-3 text-white placeholder:text-gray-500 focus:outline-none focus:border-gray-500 transition-all duration-300" />
                            </div>

                            <!-- Penambahan Waktu -->
                            <div class="space-y-3">
                                <label class="text-gray-300">Penambahan Waktu</label>
                                <p class="text-sm text-gray-400">
                                    Jika merasa waktunya kurang, Anda dapat menambah waktunya
                                </p>
                                <select x-model="timeAddition"
                                    class="w-full bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-gray-500 transition-all duration-300 appearance-none cursor-pointer">
                                    <option value="-">-</option>
                                    <option value="5">+5 Menit</option>
                                    <option value="10">+10 Menit</option>
                                </select>
                            </div>

                            <!-- Upload File -->
                            <div class="space-y-3">
                                <label class="text-gray-300">Pilih folder foto Anda</label>
                                <p class="text-sm text-gray-400">Pastikan foto yang diupload sesuai dengan hasil sesi Anda
                                </p>

                                <label for="fileUpload"
                                    class="flex items-center justify-center gap-3 cursor-pointer bg-gray-700/50 border border-gray-600/50 rounded-xl px-4 py-3 text-gray-300 hover:bg-gray-700/70 transition-all duration-300">
                                    <i class="fa-solid fa-upload text-blue-400"></i>
                                    <span>Pilih File</span>
                                </label>

                                <input type="file" id="fileUpload" accept="image/*" name="photos[]" class="hidden"
                                    multiple required x-ref="fileInput" @change="handleFileUpload($event)" />

                                <!-- Info File Uploaded -->
                                <template x-if="files.length > 0">
                                    <div
                                        class="bg-green-600/10 border border-green-500/30 rounded-xl px-4 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
                                        <div class="text-green-400">
                                            <i class="fa-solid fa-check mr-1"></i>
                                            <span x-text="files.length + ' foto berhasil diupload'"></span>
                                        </div>
                                        <button @click="cancelUpload" type="button"
                                            class="text-red-400 hover:text-red-300 transition-colors text-sm flex items-center gap-1">
                                            <i class="fa-solid fa-xmark"></i> Batal
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>



                        <!-- Right -->
                        <div
                            class="bg-gradient-to-br from-gray-700/40 to-gray-800/40 backdrop-blur-sm border border-gray-600/50 rounded-2xl p-6">
                            <h3 class="text-gray-300 text-center mb-6">TOTAL PEMBAYARAN</h3>

                            <div class="text-center mb-8">
                                <div class="flex items-baseline justify-center gap-1">
                                    <span class="text-white text-3xl">Rp.</span>
                                    <span class="text-white text-5xl" x-text="totalPrice.toLocaleString('id-ID')"></span>
                                    <span class="text-gray-400">/sesi</span>
                                </div>
                            </div>

                            <!-- Fitur Paket -->
                            <div class="space-y-3 text-gray-200 text-sm">
                                <!-- Item -->
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-5 h-5 flex items-center justify-center rounded-full bg-blue-500/80 flex-shrink-0 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="white" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span
                                        x-text="`${15 + (timeAddition !== '-' ? parseInt(timeAddition) : 0)} Menit Durasi Foto`"></span>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-5 h-5 flex items-center justify-center rounded-full bg-blue-500/80 flex-shrink-0 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="white" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span>15 Menit Seleksi Foto</span>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-5 h-5 flex items-center justify-center rounded-full bg-blue-500/80 flex-shrink-0 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="white" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span>2 Print Ukuran 4R</span>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-5 h-5 flex items-center justify-center rounded-full bg-blue-500/80 flex-shrink-0 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="white" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span>All Softcopy File</span>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-5 h-5 flex items-center justify-center rounded-full bg-blue-500/80 flex-shrink-0 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="white" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span>Free Costume & Accessories</span>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-5 h-5 flex items-center justify-center rounded-full bg-blue-500/80 flex-shrink-0 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="white" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span>
                                        <span x-text="numPeople"></span> orang : Rp.
                                        <span x-text="totalPrice.toLocaleString('id-ID')"></span>
                                    </span>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <!-- Lingkaran dinamis -->
                                    <div class="w-5 h-5 flex items-center justify-center rounded-full flex-shrink-0 mt-0.5 transition-all duration-300"
                                        :class="bonusAccepted ? 'bg-blue-500/80' : 'bg-red-500/80'">
                                        <!-- Icon Checklist -->
                                        <template x-if="bonusAccepted">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="3" stroke="white" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </template>

                                        <!-- Icon Silang -->
                                        <template x-if="!bonusAccepted">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="3" stroke="white" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </template>
                                    </div>

                                    <!-- Teks Dinamis -->
                                    <span :class="bonusAccepted ? 'text-green-400' : 'text-red-400'"
                                        x-text="bonusAccepted ? 'Mengikuti bonus' : 'Tidak mengikuti bonus'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tutorial Section -->
                    <div class="mt-8 border-t border-gray-700/50 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2 text-gray-300">
                                <i class="fa-solid fa-circle-info text-blue-400"></i>
                                <span>Tutorial & Panduan</span>
                            </div>
                            <button type="button" @click="showTutorials = !showTutorials"
                                class="cursor-pointer flex items-center gap-2 text-sm text-blue-400 hover:text-blue-300 transition-colors">
                                <i :class="showTutorials ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                                <span x-text="showTutorials ? 'Sembunyikan Tutorial' : 'Lihat Tutorial'"></span>
                            </button>
                        </div>

                        <div x-show="showTutorials" x-transition class="grid sm:grid-cols-2 gap-4">
                            <!-- Tutorial 1 -->
                            <button type="button" @click="bonusModalOpen = true"
                                class="cursor-pointer bg-gradient-to-br from-green-600/20 to-green-700/20 backdrop-blur-sm border border-green-500/30 rounded-2xl p-4 text-left hover:from-green-600/30 hover:to-green-700/30 transition-all duration-300">
                                <h4 class="text-white mb-1">
                                    <i class="fa-solid fa-gift text-green-400 mr-2"></i>
                                    Tutorial Bonus
                                </h4>
                                <p class="text-sm text-gray-400">
                                    Pelajari cara mendapatkan bonus tambahan untuk paket Anda
                                </p>
                                <div class="mt-2 text-xs px-2 py-1 rounded-lg inline-block transition-all duration-300"
                                    :class="bonusAccepted
                                        ?
                                        'bg-green-500/20 text-green-400 border border-green-500/30' :
                                        'bg-gray-700/30 text-gray-400 border border-gray-600/30'"
                                    x-text="bonusAccepted ? '✓ Bonus Aktif' : 'Bonus Tidak Aktif'"></div>
                            </button>

                            <!-- Tutorial 2 -->
                            <button type="button" @click="confirmModalOpen = true"
                                class="cursor-pointer bg-gradient-to-br from-purple-600/20 to-purple-700/20 backdrop-blur-sm border border-purple-500/30 rounded-2xl p-4 text-left hover:from-purple-600/30 hover:to-purple-700/30 transition-all duration-300">
                                <h4 class="text-white mb-1">
                                    <i class="fa-solid fa-check-to-slot text-purple-400 mr-2"></i>
                                    Konfirmasi Detail
                                </h4>
                                <p class="text-sm text-gray-400">
                                    Pastikan Anda sudah membaca semua detail paket sebelum booking
                                </p>
                                <div
                                    class="mt-2 text-xs px-2 py-1 rounded-lg inline-block bg-gray-700/30 text-gray-400 border border-gray-600/30">
                                    Klik untuk verifikasi
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="cursor-pointer bg-blue-600 border border-blue-700/50 rounded-xl px-6 py-3 text-white hover:bg-blue-700 transition-all duration-300 shadow-lg">
                            Lanjut ke Pemilihan Template →
                        </button>
                    </div>
                </form>
            </div>

            <!-- Modal Bonus -->
            <div x-show="bonusModalOpen" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <div
                    class="relative max-w-2xl w-full bg-white/95 backdrop-blur-xl border border-gray-200/50 rounded-3xl shadow-2xl p-8">
                    <button type="button" @click="bonusModalOpen = false"
                        class="absolute top-4 right-4 w-8 h-8 bg-gray-100/80 hover:bg-gray-200/80 rounded-full flex items-center justify-center transition-all duration-300">
                        <i class="fa-solid fa-xmark text-gray-600"></i>
                    </button>
                    <h2 class="text-gray-800 mb-6">
                        <i class="fa-solid fa-gift text-green-500 mr-2"></i>
                        Tutorial 1: Penawaran Bonus Spesial
                    </h2>
                    <div class="bg-blue-50/80 border border-blue-200/50 rounded-xl p-4 mb-4">
                        <h3 class="text-blue-800 mb-2">🎁 Penawaran Bonus Eksklusif!</h3>
                        <p class="text-blue-700 text-sm">
                            Dapatkan bonus tambahan dengan mengikuti syarat berikut:
                        </p>
                    </div>
                    <ul class="text-sm text-gray-700 space-y-2 list-disc ml-6">
                        <li>Follow dan mention akun Instagram @ignos.studio</li>
                        <li>Dapatkan tambahan 10k softcopy files gratis</li>
                        <li>Free costume & accessories</li>
                    </ul>
                    <div class="flex gap-3 pt-6">
                        <button type="button" @click="resetBonusAccept()"
                            class="cursor-pointer flex-1 bg-gray-100 rounded-xl py-3 text-gray-700 hover:bg-gray-200 transition-all">
                            Tidak, Terima Kasih
                        </button>
                        <button type="button" @click="handleBonusAccept()"
                            class="cursor-pointer flex-1 bg-green-600 rounded-xl py-3 text-white hover:bg-green-700 transition-all">
                            Ya, Saya Ikut Bonus!
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Konfirmasi -->
            <div x-show="confirmModalOpen" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <div
                    class="relative max-w-2xl w-full bg-white/95 backdrop-blur-xl border border-gray-200/50 rounded-3xl shadow-2xl p-8">
                    <!-- Tombol Close -->
                    <button type="button" @click="confirmModalOpen = false"
                        class="absolute top-4 right-4 w-8 h-8 bg-gray-100/80 hover:bg-gray-200/80 rounded-full flex items-center justify-center transition-all duration-300">
                        <i class="fa-solid fa-xmark text-gray-600"></i>
                    </button>

                    <!-- Judul -->
                    <h2 class="text-gray-800 mb-4 flex items-center">
                        <i class="fa-solid fa-list-check text-purple-500 mr-2"></i>
                        Konfirmasi Detail Paket
                    </h2>

                    <!-- Isi Modal -->
                    <div class="space-y-4 text-gray-700 leading-relaxed">
                        <p>
                            Pastikan seluruh informasi terkait paket, jumlah orang, waktu
                            tambahan, dan pilihan bonus sudah sesuai dengan keinginan Anda
                            sebelum melanjutkan.
                        </p>
                        <p class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 text-sm text-yellow-700">
                            ⚠️ Setelah Anda menekan tombol
                            <strong>“Lanjut ke Pemilihan Template”</strong>, semua data
                            dianggap telah benar dan tidak dapat diubah kembali.
                            <br />
                            Jika terjadi kesalahan setelah tahap ini, tanggung jawab
                            sepenuhnya berada pada pihak Anda (pengguna).
                        </p>
                        <p>
                            Dengan melanjutkan, Anda menyatakan bahwa seluruh data telah
                            diperiksa dengan teliti.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //Session Duration Management
        let sessionDurationDefault = 15;
        let sessionDuration = localStorage.getItem('sessionDuration');
        let txt_sessionDuration = document.getElementById("sessionDuration");
        let btn_resetSessionDuration = document.getElementById("resetSessionDuration");

        if (!sessionDuration) {
            localStorage.setItem('sessionDuration', sessionDurationDefault);
            sessionDuration = sessionDurationDefault;
        }
        if (sessionDuration != sessionDurationDefault) {
            btn_resetSessionDuration.classList.remove('hidden');
        } else {
            btn_resetSessionDuration.classList.add('hidden');
        }
        txt_sessionDuration.value = sessionDuration;

        function updateSessionDuration() {
            sessionDuration = txt_sessionDuration.value;
            localStorage.setItem('sessionDuration', sessionDuration);
            if (sessionDuration != sessionDurationDefault) {
                btn_resetSessionDuration.classList.remove('hidden');
            } else {
                btn_resetSessionDuration.classList.add('hidden');
            }
        }

        function resetSessionDuration() {
            sessionDuration = sessionDurationDefault;
            localStorage.setItem('sessionDuration', sessionDuration);
            txt_sessionDuration.value = sessionDuration;
            btn_resetSessionDuration.classList.add('hidden');
        }
    </script>
@endsection
