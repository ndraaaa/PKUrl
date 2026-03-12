<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Portal - e-Link RS PKU Aisyiyah Boyolali</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .bg-noise {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
        }

        .card-enter { animation: cardEnter 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(30px) scale(0.95); }
        @keyframes cardEnter { to { opacity: 1; transform: translateY(0) scale(1); } }

        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }

        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active  {
            -webkit-box-shadow: 0 0 0 30px #022c22 inset !important;
            -webkit-text-fill-color: #ecfdf5 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
    <script>
        tailwind.config = {
            darkMode: 'class', 
            theme: {
                extend: {
                    colors: {
                        slate: {"800":"#1e293b","900":"#0f172a","950":"#020617"},
                        primary: {"50":"#ecfdf5","100":"#d1fae5","200":"#a7f3d0","300":"#6ee7b7","400":"#34d399","500":"#10b981","600":"#059669","700":"#047857","800":"#065f46","900":"#064e3b","950":"#022c22"},
                        teal: {"400": "#2dd4bf", "500": "#14b8a6", "600": "#0d9488"}
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen antialiased text-primary-50 flex flex-col items-center justify-center p-4 lg:p-6 relative overflow-hidden bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/hero-bg.jpeg') }}');">

    <div class="absolute inset-0 bg-primary-950/85 z-0 pointer-events-none"></div>
    <div class="absolute inset-0 bg-noise opacity-10 mix-blend-soft-light pointer-events-none z-0"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[300px] h-[300px] lg:w-[600px] lg:h-[600px] bg-primary-500/20 rounded-full blur-[80px] lg:blur-[120px] pointer-events-none z-0"></div>

    <div class="lg:hidden flex flex-col items-center text-center mb-8 relative z-20 animate-float">
        <a href="{{ url('/') }}" class="group p-0 bg-white/80 backdrop-blur-2xl rounded-[2rem] border border-white/20 shadow-2xl ring-4 ring-white/10 overflow-hidden hover:scale-105 transition-transform duration-300 cursor-pointer">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 object-contain drop-shadow-md"/>
        </a>
        <div class="mt-5">
            <h2 class="text-3xl font-extrabold text-white tracking-tight drop-shadow-lg">e-Link</h2>
            <p class="text-primary-100 text-sm font-bold uppercase tracking-widest drop-shadow-md mt-1">RS PKU Aisyiyah Boyolali</p>
        </div>
    </div>
    <div class="w-full max-w-5xl bg-primary-950/40 backdrop-blur-2xl rounded-[2rem] lg:rounded-[2.5rem] border border-white/10 shadow-2xl shadow-black/50 overflow-hidden flex flex-col lg:flex-row card-enter relative z-10">
        
        <div class="hidden lg:flex lg:w-[45%] relative overflow-hidden bg-gradient-to-br from-primary-800/80 to-primary-950/80 p-14 flex-col justify-between text-white border-r border-white/5">
             <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/hero-bg.jpeg') }}" class="w-full h-full object-cover scale-110 opacity-40 mix-blend-overlay">
                <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-900/40 to-transparent"></div>
            </div>

            <div class="relative z-20 flex items-center space-x-4">
                <a href="{{ url('/') }}" class="p-0 bg-white/90 backdrop-blur-md rounded-2xl border border-primary-400/20 shadow-lg overflow-hidden hover:scale-105 transition-transform duration-300 cursor-pointer group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain drop-shadow-sm"/>
                </a>
                
                <a href="{{ url('/') }}" class="group">
                    <span class="block text-2xl font-extrabold tracking-tight text-white leading-none group-hover:text-primary-200 transition-colors">e-Link</span>
                    <span class="text-sm font-semibold text-primary-200 leading-none">RS PKU Aisyiyah Boyolali</span>
                </a>
            </div>

            <div class="relative z-20">
                <h1 class="text-4xl font-extrabold leading-tight mb-6 tracking-tight">
                    Sentralisasi Tautan & <br>Informasi Publik.
                </h1>
                 <p class="text-primary-100/90 text-lg font-medium leading-relaxed pl-4 border-l-4 border-primary-400 rounded-sm">
                    Kelola <b>Shortlink</b> dan <b>Halaman Bio-Link</b> resmi rumah sakit agar informasi lebih rapi, terpercaya, dan mudah diakses pasien.
                </p>
            </div>

            <div class="relative z-20 text-xs text-primary-300/70 font-bold tracking-widest uppercase">
                &copy; {{ date('Y') }} e-Link RS PKU Aisyiyah Boyolali.
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-center px-6 py-8 lg:p-14 relative bg-transparent lg:bg-primary-950/20">
            
            <div class="w-full max-w-sm mx-auto">
                
                <div class="mb-8 lg:mb-10 text-center lg:text-left">
                    <h2 class="text-2xl lg:text-3xl font-bold text-white tracking-tight">Akses Manajer</h2>
                    <p class="mt-2 text-primary-200/80 text-sm font-medium">Masuk untuk mengelola tautan unit Anda.</p>
                </div>

                @if (session('status'))
                    <div class="mb-6 bg-emerald-500/20 border border-emerald-500/30 text-emerald-100 rounded-xl p-3.5 text-sm font-medium flex items-center gap-3 shadow-lg backdrop-blur-sm animate-pulse">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="group">
                        <label for="username" class="block text-sm font-bold text-primary-100 mb-2 pl-1">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-primary-300">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="username" id="username" required autofocus autocomplete="username" placeholder="Masukkan Username" value="{{ old('username') }}"
                                class="block w-full rounded-xl border border-primary-500/30 bg-primary-900/40 py-4 pl-12 pr-4 text-white placeholder:text-primary-400/50 focus:ring-2 focus:ring-primary-400 focus:border-primary-400 focus:bg-primary-900/60 transition-all duration-300 sm:text-sm shadow-inner">
                        </div>
                        @error('username')
                            <p class="mt-2 text-sm font-bold text-red-400 flex items-center gap-1 pl-1 bg-red-900/20 p-2 rounded-lg border border-red-500/20">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="group" x-data="{ show: false }">
                        <div class="flex items-center justify-between mb-2 pl-1 pr-1">
                            <label for="password" class="block text-sm font-bold text-primary-100">Password</label>
                            {{-- @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-bold text-teal-300 hover:text-teal-200 transition-colors">
                                    Lupa sandi?
                                </a>
                            @endif --}}
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-primary-300">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                             <input :type="show ? 'text' : 'password'" name="password" id="password" autocomplete="current-password" required placeholder="••••••••••••"
                                class="block w-full rounded-xl border border-primary-500/30 bg-primary-900/40 py-4 pl-12 pr-12 text-white placeholder:text-primary-400/50 focus:ring-2 focus:ring-primary-400 focus:border-primary-400 focus:bg-primary-900/60 transition-all duration-300 sm:text-sm shadow-inner">
                             
                             <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-4 text-primary-400/70 hover:text-white transition-colors outline-none focus:outline-none z-10 p-2">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L9.135 9.135" /></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm font-bold text-red-400 flex items-center gap-1 pl-1 bg-red-900/20 p-2 rounded-lg border border-red-500/20">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-center pl-1">
                        <input id="remember_me" name="remember" type="checkbox" class="h-5 w-5 rounded border-primary-500/50 bg-primary-900/50 text-teal-500 focus:ring-teal-500 focus:ring-offset-0 cursor-pointer transition-all">
                        <label for="remember_me" class="ml-3 block text-sm font-bold text-primary-100 cursor-pointer select-none">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="group relative w-full flex justify-center items-center rounded-xl bg-gradient-to-r from-primary-600 to-teal-600 px-4 py-4 text-sm font-bold leading-6 text-white shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_30px_rgba(16,185,129,0.5)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 border border-white/10 overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 group-hover:translate-x-full transition-transform duration-500 -skew-x-12 -translate-x-full"></div>
                        <span class="relative flex items-center">
                            Masuk Dashboard
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-2 transition-transform group-hover:translate-x-1">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.5a.75.75 0 010 1.06l-5.5 5.5a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                </form>
            </div>

            <div class="mt-8 lg:hidden text-center">
                <p class="text-[10px] font-bold text-primary-400/50 uppercase tracking-[0.2em]">&copy; 2026 e-Link Systems</p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style> [x-cloak] { display: none !important; } </style>
</body>
</html>