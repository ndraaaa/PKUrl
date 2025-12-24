<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Tautan Pendek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900 dark:text-green-200 dark:border-green-700" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Buat Link Baru') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Masukkan URL panjang Anda untuk mendapatkan tautan pendek.
                    </p>
                </header>

                <form method="post" action="{{ route('links.store') }}" class="mt-6 space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        
                        <div class="md:col-span-8">
                            <x-input-label for="original_url" :value="__('URL Panjang')" />
                            <x-text-input id="original_url" name="original_url" type="url" class="mt-1 block w-full" 
                                placeholder="https://contoh-website.com/..." required />
                            <x-input-error class="mt-2" :messages="$errors->get('original_url')" />
                        </div>

                        <div class="md:col-span-4">
                            <x-input-label for="custom_code" :value="__('Custom Code (Opsional)')" />
                            <div class="flex mt-1">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                                    /
                                </span>
                                <x-text-input id="custom_code" name="custom_code" type="text" class="block w-full rounded-l-none" 
                                    placeholder="my-custom-link" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('custom_code')" />
                        </div>

                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Singkat & Simpan') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Riwayat Link</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Short Link</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">URL Asli</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Klik</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($links as $link)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-semibold">
                                            {{ url('/') }}/{{ $link->short_code }}
                                        </span>
                                        <button 
                                            @click="navigator.clipboard.writeText('{{ url('/') }}/{{ $link->short_code }}'); alert('Dicopy!')" 
                                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                                            title="Copy Link">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        </button>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $link->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-gray-100 truncate w-64" title="{{ $link->original_url }}">
                                        {{ $link->original_url }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-300">
                                    {{ $link->click_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus link ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada link yang dibuat.
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