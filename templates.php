<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse free and premium (VIP) portfolio templates.">
    <title>Templates — PortfolioGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
    <style>
        .template-badge {
            position: absolute; top: 16px; left: 16px; z-index: 4;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
        }
        .template-badge.vip {
            background: rgba(212,175,55,0.92);
            color: #111;
            border-color: rgba(212,175,55,0.3);
        }
        .template-badge.free {
            background: rgba(34,197,94,0.92);
            color: #fff;
            border-color: rgba(34,197,94,0.35);
        }
        .use-template-btn {
            position: absolute; bottom: 16px; right: 16px; z-index: 4;
            padding: 0.85rem 1.5rem;
            background: linear-gradient(135deg, #B11226 0%, #D4AF37 100%);
            color: #fff;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: opacity 0.3s ease, transform 0.3s ease;
            opacity: 0;
            transform: translateY(10px);
        }
        .tm-card:hover .use-template-btn {
            opacity: 1;
            transform: translateY(0);
        }
        .template-section-header {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .template-section-header p {
            max-width: 760px;
            color: var(--text-muted);
        }
    </style>
</head>
<body class="page-templates">
    <?php require 'includes/header.php'; ?>

    <!-- HERO SECTION -->
    <section class="template-page-hero">
        <span class="section-eyebrow">Templates</span>
        <h1 class="section-title">Premium Portfolio Templates</h1>
        <p class="section-subtitle">Browse free and VIP designs built to feel premium, modern, and fully ready to launch.</p>
    </section>

    <section class="template-section" id="free-templates">
        <div class="template-section-header">
            <span class="section-eyebrow">Free Templates</span>
            <div>
                <h2 class="section-title">Start with premium free templates</h2>
                <p class="section-subtitle">Beautiful, polished portfolio designs that are easy to customize and perfect for a quick launch.</p>
            </div>
        </div>

        <div class="template-grid">
            <article class="tm-card reveal" data-category="creative" data-rating="4.9">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img5.jpg" alt="Stellar" class="tm-card-img">
                    <span class="port-cat-pill">Creative</span>
                    <span class="template-badge free">Free</span>
                    <div class="tm-card-actions">
                        <button class="tm-action-btn" aria-label="Favorite Stellar"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Stellar</h3>
                        <div class="tm-rating"><span>★</span> 4.9</div>
                    </div>
                    <p class="tm-card-desc">A professional, well-structured theme for resumes and personal branding.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <a href="generator.php?template=Stellar" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </article>

            <article class="tm-card reveal" data-category="architecture" data-rating="4.8">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img6.jpg" alt="Architecture Pro" class="tm-card-img">
                    <span class="port-cat-pill">Architecture</span>
                    <span class="template-badge free">Free</span>
                    <div class="tm-card-actions">
                        <button class="tm-action-btn" aria-label="Favorite Architecture Pro"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Architecture Pro</h3>
                        <div class="tm-rating"><span>★</span> 4.8</div>
                    </div>
                    <p class="tm-card-desc">A clean portfolio for architects with bold imagery and crisp project sections.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <a href="generator.php?template=Architecture%20Pro" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </article>

            <article class="tm-card reveal" data-category="developer" data-rating="4.7">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img7.jpg" alt="Dev Portfolio" class="tm-card-img">
                    <span class="port-cat-pill">Developer</span>
                    <span class="template-badge free">Free</span>
                    <div class="tm-card-actions">
                        <button class="tm-action-btn" aria-label="Favorite Dev Portfolio"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Dev Portfolio</h3>
                        <div class="tm-rating"><span>★</span> 4.7</div>
                    </div>
                    <p class="tm-card-desc">A sleek developer portfolio with clear sections for projects, skills, and experience.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <a href="generator.php?template=Dev%20Portfolio" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="template-section" id="vip-templates">
        <div class="template-section-header">
            <span class="section-eyebrow">VIP Templates</span>
            <div>
                <h2 class="section-title">Unlock premium VIP designs</h2>
                <p class="section-subtitle">Exclusive portfolio templates crafted for higher-end brands and standout digital resumes.</p>
            </div>
        </div>

        <div class="template-grid">
            <article class="tm-card reveal" data-category="branding" data-rating="5.0">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img8.jpg" alt="Luxury Branding" class="tm-card-img">
                    <span class="port-cat-pill">Branding</span>
                    <span class="template-badge vip">VIP</span>
                    <div class="tm-card-actions">
                        <button class="tm-action-btn" aria-label="Favorite Luxury Branding"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Luxury Branding</h3>
                        <div class="tm-rating"><span>★</span> 5.0</div>
                    </div>
                    <p class="tm-card-desc">A striking VIP portfolio layout for premium agencies and personal brands.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price" style="display:flex;flex-direction:column;gap:1px;">
                            VIP
                            <span style="font-size:0.82rem;font-weight:800;background:linear-gradient(135deg,#E0143C,#2255D4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;letter-spacing:-.3px;">€29.99</span>
                        </span>
                        <a href="generator.php?template=Luxury%20Branding" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </article>

            <article class="tm-card reveal" data-category="design" data-rating="4.9">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img9.jpg" alt="3D Showcase" class="tm-card-img">
                    <span class="port-cat-pill">3D Art</span>
                    <span class="template-badge vip">VIP</span>
                    <div class="tm-card-actions">
                        <button class="tm-action-btn" aria-label="Favorite 3D Showcase"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">3D Showcase</h3>
                        <div class="tm-rating"><span>★</span> 4.9</div>
                    </div>
                    <p class="tm-card-desc">A premium showpiece template with immersive visuals and dynamic sections.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price" style="display:flex;flex-direction:column;gap:1px;">
                            VIP
                            <span style="font-size:0.82rem;font-weight:800;background:linear-gradient(135deg,#E0143C,#2255D4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;letter-spacing:-.3px;">€29.99</span>
                        </span>
                        <a href="generator.php?template=3D%20Showcase" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </article>

            <article class="tm-card reveal" data-category="motion" data-rating="4.8">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img6.jpg" alt="Motion Designer" class="tm-card-img">
                    <span class="port-cat-pill">Motion</span>
                    <span class="template-badge vip">VIP</span>
                    <div class="tm-card-actions">
                        <button class="tm-action-btn" aria-label="Favorite Motion Designer"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Motion Designer</h3>
                        <div class="tm-rating"><span>★</span> 4.8</div>
                    </div>
                    <p class="tm-card-desc">A bold creative template built for motion designers and digital portfolios.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price" style="display:flex;flex-direction:column;gap:1px;">
                            VIP
                            <span style="font-size:0.82rem;font-weight:800;background:linear-gradient(135deg,#E0143C,#2255D4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;letter-spacing:-.3px;">€29.99</span>
                        </span>
                        <a href="generator.php?template=Motion%20Designer" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <?php require 'includes/footer.php'; ?>
    <?php require 'includes/scripts.php'; ?>
    <script>
        // GSAP reveal animations (same as other pages)
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);
                gsap.utils.toArray('.reveal').forEach(el => {
                    gsap.fromTo(el, {opacity:0, y:30}, {opacity:1, y:0, duration:0.8, ease:'power3.out', scrollTrigger:{trigger:el, start:'top 90%'}});
                });
            }
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeFavorites();
        document.querySelectorAll('.tm-action-btn').forEach((btn, index) => {
            const card = btn.closest('.tm-card');
            const templateName = card.querySelector('.tm-card-title').textContent.trim();
            btn.setAttribute('data-template', templateName);
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleFavorite(this);
            });
        });
    });

    function initializeFavorites() {
        const favorites = JSON.parse(localStorage.getItem('portfolioFavorites')) || [];
        document.querySelectorAll('.tm-action-btn').forEach(btn => {
            const card = btn.closest('.tm-card');
            const templateName = card.querySelector('.tm-card-title').textContent.trim();
            if (favorites.includes(templateName)) {
                btn.classList.add('active');
                btn.querySelector('svg').style.fill = '#ef4444';
                btn.querySelector('svg').style.stroke = '#ef4444';
            }
        });
    }

    function toggleFavorite(btn) {
        const card = btn.closest('.tm-card');
        const templateName = card.querySelector('.tm-card-title').textContent.trim();
        const svg = btn.querySelector('svg');
        let favorites = JSON.parse(localStorage.getItem('portfolioFavorites')) || [];
        if (btn.classList.contains('active')) {
            btn.classList.remove('active');
            svg.style.fill = 'none';
            svg.style.stroke = 'currentColor';
            favorites = favorites.filter(fav => fav !== templateName);
        } else {
            btn.classList.add('active');
            svg.style.fill = '#ef4444';
            svg.style.stroke = '#ef4444';
            if (!favorites.includes(templateName)) favorites.push(templateName);
        }
        localStorage.setItem('portfolioFavorites', JSON.stringify(favorites));
        window.dispatchEvent(new Event('storage'));
    }
    </script>

    <!-- ═══ MODAL PAIEMENT VIP — une seule ligne à ajouter ═══ -->
    <?php require 'includes/vip_payment_modal.php'; ?>

</body>
</html>