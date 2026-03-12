<x-app-layout title="Dashboard" desc="Ringkasan performa tautan dan halaman Anda.">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Halo, {{ Auth::user()->name }}! 👋
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Berikut adalah ringkasan performa akun Anda
                        hari ini.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('shortlinks.index') }}"
                        class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-bold shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-plus text-emerald-500"></i> Buat Link
                    </a>
                    <a href="{{ route('pages.index') }}"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-layer-group"></i> Kelola Halaman
                    </a>
                </div>
            </div>

            {{-- STATS CARDS GRID --}}
            {{-- Kita ubah gridnya dinamis: jika Admin (totalUsers > 0), jadi 4 kolom. Jika user biasa, 3 kolom --}}
            <div
                class="grid grid-cols-1 {{ $totalUsers > 0 ? 'md:grid-cols-2 lg:grid-cols-4' : 'md:grid-cols-3' }} gap-6">

                {{-- 1. CARD TOTAL KUNJUNGAN --}}
                <div
                    class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 shadow-lg text-white group hover:-translate-y-1 transition-transform duration-300">
                    <div
                        class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/10 blur-2xl group-hover:bg-white/20 transition">
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-emerald-100 text-sm font-medium mb-1">Total Kunjungan</p>
                                <h3 class="text-3xl font-bold">{{ number_format($totalClicks) }}</h3>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <i class="fa-solid fa-chart-simple text-xl"></i>
                            </div>
                        </div>
                        <div
                            class="mt-4 flex items-center text-xs text-emerald-100 bg-white/10 w-fit px-2 py-1 rounded-lg">
                            <i class="fa-solid fa-arrow-trend-up mr-1"></i> Lifetime Views
                        </div>
                    </div>
                </div>

                {{-- 2. CARD TOTAL SHORTLINK --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:border-emerald-500/30 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Total Shortlink</p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($totalLinks) }}</h3>
                        </div>
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl">
                            <i class="fa-solid fa-link text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 w-[70%] rounded-full"></div>
                    </div>
                </div>

                {{-- 3. CARD TOTAL HALAMAN BIO --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:border-emerald-500/30 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Halaman Bio</p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($totalPages) }}</h3>
                        </div>
                        <div
                            class="p-3 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-xl">
                            <i class="fa-solid fa-pager text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-500 w-[40%] rounded-full"></div>
                    </div>
                </div>

                {{-- 4. CARD KHUSUS ADMIN (TOTAL USER) --}}
                @if ($totalUsers > 0)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:border-emerald-500/30 transition duration-300 border-l-4 border-l-orange-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Total Pengguna</p>
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ number_format($totalUsers) }}</h3>
                            </div>
                            <div
                                class="p-3 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 rounded-xl">
                                <i class="fa-solid fa-users text-xl"></i>
                            </div>
                        </div>
                        <div
                            class="mt-4 flex items-center text-xs text-orange-600 bg-orange-50 dark:bg-orange-900/30 w-fit px-2 py-1 rounded-lg">
                            <i class="fa-solid fa-shield-halved mr-1"></i> Admin Area
                        </div>
                    </div>
                @endif

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- CHART SECTION (2/3 width) --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6"
                    x-data="analyticsHandler()">

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Analitik Kunjungan</h3>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fa-solid fa-arrows-left-right mr-1"></i> Geser grafik untuk melihat riwayat
                            </p>
                        </div>

                        <select x-model="range" @change="fetchData()"
                            class="bg-gray-50 dark:bg-gray-700 border-0 rounded-lg text-xs font-bold text-gray-700 dark:text-gray-200 focus:ring-emerald-500 py-2 pl-3 pr-8 cursor-pointer shadow-sm">
                            <option value="week">30 Hari Terakhir</option>
                            <option value="month">1 Tahun Terakhir</option>
                        </select>
                    </div>

                    <div class="relative h-[300px] w-full group">
                        <div x-show="loading"
                            class="absolute inset-0 flex items-center justify-center bg-white/50 dark:bg-gray-800/50 z-20 backdrop-blur-[1px] rounded-xl transition">
                            <svg class="animate-spin h-8 w-8 text-emerald-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>

                        <div id="clicksChart"></div>
                    </div>
                </div>

                {{-- TOP PERFORMING (1/3 width) --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex flex-col">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">🔥 Link Terpopuler</h3>

                    <div class="flex-1 overflow-y-auto pr-1 space-y-4">
                        @forelse($popularLinks as $link)
                            <div
                                class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700/30 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition group">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center text-emerald-500 shadow-sm text-xs font-bold border border-gray-100 dark:border-gray-600">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                            {{ $link->title ?? 'Tanpa Judul' }}</p>
                                        <p class="text-xs text-gray-400 truncate">
                                            @if ($link->page_id)
                                                <i class="fa-solid fa-pager text-[10px] mr-1"></i> Bio Link
                                            @else
                                                <i class="fa-solid fa-link text-[10px] mr-1"></i>
                                                /{{ $link->short_code }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span
                                        class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ number_format($link->click_count) }}</span>
                                    <p class="text-[10px] text-gray-400">Klik</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-400 text-sm py-10">Belum ada data populer.</div>
                        @endforelse
                    </div>

                    <a href="{{ route('shortlinks.index') }}?sort=clicks&dir=desc"
                        class="mt-4 text-center text-xs font-bold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition">
                        Lihat Semua &rarr;
                    </a>
                </div>
            </div>

            {{-- RECENT ACTIVITY TABLE --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Link Terbaru Ditambahkan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Judul / Tipe</th>
                                <th class="px-6 py-4">Tujuan</th>
                                <th class="px-6 py-4 text-center">Tanggal</th>
                                <th class="px-6 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentLinks as $link)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">
                                            {{ $link->title ?? 'Tanpa Judul' }}</div>
                                        @if ($link->page_id)
                                            <div class="text-purple-500 text-xs font-medium"><i
                                                    class="fa-solid fa-pager mr-1"></i> Halaman Bio</div>
                                        @else
                                            <div class="text-emerald-600 text-xs font-medium">/{{ $link->short_code }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="flex items-center text-gray-500 dark:text-gray-400 max-w-xs truncate gap-2">
                                            <img src="https://www.google.com/s2/favicons?domain={{ parse_url($link->destination_url, PHP_URL_HOST) }}&sz=16"
                                                class="w-4 h-4 opacity-70">
                                            <span class="truncate">{{ $link->destination_url }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        {{ $link->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($link->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada link yang
                                        dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPT GRAPH CHART --}}
    <script>
        function analyticsHandler() {
            return {
                range: 'week',
                loading: false,
                chart: null,

                init() {
                    this.fetchData();
                },

                fetchData() {
                    this.loading = true;
                    const url = `{{ route('dashboard.chart') }}?range=${this.range}`;

                    fetch(url)
                        .then(res => res.json())
                        .then(data => {
                            this.renderChart(data.shortlink, data.biolink);
                            this.loading = false;
                        })
                        .catch(err => {
                            console.error(err);
                            this.loading = false;
                        });
                },

                renderChart(shortlinkData, biolinkData) {
                    const today = new Date().getTime();
                    const sevenDaysAgo = today - (7 * 24 * 60 * 60 * 1000);

                    if (this.chart) {
                        this.chart.destroy();
                    }

                    var options = {
                        series: [{
                                name: 'Shortlink Visits',
                                data: shortlinkData
                            },
                            {
                                name: 'Bio Link Visits',
                                data: biolinkData
                            }
                        ],
                        chart: {
                            type: 'area',
                            height: 300,
                            fontFamily: 'inherit',
                            background: 'transparent',
                            toolbar: {
                                show: false,
                                autoSelected: 'pan'
                            },
                            zoom: {
                                enabled: true,
                                type: 'x',
                                autoScaleYaxis: true
                            }
                        },
                        colors: ['#10b981', '#8b5cf6'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0.05,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },

                        xaxis: {
                            type: 'datetime',
                            min: sevenDaysAgo,
                            max: today,
                            tooltip: {
                                enabled: false
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            labels: {
                                style: {
                                    colors: '#9ca3af'
                                },
                                datetimeFormatter: {
                                    year: 'yyyy',
                                    month: 'dd MMM',
                                    day: 'dd MMM',
                                    hour: 'HH:mm'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: '#9ca3af'
                                },
                                formatter: (value) => {
                                    return value.toFixed(0)
                                }
                            }
                        },
                        grid: {
                            borderColor: '#f3f4f6',
                            strokeDashArray: 4,
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            }
                        },
                        theme: {
                            mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right'
                        },
                        tooltip: {
                            x: {
                                format: 'dd MMM yyyy'
                            }
                        }
                    };

                    this.chart = new ApexCharts(document.querySelector("#clicksChart"), options);
                    this.chart.render();
                }
            }
        }
    </script>
</x-app-layout>
