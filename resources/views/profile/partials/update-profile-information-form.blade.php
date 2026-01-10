<section>
    <header class="flex items-center space-x-3 mb-6">
        <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Informasi Profil</h2>
            <p class="text-sm text-gray-500">Perbarui nama dan alamat email akun Anda.</p>
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-4">
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs uppercase tracking-wider font-semibold text-gray-500" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-200 dark:border-gray-700 focus:ring-emerald-500" :value="old('name', $user->name)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email Address')" class="text-xs uppercase tracking-wider font-semibold text-gray-500" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-200 dark:border-gray-700 focus:ring-emerald-500" :value="old('email', $user->email)" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="flex items-center justify-end pt-4 border-t border-gray-50 dark:border-gray-700">
            <x-primary-button class="bg-emerald-600 hover:bg-emerald-700 shadow-md shadow-emerald-200 dark:shadow-none transition-all active:scale-95">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>
        </div>
    </form>
</section>