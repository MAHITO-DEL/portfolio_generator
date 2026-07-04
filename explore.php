<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore premium portfolio templates with the same polished professional style as PortfolioGen.">
    <title>Explore — PortfolioGen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
</head>
<body class="page-category">

    <?php require 'includes/header.php'; ?>

    <main>
        <section class="template-page-hero">
            <span class="section-eyebrow">Explore</span>
            <h1 class="section-title">Explore <span class="gradient-text">Professional Templates</span></h1>
            <p class="section-subtitle">Browse a curated selection of polished portfolio templates with the same premium font, color system, and card style used across PortfolioGen.</p>
        </section>

        <section class="template-filters-section">
            <div class="template-search-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="template-search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" class="template-search-input" placeholder="Search templates...">
            </div>
            <div class="filter-group">
                <button class="filter-btn active">All</button>
                <button class="filter-btn">Business</button>
                <button class="filter-btn">Creative</button>
                <button class="filter-btn">Minimal</button>
            </div>
        </section>

        <section class="template-grid">
            <div class="tm-card" data-category="corporate">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img5.jpg" alt="Stellar" class="tm-card-img">
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
                        <a href="generator.php" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </div>

            <div class="tm-card" data-category="business">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img6.jpg" alt="Strata" class="tm-card-img">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn" aria-label="Favorite Strata"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Strata</h3>
                        <div class="tm-rating"><span>★</span> 4.8</div>
                    </div>
                    <p class="tm-card-desc">A refined corporate layout optimized for executives and consulting professionals.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <a href="generator.php" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </div>

            <div class="tm-card" data-category="corporate">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img7.jpg" alt="Story" class="tm-card-img">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn" aria-label="Favorite Story"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Story</h3>
                        <div class="tm-rating"><span>★</span> 4.7</div>
                    </div>
                    <p class="tm-card-desc">A polished gallery-style template designed for high-impact storytelling and case studies.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <a href="generator.php" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </div>

            <div class="tm-card" data-category="business">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img8.jpg" alt="Twenty" class="tm-card-img">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn" aria-label="Favorite Twenty"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Twenty</h3>
                        <div class="tm-rating"><span>★</span> 4.6</div>
                    </div>
                    <p class="tm-card-desc">A modern corporate portfolio layout with bold visuals and clean content structure.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <a href="generator.php" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php require 'includes/footer.php'; ?>
    <?php require 'includes/scripts.php'; ?>
    <?php require 'includes/chatbot.php'; ?>
    <?php require 'includes/modals.php'; ?>
    <!-- 
    À ajouter à la fin de explore.php, juste avant </body>
    Ce script rend les cœurs fonctionnels et les garde rouges
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