<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ $page->title }} | LinkApp</title>
    <meta name="description" content="Kunjungi link bio dari {{ $page->title }}.">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .animate-gradient { background-size: 400% 400%; animation: gradient 15s ease infinite; }
        @keyframes gradient { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .fade-in-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(20px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        
        .text-shadow-safe {
            text-shadow: 0 2px 4px rgba(0,0,0,0.4), 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .glass-card {
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Class untuk handle blur background */
        .bg-blur-subtle {
            filter: blur(4px) brightness(0.9); /* Nilai 4px memberikan efek fokus yang elegan tanpa menghilangkan bentuk objek di belakang */
            transform: scale(1.05); /* Sedikit scale up untuk mencegah pinggiran putih akibat efek blur */
        }
    </style>
</head>

@php
    $bgClass      = 'bg-gradient-to-br from-gray-900 via-emerald-900 to-gray-900';
    $ringClass    = 'from-emerald-400 to-teal-400';
    $btnHover     = 'group-hover:bg-emerald-500 group-hover:text-white';
    $btnIconBg    = 'bg-emerald-500/20 text-emerald-300';
    $badgeClass   = 'bg-emerald-900/50 border-emerald-500/30 text-emerald-200';

    switch($page->theme) {
        case 'ocean':
            $bgClass      = 'bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900';
            $ringClass    = 'from-blue-400 to-cyan-400';
            $btnHover     = 'group-hover:bg-blue-600 group-hover:text-white';
            $btnIconBg    = 'bg-blue-500/20 text-blue-300';
            $badgeClass   = 'bg-blue-900/50 border-blue-500/30 text-blue-200';
            break;
        case 'sunset':
            $bgClass      = 'bg-gradient-to-br from-purple-900 via-orange-800 to-red-900';
            $ringClass    = 'from-orange-400 to-pink-500';
            $btnHover     = 'group-hover:bg-orange-500 group-hover:text-white';
            $btnIconBg    = 'bg-orange-500/20 text-orange-300';
            $badgeClass   = 'bg-orange-900/50 border-orange-500/30 text-orange-200';
            break;
        case 'midnight':
            $bgClass      = 'bg-gray-950'; 
            $ringClass    = 'from-gray-100 to-gray-400';
            $btnHover     = 'group-hover:bg-white group-hover:text-black';
            $btnIconBg    = 'bg-white/10 text-gray-300';
            $badgeClass   = 'bg-gray-800 border-gray-600 text-gray-300';
            break;
    }

    $customBgStyle = "";
    if($page->background_image) {
        $bgUrl = asset('storage/' . $page->background_image);
        $customBgStyle = "background-image: url('$bgUrl'); background-size: cover; background-position: center; background-attachment: fixed;";
    }
@endphp

<body class="antialiased min-h-screen text-white overflow-x-hidden bg-black">

    <div class="fixed inset-0 z-0 {{ $bgClass }} {{ ($page->theme != 'midnight' && !$page->background_image) ? 'animate-gradient' : '' }} {{ $page->background_image ? 'bg-blur-subtle' : '' }}"
         style="{{ $customBgStyle }}">
         
         @if($page->background_image)
            <div class="absolute inset-0 bg-black/40"></div>
         @endif
    </div>
    
    <div class="fixed inset-0 z-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'1\'/%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative z-10 w-full max-w-lg mx-auto min-h-screen px-6 py-12 flex flex-col items-center">

        <div class="absolute top-6 right-6 fade-in-up">
            <button onclick="navigator.share({title: '{{ $page->title }}', url: window.location.href})" 
                class="p-3 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white hover:bg-white/20 transition-all shadow-xl active:scale-90">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
            </button>
        </div>

        <div class="flex flex-col items-center text-center mb-10 w-full fade-in-up" style="animation-delay: 100ms;">
            <div class="relative mb-6 group">
                <div class="absolute -inset-1 bg-gradient-to-r {{ $ringClass }} rounded-full blur opacity-75 group-hover:opacity-100 transition duration-1000"></div>
                
                @if($page->avatar)
                    <img class="relative w-28 h-28 rounded-full object-cover border-4 border-gray-900 shadow-2xl" src="{{ asset('storage/' . $page->avatar) }}" alt="{{ $page->title }}">
                @else
                    <div class="relative w-28 h-28 rounded-full bg-gray-800 border-4 border-gray-900 flex items-center justify-center text-3xl font-bold shadow-2xl">
                        {{ substr($page->title, 0, 1) }}
                    </div>
                @endif
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-white mb-2 text-shadow-safe flex items-center justify-center gap-2">
                {{ $page->title }}
                @if($user->email_verified_at) 
                <div class="bg-blue-500 text-white p-0.5 rounded-full shadow-md" title="Verified Owner">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </div>
                @endif
            </h1>
            
            <p class="font-medium text-xs tracking-widest px-4 py-1.5 rounded-full border {{ $badgeClass }} shadow-lg">
                {{'@' .$page->handle }}
            </p>
        </div>

        <div class="w-full space-y-4 px-2">
            @forelse($links as $index => $link)
                <a href="{{ $link->original_url ?? $link->url }}" target="_blank" rel="noopener noreferrer"
                   class="block group relative w-full fade-in-up" 
                   style="animation-delay: {{ ($index + 2) * 100 }}ms;">
                   
                    <div class="absolute inset-0 glass-card rounded-2xl transition-all duration-300 group-hover:scale-[1.02] group-hover:bg-white/10 group-hover:border-white/40"></div>
                    
                    <div class="relative flex items-center justify-between px-5 py-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center transition-colors duration-300 {{ $btnIconBg }} {{ $btnHover }}">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>

                        <div class="flex-1 text-center px-2">
                            <span class="font-bold text-white tracking-wide text-shadow-safe">
                                {{ $link->title }}
                            </span>
                        </div>

                        <div class="w-6 text-white/20 group-hover:text-white group-hover:translate-x-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-10 px-6 glass-card rounded-2xl text-gray-400 fade-in-up">
                    <p class="text-sm">Belum ada tautan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-auto py-10 text-center fade-in-up" style="animation-delay: 800ms;">
            <a href="/" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-black/40 hover:bg-black/60 backdrop-blur-md transition text-[10px] font-bold text-white/50 hover:text-white uppercase tracking-widest border border-white/5">
                Dibuat dengan LinkApp
            </a>
        </div>
    </div>
</body>
</html>