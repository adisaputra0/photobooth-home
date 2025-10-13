@extends('layouts.photobooth')

@section('content')
    <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-black min-h-screen p-4 sm:p-8">
        <div x-data="{
            uploadedPhotos: {{ Js::from($photos->map(fn($p) => asset($p->file_path))) }},
            selectedSlots: Array(3).fill(null),
            remainingTime: 0,
            timerInterval: null,
        
            init() {
                // Ambil durasi dari localStorage (dalam menit)
                const savedMinutes = localStorage.getItem('sessionDuration');
                const durationInSeconds = savedMinutes ? parseInt(savedMinutes) * 60 : 60 * 1; // default 1 menit jika kosong
                this.remainingTime = durationInSeconds;
        
                this.startCountdown();
            },
        
            startCountdown() {
                this.timerInterval = setInterval(() => {
                    if (this.remainingTime > 0) {
                        this.remainingTime--;
                    } else {
                        clearInterval(this.timerInterval);
                        alert('Waktu Habis');
                    }
                }, 1000);
            },
        
            formatTime(seconds) {
                const m = Math.floor(seconds / 60);
                const s = seconds % 60;
                return `${m}:${s.toString().padStart(2, '0')}`;
            },
        
            selectPhoto(slotIndex, photo) {
                this.selectedSlots[slotIndex] = photo;
            },
        
            handleFinish() {
                alert('Terima kasih! Hasil akhir Anda sedang diproses.');
            }
        }"
            class="relative max-w-6xl mx-auto bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl">

            <!-- Countdown Timer (kanan atas) -->
            <div
                class="absolute top-4 right-6 bg-gray-900/70 border border-gray-700/50 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-md">
                ⏱️ <span x-text="formatTime(remainingTime)"></span>
            </div>

            <!-- Header -->
            <div class="text-center mb-8">
                <p class="text-sm text-gray-400 mb-1">Langkah 3 dari 3</p>
                <h1 class="text-white text-2xl font-semibold mb-2">
                    Susun Hasil Akhir Anda
                </h1>
                <p class="text-gray-400 text-sm">
                    Pilih foto terbaik dan tempatkan ke dalam template pilihan Anda
                </p>
            </div>

            <!-- Grid -->
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Left: Uploaded Photos -->
                <div>
                    <h2 class="text-gray-200 mb-4 text-center">Foto Anda</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <template x-for="(photo, index) in uploadedPhotos" :key="index">
                            <img :src="photo"
                                @click="selectPhoto(selectedSlots.findIndex(slot => slot === null), photo)"
                                class="w-full h-28 object-cover rounded-xl border border-gray-700 hover:border-blue-500 cursor-pointer transition-all" />
                        </template>
                    </div>
                </div>

                <!-- Right: Template Slots -->
                <div>
                    <h2 class="text-gray-200 mb-4 text-center">Template Pilihan</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <template x-for="(slot, index) in selectedSlots" :key="index">
                            <div class="w-full h-32 rounded-xl border-2 border-dashed flex items-center justify-center text-gray-500 cursor-pointer"
                                :class="slot ? 'border-blue-500 bg-gray-700/50' : 'border-gray-600/50'"
                                @click="slot = null">
                                <template x-if="!slot">
                                    <span>Kosong</span>
                                </template>
                                <template x-if="slot">
                                    <img :src="slot" class="w-full h-full object-cover rounded-lg" />
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="flex justify-end mt-8">
                <button @click="handleFinish()"
                    class="bg-green-600 border border-green-700/50 rounded-xl px-6 py-3 text-white hover:bg-green-700 transition-all duration-300 shadow-lg">
                    Selesai & Generate Hasil →
                </button>
            </div>
        </div>
    </div>
@endsection
