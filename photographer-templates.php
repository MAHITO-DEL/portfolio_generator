<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore premium Photographer portfolio templates.">
    <title>Photographer Templates — PortfolioGen</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
    <!-- GSAP CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
</head>
<body class="page-category">

    <!-- ===== Fixed Header ===== -->
     <?php require 'includes/header.php'; ?>

    <main>
        <section class="template-page-hero">
            <span class="section-eyebrow" style="color: #D4AF37;">Premium Collection</span>
            <h1 class="section-title">Photographer <span class="gradient-text">Templates</span></h1>
            <p class="section-subtitle">Immersive, full-screen gallery templates to showcase your photographic masterpieces.</p>
        </section>

        <section class="template-filters-section">
            <div class="template-search-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="template-search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" class="template-search-input" placeholder="Search photographer templates...">
            </div>
            <div class="filter-group">
                <button class="filter-btn active">All</button>
                <button class="filter-btn">Landscape</button>
                <button class="filter-btn">Portrait</button>
            </div>
        </section>

        <div class="template-grid">
            <div class="tm-card" data-category="landscape">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img4.jpg" alt="Lens" class="tm-card-img" style="filter: saturate(1.5);">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Lens</h3>
                        <div class="tm-rating"><span>★</span> 4.9</div>
                    </div>
                    <p class="tm-card-desc">The ultimate photography theme featuring a full-screen gallery.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
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
