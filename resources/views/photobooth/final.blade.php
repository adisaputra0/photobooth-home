@php
    use Illuminate\Support\Facades\File;

    // Ambil semua file gambar dari folder uploads/photobooth
    $photoDirectory = public_path('uploads/photobooth');
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $photos = [];

    if (File::exists($photoDirectory)) {
        $files = File::files($photoDirectory);

        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());
            if (in_array($extension, $allowedExtensions)) {
                $photos[] = asset('uploads/photobooth/' . $file->getFilename());
            }
        }
    }

    $templates = $templates ?? [];
@endphp

@extends('layouts.photobooth')

@section('content')
    <style>
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .zoom-container {
            border: none;
        }
    </style>

    <div x-data="{
        showTutorialBar: true,
        previewPhoto: null,
    }" class="bg-gradient-to-br from-gray-800 via-gray-900 to-black min-h-screen p-8 pb-32">
        <div x-data="{
            uploadedPhotos: {{ Js::from($photos) }},
            templates: {{ Js::from($templates) }},
            selectedTemplates: [],
            templateSlots: {},

            // 🆕 FITUR BARU: Menyimpan transform (scale, x, y) setiap foto
            imageTransforms: {}, // Format: { templateIndex: { slotIndex: { scale, x, y } } }

            remainingTime: 0,
            timerInterval: null,
            activeTemplate: 0,

            init() {
                const storedTemplates = localStorage.getItem('selectedTemplates');
                const templateIds = storedTemplates ? JSON.parse(storedTemplates) : [];

                this.selectedTemplates = templateIds.map(id => this.templates[id]);
                this.selectedTemplates.forEach((template, index) => {
                    this.templateSlots[index] = Array(template.slots).fill(null);

                    // 🆕 Inisialisasi object untuk menyimpan transform tiap template
                    this.imageTransforms[index] = {};
                });

                const savedMinutes = localStorage.getItem('sessionDuration');
                const durationInSeconds = savedMinutes ? parseInt(savedMinutes) * 60 : 60;
                this.remainingTime = durationInSeconds;
                this.startCountdown();

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
                // 🆕 Jika foto berbeda dengan sebelumnya, reset transform
                const previousPhoto = this.templateSlots[templateIndex][slotIndex];
                if (previousPhoto !== photo) {
                    delete this.imageTransforms[templateIndex][slotIndex];
                }

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

            // 🔧 FUNGSI UTAMA YANG DIPERBAIKI
            initPanzoom() {
                const images = document.querySelectorAll('.zoomable');

                images.forEach((img) => {
                    const parent = img.closest('.zoom-container');
                    if (!parent) return;

                    // Ambil index dari data attribute
                    const templateIndex = parseInt(parent.dataset.templateIndex);
                    const slotIndex = parseInt(parent.dataset.slotIndex);

                    // Cleanup instance sebelumnya
                    if (parent.panzoomInstance) {
                        // 🆕 SIMPAN transform sebelum destroy
                        const currentTransform = parent.panzoomInstance.getScale();
                        const currentPan = parent.panzoomInstance.getPan();

                        this.imageTransforms[templateIndex] = this.imageTransforms[templateIndex] || {};
                        this.imageTransforms[templateIndex][slotIndex] = {
                            scale: currentTransform,
                            x: currentPan.x,
                            y: currentPan.y
                        };

                        parent.panzoomInstance.destroy();
                        parent.removeEventListener('wheel', parent.wheelHandler);
                        delete parent.panzoomInstance;
                        delete parent.wheelHandler;
                    }

                    const initializePanzoom = () => {
                        const containerW = parent.offsetWidth;
                        const containerH = parent.offsetHeight;
                        const naturalW = img.naturalWidth;
                        const naturalH = img.naturalHeight;

                        if (!naturalW || !naturalH || !containerW || !containerH) return;

                        const fitScale = Math.min(containerW / naturalW, containerH / naturalH);

                        const scaledW = naturalW * fitScale;
                        const scaledH = naturalH * fitScale;
                        const defaultX = (containerW - scaledW) / 2;
                        const defaultY = (containerH - scaledH) / 2;

                        // 🆕 CEK apakah ada transform tersimpan untuk slot ini
                        const savedTransform = this.imageTransforms[templateIndex]?.[slotIndex];

                        const startScale = savedTransform?.scale || fitScale;
                        const startX = savedTransform?.x ?? defaultX;
                        const startY = savedTransform?.y ?? defaultY;

                        const panzoom = Panzoom(img, {
                            maxScale: 5,
                            minScale: fitScale,
                            startScale: startScale, // 🆕 Gunakan saved scale atau default
                            startX: startX, // 🆕 Gunakan saved X atau default
                            startY: startY, // 🆕 Gunakan saved Y atau default
                            contain: 'outside',
                            cursor: 'grab',
                            step: 0.1,
                        });

                        // 🆕 AUTO-SAVE transform setiap kali ada perubahan
                        img.addEventListener('panzoomchange', (e) => {
                            this.imageTransforms[templateIndex] = this.imageTransforms[templateIndex] || {};
                            this.imageTransforms[templateIndex][slotIndex] = {
                                scale: e.detail.scale,
                                x: e.detail.x,
                                y: e.detail.y
                            };
                        });

                        const wheelHandler = (e) => {
                            e.preventDefault();
                            panzoom.zoomWithWheel(e);
                        };
                        parent.addEventListener('wheel', wheelHandler, { passive: false });
                        parent.wheelHandler = wheelHandler;

                        // Double click reset ke posisi default (bukan saved)
                        img.addEventListener('dblclick', () => {
                            panzoom.zoom(fitScale, { animate: true });
                            panzoom.pan(defaultX, defaultY, { animate: true });

                            // 🆕 Hapus saved transform agar kembali ke default
                            if (this.imageTransforms[templateIndex]) {
                                delete this.imageTransforms[templateIndex][slotIndex];
                            }
                        });

                        parent.addEventListener('mousedown', () => parent.style.cursor = 'grabbing');
                        parent.addEventListener('mouseup', () => parent.style.cursor = 'grab');

                        parent.panzoomInstance = panzoom;
                    };

                    if (img.complete && img.naturalWidth > 0) {
                        initializePanzoom();
                    } else {
                        img.addEventListener('load', initializePanzoom, { once: true });
                    }
                });
            },

            printTemplate(index) {
                const element = document.getElementById(`template-container-${index}`);
                if (!element) return alert('Template tidak ditemukan');

                html2canvas(element, {
                        scale: 2,
                        useCORS: true
                    }).then(canvas => {
                            const image = canvas.toDataURL('image/png');

                            const printWindow = window.open('', '_blank');
                            const html = `<html><head><title>Print Template</title><style>@page{size:4in 6in;margin:0;}body{margin:0;display:flex;align-items:center;justify-content:center;background:black;height:100vh;}img{width:100%;height:auto;object-fit:contain;}</style></head><body><img src='${image}' alt='Template Print'/><script>
                                window.onload = function() {
                                    window.print();
                                    setTimeout(() => window.close(), 1000);
                                } < \/script></body > < /html>`;
    printWindow.document.open();
    printWindow.document.write(html);
    printWindow.document.close();
    });
    },

    downloadTemplate(index) {
        const element = document.getElementById(`template-container-${index}`);
        if (!element) return alert('Template tidak ditemukan');

        html2canvas(element, {
            scale: 2,
            useCORS: true,
            backgroundColor: '#000',
        }).then(canvas => {
            const image = canvas.toDataURL('image/jpeg', 1.0);

            const link = document.createElement('a');
            link.href = image;
            link.download = `template-${index + 1}.jpg`;
                                        link.click();
                                    }).catch(err => {
                                        console.error('Gagal mengunduh template:', err);
                                        alert('Terjadi kesalahan saat mengunduh template.');
                                    });
                                },
                                }
                                "
                                class =
                                "relative max-w-6xl mx-auto bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl" >


                            <!-- Countdown Timer -->
                            <div class="absolute top-4 right-6 bg-gray-900/70 border border-gray-700/50 text-white px-4 py-2
            rounded-xl text-sm font-semibold shadow-md">
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
            <div class="h-[150vh] overflow-auto scrollbar-none">
                <h2 class="text-gray-200 mb-4 text-center">Foto Anda</h2>

                <template x-if="selectedTemplates.length > 1">
                    <div class="flex gap-2 mb-4 justify-center flex-wrap">
                        <template x-for="(template, idx) in selectedTemplates" :key="idx">
                            <button @click="activeTemplate = idx"
                                :class="activeTemplate === idx ? 'bg-blue-600' : 'bg-gray-700'"
                                class="px-3 py-1 rounded-lg text-white text-xs" x-text="`Orang ${idx + 1}`">
                            </button>
                        </template>
                    </div>
                </template>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <template x-for="(photo, index) in uploadedPhotos" :key="index">
                        <div class="relative group">
                            <img :src="photo" @click="selectPhotoAuto(activeTemplate || 0, photo)"
                                class="w-full aspect-[9/16] object-cover rounded-xl border border-gray-700 hover:border-blue-500 cursor-pointer transition-all duration-200" />

                            <button @click.stop="previewPhoto = photo"
                                class="absolute top-2 right-2 bg-black/60 hover:bg-black/80 text-white text-xs px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-md">
                                Preview Gambar
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Right: Template Slots -->
            <div class="h-[150vh] overflow-auto scrollbar-none">
                <h2 class="text-gray-200 mb-4 text-center">Template Pilihan</h2>

                <template x-for="(template, templateIndex) in selectedTemplates" :key="templateIndex">
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-gray-300 text-sm"
                                x-text="`${template.name} (${template.slots} slots) - Orang ${templateIndex + 1}`">
                            </h3>
                            <div class="flex gap-2">
                                <button @click="printTemplate(templateIndex)"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1 rounded-lg shadow">
                                    🖨️ Print 4R
                                </button>

                                <button @click="downloadTemplate(templateIndex)"
                                    class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold px-3 py-1 rounded-lg shadow">
                                    💾 Download HD
                                </button>
                            </div>
                        </div>

                        <!-- Template Container -->
                        <div :id="`template-container-${templateIndex}`"
                            class="relative w-full h-[800px] rounded-xl overflow-hidden border-2 border-gray-700/50 bg-black">
                            <img :src="template.file_path" class="absolute inset-0 w-full h-full object-cover opacity-60"
                                alt="Template Background" />

                            <!-- Slot Grid -->
                            <div class="absolute inset-0 grid grid-cols-2 gap-4 p-4 h-max">
                                <template x-for="(slot, slotIndex) in templateSlots[templateIndex]" :key="slotIndex">
                                    <!-- 🆕 TAMBAHKAN data-template-index dan data-slot-index -->
                                    <div class="zoom-container group relative w-full aspect-square rounded-xl border-2 border-dashed flex items-center justify-center cursor-grab overflow-hidden bg-gray-900/30 transition"
                                        :class="slot ? 'border-blue-500' : 'border-gray-400/50'"
                                        :data-template-index="templateIndex" :data-slot-index="slotIndex">

                                        <template x-if="!slot">
                                            <span class="text-white text-xs bg-black/50 px-2 py-1 rounded"
                                                x-text="`Slot ${slotIndex + 1}`"></span>
                                        </template>

                                        <template x-if="slot">
                                            <div class="relative w-full h-full">
                                                <img :src="slot"
                                                    class="zoomable transition-transform duration-200" />

                                                <button
                                                    @click.stop="templateSlots[templateIndex][slotIndex] = null;
                                                                     delete imageTransforms[templateIndex]?.[slotIndex];
                                                                     $nextTick(() => initPanzoom());"
                                                    class="absolute top-1 right-1 bg-red-600/80 hover:bg-red-700 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-md"
                                                    title="Hapus Foto">✕
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

    <!-- Tutorial Bar -->
    <div x-show="showTutorialBar" x-transition
        class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 bg-gray-900/90 text-gray-100 border border-gray-700/60 backdrop-blur-md rounded-2xl shadow-2xl px-6 py-3 flex items-center gap-4 max-w-3xl w-[90%] text-sm">
        <div class="flex-1 leading-relaxed">
            💡 <strong>Panduan:</strong> Silakan pilih foto untuk setiap template mulai dari orang pertama.
            Untuk melihat foto lebih jelas, arahkan kursor ke foto lalu klik tombol <em>Preview Gambar</em>.
            Setelah semua terisi, klik <strong>"Selesai & Generate Hasil"</strong>.
        </div>
        <button @click="showTutorialBar = false" class="text-gray-400 hover:text-white transition text-lg leading-none">
            ✕
        </button>
    </div>

    <!-- Modal Preview -->
    <div x-show="previewPhoto" x-transition.opacity @click.self="previewPhoto = null"
        class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 h-11/12">
        <div class="relative h-full mx-4 py-5">
            <img :src="previewPhoto" class="h-full rounded-xl shadow-2xl border border-gray-700" />
            <button @click="previewPhoto = null"
                class="absolute top-2 -right-4 bg-red-600 hover:bg-red-700 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg">
                ✕
            </button>
        </div>
    </div>
    </div>
    <!-- Panzoom -->
<script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>

<!-- html2canvas -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

@endsection
