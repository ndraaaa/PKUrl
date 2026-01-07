<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LinkApp') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            // Script Anti-FOUC (Flash of Unstyled Content) untuk Dark Mode
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <style>
            [x-cloak] { display: none !important; }
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .no-scrollbar::-webkit-scrollbar { display: none; }
        </style>
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased text-gray-900 dark:text-gray-100">
        
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
            
            @include('layouts.navigation')

            <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
                
                @include('layouts.header')

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
                    
                    @if (isset($header))
                        <div class="mx-auto px-4 sm:px-6 md:px-8 py-8">
                            {{ $header }}
                        </div>
                    @endif

                    <div class="mx-auto px-4 sm:px-6 md:px-8 pb-10">
                        {{ $slot }}
                    </div>
                    
                </main>
            </div>
            
        </div>
    </body>
</html>