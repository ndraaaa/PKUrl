<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mengalihkan... | e-Link RS PKU</title>
    <meta http-equiv="refresh" content="2;url={{ $link->destination_url }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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

        /* === Background Layer === */
        .bg-layer {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 60% 50% at 50% 0%, rgba(16, 185, 129, 0.12) 0%, transparent 70%),
                radial-gradient(ellipse 40% 30% at 80% 80%, rgba(5, 150, 105, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse 30% 40% at 10% 70%, rgba(52, 211, 153, 0.05) 0%, transparent 60%),
                #030712;
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.025) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 50%, black 40%, transparent 100%);
            -webkit-mask-image: radial-gradient(ellipse 80% 60% at 50% 50%, black 40%, transparent 100%);
        }

        /* Floating particles */
        .particles {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(52, 211, 153, 0.6);
            border-radius: 50%;
            animation: floatUp linear infinite;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 0.5;
            }

            100% {
                transform: translateY(-10vh) scale(1.5);
                opacity: 0;
            }
        }

        /* === Main Card === */
        .card {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 3rem 2.5rem 2.5rem;
            width: min(420px, 92vw);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 28px;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow:
                0 0 0 1px rgba(16, 185, 129, 0.08),
                0 32px 64px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
            animation: cardIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* === Logo Ring === */
        .logo-wrap {
            position: relative;
            width: 96px;
            height: 96px;
            margin-bottom: 1.75rem;
        }

        .logo-aura {
            position: absolute;
            inset: -12px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
            animation: aura 2s ease-in-out infinite alternate;
        }

        @keyframes aura {
            from {
                transform: scale(0.9);
                opacity: 0.5;
            }

            to {
                transform: scale(1.15);
                opacity: 1;
            }
        }

        .ring-svg {
            position: absolute;
            inset: -16px;
            width: calc(100% + 32px);
            height: calc(100% + 32px);
        }

        .ring-track {
            fill: none;
            stroke: rgba(16, 185, 129, 0.1);
            stroke-width: 1.5;
        }

        .ring-arc {
            fill: none;
            stroke-width: 1.5;
            stroke: url(#arcGrad);
            stroke-linecap: round;
            stroke-dasharray: 200 220;
            transform-origin: center;
            animation: spinRing 2s linear infinite;
        }

        @keyframes spinRing {
            to {
                transform: rotate(360deg);
            }
        }

        .ring-dot {
            fill: #34d399;
            animation: spinRing 2s linear infinite;
            transform-origin: center;
        }

        .logo-circle {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(10, 25, 20, 0.9);
            border: 1px solid rgba(16, 185, 129, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 20px rgba(16, 185, 129, 0.1);
            overflow: hidden;
        }

        .logo-circle img {
            width: 60%;
            height: 60%;
            object-fit: contain;
            filter: drop-shadow(0 0 8px rgba(52, 211, 153, 0.4));
        }

        .logo-fallback {
            display: none;
            color: #34d399;
        }

        /* === Badge === */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            color: #6ee7b7;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #34d399;
            animation: blink 1s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 4px #34d399;
            }

            50% {
                opacity: 0.3;
                box-shadow: none;
            }
        }

        /* === Heading === */
        h1 {
            font-size: clamp(1.25rem, 5vw, 1.6rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 0.6rem;
            background: linear-gradient(135deg, #fff 0%, #9ca3af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all 0.6s ease;
        }

        h1.done {
            background: linear-gradient(135deg, #6ee7b7 0%, #34d399 50%, #10b981 100%);
            -webkit-background-clip: text;
            background-clip: text;
        }

        .subtext {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 1.75rem;
        }

        /* === URL Chip === */
        .url-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 10px 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            margin-bottom: 1.75rem;
            min-width: 0;
        }

        .url-chip svg {
            flex-shrink: 0;
            color: rgba(255, 255, 255, 0.3);
        }

        .url-text {
            font-size: 12px;
            font-weight: 500;
            color: #34d399;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            min-width: 0;
        }

        /* === Progress === */
        .progress-wrap {
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 100px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            border-radius: 100px;
            background: linear-gradient(90deg, #059669, #34d399, #6ee7b7);
            animation: fill 2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            position: relative;
        }

        @keyframes fill {
            0% {
                width: 0%;
            }

            60% {
                width: 75%;
            }

            100% {
                width: 100%;
            }
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            right: -20px;
            width: 20px;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            animation: shimmer 1.2s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                right: 110%;
            }

            100% {
                right: -20%;
            }
        }

        .timer {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.25);
            margin-top: 10px;
            font-variant-numeric: tabular-nums;
            letter-spacing: 0.05em;
        }

        /* === Footer === */
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
            color: rgba(255, 255, 255, 0.2);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .footer-divider {
            width: 24px;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        .footer svg {
            color: rgba(52, 211, 153, 0.5);
        }
    </style>
</head>

<body>

    <div class="bg-layer"></div>
    <div class="bg-grid"></div>
    <div class="particles" id="particles"></div>

    <div class="card">

        <!-- Logo ring -->
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
                    onerror="this.style.display='none'; document.getElementById('fallbackIcon').style.display='block'">
                <svg id="fallbackIcon" class="logo-fallback" width="32" height="32" fill="none"
                    stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
        </div>

        <!-- Badge -->
        <div class="badge">
            <div class="badge-dot"></div>
            Tautan Terverifikasi
        </div>

        <!-- Heading -->
        <h1 id="statusText">Memverifikasi Tautan...</h1>
        <p class="subtext" id="subText">Memeriksa keamanan dan mengalihkan halaman</p>

        <!-- URL -->
        <div class="url-chip">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
            </svg>
            <span class="url-text">{{ $link->destination_url }}</span>
        </div>

        <!-- Progress -->
        <div class="progress-wrap">
            <div class="progress-bar"></div>
        </div>

        <p class="timer" id="timerText">Mengalihkan dalam 2 detik...</p>

    </div>

    <!-- Footer -->
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
        /* Particles */
        const pContainer = document.getElementById('particles');
        for (let i = 0; i < 18; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 2 + 1;
            p.style.cssText = `
      left: ${Math.random() * 100}%;
      width: ${size}px; height: ${size}px;
      animation-duration: ${Math.random() * 8 + 6}s;
      animation-delay: ${Math.random() * 8}s;
      opacity: ${Math.random() * 0.5 + 0.2};
    `;
            pContainer.appendChild(p);
        }

        /* Status transitions */
        setTimeout(() => {
            const h = document.getElementById('statusText');
            const s = document.getElementById('subText');
            h.textContent = 'Mengalihkan Halaman...';
            h.classList.add('done');
            s.textContent = 'Membawa Anda ke tujuan...';
        }, 1000);

        /* Countdown */
        let secs = 2;
        const timerEl = document.getElementById('timerText');
        const countdown = setInterval(() => {
            secs = Math.max(0, secs - 1);
            timerEl.textContent = secs > 0 ? `Mengalihkan dalam ${secs} detik...` : 'Mengalihkan...';
            if (secs === 0) clearInterval(countdown);
        }, 1000);

        /* Redirect */
        setTimeout(() => {
            window.location.replace("{!! $link->destination_url !!}");
        }, 2000);
    </script>

</body>

</html>
