<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Shortlink
        </h2>
        <p class="text-sm text-gray-500 mt-1">Buat link yang panjang menjadi pendek dengan instan.</p>
    </x-slot>

    <div class="py-6" x-data="{
        search: '{{ request('search') }}',
        isLoading: false,
        
        // Fungsi umum untuk mengambil data list
        fetchResults(url = null) {
            this.isLoading = true;
            const fetchUrl = url || '{{ route('shortlinks.index') }}?search=' + this.search;
            
            fetch(fetchUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('links-container').innerHTML = html;
                this.isLoading = false;
                
                // Update URL browser tanpa refresh
                if (!url) {
                    const newUrl = new URL(window.location);
                    newUrl.searchParams.set('search', this.search);
                    window.history.pushState({}, '', newUrl);
                } else {
                    window.history.pushState({}, '', url);
                }
            });
        },

        // Fungsi baru untuk Action (Toggle & Delete)
        performAction(event, message = null) {
            if (message && !confirm(message)) return;

            event.preventDefault();
            const form = event.target.closest('form');
            const url = form.action;
            const formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(() => {
                // Setelah aksi berhasil, refresh list secara background
                this.fetchResults();
            });
        }
    }">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show"
                    class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-md flex justify-between items-center">
                    <div class="flex items-center text-emerald-700">
                        <span class="font-bold mr-2">Berhasil!</span>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">✕</button>
                </div>
            @endif

            <div
                class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="bg-emerald-600 px-6 py-4 border-b border-emerald-500">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                        Buat Shortlink Cepat
                    </h3>
                </div>
                <div class="p-6">
                    <form method="post" action="{{ route('shortlinks.store') }}"
                        class="flex flex-col md:flex-row gap-4">
                        @csrf
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">URL Panjang</label>
                            <input type="url" name="original_url" required placeholder="https://..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white transition">
                        </div>
                        <div class="md:w-1/3">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Custom Nama</label>
                            <div
                                class="flex rounded-xl border border-gray-200 dark:border-gray-600 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500">
                                <span
                                    class="bg-gray-50 dark:bg-gray-800 px-3 py-3 text-gray-500 text-sm border-r border-gray-200 dark:border-gray-600">/</span>
                                <input type="text" name="custom_code" placeholder="data-karyawan"
                                    class="w-full border-0 py-3 px-3 bg-transparent dark:text-white focus:ring-0">
                            </div>
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-600/20 transition transform hover:-translate-y-0.5">Singkat!</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-2">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 flex items-center">
                    <span class="w-1 h-6 bg-emerald-500 rounded-full mr-3"></span>
                    Riwayat Link
                    <svg x-show="isLoading" class="animate-spin ml-3 h-5 w-5 text-emerald-500"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </h3>

                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" x-model="search" @input.debounce.500ms="fetchResults()"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm transition outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                        placeholder="Cari URL atau nama link...">
                </div>
            </div>

            <div id="links-container">
                @include('shortlinks.partials.list')
            </div>

        </div>
    </div>

    <div x-data="{ showQr: false, qrUrl: '', downloadName: '' }"
        @open-qr.window="showQr = true; qrUrl = $event.detail.url; downloadName = $event.detail.downloadName"
        x-show="showQr" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm"
        style="display: none;" x-transition.opacity>

        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-sm relative overflow-hidden"
            @click.away="showQr = false">
            <div class="bg-gray-900 p-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-lg">QR Code</h3>
                <button @click="showQr = false" class="text-gray-400 hover:text-white">✕</button>
            </div>
            <div class="p-8 flex flex-col items-center">
                <div
                    class="bg-white p-3 rounded-2xl shadow-inner border border-gray-100 mb-6 w-60 h-60 flex items-center justify-center">
                    <template x-if="qrUrl && qrUrl.includes('storage/')">
                        <img :src="qrUrl" x-ref="qrImage" alt="QR Code"
                            class="w-full h-full object-contain rounded-lg">
                    </template>
                    <template x-if="!qrUrl || !qrUrl.includes('storage/')">
                        <span class="text-xs text-gray-400">QR belum tersedia</span>
                    </template>
                </div>

                <div class="grid grid-cols-2 gap-3 w-full">
                    <a :href="qrUrl" 
                    :download="downloadName.replace(/\.(png|svg)$/i, '') + '.svg'" 
                    class="flex justify-center items-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 text-gray-800 dark:text-gray-200 px-4 py-3 rounded-xl font-bold text-sm transition text-center">
                    SVG
                    </a>

                    <button @click="downloadQRAsPng($refs.qrImage, downloadName)"
                    type="button"
                    class="flex justify-center items-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl shadow-lg font-bold text-sm transition text-center">
                    PNG
                    </button>
                </div>

                <p class="mt-4 text-[10px] text-gray-400 text-center uppercase tracking-widest font-bold">Pilih format
                    unduhan</p>
            </div>
        </div>
    </div>

    <script>
        function downloadQRAsPng(imgElement, downloadName) {
            if (!imgElement || !imgElement.src) {
                alert('Gambar QR belum siap.');
                return;
            }

            // 1. Ambil data SVG asli lewat fetch (untuk memastikan kita dapat source XML-nya)
            fetch(imgElement.src)
                .then(response => response.text())
                .then(svgData => {
                    // 2. Buat Image object untuk proses render
                    const img = new Image();
                    // Gunakan Base64 encoding agar aman untuk karakter spesial
                    const svgBase64 = "data:image/svg+xml;base64," + btoa(unescape(encodeURIComponent(svgData)));
                    
                    img.onload = function() {
                        // 3. Setup Canvas HD
                        const canvas = document.createElement('canvas');
                        const size = 1200; // Ukuran HD
                        canvas.width = size;
                        canvas.height = size;
                        const ctx = canvas.getContext('2d');

                        // 4. Background Putih (Agar QR mudah terbaca)
                        ctx.fillStyle = "white";
                        ctx.fillRect(0, 0, canvas.width, canvas.height);

                        // 5. Gambar ke Canvas
                        ctx.drawImage(img, 0, 0, size, size);

                        // 6. Eksekusi Download sebagai PNG asli
                        try {
                            const pngUrl = canvas.toDataURL("image/png");
                            const downloadLink = document.createElement("a");
                            downloadLink.href = pngUrl;
                            const cleanName = downloadName.replace(/\.(png|svg)$/i, '');
                            downloadLink.download = cleanName + ".png";
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        } catch (e) {
                            console.error("Gagal mengonversi ke PNG:", e);
                            alert("Gagal membuat file PNG. Coba gunakan browser lain.");
                        }
                    };

                    img.onerror = function() {
                        alert("Gagal memproses file SVG.");
                    };

                    img.src = svgBase64;
                })
                .catch(err => {
                    console.error(err);
                    alert("Gagal mengambil data QR.");
                });
        }
    </script>
</x-app-layout>
