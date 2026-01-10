<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Pengaturan Akun
                </h2>
                <p class="text-gray-500 dark:text-gray-400">Kelola informasi profil, keamanan, dan preferensi akun Anda.</p>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/3">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        
                        <div class="hidden md:flex items-center space-x-4 p-6 border-b border-gray-50 dark:border-gray-700">
                            <div class="h-12 w-12 rounded-full bg-gradient-to-tr from-emerald-400 to-emerald-600 flex items-center justify-center text-white text-lg font-bold shadow-md">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white leading-tight">{{ Auth::user()->name }}</h3>
                                <p class="text-xs text-gray-500 italic">Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                        
                        <nav class="flex md:flex-col p-2 md:p-4 overflow-x-auto md:overflow-x-visible items-center md:items-stretch space-x-2 md:space-x-0 md:space-y-1 no-scrollbar">
                            
                            <a href="#profile-info" class="flex-shrink-0 flex items-center px-4 py-2.5 text-sm font-medium text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl transition-all">
                                <svg class="mr-2 md:mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="whitespace-nowrap">Profil</span>
                            </a>

                            <a href="#password-update" class="flex-shrink-0 flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition-all">
                                <svg class="mr-2 md:mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                <span class="whitespace-nowrap">Keamanan</span>
                            </a>

                            <a href="#delete-account" class="flex-shrink-0 flex items-center px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 rounded-xl transition-all">
                                <svg class="mr-2 md:mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span class="whitespace-nowrap">Hapus Akun</span>
                            </a>

                        </nav>
                    </div>
                </div>

                <div class="w-full md:w-2/3 space-y-6">
                    <div id="profile-info" class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl transition-all hover:shadow-md">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div id="password-update" class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl transition-all hover:shadow-md">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div id="delete-account" class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-sm border border-red-100 dark:border-red-900/30 rounded-2xl transition-all hover:shadow-md">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        html { scroll-behavior: smooth; }
        :target { scroll-margin-top: 100px; }
    </style>
</x-app-layout>