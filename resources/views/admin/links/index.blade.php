<x-app-layout title="Manajemen Link Global" desc="Semua link pengguna & shortlink.">

    {{-- HEADER --}}
    <div class="py-4 md:py-8" x-data="linkHandler()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-2 md:space-y-6 relative">

            {{-- NOTIFIKASI SUCCESS DINAMIS (AJAX) --}}
            <div x-cloak x-show="toast.show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-[-100%]"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-[-100%]"
                class="fixed top-4 left-1/2 transform -translate-x-1/2 z-[100] bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 px-6 py-3 rounded-xl shadow-xl flex items-center gap-4 min-w-[300px]">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <span class="font-semibold flex-1" x-text="toast.message"></span>
                <button @click="toast.show = false" class="text-emerald-500 hover:text-emerald-800 transition"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>

            {{-- BANNER BULK DELETE --}}
            <div x-cloak x-show="selectedLinks.length > 0" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="sticky top-4 z-50 bg-emerald-50/90 dark:bg-emerald-900/80 backdrop-blur-md border border-emerald-200 dark:border-emerald-700 rounded-xl p-3 flex justify-between items-center shadow-lg"
                style="display: none;">

                <div class="flex items-center gap-2 text-emerald-800 dark:text-emerald-300 text-sm font-medium px-2">
                    <i class="fa-solid fa-check-double"></i>
                    <span x-text="selectedLinks.length + ' item dipilih'"></span>
                </div>

                {{-- Form Bulk Delete diubah jadi Panggilan Fungsi AJAX --}}
                <button type="button" @click="deleteBulk('{{ route('admin.links.bulk_destroy') }}')"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-trash"></i> Hapus Terpilih
                </button>
            </div>

            {{-- TAB NAVIGATION & SEARCH --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                {{-- Tab Tombol --}}
                <div
                    class="flex flex-row p-1 bg-gray-100 dark:bg-gray-800/50 rounded-xl w-full md:w-fit border border-gray-200 dark:border-gray-700">

                    <button @click="activeTab = 'bio'"
                        :class="activeTab === 'bio' ?
                            'bg-white dark:bg-gray-700 shadow text-emerald-600 dark:text-emerald-400' :
                            'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                        class="flex-1 md:flex-none px-2 md:px-6 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-pager"></i>
                        <span class="truncate whitespace-nowrap">Bio Link</span>
                    </button>

                    <button @click="activeTab = 'short'"
                        :class="activeTab === 'short' ?
                            'bg-white dark:bg-gray-700 shadow text-emerald-600 dark:text-emerald-400' :
                            'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                        class="flex-1 md:flex-none px-2 md:px-6 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-bolt"></i>
                        <span class="truncate whitespace-nowrap">Shortlink</span>
                    </button>

                </div>

                {{-- Search Input --}}
                <form @submit.prevent="fetchResults()" class="w-full md:w-auto">
                    <div class="relative w-full md:w-80">
                        <span
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-500">
                            <i class="fa-solid fa-search"></i>
                        </span>

                        <input type="text" x-model="search" @input.debounce.500ms="fetchResults()"
                            placeholder="Cari judul, URL, user..."
                            class="w-full rounded-xl border border-emerald-200 pl-10 pr-10 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none dark:bg-gray-800 dark:border-emerald-900 dark:text-white transition text-sm">

                        <button type="button" x-show="search.length > 0" @click="search = ''; fetchResults()"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-75"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors focus:outline-none"
                            title="Hapus pencarian">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                </form>

            </div>

            {{-- CONTAINER UNTUK DOM REPLACEMENT AJAX --}}
            <div id="links-container" class="space-y-6" @click="handlePagination($event)">

                {{-- ================= TAB 1: BIO LINKS ================= --}}
                <div x-show="activeTab === 'bio'" x-transition:enter="transition ease-out duration-200">
                    <div
                        class="bg-white dark:bg-gray-800 md:rounded-2xl shadow md:border border-emerald-100 dark:border-emerald-900/30 overflow-hidden">

                        <div
                            class="px-4 md:px-6 py-4 border-b dark:border-gray-700 bg-emerald-50/50 dark:bg-gray-800 flex items-center justify-between">
                            <h3 class="font-bold text-emerald-700 dark:text-emerald-400">🌿 Daftar Link di Halaman Bio
                            </h3>
                            <div class="md:hidden flex items-center gap-2 text-xs font-bold text-gray-500">
                                <label for="selectAllBioMobile">Pilih Semua</label>
                                <input type="checkbox" id="selectAllBioMobile" @change="toggleAll('bio')"
                                    :checked="isAllSelected('bio')"
                                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </div>
                        </div>

                        {{-- TAMPILAN DESKTOP (TABEL) --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left w-10">
                                            <input type="checkbox" @change="toggleAll('bio')"
                                                :checked="isAllSelected('bio')"
                                                class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 cursor-pointer">
                                        </th>
                                        <th @click="sortBy('title')"
                                            class="px-6 py-3 text-left text-xs font-bold uppercase cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition group select-none">
                                            Judul Link <i class="fa-solid ml-1" :class="getSortIcon('title')"></i>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase">Halaman Bio</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase">Pemilik</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase">URL Tujuan</th>
                                        <th @click="sortBy('click_count')"
                                            class="px-6 py-3 text-center text-xs font-bold uppercase cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition group select-none">
                                            Klik <i class="fa-solid ml-1" :class="getSortIcon('click_count')"></i>
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-bold uppercase">Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($bioLinks as $link)
                                        <tr class="hover:bg-emerald-50/30 dark:hover:bg-gray-700/30 transition">
                                            <td class="px-6 py-4">
                                                <input type="checkbox" x-model="selectedLinks"
                                                    value="{{ $link->id }}"
                                                    class="bio-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 cursor-pointer">
                                            </td>
                                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                                {{ $link->title ?? 'Tanpa Judul' }}</td>
                                            <td class="px-6 py-4">
                                                @if ($link->page)
                                                    <a href="{{ url('/' . $link->page->handle) }}" target="_blank"
                                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 text-xs font-bold hover:bg-purple-100 hover:scale-105 transition-all dark:bg-purple-900/30 dark:text-purple-300">
                                                        <i class="fa-solid fa-pager"></i> {{ $link->page->title }} <i
                                                            class="fa-solid fa-arrow-up-right-from-square text-[9px] opacity-60 ml-0.5"></i>
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600">
                                                        {{ substr($link->user->name ?? 'G', 0, 1) }}</div>
                                                    <div class="text-xs font-bold text-gray-700 dark:text-gray-300">
                                                        {{ $link->user->name ?? 'Guest' }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-xs text-gray-500 truncate max-w-xs">
                                                <div class="flex items-center gap-2"
                                                    title="{{ $link->destination_url }}"><i
                                                        class="fa-solid fa-turn-up fa-rotate-90"></i><span
                                                        class="truncate w-32">{{ $link->destination_url }}</span></div>
                                            </td>
                                            <td
                                                class="px-6 py-4 text-center font-bold text-gray-600 dark:text-gray-300">
                                                {{ number_format($link->click_count) }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <button x-data="{ isActive: {{ $link->is_active ? 'true' : 'false' }} }"
                                                    @click="isActive = !isActive; fetch(`/admin/links/{{ $link->id }}/toggle`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })"
                                                    class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                                    :class="isActive ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600'">
                                                    <span
                                                        class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                        :class="isActive ? 'translate-x-4' : 'translate-x-0'"></span>
                                                </button>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <button type="button"
                                                    @click.prevent="deleteLink('{{ route('admin.links.destroy', $link) }}')"
                                                    class="text-red-400 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-12 text-center text-gray-400">Tidak ada
                                                data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- TAMPILAN MOBILE (CARDS) --}}
                        <div class="md:hidden flex flex-col gap-4 p-4 bg-gray-50 dark:bg-gray-900/50">
                            @forelse($bioLinks as $link)
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-emerald-100 dark:border-emerald-900/50 flex flex-col gap-3 relative">
                                    <div class="flex justify-between items-start gap-3">
                                        <div class="flex gap-3 items-start flex-1 min-w-0">
                                            <input type="checkbox" x-model="selectedLinks"
                                                value="{{ $link->id }}"
                                                class="bio-checkbox mt-1 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700">
                                            <div class="flex-1 min-w-0">
                                                <h4
                                                    class="font-bold text-gray-900 dark:text-white truncate text-sm mb-1">
                                                    {{ $link->title ?? 'Tanpa Judul' }}</h4>
                                                @if ($link->page)
                                                    <a href="{{ url('/' . $link->user->username) }}" target="_blank"
                                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 text-[10px] font-bold dark:bg-purple-900/30 dark:text-purple-300">
                                                        <i class="fa-solid fa-pager"></i> {{ $link->page->title }} <i
                                                            class="fa-solid fa-arrow-up-right-from-square text-[8px] opacity-60"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <button x-data="{ isActive: {{ $link->is_active ? 'true' : 'false' }} }"
                                            @click="isActive = !isActive; fetch(`/admin/links/{{ $link->id }}/toggle`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })"
                                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out"
                                            :class="isActive ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600'">
                                            <span
                                                class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                :class="isActive ? 'translate-x-4' : 'translate-x-0'"></span>
                                        </button>
                                    </div>
                                    <div
                                        class="bg-gray-50 dark:bg-gray-900/80 rounded-lg p-2 flex items-center justify-between gap-3 text-xs border border-gray-100 dark:border-gray-700">
                                        <a href="{{ $link->destination_url }}" target="_blank"
                                            class="truncate text-emerald-600 dark:text-emerald-400 font-medium w-full"><i
                                                class="fa-solid fa-turn-up fa-rotate-90 text-gray-400 mr-1"></i>
                                            {{ $link->destination_url }}</a>
                                        <span
                                            class="font-bold text-gray-600 dark:text-gray-300 flex items-center whitespace-nowrap"><i
                                                class="fa-solid fa-mouse-pointer text-[10px] text-gray-400 mr-1.5"></i>
                                            {{ number_format($link->click_count) }}</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-700 mt-1">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center text-[9px] font-bold text-gray-600">
                                                {{ substr($link->user->name ?? 'G', 0, 1) }}</div>
                                            <span
                                                class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $link->user->name ?? 'Guest' }}</span>
                                        </div>
                                        <button type="button"
                                            @click.prevent="deleteLink('{{ route('admin.links.destroy', $link) }}')"
                                            class="text-red-400 hover:text-red-600 p-1 rounded transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-sm text-gray-400">Tidak ada data.</div>
                            @endforelse
                        </div>

                        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                            {{ $bioLinks->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>

                {{-- ================= TAB 2: SHORTLINKS ================= --}}
                <div x-show="activeTab === 'short'" x-transition:enter="transition ease-out duration-200"
                    style="display: none;">
                    <div
                        class="bg-white dark:bg-gray-800 md:rounded-2xl shadow md:border border-emerald-100 dark:border-emerald-900/30 overflow-hidden">

                        <div
                            class="px-4 md:px-6 py-4 border-b dark:border-gray-700 bg-emerald-50/50 dark:bg-gray-800 flex items-center justify-between">
                            <h3 class="font-bold text-emerald-700 dark:text-emerald-400">⚡ Daftar Shortlink Langsung
                            </h3>
                            <div class="md:hidden flex items-center gap-2 text-xs font-bold text-gray-500">
                                <label for="selectAllShortMobile">Pilih Semua</label>
                                <input type="checkbox" id="selectAllShortMobile" @change="toggleAll('short')"
                                    :checked="isAllSelected('short')"
                                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </div>
                        </div>

                        {{-- TAMPILAN DESKTOP (TABEL) --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left w-10">
                                            <input type="checkbox" @change="toggleAll('short')"
                                                :checked="isAllSelected('short')"
                                                class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 cursor-pointer">
                                        </th>
                                        <th @click="sortBy('short_code')"
                                            class="px-6 py-3 text-left text-xs font-bold uppercase cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition group select-none">
                                            Short Code <i class="fa-solid ml-1"
                                                :class="getSortIcon('short_code')"></i>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase">Pemilik</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold uppercase">URL Tujuan</th>
                                        <th @click="sortBy('click_count')"
                                            class="px-6 py-3 text-center text-xs font-bold uppercase cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition group select-none">
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
                                                <input type="checkbox" x-model="selectedLinks"
                                                    value="{{ $link->id }}"
                                                    class="short-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 cursor-pointer">
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ url($link->short_code) }}" target="_blank"
                                                    class="font-mono font-bold text-emerald-600 hover:underline flex items-center gap-1">
                                                    /{{ $link->short_code }} <i
                                                        class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                                </a>
                                                <div class="text-[10px] text-gray-400 mt-1">
                                                    {{ $link->title ?? 'Untitled' }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600">
                                                        {{ substr($link->user->name ?? 'G', 0, 1) }}</div>
                                                    <div class="text-xs font-bold text-gray-700 dark:text-gray-300">
                                                        {{ $link->user->name ?? 'Guest' }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-xs text-gray-500 truncate max-w-xs">
                                                <div class="flex items-center gap-2"
                                                    title="{{ $link->destination_url }}"><i
                                                        class="fa-solid fa-turn-up fa-rotate-90"></i><span
                                                        class="truncate w-32">{{ $link->destination_url }}</span>
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 text-center font-bold text-gray-600 dark:text-gray-300">
                                                {{ number_format($link->click_count) }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <button x-data="{ isActive: {{ $link->is_active ? 'true' : 'false' }} }"
                                                    @click="isActive = !isActive; fetch(`/admin/links/{{ $link->id }}/toggle`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })"
                                                    class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                                    :class="isActive ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600'">
                                                    <span
                                                        class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                        :class="isActive ? 'translate-x-4' : 'translate-x-0'"></span>
                                                </button>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <button type="button"
                                                    @click.prevent="deleteLink('{{ route('admin.links.destroy', $link) }}')"
                                                    class="text-red-400 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada
                                                data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- TAMPILAN MOBILE (CARDS) --}}
                        <div class="md:hidden flex flex-col gap-4 p-4 bg-gray-50 dark:bg-gray-900/50">
                            @forelse($shortLinks as $link)
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-emerald-100 dark:border-emerald-900/50 flex flex-col gap-3 relative">
                                    <div class="flex justify-between items-start gap-3">
                                        <div class="flex gap-3 items-start flex-1 min-w-0">
                                            <input type="checkbox" x-model="selectedLinks"
                                                value="{{ $link->id }}"
                                                class="short-checkbox mt-1 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700">
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ url($link->short_code) }}" target="_blank"
                                                    class="font-mono font-bold text-emerald-600 hover:underline flex items-center gap-1.5 text-sm mb-1">
                                                    /{{ $link->short_code }} <i
                                                        class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-70"></i>
                                                </a>
                                                <h4 class="text-[10px] text-gray-500 dark:text-gray-400 truncate">
                                                    {{ $link->title ?? 'Untitled' }}</h4>
                                            </div>
                                        </div>
                                        <button x-data="{ isActive: {{ $link->is_active ? 'true' : 'false' }} }"
                                            @click="isActive = !isActive; fetch(`/admin/links/{{ $link->id }}/toggle`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })"
                                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out"
                                            :class="isActive ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600'">
                                            <span
                                                class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                :class="isActive ? 'translate-x-4' : 'translate-x-0'"></span>
                                        </button>
                                    </div>
                                    <div
                                        class="bg-gray-50 dark:bg-gray-900/80 rounded-lg p-2 flex items-center justify-between gap-3 text-xs border border-gray-100 dark:border-gray-700">
                                        <a href="{{ $link->destination_url }}" target="_blank"
                                            class="truncate text-emerald-600 dark:text-emerald-400 font-medium w-full"><i
                                                class="fa-solid fa-turn-up fa-rotate-90 text-gray-400 mr-1"></i>
                                            {{ $link->destination_url }}</a>
                                        <span
                                            class="font-bold text-gray-600 dark:text-gray-300 flex items-center whitespace-nowrap"><i
                                                class="fa-solid fa-mouse-pointer text-[10px] text-gray-400 mr-1.5"></i>
                                            {{ number_format($link->click_count) }}</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-700 mt-1">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center text-[9px] font-bold text-gray-600">
                                                {{ substr($link->user->name ?? 'G', 0, 1) }}</div>
                                            <span
                                                class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $link->user->name ?? 'Guest' }}</span>
                                        </div>
                                        <button type="button"
                                            @click.prevent="deleteLink('{{ route('admin.links.destroy', $link) }}')"
                                            class="text-red-400 hover:text-red-600 p-1 rounded transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-sm text-gray-400">Tidak ada data.</div>
                            @endforelse
                        </div>

                        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                            {{ $shortLinks->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- SCRIPT ALPINE JS --}}
    <script>
        function linkHandler() {
            return {
                activeTab: localStorage.getItem('admin_link_tab') || 'bio',

                sortCol: '{{ request('sort', 'created_at') }}',
                sortDir: '{{ request('dir', 'desc') }}',
                search: '{{ request('search') }}',

                isLoading: false,
                selectedLinks: [],

                toast: {
                    show: false,
                    message: ''
                },

                init() {
                    this.$watch('activeTab', value => localStorage.setItem('admin_link_tab', value));
                },

                showToast(msg) {
                    this.toast.message = msg;
                    this.toast.show = true;
                    setTimeout(() => {
                        this.toast.show = false;
                    }, 3000);
                },

                deleteLink(url) {
                    if (!confirm('Yakin ingin menghapus link ini secara permanen?')) return;

                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                this.showToast(data.message);
                                this.selectedLinks = []; // PERBAIKAN: Selalu kosongkan array agar banner hilang

                                // PERBAIKAN: Tambahkan parameter `true` agar posisinya tetap di page saat ini
                                this.fetchResults(null, true);
                            } else {
                                alert('Gagal menghapus data.');
                            }
                        })
                        .catch(err => alert('Terjadi kesalahan jaringan!'));
                },

                deleteBulk(url) {
                    if (!confirm('Yakin ingin menghapus ' + this.selectedLinks.length + ' link terpilih secara permanen?'))
                        return;

                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                ids: this.selectedLinks
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                this.showToast(data.message);
                                this.selectedLinks = []; // PERBAIKAN: Kosongkan array agar banner hilang

                                // PERBAIKAN: Tambahkan parameter `true` agar posisinya tetap di page saat ini
                                this.fetchResults(null, true);
                            } else {
                                alert('Gagal menghapus data massal.');
                            }
                        })
                        .catch(err => alert('Terjadi kesalahan jaringan!'));
                },

                getPageIds(type) {
                    let elements = Array.from(document.querySelectorAll('.' + type + '-checkbox'));
                    return [...new Set(elements.map(el => el.value))];
                },

                toggleAll(type) {
                    let ids = this.getPageIds(type);
                    let allSelected = this.isAllSelected(type);

                    if (allSelected) {
                        this.selectedLinks = this.selectedLinks.filter(id => !ids.includes(id));
                    } else {
                        ids.forEach(id => {
                            if (!this.selectedLinks.includes(id)) this.selectedLinks.push(id);
                        });
                    }
                },

                isAllSelected(type) {
                    let ids = this.getPageIds(type);
                    if (ids.length === 0) return false;
                    return ids.every(id => this.selectedLinks.includes(id));
                },

                handlePagination(e) {
                    let link = e.target.closest('nav[role="navigation"] a');

                    if (link && link.href) {
                        e.preventDefault();
                        this.fetchResults(link.href);
                    }
                },

                // PERBAIKAN: Tambahkan argumen `keepPage = false`
                fetchResults(customUrl = null, keepPage = false) {
                    this.isLoading = true;

                    let targetUrl = customUrl ? new URL(customUrl) : new URL(window.location.href);

                    if (!customUrl) {
                        if (this.search) targetUrl.searchParams.set('search', this.search);
                        else targetUrl.searchParams.delete('search');

                        targetUrl.searchParams.set('sort', this.sortCol);
                        targetUrl.searchParams.set('dir', this.sortDir);

                        // PERBAIKAN: Parameter halaman HANYA dihapus jika sedang mencari/menyortir data (keepPage = false)
                        if (!keepPage) {
                            targetUrl.searchParams.delete('bio_page');
                            targetUrl.searchParams.delete('short_page');
                        }
                    }

                    fetch(targetUrl.toString(), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            document.getElementById('links-container').innerHTML = doc.getElementById('links-container')
                                .innerHTML;

                            this.isLoading = false;

                            window.history.pushState({}, '', targetUrl.toString());
                        })
                        .catch(err => {
                            console.error('AJAX/Pagination gagal', err);
                            this.isLoading = false;
                        });
                },

                sortBy(column) {
                    if (this.sortCol === column) {
                        this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortCol = column;
                        this.sortDir = 'desc';
                    }
                    this.fetchResults();
                },

                getSortIcon(column) {
                    if (this.sortCol !== column) return 'fa-sort text-gray-300 opacity-0 group-hover:opacity-50';
                    return this.sortDir === 'asc' ? 'fa-sort-up text-emerald-500' : 'fa-sort-down text-emerald-500';
                }
            }
        }
    </script>
</x-app-layout>
