<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Ringkasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 {{ Auth::user()->role === 'admin' ? 'lg:grid-cols-4' : 'lg:grid-cols-3' }} gap-6">
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Klik</div>
                            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalClicks) }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Link Pendek</div>
                            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalShortlinks }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-pink-500">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Tombol Bio</div>
                                <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalBiolinks }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->role === 'admin')
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total User</div>
                                    <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $totalUsers }}</div>
                                </div>
                            </div>
                            <a href="{{ route('admin.users') }}" class="text-xs text-yellow-500 hover:underline">Kelola &rarr;</a>
                        </div>
                    </div>
                @endif

            </div>

            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-2">Buat Link Pendek Instan</h3>
                <p class="text-indigo-100 text-sm mb-4">Tempel link panjang Anda di sini, kami akan menyingkatnya secepat kilat.</p>
                
                <form action="{{ route('links.store') }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                    @csrf
                    <input type="url" name="original_url" placeholder="https://..." class="flex-1 rounded-md border-none text-gray-900 focus:ring-2 focus:ring-yellow-400 px-4 py-3" required>
                    <button type="submit" class="bg-yellow-400 text-gray-900 font-bold py-3 px-6 rounded-md hover:bg-yellow-300 transition">
                        Singkat!
                    </button>
                </form>
                @if ($errors->any())
                    <div class="mt-2 text-sm text-red-200 bg-red-900/20 p-2 rounded">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Link Paling Populer</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Judul / URL</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tipe</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total Klik</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Link</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($popularLinks as $link)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                        {{ $link->title ?? Str::limit($link->original_url, 30) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($link->type == 'biolink')
                                            <span class="px-2 py-1 text-xs rounded-full bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200">Bio</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Short</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900 dark:text-gray-100">
                                        {{ number_format($link->click_count) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right">
                                        <a href="{{ url($link->short_code) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                            /{{ $link->short_code }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                        Belum ada data link.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>