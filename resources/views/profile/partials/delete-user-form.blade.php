<section class="space-y-6">
    <header class="flex items-center space-x-3">
        <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Zona Bahaya</h2>
            <p class="text-sm text-gray-500">Tindakan ini permanen dan tidak dapat dibatalkan.</p>
        </div>
    </header>

    <div class="p-4 bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 rounded-xl">
        <p class="text-sm text-red-800 dark:text-red-400 mb-4">
            Setelah akun Anda dihapus, semua data akan hilang selamanya. Mohon pertimbangkan kembali.
        </p>
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-6 py-2.5 rounded-xl transition-all hover:ring-2 hover:ring-red-500 hover:ring-offset-2 dark:hover:ring-offset-gray-800"
        >{{ __('Hapus Akun Sekarang') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        </x-modal>
</section>