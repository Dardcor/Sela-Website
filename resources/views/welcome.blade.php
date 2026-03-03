<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SELA - Crush College Chaos.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Mono+One&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cyan: #09637E;
            --blue: #09637E;
            --text-main: #000000;
            --text-muted: #666666;
            --bg-white: #ffffff;
            --bg-dark: #000000;
            --shadow-neo: 6px 6px 0px #000000;
            --shadow-neo-hover: 12px 12px 0px #000000;
            --shadow-neo-cyan: 6px 6px 0px var(--cyan);
            --transition-glitch: 0.2s cubic-bezier(0.19, 1, 0.22, 1);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-white);
            line-height: 1.4;
            overflow-x: hidden;
        }
        h1, h2, h3 {
            font-family: 'Rubik Mono One', monospace;
            font-weight: 400;
            text-transform: uppercase;
            line-height: 1;
        }
        a { text-decoration: none; color: inherit; }
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 40px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 32px;
            font-family: 'Rubik Mono One', monospace;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 3px solid var(--text-main);
            border-radius: 16px;
        }
        .btn-primary {
            background-color: var(--bg-white);
            color: var(--text-main);
            box-shadow: var(--shadow-neo);
        }
        .btn-primary:hover {
            transform: translate(-3px, -3px);
            box-shadow: var(--shadow-neo-hover);
        }
        .btn-dark {
            background-color: var(--bg-dark);
            color: var(--bg-white);
            box-shadow: 8px 8px 0px var(--cyan);
        }
        .btn-dark:hover {
            transform: translate(-4px, -4px);
            box-shadow: 12px 12px 0px var(--cyan);
        }
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 30px 0;
            position: relative;
            z-index: 1000;
        }
        .logo {
            font-family: 'Rubik Mono One', monospace;
            font-size: 2rem;
            letter-spacing: -2px;
            background: linear-gradient(135deg, var(--cyan), var(--blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: logo-shimmer 2s linear infinite;
            background-size: 200% auto;
        }
        @keyframes logo-shimmer {
            to { background-position: 200% center; }
        }
        .nav-links {
            display: flex;
            gap: 40px;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        .nav-links a:hover {
            color: var(--cyan);
        }
        .hero {
            padding: 60px 0 120px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            z-index: 10;
            background-size: 50px 50px;
            background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px);
            animation: grid-move 20s linear infinite;
        }
        @keyframes grid-move {
            0% { background-position: 0 0; }
            100% { background-position: 50px 50px; }
        }
        .hero-marquee-wrapper {
            width: 105vw;
            overflow: hidden;
            background: var(--text-main);
            padding: 20px 0;
            transform: rotate(-3deg);
            margin-bottom: 80px;
            box-shadow: 0 20px 0 var(--cyan);
            display: flex;
            position: relative;
            left: -2vw;
        }
        .hero-marquee {
            display: flex;
            white-space: nowrap;
            animation: marquee-scroll 15s linear infinite;
        }
        .hero-marquee h1 {
            font-size: 5rem;
            color: var(--bg-white);
            margin-right: 40px;
            -webkit-text-stroke: 2px var(--text-main);
        }
        .hero-marquee h1 span.outline {
            color: transparent;
            -webkit-text-stroke: 2px var(--cyan);
        }
        .hero-marquee h1 span.blue {
            color: var(--blue);
        }
        @keyframes marquee-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .hero-grid-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            text-align: left;
            position: relative;
        }
        .hero-content {
            position: relative;
            z-index: 10;
            background: var(--bg-white);
            padding: 50px;
            border: 4px solid var(--text-main);
            border-radius: 32px;
            box-shadow: var(--shadow-neo-hover);
            animation: float-subtle 6s ease-in-out infinite;
        }
        @keyframes float-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .hero-content h2 {
            font-size: 2.8rem;
            color: var(--text-main);
            margin-bottom: 24px;
            line-height: 1.15;
        }
        .hero-content p {
            font-size: 1.2rem;
            color: var(--text-muted);
            margin-bottom: 40px;
            font-weight: 500;
            line-height: 1.6;
        }
        .hero-btns {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .hero-visual-container {
            position: relative;
            height: 600px;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1000px;
        }
        .hero-visual-scr {
            width: 280px;
            height: 580px;
            background: #111;
            border-radius: 40px;
            border: 12px solid #222;
            box-shadow: 20px 20px 60px rgba(9, 99, 126, 0.4);
            position: absolute;
            overflow: hidden;
            transform-style: preserve-3d;
            animation: phone-levitate 8s ease-in-out infinite;
            z-index: 10;
        }
        @keyframes phone-levitate {
            0%, 100% { transform: translateY(0) rotateX(5deg) rotateY(-15deg); }
            50% { transform: translateY(-30px) rotateX(10deg) rotateY(-5deg); box-shadow: 20px 50px 80px rgba(9, 99, 126, 0.5); }
        }
        .scr-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            border: 2px solid rgba(255,255,255,0.1);
            display: flex; flex-direction: column; gap: 8px; padding: 15px;
        }
        .scr-element:nth-child(1) { width: 85%; height: 25%; top: 8%; left: 7.5%; background: linear-gradient(135deg, rgba(9, 99, 126, 0.2), rgba(9, 99, 126, 0.2)); border-color: rgba(9, 99, 126, 0.5); }
        .scr-element:nth-child(2) { width: 85%; height: 18%; top: 36%; left: 7.5%; }
        .scr-element:nth-child(3) { width: 85%; height: 18%; top: 57%; left: 7.5%; }
        .scr-element:nth-child(4) { width: 85%; height: 18%; top: 78%; left: 7.5%; }
        .scr-line { height: 6px; background: rgba(255,255,255,0.2); border-radius: 10px; }
        .scr-line.l { width: 80%; }
        .scr-line.s { width: 40%; }
        .scr-title { height: 12px; background: #fff; width: 60%; margin-bottom: 12px; border-radius: 10px; }
        .hero-element-floating {
            position: absolute;
            font-family: 'Rubik Mono One', monospace;
            font-size: 1rem;
            color: var(--text-main);
            padding: 14px 24px;
            border: 3px solid var(--text-main);
            background: var(--bg-white);
            box-shadow: var(--shadow-neo-cyan);
            border-radius: 20px;
            z-index: 15;
        }
        .hero-float-1 { top: 10%; right: -10%; animation: element-spin 6s ease-in-out infinite; }
        .hero-float-2 { bottom: 20%; left: -20%; animation: element-spin 8s ease-in-out infinite reverse; }
        @keyframes element-spin {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        .glow-blob {
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--cyan);
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            z-index: 1;
            animation: blob-pulse 4s infinite alternate;
        }
        @keyframes blob-pulse {
            0% { transform: scale(1); opacity: 0.4; }
            100% { transform: scale(1.2); opacity: 0.7; }
        }
        .features-section {
            padding: 120px 0;
            position: relative;
            background: var(--bg-dark);
            color: var(--bg-white);
            z-index: 20;
            border-top: 8px solid var(--text-main);
            border-radius: 60px 60px 0 0;
            margin-top: -60px;
        }
        .features-section .section-header {
            text-align: center;
            margin-bottom: 80px;
        }
        .features-section .section-header h2 {
            font-size: 3.5rem;
            color: var(--cyan);
            margin-bottom: 24px;
        }
        .features-section .section-header p {
            color: #ccc;
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            font-weight: 500;
        }
        .features-glitch-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
        }
        .feature-glitch-card {
            background: #111;
            border: 3px solid #333;
            padding: 40px 30px;
            border-radius: 32px;
            transition: all var(--transition-glitch);
            position: relative;
            cursor: crosshair;
        }
        .feature-glitch-card:hover {
            border-color: var(--cyan);
            background: #1a1a1a;
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(9, 99, 126, 0.2);
        }
        .feature-glitch-card:nth-child(2n):hover {
            border-color: var(--blue);
            box-shadow: 0 15px 30px rgba(9, 99, 126, 0.2);
        }
        .feature-glitch-icon {
            font-size: 2.8rem;
            margin-bottom: 20px;
            display: inline-block;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .feature-glitch-card:hover .feature-glitch-icon {
            transform: scale(1.2) rotate(-10deg);
        }
        .feature-glitch-card h3 {
            font-size: 1.4rem;
            margin-bottom: 16px;
            color: #fff;
            line-height: 1.3;
        }
        .feature-glitch-card p {
            font-size: 1rem;
            color: #aaa;
            line-height: 1.6;
        }
        .steps-section {
            padding: 150px 0;
            position: relative;
            background: var(--bg-white);
        }
        .steps-section .section-header { text-align: center; margin-bottom: 100px; }
        .steps-section .section-header h2 { font-size: 3.5rem; color: var(--text-main); margin-bottom: 20px; }
        .steps-section .section-header p { color: var(--text-muted); font-size: 1.15rem; max-width: 600px; margin: 0 auto; }
        .steps-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            align-items: stretch;
        }
        .step-content {
            position: relative;
            padding: 50px 30px;
            border: 4px solid var(--text-main);
            background: var(--bg-white);
            border-radius: 40px;
            box-shadow: var(--shadow-neo-hover);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .step-content:hover {
            transform: translateY(-15px);
        }
        .step-content:nth-child(1):hover { box-shadow: 12px 25px 0px var(--cyan); }
        .step-content:nth-child(2):hover { box-shadow: 12px 25px 0px var(--blue); }
        .step-content:nth-child(3):hover { box-shadow: 12px 25px 0px var(--text-main); }
        .step-number-huge {
            font-family: 'Rubik Mono One', monospace;
            font-size: 5rem;
            color: var(--cyan);
            margin-bottom: 20px;
            text-shadow: 4px 4px 0px var(--text-main);
        }
        .step-content h3 { font-size: 1.4rem; margin-bottom: 15px; color: var(--text-main); }
        .step-content p { font-size: 1rem; color: var(--text-muted); line-height: 1.6; }
        .reviews-section {
            padding: 150px 0;
            position: relative;
            background: var(--text-main);
            color: var(--bg-white);
            border-radius: 60px 60px 0 0;
        }
        .reviews-section .section-header { text-align: center; margin-bottom: 80px; }
        .reviews-section .section-header h2 { font-size: 3.5rem; color: var(--cyan); margin-bottom: 20px; }
        .reviews-stack {
            position: relative;
            height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 1200px;
        }
        .review-card-neo {
            position: absolute;
            width: 600px;
            background: var(--bg-white);
            padding: 50px;
            border: 4px solid var(--text-main);
            border-radius: 40px;
            box-shadow: 20px 20px 0px rgba(9, 99, 126, 1);
            transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            backface-visibility: hidden;
            color: var(--text-main);
        }
        .review-card-neo.front { transform: translateZ(0px) translateY(0) rotateX(0); z-index: 10; opacity: 1; }
        .review-card-neo.back { transform: translateZ(-150px) translateY(-40px) rotateX(5deg) scale(0.95); z-index: 5; opacity: 0.8; box-shadow: 20px 20px 0px rgba(9, 99, 126, 1); }
        .review-card-neo.hidden { transform: translateZ(-300px) translateY(-80px) rotateX(10deg) scale(0.9); z-index: 1; opacity: 0; }
        .review-card-neo .stars { color: #fbbf24; margin-bottom: 20px; font-size: 1.4rem; }
        .review-card-neo .review-text { font-size: 1.2rem; margin-bottom: 30px; font-style: italic; line-height: 1.6; font-weight: 500; }
        .review-card-neo .reviewer-info { display: flex; align-items: center; gap: 20px; }
        .review-card-neo .reviewer-avatar { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.5rem; border: 4px solid var(--text-main); }
        .review-card-neo .reviewer-avatar.cyan { background: var(--cyan); }
        .review-card-neo .reviewer-avatar.blue { background: var(--blue); }
        .review-card-neo .reviewer-avatar.mixed { background: linear-gradient(135deg, var(--cyan), var(--blue)); }
        .review-card-neo .reviewer-name { font-weight: 700; font-size: 1.1rem; color: var(--text-main); }
        .review-card-neo .reviewer-major { font-size: 0.9rem; color: var(--text-muted); }
        .cta-footer {
            padding: 120px 0 60px;
            background: var(--bg-dark);
            color: var(--bg-white);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-glitch-headline {
            font-size: 5rem;
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 4px 4px 0px var(--cyan), -4px -4px 0px var(--blue);
            animation: float-subtle 4s ease-in-out infinite alternate;
        }
        .cta-footer p { font-size: 1.2rem; color: #ccc; max-width: 600px; margin: 0 auto 50px; line-height: 1.6; }
        .cta-btns {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 100px;
        }
        .footer-bottom-neo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 2px solid #333;
            padding-top: 40px;
        }
        .footer-logo { font-size: 2rem; color: #fff; }
        .footer-links { display: flex; gap: 30px; }
        .footer-links a { font-weight: 700; color: #aaa; text-transform: uppercase; font-size: 0.9rem; }
        .footer-links a:hover { color: var(--cyan); }
        .copyright { color: #666; font-size: 0.9rem; }
        .reveal {
            opacity: 0;
            transform: translateY(80px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        @media (max-width: 992px) {
            .hero-marquee h1 { font-size: 4rem; }
            .hero-grid-layout { grid-template-columns: 1fr; text-align: center; gap: 40px; }
            .hero-content { padding: 40px 20px; }
            .hero-btns { justify-content: center; }
            .hero-visual-container { height: 500px; }
            .hero-float-1, .hero-float-2 { display: none; }
            .features-glitch-grid { grid-template-columns: 1fr 1fr; }
            .steps-container { grid-template-columns: 1fr; max-width: 500px; margin: 0 auto; }
            .review-card-neo { width: 90%; padding: 30px; }
            .cta-glitch-headline { font-size: 3.5rem; }
            .nav-links { display: none; }
        }
        @media (max-width: 768px) {
            .hero-marquee h1 { font-size: 3rem; }
            .hero-content h2 { font-size: 2.2rem; }
            .hero-btns, .cta-btns { flex-direction: column; width: 100%; max-width: 300px; margin-left: auto; margin-right: auto; }
            .features-glitch-grid { grid-template-columns: 1fr; }
            .features-section .section-header h2, .steps-section .section-header h2, .reviews-section .section-header h2 { font-size: 2.5rem; }
            .footer-bottom-neo { flex-direction: column; gap: 20px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav>
            <div class="logo">SELA</div>
            <div class="nav-links">
                <a href="#features">Features</a>
                <a href="#how">How it works</a>
                <a href="#reviews">Reviews</a>
            </div>
            <button class="btn btn-primary">Unduh Gratis</button>
        </nav>
    </div>
    <header class="hero">
        <div class="hero-marquee-wrapper">
            <div class="hero-marquee">
                <h1>CRUSH <span class="outline">COLLEGE</span> CHAOS <span class="blue">✦</span> STRESS <span class="outline">LESS</span> <span class="blue">✦</span> SCORE <span class="outline">HIGHER</span> <span class="blue">✦</span> </h1>
                <h1>CRUSH <span class="outline">COLLEGE</span> CHAOS <span class="blue">✦</span> STRESS <span class="outline">LESS</span> <span class="blue">✦</span> SCORE <span class="outline">HIGHER</span> <span class="blue">✦</span> </h1>
            </div>
        </div>
        <div class="container hero-grid-layout">
            <div class="glow-blob" style="top: 10%; left: -10%;"></div>
            <div class="hero-content reveal">
                <h2>Belajar Cerdas,<br>Tanpa Batas.</h2>
                <p>SELA bukan sekadar aplikasi tugas. Ia adalah mesin produktivitas pribadimu yang siap membantu menaklukkan setiap semester dengan percaya diri.</p>
                <div class="hero-btns">
                    <button class="btn btn-primary">App Store</button>
                    <button class="btn btn-dark">Google Play</button>
                </div>
                <p style="font-size: 0.9rem; color: var(--text-muted); font-weight: 700; margin-bottom: 0;">Didukung oleh Mahasiswa di MIT, UI, ITB, &amp; Lainnya.</p>
            </div>
            <div class="hero-visual-container reveal delay-1">
                <div class="hero-visual-scr" id="heroPhone">
                    <div class="scr-element"> <div class="scr-title"></div> <div class="scr-line l"></div> <div class="scr-line s"></div> </div>
                    <div class="scr-element"> <div class="scr-line l"></div> </div>
                    <div class="scr-element"> <div class="scr-line l"></div> </div>
                    <div class="scr-element"> <div class="scr-line l"></div> <div class="scr-line s"></div> </div>
                </div>
                <div class="hero-element-floating hero-float-1" id="float1">✦ SELA + KAMPUS</div>
                <div class="hero-element-floating hero-float-2" id="float2">Target A+ 🎯</div>
            </div>
        </div>
    </header>
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-header reveal">
                <h2>Didesain Berbeda.</h2>
                <p>Lupakan manajemen tugas yang membosankan. SELA menggunakan antarmuka interaktif untuk merapikan kekacauan akademismu.</p>
            </div>
            <div class="features-glitch-grid">
                <div class="feature-glitch-card reveal delay-1">
                    <div class="feature-glitch-icon">🔄</div>
                    <h3>Sync Tanpa Celah</h3>
                    <p>Semua tugas dan tenggat waktu tersinkronisasi instan di semua perangkatmu.</p>
                </div>
                <div class="feature-glitch-card reveal delay-2">
                    <div class="feature-glitch-icon">🤝</div>
                    <h3>Kolaborasi Adil</h3>
                    <p>Bagi tugas, pantau kontribusi, pastikan proyek kelompok berjalan lancar.</p>
                </div>
                <div class="feature-glitch-card reveal delay-3">
                    <div class="feature-glitch-icon">🎯</div>
                    <h3>Prioritas Cerdas</h3>
                    <p>SELA menonjolkan apa yang paling penting untuk diselesaikan hari ini.</p>
                </div>
                <div class="feature-glitch-card reveal delay-1">
                    <div class="feature-glitch-icon">📊</div>
                    <h3>Pantau Progres</h3>
                    <p>Dasbor visual menampilkan kemajuan mingguan dan streak belajarmu.</p>
                </div>
                <div class="feature-glitch-card reveal delay-2">
                    <div class="feature-glitch-icon">🔔</div>
                    <h3>Notifikasi Tepat</h3>
                    <p>Beradaptasi dengan jadwal kelasmu untuk memberi pengingat yang pas.</p>
                </div>
                <div class="feature-glitch-card reveal delay-3">
                    <div class="feature-glitch-icon">🏫</div>
                    <h3>Integrasi LMS</h3>
                    <p>Hubungkan langsung dengan Canvas atau Moodle kampusmu.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="how" class="steps-section">
        <div class="container">
            <div class="section-header reveal">
                <h2>Siap Seketika.</h2>
                <p>Tanpa panduan rumit. Mulai atur jadwalmu dalam hitungan menit.</p>
            </div>
            <div class="steps-container">
                <div class="step-content reveal delay-1">
                    <div class="step-number-huge">1</div>
                    <h3>Buat Akun</h3>
                    <p>Daftar dengan email kampus. SELA mengatur profil sesuai fakultasmu.</p>
                </div>
                <div class="step-content reveal delay-2">
                    <div class="step-number-huge">2</div>
                    <h3>Impor Matkul</h3>
                    <p>Tarik data dari sistem kampus, biarkan SELA menyusun timeline tugasmu.</p>
                </div>
                <div class="step-content reveal delay-3">
                    <div class="step-number-huge">3</div>
                    <h3>Hancurkan Tugas</h3>
                    <p>Fokus pada prioritas harian, kolaborasi, dan capai nilai tertinggi.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="reviews" class="reviews-section">
        <div class="container">
            <div class="section-header reveal">
                <h2>Suara Mahasiswa.</h2>
            </div>
            <div class="reviews-stack reveal delay-2" id="reviewsStack">
                <div class="review-card-neo front">
                    <div class="stars">★★★★★</div>
                    <p class="review-text">"SELA benar-benar mengubah cara aku mengelola minggu ujian. Dulu aku merasa kewalahan, sekarang aku punya rencana belajar yang jelas setiap harinya."</p>
                    <div class="reviewer-info">
                        <div class="reviewer-avatar cyan">A</div>
                        <div>
                            <div class="reviewer-name">Annie M.</div>
                            <div class="reviewer-major">Informatika, ITB</div>
                        </div>
                    </div>
                </div>
                <div class="review-card-neo back">
                    <div class="stars">★★★★★</div>
                    <p class="review-text">"Fitur kolaborasi tugas kelompoknya penyelamat banget! Semua orang bisa lihat progres masing-masing dan nggak ada lagi drama tugas telat."</p>
                    <div class="reviewer-info">
                        <div class="reviewer-avatar blue">T</div>
                        <div>
                            <div class="reviewer-name">Talia R.</div>
                            <div class="reviewer-major">Manajemen, UI</div>
                        </div>
                    </div>
                </div>
                <div class="review-card-neo hidden">
                    <div class="stars">★★★★★</div>
                    <p class="review-text">"Aku jarang banget ketinggalan tugas lagi semenjak pake SELA. Cerdas banget fiturnya, pengingatnya juga pas. Aplikasinya juara."</p>
                    <div class="reviewer-info">
                        <div class="reviewer-avatar mixed">S</div>
                        <div>
                            <div class="reviewer-name">Sam T.</div>
                            <div class="reviewer-major">Kedokteran, UGM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="cta-footer">
        <div class="container reveal">
            <h2 class="cta-glitch-headline">MULAI SEKARANG</h2>
            <p>Bergabunglah dengan 120.000+ mahasiswa yang telah mengambil kendali atas kehidupan akademis mereka. Gratis selamanya.</p>
            <div class="cta-btns">
                <button class="btn btn-primary">Unduh Bebas</button>
                <button class="btn btn-dark">App Store & Play Store</button>
            </div>
            <div class="footer-bottom-neo">
                <div class="logo footer-logo">SELA</div>
                <div class="footer-links">
                    <a href="#">Privasi</a>
                    <a href="#">Syarat</a>
                    <a href="#">Blog</a>
                </div>
                <div class="copyright">© 2026 SELA Inc.</div>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('.reveal');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            reveals.forEach(reveal => revealObserver.observe(reveal));

            const phone = document.getElementById('heroPhone');
            const float1 = document.getElementById('float1');
            const float2 = document.getElementById('float2');

            document.addEventListener('mousemove', (e) => {
                if(window.innerWidth > 992) {
                    const x = (window.innerWidth / 2 - e.pageX) / 30;
                    const y = (window.innerHeight / 2 - e.pageY) / 30;
                    phone.style.transform = `translateY(${-y}px) rotateX(${10 + y/2}deg) rotateY(${-15 + x/2}deg)`;
                    float1.style.transform = `translate(${x * 1.5}px, ${y * 1.5}px)`;
                    float2.style.transform = `translate(${-x * 2}px, ${-y * 2}px)`;
                }
            });

            const stackCards = document.querySelectorAll('.review-card-neo');
            setInterval(() => {
                let frontIndex = Array.from(stackCards).findIndex(card => card.classList.contains('front'));
                let backIndex = Array.from(stackCards).findIndex(card => card.classList.contains('back'));
                let hiddenIndex = Array.from(stackCards).findIndex(card => card.classList.contains('hidden'));

                stackCards[frontIndex].className = 'review-card-neo hidden';
                stackCards[backIndex].className = 'review-card-neo front';
                stackCards[hiddenIndex].className = 'review-card-neo back';
            }, 4000);
        });
    </script>
</body>
</html>
