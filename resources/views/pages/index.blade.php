<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    Dashboard Halaman
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola semua halaman bio link Anda di satu tempat.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ 
        search: '', 
        sortBy: 'newest',
        pages: [
            @foreach($pages as $page)
            {
                id: {{ $page->id }},
                title: '{{ addslashes($page->title) }}',
                handle: '{{ $page->handle }}',
                clicks: {{ $page->links->sum('click_count') }},
                theme: '{{ $page->theme ?? 'default' }}',
                avatar: '{{ $page->avatar ? asset('storage/'.$page->avatar) : '' }}',
                created_at: '{{ $page->created_at }}',
                edit_url: '{{ route('pages.edit', $page->id) }}',
                delete_url: '{{ route('pages.destroy', $page->id) }}'
            },
            @endforeach
        ],
        get filteredPages() {
            let filtered = this.pages.filter(p => 
                p.title.toLowerCase().includes(this.search.toLowerCase()) || 
                p.handle.toLowerCase().includes(this.search.toLowerCase())
            );
            if (this.sortBy === 'newest') return filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            if (this.sortBy === 'popular') return filtered.sort((a, b) => b.clicks - a.clicks);
            return filtered;
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                    <div class="p-3 bg-emerald-100 dark:bg-emerald-900 rounded-full text-emerald-600 dark:text-emerald-300 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Halaman</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $pages->count() }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full text-blue-600 dark:text-blue-300 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Kunjungan</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($pages->sum(fn($page) => $page->links->sum('click_count'))) }}</p>
                    </div>
                </div>

                <a href="{{ route('shortlinks.index') }}" class="group bg-gradient-to-br from-emerald-500 to-teal-600 p-6 rounded-2xl shadow-lg text-white flex items-center justify-between hover:scale-[1.02] transition-transform">
                    <div>
                        <p class="text-emerald-100 font-medium mb-1">Butuh link cepat?</p>
                        <p class="text-xl font-bold">Buat Shortlink &rarr;</p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </div>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-gray-200 flex items-center">
                    <span class="bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 p-1.5 rounded-lg mr-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </span>
                    Buat Halaman Bio Baru
                </h3>
                
                <form action="{{ route('pages.store') }}" method="POST" class="flex flex-col md:flex-row gap-4">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">URL Halaman</label>
                        <div class="flex rounded-xl border border-gray-200 dark:border-gray-600 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 bg-white dark:bg-gray-900">
                            <span class="bg-gray-50 dark:bg-gray-800 px-3 py-3 text-gray-500 text-sm border-r border-gray-200 dark:border-gray-600 select-none flex items-center">
                                {{ request()->getHost() }}/
                            </span>
                            <input type="text" name="handle" placeholder="cs" 
                                class="flex-1 border-0 focus:ring-0 py-3 px-3 text-gray-900 dark:text-white bg-transparent placeholder-gray-400" required>
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Judul Halaman</label>
                        <input type="text" name="title" placeholder="Customer Service" 
                            class="w-full rounded-xl border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white py-3 px-4 focus:ring-emerald-500 focus:border-emerald-500 placeholder-gray-400" required>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg shadow-emerald-600/20 whitespace-nowrap w-full md:w-auto">
                            Buat Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-4">
                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-200">Halaman Saya</h3>
                
                <div class="flex items-center gap-2 bg-white dark:bg-gray-800 p-1 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm w-full md:w-auto">
                    <div class="relative flex-1 md:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input x-model="search" type="text" placeholder="Cari halaman..." 
                            class="w-full pl-9 pr-4 py-2 bg-transparent border-none text-sm focus:ring-0 dark:text-white">
                    </div>
                    <div class="h-6 w-px bg-gray-200 dark:bg-gray-700 mx-1"></div>
                    <select x-model="sortBy" class="bg-transparent border-none text-xs font-bold text-gray-500 dark:text-gray-400 focus:ring-0 py-2 cursor-pointer">
                        <option value="newest">Terbaru</option>
                        <option value="popular">Terpopuler</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="page in filteredPages" :key="page.id">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden hover:border-emerald-500 transition group flex flex-col h-full relative">
                        
                        <div class="h-24 w-full transition-colors"
                            :class="{
                                'bg-gradient-to-r from-blue-500 to-cyan-500': page.theme === 'ocean',
                                'bg-gradient-to-r from-orange-500 to-pink-500': page.theme === 'sunset',
                                'bg-gray-900': page.theme === 'midnight',
                                'bg-gradient-to-r from-emerald-600 to-teal-600': page.theme === 'default' || !page.theme
                            }">
                        </div>
                        
                        <div class="px-6 pb-6 flex-1 flex flex-col relative">
                            <div class="absolute -top-10 left-6">
                                <template x-if="page.avatar">
                                    <img :src="page.avatar" class="w-20 h-20 rounded-2xl border-4 border-white dark:border-gray-800 shadow-md object-cover bg-white">
                                </template>
                                <template x-if="!page.avatar">
                                    <div class="w-20 h-20 rounded-2xl border-4 border-white dark:border-gray-800 shadow-md bg-emerald-50 dark:bg-emerald-900 flex items-center justify-center text-3xl font-bold text-emerald-600 dark:text-emerald-400" x-text="page.title.charAt(0)">
                                    </div>
                                </template>
                            </div>

                            <form :action="page.delete_url" method="POST" class="absolute top-4 right-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-500 rounded-lg opacity-0 group-hover:opacity-100 transition hover:bg-red-500 hover:text-white" title="Hapus Halaman">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            
                            <div class="mt-12 mb-4">
                                <div class="flex justify-between items-start gap-2">
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-1 truncate" x-text="page.title"></h4>
                                    <span class="text-[10px] bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-md font-bold text-gray-500 shrink-0" x-text="page.clicks + ' Klik'"></span>
                                </div>
                                <a :href="'/' + page.handle" target="_blank" class="text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 flex items-center w-max transition group-hover:underline">
                                    <span class="truncate max-w-[150px]" x-text="'/' + page.handle"></span>
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>

                            <div class="mt-auto pt-4">
                                <a :href="page.edit_url" class="flex justify-center items-center w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow-lg shadow-emerald-600/20 transform active:scale-95 group-hover:-translate-y-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Kelola Halaman
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="filteredPages.length === 0" class="text-center py-12 bg-white dark:bg-gray-800 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tidak ditemukan</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Pencarian untuk "<span x-text="search"></span>" tidak membuahkan hasil.</p>
            </div>

        </div>
    </div>
</x-app-layout>