<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - LinkApp</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
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
            <h1 class="text-5xl font-bold leading-tight mb-6">Selamat Datang Kembali.</h1>
            <p class="text-emerald-100/80 text-lg font-light leading-relaxed">
                Masuk ke dashboard untuk mengelola tautan, melihat analitik, dan memperbarui profil bio Anda.
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
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">Masuk Akun 👋</h2>
                    <p class="mt-2 text-sm text-gray-500">Masukkan email dan password Anda.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <div class="relative rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-600 bg-white">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input type="email" name="email" id="email" autocomplete="email" required autofocus
                                class="block w-full border-0 bg-transparent py-3 pl-10 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" 
                                placeholder="nama@email.com" value="{{ old('email') }}">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <div class="relative rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-600 bg-white">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password" id="password" autocomplete="current-password" required
                                class="block w-full border-0 bg-transparent py-3 pl-10 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" 
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-600 cursor-pointer">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember_me" class="font-medium text-gray-600 cursor-pointer select-none">Ingat saya</label>
                        </div>
                    </div>

                    <button type="submit" class="flex w-full justify-center rounded-lg bg-emerald-600 px-3 py-3.5 text-sm font-bold leading-6 text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all">
                        Masuk Dashboard
                    </button>

                    <p class="mt-6 text-center text-sm text-gray-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-500">Daftar Gratis</a>
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