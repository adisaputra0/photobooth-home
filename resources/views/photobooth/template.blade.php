@extends('layouts.photobooth')

@section('content')
    <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-black min-h-screen p-4 sm:p-8">
        <div x-data="templateSelector"
            class="max-w-5xl mx-auto bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <p class="text-sm text-gray-400 mb-1">Langkah 2 dari 3</p>
                <h1 class="text-white text-2xl font-semibold mb-2">
                    Pilih Template Foto
                </h1>
                <p class="text-gray-400 text-sm">
                    Pilih template untuk setiap orang sesuai hasil sesi Anda
                </p>
            </div>

            <!-- Template Grid -->
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
                <template x-for="t in templates" :key="t.id">
                    <div class="relative group cursor-pointer rounded-2xl overflow-hidden border-2 transition-all duration-300"
                        :class="selectedTemplate?.id === t.id ? 'border-blue-500' : 'border-gray-700/50'"
                        @click="selectTemplate(t)">
                        <img :src="t.image" :alt="t.name" class="w-full aspect-[4/6] object-cover" />
                        <div
                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                            <span class="text-white font-medium" x-text="t.name"></span>
                        </div>
                        <div class="absolute top-3 right-3 w-6 h-6 flex items-center justify-center rounded-full border"
                            :class="selectedTemplate?.id === t.id ? 'bg-blue-600 border-blue-400' :
                                'bg-gray-700/70 border-gray-500'">
                            <i class="fa-solid fa-check text-xs text-white" x-show="selectedTemplate?.id === t.id"></i>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Preview Per User -->
            <div class="bg-gray-900/40 border border-gray-700/50 rounded-2xl p-5 mb-8">
                <h2 class="text-white text-lg font-semibold mb-4">
                    Preview Pilihan Setiap Orang
                </h2>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <template x-for="(u, index) in users" :key="index">
                        <div
                            class="relative rounded-xl border border-gray-700/50 bg-gray-800/40 p-3 flex flex-col items-center text-center group">
                            <!-- Hapus -->
                            <button x-show="u.template" @click="removeTemplate(index)"
                                class="absolute top-2 right-2 bg-red-600/80 hover:bg-red-700 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center">
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                            <div class="w-16 h-16 rounded-full bg-blue-500/20 flex items-center justify-center mb-2">
                                <i class="fa-solid fa-user text-blue-400 text-xl"></i>
                            </div>

                            <p class="text-white font-medium mb-1" x-text="`Orang ${index + 1}`"></p>

                            <template x-if="u.template">
                                <div>
                                    <img :src="u.template.image" class="w-full h-28 object-cover rounded-lg mb-2" />
                                    <p class="text-gray-300 text-sm" x-text="u.template.name"></p>
                                </div>
                            </template>

                            <template x-if="!u.template">
                                <p class="text-gray-500 text-sm">Belum memilih template</p>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-between items-center mt-6">
                <p class="text-gray-400 text-sm">
                    <span x-text="currentUserText"></span>
                </p>
                <button @click="handleNext"
                    class="bg-blue-600 border border-blue-700/50 rounded-xl px-6 py-3 text-white hover:bg-blue-700 transition-all duration-300 shadow-lg">
                    Lanjut ke Penyusunan Hasil →
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("templateSelector", () => ({
                templates: {{ Js::from(
                    $templates->map(
                        fn($template) => [
                            'id' => $template->id,
                            'name' => $template->name,
                            'image' => match ($template->id) {
                                1 => asset('templates/tm-slot-1.png'),
                                2 => asset('templates/tm-slot-4.png'),
                                3 => asset('templates/tm-slot-6.png'),
                                4 => asset('templates/tm-slot-8.png'),
                                default => asset($template->file_path),
                            },
                        ],
                    ),
                ) }},

                // Jumlah user (contoh ambil dari localStorage atau default 3)
                numPeople: localStorage.getItem("numPeople") ? (localStorage.getItem("bonusAccepted") ==
                    'true' ?
                    Number(
                        localStorage.getItem("numPeople")) * 2 : Number(localStorage.getItem(
                        "numPeople"))) : 2,
                users: [],
                currentUser: 0,
                selectedTemplate: null,

                get currentUserText() {
                    return this.currentUser < this.numPeople ?
                        `Sedang memilih template untuk User ${this.currentUser + 1}` :
                        "Semua user sudah memilih template ✅";
                },

                init() {
                    // Buat array user kosong
                    this.users = Array.from({
                        length: this.numPeople
                    }, () => ({
                        template: null,
                    }));
                },

                selectTemplate(template) {
                    if (this.currentUser >= this.numPeople) return;
                    this.selectedTemplate = template;
                    this.users[this.currentUser].template = template;
                    this.currentUser++;

                    if (this.currentUser < this.numPeople) {
                        this.selectedTemplate = null;
                    }
                },

                removeTemplate(index) {
                    this.users[index].template = null;
                    if (index < this.currentUser) {
                        this.currentUser = index;
                    }
                    this.selectedTemplate = null;
                },

                handleNext() {
                    if (this.users.some((u) => !u.template))
                        return alert(
                            "Semua user harus memilih template terlebih dahulu!"
                        );
                    // localStorage.setItem(
                    //   "selectedTemplates",
                    //   JSON.stringify(this.users)
                    // );

                    // Simpan hanya ID template yang dipilih
                    const templateIds = this.users.map(user => user.template.id);
                    console.log("Template IDs:", templateIds);
                    localStorage.setItem("selectedTemplates", JSON.stringify(templateIds));
                    window.location.href = "{{ route('photobooth.final') }}";
                },
            }));
        });
    </script>
@endsection
