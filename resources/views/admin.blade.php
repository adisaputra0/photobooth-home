@extends('layouts.photobooth')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-800 via-gray-900 to-black flex flex-col">
    <!-- Header Section -->
    <div class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-6xl">
            <!-- Title Section -->
            <div class="text-center mb-12 animate-fade-in">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 tracking-tight">
                    Admin Panel
                </h1>
                <div class="flex items-center justify-center gap-3 mb-3">
                    <div class="h-px w-12 bg-gradient-to-r from-transparent to-gray-600"></div>
                    <p class="text-xl md:text-2xl text-gray-300 font-light">
                        Template Management
                    </p>
                    <div class="h-px w-12 bg-gradient-to-l from-transparent to-gray-600"></div>
                </div>
                <p class="text-gray-500 text-sm md:text-base">
                    Choose what you want to edit
                </p>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Photobooth Template Card -->
                <a href="{{ route('photobooth.template.admin') }}" 
                   class="group relative bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl p-8 md:p-10 transition-all duration-300 hover:scale-105 hover:shadow-blue-500/20 hover:border-blue-500/50 overflow-hidden">
                    <!-- Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/0 via-blue-600/0 to-blue-600/0 group-hover:from-blue-600/10 group-hover:via-blue-600/5 group-hover:to-transparent transition-all duration-500 rounded-3xl"></div>
                    
                    <!-- Content -->
                    <div class="relative z-10 text-center">
                        <!-- Icon -->
                        <div class="mb-6 inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-blue-600 rounded-2xl group-hover:bg-blue-700 transition-all duration-300 group-hover:rotate-6 shadow-lg shadow-blue-600/30">
                            <i class="fas fa-camera-retro text-4xl md:text-5xl text-white"></i>
                        </div>
                        
                        <!-- Title -->
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors duration-300">
                            Photobooth Template
                        </h2>
                        
                        <!-- Description -->
                        <p class="text-gray-400 text-sm md:text-base mb-4">
                            Edit Photobooth Templates
                        </p>
                        
                        <!-- Subtitle -->
                        <p class="text-gray-500 text-xs md:text-sm">
                            Manage layouts, frames, and designs
                        </p>
                        
                        <!-- Arrow Icon -->
                        <div class="mt-6 flex items-center justify-center gap-2 text-blue-500 group-hover:gap-4 transition-all duration-300">
                            <span class="text-sm font-semibold">Open Editor</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>

                <!-- ID Card Template Card -->
                <a href="{{ route('idcard.template.admin') }}" 
                   class="group relative bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-3xl shadow-2xl p-8 md:p-10 transition-all duration-300 hover:scale-105 hover:shadow-green-500/20 hover:border-green-500/50 overflow-hidden">
                    <!-- Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-green-600/0 via-green-600/0 to-green-600/0 group-hover:from-green-600/10 group-hover:via-green-600/5 group-hover:to-transparent transition-all duration-500 rounded-3xl"></div>
                    
                    <!-- Content -->
                    <div class="relative z-10 text-center">
                        <!-- Icon -->
                        <div class="mb-6 inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-green-600 rounded-2xl group-hover:bg-green-700 transition-all duration-300 group-hover:rotate-6 shadow-lg shadow-green-600/30">
                            <i class="fas fa-id-card text-4xl md:text-5xl text-white"></i>
                        </div>
                        
                        <!-- Title -->
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-3 group-hover:text-green-400 transition-colors duration-300">
                            ID Card Template
                        </h2>
                        
                        <!-- Description -->
                        <p class="text-gray-400 text-sm md:text-base mb-4">
                            Edit ID Card Templates
                        </p>
                        
                        <!-- Subtitle -->
                        <p class="text-gray-500 text-xs md:text-sm">
                            Customize ID card layouts and fields
                        </p>
                        
                        <!-- Arrow Icon -->
                        <div class="mt-6 flex items-center justify-center gap-2 text-green-500 group-hover:gap-4 transition-all duration-300">
                            <span class="text-sm font-semibold">Open Editor</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Quick Stats (Optional Enhancement) -->
            <div class="mt-12 grid grid-cols-2 gap-4 max-w-4xl mx-auto">
                <div class="bg-gray-800/30 backdrop-blur-sm border border-gray-700/30 rounded-2xl p-4 text-center">
                    <i class="fas fa-images text-2xl text-blue-400 mb-2"></i>
                    <p class="text-gray-400 text-xs">Photobooth</p>
                    <p class="text-white text-xl font-bold">{{ $totalPhotoboothTemplates }}</p>
                </div>
                <div class="bg-gray-800/30 backdrop-blur-sm border border-gray-700/30 rounded-2xl p-4 text-center">
                    <i class="fas fa-address-card text-2xl text-green-400 mb-2"></i>
                    <p class="text-gray-400 text-xs">ID Cards</p>
                    <p class="text-white text-xl font-bold">{{ $totalIDCardTemplates }}</p>
                </div>
                {{-- <div class="bg-gray-800/30 backdrop-blur-sm border border-gray-700/30 rounded-2xl p-4 text-center">
                    <i class="fas fa-clock text-2xl text-purple-400 mb-2"></i>
                    <p class="text-gray-400 text-xs">Recent</p>
                    <p class="text-white text-xl font-bold">8</p>
                </div>
                <div class="bg-gray-800/30 backdrop-blur-sm border border-gray-700/30 rounded-2xl p-4 text-center">
                    <i class="fas fa-star text-2xl text-yellow-400 mb-2"></i>
                    <p class="text-gray-400 text-xs">Popular</p>
                    <p class="text-white text-xl font-bold">12</p>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-6 text-center">
        <div class="flex items-center justify-center gap-2 text-gray-500 text-sm">
            <i class="far fa-copyright"></i>
            <span>2025 Photobooth Admin Panel — All Rights Reserved</span>
        </div>
    </footer>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}
</style>
@endsection