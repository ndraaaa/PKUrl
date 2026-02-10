<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-gray-900/50 backdrop-blur-sm md:hidden">
</div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 shadow-xl md:shadow-none flex flex-col">

    <div class="flex items-center justify-center h-16 border-b border-gray-100 dark:border-gray-800">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" 
                alt="Logo E-Link" 
                class="w-8 h-8 object-contain shadow-lg shadow-emerald-500/30 rounded-lg">
            
            <span class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">E-Link</span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 no-scrollbar">

        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">
            Overview
        </p>

        <a href="{{ route('dashboard') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-colors group
           {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('dashboard') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">
            Management
        </p>

        <a href="{{ route('pages.index') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-colors group
           {{ request()->routeIs('pages.*') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('pages.*') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                </path>
            </svg>
            <span class="font-medium">Halaman Bio</span>
        </a>

        <a href="{{ route('shortlinks.index') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-colors group
           {{ request()->routeIs('shortlinks.*') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('shortlinks.*') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                </path>
            </svg>
            <span class="font-medium">Shortlinks</span>
        </a>

        @if (Auth::user()->role === 'admin')
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">
                Administrator
            </p>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center px-3 py-2.5 rounded-lg transition-colors group
               {{ request()->routeIs('admin.users*') ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200' }}">
                <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.users*') ? 'text-red-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <span class="font-medium">Manajemen User</span>
            </a>

            <a href="{{ route('admin.links.index') }}"
                class="flex items-center px-3 py-2.5 rounded-lg transition-colors group
               {{ request()->routeIs('admin.links*') ? 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200' }}">
                <svg class="w-5 h-5 mr-3 transition-colors {{ request()->routeIs('admin.links*') ? 'text-red-600' : 'text-gray-400 group-hover:text-gray-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span class="font-medium">Manajemen Link</span>
            </a>
        @endif

    </div>

    <div class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/50">

        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tema</span>
            <button x-data="{
                darkMode: localStorage.getItem('theme') === 'dark',
                toggle() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    if (this.darkMode) document.documentElement.classList.add('dark');
                    else document.documentElement.classList.remove('dark');
                }
            }" @click="toggle()"
                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                :class="darkMode ? 'bg-emerald-600' : 'bg-gray-200'">
                <span class="sr-only">Switch theme</span>
                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                    :class="darkMode ? 'translate-x-6' : 'translate-x-1'">
                </span>
            </button>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                @if (Auth::user()->profile)
                    <img class="h-9 w-9 rounded-full object-cover border border-gray-200 dark:border-gray-600"
                        src="{{ asset('storage/' . Auth::user()->profile) }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div
                        class="h-9 w-9 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-700 dark:text-emerald-300 font-bold text-xs">
                        {{ substr(Auth::user()->username, 0, 1) }}
                    </div>
                @endif
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                    {{ Auth::user()->username }}
                </p>
                {{-- <a href="{{ route('profile.edit') }}"
                    class="text-xs text-gray-500 hover:text-emerald-600 truncate block">
                    Edit Profil
                </a> --}}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                    title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
