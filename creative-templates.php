<?php
/**
 * creative-templates.php
 * session_start() obligatoire pour que includes/header.php
 * puisse lire $_SESSION et afficher avatar ou boutons login.
 */
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore premium Creative portfolio templates.">
    <title>Creative Templates — PortfolioGen</title>

    <!-- Bootstrap EN PREMIER -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- style.css EN DERNIER -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
</head>
<body class="page-category">

    <!-- ===== Header partagé (lit $_SESSION automatiquement) ===== -->
    <?php require 'includes/header.php'; ?>

    <main>
        <section class="template-page-hero">
            <span class="section-eyebrow" style="color:#D4AF37;">Premium Collection</span>
            <h1 class="section-title">Creative <span class="gradient-text">Templates</span></h1>
            <p class="section-subtitle">Bold, artistic designs for designers, photographers, and creative professionals.</p>
        </section>

        <section class="template-filters-section">
            <div class="template-search-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="template-search-icon">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" class="template-search-input" placeholder="Search creative templates...">
            </div>
            <div class="filter-group">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="designer">Designer</button>
                <button class="filter-btn" data-filter="photographer">Photographer</button>
                <button class="filter-btn" data-filter="artist">Artist</button>
            </div>
        </section>

        <div class="template-grid">

            <!-- Template Card 1 -->
            <div class="tm-card" data-category="designer">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img2.jpg" alt="Forty" class="tm-card-img">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Forty</h3>
                        <div class="tm-rating"><span>★</span> 5.0</div>
                    </div>
                    <p class="tm-card-desc">A grid-based, visual-first theme with striking banner images and smooth transitions.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <?php if (isset($_SESSION['id_user'])): ?>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        <?php else: ?>
                            <a href="#" class="tm-use-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Use Template</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Template Card 2 -->
            <div class="tm-card" data-category="photographer">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img4.jpg" alt="Lens" class="tm-card-img" style="filter:saturate(1.5);">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Lens</h3>
                        <div class="tm-rating"><span>★</span> 4.9</div>
                    </div>
                    <p class="tm-card-desc">The ultimate photography theme featuring a full-screen gallery and elegant lightbox.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <?php if (isset($_SESSION['id_user'])): ?>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        <?php else: ?>
                            <a href="#" class="tm-use-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Use Template</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Template Card 3 -->
            <div class="tm-card" data-category="designer">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img6.jpg" alt="Multiverse" class="tm-card-img" style="filter:brightness(0.9);">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Multiverse</h3>
                        <div class="tm-rating"><span>★</span> 4.8</div>
                    </div>
                    <p class="tm-card-desc">A dark, immersive grid gallery designed for high-impact visual portfolios.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Premium</span>
                        <?php if (isset($_SESSION['id_user'])): ?>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        <?php else: ?>
                            <a href="#" class="tm-use-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Use Template</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- ===== Footer partagé ===== -->
    <?php require 'includes/footer.php'; ?>

    <!-- ===== Scripts JS communs + modals ===== -->
    <?php require 'includes/scripts.php'; ?>

    <!-- ===== Modals Auth ===== -->
    <?php require 'includes/modals.php'; ?>

    <!-- ===== Chatbot (connecté uniquement) ===== -->
    <?php require 'includes/chatbot.php'; ?>

    <!-- ===== Favoris ===== -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        initializeFavorites();

        document.querySelectorAll('.tm-action-btn').forEach(btn => {
            const card = btn.closest('.tm-card');
            const name = card.querySelector('.tm-card-title').textContent.trim();
            btn.setAttribute('data-template', name);
            btn.addEventListener('click', function (e) {
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
            const name = card.querySelector('.tm-card-title').textContent.trim();
            if (favorites.includes(name)) {
                btn.classList.add('active');
                btn.querySelector('svg').style.fill   = '#ef4444';
                btn.querySelector('svg').style.stroke = '#ef4444';
            }
        });
    }

    function toggleFavorite(btn) {
        const card = btn.closest('.tm-card');
        const name = card.querySelector('.tm-card-title').textContent.trim();
        const svg  = btn.querySelector('svg');
        let favorites = JSON.parse(localStorage.getItem('portfolioFavorites')) || [];

        if (btn.classList.contains('active')) {
            btn.classList.remove('active');
            svg.style.fill   = 'none';
            svg.style.stroke = 'currentColor';
            favorites = favorites.filter(f => f !== name);
        } else {
            btn.classList.add('active');
            svg.style.fill   = '#ef4444';
            svg.style.stroke = '#ef4444';
            if (!favorites.includes(name)) favorites.push(name);
        }

        localStorage.setItem('portfolioFavorites', JSON.stringify(favorites));
        window.dispatchEvent(new Event('storage'));
    }
    </script>

</body>
</html>
