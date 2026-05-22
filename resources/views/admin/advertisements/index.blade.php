<x-app-layout title="Kelola Iklan" desc="Atur banner promo dan informasi penting yang muncul di splash screen.">
    <div class="py-4 md:py-8" x-data="{
        search: '',
        modalOpen: false,
        isEdit: false,
        adId: null,
        form: { title: '', target_url: '', is_active: false },
    
        // Data iklan untuk pencarian (Alpine.js array)
        ads: [
            @foreach ($ads as $ad)
            {
                id: {{ $ad->id }},
                title: '{{ addslashes($ad->title) }}',
                target_url: '{{ $ad->target_url }}',
                is_active: {{ $ad->is_active ? 'true' : 'false' }},
                image_path: '{{ asset('storage/' . $ad->image_path) }}'
            }, @endforeach
        ],
    
        get filteredAds() {
            return this.ads.filter(ad => ad.title.toLowerCase().includes(this.search.toLowerCase()));
        },
    
        openModal(edit = false, id = null, title = '', url = '', active = false) {
            this.isEdit = edit;
            this.adId = id;
            this.form = { title: title, target_url: url, is_active: !!active };
            this.modalOpen = true;
        },
        closeModal() { this.modalOpen = false; }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER & SEARCH --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-emerald-600"></i> Daftar Iklan
                </h2>
                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </span>
                        <input type="text" x-model="search" placeholder="Cari judul..."
                            class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 dark:bg-gray-800 dark:border-gray-700 text-sm">
                    </div>
                    <button @click="openModal()"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Iklan
                    </button>
                </div>
            </div>

            {{-- TABEL --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Gambar</th>
                                <th class="px-6 py-4">Judul</th>
                                <th class="px-6 py-4">URL Tujuan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <template x-for="ad in filteredAds" :key="ad.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <img :src="ad.image_path" class="w-16 h-10 object-cover rounded-lg shadow-sm">
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white" x-text="ad.title">
                                    </td>

                                    <td class="px-6 py-4 font-mono text-xs text-gray-500 dark:text-gray-400">
                                        <span x-text="ad.target_url ? ad.target_url : '-'"></span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold"
                                            :class="ad.is_active ? 'bg-emerald-100 text-emerald-700' :
                                                'bg-gray-100 text-gray-600'"
                                            x-text="ad.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button
                                                @click="openModal(true, ad.id, ad.title, ad.target_url, ad.is_active)"
                                                class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg"><i
                                                    class="fa-solid fa-pen"></i></button>
                                            <form :action="'/admin/pengaturan-iklan/' + ad.id" method="POST"
                                                onsubmit="return confirm('Yakin hapus iklan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-500 hover:bg-red-50 rounded-lg"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <tr x-show="filteredAds.length === 0" style="display: none;">
                                <td colspan="5"
                                    class="px-6 py-8 text-center text-gray-400 dark:text-gray-500 text-sm italic">
                                    <i class="fa-solid fa-folder-open mb-2 block text-xl opacity-50"></i>
                                    Tidak ada iklan yang ditemukan.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODAL TAMBAH/EDIT --}}
        <div x-show="modalOpen" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/70 backdrop-blur-sm overflow-y-auto"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl p-6 shadow-2xl border border-gray-200 dark:border-gray-700 relative my-auto"
                @click.away="closeModal()">

                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-5"
                    x-text="isEdit ? 'Edit Iklan' : 'Tambah Iklan'"></h3>

                <form :action="isEdit ? '/admin/pengaturan-iklan/' + adId : '{{ route('admin.advertisements.store') }}'"
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>

                    <div>
                        <label
                            class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Judul</label>
                        <input type="text" name="title" x-model="form.title" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">URL
                            Tujuan (Opsional)</label>
                        <input type="url" name="target_url" x-model="form.target_url"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Gambar
                            Banner</label>
                        <input type="file" name="image"
                            class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700">
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer pt-2">
                        <input type="checkbox" name="is_active" value="1" x-model="form.is_active"
                            class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Aktifkan Iklan</span>
                    </label>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="closeModal()"
                            class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-xl font-bold text-sm transition">Batal</button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-sm transition shadow-lg shadow-emerald-600/20">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
