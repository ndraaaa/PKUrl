<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between shadow-sm">
            <h2 class="font-bold text-2xl text-emerald-800 dark:text-emerald-200 leading-tight">
                {{ __('Manajemen User') }}
            </h2>
            <p class="text-sm text-emerald-600 dark:text-emerald-400 font-medium">
                Total: {{ count($users) }} Pengguna Terdaftar
            </p>
        </div>
    </x-slot>

    <div class="py-12" x-data="userManagement()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm animate-bounce" role="alert">
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-900/30 flex flex-col md:flex-row gap-4 justify-between">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-emerald-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input x-model="search" type="text" placeholder="Cari nama atau email..." 
                        class="block w-full pl-10 pr-3 py-2 border border-emerald-200 dark:border-emerald-800 rounded-xl leading-5 bg-emerald-50/30 dark:bg-gray-900 text-emerald-900 dark:text-emerald-100 placeholder-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition duration-150 ease-in-out">
                </div>

                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Urutkan:</label>
                    <select x-model="sortBy" class="rounded-xl border-emerald-200 dark:border-emerald-800 bg-emerald-50/30 dark:bg-gray-900 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="name_asc">Nama (A-Z)</option>
                        <option value="name_desc">Nama (Z-A)</option>
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                    </select>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl shadow-emerald-900/5 sm:rounded-2xl border border-emerald-100 dark:border-emerald-900/20">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-emerald-100 dark:divide-emerald-900/50">
                        <thead class="bg-emerald-50/50 dark:bg-emerald-900/20">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Pengguna</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Email</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Bergabung</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50 dark:divide-emerald-900/30">
                            <template x-for="user in filteredUsers" :key="user.id">
                                <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/10 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold shadow-md shadow-emerald-500/20" x-text="user.name.charAt(0)"></div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-white" x-text="user.name"></div>
                                                <div class="text-[10px] text-emerald-500 font-mono">ID: #<span x-text="user.id"></span></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300" x-text="user.email"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span :class="user.role === 'admin' ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 'bg-blue-50 text-blue-600 border-blue-100'" 
                                              class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border" 
                                              x-text="user.role"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" x-text="user.formatted_date"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-4">
                                            <a :href="'/admin/users/' + user.id + '/edit'" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 transition group flex items-center">
                                                <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                Edit
                                            </a>
                                            
                                            <template x-if="user.id != {{ Auth::id() }}">
                                                <form :action="'/admin/users/' + user.id" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 dark:hover:text-red-400 transition flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </template>
                                            <template x-if="user.id == {{ Auth::id() }}">
                                                <span class="text-[10px] bg-gray-100 text-gray-400 px-2 py-1 rounded">Anda</span>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div x-show="filteredUsers.length === 0" class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <p class="mt-4 text-emerald-600 font-medium">Tidak ada user ditemukan...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function userManagement() {
            return {
                search: '',
                sortBy: 'newest',
                // Masukkan data dari Laravel ke JavaScript
                users: [
                    @foreach($users as $user)
                    {
                        id: {{ $user->id }},
                        name: "{{ $user->name }}",
                        email: "{{ $user->email }}",
                        role: "{{ $user->role }}",
                        created_at: "{{ $user->created_at }}",
                        formatted_date: "{{ $user->created_at->format('d M Y') }}"
                    },
                    @endforeach
                ],
                get filteredUsers() {
                    let filtered = this.users.filter(user => {
                        return user.name.toLowerCase().includes(this.search.toLowerCase()) ||
                               user.email.toLowerCase().includes(this.search.toLowerCase());
                    });

                    // Sorting Logic
                    return filtered.sort((a, b) => {
                        if (this.sortBy === 'name_asc') return a.name.localeCompare(b.name);
                        if (this.sortBy === 'name_desc') return b.name.localeCompare(a.name);
                        if (this.sortBy === 'newest') return new Date(b.created_at) - new Date(a.created_at);
                        if (this.sortBy === 'oldest') return new Date(a.created_at) - new Date(b.created_at);
                    });
                }
            }
        }
    </script>
</x-app-layout>