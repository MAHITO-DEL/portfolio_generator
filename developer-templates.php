<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore premium Developer portfolio templates.">
    <title>Developer Templates — PortfolioGen</title>

    <!-- Bootstrap EN PREMIER -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- style.css EN DERNIER -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
        
    <!-- GSAP CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
</head>
<body class="page-category">

    <!-- ===== Header partagé (lit $_SESSION automatiquement) ===== -->
    <?php require 'includes/header.php'; ?>

    <main>
        <section class="template-page-hero">
            <span class="section-eyebrow" style="color: #D4AF37;">Premium Collection</span>
            <h1 class="section-title">Developer <span class="gradient-text">Templates</span></h1>
            <p class="section-subtitle">Sleek, tech-focused designs for software engineers and developers.</p>
        </section>

        <section class="template-filters-section">
            <div class="template-search-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="template-search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" class="template-search-input" placeholder="Search developer templates...">
            </div>
            <div class="filter-group">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="frontend">Frontend</button>
                <button class="filter-btn" data-filter="backend">Backend</button>
                <button class="filter-btn" data-filter="full-stack">Full-Stack</button>
            </div>
        </section>

        <div class="template-grid">
            <!-- Template Card 1 -->
            <div class="tm-card" data-category="frontend">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img1.png" alt="Hyperspace" class="tm-card-img">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                        <button class="tm-action-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Hyperspace</h3>
                        <div class="tm-rating"><span>★</span> 4.9</div>
                    </div>
                    <p class="tm-card-desc">A vibrant, high-energy theme with sidebar navigation and fluid scrolling effects.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <a href="generator.php" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </div>

            <!-- Template Card 2 -->
            <div class="tm-card" data-category="full-stack">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img5.jpg" alt="Read Only" class="tm-card-img" style="filter: brightness(0.8);">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Read Only</h3>
                        <div class="tm-rating"><span>★</span> 4.7</div>
                    </div>
                    <p class="tm-card-desc">Minimalist, content-focused layout perfect for documenting deep technical projects.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <a href="generator.php" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </div>

            <!-- Template Card 3 -->
            <div class="tm-card" data-category="frontend">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img6.jpg" alt="Massively" class="tm-card-img" style="filter: contrast(1.2);">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Massively</h3>
                        <div class="tm-rating"><span>★</span> 4.8</div>
                    </div>
                    <p class="tm-card-desc">A text-heavy, narrative-driven theme for developers who like to tell the story behind the code.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Premium</span>
                        <a href="generator.php" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

     <?php require 'includes/footer.php'; ?>

    <script src="assets/js/script.js?v=<?php echo filemtime('assets/js/script.js'); ?>" defer></script>
    <!-- 
    À COPIER À LA FIN DE CHAQUE PAGE DE CATÉGORIE
    (juste avant </body>)
    
    Exemple de pages concernées:
    - category-business.php
    - category-creative.php
    - category-minimal.php
    - Ou toute autre page avec la même structure que explore.php
-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser les favoris au chargement
        initializeFavorites();
        
        // Ajouter événement aux cœurs (tous les tm-action-btn)
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
        
        // Parcourir tous les boutons cœurs et les activer si favoris
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
            // Retirer des favoris
            btn.classList.remove('active');
            svg.style.fill = 'none';
            svg.style.stroke = 'currentColor';
            favorites = favorites.filter(fav => fav !== templateName);
        } else {
            // Ajouter aux favoris
            btn.classList.add('active');
            svg.style.fill = '#ef4444';
            svg.style.stroke = '#ef4444';
            if (!favorites.includes(templateName)) {
                favorites.push(templateName);
            }
        }
        
        // Sauvegarder dans localStorage
        localStorage.setItem('portfolioFavorites', JSON.stringify(favorites));
        
        // Déclencher événement pour mettre à jour le compteur
        window.dispatchEvent(new Event('storage'));
    }
</script>
</body>
</html>
