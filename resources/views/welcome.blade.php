<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ config('app.name') }} - Portal Link RS PKU Aisyiyah Boyolali</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: "media",
            theme: {
                extend: {
                    colors: {
                        "primary": "#10B981",
                        "primary-hover": "#059669",
                        "primary-light": "#D1FAE5",
                        "bg-primary-section": "#ffffff",
                        "bg-secondary-section": "#f8fafc",
                        "bg-primary-section-dark": "#0f172a",
                        "bg-secondary-section-dark": "#1e293b",
                        "slate-custom": "#064e3b",
                        "accent-muted": "#6ee7b7"
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"],
                        "sans": ["Manrope", "sans-serif"]
                    },
                    // Animasi 'float' dihapus dari sini karena tidak lagi digunakan pada HP
                    animation: {
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'gradient-x': 'gradient-x 3s ease infinite',
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        },
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            },
                        },
                        blob: {
                            '0%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                            '33%': {
                                transform: 'translate(30px, -50px) scale(1.1)'
                            },
                            '66%': {
                                transform: 'translate(-20px, 20px) scale(0.9)'
                            },
                            '100%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                        }
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Manrope', sans-serif;
            overflow-x: hidden;
        }

        [x-cloak] {
            display: none !important;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .text-gradient-animated {
            background: linear-gradient(to right, #10B981, #34d399, #10B981);
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: gradient-x 3s linear infinite;
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        }

        .glass-input:focus-within {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(16, 185, 129, 0.5);
            box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.2);
        }
    </style>
</head>

<body
    class="bg-bg-primary-section dark:bg-bg-primary-section-dark text-slate-900 dark:text-white transition-colors duration-300 selection:bg-primary selection:text-white">

    <header x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
        class="sticky top-0 z-50 w-full transition-all duration-500 ease-in-out bg-transparent border-b border-transparent"
        :class="{ 'backdrop-blur-xl border-slate-200/50 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50': scrolled }">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group"
                :class="{ 'text-slate-900 dark:text-white': scrolled, 'text-white drop-shadow-md': !scrolled }">
                <img src="{{ asset('images/logo.png') }}" alt="e-Link Logo"
                    class="h-11 w-11 object-cover p-0 bg-white rounded-lg border border-slate-100 shadow-sm group-hover:rotate-12 transition-transform duration-300">

                <div class="flex flex-col">
                    <h2
                        class="text-2xl font-extrabold tracking-tight leading-none text-primary group-hover:scale-105 transition-transform origin-left">
                        e-Link</h2>
                    <span class="text-sm font-bold leading-tight opacity-90 text-primary">RS PKU Aisyiyah
                        Boyolali</span>
                </div>
            </a>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            :class="{
                                'bg-white dark:bg-slate-custom text-slate-900 dark:text-white border-emerald-200 dark:border-emerald-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/50': scrolled,
                                'bg-white/10 text-white border-white/40 hover:bg-white/20': !scrolled
                            }"
                            class="border px-6 py-2.5 rounded-lg text-sm font-bold transition-all hover:scale-105 active:scale-95">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-primary hover:bg-primary-hover text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-lg shadow-primary/20 transition-all hover:-translate-y-1 hover:shadow-primary/40 active:scale-95">Masuk</a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main class="w-full" x-data="shortenerLogic()">

        <section class="relative overflow-hidden pt-28 pb-20 md:pt-48 md:pb-48 bg-cover bg-center bg-no-repeat -mt-20"
            style="background-image: url('{{ asset('images/hero-bg.jpeg') }}');">

            <div class="absolute inset-0 bg-slate-900/80 mix-blend-multiply z-0"></div>

            <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
                <div
                    class="absolute top-0 left-1/4 w-96 h-96 bg-primary/20 rounded-full mix-blend-overlay filter blur-3xl opacity-30 animate-blob">
                </div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/20 rounded-full mix-blend-overlay filter blur-3xl opacity-30 animate-blob"
                    style="animation-delay: 2s"></div>
            </div>

            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <div data-aos="zoom-in-down" data-aos-duration="1000"
                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-emerald-300 text-xs font-bold mb-6 md:mb-8 uppercase tracking-widest backdrop-blur-md shadow-lg">
                    <i class="fa-solid fa-hospital"></i> Portal Internal RS PKU Aisyiyah Boyolali
                </div>

                <h1 data-aos="fade-up" data-aos-duration="1000"
                    class="text-4xl md:text-7xl font-extrabold tracking-tight mb-6 md:mb-8 leading-[1.1] text-white drop-shadow-2xl">
                    Kelola Link dan Informasi <br class="hidden md:block" />
                    <span class="text-gradient-animated">Rumah Sakit</span>
                    dengan Mudah.
                </h1>

                <p data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000"
                    class="text-base md:text-xl text-slate-200 max-w-2xl mx-auto mb-8 md:mb-12 leading-relaxed opacity-90">
                    Alat bantu untuk staf RS PKU Aisyiyah Boyolali dalam memendekkan link panjang agar lebih rapi dan
                    mudah dibagikan ke pasien atau rekan kerja.
                </p>

                <div data-aos="zoom-in-up" data-aos-delay="400" data-aos-duration="800"
                    class="w-full max-w-2xl mx-auto relative z-20">
                    <div class="p-3 md:p-3 rounded-2xl transition-all duration-300 glass-input">
                        <div class="flex flex-col md:flex-row gap-3 md:gap-2">
                            <div class="flex-1 flex items-center px-2 md:px-4 py-1 md:py-0">
                                <i class="fa-solid fa-link text-emerald-400 mr-3 text-lg animate-pulse"></i>
                                <input x-model="url" @keydown.enter="shorten()"
                                    class="w-full bg-transparent border-none focus:ring-0 text-white placeholder:text-white/50 text-base md:text-lg p-0 font-medium tracking-wide"
                                    placeholder="Tempel link panjang di sini..." type="url" />
                            </div>
                            <button @click="shorten()" :disabled="loading || !url"
                                class="w-full md:w-auto bg-gradient-to-r from-primary to-emerald-600 hover:from-primary-hover hover:to-emerald-700 text-white px-8 py-4 rounded-xl text-base md:text-lg font-bold transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_30px_rgba(16,185,129,0.5)] hover:-translate-y-1">
                                <span x-show="!loading">Pendekkan Link</span>
                                <span x-show="loading" x-cloak><i class="fa-solid fa-circle-notch fa-spin"></i></span>
                                <span x-show="!loading"
                                    class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></span>
                            </button>
                        </div>
                    </div>

                    <div x-show="error" x-transition class="mt-4 text-center">
                        <span
                            class="inline-block px-4 py-2 rounded-lg bg-red-500/80 text-white text-sm font-bold backdrop-blur-md shadow-lg">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i> <span x-text="error"></span>
                        </span>
                    </div>

                    <div x-show="result" x-cloak x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-20 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        class="mt-8 p-5 md:p-6 bg-white/90 dark:bg-slate-800/90 border border-white/40 dark:border-emerald-500/30 rounded-2xl shadow-2xl backdrop-blur-xl text-left relative z-30 ring-1 ring-white/50">

                        <div class="flex flex-col sm:flex-row gap-6 items-center">
                            <div class="shrink-0 bg-white p-1 rounded-xl shadow-inner border border-emerald-50">
                                <div x-show="!finalQrUrl"
                                    class="w-28 h-28 flex items-center justify-center text-emerald-500">
                                    <i class="fa-solid fa-circle-notch fa-spin text-2xl"></i>
                                </div>
                                <img x-show="finalQrUrl" :src="finalQrUrl" class="w-28 h-28 object-contain">
                            </div>

                            <div class="flex-1 w-full min-w-0 space-y-4 text-center sm:text-left">
                                <div>
                                    <p class="text-xs font-bold text-primary uppercase tracking-widest mb-1">Link Pendek
                                        Siap</p>
                                    <div class="flex items-center justify-center sm:justify-start gap-2 group cursor-pointer"
                                        @click="copyToClipboard()">
                                        <h3 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white truncate hover:text-primary transition-colors"
                                            x-text="result?.short_url"></h3>
                                        <i
                                            class="fa-regular fa-copy text-slate-400 hover:text-primary transition-colors group-hover:scale-125 duration-300"></i>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 truncate"
                                        x-text="result?.original_url"></p>
                                </div>

                                <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                                    <a :href="finalQrUrl"
                                        :download="result ? 'qr-' + result.short_url.split('/').pop() + '.png' : 'qrcode-elink.png'"
                                        class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-emerald-50 dark:bg-slate-700 hover:bg-emerald-100 text-slate-700 dark:text-white text-sm font-bold transition transform hover:scale-105 border border-emerald-100 flex justify-center gap-2">
                                        <i class="fa-solid fa-download"></i> Unduh QR
                                    </a>

                                    <a :href="result?.short_url" target="_blank"
                                        class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-bold transition transform hover:scale-105 shadow-lg shadow-primary/20 flex justify-center gap-2">
                                        Kunjungi Link <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center border-t border-slate-200 dark:border-slate-700 pt-3">
                            <button @click="resetForm()"
                                class="text-xs text-slate-500 hover:text-primary transition font-bold uppercase tracking-wider">Buat
                                link baru</button>
                        </div>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="500" class="md:hidden mt-10 grid grid-cols-3 gap-4 px-4">
                    <div class="flex flex-col items-center text-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/20 border border-primary/40 flex items-center justify-center font-bold text-sm text-white shadow-[0_0_10px_rgba(16,185,129,0.3)] backdrop-blur-sm">
                            1</div>
                        <span class="text-xs font-medium text-white/80 leading-tight">Tempel URL</span>
                    </div>
                    <div class="flex flex-col items-center text-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/20 border border-primary/40 flex items-center justify-center font-bold text-sm text-white shadow-[0_0_10px_rgba(16,185,129,0.3)] backdrop-blur-sm">
                            2</div>
                        <span class="text-xs font-medium text-white/80 leading-tight">Dapatkan QR</span>
                    </div>
                    <div class="flex flex-col items-center text-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/20 border border-primary/40 flex items-center justify-center font-bold text-sm text-white shadow-[0_0_10px_rgba(16,185,129,0.3)] backdrop-blur-sm">
                            3</div>
                        <span class="text-xs font-medium text-white/80 leading-tight">Siap Dibagikan</span>
                    </div>
                </div>

                <div class="hidden md:grid grid-cols-3 gap-8 mt-24 max-w-3xl mx-auto relative z-10">
                    <div data-aos="fade-up" data-aos-delay="500"
                        class="flex flex-col items-center justify-center gap-4 text-slate-200 group cursor-default">
                        <span
                            class="w-14 h-14 rounded-full bg-primary flex items-center justify-center text-2xl font-bold text-white shadow-[0_0_20px_rgba(16,185,129,0.4)] group-hover:scale-110 transition-transform duration-300">1</span>
                        <span class="font-semibold text-lg group-hover:text-white transition-colors">Tempel URL
                            Panjang</span>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="600"
                        class="flex flex-col items-center justify-center gap-4 text-slate-200 group cursor-default">
                        <span
                            class="w-14 h-14 rounded-full bg-primary flex items-center justify-center text-2xl font-bold text-white shadow-[0_0_20px_rgba(16,185,129,0.4)] group-hover:scale-110 transition-transform duration-300">2</span>
                        <span class="font-semibold text-lg group-hover:text-white transition-colors">Dapatkan Link &
                            QR</span>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="700"
                        class="flex flex-col items-center justify-center gap-4 text-slate-200 group cursor-default">
                        <span
                            class="w-14 h-14 rounded-full bg-primary flex items-center justify-center text-2xl font-bold text-white shadow-[0_0_20px_rgba(16,185,129,0.4)] group-hover:scale-110 transition-transform duration-300">3</span>
                        <span class="font-semibold text-lg group-hover:text-white transition-colors">Siap
                            Dibagikan</span>
                    </div>
                </div>

            </div>
        </section>

        <section
            class="py-16 md:py-24 bg-bg-secondary-section dark:bg-bg-secondary-section-dark border-y border-slate-200 dark:border-slate-700 transition-colors relative z-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    <div data-aos="fade-right" data-aos-duration="1000"
                        class="space-y-8 text-center lg:text-left relative z-10">
                        <div class="space-y-4">
                            <h2 class="text-3xl md:text-5xl font-black leading-tight text-slate-900 dark:text-white">
                                Satu Halaman untuk <span class="text-primary italic font-serif relative">Semua
                                    <svg class="absolute w-full h-3 -bottom-1 left-0 text-primary opacity-30"
                                        viewBox="0 0 100 10" preserveAspectRatio="none">
                                        <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="3"
                                            fill="none" />
                                    </svg>
                                </span>
                                Informasi Penting.
                            </h2>
                            <p class="text-base md:text-lg text-slate-600 dark:text-accent-muted leading-relaxed">
                                Buat halaman khusus (Bio-Link) untuk mengumpulkan berbagai link penting unit kerja Anda
                                dalam satu tempat agar mudah diakses oleh staf lain atau pasien.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:gap-6 text-left">
                            <div
                                class="flex gap-4 p-5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer">
                                <div
                                    class="shrink-0 w-14 h-14 bg-gradient-to-br from-primary/20 to-teal-500/20 rounded-xl flex items-center justify-center group-hover:bg-primary transition-colors duration-300">
                                    <i
                                        class="fa-solid fa-palette text-primary text-2xl group-hover:text-white transition-colors"></i>
                                </div>
                                <div>
                                    <h4
                                        class="font-bold text-base text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                        Tampilan Rapi</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Halaman link yang
                                        bersih, profesional, dan mudah dibaca di HP.</p>
                                </div>
                            </div>

                            <div
                                class="flex gap-4 p-5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer">
                                <div
                                    class="shrink-0 w-14 h-14 bg-gradient-to-br from-primary/20 to-teal-500/20 rounded-xl flex items-center justify-center group-hover:bg-primary transition-colors duration-300">
                                    <i
                                        class="fa-solid fa-chart-pie text-primary text-2xl group-hover:text-white transition-colors"></i>
                                </div>
                                <div>
                                    <h4
                                        class="font-bold text-base text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                        Pantau Akses</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Lihat statistik seberapa
                                        sering link unit Anda dibuka.</p>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('login') }}"
                            class="inline-block w-full sm:w-auto bg-slate-900 dark:bg-white dark:text-slate-900 text-white px-8 py-4 rounded-xl text-base font-bold transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1 hover:scale-105">
                            Buat Halaman Link Unit
                        </a>
                    </div>

                    <div data-aos="zoom-in-left" data-aos-duration="1200"
                        class="relative flex justify-center mt-8 lg:mt-0 z-0">
                        <div
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-primary/20 blur-[90px] rounded-full w-[250px] h-[250px] md:w-[350px] md:h-[350px] -z-10 animate-pulse">
                        </div>

                        <div
                            class="relative w-[240px] h-[480px] md:w-[300px] md:h-[600px] bg-slate-900 rounded-[2.5rem] md:rounded-[3rem] border-4 md:border-8 border-slate-800 shadow-2xl overflow-hidden p-2 transform transition-all duration-500 ease-out lg:rotate-6 hover:rotate-0 hover:scale-[1.02]">
                            <div
                                class="w-full h-full bg-bg-secondary-section-dark rounded-[2rem] md:rounded-[2.5rem] overflow-hidden flex flex-col p-5 md:p-6 items-center text-center relative">
                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-primary/10 via-transparent to-transparent pointer-events-none">
                                </div>
                                <div
                                    class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-white/10 mb-4 border-4 border-slate-800 shadow-lg z-10 relative flex items-center justify-center">
                                    <i class="fa-solid fa-hospital-user text-3xl md:text-4xl text-primary-light"></i>
                                </div>
                                <h5 class="text-lg md:text-xl font-bold text-white z-10">Unit Humas</h5>
                                <p class="text-xs text-emerald-300/80 mb-6 md:mb-8 z-10 font-medium">Informasi &
                                    Layanan Publik</p>
                                <div class="w-full space-y-3 md:space-y-4 z-10">
                                    <div
                                        class="w-full p-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-xs md:text-sm font-semibold text-white transition hover:translate-x-1 cursor-pointer flex items-center justify-between group">
                                        <span>Jadwal Dokter</span>
                                        <i
                                            class="fa-solid fa-arrow-right text-white/50 group-hover:text-primary transition"></i>
                                    </div>
                                    <div
                                        class="w-full p-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-xs md:text-sm font-semibold text-white transition hover:translate-x-1 cursor-pointer flex items-center justify-between group">
                                        <span>Pendaftaran BPJS</span>
                                        <i
                                            class="fa-solid fa-arrow-right text-white/50 group-hover:text-primary transition"></i>
                                    </div>
                                    <div
                                        class="w-full p-3 bg-gradient-to-r from-primary to-teal-600 hover:from-primary-hover hover:to-teal-700 text-white rounded-xl text-xs md:text-sm font-bold shadow-lg shadow-primary/20 transition cursor-pointer hover:scale-[1.03]">
                                        <i class="fa-solid fa-phone mr-2 animate-pulse"></i> Kontak IGD
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            class="py-16 md:py-24 bg-bg-primary-section dark:bg-bg-primary-section-dark transition-colors relative z-10">
            <div class="max-w-5xl mx-auto px-4 md:px-6">
                <div data-aos="zoom-in" data-aos-duration="1000"
                    class="relative rounded-[2rem] md:rounded-[2.5rem] overflow-hidden bg-gradient-to-br from-primary to-teal-600 p-8 md:p-20 text-center shadow-[0_20px_50px_rgba(16,185,129,0.3)] group hover:scale-[1.01] transition-transform duration-500">

                    <div
                        class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] mix-blend-overlay">
                    </div>

                    <div
                        class="hidden md:block absolute -top-24 -left-24 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float">
                    </div>
                    <div
                        class="hidden md:block absolute -bottom-24 -right-24 w-64 h-64 bg-teal-900/20 rounded-full blur-3xl animate-float-delayed">
                    </div>

                    <div class="relative z-10 max-w-2xl mx-auto">
                        <h2 class="text-2xl md:text-5xl font-black text-white mb-4 md:mb-6 drop-shadow-md">Siap
                            memudahkan pekerjaan Anda?</h2>
                        <p class="text-white/90 text-base md:text-lg mb-8 md:mb-10 font-medium leading-relaxed">Gunakan
                            e-Link untuk pengelolaan dan berbagi informasi digital yang lebih efisien di lingkungan RS
                            PKU Aisyiyah Boyolali.</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('login') }}"
                                class="w-full sm:w-auto bg-white text-primary px-8 py-3 md:px-10 md:py-4 rounded-xl font-bold text-base md:text-lg shadow-xl hover:shadow-2xl hover:bg-slate-50 hover:-translate-y-1 transition-all duration-300">
                                Mulai Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer data-aos="fade-up" data-aos-offset="50" x-data="{ openSection: null }"
        class="bg-bg-secondary-section dark:bg-bg-secondary-section-dark pt-12 md:pt-20 pb-8 md:pb-10 border-t border-slate-200 dark:border-slate-800 transition-colors relative z-10">
        <div class="max-w-7xl mx-auto px-6 text-center md:text-left">
            <div class="grid md:grid-cols-4 gap-0 md:gap-12 mb-8 md:mb-16">

                <div class="col-span-1 md:col-span-1 mb-8 md:mb-0 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                            class="h-10 w-10 object-cover p-0 bg-white rounded-lg border border-slate-100 shadow-sm">
                        <div class="flex flex-col items-start">
                            <h2 class="text-xl font-extrabold tracking-tight text-primary leading-none">e-Link</h2>
                            <span class="text-sm font-bold text-primary">RS PKU Aisyiyah Boyolali</span>
                        </div>
                    </div>
                    <p class="text-slate-600 dark:text-accent-muted text-sm leading-relaxed pr-0 md:pr-4">
                        Alat pendukung operasional digital untuk manajemen link dan informasi di lingkungan Rumah Sakit.
                    </p>
                </div>

                <div class="md:text-left border-b border-slate-200/10 dark:border-slate-700/50 md:border-none">
                    <button @click="openSection = openSection === 'fitur' ? null : 'fitur'"
                        class="flex justify-between items-center w-full py-4 md:py-0 md:mb-6 group focus:outline-none">
                        <h4 class="font-bold text-slate-900 dark:text-white">Fitur</h4>
                        <i class="fa-solid fa-chevron-down md:hidden text-slate-400 transition-transform duration-300"
                            :class="{ 'rotate-180': openSection === 'fitur' }"></i>
                    </button>
                    <ul x-show="openSection === 'fitur'" x-transition
                        class="space-y-3 pb-4 md:pb-0 md:space-y-4 text-sm text-slate-600 dark:text-accent-muted font-medium md:!block">
                        <li><a class="hover:text-primary transition-colors hover:translate-x-1 inline-block"
                                href="{{ route('shortlinks.index') }}">Shortlink</a></li>
                        <li><a class="hover:text-primary transition-colors hover:translate-x-1 inline-block"
                                href="{{ route('pages.index') }}">Bio-Link</a></li>
                        <li><a class="hover:text-primary transition-colors hover:translate-x-1 inline-block"
                                href="{{ route('dashboard') }}">Statistic & Analytics</a></li>
                    </ul>
                </div>

                <div class="md:text-left border-b border-slate-200/10 dark:border-slate-700/50 md:border-none">
                    <button @click="openSection = openSection === 'bantuan' ? null : 'bantuan'"
                        class="flex justify-between items-center w-full py-4 md:py-0 md:mb-6 group focus:outline-none">
                        <h4 class="font-bold text-slate-900 dark:text-white">Bantuan</h4>
                        <i class="fa-solid fa-chevron-down md:hidden text-slate-400 transition-transform duration-300"
                            :class="{ 'rotate-180': openSection === 'bantuan' }"></i>
                    </button>
                    <ul x-show="openSection === 'bantuan'" x-transition
                        class="space-y-3 pb-4 md:pb-0 md:space-y-4 text-sm text-slate-600 dark:text-accent-muted font-medium md:!block">
                        <li><a class="hover:text-primary transition-colors hover:translate-x-1 inline-block"
                                href="#">Pusat Bantuan IT</a></li>
                        <li><a class="hover:text-primary transition-colors hover:translate-x-1 inline-block"
                                href="#">Panduan</a></li>
                        <li><a class="hover:text-primary transition-colors hover:translate-x-1 inline-block"
                                href="#">FAQ</a></li>
                    </ul>
                </div>

                <div class="md:text-left border-b border-slate-200/10 dark:border-slate-700/50 md:border-none">
                    <button @click="openSection = openSection === 'tentang' ? null : 'tentang'"
                        class="flex justify-between items-center w-full py-4 md:py-0 md:mb-6 group focus:outline-none">
                        <h4 class="font-bold text-slate-900 dark:text-white">Tentang RS</h4>
                        <i class="fa-solid fa-chevron-down md:hidden text-slate-400 transition-transform duration-300"
                            :class="{ 'rotate-180': openSection === 'tentang' }"></i>
                    </button>
                    <ul x-show="openSection === 'tentang'" x-transition
                        class="space-y-3 pb-4 md:pb-0 md:space-y-4 text-sm text-slate-600 dark:text-accent-muted font-medium md:!block">
                        <li><a class="hover:text-primary transition-colors hover:translate-x-1 inline-block"
                                href="https://rspkuboyolali.co.id/profil-rumah-sakit/">Profil Rumah Sakit</a></li>
                        <li><a class="hover:text-primary transition-colors hover:translate-x-1 inline-block"
                                href="https://rspkuboyolali.co.id/">Website Resmi</a></li>
                        <li><a class="hover:text-primary transition-colors hover:translate-x-1 inline-block"
                                href="https://wa.link/yle42w">Kontak Internal</a></li>
                    </ul>
                </div>
            </div>

            <div
                class="border-t border-slate-200 dark:border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500 dark:text-slate-400 font-medium">
                <p class="text-center md:text-left">&copy; {{ date('Y') }} e-Link RS PKU Aisyiyah Boyolali.<br
                        class="md:hidden"> Hak cipta dilindungi.</p>
                <div class="flex gap-6 md:gap-8">
                    <a class="hover:text-primary transition-colors" href="#">Kebijakan Privasi</a>
                    <a class="hover:text-primary transition-colors" href="#">Syarat Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: false,
            mirror: true,
            offset: 50,
            easing: 'ease-out-cubic',
        });

        function shortenerLogic() {
            return {
                url: '',
                loading: false,
                result: null,
                error: null,
                finalQrUrl: null,
                logoUrl: '{{ asset('images/logo_pku.png') }}',

                shorten() {
                    if (!this.url) return;
                    this.loading = true;
                    this.error = null;
                    this.result = null;
                    this.finalQrUrl = null;

                    fetch('{{ route('guest.shorten') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                url: this.url
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.loading = false;
                            if (data.status === 'success') {
                                this.result = data;
                                this.url = '';

                                // Panggil fungsi untuk menggabungkan logo
                                this.generateQrWithLogo(data.qr_code);
                            } else {
                                this.error = data.message || 'URL invalid.';
                            }
                        })
                        .catch(() => {
                            this.loading = false;
                            this.error = 'Koneksi gagal / Terjadi kesalahan server.';
                        });
                },

                resetForm() {
                    this.url = '';
                    this.result = null;
                    this.finalQrUrl = null;
                },

                copyToClipboard() {
                    if (!this.result) return;
                    navigator.clipboard.writeText(this.result.short_url);
                    alert('Link pendek berhasil disalin!');
                },

                // Fungsi Generasi QR dengan Logo
                generateQrWithLogo(qrSourceUrl) {
                    const canvas = document.createElement('canvas');
                    const size = 1200;
                    canvas.width = size;
                    canvas.height = size;
                    const ctx = canvas.getContext('2d');
                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';
                    ctx.fillStyle = "#ffffff";
                    ctx.fillRect(0, 0, size, size);

                    const loadImage = (src) => {
                        return new Promise((resolve, reject) => {
                            const img = new Image();
                            img.crossOrigin = "Anonymous";
                            img.onload = () => resolve(img);
                            img.onerror = (e) => reject(e);
                            img.src = src;
                        });
                    };

                    // 2. Fetch SVG lalu convert ke Base64 seperti di dashboard
                    fetch(qrSourceUrl)
                        .then(res => res.text())
                        .then(svgData => {
                            const svgBase64 = "data:image/svg+xml;base64," + btoa(unescape(encodeURIComponent(
                                svgData)));

                            Promise.all([loadImage(svgBase64), loadImage(this.logoUrl)])
                                .then(([imgQRObj, imgLogoObj]) => {

                                    // 3. Padding dan margin disamakan persis (30px)
                                    const padding = 10;
                                    const qrActualSize = size - (padding * 2);
                                    ctx.drawImage(imgQRObj, padding, padding, qrActualSize, qrActualSize);

                                    // 4. Logo di tengah dengan ukuran proporsional (0.22)
                                    const logoSize = size * 0.22;
                                    const logoX = (size - logoSize) / 2;
                                    const logoY = (size - logoSize) / 2;
                                    const centerX = size / 2;
                                    const centerY = size / 2;

                                    // Lingkaran putih background logo
                                    ctx.beginPath();
                                    ctx.arc(centerX, centerY, (logoSize / 2) + 20, 0, 2 * Math.PI);
                                    ctx.fillStyle = "#ffffff";
                                    ctx.fill();
                                    ctx.closePath();
                                    ctx.drawImage(imgLogoObj, logoX, logoY, logoSize, logoSize);
                                    this.finalQrUrl = canvas.toDataURL("image/png", 1.0);
                                })
                                .catch(err => {
                                    console.error("Gagal memuat gambar untuk Canvas:", err);
                                    this.finalQrUrl = qrSourceUrl;
                                });
                        })
                        .catch(err => {
                            console.error("Gagal melakukan fetch SVG:", err);
                            this.finalQrUrl = qrSourceUrl;
                        });
                }
            }
        }
    </script>
</body>

</html>
