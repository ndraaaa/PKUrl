<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mengalihkan... | e-Link RS PKU</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #030712;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
        }

        /* ── Background (unchanged) ── */
        .bg-layer {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 60% 50% at 50% 0%, rgba(16, 185, 129, .12) 0%, transparent 70%),
                radial-gradient(ellipse 40% 30% at 80% 80%, rgba(5, 150, 105, .06) 0%, transparent 60%),
                radial-gradient(ellipse 30% 40% at 10% 70%, rgba(52, 211, 153, .05) 0%, transparent 60%),
                #030712;
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .025) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 50%, black 40%, transparent 100%);
            -webkit-mask-image: radial-gradient(ellipse 80% 60% at 50% 50%, black 40%, transparent 100%);
        }

        .particles {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(52, 211, 153, .6);
            border-radius: 50%;
            animation: floatUp linear infinite
        }

        @keyframes floatUp {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0
            }

            10% {
                opacity: 1
            }

            90% {
                opacity: .5
            }

            100% {
                transform: translateY(-10vh) scale(1.5);
                opacity: 0
            }
        }

        /* ── Splash Card (unchanged) ── */
        .card {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 3rem 2.5rem 2.5rem;
            width: min(420px, 92vw);
            background: rgba(255, 255, 255, .03);
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 28px;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: 0 0 0 1px rgba(16, 185, 129, .08), 0 32px 64px rgba(0, 0, 0, .5), inset 0 1px 0 rgba(255, 255, 255, .08);
            animation: cardIn .6s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(.97)
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1)
            }
        }

        .logo-wrap {
            position: relative;
            width: 96px;
            height: 96px;
            margin-bottom: 1.75rem
        }

        .logo-aura {
            position: absolute;
            inset: -12px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, .2) 0%, transparent 70%);
            animation: aura 2s ease-in-out infinite alternate
        }

        @keyframes aura {
            from {
                transform: scale(.9);
                opacity: .5
            }

            to {
                transform: scale(1.15);
                opacity: 1
            }
        }

        .ring-svg {
            position: absolute;
            inset: -16px;
            width: calc(100% + 32px);
            height: calc(100% + 32px)
        }

        .ring-track {
            fill: none;
            stroke: rgba(16, 185, 129, .1);
            stroke-width: 1.5
        }

        .ring-arc {
            fill: none;
            stroke-width: 1.5;
            stroke: url(#arcGrad);
            stroke-linecap: round;
            stroke-dasharray: 200 220;
            transform-origin: center;
            animation: spinRing 2s linear infinite
        }

        @keyframes spinRing {
            to {
                transform: rotate(360deg)
            }
        }

        .ring-dot {
            fill: #34d399;
            animation: spinRing 2s linear infinite;
            transform-origin: center
        }

        .logo-circle {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(10, 25, 20, .9);
            border: 1px solid rgba(16, 185, 129, .25);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 20px rgba(16, 185, 129, .1);
            overflow: hidden
        }

        .logo-circle img {
            width: 60%;
            height: 60%;
            object-fit: contain;
            filter: drop-shadow(0 0 8px rgba(52, 211, 153, .4))
        }

        .logo-fallback {
            display: none;
            color: #34d399
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            background: rgba(16, 185, 129, .08);
            border: 1px solid rgba(16, 185, 129, .2);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            color: #6ee7b7;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 1.25rem
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #34d399;
            animation: blink 1s ease-in-out infinite
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 4px #34d399
            }

            50% {
                opacity: .3;
                box-shadow: none
            }
        }

        h1 {
            font-size: clamp(1.25rem, 5vw, 1.6rem);
            font-weight: 800;
            letter-spacing: -.02em;
            line-height: 1.2;
            margin-bottom: .6rem;
            background: linear-gradient(135deg, #fff 0%, #9ca3af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all .6s ease
        }

        h1.done {
            background: linear-gradient(135deg, #6ee7b7 0%, #34d399 50%, #10b981 100%);
            -webkit-background-clip: text;
            background-clip: text
        }

        .subtext {
            font-size: 13px;
            color: rgba(255, 255, 255, .4);
            margin-bottom: 1.75rem
        }

        .url-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 12px;
            margin-bottom: 1.75rem;
            min-width: 0
        }

        .url-chip svg {
            flex-shrink: 0;
            color: rgba(255, 255, 255, .3)
        }

        .url-text {
            font-size: 12px;
            font-weight: 500;
            color: #34d399;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            min-width: 0
        }

        .progress-wrap {
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, .06);
            border-radius: 100px;
            overflow: hidden
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            border-radius: 100px;
            background: linear-gradient(90deg, #059669, #34d399, #6ee7b7);
            animation: fill 2s cubic-bezier(.4, 0, .2, 1) forwards;
            position: relative
        }

        @keyframes fill {
            0% {
                width: 0%
            }

            60% {
                width: 75%
            }

            100% {
                width: 100%
            }
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            right: -20px;
            width: 20px;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .5), transparent);
            animation: shimmer 1.2s ease-in-out infinite
        }

        @keyframes shimmer {
            0% {
                right: 110%
            }

            100% {
                right: -20%
            }
        }

        .timer {
            font-size: 11px;
            color: rgba(255, 255, 255, .25);
            margin-top: 10px;
            font-variant-numeric: tabular-nums;
            letter-spacing: .05em
        }

        .footer {
            position: fixed;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255, 255, 255, .2);
            letter-spacing: .15em;
            text-transform: uppercase;
            white-space: nowrap
        }

        .footer-divider {
            width: 24px;
            height: 1px;
            background: rgba(255, 255, 255, .1)
        }

        .footer svg {
            color: rgba(52, 211, 153, .5)
        }

        /* ──────────────────────────────
           AD MODAL — redesigned
        ────────────────────────────── */
        #ad-modal {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(3, 7, 18, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: modalIn .4s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes modalIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes modalOut {
            from {
                opacity: 1
            }

            to {
                opacity: 0
            }
        }

        .ad-panel {
            width: min(400px, 94vw);
            background: rgba(8, 20, 16, 0.95);
            border: 1px solid rgba(16, 185, 129, 0.18);
            border-radius: 24px;
            box-shadow: 0 0 0 1px rgba(52, 211, 153, .06), 0 40px 80px rgba(0, 0, 0, .7);
            overflow: hidden;
            animation: panelIn .45s cubic-bezier(.16, 1, .3, 1) .05s both;
        }

        @keyframes panelIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(.97)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        /* Banner area — fixed 16:9 */
        .ad-banner-area {
            position: relative;
            width: 100%;
            aspect-ratio: 16/9;
            background: #0a1a14;
            overflow: hidden;
        }

        .ad-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity .5s ease, transform .5s ease;
            transform: scale(1.02);
        }

        .ad-slide.active {
            opacity: 1;
            transform: scale(1);
        }

        .ad-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .ad-slide-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #0a1f18 0%, #0d2a1f 50%, #071410 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ad-slide-placeholder svg {
            opacity: .15;
            color: #34d399;
        }

        /* Dots */
        .ad-dots {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 6px;
            z-index: 2;
        }

        .ad-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .3);
            cursor: pointer;
            transition: background .3s, transform .3s;
        }

        .ad-dot.active {
            background: #34d399;
            transform: scale(1.3);
        }

        /* Prev/Next arrows */
        .ad-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(0, 0, 0, .4);
            border: 1px solid rgba(255, 255, 255, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s;
            color: #fff;
        }

        .ad-arrow:hover {
            background: rgba(0, 0, 0, .65)
        }

        .ad-arrow.prev {
            left: 10px
        }

        .ad-arrow.next {
            right: 10px
        }

        /* Info section */
        .ad-info {
            padding: 1.1rem 1.25rem 1.25rem;
        }

        .ad-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(52, 211, 153, .6);
            margin-bottom: 4px;
        }

        .ad-title {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 10px;
            min-height: 20px;
            transition: opacity .3s;
        }

        .ad-cta-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ad-cta-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            color: #34d399;
            text-decoration: none;
            padding: 5px 12px;
            border: 1px solid rgba(52, 211, 153, .25);
            border-radius: 100px;
            background: rgba(52, 211, 153, .07);
            transition: background .2s, border-color .2s;
        }

        .ad-cta-link:hover {
            background: rgba(52, 211, 153, .14);
            border-color: rgba(52, 211, 153, .4)
        }

        .ad-counter {
            font-size: 11px;
            color: rgba(255, 255, 255, .25);
            margin-left: auto;
            font-variant-numeric: tabular-nums;
        }

        /* Close button */
        .ad-close-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: calc(100% - 2.5rem);
            margin: 0 1.25rem 1.25rem;
            padding: 11px;
            background: linear-gradient(90deg, #059669, #10b981);
            border: none;
            border-radius: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .02em;
            cursor: pointer;
            transition: opacity .2s, transform .15s;
            box-shadow: 0 4px 20px rgba(16, 185, 129, .25);
        }

        .ad-close-btn:hover {
            opacity: .9
        }

        .ad-close-btn:active {
            transform: scale(.98)
        }

        .ad-close-btn svg {
            flex-shrink: 0
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(.95)
            }

            to {
                opacity: 1;
                transform: scale(1)
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1)
            }

            to {
                opacity: 0;
                transform: scale(.95)
            }
        }
    </style>
</head>

<body>
    <div class="bg-layer"></div>
    <div class="bg-grid"></div>
    <div class="particles" id="particles"></div>

    <div class="card">
        <div class="logo-wrap">
            <div class="logo-aura"></div>
            <svg class="ring-svg" viewBox="0 0 128 128">
                <defs>
                    <linearGradient id="arcGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#059669" />
                        <stop offset="100%" stop-color="#6ee7b7" />
                    </linearGradient>
                </defs>
                <circle class="ring-track" cx="64" cy="64" r="58" />
                <path class="ring-arc" d="M 64 6 A 58 58 0 0 1 116 88" stroke-linecap="round" />
                <circle class="ring-dot" cx="64" cy="6" r="3.5" />
            </svg>
            <div class="logo-circle">
                <img src="{{ asset('images/logo_pku.png') }}" alt="Logo RS PKU"
                    onerror="this.style.display='none';document.getElementById('fallbackIcon').style.display='block'">
                <svg id="fallbackIcon" class="logo-fallback" width="32" height="32" fill="none"
                    stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
        </div>

        <div class="badge">
            <div class="badge-dot"></div> Tautan Terverifikasi
        </div>
        <h1 id="statusText">Memverifikasi Tautan...</h1>
        <p class="subtext" id="subText">Memeriksa keamanan dan mengalihkan halaman</p>

        <div class="url-chip">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
            </svg>
            <span class="url-text">{{ $link->destination_url }}</span>
        </div>

        <div class="progress-wrap">
            <div class="progress-bar"></div>
        </div>
        <p class="timer" id="timerText">Mengalihkan dalam 2 detik...</p>

        <div class="mt-4 text-center opacity-0 translate-y-2" id="manual-click-container"
            style="display:none;animation:fadeIn .5s ease .2s forwards;">
            <a href="{{ $link->destination_url }}"
                class="text-[11px] text-gray-400 hover:text-emerald-400 underline decoration-gray-600/50 hover:decoration-emerald-400/50 underline-offset-4 transition-colors">
                Jika tidak otomatis dialihkan, klik di sini
            </a>
        </div>
    </div>

    {{-- ── AD MODAL ── --}}
    @if (isset($ads) && $ads->where('is_active', true)->isNotEmpty())
        @php $activeAds = $ads->where('is_active', true)->values(); @endphp
        <div id="ad-modal">
            <div class="ad-panel">

                {{-- Banner --}}
                <div class="ad-banner-area">
                    @foreach ($activeAds as $i => $ad)
                        <div class="ad-slide {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                            @if ($ad->image_path)
                                <img src="{{ asset('storage/' . $ad->image_path) }}" alt="{{ $ad->title }}">
                            @else
                                <div class="ad-slide-placeholder">
                                    <svg width="56" height="56" fill="none" stroke="currentColor"
                                        stroke-width="1" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <path d="M3 9h18M9 21V9" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    @if ($activeAds->count() > 1)
                        <button class="ad-arrow prev" onclick="adPrev()" aria-label="Sebelumnya">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button class="ad-arrow next" onclick="adNext()" aria-label="Berikutnya">
                            <svg width="14" height="14" fill="none" stroke="currentColor"
                                stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <div class="ad-dots" id="adDots">
                            @foreach ($activeAds as $i => $ad)
                                <div class="ad-dot {{ $i === 0 ? 'active' : '' }}"
                                    onclick="adGoTo({{ $i }})"></div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="ad-info">
                    <p class="ad-eyebrow">Informasi RS PKU</p>
                    <p class="ad-title" id="adTitle">{{ $activeAds->first()->title }}</p>
                    <div class="ad-cta-row">
                        {{-- Kita tambahkan id="adCtaLink" agar mudah diakses JS --}}
                        <a href="{{ $activeAds->first()->target_url ?? '#' }}" target="_blank" class="ad-cta-link"
                            id="adCtaLink" style="{{ $activeAds->first()->target_url ? '' : 'display:none;' }}">
                            <svg width="12" height="12" fill="none" stroke="currentColor"
                                stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Info selengkapnya
                        </a>
                        <span class="ad-counter" id="adCounter">1 / {{ $activeAds->count() }}</span>
                    </div>
                </div>

                <button class="ad-close-btn" onclick="closeAd()">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Tutup &amp; Lanjutkan
                </button>
            </div>
        </div>

        <script>
            const adData = @json($activeAds->map(fn($a) => ['title' => $a->title, 'target_url' => $a->target_url ?? null]));
            let adCurrent = 0;
            const adTotal = adData.length;
            let adTimer;

            function adGoTo(idx) {
                const slides = document.querySelectorAll('.ad-slide');
                const dots = document.querySelectorAll('.ad-dot');

                // Reset state sebelumnya
                slides[adCurrent].classList.remove('active');
                if (dots[adCurrent]) dots[adCurrent].classList.remove('active');

                // Update index
                adCurrent = (idx + adTotal) % adTotal;

                slides[adCurrent].classList.add('active');
                if (dots[adCurrent]) dots[adCurrent].classList.add('active');

                const d = adData[adCurrent];

                document.getElementById('adTitle').textContent = d.title;
                document.getElementById('adCounter').textContent = (adCurrent + 1) + ' / ' + adTotal;

                const ctaEl = document.getElementById('adCtaLink');
                if (d.target_url && d.target_url.trim() !== '') {
                    ctaEl.href = d.target_url;
                    ctaEl.style.display = 'inline-flex';
                } else {
                    ctaEl.style.display = 'none';
                }

                resetAdTimer();
            }

            function adNext() {
                adGoTo(adCurrent + 1)
            }

            function adPrev() {
                adGoTo(adCurrent - 1)
            }

            function resetAdTimer() {
                clearInterval(adTimer);
                if (adTotal > 1) adTimer = setInterval(adNext, 4500);
            }
            resetAdTimer();
        </script>
    @endif

    <div class="footer">
        <div class="footer-divider"></div>
        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd" />
        </svg>
        Secured by e-Link RS PKU
        <div class="footer-divider"></div>
    </div>

    <script>
        // Particles
        const pc = document.getElementById('particles');
        for (let i = 0; i < 20; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.cssText =
                `left:${Math.random()*100}%;width:${1+Math.random()*2}px;height:${1+Math.random()*2}px;animation-duration:${6+Math.random()*10}s;animation-delay:${Math.random()*8}s;opacity:${.3+Math.random()*.5}`;
            pc.appendChild(p);
        }

        const hasAd = {{ isset($ads) && $ads->where('is_active', true)->isNotEmpty() ? 'true' : 'false' }};
        let redirectExecuted = false;

        function executeRedirect() {
            if (redirectExecuted) return;
            redirectExecuted = true;
            const h = document.getElementById('statusText');
            h.textContent = 'Mengalihkan Halaman...';
            h.classList.add('done');
            const destUrl = "{!! $link->destination_url !!}";
            if (destUrl.startsWith('mailto:') || destUrl.startsWith('tel:')) {
                window.location.href = destUrl;
            } else {
                window.location.replace(destUrl);
            }
        }

        if (!hasAd) {
            let secs = 2;
            const timerEl = document.getElementById('timerText');
            const countdown = setInterval(() => {
                secs = Math.max(0, secs - 1);
                timerEl.textContent = secs > 0 ? `Mengalihkan dalam ${secs} detik...` : 'Mengalihkan...';
                if (secs === 0) {
                    clearInterval(countdown);
                    executeRedirect();
                }
            }, 1000);
        } else {
            document.getElementById('timerText').style.display = 'none';
        }

        window.closeAd = function() {
            const modal = document.getElementById('ad-modal');
            modal.style.animation = 'modalOut .3s ease forwards';
            setTimeout(() => {
                modal.style.display = 'none';
                executeRedirect();
            }, 300);
        }
    </script>
</body>

</html>
