<div id="links-list">
    @if($links->count() > 0)
        
        <div class="hidden md:block bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        @foreach(['short_code' => 'Short Link', 'original_url' => 'URL Asli', 'click_count' => 'Klik', 'created_at' => 'Dibuat'] as $field => $label)
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                            <a href="javascript:void(0)" 
                                @click="fetchResults('{{ route('shortlinks.index', ['sort' => $field, 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}')" 
                                class="flex items-center">
                                    {{ $label }}
                                <span class="ml-1 text-gray-300 group-hover:text-emerald-500">
                                    @if(request('sort') == $field)
                                        {!! request('direction') == 'asc' ? '&#9650;' : '&#9660;' !!}
                                    @else
                                        &#8645;
                                    @endif
                                </span>
                            </a>
                        </th>
                        @endforeach
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @foreach ($links as $link)
                    <tr class="hover:bg-emerald-50/30 dark:hover:bg-gray-700/50 transition duration-150">
                        <td class="px-6 py-4">
                            <a href="{{ url($link->short_code) }}" target="_blank" class="text-emerald-600 font-bold hover:underline">
                                /{{ $link->short_code }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="https://www.google.com/s2/favicons?domain={{ parse_url($link->original_url, PHP_URL_HOST) }}&sz=32" class="w-4 h-4 mr-2 opacity-60">
                                <span class="text-sm text-gray-600 dark:text-gray-300 truncate max-w-xs" title="{{ $link->original_url }}">
                                    {{ Str::limit($link->original_url, 40) }}
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
                            <form action="{{ route('shortlinks.toggle', $link->id) }}" method="POST" @submit.prevent="performAction($event)">
                                @csrf @method('PATCH')
                                <button type="submit" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $link->is_active ? 'bg-emerald-500' : 'bg-gray-200' }}">
                                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $link->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <button @click="navigator.clipboard.writeText('{{ url($link->short_code) }}'); alert('Disalin!')" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg" title="Copy">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                                <button @click="$dispatch('open-qr', { url: '{{ $link->qr_path ? asset('storage/' . $link->qr_path) : '' }}', downloadName: 'qr-{{ $link->short_code }}.png' })" class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg" title="QR">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 6h6v6H6V6zm12 0h6v6h-6V6zm-6 12h6v6h-6v-6z"></path></svg>
                                </button>
                                <form action="{{ route('shortlinks.destroy', $link->id) }}" method="POST" @submit.prevent="performAction($event, 'Hapus link ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                        <a href="{{ url($link->short_code) }}" target="_blank" class="text-lg font-bold text-emerald-600 hover:underline block">
                            /{{ $link->short_code }}
                        </a>
                        <span class="text-xs text-gray-400">{{ $link->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-2 py-1 rounded">{{ $link->click_count }} Klik</span>
                        <form action="{{ route('shortlinks.toggle', $link->id) }}" method="POST" @submit.prevent="performAction($event)">
                            @csrf @method('PATCH')
                            <button type="submit" class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $link->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}">
                                <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $link->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900 p-3 rounded-xl text-sm text-gray-600 break-all mb-4 border border-gray-200 dark:border-gray-700">
                    {{ Str::limit($link->original_url, 60) }}
                </div>

                <div class="flex justify-between items-center border-t border-gray-100 pt-3 pl-3">
                    <span class="text-xs text-gray-400 font-bold uppercase">Aksi</span>
                    <div class="flex gap-3">
                        <button @click="navigator.clipboard.writeText('{{ url($link->short_code) }}'); alert('Tautan disalin!')" class="text-gray-500 hover:text-emerald-600 font-bold text-sm">Copy</button>
                        <button @click="$dispatch('open-qr', { url: '{{ $link->qr_path ? asset('storage/' . $link->qr_path) : '' }}', downloadName: 'qr-{{ $link->short_code }}.png' })" class="text-emerald-500 hover:text-emerald-700 font-bold text-sm">QR</button>
                        <form action="{{ route('shortlinks.destroy', $link->id) }}" method="POST" @submit.prevent="performAction($event, 'Hapus link ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $links->links() }}
        </div>

    @else
        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tidak ditemukan</h3>
            <p class="mt-1 text-sm text-gray-500">Coba kata kunci pencarian yang lain.</p>
        </div>
    @endif
</div>