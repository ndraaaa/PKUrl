<header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex justify-between items-center px-6 z-10">
    
    <div class="flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $header ?? '' }}
        </h2>
    </div>

    <div class="flex items-center space-x-4">
        
        <button 
            x-data="{ 
                darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) 
            }"
            x-init="$watch('darkMode', val => {
                localStorage.setItem('theme', val ? 'dark' : 'light');
                if (val) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            });
            if(darkMode) document.documentElement.classList.add('dark');"
            @click="darkMode = !darkMode"
            class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none transition-colors"
        >
            <svg x-show="darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>

            <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>

        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                    <div class="flex items-center">
                        
                        @if(Auth::user()->profile)
                            <img class="h-8 w-8 rounded-full object-cover mr-2 bg-white border border-gray-200 dark:border-gray-600" 
                                src="{{ asset('storage/' . Auth::user()->profile) }}" 
                                alt="{{ Auth::user()->name }}" />
                        @else
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-2 text-gray-600 font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <div>{{ Auth::user()->name }}</div>
                    </div>

                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>