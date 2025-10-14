@extends('layouts.photobooth')

@section('content')
    <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-black min-h-screen p-4 sm:p-8">
        <div x-data="{
            uploadedPhotos: {{ Js::from($photos->map(fn($p) => asset($p->file_path))) }},
            templates: {{ Js::from($templates) }},
            selectedTemplates: [],
            templateSlots: {},
            remainingTime: 0,
            timerInterval: null,
            activeTemplate: 0,
        
            init() {
                const storedTemplates = localStorage.getItem('selectedTemplates');
                const templateIds = storedTemplates ? JSON.parse(storedTemplates) : [];
        
                this.selectedTemplates = templateIds.map(id => this.templates[id]);
                this.selectedTemplates.forEach((template, index) => {
                    this.templateSlots[index] = Array(template.slots).fill(null);
                });
        
                const savedMinutes = localStorage.getItem('sessionDuration');
                const durationInSeconds = savedMinutes ? parseInt(savedMinutes) * 60 : 60;
                this.remainingTime = durationInSeconds;
                this.startCountdown();
        
                // Inisialisasi Panzoom setelah semua gambar muncul
                this.$nextTick(() => {
                    this.initPanzoom();
                });
            },
        
            startCountdown() {
                this.timerInterval = setInterval(() => {
                    if (this.remainingTime > 0) this.remainingTime--;
                    else {
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
                this.$nextTick(() => this.initPanzoom());
            },
        
            selectPhotoAuto(templateIndex, photo) {
                const emptyIndex = this.templateSlots[templateIndex].findIndex(slot => slot === null);
                if (emptyIndex !== -1) {
                    this.templateSlots[templateIndex][emptyIndex] = photo;
                    this.$nextTick(() => this.initPanzoom());
                }
            },
        
        
            handleFinish() {
                alert('Terima kasih! Hasil akhir Anda sedang diproses.');
            },
        
            initPanzoom() {
                const images = document.querySelectorAll('.zoomable');
        
                images.forEach((img) => {
                    const parent = img.closest('.zoom-container');
                    if (!parent) return;
        
                    // Reset Panzoom sebelumnya jika ada
                    if (parent.panzoomInstance) {
                        parent.panzoomInstance.destroy();
                        delete parent.panzoomInstance;
                    }
        
                    const panzoom = Panzoom(img, {
                        maxScale: 5,
                        minScale: 1,
                        contain: 'outside',
                        step: 0.1,
                    });
        
                    parent.addEventListener('wheel', panzoom.zoomWithWheel);
                    img.addEventListener('dblclick', () => panzoom.reset());
        
                    parent.addEventListener('mousedown', () => parent.style.cursor = 'grabbing');
                    parent.addEventListener('mouseup', () => parent.style.cursor = 'grab');
        
                    parent.dataset.panzoomInitialized = true;
                    parent.panzoomInstance = panzoom;
                });
            }
        
        }"
            class="relative max-w-6xl mx-auto bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl">

            <!-- Panzoom CDN -->
            <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>

            <!-- Countdown Timer -->
            <div
                class="absolute top-4 right-6 bg-gray-900/70 border border-gray-700/50 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-md">
                ⏱️ <span x-text="formatTime(remainingTime)"></span>
            </div>

            <!-- Header -->
            <div class="text-center mb-8">
                <p class="text-sm text-gray-400 mb-1">Langkah 3 dari 3</p>
                <h1 class="text-white text-2xl font-semibold mb-2">Susun Hasil Akhir Anda</h1>
                <p class="text-gray-400 text-sm">Pilih foto terbaik dan tempatkan ke dalam template pilihan Anda</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Left: Foto Upload -->
                <div>
                    <h2 class="text-gray-200 mb-4 text-center">Foto Anda</h2>

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
                                class="w-full h-28 object-cover rounded-xl border border-gray-700 hover:border-blue-500 cursor-pointer transition-all duration-200" />
                        </template>
                    </div>
                </div>

                <!-- Right: Template Slots -->
                <div>
                    <h2 class="text-gray-200 mb-4 text-center">Template Pilihan</h2>

                    <template x-for="(template, templateIndex) in selectedTemplates" :key="templateIndex">
                        <div class="mb-6">
                            <h3 class="text-gray-300 text-sm mb-3" x-text="`${template.name} (${template.slots} slots)`">
                            </h3>

                            <!-- Template Container -->
                            <div class="relative w-full h-[800px] rounded-xl overflow-hidden border-2 border-gray-700/50">
                                <img :src="template.file_path"
                                    class="absolute inset-0 w-full h-full object-cover opacity-60"
                                    alt="Template Background" />

                                <!-- Slot Grid -->
                                <div class="absolute inset-0 grid grid-cols-2 gap-4 p-4 h-max">
                                    <template x-for="(slot, slotIndex) in templateSlots[templateIndex]"
                                        :key="slotIndex">
                                        <div class="zoom-container group relative w-full aspect-square rounded-xl border-2 border-dashed flex items-center justify-center cursor-grab overflow-hidden bg-gray-900/30 transition"
                                            :class="slot ? 'border-blue-500' : 'border-gray-400/50'">

                                            <!-- Jika belum ada foto -->
                                            <template x-if="!slot">
                                                <span class="text-white text-xs bg-black/50 px-2 py-1 rounded"
                                                    x-text="`Slot ${slotIndex + 1}`"></span>
                                            </template>

                                            <!-- Jika sudah ada foto -->
                                            <template x-if="slot">
                                                <div class="relative w-full h-full">
                                                    <!-- Foto -->
                                                    <img :src="slot"
                                                        class="zoomable w-full h-full object-cover transition-transform duration-200" />

                                                    <!-- Tombol hapus muncul saat hover -->
                                                    <button
                                                        @click.stop="
    templateSlots[templateIndex][slotIndex] = null;
    $nextTick(() => initPanzoom());
"
                                                        class="absolute top-1 right-1 bg-red-600/80 hover:bg-red-700 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-md"
                                                        title="Hapus Foto">
                                                        ✕
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
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
