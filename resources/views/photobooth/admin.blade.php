@extends('layouts.photobooth')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-800 via-gray-900 to-black p-4 sm:p-8">
        <div class="max-w-7xl mx-auto">

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('indexAdmin') }}"
                    class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="text-sm font-medium">Kembali ke admin</span>
                </a>
            </div>
            <!-- Header -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl p-6 sm:p-8 shadow-2xl mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        {{-- <p class="text-sm text-gray-400 mb-1">Admin Panel</p> --}}
                        <h1 class="text-white text-3xl font-semibold">Photobooth Templates</h1>
                        {{-- <p class="text-gray-400 text-sm">Kelola koleksi template photobooth Anda</p> --}}
                    </div>
                    <a href="{{ route('photobooth.template.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 border border-blue-700/50 rounded-xl px-6 py-3 text-white transition-all duration-300 shadow-lg hover:shadow-blue-600/30">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Template</span>
                    </a>
                </div>

                <!-- Alerts -->
                @foreach (['success' => 'green', 'error' => 'red'] as $key => $color)
                    @if (session($key))
                        <div x-data="{ show: true }" x-show="show" x-transition
                            class="mt-4 bg-{{ $color }}-600/20 border border-{{ $color }}-500/30 rounded-xl px-4 py-3 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <i
                                    class="fa-solid {{ $key === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' }} text-{{ $color }}-400"></i>
                                <span class="text-{{ $color }}-400">{{ session($key) }}</span>
                            </div>
                            <button @click="show = false"
                                class="text-{{ $color }}-400 hover:text-{{ $color }}-300 transition-colors">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Templates -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $no = 0; ?>
                @forelse ($templates as $template)
                    <div x-data="{ showPreview: false, showDelete: false, imageLoaded: false }"
                        class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl overflow-hidden shadow-xl transition-all duration-300 hover:scale-[1.02] hover:border-gray-600/50">

                        <!-- Thumbnail -->
                        <div class="relative group">
                            <img src="{{ asset($template->file_path) }}" alt="{{ $template->name }}"
                                class="w-full h-64 object-cover transition-opacity duration-500">
                            <div
                                class="absolute top-3 left-3 bg-gray-900/80 border border-gray-700/50 rounded-lg px-3 py-1">
                                <?php $no++; ?>
                                <span class="text-gray-300 text-xs font-mono">#{{ $no }}</span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-5">
                            <h3 class="text-white text-lg font-semibold mb-1 truncate" title="{{ $template->name }}">
                                {{ $template->name }}
                            </h3>
                            <div class="text-xs text-gray-400 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>{{ $template->created_at->format('d M Y') }}</span>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <a href="{{ route('photobooth.template.edit', $template->id) }}"
                                    class="flex-1 bg-yellow-600/20 hover:bg-yellow-600/30 border border-yellow-500/30 rounded-xl px-4 py-2.5 text-yellow-400 hover:text-yellow-300 transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="text-sm font-medium">Edit</span>
                                </a>
                                <button @click="showDelete = true"
                                    class="flex-1 bg-red-600/20 hover:bg-red-600/30 border border-red-500/30 rounded-xl px-4 py-2.5 text-red-400 hover:text-red-300 transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-trash"></i>
                                    <span class="text-sm font-medium">Hapus</span>
                                </button>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <template x-if="showDelete">
                            <div x-show="showDelete" x-transition.opacity.duration.300ms
                                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
                                @click.self="showDelete = false" @keydown.escape.window="showDelete = false" x-cloak>
                                <div x-transition.scale.origin.center
                                    class="relative max-w-md w-full bg-white/95 border border-gray-200/50 rounded-3xl shadow-2xl p-8">
                                    <button @click="showDelete = false"
                                        class="absolute top-4 right-4 w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-xmark text-gray-600"></i>
                                    </button>

                                    <div class="text-center mb-6">
                                        <div
                                            class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-exclamation-triangle text-red-600 text-2xl"></i>
                                        </div>
                                        <h2 class="text-gray-800 text-xl font-semibold mb-2">Konfirmasi Hapus</h2>
                                        <p class="text-gray-600 text-sm">
                                            Apakah Anda yakin ingin menghapus
                                            <strong>{{ $template->name }}</strong>?
                                        </p>
                                    </div>

                                    <div
                                        class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 mb-6 text-yellow-800 text-xs">
                                        <i class="fa-solid fa-info-circle mr-1"></i> Tindakan ini tidak dapat dibatalkan!
                                    </div>

                                    <div class="flex gap-3">
                                        <button @click="showDelete = false"
                                            class="flex-1 bg-gray-100 hover:bg-gray-200 rounded-xl py-3 text-gray-700 font-medium">
                                            Batal
                                        </button>
                                        <form action="{{ route('photobooth.template.destroy', $template->id) }}"
                                            method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-red-600 hover:bg-red-700 rounded-xl py-3 text-white font-medium transition-all duration-300">
                                                Ya, Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                @empty
                    <div class="col-span-full text-center bg-gray-800/50 border border-gray-700/50 rounded-2xl p-12">
                        <div class="w-20 h-20 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-inbox text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-white text-xl font-semibold mb-2">Belum Ada Template</h3>
                        <p class="text-gray-400 mb-6">Mulai dengan menambahkan template photobooth pertama Anda</p>
                        <a href="{{ route('photobooth.template.create') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 border border-blue-700/50 rounded-xl px-6 py-3 text-white transition-all duration-300 shadow-lg hover:shadow-blue-600/30">
                            <i class="fa-solid fa-plus"></i>
                            <span>Tambah Template Pertama</span>
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if (method_exists($templates, 'links') && $templates->hasPages())
                <div class="mt-8">
                    <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-4">
                        {{ $templates->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
@endsection
