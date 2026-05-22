<style>
    /* ========================================== */
    /* DESKTOP ONLY (Layar PC/Tablet Besar)       */
    /* ========================================== */
    @media (min-width: 768px) {

        /* Mengunci ukuran sidebar secara instan sebelum Javascript dimuat */
        html.sidebar-mini #app-sidebar {
            width: 5rem !important;
        }

        html:not(.sidebar-mini) #app-sidebar {
            width: 16rem !important;
        }

        /* Memanipulasi elemen di dalam sidebar saat mengecil */
        html.sidebar-mini .sb-hide {
            display: none !important;
        }

        /* Menggeser ikon ke tengah secara horizontal */
        html.sidebar-mini .sb-item-center {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Mengurangi padding samping pada container utama */
        html.sidebar-mini .sb-container-p {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        html.sidebar-mini .sb-icon-mr {
            margin-right: 0 !important;
        }

        html.sidebar-mini .sb-rotate {
            transform: translateY(-50%) rotate(180deg) !important;
        }

        /* Mengatur garis pemisah dan profil */
        html.sidebar-mini .sb-divider {
            display: block !important;
        }

        html:not(.sidebar-mini) .sb-divider {
            display: none !important;
        }

        html.sidebar-mini .sb-profile-wide {
            display: none !important;
        }

        html.sidebar-mini .sb-profile-mini {
            display: flex !important;
        }

        html:not(.sidebar-mini) .sb-profile-mini {
            display: none !important;
        }
    }

    /* ========================================== */
    /* MOBILE ONLY (Layar HP)                     */
    /* ========================================== */
    @media (max-width: 767px) {
        #app-sidebar {
            width: 16rem !important;
        }

        .sb-divider {
            display: none !important;
        }
    }
</style>

<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-gray-900/50 backdrop-blur-sm md:hidden">
</div>

<aside id="app-sidebar" x-data="{
    isCollapsed: document.documentElement.classList.contains('sidebar-mini'),
    darkMode: localStorage.getItem('theme') === 'dark',
    toggleSidebar() {
        this.isCollapsed = !this.isCollapsed;
        localStorage.setItem('sidebarCollapsed', this.isCollapsed);
        document.documentElement.classList.toggle('sidebar-mini', this.isCollapsed);
    },
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', this.darkMode);
    }
}" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 bg-[#006738] border-r border-[#004f2b] transition-all duration-300 ease-in-out md:translate-x-0 md:relative md:inset-0 shadow-xl md:shadow-none flex flex-col font-sans">

    <button @click="toggleSidebar()"
        class="absolute -right-3 top-8 -translate-y-1/2 z-50 hidden md:flex items-center justify-center w-6 h-6 rounded-full bg-white border border-gray-200 text-[#006738] hover:bg-emerald-50 shadow-md transition-transform duration-300 sb-rotate"
        title="Toggle Sidebar">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <div
        class="flex items-center h-16 border-b border-white/10 bg-[#005f34] transition-all duration-300 px-4 sb-item-center">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 w-full sb-item-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo E-Link"
                class="w-9 h-9 flex-shrink-0 object-contain shadow-md shadow-black/20 bg-white rounded-lg p-0.5">

            <div class="flex flex-col leading-tight whitespace-nowrap overflow-hidden sb-hide">
                <span class="text-xl font-black text-white tracking-tight drop-shadow-sm">e-Link</span>
                <span class="text-[10px] font-semibold text-emerald-100 uppercase tracking-wider">
                    RS PKU Aisyiyah Boyolali
                </span>
            </div>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-4 space-y-1 no-scrollbar flex flex-col px-3 sb-container-p">

        <p
            class="px-3 text-xs font-bold text-emerald-200/80 uppercase tracking-wider font-mono whitespace-nowrap sb-hide">
            Overview</p>
        <div class="h-px bg-white/20 w-8 mx-auto my-2 rounded-full sb-divider"></div>

        <a href="{{ route('dashboard') }}" title="Dashboard"
            class="flex items-center py-2.5 rounded-lg transition-all duration-200 group px-3 hover:translate-x-1 sb-item-center
            {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white shadow-inner' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors mr-3 sb-icon-mr {{ request()->routeIs('dashboard') ? 'text-white' : 'text-emerald-200 group-hover:text-white' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="font-semibold tracking-wide whitespace-nowrap sb-hide">Dashboard</span>
        </a>

        <p
            class="px-3 text-xs font-bold text-emerald-200/80 uppercase tracking-wider mb-2 mt-6 font-mono whitespace-nowrap sb-hide">
            Management</p>
        <div class="h-px bg-white/20 w-8 mx-auto my-4 rounded-full sb-divider"></div>

        <a href="{{ route('pages.index') }}" title="Halaman Bio"
            class="flex items-center py-2.5 rounded-lg transition-all duration-200 group px-3 hover:translate-x-1 sb-item-center
            {{ request()->routeIs('pages.*') ? 'bg-white/20 text-white shadow-inner' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors mr-3 sb-icon-mr {{ request()->routeIs('pages.*') ? 'text-white' : 'text-emerald-200 group-hover:text-white' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                </path>
            </svg>
            <span class="font-semibold tracking-wide whitespace-nowrap sb-hide">Halaman Bio</span>
        </a>

        <a href="{{ route('shortlinks.index') }}" title="Shortlinks"
            class="flex items-center py-2.5 rounded-lg transition-all duration-200 group px-3 hover:translate-x-1 sb-item-center
            {{ request()->routeIs('shortlinks.*') ? 'bg-white/20 text-white shadow-inner' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0 transition-colors mr-3 sb-icon-mr {{ request()->routeIs('shortlinks.*') ? 'text-white' : 'text-emerald-200 group-hover:text-white' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                </path>
            </svg>
            <span class="font-semibold tracking-wide whitespace-nowrap sb-hide">Shortlinks</span>
        </a>

        @if (Auth::user()->role === 'admin')
            <p
                class="px-3 text-xs font-bold text-emerald-200/80 uppercase tracking-wider mb-2 mt-6 font-mono whitespace-nowrap sb-hide">
                Administrator</p>
            <div class="h-px bg-white/20 w-8 mx-auto my-4 rounded-full sb-divider"></div>

            <a href="{{ route('admin.advertisements.index') }}" title="Iklan Splash"
                class="flex items-center py-2.5 rounded-lg transition-all duration-200 group px-3 hover:translate-x-1 sb-item-center
                {{ request()->routeIs('admin.advertisements.*') ? 'bg-rose-600 text-white shadow-md' : 'text-rose-200 hover:bg-rose-600 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0 transition-colors mr-3 sb-icon-mr {{ request()->routeIs('admin.advertisements.*') ? 'text-white' : 'text-rose-300 group-hover:text-white' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                    </path>
                </svg>
                <span class="font-semibold tracking-wide whitespace-nowrap sb-hide">Manajemen Iklan</span>
            </a>

            <a href="{{ route('admin.users.index') }}" title="Manajemen User"
                class="flex items-center py-2.5 rounded-lg transition-all duration-200 group px-3 hover:translate-x-1 sb-item-center
                {{ request()->routeIs('admin.users*') ? 'bg-rose-600 text-white shadow-md' : 'text-rose-200 hover:bg-rose-600 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0 transition-colors mr-3 sb-icon-mr {{ request()->routeIs('admin.users*') ? 'text-white' : 'text-rose-300 group-hover:text-white' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <span class="font-semibold tracking-wide whitespace-nowrap sb-hide">Manajemen User</span>
            </a>

            <a href="{{ route('admin.links.index') }}" title="Manajemen Link"
                class="flex items-center py-2.5 rounded-lg transition-all duration-200 group px-3 hover:translate-x-1 sb-item-center
                {{ request()->routeIs('admin.links*') ? 'bg-rose-600 text-white shadow-md' : 'text-rose-200 hover:bg-rose-600 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0 transition-colors mr-3 sb-icon-mr {{ request()->routeIs('admin.links*') ? 'text-white' : 'text-rose-300 group-hover:text-white' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span class="font-semibold tracking-wide whitespace-nowrap sb-hide">Manajemen Link</span>
            </a>
        @endif
    </div>

    <div class="border-t border-white/10 bg-[#005830] w-full" x-data="{ profileOpen: false }">

        <div class="p-4 flex-col gap-4 sb-profile-wide" style="display: flex;">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-200 uppercase tracking-wider">Mode Gelap</span>
                <button @click="toggleTheme()"
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-[#005830]"
                    :class="darkMode ? 'bg-emerald-500' : 'bg-black/40'">
                    <span
                        class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                        :class="darkMode ? 'translate-x-5' : 'translate-x-0'">
                        <span
                            class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                            :class="darkMode ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'"><svg
                                class="h-3 w-3 text-[#006738]" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" />
                            </svg></span>
                        <span
                            class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                            :class="darkMode ? 'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100'"><svg
                                class="h-3 w-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                            </svg></span>
                    </span>
                </button>
            </div>

            <div class="relative flex items-center gap-3" x-data="{ editMenuOpen: false }">
                <button @click="editMenuOpen = !editMenuOpen" @click.away="editMenuOpen = false"
                    class="flex-shrink-0 focus:outline-none transform transition-all duration-200 hover:scale-105"
                    :class="editMenuOpen ? 'ring-2 ring-white ring-offset-2 ring-offset-[#005830] rounded-full scale-105' : ''"
                    title="Ubah Avatar">
                    @if (Auth::user()->profile)
                        <img class="h-10 w-10 rounded-full object-cover border-[3px] border-white/30 shadow-sm"
                            src="{{ asset('storage/' . Auth::user()->profile) }}" alt="{{ Auth::user()->name }}" />
                    @else
                        <div
                            class="h-10 w-10 rounded-full bg-emerald-50 border-2 border-white/50 flex items-center justify-center text-emerald-900 font-black text-sm shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}</div>
                    @endif
                </button>

                <div x-show="editMenuOpen" x-cloak x-transition
                    class="absolute bottom-full left-0 mb-3 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl ring-1 ring-black/5 overflow-hidden z-50 origin-bottom-left">
                    <div class="p-1">
                        <form action="{{ route('profile.avatar.update') }}" method="POST"
                            enctype="multipart/form-data" class="m-0">
                            @csrf
                            <input type="file" name="profile" class="hidden" x-ref="avatarInput"
                                accept="image/jpeg,image/png,image/jpg" @change="$el.form.submit()">
                            <button type="button" @click="$refs.avatarInput.click()"
                                class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Unggah Profile Baru
                            </button>
                        </form>
                    </div>
                </div>

                <div class="flex-1 min-w-0 pb-1 whitespace-nowrap overflow-hidden">
                    <p class="text-sm font-bold text-white truncate tracking-wide">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-emerald-200 truncate flex items-center gap-1.5 mt-0.5 font-medium"><i
                            class="fa-solid fa-at text-[10px] opacity-80"></i> {{ Auth::user()->username }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Keluar"
                        class="p-2 text-rose-300 hover:text-white hover:bg-red-600 rounded-xl transition-all duration-200 shadow-sm hover:shadow-red-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="p-2 py-4 justify-center relative sb-profile-mini" style="display: none;">
            <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false"
                class="flex-shrink-0 focus:outline-none transform transition-all duration-200 hover:scale-105"
                :class="profileOpen ? 'ring-2 ring-white ring-offset-2 ring-offset-[#005830] rounded-full scale-105' : ''"
                title="Menu Profil">
                @if (Auth::user()->profile)
                    <img class="h-10 w-10 rounded-full object-cover border-[3px] border-white/30 shadow-sm"
                        src="{{ asset('storage/' . Auth::user()->profile) }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div
                        class="h-10 w-10 rounded-full bg-emerald-50 border-2 border-white/50 flex items-center justify-center text-emerald-900 font-black text-sm shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}</div>
                @endif
            </button>

            <div x-show="profileOpen" x-cloak x-transition
                class="absolute bottom-full left-14 mb-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl ring-1 ring-black/5 overflow-hidden z-50 origin-bottom-left">
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p
                        class="text-xs text-gray-500 dark:text-gray-400 truncate flex items-center gap-1 mt-0.5 font-medium">
                        <i class="fa-solid fa-at text-[10px]"></i> {{ Auth::user()->username }}</p>
                </div>
                <div class="p-1 border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data"
                        class="m-0">
                        @csrf
                        <input type="file" name="profile" class="hidden" x-ref="avatarInputMini"
                            accept="image/jpeg,image/png,image/jpg" @change="$el.form.submit()">
                        <button type="button" @click="$refs.avatarInputMini.click()"
                            class="w-full flex items-center gap-3 px-3 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Unggah Profile Baru
                        </button>
                    </form>
                </div>
                <div
                    class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-white dark:bg-gray-800">
                    <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Mode
                        Gelap</span>
                    <button @click="toggleTheme()"
                        class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1"
                        :class="darkMode ? 'bg-emerald-500' : 'bg-gray-300'">
                        <span
                            class="pointer-events-none relative inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            :class="darkMode ? 'translate-x-4' : 'translate-x-0'"></span>
                    </button>
                </div>
                <div class="p-2 bg-white dark:bg-gray-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors group font-semibold">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>
