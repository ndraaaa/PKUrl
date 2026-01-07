<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users') }}" class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:bg-emerald-50 transition">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-bold text-2xl text-emerald-800 dark:text-emerald-200 leading-tight">
                {{ __('Edit Profil Pengguna') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-emerald-50/30 dark:bg-gray-900/50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-xl shadow-emerald-900/5 border border-emerald-100 dark:border-emerald-900/20 text-center">
                            <div class="relative inline-block">
                                <div class="h-24 w-24 mx-auto rounded-3xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-emerald-500/30">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="absolute -bottom-2 -right-2 bg-emerald-500 text-white p-1.5 rounded-xl border-4 border-white dark:border-gray-800">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                </span>
                            </div>
                            <h3 class="mt-4 font-bold text-gray-900 dark:text-white text-lg">{{ $user->name }}</h3>
                            <p class="text-sm text-emerald-600 font-medium">{{ $user->email }}</p>
                            
                            <div class="mt-6 pt-6 border-t border-emerald-50 dark:border-emerald-900/30 flex justify-around text-center">
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-emerald-400 tracking-widest">Role</p>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ ucfirst($user->role) }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-emerald-400 tracking-widest">Bergabung</p>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $user->created_at->format('M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl shadow-emerald-900/5 border border-emerald-100 dark:border-emerald-900/20">
                            <div class="flex items-center gap-2 mb-6 text-emerald-700 dark:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <h4 class="font-bold uppercase tracking-wider text-sm">Informasi Profil</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-emerald-700 dark:text-emerald-300 font-semibold" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-2xl border-emerald-100 dark:bg-gray-900 focus:ring-emerald-500" :value="old('name', $user->name)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Alamat Email')" class="text-emerald-700 dark:text-emerald-300 font-semibold" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-2xl border-emerald-100 dark:bg-gray-900 focus:ring-emerald-500" :value="old('email', $user->email)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>

                                <div>
                                    <x-input-label for="role" :value="__('Level Akses')" class="text-emerald-700 dark:text-emerald-300 font-semibold" />
                                    <select id="role" name="role" class="mt-1 block w-full border-emerald-100 dark:border-emerald-900 dark:bg-gray-900 dark:text-gray-300 focus:ring-emerald-500 rounded-2xl shadow-sm">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Member Biasa</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl shadow-emerald-900/5 border border-emerald-100 dark:border-emerald-900/20">
                            <div class="flex items-center gap-2 mb-2 text-emerald-700 dark:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <h4 class="font-bold uppercase tracking-wider text-sm">Keamanan Akun</h4>
                            </div>
                            <p class="text-xs text-gray-400 mb-6 italic">Kosongkan jika tidak ingin merubah password.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="password" :value="__('Password Baru')" class="text-emerald-700 dark:text-emerald-300 font-semibold" />
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-2xl border-emerald-100 dark:bg-gray-900 focus:ring-emerald-500" autocomplete="new-password" placeholder="••••••••" />
                                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                </div>
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-emerald-700 dark:text-emerald-300 font-semibold" />
                                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-2xl border-emerald-100 dark:bg-gray-900 focus:ring-emerald-500" placeholder="••••••••" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 px-4">
                            <a href="{{ route('admin.users') }}" class="text-sm font-bold text-gray-500 hover:text-emerald-600 transition tracking-wider">
                                BATAL
                            </a>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-emerald-500/30 transition duration-150 transform hover:-translate-y-0.5 active:scale-95 uppercase tracking-widest text-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>