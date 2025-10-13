@extends('layouts.photobooth')

@section('content')
    <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-black min-h-screen p-4 sm:p-8">
        <div x-data="{
            uploadedPhotos: {{ Js::from($photos->map(fn($p) => asset($p->file_path))) }},
            templates: {{ Js::from($templates) }},
            selectedTemplates: [],
            templateSlots: {}, // { templateIndex: [photo1, photo2, ...] }
            remainingTime: 0,
            timerInterval: null,
            activeTemplate: 0,
        
            init() {
                // Ambil selectedTemplates dari localStorage
                const storedTemplates = localStorage.getItem('selectedTemplates');
                const templateIds = storedTemplates ? JSON.parse(storedTemplates) : [];
        
                // Map ke data template lengkap
                this.selectedTemplates = templateIds.map(id => this.templates[id]);
        
                // Inisialisasi slots kosong untuk setiap template
                this.selectedTemplates.forEach((template, index) => {
                    this.templateSlots[index] = Array(template.slots).fill(null);
                });
        
                // Timer
                const savedMinutes = localStorage.getItem('sessionDuration');
                const durationInSeconds = savedMinutes ? parseInt(savedMinutes) * 60 : 60 * 1;
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
        
            selectPhoto(templateIndex, slotIndex, photo) {
                this.templateSlots[templateIndex][slotIndex] = photo;
            },
        
            selectPhotoAuto(templateIndex, photo) {
                const emptyIndex = this.templateSlots[templateIndex].findIndex(slot => slot === null);
                if (emptyIndex !== -1) {
                    this.templateSlots[templateIndex][emptyIndex] = photo;
                }
            },
        
            handleFinish() {
                alert('Terima kasih! Hasil akhir Anda sedang diproses.');
                // Kirim data this.templateSlots ke backend
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

                    <!-- Pilih template yang mana -->
                    <template x-if="selectedTemplates.length > 1">
                        <div class="flex gap-2 mb-4 justify-center flex-wrap">
                            <template x-for="(template, idx) in selectedTemplates" :key="idx">
                                <button @click="activeTemplate = idx"
                                    :class="activeTemplate === idx ? 'bg-blue-600' : 'bg-gray-700'"
                                    class="px-3 py-1 rounded-lg text-white text-xs" x-text="`Template ${idx + 1}`">
                                </button>
                            </template>
                        </div>
                    </template>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <template x-for="(photo, index) in uploadedPhotos" :key="index">
                            <img :src="photo" @click="selectPhotoAuto(activeTemplate || 0, photo)"
                                class="w-full h-28 object-cover rounded-xl border border-gray-700 hover:border-blue-500 cursor-pointer transition-all" />
                        </template>
                    </div>
                </div>
                <!-- Right: Template Slots -->
                <div>
                    <h2 class="text-gray-200 mb-4 text-center">Template Pilihan</h2>

                    <!-- Loop setiap template -->
                    <template x-for="(template, templateIndex) in selectedTemplates" :key="templateIndex">
                        <div class="mb-6">
                            <h3 class="text-gray-300 text-sm mb-3" x-text="`${template.name} (${template.slots} slots)`">
                            </h3>

                            <!-- Grid slots berdasarkan jumlah slots template -->
                            <div class="grid grid-cols-2 gap-4">
                                <template x-for="(slot, slotIndex) in templateSlots[templateIndex]" :key="slotIndex">
                                    <div class="w-full h-32 rounded-xl border-2 border-dashed flex items-center justify-center text-gray-500 cursor-pointer"
                                        :class="slot ? 'border-blue-500 bg-gray-700/50' : 'border-gray-600/50'"
                                        @click="templateSlots[templateIndex][slotIndex] = null">

                                        <template x-if="!slot">
                                            <span x-text="`Slot ${slotIndex + 1}`"></span>
                                        </template>

                                        <template x-if="slot">
                                            <img :src="slot" class="w-full h-full object-cover rounded-lg" />
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
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
