<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SELA – Kerja Kelompok Adil, Tanpa Drama.</title>
    <meta name="description" content="SELA membagi tugas dengan cerdas menggunakan AI, memantau kontribusi setiap anggota, dan memastikan kolaborasi mahasiswa berjalan transparan.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Mono+One&family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --cyan: #09637E;
            --cyan-light: #0a7a9e;
            --text-main: #000000;
            --text-muted: #666666;
            --bg-white: #ffffff;
            --bg-light: #f7f9fc;
            --bg-dark: #000000;
            --shadow-neo: 6px 6px 0px #000000;
            --shadow-neo-hover: 12px 12px 0px #000000;
            --shadow-neo-cyan: 6px 6px 0px var(--cyan);
            --transition: 0.2s cubic-bezier(0.19, 1, 0.22, 1);
        }
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text-main);
            background: var(--bg-white);
            line-height: 1.5;
            overflow-x: hidden;
            padding-top: 84px;
        }
        h1, h2, h3 {
            font-family: 'Rubik Mono One', monospace;
            font-weight: 400;
            text-transform: uppercase;
            line-height: 1.1;
        }
        a { text-decoration: none; color: inherit; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 40px; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 14px 28px;
            font-family: 'Rubik Mono One', monospace; font-size: 0.85rem;
            cursor: pointer; border-radius: 14px; border: 3px solid var(--text-main);
            transition: all var(--transition); white-space: nowrap;
        }
        .btn-outline { background: transparent; color: var(--text-main); }
        .btn-outline:hover { background: var(--text-main); color: var(--bg-white); transform: translate(-2px,-2px); box-shadow: var(--shadow-neo); }
        .btn-primary { background: var(--bg-white); color: var(--text-main); box-shadow: var(--shadow-neo); }
        .btn-primary:hover { transform: translate(-3px,-3px); box-shadow: var(--shadow-neo-hover); }
        .btn-dark { background: var(--bg-dark); color: var(--bg-white); box-shadow: 8px 8px 0px var(--cyan); }
        .btn-dark:hover { transform: translate(-4px,-4px); box-shadow: 12px 12px 0px var(--cyan); }
        .btn-cyan { background: var(--cyan); color: var(--bg-white); border-color: var(--cyan); box-shadow: 6px 6px 0px var(--bg-dark); }
        .btn-cyan:hover { transform: translate(-3px,-3px); box-shadow: 10px 10px 0px var(--bg-dark); }

        /* ── NAVBAR ── */
        .navbar-wrap {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: calc(100% - 80px);
            max-width: 1200px;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 2.5px solid var(--text-main);
            border-radius: 100px;
            box-shadow: 6px 6px 0px var(--text-main);
            transition: all 0.3s ease;
        }
        .navbar-wrap.scrolled {
            background: rgba(255,255,255,0.96);
            box-shadow: 8px 8px 0px var(--text-main);
        }
        nav { display: flex; align-items: center; justify-content: space-between; padding: 14px 28px; }
        .logo {
            font-family: 'Rubik Mono One', monospace; font-size: 1.8rem; letter-spacing: -2px;
            background: linear-gradient(135deg, var(--cyan) 0%, #06A3CC 50%, var(--cyan) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-size: 200% auto; animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer { to { background-position: 200% center; } }
        .nav-links { display: flex; gap: 32px; font-weight: 700; font-size: 0.88rem; text-transform: uppercase; }
        .nav-links a { transition: color var(--transition); }
        .nav-links a:hover { color: var(--cyan); }
        .nav-actions { display: flex; gap: 12px; align-items: center; }

        /* ── HERO ── */
        .hero {
            padding: 80px 0 140px; position: relative;
            background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: grid-move 20s linear infinite;
            overflow: hidden;
        }
        @keyframes grid-move { 100% { background-position: 50px 50px; } }
        .hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--bg-dark); color: var(--bg-white);
            font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
            padding: 8px 18px; border-radius: 100px; margin-bottom: 28px;
        }
        .hero-badge span { width: 8px; height: 8px; background: #22c55e; border-radius: 50%; animation: blink 1.4s infinite; }
        @keyframes blink { 0%,100%{opacity:1;} 50%{opacity:0.2;} }
        .hero-content h1 { font-size: 3.2rem; color: var(--text-main); margin-bottom: 24px; line-height: 1.1; }
        .hero-content h1 em { color: var(--cyan); font-style: normal; }
        .hero-content p { font-size: 1.15rem; color: var(--text-muted); margin-bottom: 40px; font-weight: 500; line-height: 1.7; max-width: 480px; }
        .hero-btns { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 36px; }
        .hero-stats { display: flex; gap: 32px; }
        .hero-stat strong { display: block; font-family: 'Rubik Mono One', monospace; font-size: 1.6rem; color: var(--text-main); }
        .hero-stat span { font-size: 0.85rem; color: var(--text-muted); font-weight: 600; }

        /* Phone Mockup */
        .hero-visual { position: relative; height: 580px; display: flex; justify-content: center; align-items: center; perspective: 1200px; }
        .phone-blob { position: absolute; width: 360px; height: 360px; background: var(--cyan); border-radius: 50%; filter: blur(80px); opacity: 0.35; animation: blob-pulse 5s alternate infinite; }
        @keyframes blob-pulse { to { transform: scale(1.25); opacity: 0.55; } }
        .phone-mockup {
            width: 260px; height: 540px; background: #111; border-radius: 42px; border: 10px solid #2a2a2a;
            box-shadow: 24px 24px 64px rgba(9,99,126,0.45);
            position: relative; overflow: hidden; z-index: 10;
            animation: phone-float 7s ease-in-out infinite;
            transform-style: preserve-3d;
        }
        @keyframes phone-float {
            0%,100% { transform: translateY(0) rotateX(5deg) rotateY(-12deg); }
            50% { transform: translateY(-28px) rotateX(9deg) rotateY(-4deg); box-shadow: 24px 56px 80px rgba(9,99,126,0.6); }
        }
        .phone-screen { position: absolute; inset: 0; padding: 20px 14px; display: flex; flex-direction: column; gap: 10px; }
        .phone-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; }
        .phone-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--cyan), #06A3CC); }
        .phone-greeting { flex:1; margin: 0 10px; }
        .ph-line { height: 7px; border-radius: 10px; background: rgba(255,255,255,0.2); }
        .ph-line.w80 { width: 80%; } .ph-line.w50 { width: 50%; margin-top: 4px; } .ph-line.w60 { width: 60%; } .ph-line.w35 { width: 35%; margin-top: 4px; }
        .phone-notif { width: 24px; height: 24px; border-radius: 8px; background: var(--cyan); display: flex; align-items: center; justify-content: center; }
        .phone-card {
            background: rgba(255,255,255,0.08); border: 1.5px solid rgba(255,255,255,0.12);
            border-radius: 16px; padding: 12px; display: flex; flex-direction: column; gap: 6px;
        }
        .phone-card.accent { background: linear-gradient(135deg, rgba(9,99,126,0.4), rgba(6,163,204,0.2)); border-color: rgba(9,99,126,0.6); }
        .phone-task-row { display: flex; align-items: center; gap: 8px; }
        .task-check { width: 16px; height: 16px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.3); flex-shrink: 0; }
        .task-check.done { background: #22c55e; border-color: #22c55e; }
        .progress-bar { height: 6px; background: rgba(255,255,255,0.12); border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 10px; background: linear-gradient(90deg, var(--cyan), #06A3CC); animation: progress-anim 3s ease-in-out infinite alternate; }
        @keyframes progress-anim { from { width: 45%; } to { width: 72%; } }

        .float-badge {
            position: absolute; font-family: 'Rubik Mono One', monospace; font-size: 0.8rem;
            padding: 10px 18px; border: 3px solid var(--text-main); border-radius: 14px;
            background: var(--bg-white); box-shadow: var(--shadow-neo-cyan); z-index: 15;
        }
        .fb1 { top: 8%; right: -12%; animation: fbob 6s ease-in-out infinite; }
        .fb2 { bottom: 16%; left: -16%; animation: fbob 8s ease-in-out infinite reverse; }
        @keyframes fbob { 0%,100%{transform:translateY(0) rotate(-4deg);} 50%{transform:translateY(-18px) rotate(4deg);} }

        /* ── FEATURES ── */
        .features-section {
            padding: 120px 0; background: var(--bg-dark); color: var(--bg-white);
            border-top: 8px solid var(--text-main); border-radius: 60px 60px 0 0; margin-top: -60px; position: relative; z-index: 20;
        }
        .section-label { display: inline-block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: var(--cyan); margin-bottom: 16px; }
        .section-header { text-align: center; margin-bottom: 80px; }
        .section-header h2 { font-size: 3.2rem; margin-bottom: 20px; }
        .section-header p { font-size: 1.1rem; max-width: 680px; margin: 0 auto; line-height: 1.7; }
        .features-section .section-header h2 { color: var(--cyan); }
        .features-section .section-header p { color: #ccc; }

        /* Alternating Feature Rows */
        .feat-rows { display: flex; flex-direction: column; gap: 100px; }
        .feat-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        .feat-row.reverse { direction: rtl; }
        .feat-row.reverse > * { direction: ltr; }
        .feat-tag {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(9,99,126,0.2); border: 1.5px solid var(--cyan);
            color: var(--cyan); font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.5px;
            padding: 6px 14px; border-radius: 100px; margin-bottom: 20px;
        }
        .feat-tag-dot { width: 6px; height: 6px; background: var(--cyan); border-radius: 50%; }
        .feat-num {
            font-family: 'Rubik Mono One', monospace;
            font-size: 5rem; line-height: 1;
            color: transparent; -webkit-text-stroke: 2px #333;
            margin-bottom: 8px; display: block;
        }
        .feat-content h3 {
            font-size: 2.2rem; color: #fff; margin-bottom: 18px; line-height: 1.15;
        }
        .feat-content p {
            font-size: 1.05rem; color: #aaa; line-height: 1.75; margin-bottom: 28px;
        }
        .feat-points { display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px; }
        .feat-point {
            display: flex; align-items: flex-start; gap: 12px;
        }
        .feat-point-dot {
            width: 20px; height: 20px; border-radius: 50%;
            background: linear-gradient(135deg, var(--cyan), #06A3CC);
            flex-shrink: 0; margin-top: 2px;
            display: flex; align-items: center; justify-content: center;
        }
        .feat-point-dot::after { content: ''; width: 6px; height: 6px; background: white; border-radius: 50%; }
        .feat-point span { font-size: 0.95rem; color: #ccc; line-height: 1.6; }

        /* Phone Mockup Placeholder */
        .feat-phone-wrap {
            position: relative;
            display: flex; justify-content: center; align-items: center;
            min-height: 540px;
        }
        .feat-phone-glow {
            position: absolute;
            width: 300px; height: 300px;
            background: var(--cyan); border-radius: 50%;
            filter: blur(80px); opacity: 0.2;
        }
        .feat-phone {
            width: 260px; height: 520px;
            background: #111; border-radius: 40px;
            border: 10px solid #2a2a2a;
            box-shadow: 20px 20px 0px var(--cyan);
            position: relative; z-index: 2;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feat-phone:hover { transform: translate(-4px,-4px); box-shadow: 24px 24px 0px var(--cyan); }
        .feat-phone-inner {
            height: 100%;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 12px;
            padding: 24px 20px;
        }
        .feat-phone-placeholder {
            width: 100%; flex: 1;
            background: #1a1a1a;
            border: 1.5px dashed #333;
            border-radius: 16px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 10px;
        }
        .feat-phone-placeholder-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: rgba(9,99,126,0.2);
            border: 2px solid rgba(9,99,126,0.4);
        }
        .feat-phone-placeholder p {
            font-size: 0.72rem; color: #444; text-align: center;
            font-weight: 600; text-transform: uppercase; letter-spacing: 1px;
            margin: 0;
        }
        /* Built-in UI previews inside phones */
        .feat-preview { width: 100%; padding: 0; display: flex; flex-direction: column; gap: 8px; }
        .checklist-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-bottom: 1px solid #222; border-radius: 10px; background: #1a1a1a; margin-bottom: 4px; }
        .ck-box { width: 18px; height: 18px; border-radius: 6px; border: 2px solid #444; flex-shrink: 0; }
        .ck-box.done { background: var(--cyan); border-color: var(--cyan); }
        .ck-text { height: 8px; border-radius: 8px; background: #333; flex: 1; }
        .ck-text.done { background: #555; }
        .skill-bar-wrap { background: #1a1a1a; border-radius: 10px; padding: 10px 12px; margin-bottom: 4px; }
        .skill-label { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .skill-label span { font-size: 0.7rem; color: #777; font-weight: 600; }
        .skill-bar { height: 8px; background: #2a2a2a; border-radius: 10px; overflow: hidden; }
        .skill-fill { height: 100%; border-radius: 10px; }
        .sf-cyan { background: linear-gradient(90deg, var(--cyan), #06A3CC); }
        .sf-green { background: linear-gradient(90deg, #22c55e, #16a34a); }
        .sf-orange { background: linear-gradient(90deg, #f97316, #ea580c); }
        .analytics-row { display: flex; align-items: center; gap: 10px; padding: 8px 12px; background: #1a1a1a; border-radius: 10px; margin-bottom: 4px; }
        .a-avatar { width: 26px; height: 26px; border-radius: 50%; flex-shrink: 0; }
        .a-bar { flex: 1; height: 8px; border-radius: 10px; overflow: hidden; background: #2a2a2a; }
        .a-pct { font-size: 0.7rem; color: #aaa; font-weight: 700; min-width: 28px; text-align: right; }

        /* ── HOW IT WORKS ── */
        .steps-section { padding: 130px 0; background: var(--bg-white); position: relative; }
        .steps-section .section-header h2 { color: var(--text-main); }
        .steps-section .section-header p { color: var(--text-muted); }
        .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 36px; }
        .step-card {
            border: 4px solid var(--text-main); border-radius: 36px; padding: 48px 28px; text-align: center;
            background: var(--bg-white); box-shadow: var(--shadow-neo-hover); transition: transform 0.3s ease;
            display: flex; flex-direction: column; align-items: center;
        }
        .step-card:hover { transform: translateY(-14px); }
        .step-card:nth-child(1):hover { box-shadow: 12px 24px 0px var(--cyan); }
        .step-card:nth-child(2):hover { box-shadow: 12px 24px 0px var(--bg-dark); }
        .step-card:nth-child(3):hover { box-shadow: 12px 24px 0px var(--cyan-light); }
        .step-num { font-family: 'Rubik Mono One', monospace; font-size: 5rem; color: var(--cyan); text-shadow: 4px 4px 0px var(--text-main); margin-bottom: 18px; }
        .step-icon-wrap { font-size: 2.5rem; margin-bottom: 20px; }
        .step-card h3 { font-size: 1.3rem; color: var(--text-main); margin-bottom: 14px; }
        .step-card p { font-size: 0.97rem; color: var(--text-muted); line-height: 1.65; }

        /* ── FAQ ── */
        .faq-section { padding: 130px 0; background: var(--bg-light); }
        .faq-section .section-header h2 { color: var(--text-main); }
        .faq-section .section-header p { color: var(--text-muted); }
        .faq-list { max-width: 820px; margin: 0 auto; display: flex; flex-direction: column; gap: 16px; }
        .faq-item {
            border: 3px solid var(--text-main); border-radius: 20px; background: var(--bg-white);
            box-shadow: 4px 4px 0px var(--text-main); overflow: hidden; transition: box-shadow var(--transition);
        }
        .faq-item:hover { box-shadow: var(--shadow-neo-cyan); }
        .faq-q {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            padding: 22px 28px; cursor: pointer; background: none; border: none; text-align: left;
            font-family: 'DM Sans', sans-serif; font-size: 1rem; font-weight: 700; color: var(--text-main);
        }
        .faq-q .faq-icon { font-size: 1.4rem; font-weight: 300; color: var(--cyan); transition: transform 0.3s ease; flex-shrink: 0; }
        .faq-item.open .faq-icon { transform: rotate(45deg); }
        .faq-a { max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.3s; }
        .faq-item.open .faq-a { max-height: 300px; }
        .faq-a p { padding: 0 28px 24px; font-size: 0.97rem; color: var(--text-muted); line-height: 1.7; }

        /* ── REVIEWS ── */
        .reviews-section {
            padding: 130px 0; background: var(--bg-dark); color: var(--bg-white);
            border-radius: 60px 60px 0 0; position: relative;
        }
        .reviews-section .section-header h2 { color: var(--cyan); }
        .reviews-section .section-header p { color: #aaa; }
        .reviews-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 28px; }
        .review-card {
            background: #111; border: 3px solid #2a2a2a; border-radius: 28px; padding: 36px;
            transition: all var(--transition); position: relative;
        }
        .review-card:hover { border-color: var(--cyan); transform: translateY(-6px); box-shadow: 0 12px 32px rgba(9,99,126,0.25); }
        .review-stars { color: #fbbf24; font-size: 1.2rem; margin-bottom: 18px; letter-spacing: 2px; }
        .review-text { font-size: 1.05rem; color: #ddd; line-height: 1.75; font-style: italic; margin-bottom: 28px; }
        .review-author { display: flex; align-items: center; gap: 16px; }
        .r-avatar { width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 700; color: white; border: 3px solid #333; flex-shrink: 0; }
        .r-avatar.c1 { background: var(--cyan); }
        .r-avatar.c2 { background: linear-gradient(135deg, var(--cyan), #06A3CC); }
        .r-avatar.c3 { background: #1d4ed8; }
        .r-avatar.c4 { background: #7c3aed; }
        .r-name { font-weight: 700; font-size: 1rem; color: #fff; }
        .r-role { font-size: 0.85rem; color: #777; margin-top: 3px; }
        .review-badge { position: absolute; top: 20px; right: 20px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 5px 12px; border-radius: 100px; }
        .badge-mhs { background: rgba(9,99,126,0.25); color: var(--cyan); }
        .badge-dosen { background: rgba(124,58,237,0.25); color: #a78bfa; }

        /* ── TEAM ── */
        .team-section { padding: 130px 0; background: var(--bg-white); }
        .team-section .section-header h2 { color: var(--text-main); }
        .team-section .section-header p { color: var(--text-muted); }
        .team-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px; }
        .team-grid-row2 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; margin-top: 28px; max-width: calc(75% + 14px); margin-left: auto; margin-right: auto; }
        .team-card {
            border: 4px solid var(--text-main); border-radius: 28px; padding: 36px 24px; text-align: center;
            background: var(--bg-white); box-shadow: var(--shadow-neo); transition: all var(--transition);
        }
        .team-card:hover { transform: translate(-4px,-4px); box-shadow: var(--shadow-neo-hover); }
        .team-card:nth-child(odd):hover { box-shadow: 10px 10px 0px var(--cyan); }
        .team-avatar {
            width: 90px; height: 90px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 2rem; font-family: 'Rubik Mono One', monospace; color: white; margin: 0 auto 20px;
            border: 4px solid var(--text-main); background: linear-gradient(135deg, var(--cyan), #06A3CC);
            box-shadow: 4px 4px 0px var(--text-main);
        }
        .team-avatar.t2 { background: linear-gradient(135deg, #1d4ed8, #3b82f6); }
        .team-avatar.t3 { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
        .team-avatar.t4 { background: linear-gradient(135deg, #059669, #34d399); }
        .team-name { font-family: 'Rubik Mono One', monospace; font-size: 1rem; color: var(--text-main); margin-bottom: 6px; text-transform: uppercase; }
        .team-role { font-size: 0.85rem; font-weight: 700; color: var(--cyan); margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px; }
        .team-sub { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 20px; }
        .team-links { display: flex; justify-content: center; gap: 12px; }
        .team-link {
            width: 38px; height: 38px; border-radius: 10px; border: 2.5px solid var(--text-main);
            display: flex; align-items: center; justify-content: center; font-size: 1rem;
            transition: all var(--transition); background: var(--bg-white); box-shadow: 3px 3px 0 var(--text-main);
        }
        .team-link:hover { background: var(--text-main); color: white; transform: translate(-2px,-2px); box-shadow: 5px 5px 0 var(--cyan); }

        /* ── FOOTER ── */
        .footer-section { background: var(--bg-dark); color: var(--bg-white); padding: 80px 0 0; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; padding-bottom: 60px; border-bottom: 2px solid #222; }
        .footer-brand .logo { font-size: 2.4rem; margin-bottom: 16px; display: block; }
        .footer-brand p { font-size: 0.92rem; color: #888; line-height: 1.7; max-width: 280px; margin-bottom: 24px; }
        .footer-socials { display: flex; gap: 12px; }
        .footer-social-btn {
            width: 40px; height: 40px; border-radius: 10px; border: 2px solid #333;
            display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
            transition: all var(--transition); color: #aaa;
        }
        .footer-social-btn:hover { border-color: var(--cyan); color: var(--cyan); transform: translateY(-3px); }
        .footer-col h4 { font-family: 'DM Sans', sans-serif; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #555; margin-bottom: 20px; }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 12px; }
        .footer-col ul li a { font-size: 0.92rem; color: #888; transition: color var(--transition); font-weight: 500; }
        .footer-col ul li a:hover { color: #fff; }
        .footer-bottom { display: flex; align-items: center; justify-content: space-between; padding: 28px 0; }
        .footer-bottom p { font-size: 0.85rem; color: #555; }
        .footer-bottom a { font-size: 0.85rem; color: #555; transition: color var(--transition); }
        .footer-bottom a:hover { color: #fff; }

        /* ── REVEAL ANIMATION ── */
        .reveal { opacity: 0; transform: translateY(60px); transition: opacity 0.8s ease, transform 0.8s ease; }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .d1 { transition-delay: 0.1s; } .d2 { transition-delay: 0.2s; } .d3 { transition-delay: 0.3s; } .d4 { transition-delay: 0.4s; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1100px) {
            .team-grid { grid-template-columns: repeat(2, 1fr); }
            .team-grid-row2 { grid-template-columns: repeat(2, 1fr); max-width: 100%; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
        }
        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-content p { max-width: 100%; }
            .hero-btns { justify-content: center; }
            .hero-stats { justify-content: center; }
            .hero-visual { height: 420px; }
            .fb1, .fb2 { display: none; }
            .feat-row { grid-template-columns: 1fr; gap: 40px; }
            .feat-row.reverse { direction: ltr; }
            .feat-phone-wrap { min-height: 420px; }
            .steps-grid { grid-template-columns: 1fr; max-width: 480px; margin: 0 auto; }
            .reviews-grid { grid-template-columns: 1fr; }
            .nav-links { display: none; }
        }
        @media (max-width: 768px) {
            .container { padding: 0 20px; }
            .hero-content h1 { font-size: 2.4rem; }
            .section-header h2 { font-size: 2.4rem !important; }
            .features-grid { grid-template-columns: 1fr; }
            .team-grid { grid-template-columns: 1fr 1fr; }
            .team-grid-row2 { grid-template-columns: 1fr 1fr; max-width: 100%; }
            .footer-grid { grid-template-columns: 1fr; gap: 32px; }
            .footer-bottom { flex-direction: column; gap: 16px; text-align: center; }
        }
        @media (max-width: 480px) {
            .navbar-wrap { width: calc(100% - 32px); top: 10px; }
            .team-grid { grid-template-columns: 1fr; }
            .hero-btns { flex-direction: column; width: 100%; max-width: 300px; margin-left: auto; margin-right: auto; }
        }
    </style>
</head>
<body>

    {{-- ══ NAVBAR ══ --}}
    <div class="navbar-wrap">
        <div class="container">
            <nav>
                <a href="#" class="logo">SELA</a>
                <div class="nav-links">
                    <a href="#features">Feature</a>
                    <a href="#how">How it Works</a>
                    <a href="#reviews">Reviews</a>
                    <a href="#faq">FAQ</a>
                    <a href="#team">Bantuan</a>
                </div>
                <div class="nav-actions">
                    <a href="#" class="btn btn-dark">Download App</a>
                </div>
            </nav>
        </div>
    </div>

    {{-- ══ HERO ══ --}}
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-badge reveal"><span></span> Platform Kolaborasi #1 Mahasiswa</div>
                    <h1 class="reveal d1">Kerja Kelompok <em>Adil</em>,<br>Tanpa Drama Free-Rider.</h1>
                    <p class="reveal d2">SELA membagi tugas dengan cerdas menggunakan teknologi AI, memantau kontribusi setiap anggota, dan memastikan kolaborasi mahasiswa berjalan transparan.</p>
                    <div class="hero-btns reveal d2">
                        <a href="#" class="btn btn-cyan">Mulai Gunakan SELA Gratis</a>
                        <a href="#how" class="btn btn-primary">Lihat Cara Kerja</a>
                    </div>
                    <div class="hero-stats reveal d3">
                        <div class="hero-stat"><strong>10K+</strong><span>Mahasiswa Aktif</span></div>
                        <div class="hero-stat"><strong>500+</strong><span>Universitas</span></div>
                        <div class="hero-stat"><strong>4.9★</strong><span>Rating Pengguna</span></div>
                    </div>
                </div>
                <div class="hero-visual reveal d2">
                    <div class="phone-blob"></div>
                    <div class="phone-mockup" id="heroPhone">
                        <div class="phone-screen">
                            <div class="phone-topbar">
                                <div class="phone-avatar"></div>
                                <div class="phone-greeting">
                                    <div class="ph-line w80"></div>
                                    <div class="ph-line w50"></div>
                                </div>
                                <div class="phone-notif"></div>
                            </div>
                            <div class="phone-card accent">
                                <div class="ph-line w60"></div>
                                <div class="ph-line w35"></div>
                                <div class="progress-bar" style="margin-top:8px;"><div class="progress-fill"></div></div>
                            </div>
                            <div class="phone-card">
                                <div class="phone-task-row"><div class="task-check done">✓</div><div class="ph-line w80"></div></div>
                                <div class="phone-task-row"><div class="task-check done">✓</div><div class="ph-line w60"></div></div>
                                <div class="phone-task-row"><div class="task-check"></div><div class="ph-line w80"></div></div>
                                <div class="phone-task-row"><div class="task-check"></div><div class="ph-line w50"></div></div>
                            </div>
                            <div class="phone-card">
                                <div class="ph-line w60"></div>
                                <div class="analytics-row">
                                    <div class="a-avatar" style="background:#09637E;"></div>
                                    <div class="a-bar"><div class="skill-fill sf-cyan" style="height:100%;width:82%;"></div></div>
                                    <div class="a-pct">82%</div>
                                </div>
                                <div class="analytics-row">
                                    <div class="a-avatar" style="background:#1d4ed8;"></div>
                                    <div class="a-bar"><div class="skill-fill sf-green" style="height:100%;width:65%;"></div></div>
                                    <div class="a-pct">65%</div>
                                </div>
                                <div class="analytics-row">
                                    <div class="a-avatar" style="background:#7c3aed;"></div>
                                    <div class="a-bar"><div class="skill-fill sf-orange" style="height:100%;width:40%;"></div></div>
                                    <div class="a-pct">40%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="float-badge fb1" id="float1">AI Task Split</div>
                    <div class="float-badge fb2" id="float2">No Free-Rider!</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ FEATURES ══ --}}
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-header reveal">
                <div class="section-label">Fitur Unggulan</div>
                <h2>Didesain untuk<br>Kolaborasi Nyata.</h2>
                <p>Setiap fitur SELA dirancang untuk menghilangkan ketidakadilan dalam kerja kelompok dan memberdayakan setiap anggota tim.</p>
            </div>

            <div class="feat-rows">

                {{-- FITUR 1: Teks Kiri, Visual Kanan --}}
                <div class="feat-row reveal">
                    <div class="feat-content">
                        <div class="feat-tag"><span class="feat-tag-dot"></span>Fitur 01</div>
                        <span class="feat-num">01</span>
                        <h3>Generate Sub-Tugas Otomatis (AI)</h3>
                        <p>AI SELA memecah tugas besar menjadi langkah-langkah kecil yang actionable secara instan — tidak perlu rapat panjang untuk membagi pekerjaan.</p>
                        <div class="feat-points">
                            <div class="feat-point"><div class="feat-point-dot"></div><span>Input judul tugas, AI langsung buat breakdown sub-tugas</span></div>
                            <div class="feat-point"><div class="feat-point-dot"></div><span>Sub-tugas terstruktur dan dapat langsung didelegasikan</span></div>
                            <div class="feat-point"><div class="feat-point-dot"></div><span>Didukung berbagai jenis proyek akademik</span></div>
                        </div>
                    </div>
                    <div class="feat-phone-wrap">
                        <div class="feat-phone-glow"></div>
                        <div class="feat-phone">
                            <div class="feat-phone-inner">
                                {{-- Preview: Checklist sub-tugas --}}
                                <div style="width:100%;padding:10px 4px;">
                                    <div style="height:7px;background:#333;border-radius:6px;width:60%;margin-bottom:14px;"></div>
                                    <div class="feat-preview">
                                        <div class="checklist-item"><div class="ck-box done"></div><div class="ck-text done" style="width:75%;"></div></div>
                                        <div class="checklist-item"><div class="ck-box done"></div><div class="ck-text done" style="width:60%;"></div></div>
                                        <div class="checklist-item"><div class="ck-box"></div><div class="ck-text" style="width:85%;"></div></div>
                                        <div class="checklist-item"><div class="ck-box"></div><div class="ck-text" style="width:50%;"></div></div>
                                        <div class="checklist-item"><div class="ck-box"></div><div class="ck-text" style="width:70%;"></div></div>
                                    </div>
                                    <div style="margin-top:16px;padding:10px;background:#1a1a1a;border-radius:12px;border:1px dashed #333;text-align:center;">
                                        <div style="font-size:0.65rem;color:#444;text-transform:uppercase;letter-spacing:1px;">Ganti dengan screenshot app</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FITUR 2: Visual Kiri, Teks Kanan --}}
                <div class="feat-row reverse reveal">
                    <div class="feat-content">
                        <div class="feat-tag"><span class="feat-tag-dot"></span>Fitur 02</div>
                        <span class="feat-num">02</span>
                        <h3>Pembagian Tugas Berkeadilan</h3>
                        <p>Algoritma SELA mendistribusikan beban kerja secara proporsional berdasarkan skill dan ketersediaan masing-masing anggota kelompok.</p>
                        <div class="feat-points">
                            <div class="feat-point"><div class="feat-point-dot"></div><span>Profil skill setiap anggota diperhitungkan otomatis</span></div>
                            <div class="feat-point"><div class="feat-point-dot"></div><span>Beban kerja terdistribusi merata & proporsional</span></div>
                            <div class="feat-point"><div class="feat-point-dot"></div><span>Semua anggota dapat melihat pembagian secara transparan</span></div>
                        </div>
                    </div>
                    <div class="feat-phone-wrap">
                        <div class="feat-phone-glow"></div>
                        <div class="feat-phone">
                            <div class="feat-phone-inner">
                                {{-- Preview: Skill bars --}}
                                <div style="width:100%;padding:10px 4px;">
                                    <div style="height:7px;background:#333;border-radius:6px;width:55%;margin-bottom:14px;"></div>
                                    <div class="feat-preview">
                                        <div class="skill-bar-wrap"><div class="skill-label"><span>Rafif — Frontend</span><span>85%</span></div><div class="skill-bar"><div class="skill-fill sf-cyan" style="width:85%;"></div></div></div>
                                        <div class="skill-bar-wrap"><div class="skill-label"><span>Aldi — Backend</span><span>78%</span></div><div class="skill-bar"><div class="skill-fill sf-green" style="width:78%;"></div></div></div>
                                        <div class="skill-bar-wrap"><div class="skill-label"><span>Sari — Mobile</span><span>70%</span></div><div class="skill-bar"><div class="skill-fill sf-orange" style="width:70%;"></div></div></div>
                                        <div class="skill-bar-wrap"><div class="skill-label"><span>Dimas — AI</span><span>92%</span></div><div class="skill-bar"><div class="skill-fill sf-cyan" style="width:92%;"></div></div></div>
                                    </div>
                                    <div style="margin-top:12px;padding:10px;background:#1a1a1a;border-radius:12px;border:1px dashed #333;text-align:center;">
                                        <div style="font-size:0.65rem;color:#444;text-transform:uppercase;letter-spacing:1px;">Ganti dengan screenshot app</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FITUR 3: Teks Kiri, Visual Kanan --}}
                <div class="feat-row reveal">
                    <div class="feat-content">
                        <div class="feat-tag"><span class="feat-tag-dot"></span>Fitur 03</div>
                        <span class="feat-num">03</span>
                        <h3>Dashboard Pemantauan Dosen</h3>
                        <p>Dosen mendapatkan laporan kontribusi real-time setiap anggota kelompok — penilaian objektif berbasis data, bukan asumsi.</p>
                        <div class="feat-points">
                            <div class="feat-point"><div class="feat-point-dot"></div><span>Laporan kontribusi real-time setiap anggota</span></div>
                            <div class="feat-point"><div class="feat-point-dot"></div><span>Grafik progres kemajuan per kelompok</span></div>
                            <div class="feat-point"><div class="feat-point-dot"></div><span>Deteksi otomatis anggota dengan kontribusi rendah</span></div>
                        </div>
                    </div>
                    <div class="feat-phone-wrap">
                        <div class="feat-phone-glow"></div>
                        <div class="feat-phone">
                            <div class="feat-phone-inner">
                                {{-- Preview: Analytics bars --}}
                                <div style="width:100%;padding:10px 4px;">
                                    <div style="height:7px;background:#333;border-radius:6px;width:65%;margin-bottom:14px;"></div>
                                    <div class="feat-preview">
                                        <div class="analytics-row"><div class="a-avatar" style="background:var(--cyan);"></div><div class="a-bar"><div class="skill-fill sf-cyan" style="height:100%;width:90%;"></div></div><div class="a-pct">90%</div></div>
                                        <div class="analytics-row"><div class="a-avatar" style="background:#1d4ed8;"></div><div class="a-bar"><div class="skill-fill sf-green" style="height:100%;width:72%;"></div></div><div class="a-pct">72%</div></div>
                                        <div class="analytics-row"><div class="a-avatar" style="background:#7c3aed;"></div><div class="a-bar"><div class="skill-fill sf-orange" style="height:100%;width:15%;"></div></div><div class="a-pct" style="color:#f97316;">15%</div></div>
                                        <div class="analytics-row"><div class="a-avatar" style="background:#059669;"></div><div class="a-bar"><div class="skill-fill sf-cyan" style="height:100%;width:88%;"></div></div><div class="a-pct">88%</div></div>
                                    </div>
                                    <div style="margin-top:12px;padding:10px;background:#1a1a1a;border-radius:12px;border:1px dashed #333;text-align:center;">
                                        <div style="font-size:0.65rem;color:#444;text-transform:uppercase;letter-spacing:1px;">Ganti dengan screenshot app</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══ HOW IT WORKS ══ --}}
    <section id="how" class="steps-section">
        <div class="container">
            <div class="section-header reveal">
                <div class="section-label" style="color:var(--cyan);">Alur Penggunaan</div>
                <h2>Mulai dalam<br>3 Langkah Mudah.</h2>
                <p>Tanpa konfigurasi rumit. Langsung kolaborasi secara adil dalam hitungan menit.</p>
            </div>
            <div class="steps-grid">
                <div class="step-card reveal d1">
                    <div class="step-num">01</div>
                    <div class="step-icon-wrap"></div>
                    <h3>Registrasi & Pembuatan Grup</h3>
                    <p>Masuk menggunakan akun SSO institusi akademikmu dan buat ruang kolaborasi untuk kelompokmu dalam sekejap.</p>
                </div>
                <div class="step-card reveal d2">
                    <div class="step-num">02</div>
                    <div class="step-icon-wrap"></div>
                    <h3>Otomatisasi Tugas</h3>
                    <p>Sistem AI menyusun rencana kerja secara cerdas dan membagi porsi tugas ke masing-masing anggota berdasarkan skill.</p>
                </div>
                <div class="step-card reveal d3">
                    <div class="step-num">03</div>
                    <div class="step-icon-wrap"></div>
                    <h3>Eksekusi & Pantauan</h3>
                    <p>Setiap anggota fokus mengerjakan tugasnya masing-masing sementara sistem mencatat dan melaporkan progres secara real-time.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ FAQ ══ --}}
    <section id="faq" class="faq-section">
        <div class="container">
            <div class="section-header reveal">
                <div class="section-label" style="color:var(--cyan);">Pertanyaan Umum</div>
                <h2>Ada Pertanyaan?<br>Kami Jawab.</h2>
                <p>Temukan jawaban atas pertanyaan yang paling sering ditanyakan tentang SELA.</p>
            </div>
            <div class="faq-list">
                <div class="faq-item reveal d1">
                    <button class="faq-q" onclick="toggleFaq(this)">
                        <span>Bagaimana SELA memastikan pembagian tugas dalam kelompok benar-benar adil?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-a"><p>SELA menggunakan algoritma berbasis profil skill, riwayat kontribusi, dan ketersediaan waktu setiap anggota untuk mendistribusikan tugas secara proporsional. Setiap pembagian bersifat transparan dan dapat dilihat oleh seluruh anggota kelompok.</p></div>
                </div>
                <div class="faq-item reveal d2">
                    <button class="faq-q" onclick="toggleFaq(this)">
                        <span>Apakah fitur AI dapat memecah semua jenis tugas akademik?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-a"><p>AI SELA dirancang untuk menangani berbagai jenis tugas akademik — mulai dari laporan tertulis, presentasi, proyek pemrograman, hingga penelitian kelompok. Semakin detail deskripsi tugas yang diberikan, semakin presisi hasil pemecahan yang dihasilkan AI.</p></div>
                </div>
                <div class="faq-item reveal d3">
                    <button class="faq-q" onclick="toggleFaq(this)">
                        <span>Bagaimana dosen pembimbing dapat mendeteksi mahasiswa yang tidak berkontribusi (free-rider)?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-a"><p>Dashboard dosen menampilkan laporan kontribusi real-time setiap anggota kelompok, termasuk persentase tugas yang diselesaikan, waktu pengerjaan, dan riwayat aktivitas. Anggota dengan kontribusi rendah secara otomatis ditandai untuk perhatian dosen.</p></div>
                </div>
                <div class="faq-item reveal d1">
                    <button class="faq-q" onclick="toggleFaq(this)">
                        <span>Apakah data akademik dan kredensial login mahasiswa dijamin keamanannya?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-a"><p>Keamanan data adalah prioritas utama kami. Semua data dienkripsi menggunakan standar AES-256, dan autentikasi dilakukan melalui protokol SSO institusi yang aman. Kami tidak pernah menyimpan kata sandi pengguna secara langsung.</p></div>
                </div>
                <div class="faq-item reveal d2">
                    <button class="faq-q" onclick="toggleFaq(this)">
                        <span>Apakah aplikasi SELA hanya tersedia di ponsel pintar?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-a"><p>SELA tersedia di platform mobile (Android & iOS) maupun web browser. Kamu bisa mengakses seluruh fitur SELA dari smartphone, tablet, laptop, maupun desktop sesuai preferensimu.</p></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ REVIEWS ══ --}}
    <section id="reviews" class="reviews-section">
        <div class="container">
            <div class="section-header reveal">
                <div class="section-label">Testimoni Pengguna</div>
                <h2>Dipercaya oleh<br>Mahasiswa & Dosen.</h2>
                <p>Dengarkan langsung pengalaman mereka yang telah merasakan manfaat SELA.</p>
            </div>
            <div class="reviews-grid">
                <div class="review-card reveal d1">
                    <span class="review-badge badge-mhs">Mahasiswa</span>
                    <div class="review-stars">★★★★★</div>
                    <p class="review-text">"Serius, ini game-changer buat tugas kelompok! Sebelumnya selalu ada yang numpang nama, sekarang semua kebagian tugas sesuai kemampuan dan kelihatan ngerjainnya. Drama bebas!"</p>
                    <div class="review-author">
                        <div class="r-avatar c1">A</div>
                        <div><div class="r-name">Anisa Rahmawati</div><div class="r-role">Teknik Informatika, Universitas Brawijaya</div></div>
                    </div>
                </div>
                <div class="review-card reveal d2">
                    <span class="review-badge badge-dosen">Dosen</span>
                    <div class="review-stars">★★★★★</div>
                    <p class="review-text">"Sebagai dosen, penilaian kelompok selalu jadi tantangan. Dengan SELA, saya bisa melihat kontribusi nyata setiap mahasiswa — bukan sekadar laporan akhir yang bisa diklaim siapa saja."</p>
                    <div class="review-author">
                        <div class="r-avatar c4">B</div>
                        <div><div class="r-name">Dr. Budi Santosa, M.Kom</div><div class="r-role">Dosen, Universitas Indonesia</div></div>
                    </div>
                </div>
                <div class="review-card reveal d3">
                    <span class="review-badge badge-mhs">Mahasiswa</span>
                    <div class="review-stars">★★★★★</div>
                    <p class="review-text">"AI-nya bikin gue takjub. Tinggal input judul tugas besar, dalam hitungan detik langsung ada breakdown sub-tugas yang logis dan siap dibagi ke masing-masing anggota. Efisiensi banget!"</p>
                    <div class="review-author">
                        <div class="r-avatar c2">R</div>
                        <div><div class="r-name">Rizky Firmansyah</div><div class="r-role">Sistem Informasi, Institut Teknologi Bandung</div></div>
                    </div>
                </div>
                <div class="review-card reveal d4">
                    <span class="review-badge badge-dosen">Dosen</span>
                    <div class="review-stars">★★★★★</div>
                    <p class="review-text">"Dashboard pemantauan SELA memangkas waktu saya dalam mengevaluasi kelas secara drastis. Grafik progres per kelompok sangat informatif dan membantu saya memberikan feedback yang lebih tepat sasaran."</p>
                    <div class="review-author">
                        <div class="r-avatar c3">S</div>
                        <div><div class="r-name">Prof. Siti Marlinda, Ph.D</div><div class="r-role">Dosen Senior, Universitas Gadjah Mada</div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ TEAM ══ --}}
    <section id="team" class="team-section">
        <div class="container">
            <div class="section-header reveal">
                <div class="section-label" style="color:var(--cyan);">Tim Pengembang</div>
                <h2>Dibangun oleh<br>Tim yang Berdedikasi.</h2>
                <p>Kami adalah tim mahasiswa yang merasakan langsung masalah free-rider dan bertekad membangun solusinya.</p>
            </div>
            {{-- Baris 1: 4 orang --}}
            <div class="team-grid">
                <div class="team-card reveal d1">
                    <div class="team-avatar">R</div>
                    <div class="team-name">Rafif Ahmad</div>
                    <div class="team-role">Frontend Web</div>
                    <div class="team-sub">UI/UX & Web Developer</div>
                    <div class="team-links">
                        <a href="#" class="team-link" title="LinkedIn">LN</a>
                        <a href="#" class="team-link" title="GitHub">GH</a>
                    </div>
                </div>
                <div class="team-card reveal d2">
                    <div class="team-avatar t2">A</div>
                    <div class="team-name">Aldi Pratama</div>
                    <div class="team-role">Backend API</div>
                    <div class="team-sub">Laravel & Node.js</div>
                    <div class="team-links">
                        <a href="#" class="team-link" title="LinkedIn">LN</a>
                        <a href="#" class="team-link" title="GitHub">GH</a>
                    </div>
                </div>
                <div class="team-card reveal d3">
                    <div class="team-avatar t3">S</div>
                    <div class="team-name">Sari Dewi</div>
                    <div class="team-role">Mobile Developer</div>
                    <div class="team-sub">Flutter & Dart</div>
                    <div class="team-links">
                        <a href="#" class="team-link" title="LinkedIn">LN</a>
                        <a href="#" class="team-link" title="GitHub">GH</a>
                    </div>
                </div>
                <div class="team-card reveal d4">
                    <div class="team-avatar t4">D</div>
                    <div class="team-name">Dimas Kurnia</div>
                    <div class="team-role">AI Engineer</div>
                    <div class="team-sub">Python & ML</div>
                    <div class="team-links">
                        <a href="#" class="team-link" title="LinkedIn">LN</a>
                        <a href="#" class="team-link" title="GitHub">GH</a>
                    </div>
                </div>
            </div>
            {{-- Baris 2: 3 orang (centered) --}}
            <div class="team-grid-row2">
                <div class="team-card reveal d1">
                    <div class="team-avatar" style="background:linear-gradient(135deg,#0f766e,#14b8a6);">F</div>
                    <div class="team-name">Fajar Nugroho</div>
                    <div class="team-role">UI/UX Designer</div>
                    <div class="team-sub">Figma & Prototyping</div>
                    <div class="team-links">
                        <a href="#" class="team-link" title="LinkedIn">LN</a>
                        <a href="#" class="team-link" title="GitHub">GH</a>
                    </div>
                </div>
                <div class="team-card reveal d2">
                    <div class="team-avatar" style="background:linear-gradient(135deg,#b45309,#f59e0b);">N</div>
                    <div class="team-name">Nadia Putri</div>
                    <div class="team-role">QA Engineer</div>
                    <div class="team-sub">Testing & Automation</div>
                    <div class="team-links">
                        <a href="#" class="team-link" title="LinkedIn">LN</a>
                        <a href="#" class="team-link" title="GitHub">GH</a>
                    </div>
                </div>
                <div class="team-card reveal d3">
                    <div class="team-avatar" style="background:linear-gradient(135deg,#be185d,#f472b6);">H</div>
                    <div class="team-name">Hendra Wijaya</div>
                    <div class="team-role">DevOps Engineer</div>
                    <div class="team-sub">Docker & CI/CD</div>
                    <div class="team-links">
                        <a href="#" class="team-link" title="LinkedIn">LN</a>
                        <a href="#" class="team-link" title="GitHub">GH</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══ FOOTER ══ --}}
    <footer class="footer-section">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="#" class="logo">SELA</a>
                    <p>Platform kolaborasi akademik berbasis AI yang memastikan setiap mahasiswa berkontribusi secara adil dan dosen dapat memantau kemajuan kelompok secara transparan.</p>
                    <div class="footer-socials">
                        <a href="#" class="footer-social-btn" title="Instagram">IG</a>
                        <a href="#" class="footer-social-btn" title="Twitter/X">X</a>
                        <a href="#" class="footer-social-btn" title="LinkedIn">LN</a>
                        <a href="#" class="footer-social-btn" title="YouTube">YT</a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="#features">Detail Fitur</a></li>
                        <li><a href="#how">Cara Kerja</a></li>
                        <li><a href="#reviews">Testimoni</a></li>
                        <li><a href="#team">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Dukungan</h4>
                    <ul>
                        <li><a href="#faq">FAQ</a></li>
                        <li><a href="#">Pusat Bantuan</a></li>
                        <li><a href="#">Kontak Kami</a></li>
                        <li><a href="#">Status Sistem</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Legalitas</h4>
                    <ul>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Lisensi</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2026 Tim SELA. All rights reserved.</p>
                <div style="display:flex;gap:24px;">
                    <a href="#">Terms of Service</a>
                    <a href="#">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // ── Reveal on Scroll ──
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('active'); revealObserver.unobserve(e.target); } });
        }, { threshold: 0.12 });
        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        // ── Parallax Phone + Floating Badges ──
        const phone = document.getElementById('heroPhone');
        const f1 = document.getElementById('float1');
        const f2 = document.getElementById('float2');
        document.addEventListener('mousemove', (e) => {
            if (window.innerWidth > 992) {
                const x = (window.innerWidth / 2 - e.pageX) / 35;
                const y = (window.innerHeight / 2 - e.pageY) / 35;
                phone.style.transform = `translateY(${-y}px) rotateX(${8 + y/2}deg) rotateY(${-12 + x/2}deg)`;
                f1.style.transform = `translate(${x * 1.6}px, ${y * 1.6}px) rotate(-4deg)`;
                f2.style.transform = `translate(${-x * 2}px, ${-y * 2}px) rotate(4deg)`;
            }
        });

        // ── FAQ Toggle ──
        function toggleFaq(btn) {
            const item = btn.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        }

        // ── Navbar Scroll ──
        const navWrap = document.querySelector('.navbar-wrap');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navWrap.classList.add('scrolled');
            } else {
                navWrap.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
