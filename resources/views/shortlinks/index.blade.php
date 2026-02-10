<x-app-layout title="Shortlink Manager" desc="Kelola tautan pendek Anda dengan mudah.">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="py-8" x-data="shortlinkHandler()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-md flex justify-between items-center transition-all">
                    <div class="flex items-center text-emerald-700">
                        <i class="fa-solid fa-check-circle mr-2"></i>
                        <span class="font-bold mr-1">Berhasil!</span>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">✕</button>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="bg-emerald-600 px-6 py-4 border-b border-emerald-500 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <i class="fa-solid fa-bolt mr-2"></i> Buat Link Baru
                    </h3>
                </div>
                <div class="p-6">
                    <form method="post" action="{{ route('shortlinks.store') }}" class="flex flex-col md:flex-row gap-4 items-start">
                        @csrf
                        
                        <div class="md:w-1/4 w-full">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1 ml-1">Judul (Opsional)</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Katalog ..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition">
                        </div>
                        
                        <div class="flex-1 w-full">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1 ml-1">URL Tujuan</label>
                            <input type="url" name="destination_url" value="{{ old('destination_url') }}" required placeholder="https://website-panjang.com/..."
                                class="w-full px-4 py-3 rounded-xl border @error('destination_url') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition">
                            @error('destination_url')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:w-1/4 w-full">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1 ml-1">Custom Alias</label>
                            <div class="flex rounded-xl border @error('custom_code') border-red-500 @else border-gray-200 @enderror dark:border-gray-600 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500">
                                <span class="bg-gray-50 dark:bg-gray-800 px-3 py-3 text-gray-500 text-sm border-r border-gray-200 dark:border-gray-600 select-none">/</span>
                                <input type="text" name="custom_code" value="{{ old('custom_code') }}" placeholder="code-unik"
                                    class="w-full border-0 py-3 px-3 bg-transparent dark:text-white focus:ring-0">
                            </div>
                            @error('custom_code')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-600/20 transition transform hover:-translate-y-0.5 whitespace-nowrap h-[50px] flex items-center justify-center gap-2 mt-auto">
                            <i class="fa-solid fa-link"></i> Singkat!
                        </button>
                    </form>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 flex items-center shrink-0">
                    <span class="w-1 h-6 bg-emerald-500 rounded-full mr-3"></span>
                    Daftar Link
                    <svg x-show="isLoading" class="animate-spin ml-3 h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </h3>
                
                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-72">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </div>
                        <input type="text" x-model="search" @input.debounce.500ms="fetchResults()"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm transition outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            placeholder="Cari judul atau URL...">
                    </div>
                    <div class="relative w-full md:w-48">
                        <input type="date" x-model="date" @change="fetchResults()"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm transition outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 text-gray-500">
                    </div>
                </div>
            </div>

            <div x-show="selectedLinks.length > 0" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl p-3 mb-4 flex justify-between items-center"
                style="display: none;">
                
                <div class="flex items-center gap-2 text-emerald-800 dark:text-emerald-300 text-sm font-medium px-2">
                    <i class="fa-solid fa-check-double"></i>
                    <span x-text="selectedLinks.length + ' item dipilih'"></span>
                </div>

                <button @click="bulkDelete()" 
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-trash"></i> Hapus Terpilih
                </button>
            </div>

            <div id="links-container">
                @if ($links->count() > 0)
                    <div class="hidden md:block bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-center w-10">
                                        <input type="checkbox" @click="toggleAll()" x-model="allSelected" 
                                            class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 cursor-pointer">
                                    </th>

                                    <th @click="sortBy('short_code')" 
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer group hover:bg-gray-100 dark:hover:bg-gray-700 transition select-none">
                                        <div class="flex items-center gap-1">
                                            Short Link
                                            <i class="fa-solid" 
                                            :class="sortCol === 'short_code' 
                                                    ? (sortDir === 'asc' ? 'fa-sort-up text-emerald-500' : 'fa-sort-down text-emerald-500') 
                                                    : 'fa-sort text-gray-300 opacity-0 group-hover:opacity-100'"></i>
                                        </div>
                                    </th>

                                    <th @click="sortBy('destination_url')" 
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer group hover:bg-gray-100 dark:hover:bg-gray-700 transition select-none">
                                        <div class="flex items-center gap-1">
                                            Tujuan
                                            <i class="fa-solid" 
                                            :class="sortCol === 'destination_url' 
                                                    ? (sortDir === 'asc' ? 'fa-sort-up text-emerald-500' : 'fa-sort-down text-emerald-500') 
                                                    : 'fa-sort text-gray-300 opacity-0 group-hover:opacity-100'"></i>
                                        </div>
                                    </th>

                                    <th @click="sortBy('clicks')" 
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer group hover:bg-gray-100 dark:hover:bg-gray-700 transition select-none">
                                        <div class="flex items-center justify-center gap-1">
                                            Klik
                                            <i class="fa-solid" 
                                            :class="sortCol === 'clicks' 
                                                    ? (sortDir === 'asc' ? 'fa-sort-up text-emerald-500' : 'fa-sort-down text-emerald-500') 
                                                    : 'fa-sort text-gray-300 opacity-0 group-hover:opacity-100'"></i>
                                        </div>
                                    </th>

                                    <th @click="sortBy('created_at')" 
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer group hover:bg-gray-100 dark:hover:bg-gray-700 transition select-none">
                                        <div class="flex items-center gap-1">
                                            Tanggal
                                            <i class="fa-solid" 
                                            :class="sortCol === 'created_at' 
                                                    ? (sortDir === 'asc' ? 'fa-sort-up text-emerald-500' : 'fa-sort-down text-emerald-500') 
                                                    : 'fa-sort text-gray-300 opacity-0 group-hover:opacity-100'"></i>
                                        </div>
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach ($links as $link)
                                    <tr class="hover:bg-emerald-50/30 dark:hover:bg-gray-700/50 transition duration-150">
                                        <td class="px-6 py-4 text-center">
                                            <input type="checkbox" value="{{ $link->id }}" x-model="selectedLinks" 
                                                class="link-checkbox rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 cursor-pointer">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-gray-900 dark:text-white text-sm mb-1">{{ $link->title }}</span>
                                                <a href="{{ url($link->short_code) }}" target="_blank" class="text-emerald-600 font-bold hover:underline text-xs flex items-center">
                                                    <i class="fa-solid fa-link mr-1"></i> /{{ $link->short_code }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center" title="{{ $link->destination_url }}">
                                                <img src="https://www.google.com/s2/favicons?domain={{ parse_url($link->destination_url, PHP_URL_HOST) }}&sz=32" class="w-4 h-4 mr-2 opacity-60">
                                                <span class="text-sm text-gray-600 dark:text-gray-300 truncate max-w-[200px]">
                                                    {{ Str::limit($link->destination_url, 40) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs font-bold">{{ $link->click_count }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $link->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button @click="toggleStatus({{ $link->id }}, {{ $link->is_active ? 1 : 0 }})" 
                                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                                    :class="linkStatus[{{ $link->id }}] ? 'bg-emerald-500' : 'bg-gray-200 dark:bg-gray-600'">
                                                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                    :class="linkStatus[{{ $link->id }}] ? 'translate-x-5' : 'translate-x-0'"></span>
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end items-center space-x-2">
                                                <button @click="navigator.clipboard.writeText('{{ url($link->short_code) }}'); alert('Tautan disalin!')" 
                                                        class="p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition" title="Copy">
                                                    <i class="fa-regular fa-copy"></i>
                                                </button>
                                                <button @click="openQrModal('{{ route('shortlinks.qr', $link->id) }}', '{{ $link->short_code }}')" 
                                                        class="p-2 text-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition" title="QR Code">
                                                    <i class="fa-solid fa-qrcode"></i>
                                                </button>
                                                <button @click="openEditModal({{ $link->id }}, '{{ addslashes($link->title) }}', '{{ addslashes($link->destination_url) }}', '{{ $link->short_code }}')" 
                                                        class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition" title="Edit">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <form action="{{ route('shortlinks.destroy', $link->id) }}" method="POST" @submit.prevent="performAction($event, 'Hapus link ini secara permanen?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="md:hidden space-y-4">
                        @foreach ($links as $link)
                            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $link->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}"></div>
                                <div class="flex justify-between items-start pl-3 mb-3">
                                    <div>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $link->title }}</span>
                                        <a href="{{ url($link->short_code) }}" target="_blank" class="text-lg font-bold text-emerald-600 hover:underline block break-all">
                                            /{{ $link->short_code }}
                                        </a>
                                        <span class="text-xs text-gray-400"><i class="fa-regular fa-clock"></i> {{ $link->created_at->diffForHumans() }}</span>
                                    </div>
                                    <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-2 py-1 rounded">{{ $link->click_count }} Klik</span>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded-xl text-xs text-gray-600 dark:text-gray-400 break-all mb-4 border border-gray-200 dark:border-gray-700 flex items-start gap-2">
                                    <i class="fa-solid fa-turn-up fa-rotate-90 mt-0.5"></i>
                                    {{ Str::limit($link->destination_url, 60) }}
                                </div>
                                <div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-700 pt-3 pl-3">
                                    <button @click="toggleStatus({{ $link->id }}, {{ $link->is_active ? 1 : 0 }})" 
                                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                            :class="linkStatus[{{ $link->id }}] ? 'bg-emerald-500' : 'bg-gray-300'">
                                        <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                            :class="linkStatus[{{ $link->id }}] ? 'translate-x-4' : 'translate-x-0'"></span>
                                    </button>
                                    <div class="flex gap-4">
                                        <button @click="navigator.clipboard.writeText('{{ url($link->short_code) }}'); alert('Disalin!')" class="text-gray-500 font-bold text-sm"><i class="fa-regular fa-copy"></i></button>
                                        <button @click="openQrModal('{{ route('shortlinks.qr', $link->id) }}', '{{ $link->short_code }}')" class="text-purple-500 font-bold text-sm"><i class="fa-solid fa-qrcode"></i></button>
                                        <button @click="openEditModal({{ $link->id }}, '{{ addslashes($link->title) }}', '{{ addslashes($link->destination_url) }}', '{{ $link->short_code }}')" class="text-blue-500 font-bold text-sm"><i class="fa-solid fa-pen"></i></button>
                                        <form action="{{ route('shortlinks.destroy', $link->id) }}" method="POST" @submit.prevent="performAction($event, 'Hapus?')">@csrf @method('DELETE')<button type="submit" class="text-red-500 font-bold text-sm"><i class="fa-solid fa-trash"></i></button></form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">{{ $links->links() }}</div>
                @else
                    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-link-slash text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tidak ada data</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai buat link pendek pertama Anda di atas.</p>
                    </div>
                @endif
            </div>
        </div>

        <div x-show="editModalOpen" style="display: none;" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
             x-transition.opacity>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all" 
                 @click.away="editModalOpen = false">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Link</h3>
                    <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                
                <form @submit.prevent="submitEdit" class="p-6 space-y-4">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Judul</label>
                        <input type="text" x-model="editForm.title" 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">URL Tujuan</label>
                        <input type="url" x-model="editForm.destination_url" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm focus:ring-emerald-500"
                               :class="{'border-red-500': errors.destination_url}">
                        <p x-show="errors.destination_url" x-text="errors.destination_url" class="text-red-500 text-xs mt-1"></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Custom Alias (Short Code)</label>
                        <div class="flex rounded-xl border border-gray-200 dark:border-gray-600 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500"
                             :class="{'border-red-500': errors.custom_code}">
                            <span class="bg-gray-50 dark:bg-gray-800 px-3 py-2.5 text-gray-500 text-sm border-r border-gray-200 dark:border-gray-600 select-none">/</span>
                            <input type="text" x-model="editForm.custom_code" placeholder="unik"
                                class="w-full border-0 py-2.5 px-3 bg-transparent dark:text-white focus:ring-0 text-sm">
                        </div>
                        <p x-show="errors.custom_code" x-text="errors.custom_code" class="text-red-500 text-xs mt-1"></p>
                        <p class="text-[10px] text-gray-400 mt-1">Hanya huruf, angka, dan tanda hubung (-).</p>
                    </div>

                    <div class="pt-2 flex justify-end gap-2">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-md transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showQr" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/70 backdrop-blur-sm" style="display: none;" x-transition.opacity @click.away="showQr = false">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-sm relative overflow-hidden flex flex-col">
                <div class="bg-gray-900 px-6 py-4 flex justify-between items-center border-b border-gray-800">
                    <h3 class="text-white font-bold text-lg tracking-wide">QR Code</h3>
                    <button @click="showQr = false" class="text-gray-400 hover:text-white transition-colors focus:outline-none"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                <div class="p-8 flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-800">
                    <div class="relative bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-8 w-64 h-64 flex items-center justify-center" id="qr-container">
                        <img :src="qrUrl" x-ref="qrImage" class="w-full h-full object-contain rounded-lg" alt="QR Code">
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="bg-white p-1 rounded-full shadow-sm border border-gray-100">
                                <img src="{{ asset('images/logo_pku.png') }}" class="w-12 h-12 object-contain rounded-full">
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <button @click="downloadQRAsPng($refs.qrImage, downloadName, '{{ asset('images/logo_pku.png') }}')" class="w-full flex justify-center items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 px-4 rounded-xl shadow-lg shadow-emerald-600/20 font-bold text-sm transition-all transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"><span>Download PNG</span></button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function shortlinkHandler() {
            return {
                search: '{{ request('search') }}',
                date: '{{ request('date') }}',
                sortCol: '{{ request('sort', 'created_at') }}',
                sortDir: '{{ request('dir', 'desc') }}',
                isLoading: false,

                linkStatus: {
                    @foreach($links as $link)
                        {{ $link->id }}: {{ $link->is_active ? 'true' : 'false' }},
                    @endforeach
                },

                editModalOpen: false,
                editForm: { title: '', destination_url: '', custom_code: '' }, 
                editAction: '',
                errors: {},

                showQr: false,
                qrUrl: '',
                downloadName: '',

                selectedLinks: [],
                allSelected: false,

                fetchResults(url = null) {
                    this.isLoading = true;
                    const baseUrl = url ? url.split('?')[0] : '{{ route('shortlinks.index') }}';
                    const params = new URLSearchParams(url ? url.split('?')[1] : window.location.search);
                    
                    if (this.search) params.set('search', this.search); else params.delete('search');
                    if (this.date) params.set('date', this.date); else params.delete('date');
                    params.set('sort', this.sortCol);
                    params.set('dir', this.sortDir);

                    const finalUrl = `${baseUrl}?${params.toString()}`;

                    fetch(finalUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.getElementById('links-container').innerHTML;
                        document.getElementById('links-container').innerHTML = newContent;
                        this.isLoading = false;
                        window.history.pushState({}, '', finalUrl);
                    });
                },

                sortBy(column) {
                    if (this.sortCol === column) {
                        this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortCol = column;
                        this.sortDir = 'asc';
                    }
                    this.fetchResults();
                },

                openEditModal(id, title, url, customCode) {
                    this.editForm.title = title;
                    this.editForm.destination_url = url;
                    this.editForm.custom_code = customCode;
                    this.editAction = '/shortlinks/' + id;
                    this.errors = {}; // Reset error
                    this.editModalOpen = true;
                },

                toggleStatus(id, currentStatus) {
                    this.linkStatus[id] = !this.linkStatus[id];

                    fetch(`/shortlinks/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json', 
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            _method: 'PUT',
                            is_active: this.linkStatus[id] ? 1 : 0,
                            toggle_only: true
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            this.linkStatus[id] = !this.linkStatus[id];
                            alert('Gagal mengubah status.');
                        }
                    })
                    .catch(err => {
                        this.linkStatus[id] = !this.linkStatus[id];
                        console.error(err);
                        alert('Terjadi kesalahan koneksi.');
                    });
                },

                toggleAll() {
                    this.allSelected = !this.allSelected;
                    if (this.allSelected) {
                        // Ambil semua ID yang ada di halaman ini
                        this.selectedLinks = Array.from(document.querySelectorAll('.link-checkbox')).map(el => el.value);
                    } else {
                        this.selectedLinks = [];
                    }
                },

                bulkDelete() {
                    if (this.selectedLinks.length === 0) return;
                    if (!confirm(`Yakin ingin menghapus ${this.selectedLinks.length} link terpilih?`)) return;

                    fetch('{{ route("shortlinks.bulk_destroy") }}', { // Kita akan buat route ini nanti
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ ids: this.selectedLinks })
                    })
                    .then(response => {
                        if (response.ok) {
                            this.selectedLinks = [];
                            this.allSelected = false;
                            this.fetchResults(window.location.href);
                            alert('Link terpilih berhasil dihapus.');
                        } else {
                            alert('Gagal menghapus link.');
                        }
                    })
                    .catch(err => alert('Terjadi kesalahan koneksi.'));
                },

                submitEdit() {
                    this.errors = {}; // Reset error
                    
                    // Siapkan Data
                    const formData = new FormData();
                    formData.append('_method', 'PUT');
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('title', this.editForm.title ?? '');
                    formData.append('destination_url', this.editForm.destination_url);
                    formData.append('custom_code', this.editForm.custom_code);

                    fetch(this.editAction, {
                        method: 'POST',
                        headers: { 
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(async response => {
                        const data = await response.json();
                        
                        if (response.status === 422) {
                            this.errors = data.errors;
                        } else if (response.ok) {
                            this.editModalOpen = false;
                            this.fetchResults(window.location.href);
                            alert('Link berhasil diperbarui!');
                        } else {
                            alert('Terjadi kesalahan sistem.');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Gagal terhubung ke server.');
                    });
                },

                openQrModal(qrRouteUrl, code) {
                    this.qrUrl = qrRouteUrl; 
                    this.downloadName = `qr-${code}.png`;
                    this.showQr = true;
                },

                performAction(event, message = null) {
                    if (message && !confirm(message)) return;
                    event.preventDefault();
                    const form = event.target.closest('form');
                    const formData = new FormData(form);
                    fetch(form.action, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(response => { if(response.ok) { this.fetchResults(window.location.href); } else { alert('Gagal memproses permintaan.'); } })
                    .catch(err => alert('Terjadi kesalahan koneksi.'));
                },

                downloadQRAsPng(img, name, logoUrl) {
                    const canvas = document.createElement('canvas');
                    const size = 1200;
                    canvas.width = size;
                    canvas.height = size;
                    const ctx = canvas.getContext('2d');
                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';
                    ctx.fillStyle = "#ffffff";
                    ctx.fillRect(0, 0, size, size);
                    const loadImage = (src) => {
                        return new Promise((resolve, reject) => {
                            const img = new Image();
                            img.crossOrigin = "Anonymous"; 
                            img.onload = () => resolve(img);
                            img.onerror = (e) => reject(e);
                            img.src = src;
                        });
                    };

                    fetch(img.src).then(res => res.text()).then(svgData => {
                        const svgBase64 = "data:image/svg+xml;base64," + btoa(unescape(encodeURIComponent(svgData)));
                        Promise.all([loadImage(svgBase64), loadImage(logoUrl)]).then(([imgQRObj, imgLogoObj]) => {
                            const padding = 30; 
                            const qrActualSize = size - (padding * 2); 
                            ctx.drawImage(imgQRObj, padding, padding, qrActualSize, qrActualSize);
                            const logoSize = size * 0.22; 
                            const logoX = (size - logoSize) / 2;
                            const logoY = (size - logoSize) / 2;
                            const centerX = size / 2;
                            const centerY = size / 2;
                            ctx.beginPath();
                            ctx.arc(centerX, centerY, (logoSize / 2) + 20, 0, 2 * Math.PI);
                            ctx.fillStyle = "#ffffff"; 
                            ctx.fill();
                            ctx.closePath();
                            ctx.drawImage(imgLogoObj, logoX, logoY, logoSize, logoSize);
                            const url = canvas.toDataURL("image/png", 1.0);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = name;
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                        }).catch(err => {
                            console.error("Gagal load gambar:", err);
                            alert("Gagal memproses gambar.");
                        });
                    });
                }
            }
        }
    </script>
</x-app-layout>