<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Halaman: {{ $page->title }}
        </h2>
        <p class="text-sm text-gray-500 mt-1">Ubah tampilan, ganti logo, dan atur tema halaman ini.</p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show"
                    class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-sm flex justify-between items-center mx-4 lg:mx-0">
                    <div class="flex items-center text-emerald-700">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600"><svg class="w-5 h-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg></button>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <div class="lg:col-span-7 space-y-6 mx-4 lg:mx-0">

                    <div
                        class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
                        <div
                            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                            <h3 class="font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                🎨 Informasi Halaman
                            </h3>
                        </div>

                        <div class="p-6 md:p-8">
                            <form action="{{ route('pages.update', $page->id) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="flex flex-col sm:flex-row items-center gap-6">
                                    <div class="relative group">
                                        @if ($page->avatar)
                                            <img id="avatar-preview"
                                                class="h-24 w-24 rounded-full object-cover border-4 border-emerald-100 shadow-md"
                                                src="{{ asset('storage/' . $page->avatar) }}" alt="Avatar">
                                        @else
                                            <div id="avatar-preview-default"
                                                class="h-24 w-24 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-3xl border-4 border-white shadow-md">
                                                {{ substr($page->title, 0, 1) }}
                                            </div>
                                            <img id="avatar-preview"
                                                class="hidden h-24 w-24 rounded-full object-cover border-4 border-emerald-100 shadow-md">
                                        @endif

                                        <label for="avatar"
                                            class="absolute inset-0 flex items-center justify-center bg-black/40 text-white rounded-full opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </label>
                                        <input id="avatar" name="avatar" type="file" class="hidden"
                                            accept="image/*" onchange="previewImage(this)">
                                    </div>
                                    <div class="text-center sm:text-left">
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100">Logo / Foto
                                            Profil</h4>
                                        <p class="text-xs text-gray-500 mt-1">Klik gambar untuk mengganti.<br>Max: 2MB.
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="group">
                                        <label
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Link
                                            URL</label>
                                        <div
                                            class="flex rounded-xl shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-emerald-500 bg-white dark:bg-gray-900 dark:ring-gray-600">
                                            <span
                                                class="flex select-none items-center pl-3 pr-2 text-gray-500 sm:text-sm bg-gray-50 dark:bg-gray-800 rounded-l-xl border-r border-gray-200 dark:border-gray-700">
                                                {{ request()->getHost() }}/
                                            </span>
                                            <input type="text" name="handle"
                                                value="{{ old('handle', $page->handle) }}"
                                                class="block flex-1 border-0 bg-transparent py-2.5 pl-2 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 rounded-r-xl"
                                                placeholder="nama-unik">
                                        </div>
                                    </div>

                                    <div class="group">
                                        <label
                                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Judul
                                            Halaman</label>
                                        <input type="text" name="title" value="{{ old('title', $page->title) }}"
                                            class="w-full px-4 py-2.5 rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Pilih
                                        Tema</label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach (['default' => 'Emerald', 'ocean' => 'Ocean', 'sunset' => 'Sunset', 'midnight' => 'Midnight'] as $key => $label)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="theme" value="{{ $key }}"
                                                    class="peer sr-only" {{ $page->theme == $key ? 'checked' : '' }}>
                                                <div
                                                    class="rounded-xl border-2 border-transparent peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-200 overflow-hidden shadow-sm hover:shadow-md transition">
                                                    <div
                                                        class="h-12 w-full 
                                                        {{ $key == 'default' ? 'bg-gradient-to-br from-gray-900 via-emerald-900 to-gray-900' : '' }}
                                                        {{ $key == 'ocean' ? 'bg-gradient-to-br from-blue-400 to-blue-600' : '' }}
                                                        {{ $key == 'sunset' ? 'bg-gradient-to-br from-orange-400 to-pink-600' : '' }}
                                                        {{ $key == 'midnight' ? 'bg-gray-900' : '' }}
                                                    ">
                                                    </div>
                                                    <div
                                                        class="p-2 text-center text-xs font-bold bg-white dark:bg-gray-700 dark:text-white">
                                                        {{ $label }}</div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <button type="submit"
                                        class="w-full md:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-0.5 flex justify-center items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                            </path>
                                        </svg>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block lg:col-span-5 sticky top-24">
                    <div class="flex flex-col items-center">
                        <h3 class="text-gray-500 font-bold text-sm mb-4 uppercase tracking-widest">Live Preview</h3>
                        <div
                            class="relative mx-auto border-gray-900 bg-gray-900 border-[14px] rounded-[2.5rem] h-[650px] w-[320px] shadow-2xl flex flex-col justify-start overflow-hidden">
                            <div class="absolute top-0 right-0 z-50 p-3">
                                <button
                                    onclick="document.getElementById('previewFrame').contentWindow.location.reload();"
                                    class="p-1.5 bg-black/20 hover:bg-black/40 rounded-full text-white backdrop-blur-sm transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="w-full h-full bg-white rounded-[2rem] overflow-hidden relative">
                                <iframe id="previewFrame" src="{{ url($page->handle) }}"
                                    class="w-[125%] h-[125%] origin-top-left transform scale-80 border-0 bg-white"
                                    frameborder="0"></iframe>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="{{ url($page->handle) }}" target="_blank"
                                class="text-emerald-600 font-bold hover:underline flex items-center justify-center">
                                Buka di Tab Baru <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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
        function previewImage(input) {
            const preview = document.getElementById('avatar-preview');
            const defaultPreview = document.getElementById('avatar-preview-default');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (defaultPreview) defaultPreview.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
