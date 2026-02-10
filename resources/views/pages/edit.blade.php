<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="min-h-screen bg-gray-50/50 dark:bg-gray-900 pb-12" x-data="editorPage({{ $page->id }})">

        <div class="sticky top-0 z-30 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="h-16 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('pages.index') }}" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $page->title }}</h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ url($page->handle) }}" target="_blank" class="hidden sm:inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Lihat
                        </a>
                        <button @click="copyToClipboard('{{ url($page->handle) }}')" class="px-4 py-2 rounded-lg text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-lg shadow-emerald-600/20">
                            Salin Link
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 p-4 rounded-xl flex justify-between items-center shadow-sm">
                    <div class="flex items-center text-emerald-700 dark:text-emerald-400">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-bold mr-1">Berhasil!</span> {{ session('success') }}
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">✕</button>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <div class="lg:col-span-7 space-y-8">

                    <div class="bg-white dark:bg-gray-800 p-1.5 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex">
                        <button @click="activeTab = 'links'" :class="activeTab === 'links' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-bold shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'" class="flex-1 py-2.5 rounded-lg text-sm transition-all flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            Konten
                        </button>
                        <button @click="activeTab = 'appearance'" :class="activeTab === 'appearance' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-bold shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'" class="flex-1 py-2.5 rounded-lg text-sm transition-all flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                            Tampilan
                        </button>
                    </div>

                    <div x-show="activeTab === 'links'" x-transition:enter="transition ease-out duration-200 opacity-0" x-transition:enter-end="opacity-100">
                        
                        <div class="mb-10">
                            <h3 class="flex items-center gap-2 text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wide mb-3 pl-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Tombol Utama
                            </h3>

                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 mb-4">
                                <form @submit.prevent="addLink($event)" action="{{ route('page-links.store', $page->id) }}" class="flex flex-col sm:flex-row gap-3">
                                    @csrf
                                    <input type="hidden" name="type" value="link">
                                    <input type="hidden" name="display_as" value="button">
                                    <div class="flex-1 space-y-3 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-3">
                                        <input type="text" name="title" required placeholder="Judul (mis: Website)" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm">
                                        <input type="url" name="destination_url" required placeholder="URL (https://...)" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm">
                                    </div>
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2.5 rounded-xl shadow-lg transition text-sm whitespace-nowrap">
                                        <i class="fas fa-plus mr-1"></i> Tambah
                                    </button>
                                </form>
                            </div>

                            <div class="space-y-3" x-ref="listButtons" id="button-list">
                                @php $buttonLinks = $links->filter(fn($l) => !isset($l->settings['display_as']) || $l->settings['display_as'] === 'button'); @endphp
                                @forelse($buttonLinks as $link)
                                    <div data-id="{{ $link->id }}" 
                                         x-data="{ id: {{ $link->id }}, title: '{{ addslashes($link->title) }}', url: '{{ addslashes($link->destination_url) }}', active: {{ $link->is_active ? 1 : 0 }}, icon: '' }"
                                         @link-updated.window="if($event.detail.id == id) { title = $event.detail.title; url = $event.detail.destination_url; active = $event.detail.is_active; }"
                                         class="group bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between hover:border-emerald-400 transition-colors cursor-move">
                                    
                                        <div class="flex items-center gap-4 flex-1 min-w-0">
                                            <div class="text-gray-300 group-hover:text-emerald-500 handle cursor-grab"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg></div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm truncate" x-text="title"></h4>
                                                    <span x-show="active" class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                    <span x-show="!active" class="w-2 h-2 rounded-full bg-gray-300"></span>
                                                </div>
                                                <p class="text-xs text-gray-500 truncate" x-text="url"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1 ml-2">
                                            <button @click="openEditModal(id, title, url, active, '', 'button')" class="p-2 text-gray-400 hover:text-blue-600 bg-gray-50 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                            <button @click="deleteLink(id)" class="p-2 text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl text-gray-400 text-xs">Belum ada tombol utama.</div>
                                @endforelse
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="flex items-center gap-2 text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wide mb-3 pl-1">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Social Media
                            </h3>

                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 mb-4">
                                <form @submit.prevent="addLink($event)" action="{{ route('page-links.store', $page->id) }}" class="flex flex-col gap-3">
                                    @csrf
                                    <input type="hidden" name="type" value="link">
                                    <input type="hidden" name="display_as" value="social">
                                    <input type="hidden" name="title" :value="getSocialLabel(newSocialIcon)">
                                    
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <div class="sm:w-1/3">
                                            <select name="icon" x-model="newSocialIcon" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm font-sans" required>
                                                <option value="" disabled>Pilih Sosmed...</option>
                                                <option value="fa-brands fa-whatsapp">WhatsApp</option>
                                                <option value="fa-brands fa-instagram">Instagram</option>
                                                <option value="fa-brands fa-tiktok">TikTok</option>
                                                <option value="fa-brands fa-youtube">YouTube</option>
                                                <option value="fa-brands fa-twitter">Twitter / X</option>
                                                <option value="fa-brands fa-facebook">Facebook</option>
                                                <option value="fa-brands fa-linkedin">LinkedIn</option>
                                                <option value="fa-brands fa-telegram">Telegram</option>
                                                <option value="fa-solid fa-envelope">Email</option>
                                                <option value="fa-solid fa-globe">Website</option>
                                                <option value="fa-solid fa-map-marker-alt">Lokasi / Maps</option>
                                            </select>
                                        </div>
                                        <div class="flex-1">
                                            <input type="url" name="destination_url" required placeholder="Link URL (https://...)" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-xl shadow-lg shadow-blue-600/20 transition text-sm disabled:opacity-50 disabled:cursor-not-allowed" :disabled="!newSocialIcon">
                                            <i class="fas fa-plus mr-1"></i> Tambah Sosmed
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="space-y-3" x-ref="listSocials" id="social-list">
                                @php $socialLinks = $links->filter(fn($l) => isset($l->settings['display_as']) && $l->settings['display_as'] === 'social'); @endphp
                                @forelse($socialLinks as $link)
                                    <div data-id="{{ $link->id }}" 
                                         x-data="{ id: {{ $link->id }}, title: '{{ addslashes($link->title) }}', url: '{{ addslashes($link->destination_url) }}', active: {{ $link->is_active ? 1 : 0 }}, icon: '{{ $link->settings['icon'] ?? '' }}' }"
                                         @link-updated.window="if($event.detail.id == id) { title = $event.detail.title; url = $event.detail.destination_url; active = $event.detail.is_active; icon = $event.detail.settings.icon; }"
                                         class="group bg-white dark:bg-gray-800 p-3 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between hover:border-blue-400 transition-colors cursor-move">
                                    
                                        <div class="flex items-center gap-4 flex-1 min-w-0">
                                            <div class="text-gray-300 group-hover:text-blue-500 handle cursor-grab"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg></div>
                                            
                                            <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                                <i :class="icon"></i>
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm truncate" x-text="title"></h4>
                                                    <span x-show="active" class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                    <span x-show="!active" class="w-2 h-2 rounded-full bg-gray-300"></span>
                                                </div>
                                                <p class="text-xs text-gray-500 truncate" x-text="url"></p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1 ml-2">
                                            <button @click="openEditModal(id, title, url, active, icon, 'social')" class="p-2 text-gray-400 hover:text-blue-600 bg-gray-50 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                            <button @click="deleteLink(id)" class="p-2 text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl text-gray-400 text-xs">Belum ada ikon sosmed.</div>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <div x-show="activeTab === 'appearance'" style="display: none;">
                        <form action="{{ route('pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf @method('PUT')
                            
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide mb-6 border-b border-gray-100 dark:border-gray-700 pb-2">Profil Utama</h3>
                                
                                <div class="flex flex-col sm:flex-row items-center gap-6 mb-6">
                                    <div class="relative group cursor-pointer shrink-0 flex flex-col items-center gap-3">
                                        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-gray-100 dark:border-gray-700 group-hover:border-emerald-500 transition-colors relative bg-gray-50 dark:bg-gray-900">
                                            @if ($page->avatar_path) 
                                                <img id="preview-avatar" src="{{ asset('storage/' . $page->avatar_path) }}" class="w-full h-full object-cover">
                                            @else 
                                                <div id="default-avatar" class="w-full h-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-3xl font-bold text-emerald-600 dark:text-emerald-400 select-none">
                                                    @php
                                                        $words = preg_split("/\s+/", $page->title);
                                                        $initials = '';
                                                        if (count($words) >= 2) { $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1)); } 
                                                        else { $initials = strtoupper(substr($page->title, 0, 1)); }
                                                    @endphp
                                                    {{ $initials }}
                                                </div> 
                                                <img id="preview-avatar" class="hidden w-full h-full object-cover">
                                            @endif
                                            
                                            <div class="absolute inset-0 bg-black/30 hidden group-hover:flex items-center justify-center transition-all">
                                                <i class="fa-solid fa-camera text-white text-xl"></i>
                                            </div>
                                        </div>
                                        
                                        <input type="file" name="avatar" class="absolute inset-0 opacity-0 cursor-pointer w-24 h-24" onchange="previewImage(this)">
                                        
                                        @if ($page->avatar_path)
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" name="delete_avatar" id="delete_avatar" class="rounded border-gray-300 text-red-600 focus:ring-red-500 w-4 h-4 cursor-pointer">
                                                <label for="delete_avatar" class="text-xs text-red-500 font-bold cursor-pointer hover:text-red-700">Hapus Foto</label>
                                            </div>
                                        @endif
                                        
                                        @error('avatar') <p class="text-red-500 text-xs text-center">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="flex-1 w-full space-y-4">
                                        
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Judul Halaman</label>
                                            <input type="text" name="title" value="{{ old('title', $page->title) }}" 
                                                class="w-full px-4 py-2.5 rounded-xl border @error('title') border-red-500 @else border-gray-200 @enderror dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm" 
                                                placeholder="Judul Halaman">
                                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Handle URL (Link)</label>
                                            <div class="flex rounded-xl shadow-sm ring-1 ring-inset @error('handle') ring-red-500 @else ring-gray-200 dark:ring-gray-700 @enderror focus-within:ring-2 focus-within:ring-inset focus-within:ring-emerald-500 bg-gray-50 dark:bg-gray-900 overflow-hidden">
                                                <span class="flex select-none items-center pl-3 text-gray-400 text-xs">{{ request()->getHost() }}/</span>
                                                <input type="text" name="handle" value="{{ old('handle', $page->handle) }}" 
                                                    class="block flex-1 border-0 bg-transparent py-2.5 pl-1 text-gray-900 dark:text-white placeholder:text-gray-400 focus:ring-0 sm:text-sm font-medium" 
                                                    placeholder="username">
                                            </div>
                                            @error('handle') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Bio Deskripsi</label>
                                            <textarea name="bio" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm" placeholder="Bio Deskripsi">{{ old('bio', $page->bio) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide mb-6 border-b border-gray-100 dark:border-gray-700 pb-2">Gambar Latar Belakang</h3>
                                <div class="relative group">
                                    <label class="relative block w-full h-32 rounded-xl border-2 border-dashed @error('background_image') border-red-500 @else border-gray-300 @enderror hover:border-emerald-500 bg-gray-50 flex flex-col items-center justify-center cursor-pointer overflow-hidden">
                                        <img id="background-preview" src="{{ isset($page->appearance['background_image_path']) ? asset('storage/' . $page->appearance['background_image_path']) : '' }}" class="{{ isset($page->appearance['background_image_path']) ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover z-10">
                                        <div id="background-placeholder" class="{{ isset($page->appearance['background_image_path']) ? 'hidden' : '' }} text-center z-20"><p class="text-xs text-gray-500">Klik untuk upload background</p></div>
                                        <input type="file" name="background_image" class="hidden" onchange="previewBackground(this)">
                                    </label>
                                </div>
                                @error('background_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                                @if(isset($page->appearance['background_image_path']) && $page->appearance['background_image_path'])
                                    <div class="mt-2 flex items-center"><input type="checkbox" name="delete_background" class="mr-2 rounded text-red-600"><label class="text-xs text-red-600">Hapus background</label></div>
                                @endif
                            </div>

                            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide mb-6 border-b border-gray-100 dark:border-gray-700 pb-2">Tema</h3>
                                <div class="grid grid-cols-4 gap-4">
                                    @foreach (['default', 'ocean', 'sunset', 'midnight'] as $key)
                                    <label class="cursor-pointer group"><input type="radio" name="theme" value="{{ $key }}" class="peer sr-only" {{ (old('theme', $page->appearance['theme'] ?? 'default')) == $key ? 'checked' : '' }}><div class="h-12 w-full rounded-lg bg-gray-200 peer-checked:ring-2 peer-checked:ring-emerald-500 transition relative overflow-hidden"><div class="absolute inset-0 {{ $key == 'default' ? 'bg-emerald-900' : ($key == 'ocean' ? 'bg-blue-900' : ($key == 'sunset' ? 'bg-orange-900' : 'bg-black')) }}"></div></div><span class="text-[10px] uppercase font-bold mt-1 block text-center">{{ $key }}</span></label>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl shadow-lg">Simpan Tampilan</button>
                        </form>
                    </div>
                </div>

                <div class="hidden lg:block lg:col-span-5 sticky top-24">
                    <div class="relative mx-auto border-gray-900 bg-gray-900 border-[12px] rounded-[3rem] h-[650px] w-[340px] shadow-2xl flex flex-col overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-6 bg-gray-900 z-20 flex justify-center"><div class="h-4 w-24 bg-black rounded-b-xl"></div></div>
                        <div class="absolute top-10 right-4 z-30"><button @click="refreshPreview()" class="p-1.5 bg-black/30 text-white rounded-full backdrop-blur-md hover:bg-black/50 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg></button></div>
                        <iframe id="previewFrame" src="{{ url($page->handle) }}" class="w-full h-full border-0" scrolling="yes"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-transition.opacity>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md overflow-hidden" @click.away="editModalOpen = false">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Konten</h3>
                    <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                
                <form @submit.prevent="updateLink()" class="p-6 space-y-4">
                    <input type="hidden" name="display_as" x-model="editDisplayAs">

                    <div x-show="editDisplayAs == 'social'">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ikon</label>
                        <select name="icon" x-model="editIcon" class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm font-sans">
                            <option value="" disabled>Pilih Sosmed...</option>
                            <option value="fa-brands fa-whatsapp">WhatsApp</option>
                            <option value="fa-brands fa-instagram">Instagram</option>
                            <option value="fa-brands fa-tiktok">TikTok</option>
                            <option value="fa-brands fa-youtube">YouTube</option>
                            <option value="fa-brands fa-twitter">Twitter / X</option>
                            <option value="fa-brands fa-facebook">Facebook</option>
                            <option value="fa-brands fa-linkedin">LinkedIn</option>
                            <option value="fa-brands fa-telegram">Telegram</option>
                            <option value="fa-solid fa-envelope">Email</option>
                            <option value="fa-solid fa-globe">Website</option>
                            <option value="fa-solid fa-map-marker-alt">Lokasi</option>
                        </select>
                    </div>

                    <div x-show="editDisplayAs == 'button'">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Judul</label>
                        <input type="text" name="title" x-model="editTitle" class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm">
                        <p x-show="errors.title" x-text="errors.title" class="text-red-500 text-xs mt-1"></p>
                    </div>
                    
                    <input type="hidden" name="title" x-model="editTitle" x-if="editDisplayAs == 'social'">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">URL Tujuan</label>
                        <input type="url" name="destination_url" x-model="editUrl" required class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm" :class="{'border-red-500': errors.destination_url}">
                        <p x-show="errors.destination_url" x-text="errors.destination_url" class="text-red-500 text-xs mt-1"></p>
                    </div>
                    
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Status Aktif</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                x-model="editIsActive" 
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:bg-emerald-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                        </label>
                    </div>

                    <div class="pt-4 flex justify-end gap-2">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-md disabled:opacity-50" :disabled="isSaving">
                            <span x-show="!isSaving">Simpan</span>
                            <span x-show="isSaving">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview-avatar');
            const defaultDiv = document.getElementById('default-avatar');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if(defaultDiv) defaultDiv.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewBackground(input) {
            const preview = document.getElementById('background-preview');
            const placeholder = document.getElementById('background-placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function editorPage(pageId) {
            return {
                activeTab: '{{ session("tab") === "appearance" || $errors->hasAny(["handle", "title", "bio", "avatar", "background_image", "theme"]) ? "appearance" : "links" }}',
                newSocialIcon: '',
                editModalOpen: false, editLinkId: null, editTitle: '', editUrl: '', editIsActive: true, editIcon: '', editDisplayAs: 'button', isSaving: false,
                errors: {},

                getSocialLabel(iconClass) {
                    const map = {
                        'fa-brands fa-whatsapp': 'WhatsApp',
                        'fa-brands fa-instagram': 'Instagram',
                        'fa-brands fa-tiktok': 'TikTok',
                        'fa-brands fa-youtube': 'YouTube',
                        'fa-brands fa-twitter': 'Twitter',
                        'fa-brands fa-facebook': 'Facebook',
                        'fa-brands fa-linkedin': 'LinkedIn',
                        'fa-brands fa-telegram': 'Telegram',
                        'fa-solid fa-envelope': 'Email',
                        'fa-solid fa-globe': 'Website',
                        'fa-solid fa-map-marker-alt': 'Lokasi'
                    };
                    return map[iconClass] || 'Social Media';
                },

                openEditModal(id, title, url, isActive, icon, displayAs) {
                    this.editLinkId = id; 
                    this.editTitle = title; 
                    this.editUrl = url; 
                    this.editIsActive = isActive; 
                    this.editIcon = icon; 
                    this.editDisplayAs = displayAs; 
                    this.errors = {}; // Reset pesan error
                    this.editModalOpen = true;
                },

                // AJAX Update Function
                updateLink() {
                    this.isSaving = true;
                    this.errors = {}; // Reset error sebelum request

                    const data = {
                        title: this.editTitle,
                        destination_url: this.editUrl,
                        is_active: this.editIsActive ? 1 : 0, 
                        display_as: this.editDisplayAs,
                        icon: this.editIcon
                    };

                    fetch(`/links/${this.editLinkId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(data)
                    })
                    .then(async response => {
                        const result = await response.json();
                        
                        if (response.status === 422) {
                            // Tangkap error validasi
                            this.errors = result.errors;
                        } else if(result.status === 'success') {
                            this.editModalOpen = false;
                            window.dispatchEvent(new CustomEvent('link-updated', { detail: result.data }));
                            this.refreshPreview();
                            alert('Perubahan berhasil disimpan!');
                        } else {
                            alert('Gagal menyimpan perubahan.');
                        }
                    })
                    .catch(error => { console.error('Error:', error); alert('Terjadi kesalahan sistem.'); })
                    .finally(() => { this.isSaving = false; });
                },

                addLink(event) {
                    this.isAdding = true;
                    const form = event.target;
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json', // Minta JSON ke Controller
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'success') {
                            // 1. Reset Input Form
                            form.reset();
                            this.newSocialIcon = ''; // Reset dropdown sosmed jika ada
                            
                            // 2. Refresh List Link di Layar (Tanpa Reload Halaman)
                            this.refreshLinkList();
                            
                            // 3. Update Preview HP
                            this.refreshPreview();
                        } else {
                            alert('Gagal menambahkan link.');
                        }
                    })
                    .catch(err => { console.error(err); alert('Terjadi kesalahan.'); })
                    .finally(() => { this.isAdding = false; });
                },

                refreshLinkList() {
                    fetch(window.location.href)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            // Ambil HTML list baru dari respon background
                            const newButtons = doc.getElementById('button-list').innerHTML;
                            const newSocials = doc.getElementById('social-list').innerHTML;

                            // Tempel ke halaman yang sedang terbuka
                            document.getElementById('button-list').innerHTML = newButtons;
                            document.getElementById('social-list').innerHTML = newSocials;

                            // Re-init sortable agar item baru bisa digeser
                            this.initSortable();
                        });
                },

                deleteLink(id) {
                    if (!confirm('Yakin ingin menghapus item ini?')) return;

                    fetch(`/links/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            this.refreshLinkList();
                            this.refreshPreview();
                        } else {
                            alert('Gagal menghapus item.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan koneksi.');
                    });
                },

                copyToClipboard(text) { navigator.clipboard.writeText(text); alert('Link berhasil disalin!'); },
                refreshPreview() { const iframe = document.getElementById('previewFrame'); if(iframe) iframe.src = iframe.src; },
                
                initSortable() {
                    const buttonsEl = document.getElementById('button-list');
                    const socialsEl = document.getElementById('social-list');
                    const handleEnd = () => {
                        const buttonIds = Array.from(buttonsEl.children).map(el => el.dataset.id);
                        const socialIds = Array.from(socialsEl.children).map(el => el.dataset.id);
                        const allIds = [...buttonIds, ...socialIds];
                        this.saveOrder(allIds);
                    };
                    if(buttonsEl) Sortable.create(buttonsEl, { animation: 150, handle: '.handle', ghostClass: 'bg-emerald-50', onEnd: handleEnd });
                    if(socialsEl) Sortable.create(socialsEl, { animation: 150, handle: '.handle', ghostClass: 'bg-blue-50', onEnd: handleEnd });
                },
                saveOrder(ids) {
                    fetch('{{ route("links.reorder") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }, body: JSON.stringify({ ids: ids }) }).then(() => this.refreshPreview());
                },
                init() { 
                    this.$nextTick(() => this.initSortable());
                    
                    this.$watch('editIcon', (value) => {
                        if (this.editModalOpen && this.editDisplayAs === 'social') {
                            this.editTitle = this.getSocialLabel(value);
                        }
                    });
                }
            }
        }
    </script>
</x-app-layout>