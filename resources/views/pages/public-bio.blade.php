<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }} | {{ config('app.name') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animasi Muncul dari bawah */
        .reveal-up { animation: revealUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(30px); }
        @keyframes revealUp { to { opacity: 1; transform: translateY(0); } }

        /* Animasi Background Bergerak Halus */
        .animate-breathe { animation: breathe 10s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        /* Noise Texture */
        .bg-noise { background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E"); }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 0px; background: transparent; }
    </style>
</head>

@php
    $appearance = is_array($page->appearance) ? $page->appearance : [];
    $theme = $appearance['theme'] ?? 'default';

    // Konfigurasi Tema (Warna & Aksen)
    switch($theme) {
        case 'ocean':
            $bgGradient = 'from-slate-900 via-blue-900 to-black';
            $accentColor = 'text-blue-400';
            $glowColor = 'bg-blue-500';
            break;
        case 'sunset':
            $bgGradient = 'from-slate-900 via-rose-900 to-black';
            $accentColor = 'text-rose-400';
            $glowColor = 'bg-rose-500';
            break;
        case 'nature':
            $bgGradient = 'from-slate-900 via-emerald-900 to-black';
            $accentColor = 'text-emerald-400';
            $glowColor = 'bg-emerald-500';
            break;
        case 'midnight':
            $bgGradient = 'from-gray-900 via-gray-950 to-black';
            $accentColor = 'text-gray-400';
            $glowColor = 'bg-white';
            break;
        default: 
            $bgGradient = 'from-gray-900 via-emerald-950 to-black';
            $accentColor = 'text-emerald-400';
            $glowColor = 'bg-emerald-500';
    }

    // Custom Background Image
    $customStyle = "";
    $hasCustomBg = false;
    if(isset($appearance['background_type']) && $appearance['background_type'] === 'image' && !empty($appearance['background_image_path'])) {
        $imgUrl = asset('storage/' . $appearance['background_image_path']);
        $customStyle = "background-image: url('$imgUrl'); background-size: cover; background-position: center;";
        $hasCustomBg = true;
    }

    // --- PISAHKAN LINK ---
    // 1. Social Media (Tampilan Ikon)
    $socialLinks = $page->links->filter(function($link) {
        return isset($link->settings['display_as']) && $link->settings['display_as'] === 'social';
    });
    
    // 2. Main Buttons (Tampilan Tombol Besar)
    $buttonLinks = $page->links->filter(function($link) {
        return !isset($link->settings['display_as']) || $link->settings['display_as'] === 'button';
    });
@endphp

<body class="antialiased min-h-screen text-white bg-black selection:bg-white/20 overflow-x-hidden">

    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br {{ $bgGradient }} {{ $hasCustomBg ? '' : 'animate-breathe' }}" style="{{ $customStyle }}"></div>
        
        @if($hasCustomBg)
            <div class="absolute inset-0 bg-black/60 backdrop-blur-[3px]"></div>
        @else
            <div class="absolute top-[-10%] left-1/2 -translate-x-1/2 w-[600px] h-[600px] {{ $glowColor }} opacity-20 blur-[120px] rounded-full pointer-events-none"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] {{ $glowColor }} opacity-10 blur-[100px] rounded-full pointer-events-none"></div>
            <div class="absolute inset-0 bg-noise mix-blend-overlay pointer-events-none"></div>
        @endif
    </div>

    <div class="relative w-full max-w-lg mx-auto min-h-screen px-6 py-16 flex flex-col items-center">

        <div class="w-full flex flex-col items-center text-center mb-8 reveal-up" style="animation-delay: 100ms;">
            
            <div class="relative group cursor-default mb-3">
                <div class="absolute -inset-1 rounded-full bg-gradient-to-tr from-white/20 to-transparent blur-sm opacity-70 group-hover:opacity-100 transition duration-700"></div>
                
                <div class="relative w-20 h-20 rounded-full border-0 border-white/10 overflow-hidden shadow-2xl bg-gray-800">
                    @if($page->avatar_path)
                        <img src="{{ asset('storage/' . $page->avatar_path) }}" class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110">
                    @else
                        @php
                            $words = preg_split("/\s+/", $page->title);
                            $initials = '';
                            if (count($words) >= 2) {
                                $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                            } 
                            else {
                                $initials = strtoupper(substr($page->title, 0, 1));
                            }
                        @endphp

                        <div class="w-full h-full flex items-center justify-center text-3xl font-bold text-white/90 bg-white/5 backdrop-blur-md">
                            {{ $initials }}
                        </div>
                    @endif
                </div>
            </div>

            <h1 class="text-2xl font-black text-white tracking-tight drop-shadow-lg">
                {{ $page->title }}
            </h1>

            @if($page->bio)
                <div class="relative px-6 py-2 backdrop-blur-sm max-w-sm">
                    <p class="text-sm text-white/80 font-medium leading-relaxed">
                        {{ $page->bio }}
                    </p>
                </div>
            @endif
        </div>

        @if($socialLinks->isNotEmpty())
            <div class="flex flex-wrap justify-center gap-4 mb-10 w-full reveal-up" style="animation-delay: 200ms;">
                @foreach($socialLinks as $link)
                    <a href="{{ route('public.redirect', $link->short_code) }}" target="_blank" 
                       class="group relative flex items-center justify-center w-12 h-12 rounded-full bg-white/5 hover:bg-white/20 border border-white/10 hover:border-white/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-{{ $accentColor }}/20 backdrop-blur-md"
                       title="{{ $link->title }}">
                        
                        @if(isset($link->settings['icon']) && $link->settings['icon'])
                            <i class="{{ $link->settings['icon'] }} text-2xl text-white/70 group-hover:text-white transition-colors"></i>
                        @else
                            <svg class="w-6 h-6 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        @endif
                        
                        <span class="absolute -bottom-8 opacity-0 group-hover:opacity-100 transition-opacity text-[10px] font-bold text-white bg-black/80 px-2 py-1 rounded whitespace-nowrap pointer-events-none">
                            {{ $link->title }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="w-full space-y-4 flex-1 pb-12">
            @foreach($buttonLinks as $index => $link)
                <a href="{{ route('public.redirect', $link->short_code) }}" target="_blank"
                   class="group relative block w-full reveal-up active:scale-[0.98] transition-transform duration-100"
                   style="animation-delay: {{ 300 + ($index * 100) }}ms;">
                   
                   <div class="relative bg-white rounded-2xl p-2 flex items-center shadow-xl shadow-black/10 transition-all duration-300 group-hover:shadow-2xl group-hover:-translate-y-0.5 overflow-hidden">
                        
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-50 to-white opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        <div class="relative z-10 w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center shrink-0 transition-colors group-hover:bg-black group-hover:text-white">
                            @if(isset($link->settings['icon']) && $link->settings['icon'])
                                <i class="{{ $link->settings['icon'] }} text-xl"></i>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            @endif
                        </div>

                        <div class="relative z-10 flex-1 px-4 text-center">
                            <h3 class="font-bold text-gray-900 text-base tracking-wide truncate group-hover:text-black transition-colors">
                                {{ $link->title }}
                            </h3>
                        </div>

                        <div class="relative z-10 w-8 flex justify-end pr-2">
                            <div class="text-gray-300 transform transition-all duration-300 group-hover:text-black group-hover:translate-x-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                   </div>
                </a>
            @endforeach

            @if($buttonLinks->isEmpty() && $socialLinks->isEmpty())
                <div class="text-center py-12 rounded-2xl border border-dashed border-white/20 bg-white/5 text-white/40 reveal-up">
                    <p class="text-sm font-medium">Halaman ini belum memiliki konten.</p>
                </div>
            @endif
        </div>

        <div class="mt-auto text-center reveal-up opacity-0" style="animation-delay: 1s; animation-fill-mode: forwards;">
            <a href="/" class="group inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/5 transition-all backdrop-blur-md">
                <span class="w-1.5 h-1.5 rounded-full bg-white group-hover:{{ $glowColor }} transition-colors"></span>
                <span class="text-[10px] font-bold text-white/50 group-hover:text-white uppercase tracking-widest transition-colors">
                    e-Link
                </span>
            </a>
        </div>

    </div>
</body>
</html>