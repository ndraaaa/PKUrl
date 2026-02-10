<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ config('app.name') }} - Link Management Platform</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: "media",
            theme: {
                extend: {
                    colors: {
                        "primary": "#10B981",
                        "primary-hover": "#059669",
                        "primary-light": "#D1FAE5",

                        // BACKGROUNDS (Sesuai request sebelumnya: Seling-seling)
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
                    // Animasi lambat khusus hiasan mobile
                    animation: {
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
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
        }

        [x-cloak] {
            display: none !important;
        }

        /* Hide scrollbar untuk swipe mobile */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body
    class="bg-bg-primary-section dark:bg-bg-primary-section-dark text-slate-900 dark:text-white transition-colors duration-300 selection:bg-primary selection:text-white overflow-x-hidden">

    <header
        class="sticky top-0 z-50 w-full border-b border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-bg-primary-section-dark/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="E-Link Logo"
                    class="h-10 w-auto object-contain group-hover:scale-105 transition-transform filter drop-shadow-lg">
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">E-Link</h2>
            </a>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="bg-white dark:bg-slate-custom text-slate-900 dark:text-white border border-emerald-200 dark:border-emerald-800 px-6 py-2.5 rounded-lg text-sm font-bold transition-all hover:bg-emerald-50 dark:hover:bg-emerald-900/50">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-primary hover:bg-primary-hover text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5">Masuk</a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main class="w-full" x-data="shortenerLogic()">

        <section
            class="relative overflow-hidden pt-16 pb-24 md:pt-32 md:pb-40 bg-bg-primary-section dark:bg-bg-primary-section-dark transition-colors">

            <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none md:hidden">
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-72 h-72 bg-primary/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
                </div>
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-blue-400/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"
                    style="animation-delay: 2s"></div>
            </div>
            <div
                class="hidden md:block absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-primary/20 via-transparent to-transparent">
            </div>

            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-bold mb-8 uppercase tracking-widest animate-fade-in-up">
                    <i class="fa-solid fa-circle-check"></i> Trusted by Creators
                </div>

                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8 leading-[1.1]">
                    Your Links, <span class="text-primary">Synchronized</span> and Simplified.
                </h1>

                <p class="text-lg md:text-xl text-slate-600 dark:text-accent-muted max-w-2xl mx-auto mb-12">
                    Cara profesional untuk memendekkan URL, melacak performa, dan mengelola identitas digital Anda.
                </p>

                <div class="w-full max-w-2xl mx-auto relative z-20">
                    <div
                        class="p-2 bg-white dark:bg-slate-custom/30 border border-emerald-100 dark:border-emerald-800/50 rounded-2xl shadow-2xl shadow-primary/10 backdrop-blur-sm transition-all focus-within:border-primary/50 focus-within:ring-4 focus-within:ring-primary/10">
                        <div class="flex flex-col md:flex-row gap-2">
                            <div class="flex-1 flex items-center px-4 py-3 md:py-0">
                                <i class="fa-solid fa-link text-emerald-400 mr-3 text-lg"></i>
                                <input x-model="url" @keydown.enter="shorten()"
                                    class="w-full bg-transparent border-none focus:ring-0 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-emerald-200/50 text-lg p-0"
                                    placeholder="Tempel link panjang Anda di sini..." type="url" />
                            </div>
                            <button @click="shorten()" :disabled="loading || !url"
                                class="bg-primary hover:bg-primary-hover text-white px-8 py-4 rounded-xl text-lg font-bold transition-all flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed shadow-lg shadow-primary/25">
                                <span x-show="!loading">Shorten Now</span>
                                <span x-show="loading" x-cloak><i class="fa-solid fa-circle-notch fa-spin"></i></span>
                                <span x-show="!loading" class="fa-solid fa-arrow-right"></span>
                            </button>
                        </div>
                    </div>

                    <div x-show="error" x-transition class="mt-4 text-center">
                        <span
                            class="inline-block px-4 py-2 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-sm font-bold border border-red-200 dark:border-red-800">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i> <span x-text="error"></span>
                        </span>
                    </div>

                    <div x-show="result" x-cloak x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-10"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="mt-8 p-6 bg-white dark:bg-slate-custom/40 border border-emerald-100 dark:border-emerald-800 rounded-2xl shadow-xl backdrop-blur-md text-left">

                        <div class="flex flex-col sm:flex-row gap-6 items-center">
                            <div class="shrink-0 bg-white p-3 rounded-xl shadow-inner border border-emerald-50">
                                <img :src="result?.qr_code" class="w-28 h-28 object-contain">
                            </div>

                            <div class="flex-1 w-full min-w-0 space-y-4">
                                <div>
                                    <p class="text-xs font-bold text-primary uppercase tracking-widest mb-1">Shortlink
                                        Ready</p>
                                    <div class="flex items-center gap-2 group cursor-pointer"
                                        @click="copyToClipboard()">
                                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white truncate"
                                            x-text="result?.short_url"></h3>
                                        <i
                                            class="fa-regular fa-copy text-slate-400 hover:text-primary transition-colors"></i>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-emerald-200/70 mt-1 truncate"
                                        x-text="result?.original_url"></p>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <a :href="result?.qr_download"
                                        class="flex-1 sm:flex-none px-5 py-2.5 rounded-lg bg-emerald-50 dark:bg-slate-custom hover:bg-emerald-100 dark:hover:bg-emerald-900 text-slate-700 dark:text-white text-sm font-bold transition flex items-center justify-center gap-2 border border-emerald-100 dark:border-emerald-800">
                                        <i class="fa-solid fa-download"></i> PNG
                                    </a>
                                    <a :href="result?.short_url" target="_blank"
                                        class="flex-1 sm:flex-none px-5 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                                        Visit Link <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center border-t border-emerald-100 dark:border-emerald-800/50 pt-3">
                            <button @click="url=''; result=null"
                                class="text-xs text-slate-500 hover:text-primary transition">Create another
                                link</button>
                        </div>
                    </div>
                </div>

                <div
                    class="md:hidden mt-12 overflow-x-auto no-scrollbar pb-4 -mx-6 px-6 flex gap-4 snap-x snap-mandatory">
                    <div
                        class="snap-center shrink-0 w-40 p-4 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 flex flex-col items-center gap-3 shadow-sm">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-lg">
                            1</div>
                        <span class="text-sm font-bold">Paste URL</span>
                    </div>
                    <div
                        class="snap-center shrink-0 w-40 p-4 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 flex flex-col items-center gap-3 shadow-sm">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-lg">
                            2</div>
                        <span class="text-sm font-bold">Get QR</span>
                    </div>
                    <div
                        class="snap-center shrink-0 w-40 p-4 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 flex flex-col items-center gap-3 shadow-sm">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-lg">
                            3</div>
                        <span class="text-sm font-bold">Share</span>
                    </div>
                </div>

                <div class="hidden md:grid grid-cols-3 gap-8 mt-16 max-w-3xl mx-auto opacity-70">
                    <div class="flex items-center justify-center gap-3 text-sm text-slate-600 dark:text-accent-muted">
                        <span
                            class="w-6 h-6 rounded-full bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-[10px] font-bold border border-primary/30 text-primary">1</span>
                        Paste your URL
                    </div>
                    <div class="flex items-center justify-center gap-3 text-sm text-slate-600 dark:text-accent-muted">
                        <span
                            class="w-6 h-6 rounded-full bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-[10px] font-bold border border-primary/30 text-primary">2</span>
                        Get Shortlink & QR
                    </div>
                    <div class="flex items-center justify-center gap-3 text-sm text-slate-600 dark:text-accent-muted">
                        <span
                            class="w-6 h-6 rounded-full bg-primary/10 dark:bg-primary/20 flex items-center justify-center text-[10px] font-bold border border-primary/30 text-primary">3</span>
                        Share everywhere
                    </div>
                </div>

            </div>
        </section>

        <section
            class="py-24 bg-bg-secondary-section dark:bg-bg-secondary-section-dark border-y border-slate-200 dark:border-slate-700 transition-colors">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-20 items-center">
                    <div class="space-y-8 text-center lg:text-left">
                        <div class="space-y-4">
                            <h2 class="text-4xl md:text-5xl font-black leading-tight text-slate-900 dark:text-white">
                                One Link for Your <span class="text-primary italic font-serif">Entire</span> Bio.
                            </h2>
                            <p class="text-lg text-slate-600 dark:text-accent-muted">
                                Create a stylish, mobile-optimized landing page for your social profiles. Showcase your
                                latest content, products, and links in seconds.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-left">
                            <div
                                class="flex gap-4 p-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all">
                                <i class="fa-solid fa-palette text-primary text-2xl"></i>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900 dark:text-white">Custom Themes</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Match your brand.</p>
                                </div>
                            </div>

                            <div
                                class="flex gap-4 p-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all">
                                <i class="fa-solid fa-chart-pie text-primary text-2xl"></i>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-900 dark:text-white">Live Insights</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Track audience growth.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('login') }}"
                            class="inline-block bg-primary hover:bg-primary-hover text-white px-8 py-3.5 rounded-lg text-base font-bold transition-all shadow-lg shadow-primary/20">
                            Build Your Bio-Link
                        </a>
                    </div>

                    <div class="relative flex justify-center mt-12 lg:mt-0">
                        <div class="absolute inset-0 bg-primary/20 blur-[100px] rounded-full scale-75"></div>
                        <div
                            class="relative w-[260px] h-[520px] md:w-[300px] md:h-[600px] bg-slate-900 rounded-[3rem] border-8 border-slate-800 shadow-2xl overflow-hidden p-2 transform rotate-0 lg:rotate-3 lg:hover:rotate-0 transition duration-500">
                            <div
                                class="w-full h-full bg-background-dark rounded-[2.5rem] overflow-hidden flex flex-col p-6 items-center text-center relative">
                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-primary/20 to-background-dark pointer-events-none">
                                </div>
                                <div
                                    class="w-20 h-20 rounded-full bg-gradient-to-tr from-primary to-teal-400 mb-4 border-4 border-white/10 z-10">
                                </div>
                                <h5 class="text-lg font-bold text-white z-10">@elink_user</h5>
                                <p class="text-[10px] text-accent-muted mb-6 z-10">Digital Creator</p>
                                <div class="w-full space-y-3 z-10">
                                    <div
                                        class="w-full py-3 bg-white/10 border border-white/10 rounded-xl text-xs font-semibold text-white">
                                        Latest Portfolio</div>
                                    <div
                                        class="w-full py-3 bg-white/10 border border-white/10 rounded-xl text-xs font-semibold text-white">
                                        My YouTube Channel</div>
                                    <div
                                        class="w-full py-3 bg-primary text-white rounded-xl text-xs font-bold shadow-lg shadow-primary/30">
                                        Buy Me a Coffee</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 bg-bg-primary-section dark:bg-bg-primary-section-dark transition-colors">
            <div class="max-w-5xl mx-auto px-6">
                <div
                    class="relative rounded-3xl overflow-hidden bg-primary p-12 md:p-20 text-center shadow-2xl shadow-primary/30">
                    <div
                        class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
                    </div>
                    <div class="relative z-10 max-w-2xl mx-auto">
                        <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Ready to simplify your links?</h2>
                        <p class="text-white/80 text-lg mb-10">Join thousands of businesses and creators using E-Link.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('login') }}"
                                class="bg-white text-primary px-10 py-4 rounded-xl font-bold text-lg hover:bg-slate-100 transition-all">Get
                                Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer
        class="bg-bg-secondary-section dark:bg-bg-secondary-section-dark pt-16 pb-8 border-t border-slate-200 dark:border-slate-700 transition-colors">
        <div class="max-w-7xl mx-auto px-6 text-center md:text-left">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto object-contain">
                        <h2 class="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white">E-Link</h2>
                    </div>
                    <p class="text-slate-600 dark:text-accent-muted text-sm leading-relaxed">
                        The ultimate tool for link management and digital identity visualization.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Product</h4>
                    <ul class="space-y-4 text-sm text-slate-600 dark:text-accent-muted">
                        <li><a class="hover:text-primary transition-colors" href="{{ route('shortlinks.index') }}">URL
                                Shortener</a></li>
                        <li><a class="hover:text-primary transition-colors" href="{{ route('pages.index') }}">Bio-Link
                                Builder</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Resources</h4>
                    <ul class="space-y-4 text-sm text-slate-600 dark:text-accent-muted">
                        <li><a class="hover:text-primary transition-colors" href="#">Help Center</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Company</h4>
                    <ul class="space-y-4 text-sm text-slate-600 dark:text-accent-muted">
                        <li><a class="hover:text-primary transition-colors" href="#">About Us</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div
                class="border-t border-slate-200 dark:border-slate-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500 dark:text-accent-muted/50">
                <p>&copy; {{ date('Y') }} E-Link. All rights reserved.</p>
                <div class="flex gap-8">
                    <a class="hover:text-primary" href="#">Privacy Policy</a>
                    <a class="hover:text-primary" href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function shortenerLogic() {
            return {
                url: '',
                loading: false,
                result: null,
                error: null,
                copied: false,

                shorten() {
                    if (!this.url) return;
                    this.loading = true;
                    this.error = null;
                    this.result = null;

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
                            } else {
                                this.error = data.message || 'URL invalid.';
                            }
                        })
                        .catch(() => {
                            this.loading = false;
                            this.error = 'Connection failed.';
                        });
                },

                copyToClipboard() {
                    if (!this.result) return;
                    navigator.clipboard.writeText(this.result.short_url);
                    alert('Shortlink copied!');
                }
            }
        }
    </script>
</body>

</html>
