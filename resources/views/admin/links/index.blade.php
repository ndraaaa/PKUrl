<x-app-layout>
    <x-slot name="title">Manajemen Link</x-slot>

    {{-- HEADER --}}
    <div class="py-10" x-data="linkHandler()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-emerald-800 dark:text-emerald-200 flex items-center gap-2">
                        <i class="fa-solid fa-link"></i> Manajemen Link Global
                    </h2>
                    <p class="text-sm text-emerald-600 dark:text-emerald-400">
                        Semua link pengguna & shortlink
                    </p>
                </div>

                {{-- SEARCH FORM --}}
                <form method="GET" class="flex flex-col md:flex-row gap-3">
                    <input type="hidden" name="sort" :value="sortCol">
                    <input type="hidden" name="dir" :value="sortDir">
                    
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-500">
                            <i class="fa-solid fa-search"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul, URL, user..."
                            class="w-full md:w-80 rounded-xl border border-emerald-200 pl-10 pr-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none dark:bg-gray-800 dark:border-emerald-900 dark:text-white transition">
                    </div>

                    <button type="submit" class="px-6 py-2 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20">
                        Cari
                    </button>
                </form>
            </div>

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                     class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl shadow flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">✕</button>
                </div>
            @endif

            {{-- TAB NAVIGATION --}}
            <div class="flex gap-2 p-1 bg-gray-100 dark:bg-gray-800/50 rounded-xl w-full md:w-fit border border-gray-200 dark:border-gray-700">
                <button @click="activeTab = 'bio'"
                    :class="activeTab === 'bio' ? 'bg-white dark:bg-gray-700 shadow text-emerald-600 dark:text-emerald-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                    class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                    <i class="fa-solid fa-pager"></i> Bio Link
                </button>
                <button @click="activeTab = 'short'"
                    :class="activeTab === 'short' ? 'bg-white dark:bg-gray-700 shadow text-emerald-600 dark:text-emerald-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                    class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                    <i class="fa-solid fa-bolt"></i> Shortlink
                </button>
            </div>

            {{-- ================= TAB 1: BIO LINKS ================= --}}
            <div x-show="activeTab === 'bio'" x-transition:enter="transition ease-out duration-200">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-emerald-100 dark:border-emerald-900/30 overflow-hidden">
                    <div class="px-6 py-4 border-b dark:border-gray-700 bg-emerald-50/50 dark:bg-gray-800">
                        <h3 class="font-bold text-emerald-700 dark:text-emerald-400">🌿 Daftar Link di Halaman Bio</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    {{-- Sortable Headers --}}
                                    <th @click="sortBy('title')" class="px-6 py-3 text-left text-xs font-bold uppercase cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition group select-none">
                                        Judul Link <i class="fa-solid ml-1" :class="getSortIcon('title')"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Halaman Bio</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Pemilik</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">URL Tujuan</th>
                                    <th @click="sortBy('click_count')" class="px-6 py-3 text-center text-xs font-bold uppercase cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition group select-none">
                                        Klik <i class="fa-solid ml-1" :class="getSortIcon('click_count')"></i>
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($bioLinks as $link)
                                <tr class="hover:bg-emerald-50/30 dark:hover:bg-gray-700/30 transition">
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $link->title ?? 'Tanpa Judul' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 text-xs font-bold dark:bg-purple-900/30 dark:text-purple-300">
                                            <i class="fa-solid fa-pager"></i> {{ $link->page->title ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600">
                                                {{ substr($link->user->name ?? 'G', 0, 1) }}
                                            </div>
                                            <div class="text-xs">
                                                <div class="font-bold text-gray-700 dark:text-gray-300">{{ $link->user->name ?? 'Guest' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 truncate max-w-xs">
                                        <div class="flex items-center gap-2" title="{{ $link->destination_url }}">
                                            <i class="fa-solid fa-turn-up fa-rotate-90"></i>
                                            <span class="truncate w-32">{{ $link->destination_url }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-gray-600 dark:text-gray-300">
                                        {{ number_format($link->click_count) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{-- Toggle Button --}}
                                        <button @click="toggleStatus({{ $link->id }})" 
                                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                            :class="status[{{ $link->id }}] ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600'">
                                            <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                :class="status[{{ $link->id }}] ? 'translate-x-4' : 'translate-x-0'"></span>
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.links.destroy', $link) }}" method="POST" onsubmit="return confirm('Hapus link ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        {{ $bioLinks->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

            {{-- ================= TAB 2: SHORTLINKS ================= --}}
            <div x-show="activeTab === 'short'" x-transition:enter="transition ease-out duration-200" style="display: none;">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-emerald-100 dark:border-emerald-900/30 overflow-hidden">
                    <div class="px-6 py-4 border-b dark:border-gray-700 bg-emerald-50/50 dark:bg-gray-800">
                        <h3 class="font-bold text-emerald-700 dark:text-emerald-400">⚡ Daftar Shortlink Langsung</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th @click="sortBy('short_code')" class="px-6 py-3 text-left text-xs font-bold uppercase cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition group select-none">
                                        Short Code <i class="fa-solid ml-1" :class="getSortIcon('short_code')"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Pemilik</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">URL Tujuan</th>
                                    <th @click="sortBy('click_count')" class="px-6 py-3 text-center text-xs font-bold uppercase cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition group select-none">
                                        Klik <i class="fa-solid ml-1" :class="getSortIcon('click_count')"></i>
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($shortLinks as $link)
                                <tr class="hover:bg-emerald-50/30 dark:hover:bg-gray-700/30 transition">
                                    <td class="px-6 py-4">
                                        <a href="{{ url($link->short_code) }}" target="_blank" class="font-mono font-bold text-emerald-600 hover:underline flex items-center gap-1">
                                            /{{ $link->short_code }} <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                        <div class="text-[10px] text-gray-400 mt-1">{{ $link->title ?? 'Untitled' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600">
                                                {{ substr($link->user->name ?? 'G', 0, 1) }}
                                            </div>
                                            <div class="text-xs">
                                                <div class="font-bold text-gray-700 dark:text-gray-300">{{ $link->user->name ?? 'Guest' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 truncate max-w-xs">
                                        <div class="flex items-center gap-2" title="{{ $link->destination_url }}">
                                            <i class="fa-solid fa-turn-up fa-rotate-90"></i>
                                            <span class="truncate w-32">{{ $link->destination_url }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-gray-600 dark:text-gray-300">
                                        {{ number_format($link->click_count) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{-- Toggle Button --}}
                                        <button @click="toggleStatus({{ $link->id }})" 
                                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                            :class="status[{{ $link->id }}] ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600'">
                                            <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                :class="status[{{ $link->id }}] ? 'translate-x-4' : 'translate-x-0'"></span>
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.links.destroy', $link) }}" method="POST" onsubmit="return confirm('Hapus shortlink ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Tidak ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        {{ $shortLinks->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        function linkHandler() {
            return {
                activeTab: localStorage.getItem('admin_link_tab') || 'bio',
                
                // Sorting State
                sortCol: '{{ request('sort', 'created_at') }}',
                sortDir: '{{ request('dir', 'desc') }}',

                // Status Mapping
                status: {
                    @foreach($bioLinks as $link) {{ $link->id }}: {{ $link->is_active ? 'true' : 'false' }}, @endforeach
                    @foreach($shortLinks as $link) {{ $link->id }}: {{ $link->is_active ? 'true' : 'false' }}, @endforeach
                },

                init() {
                    this.$watch('activeTab', value => localStorage.setItem('admin_link_tab', value));
                },

                sortBy(column) {
                    if (this.sortCol === column) {
                        this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortCol = column;
                        this.sortDir = 'desc';
                    }
                    // Reload page dengan parameter sort
                    const url = new URL(window.location.href);
                    url.searchParams.set('sort', this.sortCol);
                    url.searchParams.set('dir', this.sortDir);
                    // Pertahankan tab saat reload
                    localStorage.setItem('admin_link_tab', this.activeTab);
                    window.location.href = url.toString();
                },

                getSortIcon(column) {
                    if (this.sortCol !== column) return 'fa-sort text-gray-300 opacity-0 group-hover:opacity-50';
                    return this.sortDir === 'asc' ? 'fa-sort-up text-emerald-500' : 'fa-sort-down text-emerald-500';
                },

                toggleStatus(id) {
                    // Update tampilan dulu (Optimistic UI)
                    this.status[id] = !this.status[id];

                    fetch(`/admin/links/${id}/toggle`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status !== 'success') {
                            this.status[id] = !this.status[id]; // Balikin kalo gagal
                            alert('Gagal update status.');
                        }
                    })
                    .catch(() => {
                        this.status[id] = !this.status[id]; // Balikin kalo error koneksi
                        alert('Error koneksi server.');
                    });
                }
            }
        }
    </script>
</x-app-layout>