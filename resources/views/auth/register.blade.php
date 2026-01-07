<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - LinkApp</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Scrollbar custom agar tidak merusak pemandangan di desktop */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased min-h-screen lg:h-screen lg:overflow-hidden flex flex-col lg:flex-row">

    <div class="hidden lg:flex lg:w-1/2 bg-emerald-900 relative flex-col justify-between p-16 text-white h-full">
        <div class="absolute inset-0 z-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029&auto=format&fit=crop" class="w-full h-full object-cover grayscale" alt="Background">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900 via-emerald-900/80 to-transparent z-0"></div>

        <div class="relative z-10 flex items-center space-x-3">
            <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-900/50">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            </div>
            <span class="text-2xl font-bold tracking-tight">LinkApp.</span>
        </div>

        <div class="relative z-10 max-w-lg">
            <h1 class="text-5xl font-bold leading-tight mb-6">Mulai Perjalanan Digital Anda.</h1>
            <p class="text-emerald-100/80 text-lg font-light leading-relaxed">
                Bergabunglah dengan ribuan profesional lainnya. Buat akun gratis dan kelola identitas online Anda sekarang.
            </p>
        </div>

        <div class="relative z-10 text-xs text-emerald-300 font-medium tracking-wide uppercase">
            &copy; {{ date('Y') }} LinkApp Systems.
        </div>
    </div>

    <div class="lg:hidden absolute top-0 left-0 w-full h-64 bg-emerald-900 z-0 rounded-b-[3rem]">
        <div class="absolute inset-0 opacity-20">
             <img src="https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029&auto=format&fit=crop" class="w-full h-full object-cover grayscale" alt="bg">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-800/50 to-emerald-900 z-10"></div>
        
        <div class="relative z-20 pt-10 text-center text-white">
            <span class="text-2xl font-bold tracking-tight">LinkApp.</span>
        </div>
    </div>

    <div class="w-full lg:w-1/2 z-10 flex flex-col items-center lg:h-full lg:overflow-y-auto custom-scrollbar">
        
        <div class="w-full max-w-md p-6 lg:p-12 lg:my-auto">
            
            <div class="bg-white rounded-3xl shadow-xl lg:shadow-none lg:bg-transparent p-6 lg:p-0 mt-20 lg:mt-0">
                
                <div class="text-center lg:text-left mb-8">
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">Buat Akun Baru 🚀</h2>
                    <p class="mt-2 text-sm text-gray-500">Isi formulir di bawah untuk mendaftar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-1.5">Username (Link URL)</label>
                        <div class="flex rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-600 bg-white overflow-hidden">
                            <span class="flex select-none items-center pl-3 pr-3 bg-gray-50 text-gray-500 text-sm border-r border-gray-200">
                                {{ request()->getHost() }}/
                            </span>
                            <input type="text" name="username" id="username" autocomplete="username" 
                                class="flex-1 border-0 bg-transparent py-3 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" 
                                placeholder="username" value="{{ old('username') }}" required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Ini akan menjadi alamat profil publik Anda.</p>
                        <x-input-error :messages="$errors->get('username')" class="mt-1" />
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-600 bg-white">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" name="name" id="name" 
                                class="block w-full border-0 bg-transparent py-3 pl-10 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" 
                                placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <div class="relative rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-600 bg-white">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <input type="email" name="email" id="email" 
                                class="block w-full border-0 bg-transparent py-3 pl-10 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" 
                                placeholder="nama@email.com" value="{{ old('email') }}" required>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1.5">WhatsApp / HP</label>
                        <div class="flex rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-600 bg-white overflow-hidden">
                            <span class="flex select-none items-center justify-center pl-3 pr-2 bg-gray-50 text-gray-600 text-sm font-bold border-r border-gray-200">
                                🇮🇩 +62
                            </span>
                            <input type="text" name="phone" id="phone" inputmode="numeric" pattern="[0-9]*"
                                class="flex-1 border-0 bg-transparent py-3 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                placeholder="812345678"
                                value="{{ old('phone') }}" required >
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                        <div class="relative rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-600 bg-white">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                class="block w-full border-0 bg-transparent py-3 pl-10 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" 
                                placeholder="••••••••" required>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <div class="relative rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-600 bg-white">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                class="block w-full border-0 bg-transparent py-3 pl-10 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" 
                                placeholder="Ulangi password" required>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" type="checkbox" required class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-medium text-gray-600">Saya setuju dengan <a href="#" class="font-bold text-emerald-600 hover:text-emerald-500">Syarat & Ketentuan</a></label>
                        </div>
                    </div>

                    <button type="submit" class="flex w-full justify-center rounded-lg bg-emerald-600 px-3 py-3.5 text-sm font-bold leading-6 text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all">
                        Daftar Sekarang
                    </button>

                    <p class="mt-6 text-center text-sm text-gray-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-500">Masuk</a>
                    </p>
                </form>
            </div>
            
            <div class="mt-8 lg:hidden text-center pb-8">
                <p class="text-xs text-gray-400">&copy; 2026 LinkApp Systems.</p>
            </div>

        </div>
    </div>

</body>
</html>