<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Halaman Bio / Link-in-Bio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Profil Bio</h3>

                        <form action="{{ route('bio.update.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="flex flex-col items-center mb-4">
                                <div
                                    class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 mb-2 border-2 border-indigo-500">
                                    @if ($user->profile)
                                        <img src="{{ asset('storage/' . $user->profile) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-gray-400 text-2xl font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <label for="profile"
                                    class="cursor-pointer text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                    Ganti Foto
                                </label>
                                <input type="file" name="profile" id="profile" class="hidden"
                                    onchange="this.form.submit()">
                            </div>

                            <div class="mb-4">
                                <x-input-label for="username" value="Username (URL)" />
                                <div class="flex mt-1">
                                    <span
                                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">@</span>
                                    <x-text-input id="username" name="username" type="text"
                                        class="block w-full rounded-l-none" :value="old('username', $user->username)" placeholder="namaanda" />
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('username')" />
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Tema Background</label>
                                
                                <div class="grid grid-cols-5 gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="theme" value="default" class="peer sr-only" {{ $user->theme == 'default' ? 'checked' : '' }}>
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-500 via-red-500 to-yellow-500 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-indigo-500 transition-all hover:scale-110" title="Default"></div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="theme" value="ocean" class="peer sr-only" {{ $user->theme == 'ocean' ? 'checked' : '' }}>
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-800 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-indigo-500 transition-all hover:scale-110" title="Ocean Blue"></div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="theme" value="midnight" class="peer sr-only" {{ $user->theme == 'midnight' ? 'checked' : '' }}>
                                        <div class="w-10 h-10 rounded-full bg-gray-800 border border-gray-600 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-indigo-500 transition-all hover:scale-110" title="Midnight"></div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="theme" value="sunset" class="peer sr-only" {{ $user->theme == 'sunset' ? 'checked' : '' }}>
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-indigo-500 transition-all hover:scale-110" title="Sunset"></div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="theme" value="nature" class="peer sr-only" {{ $user->theme == 'nature' ? 'checked' : '' }}>
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-emerald-700 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-indigo-500 transition-all hover:scale-110" title="Nature"></div>
                                    </label>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('theme')" />
                            </div>

                            <x-primary-button class="w-full justify-center">{{ __('Simpan Profil') }}</x-primary-button>
                        </form>

                        @if ($user->username)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-xs text-center text-gray-500 mb-2">Link Bio Anda:</p>
                                <a href="{{ url('@' . $user->username) }}" target="_blank"
                                    class="block w-full text-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Lihat Halaman Publik
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-2">

                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tambah Tombol Link</h3>
                        <form action="{{ route('bio.link.store') }}" method="POST"
                            class="flex flex-col sm:flex-row gap-4">
                            @csrf
                            <div class="flex-1">
                                <x-text-input name="title" type="text" class="w-full"
                                    placeholder="Judul (Contoh: WhatsApp Saya)" required />
                            </div>
                            <div class="flex-1">
                                <x-text-input name="original_url" type="url" class="w-full"
                                    placeholder="URL Tujuan (https://...)" required />
                            </div>
                            <x-primary-button>{{ __('Tambah') }}</x-primary-button>
                        </form>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Judul Tombol</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        URL Tujuan</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($links as $link)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $link->title }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <div class="truncate w-48">{{ $link->original_url }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('bio.link.destroy', $link->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus tombol ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Belum ada link tombol. Tambahkan di atas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
