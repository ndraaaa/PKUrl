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
                                    <div class="flex justify-end items-center space-x-3">
                                        
                                        <button x-data 
                                                @click="$dispatch('open-qr', { 
                                                    url: '{{ asset('storage/' . $link->qr_path) }}', 
                                                    downloadName: 'qr-{{ $link->short_code }}.svg' 
                                                })"
                                                class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200"
                                                title="Lihat QR Code">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 6h6v6H6V6zm12 0h6v6h-6V6zm-6 12h6v6h-6v-6z"></path></svg>
                                        </button>

                                        <form action="{{ route('links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus link ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition">Hapus</button>
                                        </form>
                                    </div>
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

    <div x-data="{ showQr: false, qrUrl: '', downloadName: '' }" 
         @open-qr.window="showQr = true; qrUrl = $event.detail.url; downloadName = $event.detail.downloadName"
         x-show="showQr" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm"
         style="display: none;"
         x-transition.opacity>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 w-full max-w-sm relative" @click.away="showQr = false">
            <button @click="showQr = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 text-center mb-4">QR Code</h3>
            
            <div class="flex justify-center mb-6 bg-white p-4 rounded-lg border border-gray-200">
                <template x-if="qrUrl && qrUrl.includes('storage/')">
                     <img :src="qrUrl" alt="QR Code" class="w-64 h-64 object-contain">
                </template>
                <template x-if="!qrUrl || !qrUrl.includes('storage/')">
                    <div class="text-center text-gray-500 py-10">
                        QR Code belum digenerate untuk link lama ini.<br>
                        <span class="text-xs text-red-500">Buat link baru untuk mengetes.</span>
                    </div>
                </template>
            </div>

            <div class="flex justify-center">
                <a :href="qrUrl" :download="downloadName" class="flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-full shadow transition font-semibold">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download File
                </a>
            </div>
        </div>
    </div>
</x-app-layout>