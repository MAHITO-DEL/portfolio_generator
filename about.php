<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About PortfolioGen — Our story, team, mission, and the technology behind the platform.">
    <title>About — PortfolioGen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">

    <style>
        :root {
            --bg-dark:      #080a0f;
            --bg-card:      #0d1018;
            --accent-red:   #c0392b;
            --accent-red2:  #e74c3c;
            --accent-blue:  #1a6fa8;
            --accent-blue2: #2980b9;
            --text-main:    #f0ece4;
            --text-muted:   #7a8090;
            --border:       rgba(255,255,255,0.07);
            --gold:         #c9a84c;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg-dark);
            color: var(--text-main);
            font-family: 'DM Sans', sans-serif;
            font-weight: 300;
            overflow-x: hidden;
        }

        /* ── NOISE OVERLAY ── */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: .4;
        }

        /* ════════════════════════════
           HEADER
        ════════════════════════════ */
        .site-header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 20px 3rem;
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(8,10,15,0.85);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            transition: padding .3s;
        }
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem; font-weight: 700;
            color: var(--text-main); text-decoration: none;
            letter-spacing: 0.02em;
        }
        .logo span { color: var(--accent-red2); }
        .main-nav { display: flex; gap: 2rem; }
        .nav-link {
            color: var(--text-muted); text-decoration: none;
            font-size: .9rem; font-weight: 400; letter-spacing: .04em;
            text-transform: uppercase;
            transition: color .25s;
        }
        .nav-link:hover, .nav-link.active { color: var(--text-main); }
        .auth-buttons { display: flex; gap: 12px; align-items: center; }
        .btn-signin {
            background: transparent; border: 1px solid var(--border);
            color: var(--text-muted); padding: 8px 20px; border-radius: 6px;
            font-family: inherit; cursor: pointer; font-size: .85rem;
            transition: all .25s;
        }
        .btn-signin:hover { color: var(--text-main); border-color: rgba(255,255,255,.2); }
        .btn-login {
            background: var(--accent-red); border: none;
            color: #fff; padding: 8px 20px; border-radius: 6px;
            font-family: inherit; cursor: pointer; font-size: .85rem;
            transition: background .25s;
        }
        .btn-login:hover { background: var(--accent-red2); }

        /* dropdown (copied from templates.php pattern) */
        .user-avatar-btn {
            width: 38px; height: 38px; border-radius: 50%;
            background: var(--accent-red); border: none; color: #fff;
            font-weight: 700; font-size: .95rem; cursor: pointer;
        }

        /* ════════════════════════════
           HERO — CINEMATIC IMAGE
        ════════════════════════════ */
        .about-hero {
            position: relative;
            height: 100vh; min-height: 620px;
            display: flex; align-items: flex-end;
            overflow: hidden;
            cursor: pointer;
        }

        .hero-img-wrap {
            position: absolute; inset: 0;
        }
        .hero-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center 20%;
            filter: brightness(.55) saturate(1.15);
            transform: scale(1.04);
            transition: transform 8s ease, filter 1s ease;
        }
        .about-hero:hover .hero-img-wrap img {
            transform: scale(1);
            filter: brightness(.65) saturate(1.25);
        }

        /* cinematic letterbox bars */
        .hero-img-wrap::before,
        .hero-img-wrap::after {
            content: ''; position: absolute; left: 0; right: 0; z-index: 1;
            background: var(--bg-dark); height: 60px;
        }
        .hero-img-wrap::before { top: 0; }
        .hero-img-wrap::after  { bottom: 0; }

        /* gradient vignette */
        .hero-vignette {
            position: absolute; inset: 0; z-index: 2;
            background:
                linear-gradient(to top,  rgba(8,10,15,1)   0%,  rgba(8,10,15,.3) 45%, transparent 70%),
                linear-gradient(to right, rgba(8,10,15,.5) 0%,  transparent 60%),
                radial-gradient(ellipse at 70% 40%, rgba(192,57,43,.12) 0%, transparent 55%),
                radial-gradient(ellipse at 30% 60%, rgba(26,111,168,.10) 0%, transparent 50%);
        }

        /* scan lines overlay */
        .hero-scanlines {
            position: absolute; inset: 0; z-index: 3;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 3px,
                rgba(0,0,0,.04) 3px,
                rgba(0,0,0,.04) 4px
            );
            pointer-events: none;
        }

        .hero-content {
            position: relative; z-index: 4;
            padding: 0 5vw 7vh;
            max-width: 820px;
        }

        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 10px;
            color: var(--accent-red2); font-size: .75rem; font-weight: 500;
            letter-spacing: .2em; text-transform: uppercase;
            margin-bottom: 1.2rem;
            opacity: 0; transform: translateY(20px);
            animation: fadeUp .8s .3s forwards;
        }
        .hero-eyebrow::before {
            content: '';
            display: block; width: 32px; height: 1px;
            background: var(--accent-red2);
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.2rem, 7vw, 6.5rem);
            font-weight: 900; line-height: .92;
            margin-bottom: 1.6rem;
            opacity: 0; transform: translateY(28px);
            animation: fadeUp .9s .5s forwards;
        }
        .hero-title em {
            font-style: italic;
            background: linear-gradient(100deg, var(--accent-red2), var(--accent-blue2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: 1.05rem; color: rgba(240,236,228,.65);
            line-height: 1.7; max-width: 480px;
            margin-bottom: 2.4rem;
            opacity: 0; transform: translateY(20px);
            animation: fadeUp .8s .7s forwards;
        }

        .hero-cta {
            display: inline-flex; align-items: center; gap: 10px;
            background: transparent;
            border: 1px solid rgba(255,255,255,.25);
            color: var(--text-main); padding: 13px 28px; border-radius: 50px;
            font-family: inherit; font-size: .9rem; font-weight: 500;
            letter-spacing: .06em; text-transform: uppercase;
            cursor: pointer; text-decoration: none;
            transition: all .3s;
            opacity: 0; transform: translateY(20px);
            animation: fadeUp .8s .9s forwards;
        }
        .hero-cta:hover {
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.4);
            color: var(--text-main);
            gap: 16px;
        }
        .hero-cta-arrow { font-size: 1.1rem; transition: transform .3s; }
        .hero-cta:hover .hero-cta-arrow { transform: translateX(4px); }

        /* click ripple hint */
        .hero-click-hint {
            position: absolute; bottom: 70px; right: 5vw; z-index: 4;
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            color: rgba(255,255,255,.3); font-size: .72rem; letter-spacing: .12em;
            text-transform: uppercase;
            opacity: 0; animation: fadeUp .8s 1.3s forwards;
        }
        .hint-pulse {
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center;
            animation: pulse-ring 2.2s infinite;
        }
        .hint-pulse i { font-size: 1rem; }

        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(255,255,255,.2); }
            70%  { box-shadow: 0 0 0 14px rgba(255,255,255,0); }
            100% { box-shadow: 0 0 0 0 rgba(255,255,255,0); }
        }

        /* ════════════════════════════
           EXPANDED DETAIL PANEL
        ════════════════════════════ */
        .detail-panel {
            position: fixed; inset: 0; z-index: 2000;
            background: rgba(4,5,8,.96);
            backdrop-filter: blur(20px);
            overflow-y: auto;
            opacity: 0; pointer-events: none;
            transform: translateY(40px);
            transition: opacity .5s cubic-bezier(.4,0,.2,1), transform .5s cubic-bezier(.4,0,.2,1);
        }
        .detail-panel.open {
            opacity: 1; pointer-events: all;
            transform: translateY(0);
        }
        .panel-close {
            position: sticky; top: 0;
            display: flex; justify-content: flex-end;
            padding: 24px 40px;
            background: rgba(4,5,8,.8);
            backdrop-filter: blur(10px);
            z-index: 10;
        }
        .close-btn {
            background: rgba(255,255,255,.06);
            border: 1px solid var(--border);
            color: var(--text-muted); width: 46px; height: 46px; border-radius: 50%;
            font-size: 1.3rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all .25s;
        }
        .close-btn:hover { background: rgba(192,57,43,.2); color: var(--text-main); }

        .panel-inner {
            max-width: 1000px; margin: 0 auto;
            padding: 20px 40px 100px;
        }
        .panel-kicker {
            font-size: .72rem; letter-spacing: .2em; text-transform: uppercase;
            color: var(--accent-red2); margin-bottom: 16px;
        }
        .panel-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.8rem);
            font-weight: 900; line-height: 1.05;
            margin-bottom: 2.5rem;
        }
        .panel-title em { font-style: italic; color: var(--accent-blue2); }

        .panel-img-full {
            width: 100%; height: 380px;
            object-fit: cover; object-position: center 25%;
            border-radius: 12px;
            margin-bottom: 3rem;
            filter: brightness(.7) saturate(1.1);
        }

        .panel-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem 4rem;
            margin-bottom: 3rem;
        }

        .panel-block h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem; font-weight: 700;
            margin-bottom: .9rem;
            color: var(--text-main);
        }
        .panel-block h3 .accent { color: var(--accent-red2); }
        .panel-block p {
            color: var(--text-muted); line-height: 1.75; font-size: .95rem;
        }

        .panel-team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        .member-card {
            background: rgba(255,255,255,.03);
            border: 1px solid var(--border);
            border-radius: 12px; padding: 1.5rem;
            transition: border-color .25s, transform .3s;
        }
        .member-card:hover {
            border-color: rgba(192,57,43,.35);
            transform: translateY(-4px);
        }
        .member-avatar {
            width: 54px; height: 54px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-red), var(--accent-blue));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem; font-weight: 700; color: #fff;
            margin-bottom: 1rem;
        }
        .member-name { font-weight: 600; font-size: .95rem; margin-bottom: .2rem; }
        .member-role { font-size: .78rem; color: var(--accent-blue2); letter-spacing: .05em; text-transform: uppercase; margin-bottom: .7rem; }
        .member-bio { font-size: .82rem; color: var(--text-muted); line-height: 1.6; }

        /* ════════════════════════════
           MAIN SECTIONS
        ════════════════════════════ */
        section { padding: 110px 5vw; }

        .section-label {
            display: inline-flex; align-items: center; gap: 10px;
            font-size: .72rem; letter-spacing: .2em; text-transform: uppercase;
            color: var(--accent-red2); margin-bottom: 1.4rem;
        }
        .section-label::before {
            content: ''; display: block;
            width: 28px; height: 1px; background: var(--accent-red2);
        }

        .big-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.4rem, 5vw, 4rem);
            font-weight: 900; line-height: 1.05;
            margin-bottom: 1.5rem;
        }
        .big-title em { font-style: italic; color: var(--accent-red2); }
        .big-title .blue { color: var(--accent-blue2); font-style: italic; }

        .body-copy {
            color: var(--text-muted); line-height: 1.8; font-size: 1rem;
            max-width: 620px;
        }

        /* ── OUR STORY ── */
        .story-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: center;
            border-top: 1px solid var(--border);
        }

        .story-numbers {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        .stat-box {
            background: var(--bg-card); padding: 2.4rem;
            display: flex; flex-direction: column; gap: .4rem;
        }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 3rem; font-weight: 900; line-height: 1;
            background: linear-gradient(120deg, var(--accent-red2), var(--accent-blue2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stat-label { font-size: .78rem; color: var(--text-muted); letter-spacing: .07em; text-transform: uppercase; }

        /* ── MISSION ── */
        .mission-section {
            background: var(--bg-card);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            position: relative; overflow: hidden;
        }
        .mission-section::before {
            content: '';
            position: absolute; top: -120px; right: -80px;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(192,57,43,.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .mission-inner {
            max-width: 820px; margin: 0 auto; text-align: center;
        }
        .mission-quote {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 3.5vw, 2.6rem);
            font-weight: 400; font-style: italic;
            line-height: 1.5; color: var(--text-main);
            margin-bottom: 2.5rem;
            position: relative;
        }
        .mission-quote::before {
            content: '\201C';
            position: absolute; top: -.5em; left: -.3em;
            font-size: 6rem; color: rgba(192,57,43,.15);
            font-family: Georgia, serif; line-height: 1;
        }
        .mission-pillars {
            display: flex; justify-content: center; gap: 3rem;
            flex-wrap: wrap; margin-top: 3rem;
        }
        .pillar {
            display: flex; flex-direction: column; align-items: center; gap: .7rem;
        }
        .pillar-icon {
            width: 52px; height: 52px; border-radius: 50%;
            background: rgba(255,255,255,.04);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            transition: background .3s, border-color .3s;
        }
        .pillar:hover .pillar-icon {
            background: rgba(192,57,43,.15);
            border-color: rgba(192,57,43,.4);
        }
        .pillar-label {
            font-size: .78rem; letter-spacing: .1em; text-transform: uppercase;
            color: var(--text-muted);
        }

        /* ── TEAM ── */
        .team-section { border-top: 1px solid var(--border); }
        .team-header {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 4rem; flex-wrap: wrap; gap: 1.5rem;
        }
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }
        .team-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden;
            transition: border-color .3s, transform .35s;
            position: relative;
        }
        .team-card:hover {
            border-color: rgba(192,57,43,.4);
            transform: translateY(-6px);
        }
        .team-card-accent {
            height: 4px;
            background: linear-gradient(90deg, var(--accent-red), var(--accent-blue));
        }
        .team-card-body { padding: 1.8rem; }
        .t-avatar {
            width: 64px; height: 64px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem; font-weight: 900; color: #fff;
            margin-bottom: 1.2rem;
        }
        .t-name { font-weight: 600; font-size: 1.05rem; margin-bottom: .2rem; }
        .t-role { font-size: .75rem; color: var(--accent-blue2); letter-spacing: .08em; text-transform: uppercase; margin-bottom: .9rem; }
        .t-bio { font-size: .875rem; color: var(--text-muted); line-height: 1.65; }
        .t-skills { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 1.2rem; }
        .skill-tag {
            font-size: .68rem; padding: 3px 10px; border-radius: 50px;
            background: rgba(255,255,255,.04);
            border: 1px solid var(--border);
            color: var(--text-muted); letter-spacing: .04em;
        }

        /* ── EXPERIENCE ── */
        .exp-section { border-top: 1px solid var(--border); }
        .timeline {
            position: relative; max-width: 800px;
            margin: 4rem auto 0; padding-left: 2.5rem;
        }
        .timeline::before {
            content: ''; position: absolute;
            left: 0; top: 0; bottom: 0; width: 1px;
            background: linear-gradient(to bottom, var(--accent-red), var(--accent-blue), transparent);
        }
        .tl-item {
            position: relative; margin-bottom: 3.5rem;
            padding-left: 1.8rem;
        }
        .tl-item::before {
            content: ''; position: absolute;
            left: -2.05rem; top: 6px;
            width: 10px; height: 10px; border-radius: 50%;
            background: var(--accent-red2);
            box-shadow: 0 0 0 4px rgba(231,76,60,.15);
        }
        .tl-year {
            font-size: .72rem; letter-spacing: .15em; text-transform: uppercase;
            color: var(--accent-blue2); margin-bottom: .4rem;
        }
        .tl-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem; font-weight: 700; margin-bottom: .6rem;
        }
        .tl-desc { color: var(--text-muted); font-size: .9rem; line-height: 1.7; }

        /* ── TECH ── */
        .tech-section {
            border-top: 1px solid var(--border);
            background: linear-gradient(180deg, var(--bg-dark) 0%, var(--bg-card) 100%);
        }
        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem; margin-top: 4rem;
        }
        .tech-item {
            background: rgba(255,255,255,.025);
            border: 1px solid var(--border);
            border-radius: 12px; padding: 1.6rem 1rem;
            display: flex; flex-direction: column; align-items: center; gap: .8rem;
            text-align: center; cursor: default;
            transition: all .3s;
        }
        .tech-item:hover {
            background: rgba(255,255,255,.05);
            border-color: rgba(41,128,185,.35);
            transform: translateY(-4px);
        }
        .tech-icon { font-size: 2rem; }
        .tech-name { font-size: .8rem; font-weight: 500; letter-spacing: .04em; }
        .tech-cat { font-size: .68rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .1em; }

        /* ── FOOTER ── */
        .site-footer-about {
            padding: 60px 5vw;
            background: var(--bg-dark);
            border-top: 1px solid var(--border);
        }
        .footer-row {
            max-width: 1400px; margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center;
            color: var(--text-muted); font-size: .85rem; flex-wrap: wrap; gap: 1rem;
        }
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; font-weight: 700;
            color: var(--text-main); text-decoration: none;
        }
        .footer-logo span { color: var(--accent-red2); }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .reveal {
            opacity: 0; transform: translateY(32px);
            transition: opacity .7s cubic-bezier(.4,0,.2,1), transform .7s cubic-bezier(.4,0,.2,1);
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .story-section { grid-template-columns: 1fr; gap: 3rem; }
            .panel-grid { grid-template-columns: 1fr; }
            .mission-pillars { gap: 1.5rem; }
            .team-header { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 600px) {
            section { padding: 70px 1.4rem; }
            .site-header { padding: 16px 1.4rem; }
            .story-numbers { grid-template-columns: 1fr 1fr; }
            .hero-content { padding: 0 1.4rem 6vh; }
            .panel-inner { padding: 16px 20px 80px; }
        }
    </style>
</head>
<body class="page-about">

    <!-- ════ HEADER ════ -->
   <header class="site-header scrolled" id="header">
        <div class="header-container">
            <a href="index.php" class="logo">PortfolioGen</a>

            <div class="search-container">
                <input type="text" class="search-input" id="search-input" placeholder="Search portfolios…">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="search-icon">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>

            <nav class="main-nav" id="main-nav">
                <a href="index.php" class="nav-link active">Home</a>
                <a href="explore.php" class="nav-link">Explore</a>
                <a href="generator.php" class="nav-link">Templates</a>
                <a href="#about" class="nav-link">About</a>
            </nav>

            <div class="auth-buttons">
            <?php if (isset($_SESSION['id_user'])): ?>
                <!-- Utilisateur connecté : avatar cercle -->
                <div class="dropdown">
                    <button class="user-avatar-btn" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false" title="<?= htmlspecialchars($_SESSION['nom']) ?>">
                        <?= strtoupper(mb_substr($_SESSION['nom'], 0, 1)) ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                        <li class="dropdown-user-info">
                            <div class="dropdown-user-avatar"><?= strtoupper(mb_substr($_SESSION['nom'], 0, 1)) ?></div>
                            <div>
                                <div class="dropdown-user-name"><?= htmlspecialchars($_SESSION['nom']) ?></div>
                                <div class="dropdown-user-role">Member</div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="auth2/dashboard.php">
                            <i class="bi bi-person me-2"></i>View Profile</a></li>
                        <li><a class="dropdown-item" href="generator.php">
                            <i class="bi bi-plus-circle me-2"></i>My Portfolio</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="auth2/logout.php">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <!-- Visiteur non connecté -->
                <button class="btn btn-signin" data-bs-toggle="modal" data-bs-target="#registerModal">Sign In</button>
                <button class="btn btn-login"  data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- ════ EXPANDED DETAIL PANEL ════ -->
    <div class="detail-panel" id="detailPanel" role="dialog" aria-modal="true" aria-label="Team & Experience Detail">
        <div class="panel-close">
            <button class="close-btn" id="closePanel" aria-label="Close panel"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="panel-inner">
            <p class="panel-kicker">The people &amp; the journey</p>
            <h2 class="panel-title">Behind Every <em>Great Portfolio</em><br>Stands a Dedicated Team</h2>

            <img src="images/img.jpg" alt="PortfolioGen team at work" class="panel-img-full">

            <div class="panel-grid">
                <div class="panel-block">
                    <h3><span class="accent">01.</span> Our Foundation</h3>
                    <p>PortfolioGen was born in 2022 from a simple frustration: building a professional portfolio took weeks of work that had nothing to do with the work itself. We set out to change that by creating a platform where creatives, developers, and professionals could generate stunning portfolios in minutes — not months.</p>
                </div>
                <div class="panel-block">
                    <h3><span class="accent">02.</span> The Vision</h3>
                    <p>We believe your portfolio should be a living document — one that evolves as your skills do. Our platform was designed from day one to be flexible, fast, and beautiful, so you can focus on what matters: the work you put inside it.</p>
                </div>
                <div class="panel-block">
                    <h3><span class="accent">03.</span> Design Philosophy</h3>
                    <p>Every template on PortfolioGen is built with three principles in mind: clarity, impact, and authenticity. We study the portfolios of the world's leading creatives and distil those lessons into accessible, ready-to-use designs.</p>
                </div>
                <div class="panel-block">
                    <h3><span class="accent">04.</span> Growth & Scale</h3>
                    <p>From a small team of four launching a beta, we have grown to serve over 12,000 users across 38 countries. Each milestone reinforced our mission: democratise beautiful professional presentation for everyone, everywhere.</p>
                </div>
            </div>

            <h3 style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;margin-bottom:1.8rem;">
                Meet the Core Team
            </h3>
            <div class="panel-team-grid">
                <div class="member-card">
                    <div class="member-avatar" style="background:linear-gradient(135deg,#c0392b,#8e44ad);">A</div>
                    <div class="member-name">Ayoub Kharbouch</div>
                    <div class="member-role">Co-founder & CEO</div>
                    <div class="member-bio">Product strategist with a background in UX and 8+ years building creative tools used by designers worldwide.</div>
                </div>
                <div class="member-card">
                    <div class="member-avatar" style="background:linear-gradient(135deg,#1a6fa8,#16a085);">S</div>
                    <div class="member-name">Sara Benali</div>
                    <div class="member-role">CTO & Lead Engineer</div>
                    <div class="member-bio">Full-stack architect specialising in performant web applications, PHP systems, and developer experience.</div>
                </div>
                <div class="member-card">
                    <div class="member-avatar" style="background:linear-gradient(135deg,#c9a84c,#c0392b);">R</div>
                    <div class="member-name">Reda Moussaoui</div>
                    <div class="member-role">Head of Design</div>
                    <div class="member-bio">Motion designer and visual systems thinker who has shipped design systems at two Y-Combinator startups.</div>
                </div>
                <div class="member-card">
                    <div class="member-avatar" style="background:linear-gradient(135deg,#2980b9,#8e44ad);">L</div>
                    <div class="member-name">Leila Tahir</div>
                    <div class="member-role">Growth & Partnerships</div>
                    <div class="member-bio">Community builder and growth strategist who grew PortfolioGen's user base from 200 to 12,000 in under two years.</div>
                </div>
            </div>

            <h3 style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;margin:2.5rem 0 1.2rem;">
                Experience &amp; Milestones
            </h3>
            <div style="color:var(--text-muted);font-size:.9rem;line-height:1.8;max-width:680px;">
                <p style="margin-bottom:1rem;">Our team brings over 24 combined years of experience across product design, frontend engineering, backend architecture, and brand strategy. We have consulted for agencies in Paris and Casablanca, shipped features for platforms with millions of users, and competed in international hackathons.</p>
                <p>We are proud to be a remote-first, diverse team that believes exceptional work happens when talented people have the freedom and tools to do their best.</p>
            </div>
        </div>
    </div>

    <main>

        <!-- ════ HERO ════ -->
        <section class="about-hero" id="aboutHero" role="button" aria-label="Click to learn more about our team" tabindex="0">
            <div class="hero-img-wrap">
                <img src="images/img.jpg" alt="PortfolioGen creative team">
            </div>
            <div class="hero-vignette"></div>
            <div class="hero-scanlines"></div>

            <div class="hero-content">
                <span class="hero-eyebrow">About PortfolioGen</span>
                <h1 class="hero-title">
                    We build the<br>
                    stage for<br>
                    <em>your story.</em>
                </h1>
                <p class="hero-sub">A small team on a big mission — making professional portfolio design accessible, fast, and genuinely beautiful for every creator on earth.</p>
                <a class="hero-cta" id="openPanel" href="#" aria-label="Discover our team and experience">
                    Discover the team
                    <span class="hero-cta-arrow">→</span>
                </a>
            </div>

            <div class="hero-click-hint">
                <div class="hint-pulse"><i class="bi bi-cursor"></i></div>
                Click to explore
            </div>
        </section>

        <!-- ════ OUR STORY ════ -->
        <section class="story-section reveal">
            <div class="story-text">
                <span class="section-label">Our Story</span>
                <h2 class="big-title">From frustration<br>to <em>platform.</em></h2>
                <p class="body-copy">What started as four friends struggling to build their own portfolios became a platform trusted by thousands of creatives, developers, and professionals worldwide. We obsess over the details so you never have to.</p>
                <p class="body-copy" style="margin-top:1.2rem;">Every design decision, every template, every animation is made with a single question in mind: does this help our users tell their story better?</p>
            </div>

            <div class="story-numbers">
                <div class="stat-box">
                    <span class="stat-num">12K+</span>
                    <span class="stat-label">Users worldwide</span>
                </div>
                <div class="stat-box">
                    <span class="stat-num">38</span>
                    <span class="stat-label">Countries reached</span>
                </div>
                <div class="stat-box">
                    <span class="stat-num">8</span>
                    <span class="stat-label">Premium templates</span>
                </div>
                <div class="stat-box">
                    <span class="stat-num">4.8★</span>
                    <span class="stat-label">Average rating</span>
                </div>
            </div>
        </section>

        <!-- ════ MISSION ════ -->
        <section class="mission-section reveal">
            <div class="mission-inner">
                <span class="section-label">Our Mission</span>
                <p class="mission-quote">
                    Great work deserves great presentation. We exist to ensure that no talented person is held back by an underwhelming portfolio.
                </p>
                <p class="body-copy" style="margin:0 auto 1rem;text-align:center;">
                    PortfolioGen is built on the belief that design quality and speed are not opposites. With the right tools, you can have both — and the confidence to share your work with the world.
                </p>
                <div class="mission-pillars">
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-lightning-charge"></i></div>
                        <span class="pillar-label">Speed</span>
                    </div>
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-gem"></i></div>
                        <span class="pillar-label">Quality</span>
                    </div>
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-people"></i></div>
                        <span class="pillar-label">Community</span>
                    </div>
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-universal-access"></i></div>
                        <span class="pillar-label">Accessibility</span>
                    </div>
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-stars"></i></div>
                        <span class="pillar-label">Excellence</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ════ TEAM ════ -->
        <section class="team-section reveal">
            <div class="team-header">
                <div>
                    <span class="section-label">Our Team</span>
                    <h2 class="big-title">The <em>people</em><br>behind the pixels.</h2>
                </div>
                <p class="body-copy" style="max-width:360px;">Four specialists, one shared obsession: building tools that make creative people shine.</p>
            </div>

            <div class="team-grid">
                <div class="team-card">
                    <div class="team-card-accent"></div>
                    <div class="team-card-body">
                        <div class="t-avatar" style="background:linear-gradient(135deg,#c0392b,#8e44ad);">A</div>
                        <div class="t-name">Ayoub Kharbouch</div>
                        <div class="t-role">Co-founder & CEO</div>
                        <p class="t-bio">Product strategist and UX thinker with 8+ years building tools for creative professionals. Obsessed with reducing friction between great ideas and polished output.</p>
                        <div class="t-skills">
                            <span class="skill-tag">Product</span>
                            <span class="skill-tag">UX</span>
                            <span class="skill-tag">Strategy</span>
                        </div>
                    </div>
                </div>

                <div class="team-card">
                    <div class="team-card-accent" style="background:linear-gradient(90deg,var(--accent-blue),#16a085);"></div>
                    <div class="team-card-body">
                        <div class="t-avatar" style="background:linear-gradient(135deg,#1a6fa8,#16a085);">S</div>
                        <div class="t-name">Sara Benali</div>
                        <div class="t-role">CTO & Lead Engineer</div>
                        <p class="t-bio">Full-stack architect who has led engineering teams at two funded startups. She designed the PortfolioGen generator engine from scratch.</p>
                        <div class="t-skills">
                            <span class="skill-tag">PHP</span>
                            <span class="skill-tag">MySQL</span>
                            <span class="skill-tag">Architecture</span>
                        </div>
                    </div>
                </div>

                <div class="team-card">
                    <div class="team-card-accent" style="background:linear-gradient(90deg,var(--gold),var(--accent-red));"></div>
                    <div class="team-card-body">
                        <div class="t-avatar" style="background:linear-gradient(135deg,#c9a84c,#c0392b);">R</div>
                        <div class="t-name">Reda Moussaoui</div>
                        <div class="t-role">Head of Design</div>
                        <p class="t-bio">Motion designer and visual systems expert. Reda brings a cinematic eye to every template — if it moves on PortfolioGen, he designed how.</p>
                        <div class="t-skills">
                            <span class="skill-tag">Motion</span>
                            <span class="skill-tag">Figma</span>
                            <span class="skill-tag">GSAP</span>
                        </div>
                    </div>
                </div>

                <div class="team-card">
                    <div class="team-card-accent" style="background:linear-gradient(90deg,#2980b9,#8e44ad);"></div>
                    <div class="team-card-body">
                        <div class="t-avatar" style="background:linear-gradient(135deg,#2980b9,#8e44ad);">L</div>
                        <div class="t-name">Leila Tahir</div>
                        <div class="t-role">Growth & Partnerships</div>
                        <p class="t-bio">Community builder who grew PortfolioGen from 200 beta users to 12,000 paid members. Expert in creator economy trends and partnership strategy.</p>
                        <div class="t-skills">
                            <span class="skill-tag">Growth</span>
                            <span class="skill-tag">Partnerships</span>
                            <span class="skill-tag">Community</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ════ EXPERIENCE / TIMELINE ════ -->
        <section class="exp-section reveal">
            <span class="section-label">Experience</span>
            <h2 class="big-title" style="max-width:600px;">Built over years of<br><span class="blue">real-world craft.</span></h2>

            <div class="timeline">
                <div class="tl-item">
                    <div class="tl-year">2022 — Q1</div>
                    <div class="tl-title">The Idea</div>
                    <p class="tl-desc">Four colleagues at a Casablanca design agency share the same frustration: every great project is buried in a mediocre portfolio. The seed of PortfolioGen is planted.</p>
                </div>
                <div class="tl-item">
                    <div class="tl-year">2022 — Q3</div>
                    <div class="tl-title">Private Beta</div>
                    <p class="tl-desc">First 200 users test the generator engine. Feedback is clear: speed and simplicity are non-negotiable. The team rebuilds the template system from the ground up.</p>
                </div>
                <div class="tl-item">
                    <div class="tl-year">2023 — Q2</div>
                    <div class="tl-title">Public Launch & VIP Tier</div>
                    <p class="tl-desc">PortfolioGen opens to the public with 4 free templates and a VIP subscription. Within 60 days, 3,000 portfolios are published across 18 countries.</p>
                </div>
                <div class="tl-item">
                    <div class="tl-year">2024 — Q1</div>
                    <div class="tl-title">10,000 Users Milestone</div>
                    <p class="tl-desc">The platform hits 10K active users and expands the template library. The team triples the animation capabilities by integrating GSAP ScrollTrigger across all themes.</p>
                </div>
                <div class="tl-item">
                    <div class="tl-year">2025 — Present</div>
                    <div class="tl-title">Premium Template Hub & AI Features</div>
                    <p class="tl-desc">The curated Template Hub launches with cinematic preview cards. The team begins integrating AI-assisted content suggestions to help users write bios, project descriptions, and more.</p>
                </div>
            </div>
        </section>

        <!-- ════ TECHNOLOGIES ════ -->
        <section class="tech-section reveal">
            <span class="section-label">Technologies</span>
            <h2 class="big-title">Crafted with the<br>best of the <em>web.</em></h2>
            <p class="body-copy">Every layer of PortfolioGen — from server to screen — is chosen for reliability, performance, and developer delight.</p>

            <div class="tech-grid">
                <div class="tech-item">
                    <div class="tech-icon">🐘</div>
                    <div class="tech-name">PHP 8</div>
                    <div class="tech-cat">Backend</div>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🗄️</div>
                    <div class="tech-name">MySQL</div>
                    <div class="tech-cat">Database</div>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🅱️</div>
                    <div class="tech-name">Bootstrap 5</div>
                    <div class="tech-cat">UI Framework</div>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🟨</div>
                    <div class="tech-name">Vanilla JS</div>
                    <div class="tech-cat">Frontend</div>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🎬</div>
                    <div class="tech-name">GSAP</div>
                    <div class="tech-cat">Animation</div>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🌊</div>
                    <div class="tech-name">CSS3</div>
                    <div class="tech-cat">Styling</div>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🎨</div>
                    <div class="tech-name">Figma</div>
                    <div class="tech-cat">Design</div>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🐙</div>
                    <div class="tech-name">Git & GitHub</div>
                    <div class="tech-cat">Version Control</div>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">🔒</div>
                    <div class="tech-name">Sessions & PDO</div>
                    <div class="tech-cat">Auth & Security</div>
                </div>
                <div class="tech-item">
                    <div class="tech-icon">☁️</div>
                    <div class="tech-name">Apache / Nginx</div>
                    <div class="tech-cat">Server</div>
                </div>
            </div>
        </section>

    </main>

    <!-- ════ FOOTER ════ -->
    <footer class="site-footer" style="padding:60px 2rem;background:var(--bg-dark);border-top:1px solid rgba(255,255,255,0.05);">
        <div style="max-width:1400px;margin:0 auto;">
            <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1.5fr;gap:4rem;">
                <div>
                    <a href="index.php" class="logo" style="margin-bottom:20px;display:inline-block;">Portfolio<span>Gen</span></a>
                    <p style="color:var(--text-muted);line-height:1.6;">Empowering creators to build stunning portfolios without the complexity of coding.</p>
                </div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <h4 style="color:#fff;margin-bottom:8px;">Platform</h4>
                    <a href="#" style="color:var(--text-muted);text-decoration:none;">Explore</a>
                    <a href="#" style="color:var(--text-muted);text-decoration:none;">Templates</a>
                    <a href="#" style="color:var(--text-muted);text-decoration:none;">Showcase</a>
                </div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <h4 style="color:#fff;margin-bottom:8px;">Company</h4>
                    <a href="#" style="color:var(--text-muted);text-decoration:none;">About Us</a>
                    <a href="#" style="color:var(--text-muted);text-decoration:none;">Careers</a>
                    <a href="#" style="color:var(--text-muted);text-decoration:none;">Contact</a>
                </div>
                <div>
                    <h4 style="color:#fff;margin-bottom:16px;">Newsletter</h4>
                    <p style="color:var(--text-muted);margin-bottom:16px;font-size:0.9rem;">Subscribe to get the latest updates and templates.</p>
                </div>
            </div>
            <div style="margin-top:60px;padding-top:30px;border-top:1px solid rgba(255,255,255,0.05);display:flex;justify-content:space-between;align-items:center;color:var(--text-muted);font-size:0.85rem;">
                <p>&copy; 2026 PortfolioGen. All rights reserved.</p>
                <div style="display:flex;gap:24px;">
                    <a href="#" style="color:inherit;text-decoration:none;">Privacy Policy</a>
                    <a href="#" style="color:inherit;text-decoration:none;">Terms of Service</a>
                    <a href="#" style="color:inherit;text-decoration:none;">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
    (function () {
        /* ── PANEL OPEN / CLOSE ── */
        const hero    = document.getElementById('aboutHero');
        const openBtn = document.getElementById('openPanel');
        const panel   = document.getElementById('detailPanel');
        const closeBtn= document.getElementById('closePanel');

        function openPanel(e) {
            e.preventDefault();
            panel.classList.add('open');
            document.body.style.overflow = 'hidden';
            closeBtn.focus();
        }
        function closePanel() {
            panel.classList.remove('open');
            document.body.style.overflow = '';
            hero.focus();
        }

        hero.addEventListener('click',  openPanel);
        openBtn.addEventListener('click', openPanel);
        closeBtn.addEventListener('click', closePanel);

        // Close on Escape
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && panel.classList.contains('open')) closePanel();
        });

        // Prevent hero click from firing when clicking internal links/buttons inside panel
        panel.addEventListener('click', e => e.stopPropagation());

        /* ── SCROLL REVEAL ── */
        const reveals = document.querySelectorAll('.reveal');
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        reveals.forEach(el => io.observe(el));

        /* ── HEADER SHRINK ── */
        const hdr = document.getElementById('header');
        window.addEventListener('scroll', () => {
            hdr.style.padding = window.scrollY > 60 ? '12px 3rem' : '20px 3rem';
        }, { passive: true });
    })();
    </script>
</body>
</html>