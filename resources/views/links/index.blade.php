<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('pages.edit', $page->id) }}" class="text-gray-400 hover:text-emerald-600 transition" title="Kembali ke Editor Tampilan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        Kelola Tautan: {{ $page->title }}
                    </h2>
                </div>
                <p class="text-sm text-gray-500 mt-1 ml-8">Tambahkan tombol link yang akan muncul di halaman bio ini.</p>
            </div>
            
            <a href="{{ url($page->handle) }}" target="_blank" class="flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-50 transition">
                Lihat Bio
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-md flex justify-between items-center">
                    <div class="flex items-center text-emerald-700">
                        <span class="font-bold mr-2">Berhasil!</span>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">✕</button>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="bg-emerald-600 px-6 py-4 border-b border-emerald-500">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Tombol Baru
                    </h3>
                </div>
                
                <div class="p-6">
                    <form method="post" action="{{ route('links.store', $page->id) }}" class="flex flex-col md:flex-row gap-4">
                        @csrf
                        
                        <div class="md:w-1/3">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Judul Tombol</label>
                            <input type="text" name="title" required placeholder="Contoh: WhatsApp Admin" 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                        </div>

                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">URL Tujuan</label>
                            <input type="url" name="original_url" required placeholder="https://wa.me/628..." 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition transform hover:-translate-y-0.5">
                                Tambahkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($links->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700 dark:text-gray-200">Daftar Tombol Aktif</h3>
                        <span class="text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded-full">{{ $links->total() }} Item</span>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($links as $link)
                        <div class="p-4 sm:p-6 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition flex flex-col sm:flex-row justify-between items-center gap-4 group">
                            
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <div class="text-gray-300 cursor-move hidden sm:block">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                                </div>

                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200">{{ $link->title }}</h4>
                                    <a href="{{ $link->original_url }}" target="_blank" class="text-sm text-gray-500 hover:text-emerald-600 truncate max-w-xs block">
                                        {{ Str::limit($link->original_url, 50) }}
                                    </a>
                                    <div class="mt-1 flex items-center gap-3 text-xs text-gray-400">
                                        <span class="flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ $link->click_count }} klik</span>
                                        <span>•</span>
                                        <span>{{ $link->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                                
                                <form action="{{ route('links.toggle', $link->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $link->is_active ? 'bg-emerald-500' : 'bg-gray-200' }}" title="Aktif/Nonaktif">
                                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $link->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                </form>

                                <form action="{{ route('links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Hapus tombol ini dari bio?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6">
                    {{ $links->links() }}
                </div>

            @else
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Belum ada tombol link</h3>
                    <p class="mt-1 text-sm text-gray-500">Tambahkan link WhatsApp, Instagram, atau Website Anda di atas.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>