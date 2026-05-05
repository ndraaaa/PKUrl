<!DOCTYPE html>
<html lang="id" class="antialiased selection:bg-emerald-500 selection:text-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full text-center">

        {{-- Ikon Ilustrasi Error (Menggunakan Flexbox Bertingkat agar PASTI Simetris) --}}
        <div class="relative w-32 h-32 mx-auto mb-8 flex items-center justify-center">

            <div class="absolute inset-0 bg-emerald-100 dark:bg-emerald-900/30 rounded-full animate-pulse"></div>

            <div
                class="relative z-10 w-24 h-24 bg-emerald-50 dark:bg-emerald-800/40 rounded-full flex items-center justify-center">

                <svg class="w-10 h-10 text-emerald-500 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4l16 16" />
                </svg>

            </div>

            {{-- Badge 404 - Diposisikan tepat di ujung kanan bawah lingkaran --}}
            <div
                class="absolute bottom-0 right-0 z-20 bg-rose-500 text-white text-xs font-black px-3 py-1 rounded-xl shadow-lg border-2 border-white dark:border-gray-900">
                404
            </div>

        </div>

        {{-- Teks Utama --}}
        <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight mb-3">
            Oops! Halaman Hilang.
        </h1>

        {{-- Pesan Kustom dari Controller --}}
        <p class="text-gray-500 dark:text-gray-400 text-base leading-relaxed mb-8">
            {{ $exception->getMessage() ?: 'Halaman yang Anda tuju tidak ditemukan atau tautan telah dinonaktifkan oleh pemiliknya.' }}
        </p>

        {{-- Tombol Refresh (Muat Ulang) --}}
        <button onclick="window.location.reload()"
            class="inline-flex items-center justify-center px-8 py-3 rounded-xl bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 hover:-translate-y-0.5 transition transform active:scale-95 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">

            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                </path>
            </svg>
            Muat Ulang
        </button>

    </div>

</body>

</html>
