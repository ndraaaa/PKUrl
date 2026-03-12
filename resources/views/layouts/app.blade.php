@props(['title' => null, 'desc' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title . ' - ' . config('app.name', 'e-Link') : config('app.name', 'e-Link') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    <script>
        // Logika Mode Gelap
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        // TAMBAHAN: Logika Mini Sidebar (Mencegah Kedip)
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            document.documentElement.classList.add('sidebar-mini');
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased text-gray-900 dark:text-gray-100">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        @include('layouts.navigation')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <div class="flex items-center justify-between px-4 py-3 bg-[#006738] border-b border-[#004f2b] md:hidden sticky top-0 z-20 shadow-md">
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" 
                        alt="Logo E-Link" 
                        class="w-8 h-8 object-contain shadow-sm shadow-black/20 bg-white rounded-lg p-0.5">
                    
                    <div class="flex flex-col leading-tight">
                        <span class="text-lg font-black text-white tracking-tight drop-shadow-sm">e-Link</span>
                        <span class="text-[9px] font-semibold text-emerald-100 uppercase tracking-wider">
                            RS PKU Aisyiyah Boyolali
                        </span>
                    </div>
                </a>

                <button @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 text-emerald-100 hover:text-white hover:bg-black/20 rounded-lg transition-colors focus:outline-none"
                        title="Buka Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <main class="w-full flex-1 p-4 sm:p-6 md:p-8">

                @if (isset($header))
                    <header class="mb-8">
                        {{ $header }}
                    </header>
                @elseif($title)
                    <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                                {{ $title }}
                            </h2>
                            @if ($desc)
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $desc }}
                                </p>
                            @endif
                        </div>

                        @if (isset($actions) && $actions->isNotEmpty())
                            <div class="flex items-center gap-3">
                                {{ $actions }}
                            </div>
                        @endif
                    </header>
                @endif

                <div class="animate-fade-in-up">
                    {{ $slot }}
                </div>

            </main>

        </div>
    </div>

    @stack('scripts')
</body>

</html>
