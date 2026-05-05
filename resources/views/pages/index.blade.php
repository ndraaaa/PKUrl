<x-app-layout title="Halaman Saya" desc="Kelola link bio profile dan pantau statistik Anda.">

    <div class="py-4 md:py-8" x-data="{
        search: '',
        sortBy: 'newest',
        showCreateModal: {{ $errors->any() ? 'true' : 'false' }},
        pages: [
            @foreach ($pages as $page)
            {
                id: {{ $page->id }},
                title: '{{ addslashes($page->title) }}',
                handle: '{{ $page->handle }}',
                url: '{{ url($page->handle) }}',
                clicks: {{ $page->links->sum('click_count') }},
                is_public: {{ $page->is_public ?? 1 ? 'true' : 'false' }},
                
                // Tambahkan 3 baris ini untuk mendeteksi custom color
                theme: '{{ $page->appearance['theme'] ?? 'default' }}',
                customColor: '{{ $page->appearance['background_value'] ?? '#10b981' }}',
                themeClass: '{{ match ($page->appearance['theme'] ?? 'default') {
                    'ocean' => 'from-blue-500 to-cyan-400',
                    'sunset' => 'from-orange-500 to-rose-500',
                    'nature' => 'from-emerald-500 to-lime-500',
                    'midnight' => 'from-slate-700 to-slate-900',
                    default => 'from-emerald-500 to-teal-500',
                } }}',
                
                avatar: '{{ $page->avatar_path ? asset('storage/' . $page->avatar_path) : '' }}',
                created_at: '{{ $page->created_at }}',
                edit_url: '{{ route('pages.edit', $page->id) }}',
                delete_url: '{{ route('pages.destroy', $page->id) }}'
            }, @endforeach
        ],
        get filteredPages() {
            let filtered = this.pages.filter(p =>
                p.title.toLowerCase().includes(this.search.toLowerCase()) ||
                p.handle.toLowerCase().includes(this.search.toLowerCase())
            );
            if (this.sortBy === 'newest') return filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            if (this.sortBy === 'popular') return filtered.sort((a, b) => b.clicks - a.clicks);
            return filtered;
        },
        copyToClipboard(text) {
            navigator.clipboard.writeText(text);
        },
        toggleStatus(page) {
            page.is_public = !page.is_public;
    
            fetch(`/pages/${page.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    _method: 'PUT',
                    is_public: page.is_public ? 1 : 0,
                    toggle_only: true
                })
            }).then(response => {
                if (!response.ok) {
                    page.is_public = !page.is_public;
                    alert('Gagal mengubah status.');
                }
            }).catch(err => {
                page.is_public = !page.is_public;
                alert('Terjadi kesalahan jaringan.');
            });
        }
    }">

        {{-- CONTAINER UTAMA (Menyamakan Lebar dengan Halaman Lain) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 md:space-y-6 relative pb-12">

            {{-- HEADER SEARCH & FILTER --}}
            <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center">

                <div class="flex-1 relative group w-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input x-model="search" type="text"
                        class="block w-full pl-11 pr-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl leading-5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 sm:text-sm shadow-sm hover:border-gray-300 dark:hover:border-gray-600 text-gray-900 dark:text-white"
                        placeholder="Cari halaman...">
                </div>

                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <button @click="showCreateModal = true"
                        class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-lg shadow-emerald-600/20 text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform hover:-translate-y-0.5 active:scale-95 whitespace-nowrap">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Halaman
                    </button>
                </div>
            </div>

            {{-- GRID CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                <template x-for="page in filteredPages" :key="page.id">

                    <div
                        class="group bg-white dark:bg-gray-800 rounded-2xl shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] border border-gray-100 dark:border-gray-700 hover:border-emerald-500/30 hover:shadow-lg dark:hover:shadow-emerald-900/10 transition-all duration-300 relative overflow-hidden flex flex-col">

                        <div class="h-1.5 w-full"
                            :class="page.theme === 'custom' ? '' : 'bg-gradient-to-r ' + page.themeClass"
                            :style="page.theme === 'custom' ? 'background-color: ' + page.customColor : ''">
                        </div>

                        <div class="p-5 flex flex-col flex-1">

                            {{-- Menu Titik Tiga & Dropdown Dinamis --}}
                            <div class="absolute top-4 right-4 z-10" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false"
                                    class="p-1.5 text-gray-300 hover:text-gray-600 dark:hover:text-gray-200 rounded-lg transition-colors focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                        </path>
                                    </svg>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    class="absolute right-0 mt-1 w-44 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 py-1"
                                    style="display: none;">

                                    {{-- Tombol Salin --}}
                                    <button @click="copyToClipboard(page.url); open = false; alert('Tautan disalin!')"
                                        class="w-full text-left px-3 py-2 text-xs font-medium text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700 flex items-center gap-2 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3">
                                            </path>
                                        </svg>
                                        Salin Link
                                    </button>

                                    <div class="h-px bg-gray-100 dark:bg-gray-700 my-1"></div>

                                    {{-- TOMBOL TOGGLE DINAMIS (Aktifkan / Nonaktifkan) --}}
                                    <button @click="toggleStatus(page); open = false"
                                        class="w-full text-left px-3 py-2 text-xs font-medium flex items-center gap-2 transition-colors"
                                        :class="page.is_public ?
                                            'text-amber-600 hover:bg-amber-50 dark:text-amber-500 dark:hover:bg-gray-700' :
                                            'text-emerald-600 hover:bg-emerald-50 dark:text-emerald-400 dark:hover:bg-gray-700'">

                                        <svg x-show="page.is_public" class="w-3.5 h-3.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a10.05 10.05 0 015.71-1.29c4.478 0 8.268 2.943 9.543 7a9.97 9.97 0 01-1.564 3.029m-5.858-.908a3 3 0 00-4.243-4.243m4.243 4.243L8 8" />
                                        </svg>

                                        <svg x-show="!page.is_public" style="display: none;" class="w-3.5 h-3.5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>

                                        <span x-text="page.is_public ? 'Nonaktifkan' : 'Aktifkan'"></span>
                                    </button>

                                    <div class="h-px bg-gray-100 dark:bg-gray-700 my-1"></div>

                                    {{-- Tombol Hapus --}}
                                    <form :action="page.delete_url" method="POST"
                                        onsubmit="return confirm('Yakin hapus halaman ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-full text-left px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50 dark:hover:bg-gray-700 flex items-center gap-2 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 mb-4">
                                <div class="relative shrink-0">
                                    <div class="p-[2px] rounded-2xl"
                                        :class="page.theme === 'custom' ? '' : 'bg-gradient-to-br ' + page.themeClass"
                                        :style="page.theme === 'custom' ? 'background-color: ' + page.customColor : ''">
                                        <div class="bg-white dark:bg-gray-800 p-[2px] rounded-2xl">
                                            <template x-if="page.avatar">
                                                <img :src="page.avatar" class="w-14 h-14 rounded-xl object-cover">
                                            </template>
                                            <template x-if="!page.avatar">
                                                <div class="w-14 h-14 rounded-xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-lg font-bold text-gray-400 dark:text-gray-500 uppercase"
                                                    x-text="page.title.substring(0,2)">
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0 pt-1">
                                    <h3 class="text-base font-bold text-gray-900 dark:text-white truncate"
                                        x-text="page.title"></h3>
                                    <a :href="page.url" target="_blank"
                                        class="text-xs text-gray-500 hover:text-emerald-600 transition truncate block mt-0.5 underline decoration-gray-300 underline-offset-2"
                                        x-text="page.handle"></a>

                                    <div class="flex items-center gap-3 mt-2">
                                        {{-- BADGE STATUS DINAMIS (Merah untuk Nonaktif, Hijau untuk Aktif) --}}
                                        <span
                                            class="flex items-center gap-1 text-[10px] font-medium px-2 py-0.5 rounded-full transition-colors duration-300"
                                            :class="page.is_public ?
                                                'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' :
                                                'bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400'">
                                            <span class="w-1.5 h-1.5 rounded-full transition-colors duration-300"
                                                :class="page.is_public ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500'"></span>

                                            <span x-text="page.is_public ? 'Aktif' : 'Nonaktif'"></span>
                                        </span>

                                        <span class="flex items-center gap-1 text-[10px] font-medium text-gray-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            <span x-text="page.clicks"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-3 mt-auto pt-4 border-t border-gray-50 dark:border-gray-700/50">
                                <a :href="page.url" target="_blank"
                                    class="flex-1 text-center py-2 text-xs font-bold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                                    Lihat
                                </a>
                                <a :href="page.edit_url"
                                    class="flex-1 text-center py-2 text-xs font-bold text-white bg-gray-900 dark:bg-emerald-600 hover:bg-gray-800 dark:hover:bg-emerald-700 rounded-lg transition shadow-lg shadow-gray-900/10 dark:shadow-emerald-600/10">
                                    Kelola
                                </a>
                            </div>
                        </div>

                    </div>
                </template>
            </div>

            {{-- EMPTY STATE --}}
            <div x-show="filteredPages.length === 0"
                class="flex flex-col items-center justify-center py-16 bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 mt-8">
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Belum ada halaman</h3>
                <p class="mt-1 text-sm text-gray-500 mb-6">Buat halaman bio link pertama Anda sekarang.</p>
                <button @click="showCreateModal = true; search = ''"
                    class="text-sm font-bold text-emerald-600 hover:underline">
                    Buat Halaman Baru &rarr;
                </button>
            </div>

        </div>

        {{-- MODAL CREATE PAGE --}}
        <div x-show="showCreateModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div x-show="showCreateModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="showCreateModal" @click.away="showCreateModal = false"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 dark:border-gray-700">

                    <div class="bg-white dark:bg-gray-800 p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Buat Halaman</h3>
                            <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('pages.store') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Link
                                    Handle</label>

                                <div
                                    class="flex rounded-xl shadow-sm ring-1 ring-inset @error('handle') ring-red-500 @else ring-gray-200 dark:ring-gray-700 @enderror focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-500 bg-gray-50 dark:bg-gray-900 overflow-hidden">
                                    <span
                                        class="flex select-none items-center pl-3 text-gray-400 text-xs">{{ request()->getHost() }}/</span>
                                    <input type="text" name="handle" value="{{ old('handle') }}"
                                        class="block flex-1 border-0 bg-transparent py-2.5 pl-1 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-0 sm:text-sm font-medium"
                                        placeholder="username" required>
                                </div>

                                @error('handle')
                                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Nama
                                    Halaman</label>

                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="block w-full rounded-xl border-0 py-2.5 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset @error('title') ring-red-500 @else ring-gray-200 dark:ring-gray-700 @enderror placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-500 sm:text-sm bg-white dark:bg-gray-900 font-medium"
                                    placeholder="Contoh: Link Pribadi Saya" required>

                                @error('title')
                                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-xl bg-emerald-600 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-500 transition">Mulai
                                    Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
