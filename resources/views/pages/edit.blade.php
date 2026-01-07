<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <a href="{{ route('dashboard') }}" class="mr-2 text-gray-400 hover:text-emerald-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                Editor: {{ $page->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ url($page->handle) }}" target="_blank"
                    class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-50 transition flex items-center">
                    Buka Link
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ activeTab: 'links' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show"
                    class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-sm flex justify-between items-center">
                    <div class="flex items-center text-emerald-700">
                        <span class="font-bold mr-2">Sukses!</span> {{ session('success') }}
                    </div>
                    <button @click="show = false" class="text-emerald-400">✕</button>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <div class="lg:col-span-7 space-y-6">

                    <div class="bg-gray-200 dark:bg-gray-700 p-1 rounded-xl flex">
                        <button @click="activeTab = 'links'"
                            :class="activeTab === 'links' ? 'bg-white dark:bg-gray-800 text-emerald-600 shadow-sm' :
                                'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                            class="flex-1 py-2.5 rounded-lg text-sm font-bold transition duration-200 flex justify-center items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                            Tautan (Links)
                        </button>
                        <button @click="activeTab = 'appearance'"
                            :class="activeTab === 'appearance' ? 'bg-white dark:bg-gray-800 text-emerald-600 shadow-sm' :
                                'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                            class="flex-1 py-2.5 rounded-lg text-sm font-bold transition duration-200 flex justify-center items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                                </path>
                            </svg>
                            Tampilan & Profil
                        </button>
                    </div>

                    <div x-show="activeTab === 'links'" x-data="{
                        editModalOpen: false,
                        editAction: '',
                        editTitle: '',
                        editUrl: '',
                        openEditModal(id, title, url) {
                            this.editAction = '/links/' + id; // Set URL Action Form
                            this.editTitle = title;
                            this.editUrl = url;
                            this.editModalOpen = true;
                        }
                    }"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0">

                        <div
                            class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden mb-6 border border-gray-100 dark:border-gray-700">
                            <div class="p-6">
                                <h3 class="font-bold text-gray-800 dark:text-white mb-4">Tambah Tombol Baru</h3>
                                <form method="post" action="{{ route('links.store', $page->id) }}"
                                    class="flex flex-col gap-4">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="md:col-span-1">
                                            <input type="text" name="title" required
                                                placeholder="Judul (mis: WhatsApp)"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                        </div>
                                        <div class="md:col-span-2">
                                            <input type="url" name="original_url" required
                                                placeholder="URL (https://...)"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-600/20 transition">
                                        Tambahkan ke Bio
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @forelse($links as $link)
                                <div
                                    class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between group hover:border-emerald-300 transition">
                                    <div class="flex items-center gap-4 overflow-hidden">
                                        <div class="text-gray-300 cursor-move"><svg class="w-5 h-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 8h16M4 16h16"></path>
                                            </svg></div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-800 dark:text-white truncate">
                                                {{ $link->title }}</h4>
                                            <p class="text-xs text-gray-500 truncate">{{ $link->original_url }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs font-bold mr-2">
                                            {{ $link->click_count }} klik</div>

                                        <form action="{{ route('links.toggle', $link->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button
                                                class="w-8 h-5 rounded-full relative transition-colors duration-200 ease-in-out {{ $link->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}">
                                                <span
                                                    class="absolute top-1 left-1 bg-white w-3 h-3 rounded-full transition-transform duration-200 {{ $link->is_active ? 'translate-x-3' : '' }}"></span>
                                            </button>
                                        </form>

                                        <button
                                            @click="openEditModal('{{ $link->id }}', '{{ addslashes($link->title) }}', '{{ $link->original_url }}')"
                                            class="p-2 text-gray-400 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        <form action="{{ route('links.destroy', $link->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition"><svg
                                                    class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg></button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-center py-10 text-gray-500 bg-white dark:bg-gray-800 rounded-xl border border-dashed border-gray-300">
                                    Belum ada link. Tambahkan di atas.</div>
                            @endforelse
                        </div>

                        <div x-show="editModalOpen" style="display: none;"
                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm"
                            x-transition.opacity>

                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
                                @click.away="editModalOpen = false">
                                <div
                                    class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Edit Tautan</h3>
                                    <button @click="editModalOpen = false"
                                        class="text-gray-400 hover:text-gray-600">✕</button>
                                </div>

                                <form :action="editAction" method="POST" enctype="multipart/form-data"
                                    class="p-6 space-y-4">
                                    @csrf
                                    @method('PUT') <div>
                                        <label
                                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Judul
                                            Tombol</label>
                                        <input type="text" name="title" x-model="editTitle" required
                                            class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">URL
                                            Tujuan</label>
                                        <input type="url" name="original_url" x-model="editUrl" required
                                            class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    </div>

                                    <div class="pt-2 flex justify-end gap-2">
                                        <button type="button" @click="editModalOpen = false"
                                            class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-lg transition">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow-md transition">Simpan
                                            Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'appearance'" style="display: none;"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <div
                            class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl p-8 border border-gray-100 dark:border-gray-700">
                            <form action="{{ route('pages.update', $page->id) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-8">
                                @csrf @method('PUT')

                                <div
                                    class="flex flex-col sm:flex-row items-center gap-6 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl">
                                    <div class="relative group cursor-pointer">
                                        @if ($page->avatar)
                                            <img id="preview-avatar" src="{{ asset('storage/' . $page->avatar) }}"
                                                class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg group-hover:brightness-75 transition">
                                        @else
                                            <div id="default-avatar"
                                                class="w-24 h-24 rounded-full bg-gradient-to-tr from-emerald-400 to-teal-600 flex items-center justify-center text-white font-bold text-3xl border-4 border-white shadow-lg">
                                                {{ substr($page->title, 0, 1) }}</div>
                                            <img id="preview-avatar"
                                                class="hidden w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                                        @endif
                                        <input type="file" name="avatar"
                                            class="absolute inset-0 opacity-0 cursor-pointer"
                                            onchange="previewImage(this)">
                                        <div
                                            class="absolute inset-0 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="text-center sm:text-left">
                                        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Foto Profil</h4>
                                        <p class="text-sm text-gray-500">Gunakan foto rasio 1:1 untuk hasil terbaik.
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-1">
                                        <label
                                            class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Judul
                                            Halaman</label>
                                        <input type="text" name="title" value="{{ $page->title }}"
                                            class="w-full rounded-2xl border-gray-200 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white transition">
                                    </div>
                                    <div class="space-y-1">
                                        <label
                                            class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">URL
                                            Handle</label>
                                        <div
                                            class="flex rounded-2xl border border-gray-200 overflow-hidden dark:border-gray-700 focus-within:ring-2 focus-within:ring-emerald-500 transition">
                                            <span
                                                class="bg-gray-100 dark:bg-gray-800 px-4 py-2 text-gray-500 font-medium border-r dark:border-gray-700 flex items-center">link.me/</span>
                                            <input type="text" name="handle" value="{{ $page->handle }}"
                                                class="flex-1 border-0 focus:ring-0 dark:bg-gray-900 dark:text-white font-medium">
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label
                                        class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Latar
                                        Belakang Kustom</label>

                                    <div class="relative group">
                                        <div id="dropzone"
                                            class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-3xl p-8 transition-all duration-300 group-hover:border-emerald-400 group-hover:bg-emerald-50/30 flex flex-col items-center justify-center text-center overflow-hidden h-48">

                                            @if ($page->background_image)
                                                <img id="bg-preview-img"
                                                    src="{{ asset('storage/' . $page->background_image) }}"
                                                    class="absolute inset-0 w-full h-full object-cover opacity-20">
                                            @else
                                                <img id="bg-preview-img"
                                                    class="absolute inset-0 w-full h-full object-cover opacity-20 hidden">
                                            @endif

                                            <div class="relative z-10">
                                                <div
                                                    class="mx-auto w-12 h-12 mb-3 text-gray-400 group-hover:text-emerald-500 transition-colors">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                                    <span class="text-emerald-600 font-bold">Klik untuk upload</span>
                                                    atau seret gambar ke sini
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">PNG, JPG atau WEBP (Maks. 2MB)
                                                </p>
                                            </div>

                                            <input type="file" name="background_image"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                                onchange="previewBg(this)">
                                        </div>

                                        @if ($page->background_image)
                                            <div
                                                class="mt-3 flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-900/30">
                                                <div class="flex items-center text-red-600 dark:text-red-400">
                                                    <input type="checkbox" name="remove_background" id="remove_bg"
                                                        class="rounded-md text-red-600 focus:ring-red-500">
                                                    <label for="remove_bg"
                                                        class="ml-2 text-xs font-bold uppercase tracking-tight">Hapus
                                                        gambar latar saat ini</label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label
                                        class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Pilih
                                        Tema Standar</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                        @foreach (['default' => 'Emerald', 'ocean' => 'Ocean', 'sunset' => 'Sunset', 'midnight' => 'Midnight'] as $key => $label)
                                            <label class="relative cursor-pointer group">
                                                <input type="radio" name="theme" value="{{ $key }}"
                                                    class="peer sr-only" {{ $page->theme == $key ? 'checked' : '' }}>
                                                <div
                                                    class="h-20 w-full rounded-2xl border-4 border-transparent peer-checked:border-emerald-500 peer-checked:shadow-lg transition-all duration-300 relative overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700">
                                                    <div
                                                        class="absolute inset-0 
                                                        {{ $key == 'default' ? 'bg-gradient-to-br from-gray-900 via-emerald-900 to-gray-900' : '' }}
                                                        {{ $key == 'ocean' ? 'bg-gradient-to-br from-blue-400 to-blue-600' : '' }}
                                                        {{ $key == 'sunset' ? 'bg-gradient-to-br from-orange-400 to-pink-600' : '' }}
                                                        {{ $key == 'midnight' ? 'bg-gray-900' : '' }}">
                                                    </div>
                                                    <div
                                                        class="absolute bottom-2 left-2 right-2 text-[10px] font-bold text-white bg-black/20 backdrop-blur-md py-1 px-2 rounded-lg text-center uppercase tracking-tighter">
                                                        {{ $label }}
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="pt-6">
                                    <button type="submit"
                                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-emerald-600/30 transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block lg:col-span-5 sticky top-24">
                    <div class="flex flex-col items-center">

                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-4">Live Preview</h3>

                        <div
                            class="relative mx-auto border-gray-900 bg-gray-900 border-[10px] rounded-[3rem] h-[650px] w-[320px] shadow-2xl flex flex-col justify-start overflow-hidden ring-1 ring-gray-900/50">

                            <div class="absolute top-0 inset-x-0 h-6 bg-gray-900 z-20 flex justify-center">
                                <div class="h-4 w-20 bg-black rounded-b-xl"></div>
                            </div>

                            <div class="absolute top-8 right-4 z-50">
                                <button
                                    onclick="document.getElementById('previewFrame').contentWindow.location.reload();"
                                    class="p-1.5 bg-black/20 hover:bg-black/50 rounded-full text-white backdrop-blur-md transition border border-white/10 shadow-sm"
                                    title="Refresh Preview">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <div class="w-full h-full bg-white rounded-[2.5rem] overflow-hidden relative z-10">

                                <div class="w-[375px] h-[812px] origin-top-left transform scale-[0.8]">
                                    <iframe id="previewFrame" src="{{ url($page->handle) }}"
                                        class="w-full h-full border-0" scrolling="yes">
                                    </iframe>
                                </div>

                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <p class="text-xs text-gray-400">Tampilan mungkin sedikit berbeda di perangkat asli.</p>
                            <a href="{{ url($page->handle) }}" target="_blank"
                                class="mt-2 inline-flex items-center text-sm font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                                Buka di Tab Baru
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function previewBg(input) {
            const previewImg = document.getElementById('bg-preview-img');
            const dropzone = document.getElementById('dropzone');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    // Tambahkan efek visual bahwa gambar telah terpilih
                    dropzone.classList.add('border-emerald-500', 'bg-emerald-50/50');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewImage(input) {
            const preview = document.getElementById('preview-avatar');
            const defaultDiv = document.getElementById('default-avatar');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (defaultDiv) defaultDiv.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
