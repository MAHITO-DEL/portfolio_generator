<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About PortfolioGen — who we are, what we do, and why we built it.">
    <title>About — PortfolioGen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">

    <style>
        /* ── TOKENS ── */
        :root {
            --ink:    #07080c;
            --ink2:   #0e1018;
            --red:    #b91c1c;
            --red2:   #ef4444;
            --blue:   #1d4ed8;
            --blue2:  #3b82f6;
            --gold:   #c9a84c;
            --text:   #f0ede8;
            --muted:  #6b7280;
            --border: rgba(255,255,255,0.06);
            --border2:rgba(255,255,255,0.12);
            --card:   rgba(255,255,255,0.025);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            background: var(--ink);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* ── NOISE ── */
        body::after {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.72' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
        }

        


        /* ══════════════════════════════
           SHARED UTILITIES
        ══════════════════════════════ */
        .eyebrow {
            display: inline-flex; align-items: center; gap: 10px;
            font-size: .68rem; letter-spacing: .22em; text-transform: uppercase;
            color: var(--red2); margin-bottom: 1.2rem;
        }
        .eyebrow::before { content: ''; width: 24px; height: 1px; background: var(--red2); }

        .section-title {
            font-family: 'Inter', sans-serif;
            font-size: clamp(2.2rem, 4vw, 3.4rem);
            font-weight: 700; line-height: 1.05;
            color: var(--text); margin-bottom: 1.2rem;
        }
        .section-title em { font-style: italic; color: var(--red2); }

        .body-text {
            font-size: .95rem; color: var(--muted);
            line-height: 1.8; max-width: 580px;
        }

        .divider { border: none; border-top: 1px solid var(--border); margin: 0; }

        /* reveal animation */
        .reveal {
            opacity: 0; transform: translateY(24px);
            transition: opacity .7s cubic-bezier(.4,0,.2,1),
                        transform .7s cubic-bezier(.4,0,.2,1);
        }
        .reveal.visible { opacity: 1; transform: none; }

        /* ══════════════════════════════
           HERO
        ══════════════════════════════ */
        .about-hero {
            padding-top: 88px;
            position: relative; overflow: hidden;
            border-bottom: 1px solid var(--border);
        }

        .hero-glow {
            position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 60% 70% at 10% 50%,  rgba(185,28,28,.07)  0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 85% 20%,  rgba(29,78,216,.06)  0%, transparent 55%);
        }

        .hero-inner {
            max-width: 1300px; margin: 0 auto;
            padding: 90px 3rem 70px;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 5rem; align-items: center;
        }

        .hero-h1 {
            font-family: 'Inter', sans-serif;
            font-size: clamp(3rem,5vw, 5rem);
            font-weight: 500; line-height: .85;
            color: var(--text); margin-bottom: 1.8rem;
        }
        .hero-h1 em {
            font-style: italic;
            background: linear-gradient(110deg, var(--red2), var(--blue2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 1rem; color: var(--muted); line-height: 1.8;
            margin-bottom: 2.5rem; max-width: 460px;
        }

        .hero-cta {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 12px 28px;
            background: var(--red); color: #fff;
            border: none; border-radius: 6px;
            font-family: 'Inter', sans-serif;
            font-size: .8rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            text-decoration: none; cursor: pointer;
            transition: background .25s, gap .25s;
        }
        .hero-cta:hover { background: var(--red2); gap: 16px; color: #fff; }

        /* stats strip */
        .hero-stats {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 1px; background: var(--border);
            border: 1px solid var(--border);
            border-radius: 12px; overflow: hidden;
        }
        .hstat {
            background: var(--ink2);
            padding: 2rem 1.8rem;
            display: flex; flex-direction: column; gap: .3rem;
        }
        .hstat-num {
            font-family: 'Inter', sans-serif;
            font-size: 2.6rem; font-weight: 700; line-height: 1;
            background: linear-gradient(110deg, var(--red2), var(--blue2));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hstat-lbl {
            font-size: .7rem; letter-spacing: .12em;
            text-transform: uppercase; color: var(--muted);
        }

        /* ══════════════════════════════
           STORY SECTION
        ══════════════════════════════ */
        .story-section {
            max-width: 1300px; margin: 0 auto;
            padding: 100px 3rem;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 6rem; align-items: center;
            border-bottom: 1px solid var(--border);
        }

        .story-img-wrap {
            position: relative;
            border-radius: 12px; overflow: hidden;
            aspect-ratio: 4/3;
        }
        .story-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            filter: brightness(.75) saturate(1.1);
            transition: transform .6s cubic-bezier(.16,1,.3,1), filter .4s;
        }
        .story-img-wrap:hover img { transform: scale(1.04); filter: brightness(.85); }

        /* thin red border accent */
        .story-img-wrap::before {
            content: ''; position: absolute;
            top: -1px; left: -1px; right: -1px; bottom: -1px;
            border: 1px solid var(--border2); border-radius: 12px; z-index: 1;
            pointer-events: none;
        }

        /* year badge */
        .story-badge {
            position: absolute; bottom: 20px; right: 20px; z-index: 2;
            padding: 10px 16px;
            background: rgba(7,8,12,.8);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border2);
            border-radius: 8px;
            font-size: .7rem; letter-spacing: .12em;
            text-transform: uppercase; color: var(--text);
        }
        .story-badge strong { display: block; font-family: 'Inter', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--red2); line-height: 1; }

        /* ══════════════════════════════
           MISSION SECTION
        ══════════════════════════════ */
        .mission-section {
            background: var(--ink2);
            border-bottom: 1px solid var(--border);
            padding: 100px 3rem;
        }
        .mission-inner {
            max-width: 820px; margin: 0 auto; text-align: center;
        }
        .mission-quote {
            font-family: 'Inter', sans-serif;
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 600; font-style: italic;
            line-height: 1.45; color: var(--text);
            margin-bottom: 2rem;
            position: relative;
        }
        .mission-quote::before {
            content: '\201C';
            position: absolute; top: -.4em; left: -.2em;
            font-size: 5rem; color: rgba(239,68,68,.1);
            font-family: 'Inter', sans-serif; line-height: 1;
        }
        .mission-body {
            font-size: .95rem; color: var(--muted); line-height: 1.8;
            margin-bottom: 3.5rem;
        }

        .pillars {
            display: flex; justify-content: center;
            gap: 3rem; flex-wrap: wrap;
        }
        .pillar {
            display: flex; flex-direction: column;
            align-items: center; gap: .6rem;
        }
        .pillar-icon {
            width: 50px; height: 50px; border-radius: 50%;
            background: rgba(255,255,255,.03);
            border: 1px solid var(--border2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: var(--red2);
            transition: background .3s, border-color .3s;
        }
        .pillar:hover .pillar-icon {
            background: rgba(185,28,28,.15);
            border-color: rgba(239,68,68,.35);
        }
        .pillar-lbl {
            font-size: .68rem; letter-spacing: .12em;
            text-transform: uppercase; color: var(--muted);
        }

        /* ══════════════════════════════
           TEAM SECTION
        ══════════════════════════════ */
        .team-section {
            max-width: 1300px; margin: 0 auto;
            padding: 100px 3rem;
            border-bottom: 1px solid var(--border);
        }
        .team-header {
            display: flex; justify-content: space-between;
            align-items: flex-end; flex-wrap: wrap; gap: 1.5rem;
            margin-bottom: 3.5rem;
        }
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }
        .team-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px; overflow: hidden;
            transition: border-color .3s, transform .4s cubic-bezier(.16,1,.3,1);
        }
        .team-card:hover {
            border-color: rgba(239,68,68,.25);
            transform: translateY(-5px);
        }
        .team-accent { height: 3px; background: linear-gradient(90deg, var(--red), var(--blue)); }
        .team-body { padding: 1.6rem; }
        .team-avatar {
            width: 56px; height: 56px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Inter', serif;
            font-size: 1.5rem; font-weight: 700; color: #fff;
            margin-bottom: 1rem;
        }
        .team-name { font-weight: 700; font-size: 1rem; margin-bottom: .2rem; }
        .team-role {
            font-size: .68rem; letter-spacing: .1em; text-transform: uppercase;
            color: var(--blue2); margin-bottom: .8rem;
        }
        .team-bio { font-size: .82rem; color: var(--muted); line-height: 1.65; }

        /* ══════════════════════════════
           VALUES / WHY US
        ══════════════════════════════ */
        .values-section {
            background: var(--ink2);
            border-bottom: 1px solid var(--border);
            padding: 100px 3rem;
        }
        .values-inner {
            max-width: 1300px; margin: 0 auto;
        }
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem; margin-top: 3.5rem;
        }
        .value-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px; padding: 2rem;
            transition: border-color .3s, background .3s;
        }
        .value-card:hover {
            border-color: var(--border2);
            background: rgba(255,255,255,.04);
        }
        .value-icon {
            font-size: 1.6rem; color: var(--red2);
            margin-bottom: 1rem; display: block;
        }
        .value-title {
            font-size: 1rem; font-weight: 700;
            margin-bottom: .6rem; color: var(--text);
        }
        .value-desc { font-size: .85rem; color: var(--muted); line-height: 1.7; }

        /* ══════════════════════════════
           TECH SECTION
        ══════════════════════════════ */
        .tech-section {
            max-width: 1300px; margin: 0 auto;
            padding: 100px 3rem;
            border-bottom: 1px solid var(--border);
        }
        .tech-grid {
            display: flex; flex-wrap: wrap;
            gap: .75rem; margin-top: 3rem;
        }
        .tech-pill {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 18px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 50px;
            font-size: .78rem; color: var(--muted);
            transition: border-color .25s, color .25s, background .25s;
        }
        .tech-pill i { color: var(--red2); font-size: .9rem; }
        .tech-pill:hover {
            border-color: var(--border2); color: var(--text);
            background: rgba(255,255,255,.05);
        }

        /* ══════════════════════════════
           CTA BANNER
        ══════════════════════════════ */
        .cta-section {
            background: var(--ink2);
            border-bottom: 1px solid var(--border);
            padding: 100px 3rem;
            text-align: center;
        }
        .cta-inner { max-width: 640px; margin: 0 auto; }
        .cta-title {
            font-family: 'Inter', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700; line-height: 1.1;
            color: var(--text); margin-bottom: 1.2rem;
        }
        .cta-title em { font-style: italic; color: var(--red2); }
        .cta-sub { font-size: .9rem; color: var(--muted); margin-bottom: 2.5rem; line-height: 1.7; }
        .cta-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn-primary-cta {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 30px;
            background: var(--red); color: #fff;
            border: none; border-radius: 6px;
            font-family: 'Inter', sans-serif;
            font-size: .8rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            text-decoration: none; cursor: pointer;
            transition: background .25s;
        }
        .btn-primary-cta:hover { background: var(--red2); color: #fff; }
        .btn-outline-cta {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 30px;
            background: none; color: var(--text);
            border: 1px solid var(--border2); border-radius: 6px;
            font-family: 'Inter', sans-serif;
            font-size: .8rem; font-weight: 600;
            letter-spacing: .1em; text-transform: uppercase;
            text-decoration: none; cursor: pointer;
            transition: background .25s, border-color .25s;
        }
        .btn-outline-cta:hover { background: rgba(255,255,255,.06); color: var(--text); border-color: rgba(255,255,255,.25); }

       
    

        /* ══════════════════════════════
           RESPONSIVE
        ══════════════════════════════ */
        @media (max-width: 900px) {
            .hero-inner, .story-section { grid-template-columns: 1fr; gap: 3rem; }
            .hero-h1 { font-size: clamp(2.5rem, 8vw, 3.5rem); }
            .story-img-wrap { order: -1; }
        }
        @media (max-width: 700px) {
            .site-header { padding: 16px 1.4rem; }
            .main-nav    { display: none; }
            .hero-inner, .story-section,
            .team-section, .values-section .values-inner,
            .tech-section, .cta-section, .mission-section { padding-left: 1.4rem; padding-right: 1.4rem; }
            .site-footer { padding: 40px 1.4rem; }
            .hero-stats { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body class="page-about">

    <!-- ════ HEADER ════ -->
    <?php require 'includes/header.php'; ?>

    <main>

        <!-- ════ HERO ════ -->
        <section class="about-hero">
            <div class="hero-glow"></div>
            <div class="hero-inner">

                <div class="hero-text reveal">
                    <p class="eyebrow">Who We Are</p>
                    <h1 class="hero-h1">
                        Built for<br>
                        <em>Creators,</em><br>
                        by Creators
                    </h1>
                    <p class="hero-desc">
                        PortfolioGen is a platform that helps professionals, developers, designers and architects 
                        build stunning portfolios in minutes — without writing a single line of code.
                    </p>
                    <a href="templates.php" class="hero-cta">
                        Browse Templates <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="hero-stats reveal">
                    <div class="hstat">
                        <span class="hstat-num">12K+</span>
                        <span class="hstat-lbl">Portfolios Created</span>
                    </div>
                    <div class="hstat">
                        <span class="hstat-num">38</span>
                        <span class="hstat-lbl">Countries</span>
                    </div>
                    <div class="hstat">
                        <span class="hstat-num">8</span>
                        <span class="hstat-lbl">Premium Templates</span>
                    </div>
                    <div class="hstat">
                        <span class="hstat-num">4.8★</span>
                        <span class="hstat-lbl">Average Rating</span>
                    </div>
                </div>

            </div>
        </section>

        <hr class="divider">

        <!-- ════ OUR STORY ════ -->
        <section class="story-section">

            <div class="reveal">
                <p class="eyebrow">Our Story</p>
                <h2 class="section-title">From a shared<br><em>frustration</em></h2>
                <p class="body-text" style="margin-bottom:1.4rem;">
                    In 2022, four colleagues at a design agency in Casablanca kept running into the same wall: 
                    every great project they completed was buried inside a mediocre portfolio. 
                    Building something decent took weeks — weeks that had nothing to do with their actual work.
                </p>
                <p class="body-text">
                    So we built PortfolioGen. A platform where the setup takes minutes, not months, 
                    and where the result looks like you hired a studio. Today it serves thousands of 
                    creators across 38 countries, and we're just getting started.
                </p>
            </div>

            <div class="story-img-wrap reveal">
                <img src="assets/img/portfolio-img4.jpg" alt="The PortfolioGen team at work">
                <div class="story-badge">
                    <strong>2022</strong>
                    Founded
                </div>
            </div>

        </section>

        <!-- ════ MISSION ════ -->
        <section class="mission-section">
            <div class="mission-inner reveal">
                <p class="eyebrow" style="justify-content:center;">Our Mission</p>
                <p class="mission-quote">
                    Great work deserves great presentation. We exist so no talented person is ever held back 
                    by an underwhelming portfolio.
                </p>
                <p class="mission-body">
                    We believe design quality and speed are not opposites. With the right tools you can have both —
                    and the confidence to share your work with the world.
                </p>

                <div class="pillars">
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                        <span class="pillar-lbl">Speed</span>
                    </div>
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-gem"></i></div>
                        <span class="pillar-lbl">Quality</span>
                    </div>
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-people-fill"></i></div>
                        <span class="pillar-lbl">Community</span>
                    </div>
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-universal-access"></i></div>
                        <span class="pillar-lbl">Accessibility</span>
                    </div>
                    <div class="pillar">
                        <div class="pillar-icon"><i class="bi bi-stars"></i></div>
                        <span class="pillar-lbl">Excellence</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ════ TEAM ════ -->
        <section class="team-section">
            <div class="team-header reveal">
                <div>
                    <p class="eyebrow">The Team</p>
                    <h2 class="section-title">The people behind<br><em>the platform</em></h2>
                </div>
                <p class="body-text" style="max-width:340px; font-size:.88rem;">
                    A small, focused team with one shared obsession — helping creative people shine.
                </p>
            </div>

            <div class="team-grid">

                <div class="team-card reveal">
                    <div class="team-accent"></div>
                    <div class="team-body">
                        <div class="team-avatar" style="background:linear-gradient(135deg,#b91c1c,#7c3aed);">A</div>
                        <div class="team-name">Ayoub Kharbouch</div>
                        <div class="team-role">Co-founder &amp; CEO</div>
                        <p class="team-bio">Product strategist with 8+ years building creative tools. Obsessed with reducing friction between a great idea and a polished result.</p>
                    </div>
                </div>

                <div class="team-card reveal">
                    <div class="team-accent" style="background:linear-gradient(90deg,var(--blue),#0891b2);"></div>
                    <div class="team-body">
                        <div class="team-avatar" style="background:linear-gradient(135deg,#1d4ed8,#0891b2);">S</div>
                        <div class="team-name">Sara Benali</div>
                        <div class="team-role">CTO &amp; Lead Engineer</div>
                        <p class="team-bio">Full-stack architect who designed the PortfolioGen generator engine. Previously led engineering at two funded startups.</p>
                    </div>
                </div>

                <div class="team-card reveal">
                    <div class="team-accent" style="background:linear-gradient(90deg,#c9a84c,#b91c1c);"></div>
                    <div class="team-body">
                        <div class="team-avatar" style="background:linear-gradient(135deg,#c9a84c,#b91c1c);">R</div>
                        <div class="team-name">Reda Moussaoui</div>
                        <div class="team-role">Head of Design</div>
                        <p class="team-bio">Motion designer and visual systems thinker. Every animation you see on PortfolioGen went through his eye first.</p>
                    </div>
                </div>

                <div class="team-card reveal">
                    <div class="team-accent" style="background:linear-gradient(90deg,#2563eb,#7c3aed);"></div>
                    <div class="team-body">
                        <div class="team-avatar" style="background:linear-gradient(135deg,#2563eb,#7c3aed);">L</div>
                        <div class="team-name">Leila Tahir</div>
                        <div class="team-role">Growth &amp; Partnerships</div>
                        <p class="team-bio">Community builder who grew PortfolioGen from 200 beta users to 12,000 active members in under two years.</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- ════ VALUES ════ -->
        <section class="values-section">
            <div class="values-inner">
                <div class="reveal">
                    <p class="eyebrow">Why Us</p>
                    <h2 class="section-title">What makes us<br><em>different</em></h2>
                </div>

                <div class="values-grid">
                    <div class="value-card reveal">
                        <i class="bi bi-clock-history value-icon"></i>
                        <div class="value-title">Ready in Minutes</div>
                        <p class="value-desc">Pick a template, fill in your details, and publish. No technical setup, no hosting headaches — just your portfolio, live.</p>
                    </div>
                    <div class="value-card reveal">
                        <i class="bi bi-palette2 value-icon"></i>
                        <div class="value-title">Designed to Impress</div>
                        <p class="value-desc">Every template is crafted by designers who study the world's best portfolios and distil those lessons into ready-to-use layouts.</p>
                    </div>
                    <div class="value-card reveal">
                        <i class="bi bi-phone value-icon"></i>
                        <div class="value-title">Fully Responsive</div>
                        <p class="value-desc">Your portfolio looks flawless on every device — phone, tablet, or widescreen. We test everything so you don't have to.</p>
                    </div>
                    <div class="value-card reveal">
                        <i class="bi bi-shield-check value-icon"></i>
                        <div class="value-title">Secure &amp; Reliable</div>
                        <p class="value-desc">Built on a hardened PHP and MySQL stack with session-based authentication, input sanitisation, and regular security audits.</p>
                    </div>
                    <div class="value-card reveal">
                        <i class="bi bi-layers value-icon"></i>
                        <div class="value-title">Free &amp; VIP Tiers</div>
                        <p class="value-desc">Start for free with four premium templates. Upgrade to VIP to unlock exclusive designs with advanced animations and sections.</p>
                    </div>
                    <div class="value-card reveal">
                        <i class="bi bi-headset value-icon"></i>
                        <div class="value-title">Real Support</div>
                        <p class="value-desc">Questions answered by the actual team who built the product — not a bot. We respond within 24 hours, every time.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ════ TECH ════ -->
        <section class="tech-section">
            <div class="reveal">
                <p class="eyebrow">Technologies</p>
                <h2 class="section-title">Built with the<br>best of the <em>web</em></h2>
                <p class="body-text">
                    Every layer of PortfolioGen — from server to screen — is chosen for reliability, 
                    performance, and long-term maintainability.
                </p>
            </div>

            <div class="tech-grid">
                <span class="tech-pill"><i class="bi bi-filetype-php"></i> PHP 8</span>
                <span class="tech-pill"><i class="bi bi-database"></i> MySQL</span>
                <span class="tech-pill"><i class="bi bi-bootstrap"></i> Bootstrap 5</span>
                <span class="tech-pill"><i class="bi bi-filetype-js"></i> Vanilla JS</span>
                <span class="tech-pill"><i class="bi bi-camera-video"></i> GSAP</span>
                <span class="tech-pill"><i class="bi bi-filetype-css"></i> CSS3</span>
                <span class="tech-pill"><i class="bi bi-vector-pen"></i> Figma</span>
                <span class="tech-pill"><i class="bi bi-git"></i> Git &amp; GitHub</span>
                <span class="tech-pill"><i class="bi bi-shield-lock"></i> PDO &amp; Sessions</span>
                <span class="tech-pill"><i class="bi bi-hdd-network"></i> Apache / Nginx</span>
            </div>
        </section>

        <!-- ════ CTA ════ -->
        <section class="cta-section">
            <div class="cta-inner reveal">
                <p class="eyebrow" style="justify-content:center;">Get Started</p>
                <h2 class="cta-title">Ready to build your<br><em>portfolio?</em></h2>
                <p class="cta-sub">Join thousands of creators who already use PortfolioGen to present their best work to the world.</p>
                <div class="cta-btns">
                    <a href="templates.php" class="btn-primary-cta">Browse Templates <i class="bi bi-arrow-right"></i></a>
                    <a href="explore.php"   class="btn-outline-cta">Explore Portfolios</a>
                </div>
            </div>
        </section>

    </main>

    <!-- ════ FOOTER ════ -->
    <?php require 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        /* header shrink */
        const hdr = document.getElementById('siteHeader');
        window.addEventListener('scroll', () => {
            hdr.classList.toggle('compact', window.scrollY > 50);
        }, { passive: true });

        /* scroll reveal */
        const io = new IntersectionObserver(entries => {
            entries.forEach((e, i) => {
                if (e.isIntersecting) {
                    setTimeout(() => e.target.classList.add('visible'), i * 80);
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));
    })();
    </script>
</body>
</html>