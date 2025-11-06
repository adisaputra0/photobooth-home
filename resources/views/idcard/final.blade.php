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

    // Ambil data templates dari database
    $templates = \App\Models\IDCardTemplate::all()->map(fn($template) => [
        'id' => $template->id,
        'name' => $template->name,
        'image' => asset($template->file_path),
    ]);
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

        /* Scrollbar Styling */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(55, 65, 81, 0.3);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #2563eb, #7c3aed);
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #6366f1 rgba(55, 65, 81, 0.3);
        }

        img {
            will-change: transform;
        }

        /* ID Card size: 86x54mm = 3.39x2.13 inch = 323x203px at 96dpi */
        /* Preview size: 1.5x larger for better visibility */
        .idcard-container {
            width: 484px;
            height: 304px;
        }

        /* 4R paper size: 10x15cm = 3.94x5.91 inch = 378x567px at 96dpi */
        .paper-4r {
            width: 378px;
            height: 567px;
        }

        @media print {
            @page {
                size: 4in 6in;
                margin: 0;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            
            /* Reset to actual size for printing */
            .idcard-container {
                width: 323px !important;
                height: 203px !important;
            }
        }

        /* Label styling */
        .input-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }
    </style>

    <div x-data="{
        uploadedPhotos: {{ Js::from($photos) }},
        templates: {{ Js::from($templates) }},
        numberOfPeople: 0,
        idCards: [],
        activeCard: 0,
        previewPhoto: null,
        imageTransforms: {},
        showTutorialBar: true,

        init() {
            // Ambil data dari localStorage
            const numPeople = localStorage.getItem('numPeople');
            const bonusAccepted = localStorage.getItem('bonusAccepted') === 'true';
            const selectedTemplateIds = JSON.parse(localStorage.getItem('selectedTemplates') || '[]');
            
            // Hitung jumlah orang (dengan bonus jika ada)
            this.numberOfPeople = numPeople ? (bonusAccepted ? Number(numPeople) * 2 : Number(numPeople)) : 1;
            
            // Validasi jumlah template yang dipilih
            if (selectedTemplateIds.length !== this.numberOfPeople) {
                alert('Data template tidak sesuai! Silakan pilih ulang template.');
                window.location.href = '{{ route('idcard.template') }}';
                return;
            }

            // Initialize ID Cards dengan template yang sudah dipilih
            for (let i = 0; i < this.numberOfPeople; i++) {
                const templateId = selectedTemplateIds[i];
                const template = this.templates.find(t => t.id === templateId);
                
                this.idCards.push({
                    photo: null,
                    template: template || null,
                    idNumber: '',
                    name: '',
                    dateOfBirth: '',
                    class: ''
                });
                this.imageTransforms[i] = {};
            }
            
            this.$nextTick(() => {
                this.initPanzoom();
            });
        },

        selectPhoto(cardIndex, photo) {
            const previousPhoto = this.idCards[cardIndex].photo;
            if (previousPhoto !== photo) {
                delete this.imageTransforms[cardIndex];
            }

            this.idCards[cardIndex].photo = photo;
            this.$nextTick(() => this.initPanzoom());
        },

        initPanzoom() {
            const images = document.querySelectorAll('.zoomable');

            images.forEach((img) => {
                const parent = img.closest('.zoom-container');
                if (!parent) return;

                const cardIndex = parseInt(parent.dataset.cardIndex);

                if (parent.panzoomInstance) {
                    const currentTransform = parent.panzoomInstance.getScale();
                    const currentPan = parent.panzoomInstance.getPan();

                    this.imageTransforms[cardIndex] = {
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

                    const fitScale = Math.max(containerW / naturalW, containerH / naturalH);

                    const scaledW = naturalW * fitScale;
                    const scaledH = naturalH * fitScale;
                    const defaultX = (containerW - scaledW) / 2;
                    const defaultY = (containerH - scaledH) / 2;

                    const savedTransform = this.imageTransforms[cardIndex];

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
                        this.imageTransforms[cardIndex] = {
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
                        delete this.imageTransforms[cardIndex];
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

        printSingleCard(cardIndex) {
            const cardElement = document.querySelector(`#idcard-${cardIndex}`);
            if (!cardElement) return alert('Card tidak ditemukan');

            // Scale factor untuk menyesuaikan dari preview ke ukuran print sebenarnya
            const scaleFactor = 323 / 484; // actual size / preview size

            html2canvas(cardElement, {
                scale: 3 * scaleFactor, // Adjust scale untuk ukuran yang tepat
                useCORS: true,
                backgroundColor: '#fff',
                width: 484,
                height: 304
            }).then(canvas => {
                // Resize canvas ke ukuran print sebenarnya
                const printCanvas = document.createElement('canvas');
                printCanvas.width = 323;
                printCanvas.height = 203;
                const ctx = printCanvas.getContext('2d');
                ctx.drawImage(canvas, 0, 0, 323, 203);
                
                const image = printCanvas.toDataURL('image/png');

                const printWindow = window.open('', '_blank');
                const html = `<html><head><title>Print ID Card</title><style>@page{size:4in 6in;margin:0;}body{margin:0;display:flex;align-items:center;justify-content:center;background:white;height:100vh;}img{width:323px;height:203px;object-fit:contain;}</style></head><body><img src='${image}' alt='ID Card Print'/><script>window.onload=function(){window.print();setTimeout(()=>window.close(),1000);}<\/script></body></html>`;
                printWindow.document.open();
                printWindow.document.write(html);
                printWindow.document.close();
            });
        },

        downloadSingleCard(cardIndex) {
            const cardElement = document.querySelector(`#idcard-${cardIndex}`);
            if (!cardElement) return alert('Card tidak ditemukan');

            html2canvas(cardElement, {
                scale: 3,
                useCORS: true,
                backgroundColor: '#fff'
            }).then(canvas => {
                const imageData = canvas.toDataURL('image/jpeg', 1.0);

                fetch('/save-idcard', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector(`meta[name='csrf-token']`).content,
                    },
                    body: JSON.stringify({
                        image: imageData,
                        filename: `idcard-${cardIndex + 1}-${Date.now()}.jpg`
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('ID Card berhasil disimpan di server!');
                    } else {
                        alert('Gagal menyimpan ID Card di server.');
                    }
                })
                .catch(err => {
                    console.error('Gagal mengirim ke server:', err);
                    alert('Terjadi kesalahan saat mengirim gambar ke server.');
                });
            });
        }
    }"
    class="bg-gradient-to-br from-gray-800 via-gray-900 to-black min-h-screen p-8">
        <div class="relative max-w-7xl mx-auto">

            <!-- Header -->
            <div class="text-center mb-8">
                <p class="text-sm text-gray-400 mb-1">Editor ID Card</p>
                <h1 class="text-white text-2xl font-semibold mb-2">Buat ID Card Anda</h1>
                <p class="text-gray-400 text-sm">Pilih foto dan isi data untuk setiap ID Card</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Left: Photo Selection -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-6 shadow-2xl sticky top-8">
                        <h2 class="text-gray-200 mb-4 text-center font-semibold">Pilih Foto</h2>

                        <template x-if="numberOfPeople > 1">
                            <div class="flex gap-2 mb-4 justify-center flex-wrap">
                                <template x-for="(card, idx) in idCards" :key="idx">
                                    <button @click="activeCard = idx"
                                        :class="activeCard === idx ? 'bg-blue-600' : 'bg-gray-700'"
                                        class="px-3 py-1 rounded-lg text-white text-xs transition-all duration-200" 
                                        x-text="`Orang ${idx + 1}`">
                                    </button>
                                </template>
                            </div>
                        </template>

                        <div class="grid grid-cols-2 gap-3 max-h-[60vh] overflow-auto custom-scrollbar">
                            <template x-for="(photo, index) in uploadedPhotos" :key="index">
                                <div class="relative group">
                                    <img :src="photo"
                                        loading="lazy"
                                        @click="selectPhoto(activeCard, photo)"
                                        class="w-full aspect-[2/3] object-cover rounded-lg border-2 border-gray-700 hover:border-blue-500 cursor-pointer transition-all duration-200" />

                                    <button @click.stop="previewPhoto = photo"
                                        class="absolute top-2 right-2 bg-black/60 hover:bg-black/80 text-white text-xs px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-md">
                                        👁️ Preview
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Right: ID Cards Grid - CHANGED TO 1 COLUMN -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 gap-6">
                        <template x-for="(card, cardIndex) in idCards" :key="cardIndex">
                            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-6 shadow-2xl">
                                <!-- Card Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-white text-lg font-semibold" x-text="`Orang ${cardIndex + 1}`"></h3>
                                    <div class="flex gap-2">
                                        <button @click="printSingleCard(cardIndex)"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-lg transition-all duration-200 flex items-center gap-1">
                                            🖨️ Print 4R
                                        </button>
                                        <button @click="downloadSingleCard(cardIndex)"
                                            class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-lg transition-all duration-200 flex items-center gap-1">
                                            💾 Download HD
                                        </button>
                                    </div>
                                </div>

                                <!-- ID Card Container - NOW BIGGER -->
                                <div :id="`idcard-${cardIndex}`" 
                                    class="idcard-container mx-auto relative rounded-xl shadow-2xl overflow-hidden" 
                                    :style="card.template ? `background-image: url('${card.template.image}'); background-size: cover; background-position: center;` : 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);'">
                                    
                                    <!-- Overlay for better text visibility -->
                                    <div class="absolute inset-0 bg-black/20"></div>
                                    
                                    <div class="relative z-10 h-full p-6 flex items-center gap-4">
                                        <!-- Foto Section -->
                                        <div class="flex-shrink-0">
                                            <div class="zoom-container group relative w-36 h-52 border-2 border-dashed rounded-lg flex items-center justify-center cursor-grab overflow-hidden bg-white/10 backdrop-blur-sm transition"
                                                :class="card.photo ? 'border-white' : 'border-white/40'"
                                                :data-card-index="cardIndex">

                                                <template x-if="!card.photo">
                                                    <div class="text-center p-2">
                                                        <span class="text-white/60 text-xs leading-tight block">Klik foto di sebelah kiri</span>
                                                    </div>
                                                </template>

                                                <template x-if="card.photo">
                                                    <div class="relative w-full h-full">
                                                        <img :src="card.photo" class="zoomable w-full h-full object-cover rounded" />

                                                        <button
                                                            @click.stop="idCards[cardIndex].photo = null; delete imageTransforms[cardIndex]; $nextTick(() => initPanzoom());"
                                                            class="absolute top-1 right-1 bg-red-600/80 hover:bg-red-700 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-md"
                                                            title="Hapus Foto">✕
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <!-- Data Section with Labels -->
                                        <div class="w-full">
                                            <div class="mb-2">
                                                <label class="input-label">ID Number</label>
                                                <input type="text" 
                                                    x-model="idCards[cardIndex].idNumber"
                                                    class="w-full bg-white/10 backdrop-blur-sm border border-white/30 p-0 text-sm text-white placeholder-white/50 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/20 transition">
                                            </div>

                                            <div class="mb-2">
                                                <label class="input-label">Nama Lengkap</label>
                                                <input type="text" 
                                                    x-model="idCards[cardIndex].name"
                                                    class="w-full bg-white/10 backdrop-blur-sm border border-white/30 p-0 text-sm text-white placeholder-white/50 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/20 transition">
                                            </div>

                                            <div class="mb-2">
                                                <label class="input-label">Tanggal Lahir</label>
                                                <input type="text" 
                                                    x-model="idCards[cardIndex].dateOfBirth"
                                                    class="w-full bg-white/10 backdrop-blur-sm border border-white/30 p-0 text-sm text-white placeholder-white/50 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/20 transition">
                                            </div>

                                            <div>
                                                <label class="input-label">Kelas</label>
                                                <input type="text" 
                                                    x-model="idCards[cardIndex].class"
                                                    class="w-full bg-white/10 backdrop-blur-sm border border-white/30 p-0 text-sm text-white placeholder-white/50 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/20 transition">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Template Info -->
                                <template x-if="card.template">
                                    <div class="mt-4 flex items-center justify-center gap-2 bg-purple-600/20 border border-purple-500/30 rounded-lg px-4 py-2">
                                        <span class="text-purple-300 text-sm font-medium">Template:</span>
                                        <span class="text-white text-sm font-semibold" x-text="card.template.name"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tutorial Bar -->
        <div x-show="showTutorialBar" x-transition
            class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 bg-gray-900/90 text-gray-100 border border-gray-700/60 backdrop-blur-md rounded-2xl shadow-2xl px-6 py-3 flex items-center gap-4 max-w-3xl w-[90%] text-sm no-print">
            <div class="flex-1 leading-relaxed">
                💡 <strong>Panduan:</strong> Pilih foto dari panel kiri, kemudian isi data langsung di dalam ID Card. 
                Klik <strong>"Print 4R"</strong> atau <strong>"Download HD"</strong> pada masing-masing kartu untuk mencetak/menyimpan.
            </div>
            <button @click="showTutorialBar = false" class="text-gray-400 hover:text-white transition text-lg leading-none">
                ✕
            </button>
        </div>

        <!-- Modal Preview -->
        <div x-show="previewPhoto" x-transition.opacity @click.self="previewPhoto = null"
            class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 no-print">
            <div class="relative max-h-[90vh] mx-4">
                <img :src="previewPhoto" class="max-h-[90vh] rounded-xl shadow-2xl border border-gray-700" />
                <button @click="previewPhoto = null"
                    class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg">
                    ✕
                </button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
@endsection