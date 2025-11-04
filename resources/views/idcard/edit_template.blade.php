@extends('layouts.photobooth')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-4 sm:p-8">
        <div class="max-w-2xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('idcard.template.admin') }}"
                    class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="text-sm font-medium">Kembali ke Templates</span>
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div
                    class="bg-gradient-to-r from-purple-600/20 to-pink-600/20 border-b border-gray-700/50 px-6 sm:px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-pen-to-square text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-white text-2xl font-semibold">Edit Template</h1>
                            <p class="text-gray-400 text-sm">Perbarui detail template idcard Anda</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('idcard.template.update') }}" method="POST" enctype="multipart/form-data"
                    class="p-6 sm:p-8 space-y-6">
                    @csrf
                    <input type="hidden" name="template_id" value="{{ $template->id }}">

                    <!-- Template Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-gray-300 font-medium text-sm">
                            <i class="fa-solid fa-tag text-purple-400 mr-2"></i>
                            Nama Template
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $template->name) }}"
                            class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                            placeholder="Contoh: Template Elegant" required>
                    </div>

                    <!-- Template File (Optional) -->
                    <div class="space-y-2">
                        <label for="file_path" class="block text-gray-300 font-medium text-sm">
                            <i class="fa-solid fa-file-zipper text-pink-400 mr-2"></i>
                            Ganti File Template (opsional)
                        </label>
                        <div class="relative">
                            <input type="file" name="file_path" id="file_path" accept="image/*"
                                class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-gray-300 
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium 
                                file:bg-pink-600 file:text-white hover:file:bg-pink-700 file:cursor-pointer file:transition-colors
                                focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <p class="text-gray-500 text-xs flex items-center gap-2">
                            <i class="fa-solid fa-info-circle"></i>
                            Biarkan kosong jika tidak ingin mengganti file template
                        </p>

                        @if ($template->file_path)
                            <div class="mt-3">
                                <p class="text-gray-400 text-sm mb-1">File saat ini:</p>
                                <img src="{{ asset($template->file_path) }}" alt="Current Template"
                                    class="rounded-lg border border-gray-700/50 max-h-48 object-contain">
                            </div>
                        @endif
                    </div>

                    <!-- Slots -->
                    {{-- <div class="space-y-2">
                        <label for="slots" class="block text-gray-300 font-medium text-sm">
                            <i class="fa-solid fa-sliders text-green-400 mr-2"></i>
                            Jumlah Slot Foto
                        </label>
                        <input type="number" name="slots" id="slots" min="1" max="10"
                            value="{{ old('slots', $template->slots) }}"
                            class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                            required>
                    </div> --}}

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <a href="{{ route('idcard.template.admin') }}"
                            class="flex-1 bg-gray-700/50 hover:bg-gray-700 border border-gray-600/50 rounded-xl px-6 py-3 text-gray-300 hover:text-white font-medium transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-xmark"></i>
                            <span>Batal</span>
                        </a>
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl px-6 py-3 text-white font-medium transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-purple-600/30">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
