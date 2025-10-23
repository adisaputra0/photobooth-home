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
                // Buat URL yang bisa diakses browser
                $photos[] = asset('uploads/photobooth/' . $file->getFilename());
            }
        }
    }

    // Ambil data templates (sesuaikan dengan sumber data template Anda)
    // Jika templates juga perlu diambil dari folder/file, sesuaikan di sini
    $templates = $templates ?? []; // Ganti dengan logic pengambilan template Anda
@endphp

@extends('layouts.photobooth')

@section('content')
    {{-- <style>
        /* Container untuk panzoom - harus relative dan hide overflow */
        .zoom-container {
            position: relative;
            overflow: hidden;
            cursor: grab;
        }

        .zoom-container:active {
            cursor: grabbing;
        }

        /* Gambar zoomable - PENTING: jangan gunakan object-fit! */
        .zoomable {
            display: block;
            max-width: none;
            max-height: none;
            transform-origin: center center;
            user-select: none;
            -webkit-user-drag: none;
        }

        /* Optional: smooth transition saat reset (double click) */
        .zoomable {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Disable transition saat user sedang drag (agar tidak lag) */
        .zoom-container:active .zoomable {
            transition: none;
        }
    </style> --}}
    <style>
        .zoom-container {
            border: none;
        }
    </style>
    <div x-data="{
    
        previewPhoto: null,
    }" class="bg-gradient-to-br from-gray-800 via-gray-900 to-black min-h-screen p-4 sm:p-8">
        <div x-data="{
            uploadedPhotos: {{ Js::from($photos) }},
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
        
                    // Cleanup instance sebelumnya
                    if (parent.panzoomInstance) {
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
        
                        // Hitung scale agar gambar fit ke container (CONTAIN, bukan COVER)
                        // Ini akan menampilkan seluruh gambar tanpa cropping
                        const fitScale = Math.min(containerW / naturalW, containerH / naturalH);
        
                        // Posisi center
                        const scaledW = naturalW * fitScale;
                        const scaledH = naturalH * fitScale;
                        const initialX = (containerW - scaledW) / 2;
                        const initialY = (containerH - scaledH) / 2;
        
                        const panzoom = Panzoom(img, {
                            maxScale: 5, // Zoom in maksimal
                            minScale: fitScale, // ✅ Gunakan fitScale (bukan coverScale)
                            startScale: fitScale, // ✅ Mulai dengan tampilan penuh
                            startX: initialX,
                            startY: initialY,
                            contain: 'outside',
                            cursor: 'grab',
                            step: 0.1,
                        });
        
                        const wheelHandler = (e) => {
                            e.preventDefault();
                            panzoom.zoomWithWheel(e);
                        };
                        parent.addEventListener('wheel', wheelHandler, { passive: false });
                        parent.wheelHandler = wheelHandler;
        
                        // Double click reset
                        img.addEventListener('dblclick', () => {
                            panzoom.zoom(fitScale, { animate: true });
                            panzoom.pan(initialX, initialY, { animate: true });
                        });
        
                        // Cursor feedback
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
        
                // Gunakan html2canvas untuk ambil tampilan asli
                html2canvas(element, {
                    scale: 2, // resolusi lebih tinggi biar tidak blur
                    useCORS: true
                }).then(canvas => {
                    const image = canvas.toDataURL('image/png');
        
                    const printWindow = window.open('', '_blank');
                    const html = `
                                                                                                                                                                                                                                                                                                                                                                                            <html>
                                                                                                                                                                                                                                                                                                                                                                                            <head>
                                                                                                                                                                                                                                                                                                                                                                                                <title>Print Template</title>
                                                                                                                                                                                                                                                                                                                                                                                                <style>
                                                                                                                                                                                                                                                                                                                                                                                                    @page {
                                                                                                                                                                                                                                                                                                                                                                                                        size: 4in 6in; /* Ukuran 4R */
                                                                                                                                                                                                                                                                                                                                                                                                        margin: 0;
                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                    body {
                                                                                                                                                                                                                                                                                                                                                                                                        margin: 0;
                                                                                                                                                                                                                                                                                                                                                                                                        display: flex;
                                                                                                                                                                                                                                                                                                                                                                                                        align-items: center;
                                                                                                                                                                                                                                                                                                                                                                                                        justify-content: center;
                                                                                                                                                                                                                                                                                                                                                                                                        background: black;
                                                                                                                                                                                                                                                                                                                                                                                                        height: 100vh;
                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                    img {
                                                                                                                                                                                                                                                                                                                                                                                                        width: 100%;
                                                                                                                                                                                                                                                                                                                                                                                                        height: auto;
                                                                                                                                                                                                                                                                                                                                                                                                        object-fit: contain;
                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                </style>
                                                                                                                                                                                                                                                                                                                                                                                            </head>
                                                                                                                                                                                                                                                                                                                                                                                            <body>
                                                                                                                                                                                                                                                                                                                                                                                                <img src='${image}' alt='Template Print' />
                                                                                                                                                                                                                                                                                                                                                                                                <script>
                                                                                                                                                                                                                                                                                                                                                                                                    window.onload = function() {
                                                                                                                                                                                                                                                                                                                                                                                                        window.print();
                                                                                                                                                                                                                                                                                                                                                                                                        setTimeout(() => window.close(), 1000);
                                                                                                                                                                                                                                                                                                                                                                                                    };
                                                                                                                                                                                                                                                                                                                                                                                                </script>
                                                                                                                                                                                                                                                                                                                                                                                            </body>
                                                                                                                                                                                                                                                                                                                                                                                            </html>
                                                                                                                                                                                                                                                                                                                                                                                        `;
        
                    printWindow.document.open();
                    printWindow.document.write(html);
                    printWindow.document.close();
                });
            },
            downloadTemplate(index) {
                const element = document.getElementById(`template-container-${index}`);
                if (!element) return alert('Template tidak ditemukan');
        
                html2canvas(element, {
                    scale: 2, // resolusi tinggi
                    useCORS: true,
                    backgroundColor: '#000', // agar tidak transparan
                }).then(canvas => {
                    // Konversi ke JPEG (bukan PNG)
                    const image = canvas.toDataURL('image/jpeg', 1.0); // kualitas maksimum (HD)
        
                    // Buat link download otomatis
                    const link = document.createElement('a');
                    link.href = image;
                    link.download = `template-${index + 1}.jpg`;
                    link.click();
                }).catch(err => {
                    console.error('Gagal mengunduh template:', err);
                    alert('Terjadi kesalahan saat mengunduh template.');
                });
            },
        
        }"
            class="relative max-w-6xl mx-auto bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl">

            <!-- Panzoom CDN -->
            <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>

            {{-- Canvas CDN --}}
            <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

            <!-- Countdown Timer -->
            <div
                class="absolute top-4 right-6 bg-gray-900/70 border border-gray-700/50 text-white px-4 py-2
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
                {{-- <div>
                    <h2 class="text-gray-200 mb-4 text-center">Foto Anda</h2>

                    <template x-if="selectedTemplates.length > 1">
                        <div class="flex gap-2 mb-4 justify-center flex-wrap">
                            <template x-for="(template, idx) in selectedTemplates" :key="idx">
                                <button @click="activeTemplate = idx"
                                    :class="activeTemplate === idx ? 'bg-blue-600' : 'bg-gray-700'"
                                    class="px-3 py-1 rounded-lg text-white text-xs" x-text="`Pengguna ${idx + 1}`">
                                </button>
                            </template>
                        </div>
                    </template>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <template x-for="(photo, index) in uploadedPhotos" :key="index">
                            <img :src="photo" @click="selectPhotoAuto(activeTemplate || 0, photo)"
                                class="w-full aspect-[9/16] object-cover rounded-xl border border-gray-700 hover:border-blue-500 cursor-pointer transition-all duration-200" />
                        </template>
                    </div>
                </div> --}}
                <div>

                    <h2 class="text-gray-200 mb-4 text-center">Foto Anda</h2>

                    <template x-if="selectedTemplates.length > 1">
                        <div class="flex gap-2 mb-4 justify-center flex-wrap">
                            <template x-for="(template, idx) in selectedTemplates" :key="idx">
                                <button @click="activeTemplate = idx"
                                    :class="activeTemplate === idx ? 'bg-blue-600' : 'bg-gray-700'"
                                    class="px-3 py-1 rounded-lg text-white text-xs" x-text="`Pengguna ${idx + 1}`">
                                </button>
                            </template>
                        </div>
                    </template>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <template x-for="(photo, index) in uploadedPhotos" :key="index">
                            <div class="relative group">
                                <!-- Foto -->
                                <img :src="photo" @click="selectPhotoAuto(activeTemplate || 0, photo)"
                                    class="w-full aspect-[9/16] object-cover rounded-xl border border-gray-700 hover:border-blue-500 cursor-pointer transition-all duration-200" />

                                <!-- Tombol Preview di kanan atas -->
                                <button @click.stop="previewPhoto = photo"
                                    class="absolute top-2 right-2 bg-black/60 hover:bg-black/80 text-white text-xs px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-md">
                                    👁️
                                </button>
                            </div>
                        </template>
                    </div>
                </div>


                <!-- Right: Template Slots -->
                <div>
                    <h2 class="text-gray-200 mb-4 text-center">Template Pilihan</h2>

                    <template x-for="(template, templateIndex) in selectedTemplates" :key="templateIndex">
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-gray-300 text-sm"
                                    x-text="`${template.name} (${template.slots} slots) - Pengguna ${templateIndex + 1}`">
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
                                <img :src="template.file_path"
                                    class="absolute inset-0 w-full h-full object-cover opacity-60"
                                    alt="Template Background" />

                                <!-- Slot Grid -->
                                <div class="absolute inset-0 grid grid-cols-2 gap-4 p-4 h-max">
                                    <template x-for="(slot, slotIndex) in templateSlots[templateIndex]"
                                        :key="slotIndex">
                                        <div class="zoom-container group relative w-full aspect-square rounded-xl border-2 border-dashed flex items-center justify-center cursor-grab overflow-hidden bg-gray-900/30 transition"
                                            :class="slot ? 'border-blue-500' : 'border-gray-400/50'">

                                            <template x-if="!slot">
                                                <span class="text-white text-xs bg-black/50 px-2 py-1 rounded"
                                                    x-text="`Slot ${slotIndex + 1}`"></span>
                                            </template>

                                            <template x-if="slot">
                                                <div class="relative w-full h-full">
                                                    <img :src="slot"
                                                        class="zoomable transition-transform duration-200" />

                                                    <button
                                                        @click.stop="templateSlots[templateIndex][slotIndex] = null; $nextTick(() => initPanzoom());"
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
@endsection
