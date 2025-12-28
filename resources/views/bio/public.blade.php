<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->name }} (@ {{ $user->username }}) - Link Bio</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Base Animation */
        .animated-bg {
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* 1. Default Theme */
        .theme-default {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
        }
        /* 2. Ocean Theme */
        .theme-ocean {
            background: linear-gradient(-45deg, #00c6ff, #0072ff);
        }
        /* 3. Midnight Theme */
        .theme-midnight {
            background: linear-gradient(-45deg, #232526, #414345);
        }
        /* 4. Sunset Theme */
        .theme-sunset {
            background: linear-gradient(-45deg, #ff9966, #ff5e62, #833ab4);
        }
        /* 5. Nature Theme */
        .theme-nature {
            background: linear-gradient(-45deg, #11998e, #38ef7d);
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 min-h-screen flex flex-col animated-bg theme-{{ $user->theme }}">

    <div class="flex-grow flex flex-col items-center pt-16 px-4 pb-12 max-w-lg mx-auto w-full">
        
        <div class="relative group">
            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full overflow-hidden border-4 border-white shadow-xl">
                @if($user->profile)
                    <img src="{{ asset('storage/' . $user->profile) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-white flex items-center justify-center text-4xl font-bold text-gray-500">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-1 border-2 border-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

        <h1 class="mt-4 text-2xl font-bold text-white text-shadow-sm">{{ $user->name }}</h1>
        <p class="text-white/90 text-sm mt-1 mb-8 font-medium">@ {{ $user->username }}</p>

        <div class="w-full space-y-4">
            @forelse($links as $link)
                <a href="{{ url($link->short_code) }}" target="_blank" 
                   class="block w-full bg-white/90 hover:bg-white backdrop-blur-sm text-gray-800 font-semibold py-4 px-6 rounded-full shadow-lg transform transition duration-200 hover:scale-[1.02] text-center border border-white/50 relative overflow-hidden group">
                    
                    <span class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-white/50 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                    
                    {{ $link->title }}
                </a>
            @empty
                <div class="text-center text-white/80 py-4 bg-black/20 rounded-lg">
                    User ini belum menambahkan link apapun.
                </div>
            @endforelse
        </div>

        <div class="mt-auto pt-12 text-center">
            <a href="{{ url('/') }}" class="text-white/70 text-xs hover:text-white font-semibold uppercase tracking-widest transition">
                Buat link seperti ini di <span class="text-white font-bold">LinkApp</span>
            </a>
        </div>

    </div>

</body>
</html>