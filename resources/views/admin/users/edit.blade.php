<x-app-layout>
    <x-slot name="title">Edit User | {{ $user->name }}</x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users') }}"
               class="p-2 bg-white dark:bg-gray-800 rounded-xl shadow hover:bg-emerald-50 transition">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-emerald-800 dark:text-emerald-200">
                Edit Profil Pengguna
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-emerald-50/40 dark:bg-gray-900/50">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                    <div class="lg:col-span-1">
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xl border border-emerald-100 dark:border-emerald-900/30 text-center">

                            <div class="relative inline-flex justify-center group">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-3xl blur opacity-40 group-hover:opacity-70 transition"></div>

                                {{-- FOTO --}}
                                @if($user->profile)
                                    <img id="previewProfile"
                                        src="{{ asset('storage/'.$user->profile) }}"
                                        class="relative h-24 w-24 rounded-3xl object-cover shadow-xl border-4 border-white dark:border-gray-800">
                                @else
                                    <div id="previewProfile"
                                        class="relative h-24 w-24 rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-700 
                                                flex items-center justify-center text-white text-3xl font-extrabold shadow-xl">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif

                                {{-- INPUT FILE --}}
                                <label
                                    class="absolute inset-0 cursor-pointer flex items-center justify-center
                                        bg-black/0 hover:bg-black/40 rounded-3xl transition">
                                    <span class="text-white opacity-0 group-hover:opacity-100 font-bold text-sm">
                                        Ganti Foto
                                    </span>
                                    <input type="file"
                                        name="profile"
                                        accept="image/*"
                                        class="hidden"
                                        onchange="previewImage(this)">
                                </label>
                            </div>

                            <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </h3>

                            <p class="text-sm font-mono text-emerald-600 font-semibold">
                                {{'@'. $user->username }}
                            </p>

                            <div
                                class="mt-6 grid grid-cols-2 gap-4 pt-4 border-t border-emerald-100 dark:border-emerald-900/30">
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-emerald-400 tracking-widest">Role</p>
                                    <span
                                        class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold
                                        {{ $user->role === 'admin'
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-[10px] uppercase font-bold text-emerald-400 tracking-widest">Bergabung
                                    </p>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        {{ $user->created_at->format('M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-8">

                        {{-- INFORMASI PROFIL --}}
                        <div
                            class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl border border-emerald-100 dark:border-emerald-900/30">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="p-2 bg-emerald-100 text-emerald-600 rounded-xl">👤</div>
                                <h4
                                    class="font-bold uppercase tracking-widest text-sm text-emerald-700 dark:text-emerald-400">
                                    Informasi Profil
                                </h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="name" value="Nama Lengkap"
                                                   class="font-semibold text-emerald-700"/>
                                    <x-text-input id="name" name="name"
                                                  class="mt-1 block w-full rounded-2xl border-emerald-100 dark:bg-gray-900 focus:ring-emerald-500"
                                                  :value="old('name', $user->name)" required/>
                                </div>

                                <div>
                                    <x-input-label for="username" value="Username"
                                                   class="font-semibold text-emerald-700"/>
                                    <div class="relative mt-1">
                                        <span
                                            class="absolute inset-y-0 left-4 flex items-center text-emerald-400 font-bold ml-2">@</span>
                                        <x-text-input id="username" name="username"
                                                      class="pl-9 block w-full rounded-2xl border-emerald-100 dark:bg-gray-900 focus:ring-emerald-500"
                                                      :value="old('username', $user->username)" required/>
                                    </div>
                                </div>

                                <div>
                                    <x-input-label for="role" value="Level Akses"
                                                   class="font-semibold text-emerald-700"/>
                                    <select id="role" name="role"
                                            class="mt-1 w-full rounded-2xl border-emerald-100 dark:bg-gray-900 focus:ring-emerald-500">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                                            Member Biasa
                                        </option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                            Administrator
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- KEAMANAN --}}
                        <div
                            class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl border border-emerald-100 dark:border-emerald-900/30">
                            <h4 class="font-bold uppercase tracking-widest text-sm text-red-500 mb-2">
                                Keamanan Akun
                            </h4>
                            <p class="text-xs text-gray-400 italic mb-6">
                                Kosongkan jika tidak ingin mengubah password.
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="password" value="Password Baru"
                                                   class="font-semibold text-emerald-700"/>
                                    <x-text-input id="password" name="password" type="password"
                                                  class="mt-1 block w-full rounded-2xl border-emerald-100 dark:bg-gray-900 focus:ring-emerald-500"/>
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" value="Konfirmasi Password"
                                                   class="font-semibold text-emerald-700"/>
                                    <x-text-input id="password_confirmation" name="password_confirmation"
                                                  type="password"
                                                  class="mt-1 block w-full rounded-2xl border-emerald-100 dark:bg-gray-900 focus:ring-emerald-500"/>
                                </div>
                            </div>
                        </div>

                        {{-- AKSI --}}
                        <div
                            class="flex items-center justify-end gap-6 pt-6 border-t border-emerald-100 dark:border-emerald-900/30">
                            <a href="{{ route('admin.users') }}"
                               class="text-sm font-bold text-gray-400 hover:text-emerald-600 transition tracking-widest">
                                BATAL
                            </a>

                            <button type="submit"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-2 
                                    rounded-2xl shadow-xl shadow-emerald-500/40 transition 
                                    transform hover:-translate-y-0.5 active:scale-95 uppercase tracking-widest text-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.getElementById('previewProfile');

                    if (img.tagName === 'IMG') {
                        img.src = e.target.result;
                    } else {
                        img.innerHTML = '';
                        img.style.backgroundImage = `url(${e.target.result})`;
                        img.style.backgroundSize = 'cover';
                        img.style.backgroundPosition = 'center';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>