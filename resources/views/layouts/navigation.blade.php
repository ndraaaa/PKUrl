<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-emerald-900 lg:translate-x-0 lg:static lg:inset-0 flex flex-col h-full">
    
    <div class="flex items-center justify-center h-16 bg-emerald-950 border-b border-emerald-800 shadow-md flex-shrink-0">
        <div class="flex items-center text-white font-bold text-xl tracking-wider">
            <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center mr-2 shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            </div>
            LinkApp.
        </div>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
    
        <a href="{{ route('dashboard') }}" 
        class="flex items-center px-4 py-3 rounded-xl transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/50' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span class="font-medium">Dashboard Halaman</span>
        </a>

        <a href="{{ route('shortlinks.index') }}" 
        class="flex items-center px-4 py-3 rounded-xl transition-colors duration-200 {{ request()->routeIs('shortlinks.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/50' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            <span class="font-medium">Shortlink</span>
        </a>

        @if(Auth::user()->role === 'admin')
            <div class="pt-4 pb-2">
                <p class="px-4 text-[10px] font-bold text-emerald-400 uppercase tracking-wider">
                    Administrator
                </p>
            </div>

            <a href="{{ route('admin.users') }}" 
            class="flex items-center px-4 py-3 rounded-xl transition-colors duration-200 {{ request()->routeIs('admin.users*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/50' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="font-medium">Manajemen User</span>
            </a>
        @endif
        <div class="border-t border-emerald-800 my-4"></div>

        @if(isset($page) && $page->id)
            <div class="pt-4 pb-2">
                <p class="px-4 text-[10px] font-bold text-emerald-400 uppercase tracking-wider">
                    Aktif: {{ \Illuminate\Support\Str::limit($page->title, 15) }}
                </p>
            </div>
            @endif

    </nav>
    
    <div class="p-4 bg-emerald-950/50 text-center">
        <p class="text-xs text-emerald-500 font-mono">v1.2 LinkApp</p>
    </div>

</div>