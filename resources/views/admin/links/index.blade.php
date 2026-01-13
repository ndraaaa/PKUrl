<x-app-layout>
    <x-slot name="title">Manajemen Link</x-slot>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="font-bold text-2xl text-emerald-800 dark:text-emerald-200">
                🔗 Manajemen Link Global
            </h2>
            <p class="text-sm text-emerald-600 dark:text-emerald-400">
                Semua link pengguna & shortlink
            </p>
        </div>
    </x-slot>

    <div class="py-10" x-data="{ tab: 'bio' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- FLASH --}}
            @if(session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl shadow">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" class="flex flex-col md:flex-row gap-3">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul, URL, short code..."
                    class="w-full md:w-96 rounded-xl border border-emerald-200 px-4 py-2
                           focus:ring-2 focus:ring-emerald-500 focus:outline-none
                           dark:bg-gray-800 dark:border-emerald-900 dark:text-white"
                />

                <button
                    type="submit"
                    class="px-6 py-2 rounded-xl bg-emerald-600 text-white font-bold
                           hover:bg-emerald-700 transition">
                    Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('admin.links.index') }}"
                       class="px-6 py-2 rounded-xl bg-gray-100 text-gray-600 font-bold
                              hover:bg-gray-200 transition text-center">
                        Reset
                    </a>
                @endif
            </form>

            {{-- TAB --}}
            <div class="flex gap-2 bg-white dark:bg-gray-800 p-2 rounded-2xl shadow border border-emerald-100 dark:border-emerald-900/30">
                <button @click="tab = 'bio'"
                    :class="tab === 'bio' ? 'bg-emerald-600 text-white shadow' : 'text-emerald-700 hover:bg-emerald-50'"
                    class="flex-1 py-3 rounded-xl font-bold transition">
                    🌿 Bio Link
                </button>

                <button @click="tab = 'short'"
                    :class="tab === 'short' ? 'bg-emerald-600 text-white shadow' : 'text-emerald-700 hover:bg-emerald-50'"
                    class="flex-1 py-3 rounded-xl font-bold transition">
                    ⚡ Shortlink
                </button>
            </div>

            {{-- ================= BIO LINKS ================= --}}
            <div x-show="tab === 'bio'" x-transition>
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border border-emerald-100 dark:border-emerald-900/30 overflow-hidden">

                    <div class="px-6 py-4 border-b">
                        <h3 class="font-bold text-emerald-700">🌿 Bio Links</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Judul Link</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Nama Page</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Pemilik</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">URL</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase">Hapus</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @forelse($bioLinks as $link)
                                <tr class="hover:bg-emerald-50/30">
                                    <td class="px-6 py-4 font-semibold">{{ $link->title }}</td>

                                    <td class="px-6 py-4 text-sm font-semibold text-emerald-700">
                                        {{ $link->page->title ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-bold">{{ $link->page->user->name }}</div>
                                        <div class="text-xs text-emerald-500 font-mono">
                                            {{ '@'.$link->page->user->username }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-xs text-gray-500 truncate max-w-xs">
                                        {{ $link->original_url }}
                                    </td>

                                    {{-- TOGGLE --}}
                                    <td class="px-6 py-4 text-center">
                                        <form method="POST" action="{{ route('admin.links.toggle', $link) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition
                                                {{ $link->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}">
                                                <span
                                                    class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition
                                                    {{ $link->is_active ? 'translate-x-5' : 'translate-x-1' }}">
                                                </span>
                                            </button>
                                        </form>
                                    </td>

                                    {{-- DELETE --}}
                                    <td class="px-6 py-4 text-center">
                                        <form method="POST" action="{{ route('admin.links.destroy', $link) }}"
                                              onsubmit="return confirm('Hapus link ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:text-red-700 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-gray-400">
                                        Tidak ada bio link
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4">{{ $bioLinks->links() }}</div>
                </div>
            </div>

            {{-- ================= SHORTLINK ================= --}}
            <div x-show="tab === 'short'" x-transition>
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border overflow-hidden">

                    <div class="px-6 py-4 border-b">
                        <h3 class="font-bold text-emerald-700">⚡ Shortlink</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y">
                            <thead class="bg-emerald-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">Pembuat</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold uppercase">URL Tujuan</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase">Klik</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold uppercase">Hapus</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @forelse($shortLinks as $link)
                                <tr class="hover:bg-emerald-50/30">
                                    <td class="px-6 py-4">
                                        <a href="{{ url($link->short_code) }}"
                                        target="_blank"
                                        class="font-mono font-bold text-emerald-600 hover:underline">
                                            /{{ $link->short_code }}
                                        </a>
                                    </td>


                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-bold">{{ $link->user->name }}</div>
                                        <div class="text-xs text-emerald-500 font-mono">
                                            {{ '@'.$link->user->username }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-xs text-gray-500 truncate max-w-xs">
                                        {{ $link->original_url }}
                                    </td>

                                    <td class="px-6 py-4 text-center font-bold">
                                        {{ $link->click_count }}
                                    </td>

                                    {{-- TOGGLE --}}
                                    <td class="px-6 py-4 text-center">
                                        <form method="POST" action="{{ route('admin.links.toggle', $link) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition
                                                {{ $link->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}">
                                                <span
                                                    class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition
                                                    {{ $link->is_active ? 'translate-x-5' : 'translate-x-1' }}">
                                                </span>
                                            </button>
                                        </form>
                                    </td>

                                    {{-- DELETE --}}
                                    <td class="px-6 py-4 text-center">
                                        <form method="POST" action="{{ route('admin.links.destroy', $link) }}"
                                              onsubmit="return confirm('Hapus shortlink ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:text-red-700 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-gray-400">
                                        Tidak ada shortlink
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4">{{ $shortLinks->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
