<div
    class="flex flex-col bg-white dark:bg-gray-800 h-screen overflow-y-auto border-r border-gray-200 dark:border-gray-700">
    <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-gray-700 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="block h-8 w-auto fill-current text-gray-800 dark:text-gray-200" />
            <span class="ml-3 font-bold text-xl text-gray-700 dark:text-gray-200">PKUrl</span>
        </a>
    </div>

    <div class="p-4 space-y-2 flex flex-col flex-1">

        <a href="{{ route('dashboard') }}"
            class="flex items-center py-2.5 px-4 rounded transition duration-200 
           {{ request()->routeIs('dashboard')
               ? 'bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white'
               : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('bio.index') }}"
            class="flex items-center py-2.5 px-4 rounded transition duration-200 
           {{ request()->routeIs('bio.*')
               ? 'bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white'
               : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
            Halaman Bio
        </a>

        <a href="{{ route('links.index') }}"
            class="flex items-center py-2.5 px-4 rounded transition duration-200 
           {{ request()->routeIs('links.*')
               ? 'bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white'
               : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                </path>
            </svg>
            Kelola Link
        </a>

        @if (Auth::user()->role === 'admin')
            <div class="mt-4 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Administrator
            </div>

            <a href="{{ route('admin.users') }}"
                class="flex items-center py-2.5 px-4 rounded transition duration-200 
            {{ request()->routeIs('admin.users')
                ? 'bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white'
                : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Daftar User
            </a>
        @endif
    </div>
</div>
