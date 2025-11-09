@extends('layouts.photobooth')

@section('content')
    <style>
        .zoom-container {
            border: none;
        }

        img {
            will-change: transform;
        }

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

        /* .animate-swing {
            animation: swing 3s ease-in-out infinite;
            transform-origin: top center;
        } */
    </style>

    <div class="min-h-screen bg-gradient-to-br from-gray-800 via-gray-900 to-black p-4 sm:p-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl"
                x-data="gantunganKunci()">

                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-white text-2xl font-semibold mb-2">Pilih Gantungan Kunci</h1>
                    <p class="text-gray-400 text-sm">Tentukan bentuk gantungan dan pilih foto hasil sesi Anda</p>
                </div>

                <!-- Grid Utama -->
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Kiri -->
                    <div class="space-y-6 h-[100vh] overflow-y-auto">
                        <!-- Input Jumlah -->
                        <div class="space-y-2">
                            <label class="text-gray-300">Jumlah Gantungan Kunci</label>
                            <input type="number" min="1" x-model.number="jumlah" @input="aturJumlah"
                                class="w-full bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 rounded-xl px-4 py-3 text-white placeholder:text-gray-500 focus:outline-none focus:border-gray-500 transition-all duration-300" />
                        </div>

                        <!-- Pilihan Bentuk -->
                        <div class="space-y-2">
                            <label class="text-gray-300">Pilih Bentuk untuk Gantungan ke-<span x-text="gantunganAktif + 1"></span></label>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <button type="button" @click="ubahBentukGantungan('love')"
                                    :class="gantunganKunciList[gantunganAktif]?.bentuk === 'love' ? 'border-pink-500 bg-pink-500/20' : 'border-gray-600/50'"
                                    class="border rounded-xl p-4 text-white flex flex-col items-center gap-2 hover:border-pink-400 transition-all duration-300">
                                    <i class="fa-solid fa-heart text-pink-400 text-2xl"></i>
                                    <span>Love</span>
                                </button>

                                <button type="button" @click="ubahBentukGantungan('kotak')"
                                    :class="gantunganKunciList[gantunganAktif]?.bentuk === 'kotak' ? 'border-blue-500 bg-blue-500/20' : 'border-gray-600/50'"
                                    class="border rounded-xl p-4 text-white flex flex-col items-center gap-2 hover:border-blue-400 transition-all duration-300">
                                    <i class="fa-regular fa-square text-blue-400 text-2xl"></i>
                                    <span>Kotak</span>
                                </button>
                            </div>
                        </div>
                        <!-- Pilihan Foto -->
                        <div class="space-y-2">
                            <label class="text-gray-300">Pilih Foto untuk Gantungan Aktif</label>
                            <p class="text-sm text-gray-400 mb-2">Klik salah satu foto di bawah</p>
                            <div class="grid grid-cols-3 gap-3">
                                <template x-for="(foto, index) in fotoList" :key="index">
                                    <div class="relative group">
                                        <img :src="foto" @click="pilihFotoUntukGantungan(foto)"
                                            class="aspect-[3/4] object-cover rounded-xl border-2 cursor-pointer transition-all duration-300"
                                            :class="gantunganKunciList[gantunganAktif]?.foto === foto ?
                                                'border-blue-500 ring-2 ring-blue-400/60' :
                                                'border-gray-600/50 hover:border-gray-400'" />
                                        <div x-show="gantunganKunciList[gantunganAktif]?.foto === foto"
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
                                    x-text="(jumlah * 15000).toLocaleString('id-ID')"></span></p>
                            <p class="text-xs text-gray-500 mt-1">(Rp 15.000 / pcs)</p>
                        </div>
                    </div>

                    <!-- Kanan (Preview Gantungan Banyak) -->
                    <div class="h-[100vh] overflow-y-auto overflow-x-hidden ps-3">
                        <div class="grid grid-cols-2 h-fit gap-x-6 gap-y-12 relative mt-10">
                            <template x-for="(gantungan, index) in gantunganKunciList" :key="index">
                                <div class="relative w-60 h-60 cursor-pointer" @click="gantunganAktif = index"
                                    :class="gantunganAktif === index ? 'scale-105' : 'opacity-70 hover:opacity-100 transition'">
                                    
                                    <!-- Badge Nomor -->
                                    <div class="absolute -top-2 left-0 z-20 bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold border-2 border-white shadow-lg">
                                        <span x-text="index + 1"></span>
                                    </div>
                                    
                                    <!-- Bentuk Love -->
                                    <template x-if="gantungan.bentuk === 'love'">
                                        <div class="relative w-full h-full flex justify-center items-center animate-swing">
                                            <!-- Kotak Utama -->
                                            <div class="relative w-full h-full bg-gray-900/20 border-4 border-pink-400/50 rounded-2xl overflow-hidden shadow-2xl">
                                                
                                                <!-- Area Foto dengan Zoom -->
                                                <div class="zoom-container w-full h-full relative overflow-hidden cursor-grab"
                                                    :data-index="index">
                                                    <img :src="gantungan.foto" alt="Preview"
                                                        class="zoomable absolute inset-0 w-full h-full object-cover transition-all duration-500" />
                                                </div>

                                                <!-- Garis Tipis Bentuk Love -->
                                                <svg class="absolute inset-0 pointer-events-none z-10" viewBox="0 0 200 200"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g transform="translate(35, 35) scale(1.6)">
                                                        <path
                                                            d="M40.5121 74.3397L34.6378 69.0731C27.8183 62.9288 22.1804 57.6284 17.724 53.1721C13.2677 48.7158 9.7229 44.7152 7.08961 41.1704C4.45633 37.6256 2.61641 34.3678 1.56984 31.3969C0.523281 28.426 0 25.3876 0 22.2816C0 15.9348 2.12688 10.6344 6.38065 6.38065C10.6344 2.12688 15.9348 0 22.2816 0C25.7927 0 29.1349 0.742722 32.3084 2.22816C35.4818 3.71361 38.2164 5.80673 40.5121 8.50754C42.8078 5.80673 45.5423 3.71361 48.7158 2.22816C51.8892 0.742722 55.2315 0 58.7425 0C65.0894 0 70.3898 2.12688 74.6435 6.38065C78.8973 10.6344 81.0242 15.9348 81.0242 22.2816C81.0242 25.3876 80.5009 28.426 79.4543 31.3969C78.4078 34.3678 76.5678 37.6256 73.9346 41.1704C71.3013 44.7152 67.7565 48.7158 63.3001 53.1721C58.8438 57.6284 53.2059 62.9288 46.3863 69.0731L40.5121 74.3397Z"
                                                            stroke="white" stroke-width="1.5" fill="none" opacity="0.8"
                                                            stroke-dasharray="4 3" />
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Bentuk Kotak -->
                                    <template x-if="gantungan.bentuk === 'kotak'">
                                        <div class="flex items-center justify-center space-y-2 animate-swing">
                                            <!-- Wrapper dengan scaling ringan -->
                                            <div class="transform scale-[1.25] origin-center">
                                                <!-- Kotak Gantungan -->
                                                <div class="relative border border-gray-400 bg-white rounded-md shadow-lg overflow-hidden flex flex-col"
                                                    style="width: 2.68cm; height: 4.33cm;">
                                                    
                                                    <!-- Area Foto dengan Zoom -->
                                                    <div class="flex-1 bg-gray-200 relative zoom-container overflow-hidden cursor-grab"
                                                        :data-index="index">
                                                        <img :src="gantungan.foto" alt="Preview"
                                                            class="zoomable absolute inset-0 w-full h-full object-cover transition-all duration-500" />
                                                    </div>

                                                    <!-- Area Tulisan (Tidak Kena Zoom) -->
                                                    <div
                                                        class="bg-white text-black text-xs font-bold text-center py-[3px] tracking-wider border-t border-gray-300 relative z-10">
                                                        IGNOS STUDIO
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Gantungan -->
                                    <div
                                        class="absolute -top-3 left-1/2 -translate-x-1/2 w-6 h-6 bg-gray-400 rounded-full border-4 border-gray-700">
                                    </div>
                                    <div class="absolute -top-7 left-1/2 -translate-x-1/2 w-1 h-6 bg-gray-500 rounded-full">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end mt-8 space-x-4">
                    <button type="button"
                        class="bg-green-600 border border-green-700/50 rounded-xl px-6 py-3 text-white hover:bg-green-700 transition-all duration-300 shadow-lg"
                        @click="cetakGantungan()">
                        🖨️ Cetak Halaman 4R
                    </button>

                    <button type="button"
                        class="bg-blue-600 border border-blue-700/50 rounded-xl px-6 py-3 text-white hover:bg-blue-700 transition-all duration-300 shadow-lg">
                        Lanjut ke Pembayaran →
                    </button>
                </div>
            </div>
        </div>
    </div>

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

        $templates = \App\Models\IDCardTemplate::all()->map(fn($template) => [
            'id' => $template->id,
            'name' => $template->name,
            'image' => asset($template->file_path),
        ]);
    @endphp

    <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>

    <script>
    function gantunganKunci() {
        return {
            jumlah: 1,
            fotoList: @json(array_merge($photos)),
            gantunganKunciList: [],
            gantunganAktif: 0,
            imageTransforms: {},

            init() {
                this.aturJumlah();
                this.$nextTick(() => {
                    this.initPanzoom();
                });
            },

            aturJumlah() {
                if (this.jumlah > this.gantunganKunciList.length) {
                    for (let i = this.gantunganKunciList.length; i < this.jumlah; i++) {
                        this.gantunganKunciList.push({
                            foto: this.fotoList[0],
                            bentuk: 'kotak'
                        });
                    }
                } else if (this.jumlah < this.gantunganKunciList.length) {
                    this.gantunganKunciList.splice(this.jumlah);
                    if (this.gantunganAktif >= this.jumlah) this.gantunganAktif = 0;
                }
                
                this.$nextTick(() => {
                    this.initPanzoom();
                });
            },

            ubahBentukGantungan(bentuk) {
                this.gantunganKunciList[this.gantunganAktif].bentuk = bentuk;
                this.$nextTick(() => {
                    this.initPanzoom();
                });
            },

            pilihFotoUntukGantungan(foto) {
                const previousFoto = this.gantunganKunciList[this.gantunganAktif].foto;
                
                if (previousFoto !== foto) {
                    delete this.imageTransforms[this.gantunganAktif];
                }
                
                this.gantunganKunciList[this.gantunganAktif].foto = foto;
                
                this.$nextTick(() => {
                    this.initPanzoom();
                });
            },

            initPanzoom() {
                const images = document.querySelectorAll('.zoomable');

                images.forEach((img) => {
                    const parent = img.closest('.zoom-container');
                    if (!parent) return;

                    const index = parseInt(parent.dataset.index);

                    if (parent.panzoomInstance) {
                        const currentTransform = parent.panzoomInstance.getScale();
                        const currentPan = parent.panzoomInstance.getPan();

                        this.imageTransforms[index] = {
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

                        const savedTransform = this.imageTransforms[index];

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
                            this.imageTransforms[index] = {
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

                            delete this.imageTransforms[index];
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

            cetakGantungan() {
                const gantunganKotak = this.gantunganKunciList.filter(g => g.bentuk === 'kotak');
                
                if (gantunganKotak.length === 0) {
                    alert('Tidak ada gantungan kunci dengan bentuk kotak untuk dicetak');
                    return;
                }

                const printWindow = window.open('', '_blank');
                
                let gantunganHTML = '';
                gantunganKotak.forEach((gantungan, index) => {
                    const originalIndex = this.gantunganKunciList.indexOf(gantungan);
                    const container = document.querySelector(`.zoom-container[data-index="${originalIndex}"]`);
                    const img = container?.querySelector('.zoomable');
                    
                    let transform = '';
                    if (img && this.imageTransforms[originalIndex]) {
                        const t = this.imageTransforms[originalIndex];
                        transform = `transform: scale(${t.scale}) translate(${t.x / t.scale}px, ${t.y / t.scale}px); transform-origin: 0 0;`;
                    }
                    
                    gantunganHTML += `
                        <div class="border border-gray-400 bg-white" style="width: 2.68cm; height: 4.33cm; overflow: hidden; display: flex; flex-direction: column;">
                            <div style="flex: 1; background-color: #e5e7eb; position: relative; overflow: hidden;">
                                <img src="${gantungan.foto}" 
                                    style="width: 100%; height: 100%; object-fit: cover; ${transform}" 
                                    alt="Foto ${index + 1}" />
                            </div>
                            <div style="background-color: white; color: black; font-size: 8px; font-weight: bold; text-align: center; padding: 2px 0; letter-spacing: 0.05em; border-top: 1px solid #d1d5db;">
                                IGNOS STUDIO
                            </div>
                        </div>
                    `;
                });

                const printHTML = `
                    <!doctype html>
                    <html>
                    <head>
                        <meta charset="UTF-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <title>Cetak Gantungan Kunci</title>
                        <style>
                            * {
                                margin: 0;
                                padding: 0;
                                box-sizing: border-box;
                            }
                            
                            @page {
                                size: 10.2cm 15.2cm;
                                margin: 0;
                            }
                            
                            body {
                                margin: 0;
                                padding: 0;
                            }
                            
                            .print-container {
                                width: 10.2cm;
                                height: 15.2cm;
                                display: flex;
                                flex-wrap: wrap;
                                gap: 0;
                                padding: 0;
                                margin: 0;
                                page-break-after: always;
                            }
                            
                            @media print {
                                body {
                                    margin: 0;
                                    padding: 0;
                                }
                                
                                .print-container {
                                    page-break-after: always;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="print-container">
                            ${gantunganHTML}
                        </div>
                        <script>
                            window.onload = function() {
                                window.print();
                            };
                        <\/script>
                    </body>
                    </html>
                `;
                
                printWindow.document.write(printHTML);
                printWindow.document.close();
            }
        }
    }
</script>
@endsection