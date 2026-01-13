<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>e-Link - Satu Link untuk Segalanya</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi Gradient untuk Teks Highlight */
        .animated-bg-text {
            background: linear-gradient(to right, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient-text 5s ease infinite;
            /* Tambahkan sedikit shadow agar terbaca di background gelap */
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }
        @keyframes gradient-text {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50 font-figtree">

    <nav x-data="{ open: false }" class="fixed w-full z-50 transition duration-300 bg-black/20 backdrop-blur-sm border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="#" class="flex items-center gap-2 text-white">
                        <img 
                            src="{{ asset('images/logo.png') }}" 
                            alt="e-Link Logo"
                            class="h-8 w-auto"
                        >
                        <span class="text-2xl font-bold">
                            e-Link
                        </span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-200 hover:text-white transition">Fitur</a>
                    <a href="#preview" class="text-gray-200 hover:text-white transition">Preview</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white font-semibold hover:text-gray-200">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white font-medium hover:text-gray-200">Masuk</a>
                            {{-- @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-white text-gray-900 font-semibold shadow hover:bg-gray-100 transition transform hover:-translate-y-0.5">
                                    Daftar Gratis
                                </a>
                            @endif --}}
                        @endauth
                    @endif
                </div>

                <div class="flex items-center md:hidden">
                    <button @click="open = !open" class="text-white hover:text-gray-200 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" class="md:hidden bg-white border-t border-gray-100 p-4 space-y-2 shadow-lg">
            <a href="#features" class="block text-gray-600 hover:text-indigo-600">Fitur</a>
            <a href="{{ route('login') }}" class="block text-gray-600 hover:text-indigo-600">Masuk</a>
            {{-- <a href="{{ route('register') }}" class="block font-bold text-indigo-600">Daftar Sekarang</a> --}}
        </div>
    </nav>

    <section class="pt-32 pb-20 px-4 sm:px-6 lg:pt-44 lg:pb-28 overflow-hidden relative min-h-[80vh] flex items-center">
        
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-bg.jpeg') }}" 
                 alt="Background" 
                 class="w-full h-full object-cover">
        </div>

        <div class="absolute inset-0 z-0 bg-black/70"></div>

        <div class="relative z-10 max-w-7xl mx-auto text-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white mb-6">
                Satu Link untuk <br>
                <span class="animated-bg-text">Segala Kebutuhan Digitalmu</span>
            </h1>
            <p class="mt-4 text-xl text-gray-200 max-w-2xl mx-auto mb-10 leading-relaxed">
                Gabungkan Shortlink, Halaman Bio yang cantik, dan QR Code kustom dalam satu platform. Tingkatkan branding Anda sekarang juga.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-full bg-indigo-600 text-white font-bold text-lg shadow-xl hover:bg-indigo-500 transition transform hover:-translate-y-1 ring-2 ring-indigo-600 ring-offset-2 ring-offset-black">
                    Mulai Sekarang
                </a>
                <a href="#features" class="px-8 py-4 rounded-full bg-transparent text-white font-bold text-lg border-2 border-white hover:bg-white/10 transition">
                    Pelajari Fitur
                </a>
            </div>

            {{-- <div class="mt-16 relative mx-auto w-full max-w-4xl rounded-xl shadow-2xl border-4 border-white/20 bg-black/50 backdrop-blur-sm overflow-hidden transform hover:scale-[1.01] transition duration-500">
                <div class="aspect-w-16 aspect-h-9 bg-black/40 flex items-center justify-center text-gray-400">
                    <div class="p-10 text-center">
                        <svg class="w-20 h-20 mx-auto mb-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-lg font-medium text-white/60">Area Screenshot Dashboard Aplikasi</span>
                        <p class="text-sm text-white/40">(Ganti ini dengan screenshot asli)</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>

    <section id="preview" class="py-20 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-indigo-600 font-bold tracking-wide uppercase text-sm">Kustomisasi Tanpa Batas</h2>
                <h3 class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">Pilih Tema yang Sesuai Gayamu</h3>
                <p class="mt-4 text-lg text-gray-500">
                    Tersedia berbagai pilihan tema warna. Dari mode gelap yang elegan hingga gradasi warna yang ceria.
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-8 items-center">
                
                <div class="relative mx-auto border-gray-800 bg-gray-800 border-[14px] rounded-[2.5rem] h-[600px] w-[300px] shadow-xl flex flex-col justify-between p-4 transform hover:-translate-y-4 transition duration-500">
                    <div class="h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
                    <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
                    <div class="h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>
                    <div class="rounded-[2rem] overflow-hidden w-full h-full bg-gray-900 text-white flex flex-col items-center pt-10 px-4 relative">
                        <div class="w-20 h-20 bg-gray-700 rounded-full mb-4 border-2 border-gray-600"></div>
                        <div class="h-4 w-32 bg-gray-700 rounded mb-2"></div>
                        <div class="h-3 w-20 bg-gray-800 rounded mb-8"></div>
                        <div class="w-full space-y-3">
                            <div class="h-12 w-full border border-gray-700 rounded-full flex items-center justify-center text-sm font-medium text-gray-300">Portfolio Saya</div>
                            <div class="h-12 w-full border border-gray-700 rounded-full flex items-center justify-center text-sm font-medium text-gray-300">Kontak WhatsApp</div>
                            <div class="h-12 w-full border border-gray-700 rounded-full flex items-center justify-center text-sm font-medium text-gray-300">Youtube Channel</div>
                        </div>
                        <div class="absolute bottom-6 text-xs text-gray-500 font-mono">Tema: Midnight</div>
                    </div>
                </div>

                <div class="relative mx-auto border-gray-800 bg-gray-800 border-[14px] rounded-[2.5rem] h-[650px] w-[320px] shadow-2xl flex flex-col justify-between p-4 transform hover:-translate-y-4 transition duration-500 z-10">
                    <div class="h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
                    <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
                    <div class="h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>
                    <div class="rounded-[2rem] overflow-hidden w-full h-full bg-white flex flex-col items-center pt-10 px-4 relative">
                        <div class="absolute inset-0 z-0 opacity-90" style="background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab); background-size: 400% 400%; animation: gradient 5s ease infinite;"></div>
                        
                        <div class="relative z-10 w-24 h-24 bg-white rounded-full mb-4 border-4 border-white shadow-lg flex items-center justify-center">
                            <span class="text-3xl">😎</span>
                        </div>
                        <div class="relative z-10 text-white font-bold text-xl mb-1">Rizky Dev</div>
                        <div class="relative z-10 text-white/80 text-sm mb-8">@rizkycode</div>
                        
                        <div class="relative z-10 w-full space-y-3">
                            <div class="h-14 w-full bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center text-gray-800 font-bold transform hover:scale-105 transition cursor-pointer">
                                🔥 Promo Spesial
                            </div>
                            <div class="h-14 w-full bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center text-gray-800 font-bold transform hover:scale-105 transition cursor-pointer">
                                🛍️ Toko Online
                            </div>
                            <div class="h-14 w-full bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center text-gray-800 font-bold transform hover:scale-105 transition cursor-pointer">
                                💬 Chat Admin
                            </div>
                        </div>
                        <div class="z-10 absolute bottom-6 text-xs text-white/70 font-mono font-bold">Tema: Default Gradient</div>
                    </div>
                </div>

                <div class="relative mx-auto border-gray-800 bg-gray-800 border-[14px] rounded-[2.5rem] h-[600px] w-[300px] shadow-xl flex flex-col justify-between p-4 transform hover:-translate-y-4 transition duration-500">
                    <div class="h-[32px] w-[3px] bg-gray-800 absolute -left-[17px] top-[72px] rounded-l-lg"></div>
                    <div class="h-[46px] w-[3px] bg-gray-800 absolute -left-[17px] top-[124px] rounded-l-lg"></div>
                    <div class="h-[64px] w-[3px] bg-gray-800 absolute -right-[17px] top-[142px] rounded-r-lg"></div>
                    <div class="rounded-[2rem] overflow-hidden w-full h-full text-white flex flex-col items-center pt-10 px-4 relative" style="background: linear-gradient(-45deg, #00c6ff, #0072ff);">
                        <div class="w-20 h-20 bg-blue-400/50 rounded-full mb-4 border-2 border-blue-200"></div>
                        <div class="h-4 w-32 bg-blue-300/50 rounded mb-2"></div>
                        <div class="h-3 w-20 bg-blue-300/30 rounded mb-8"></div>
                        <div class="w-full space-y-3">
                            <div class="h-12 w-full bg-white/20 border border-white/30 rounded-full flex items-center justify-center text-sm font-medium">Link 1</div>
                            <div class="h-12 w-full bg-white/20 border border-white/30 rounded-full flex items-center justify-center text-sm font-medium">Link 2</div>
                            <div class="h-12 w-full bg-white/20 border border-white/30 rounded-full flex items-center justify-center text-sm font-medium">Link 3</div>
                        </div>
                        <div class="absolute bottom-6 text-xs text-blue-100 font-mono">Tema: Ocean</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="features" class="py-20 bg-white relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-indigo-600 font-bold tracking-wide uppercase text-sm">Fitur Unggulan</h2>
                <h3 class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">Semua alat yang Anda butuhkan</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="p-8 bg-gray-50 rounded-2xl hover:shadow-xl transition duration-300 border border-transparent hover:border-indigo-100 group">
                    <div class="w-14 h-14 bg-indigo-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors">
                        <svg class="w-8 h-8 text-indigo-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">URL Shortener</h4>
                    <p class="text-gray-600">Perpendek link panjang Anda menjadi singkat dan mudah diingat. Dukungan kustom slug (nama link sendiri).</p>
                </div>

                <div class="p-8 bg-gray-50 rounded-2xl hover:shadow-xl transition duration-300 border border-transparent hover:border-pink-100 group">
                    <div class="w-14 h-14 bg-pink-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-pink-600 transition-colors">
                        <svg class="w-8 h-8 text-pink-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Halaman Bio (Link-in-Bio)</h4>
                    <p class="text-gray-600">Buat satu halaman cantik yang menampung semua link sosial mediamu. Ganti tema dan warna sesuka hati.</p>
                </div>

                <div class="p-8 bg-gray-50 rounded-2xl hover:shadow-xl transition duration-300 border border-transparent hover:border-yellow-100 group">
                    <div class="w-14 h-14 bg-yellow-100 rounded-lg flex items-center justify-center mb-6 group-hover:bg-yellow-500 transition-colors">
                        <svg class="w-8 h-8 text-yellow-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 6h6v6H6V6zm12 0h6v6h-6V6zm-6 12h6v6h-6v-6z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">QR Code Kustom</h4>
                    <p class="text-gray-600">Generate QR Code otomatis dengan logo profil Anda di tengahnya. Download dalam format SVG yang tajam.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-900 relative overflow-hidden z-20">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-indigo-500 opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-pink-500 opacity-20 blur-3xl"></div>

        <div class="relative max-w-4xl mx-auto text-center px-4 sm:px-6">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-6">
                Siap Meningkatkan Identitas Digitalmu?
            </h2>
            <p class="text-lg text-gray-400 mb-10">
                Bergabunglah dengan pengguna lain yang telah mengelola link mereka dengan lebih cerdas, rapi, dan profesional.
            </p>
            <a href="{{ route('login') }}" class="inline-block px-8 py-4 bg-indigo-600 text-white font-bold rounded-full shadow-lg hover:bg-indigo-500 transition transform hover:scale-105">
                Gunakan aplikasi sekarang
            </a>
        </div>
    </section>

    <footer class="bg-gray-50 pt-16 pb-8 border-t border-gray-200 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <span class="text-2xl font-bold text-gray-900">e-Link</span>
                    <p class="text-sm text-gray-500 mt-2">&copy; {{ date('Y') }} e-Link. Dibuat dengan Laravel & ❤️.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-900">Tentang</a>
                    <a href="#" class="text-gray-400 hover:text-gray-900">Kebijakan Privasi</a>
                    <a href="#" class="text-gray-400 hover:text-gray-900">Kontak</a>
                </div>
            </div>
        </div>
    </footer>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>