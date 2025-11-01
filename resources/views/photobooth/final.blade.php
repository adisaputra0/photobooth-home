@php
    use Illuminate\Support\Facades\File;

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

        * Scrollbar Styling */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }



    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(55, 65, 81, 0.3); /* abu gelap transparan */
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #3b82f6, #8b5cf6); /* biru ke ungu */
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #2563eb, #7c3aed);
    }

    /* Untuk Firefox */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #6366f1 rgba(55, 65, 81, 0.3);
    }

    img {
        will-change: transform;
    }
    </style>

    <div x-data="{
        showTutorialBar: true,
        previewPhoto: null,
        showAlert: false,
        audio: null,
        remainingTime: 0,
        closeAlertModal() {
            if(document.getElementById('password').value == 'admin123'){
                this.showAlert = false;
                if (this.audio) {
                    this.audio.pause();
                    this.audio.currentTime = 0;
                }
            }else{
                alert('Password salah. Silakan coba lagi.');
            }
        },
    }" class="bg-gradient-to-br from-gray-800 via-gray-900 to-black min-h-screen p-8 pb-32">
        <div x-data="{
            uploadedPhotos: {{ Js::from($photos) }},
            templates: {{ Js::from($templates) }},
            selectedTemplates: [],
            templateSlots: {},
            imageTransforms: {},
            {{-- remainingTime: 0, --}}
            timerInterval: null,
            activeTemplate: 0,

            init() {
                const storedTemplates = localStorage.getItem('selectedTemplates');
                const templateIds = storedTemplates ? JSON.parse(storedTemplates) : [];

                this.selectedTemplates = templateIds.map(id => this.templates[id]);
                this.selectedTemplates.forEach((template, index) => {
                    this.templateSlots[index] = Array(template.slots).fill(null);
                    this.imageTransforms[index] = {};
                });
                const savedMinutes = localStorage.getItem('sessionDuration');
                const durationInSeconds = savedMinutes ? parseInt(savedMinutes) * 60 : 60;
                {{-- const durationInSeconds = 3; --}}
                this.remainingTime = durationInSeconds;
                this.startCountdown();

                this.$nextTick(() => {
                    this.initPanzoom();
                });
            },

            startCountdown() {
                this.timerInterval = setInterval(() => {
                    if (this.remainingTime > 0) {
                        this.remainingTime--;
                    } else {
                        clearInterval(this.timerInterval);
                        this.showAlertModal();
                    }
                }, 1000);
            },

            showAlertModal() {
                this.showAlert = true;
                this.audio = new Audio(`{{ asset('assets/ringtone.mp3') }}`);
                this.audio.loop = true;
                this.audio.play().catch(err => console.error('Gagal memutar audio:', err));
            },

            formatTime(seconds) {
                const m = Math.floor(seconds / 60);
                const s = seconds % 60;
                return `${m}:${s.toString().padStart(2, '0')}`;
            },

            selectPhoto(templateIndex, slotIndex, photo) {
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

            // 🆕 HELPER METHOD: Menentukan class grid berdasarkan jumlah slot
            getGridClass(template) {
                const slots = template.slots;

                if (slots === 1) {
                    // Single slot: Besar di tengah dengan padding bawah untuk logo
                    return 'grid-cols-1 p-6 pb-24';
                } else if (slots === 4) {
                    // 4 slots: Grid 2x2 dengan gap sedang dan padding bawah
                    return 'grid-cols-2 gap-x-4 p-4 pb-[7rem]';
                } else if (slots === 6) {
                    // 6 slots: Grid 3x2 dengan gap kecil dan padding lebih banyak
                    {{-- return 'grid-cols-2 gap-y-0 gap-x-10 p-[3rem_2rem]'; --}}
                    return 'grid-cols-2 gap-x-5 gap-y-2 my-[80px] px-5 h-max';
                }

                // Default fallback
                return 'grid-cols-2 gap-4 p-4 pb-16';
            },

            // 🆕 HELPER METHOD: Menentukan aspect ratio slot berdasarkan jumlah
            getSlotAspectClass(template) {
                const slots = template.slots;

                if (slots === 1) {
                    // Single slot: Aspect ratio lebih tinggi (portrait penuh)
                    return 'aspect-[3/4.1]';
                } else if (slots === 4) {
                    // 4 slots: Aspect ratio square-ish untuk balanced layout
                    return 'aspect-[2/2.7]';
                } else if (slots === 6) {
                    // 6 slots: Aspect ratio lebih compact
                    return 'aspect-[1/0.9]';
                }

                return 'aspect-square';
            },


            handleFinish() {
                alert('Terima kasih! Hasil akhir Anda sedang diproses.');
            },

            initPanzoom() {
                const images = document.querySelectorAll('.zoomable');

                images.forEach((img) => {
                    const parent = img.closest('.zoom-container');
                    if (!parent) return;

                    const templateIndex = parseInt(parent.dataset.templateIndex);
                    const slotIndex = parseInt(parent.dataset.slotIndex);

                    if (parent.panzoomInstance) {
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

                        const savedTransform = this.imageTransforms[templateIndex]?.[slotIndex];

                        const startScale = savedTransform?.scale || fitScale;
                        const startX = savedTransform?.x ?? defaultX;
                        const startY = savedTransform?.y ?? defaultY;

                        const panzoom = Panzoom(img, {
                            maxScale: 5,
                            minScale: fitScale,
                            startScale: startScale,
                            startX: startX,
                            startY: startY,
                            contain: 'outside',
                            cursor: 'grab',
                            step: 0.1,
                        });

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

                        img.addEventListener('dblclick', () => {
                            panzoom.zoom(fitScale, { animate: true });
                            panzoom.pan(defaultX, defaultY, { animate: true });

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

                // 🔹 Sembunyikan scrollbar sementara
                const scrollEls = document.querySelectorAll('.custom-scrollbar');
                const originalScrollbarStyles = [];
                scrollEls.forEach(el => {
                    originalScrollbarStyles.push(el.style.scrollbarWidth);
                    el.style.scrollbarWidth = 'none';
                });

                const element = document.getElementById(`template-container-${index}`);
                if (!element) return alert('Template tidak ditemukan');

                html2canvas(element, {
                    scale: 2,
                    useCORS: true
                }).then(canvas => {
                    const image = canvas.toDataURL('image/png');

                    const printWindow = window.open('', '_blank');
                    const html = `<html><head><title>Print Template</title><style>@page{size:4in 6in;margin:0;}body{margin:0;display:flex;align-items:center;justify-content:center;background:black;height:100vh;}img{width:100%;height:auto;object-fit:contain;}</style></head><body><img src='${image}' alt='Template Print'/><script>window.onload=function(){window.print();setTimeout(()=>window.close(),1000);}<\/script></body></html>`;
                    printWindow.document.open();
                    printWindow.document.write(html);
                    printWindow.document.close();
                }).finally(() => {
                    // 🔹 Pulihkan style scrollbar setelah selesai
                    scrollEls.forEach((el, i) => {
                        el.style.scrollbarWidth = originalScrollbarStyles[i] || '';
                    });
                });
            },

            downloadTemplate(index) {
                // 🔹 Sembunyikan scrollbar sementara
                const scrollEls = document.querySelectorAll('.custom-scrollbar');
                const originalScrollbarStyles = [];
                scrollEls.forEach(el => {
                    originalScrollbarStyles.push(el.style.scrollbarWidth);
                    el.style.scrollbarWidth = 'none';
                });
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
                }).finally(() => {
                    // 🔹 Pulihkan style scrollbar setelah selesai
                    scrollEls.forEach((el, i) => {
                        el.style.scrollbarWidth = originalScrollbarStyles[i] || '';
                    });
                });
            },
        }"
            class="relative max-w-6xl mx-auto bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl">

            <!-- Countdown Timer -->
            <div class="absolute top-4 right-6 bg-gray-900/70 border border-gray-700/50 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-md">
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
                <div class="h-[100vh] overflow-auto custom-scrollbar">
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

                    <div class="grid grid-cols-3 gap-4">
                        <template x-for="(photo, index) in uploadedPhotos" :key="index">
                            <div class="relative group">
                                <img :src="photo"
                                    loading="lazy"
                                    @click="selectPhotoAuto(activeTemplate || 0, photo)"
                                    class="w-full aspect-[2/3] object-cover rounded-xl border border-gray-700 hover:border-blue-500 cursor-pointer transition-all duration-200" />


                                <button @click.stop="previewPhoto = photo"
                                    class="absolute top-2 right-2 bg-black/60 hover:bg-black/80 text-white text-xs px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-md">
                                    Preview Gambar
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Right: Template Slots -->
                <div class="h-[100vh] overflow-auto pb-[10rem] custom-scrollbar">
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
                class="relative w-full h-[800px] overflow-hidden border-2 border-gray-700/50 bg-black">
                <img :src="template.file_path"
                    class="absolute inset-0 w-full h-full object-cover opacity-100"
                    alt="Template Background" />

                <!-- Slot Grid -->
                <div class="absolute inset-0 grid h-full" :class="getGridClass(template)">
                    <template x-for="(slot, slotIndex) in templateSlots[templateIndex]" :key="slotIndex">
                        <div class="zoom-container group relative w-full border-2 border-dashed flex items-center justify-center cursor-grab overflow-hidden bg-gray-900/30 transition"
                            :class="[
                                slot ? 'border-blue-500' : 'border-gray-400/50',
                                getSlotAspectClass(template),
                                template.slots === 6 ? 'rounded-[1.5rem]' : 'rounded-none'
                            ]"
                            :data-template-index="templateIndex"
                            :data-slot-index="slotIndex">

                            <template x-if="!slot">
                                <span class="text-white text-xs bg-black/50 px-2 py-1 rounded"
                                    x-text="`Slot ${slotIndex + 1}`"></span>
                            </template>

                            <template x-if="slot">
                                <div class="relative w-full h-full">
                                    <img :src="slot" class="zoomable transition-transform duration-200" />

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
                Setelah semua terisi, klik <strong>"Print 4R"</strong> untuk print. Klik <strong>"Download HD"</strong> untuk simpan hasil digital. Klik <strong>Selesai</strong> untuk mengakhiri sesi.
            </div>
            <button @click="showTutorialBar = false" class="text-gray-400 hover:text-white transition text-lg leading-none">
                ✕
            </button>
        </div>

        <!-- Modal Preview -->
        <div x-show="previewPhoto" x-transition.opacity @click.self="previewPhoto = null"
            class="fixed inset-0 bg-black/80 flex items-center justify-center z-50">
            <div class="relative max-h-[90vh] mx-4">
                <img :src="previewPhoto" class="max-h-[90vh] rounded-xl shadow-2xl border border-gray-700" />
                <button @click="previewPhoto = null"
                    class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg">
                    ✕
                </button>
            </div>
        </div>
        <!-- Modal Alert -->
        <div
            x-show="showAlert"
            x-transition.opacity
            class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center relative">
                <h2 class="text-2xl font-semibold text-gray-800 mb-3">⏰ Waktu Habis!</h2>
                <p class="text-gray-600 mb-6">Waktu pengambilan foto telah berakhir. Masukkan password untuk klik oke</p>
                <input type="password" class="w-full mb-6" id="password">
                <button
                    @click="closeAlertModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition"
                >
                    Oke
                </button>
            </div>
        </div>

    </div>
            <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

@endsection
