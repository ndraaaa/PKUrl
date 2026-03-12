<x-app-layout title="User Management" desc="Kelola pengguna dan hak akses sistem.">

    <div class="py-4 md:py-8" x-data="userHandler()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-2 md:space-y-6 relative">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-users text-emerald-600"></i> Daftar Pengguna
                </h2>

                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </span>
                        <input type="text" x-model="search" @input.debounce.500ms="fetchResults()"
                            class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white text-sm transition"
                            placeholder="Cari nama atau username...">
                    </div>

                    <button @click="openModal()"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Tambah User
                    </button>
                </div>
            </div>

            {{-- TABEL USERS --}}
            <div id="users-container"
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase text-xs font-bold">
                            <tr>
                                {{-- 1. SORTABLE HEADER: NAMA --}}
                                <th @click="sortBy('name')"
                                    class="px-6 py-4 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition group select-none">
                                    <div class="flex items-center gap-1">
                                        Nama
                                        <i class="fa-solid" :class="getSortIcon('name')"></i>
                                    </div>
                                </th>

                                {{-- 2. SORTABLE HEADER: USERNAME --}}
                                <th @click="sortBy('username')"
                                    class="px-6 py-4 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition group select-none">
                                    <div class="flex items-center gap-1">
                                        Username
                                        <i class="fa-solid" :class="getSortIcon('username')"></i>
                                    </div>
                                </th>

                                {{-- 3. SORTABLE HEADER: ROLE --}}
                                <th @click="sortBy('role')"
                                    class="px-6 py-4 text-center cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition group select-none">
                                    <div class="flex items-center justify-center gap-1">
                                        Role
                                        <i class="fa-solid" :class="getSortIcon('role')"></i>
                                    </div>
                                </th>

                                {{-- 4. SORTABLE HEADER: BERGABUNG --}}
                                <th @click="sortBy('created_at')"
                                    class="px-6 py-4 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition group select-none">
                                    <div class="flex items-center gap-1">
                                        Bergabung
                                        <i class="fa-solid" :class="getSortIcon('created_at')"></i>
                                    </div>
                                </th>

                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td
                                        class="px-6 py-4 font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div>{{ $user->name }}</div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 font-mono text-xs">
                                        {{ $user->username ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if ($user->role === 'admin')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-100 text-orange-700 dark:bg-orange-900/50 dark:text-orange-300">
                                                <i class="fa-solid fa-shield-halved text-[10px]"></i> Admin
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                                                User
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs">
                                        {{ $user->created_at->format('d M Y') }}
                                        <span
                                            class="block text-[10px] text-gray-400">{{ $user->created_at->format('H:i') }}</span>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button
                                                @click="openModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->username }}', '{{ $user->role }}')"
                                                class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition"
                                                title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            {{-- @if (Auth::id() !== $user->id)
                                                <button @click="deleteUser({{ $user->id }})"
                                                    class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
                                                    title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endif --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada user
                                        ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $users->links() }}
                </div>
            </div>

        </div>

        {{-- MODAL FORM --}}
        <div x-show="modalOpen" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
            x-transition.opacity>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all"
                @click.away="closeModal()">

                <div
                    class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white"
                        x-text="isEdit ? 'Edit User' : 'Tambah User'"></h3>
                    <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>

                <form @submit.prevent="submitForm" class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" x-model="form.name" required
                            @input="form.name = $el.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase())"
                            :disabled="isEdit"
                            :class="isEdit ? 'bg-gray-100 text-gray-500 cursor-not-allowed dark:bg-gray-700 dark:text-gray-400' : 'bg-white text-gray-900 dark:bg-gray-900 dark:text-white'"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-sm focus:ring-emerald-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center" :class="isEdit ? 'text-gray-300 dark:text-gray-500' : 'text-gray-500'">@</span>
                            <input type="text" x-model="form.username" required placeholder="username"
                                @input="form.username = $el.value.toLowerCase().replace(/\s+/g, '')"
                                :disabled="isEdit"
                                :class="isEdit ? 'bg-gray-100 text-gray-500 cursor-not-allowed dark:bg-gray-700 dark:text-gray-400' : 'bg-white text-gray-900 dark:bg-gray-900 dark:text-white'"
                                class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-sm focus:ring-emerald-500 font-mono transition-colors">
                        </div>
                    </div>

                    {{-- FIELD PASSWORD: Hanya tampil saat Tambah User (!isEdit) --}}
                    <div x-show="!isEdit">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Password</label>
                        <input type="password" x-model="form.password" :required="!isEdit"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Role / Hak Akses</label>
                        <select x-model="form.role"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm focus:ring-emerald-500">
                            <option value="user">User Biasa</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>

                    <div class="pt-2 flex justify-end gap-2">
                        <button type="button" @click="closeModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-md transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function userHandler() {
            return {
                search: '{{ request('search') }}',
                // STATE SORTING
                sortCol: '{{ request('sort', 'created_at') }}',
                sortDir: '{{ request('dir', 'desc') }}',

                modalOpen: false,
                isEdit: false,
                currentUserId: null,

                form: {
                    name: '',
                    username: '',
                    password: '',
                    role: 'user'
                },

                // --- FUNGSI SORTING ---
                sortBy(column) {
                    if (this.sortCol === column) {
                        this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortCol = column;
                        this.sortDir = 'asc';
                    }
                    this.fetchResults();
                },

                // Helper untuk Icon Panah Sort
                getSortIcon(column) {
                    if (this.sortCol !== column) return 'fa-sort text-gray-300 opacity-0 group-hover:opacity-50';
                    return this.sortDir === 'asc' ? 'fa-sort-up text-emerald-500' : 'fa-sort-down text-emerald-500';
                },

                // --- FETCH DATA ---
                fetchResults() {
                    const url = new URL('{{ route('admin.users.index') }}');
                    if (this.search) url.searchParams.set('search', this.search);

                    // Masukkan param sorting ke URL
                    url.searchParams.set('sort', this.sortCol);
                    url.searchParams.set('dir', this.sortDir);

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => res.text())
                        .then(html => {
                            const doc = new DOMParser().parseFromString(html, 'text/html');
                            document.getElementById('users-container').innerHTML = doc.getElementById('users-container')
                                .innerHTML;
                            window.history.pushState({}, '', url);
                        });
                },

                // --- MODAL FUNCTIONS ---
                openModal(id = null, name = '', username = '', role = 'user') {
                    if (id) {
                        this.isEdit = true;
                        this.currentUserId = id;
                        this.form = {
                            name,
                            username: username || '',
                            role,
                            password: ''
                        };
                    } else {
                        this.isEdit = false;
                        this.currentUserId = null;
                        this.form = {
                            name: '',
                            username: '',
                            role: 'user',
                            password: ''
                        };
                    }
                    this.modalOpen = true;
                },

                closeModal() {
                    this.modalOpen = false;
                },

                submitForm() {
                    const url = this.isEdit ? `/admin/users/${this.currentUserId}` : `{{ route('admin.users.store') }}`;
                    const method = this.isEdit ? 'PUT' : 'POST';

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                _method: method,
                                ...this.form
                            })
                        })
                        .then(async res => {
                            const data = await res.json();
                            if (res.ok) {
                                this.closeModal();
                                this.fetchResults();
                                // alert('Berhasil menyimpan data!'); // Optional: Matikan jika mengganggu
                            } else {
                                alert(data.message || 'Terjadi kesalahan input.');
                            }
                        })
                        .catch(err => alert('Terjadi kesalahan sistem.'));
                },

                deleteUser(id) {
                    if (!confirm('Yakin ingin menghapus user ini?')) return;
                    fetch(`/admin/users/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            _method: 'DELETE'
                        })
                    }).then(res => {
                        if (res.ok) {
                            this.fetchResults();
                        } else {
                            alert('Gagal menghapus user.');
                        }
                    });
                }
            }
        }
    </script>
</x-app-layout>
