<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Your saved portfolio templates - PortfolioGen.">
    <title>Saved Templates — PortfolioGen</title>

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
            <span class="section-eyebrow">Your Collection</span>
            <h1 class="section-title">Saved <span class="gradient-text">Templates</span></h1>
            <p class="section-subtitle">Your curated collection of professional portfolio templates. View and manage your saved designs.</p>
        </section>

        <div id="saved-templates-container" style="padding: 60px 20px;">
            <!-- Le contenu sera généré par JavaScript -->
        </div>
    </main>

    <?php require 'includes/footer.php'; ?>
    <?php require 'includes/scripts.php'; ?>
    <?php require 'includes/chatbot.php'; ?>
    <?php require 'includes/modals.php'; ?>

    <script>
        // Base de données des templates (même structure que explore.php)
        const allTemplates = [
            {
                name: 'Stellar',
                image: 'assets/img/portfolio-img5.jpg',
                rating: '4.9',
                description: 'A professional, well-structured theme for resumes and personal branding.',
                price: 'Free',
                category: 'corporate'
            },
            {
                name: 'Strata',
                image: 'assets/img/portfolio-img6.jpg',
                rating: '4.8',
                description: 'A refined corporate layout optimized for executives and consulting professionals.',
                price: 'Free',
                category: 'business'
            },
            {
                name: 'Story',
                image: 'assets/img/portfolio-img7.jpg',
                rating: '4.7',
                description: 'A polished gallery-style template designed for high-impact storytelling and case studies.',
                price: 'Free',
                category: 'corporate'
            },
            {
                name: 'Twenty',
                image: 'assets/img/portfolio-img8.jpg',
                rating: '4.6',
                description: 'A modern corporate portfolio layout with bold visuals and clean content structure.',
                price: 'Free',
                category: 'business'
            }
        ];

        document.addEventListener('DOMContentLoaded', function() {
            displaySavedTemplates();
        });

        function displaySavedTemplates() {
            const favorites = JSON.parse(localStorage.getItem('portfolioFavorites')) || [];
            const container = document.getElementById('saved-templates-container');
            
            if (favorites.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; color: var(--text-secondary); margin: 100px 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5; margin-bottom: 1rem;">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        <h3 style="color: var(--text-primary); margin: 1rem 0;">No Saved Templates Yet</h3>
                        <p style="margin-bottom: 2rem;">Start exploring and save your favorite portfolio templates.</p>
                        <a href="explore.php" class="tm-use-btn" style="display: inline-block;">Explore Templates</a>
                    </div>
                `;
                return;
            }
            
            // Créer la grille des templates sauvegardés
            let html = '<section class="template-grid">';
            
            favorites.forEach(favName => {
                const template = allTemplates.find(t => t.name === favName);
                if (template) {
                    html += `
                        <div class="tm-card">
                            <div class="tm-card-header">
                                <img src="${template.image}" alt="${template.name}" class="tm-card-img">
                                <div class="tm-card-actions">
                                    <button class="tm-action-btn active" onclick="removeFavorite('${template.name}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#ef4444" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="tm-card-body">
                                <div class="tm-card-top">
                                    <h3 class="tm-card-title">${template.name}</h3>
                                    <div class="tm-rating"><span>★</span> ${template.rating}</div>
                                </div>
                                <p class="tm-card-desc">${template.description}</p>
                                <div class="tm-card-footer">
                                    <span class="tm-price">${template.price}</span>
                                    <a href="generator.php" class="tm-use-btn">Use Template</a>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });
            
            html += '</section>';
            container.innerHTML = html;
        }

        function removeFavorite(templateName) {
            let favorites = JSON.parse(localStorage.getItem('portfolioFavorites')) || [];
            favorites = favorites.filter(fav => fav !== templateName);
            localStorage.setItem('portfolioFavorites', JSON.stringify(favorites));
            window.dispatchEvent(new Event('storage'));
            displaySavedTemplates();
        }

        // Mettre à jour quand les favoris changent
        window.addEventListener('storage', function() {
            displaySavedTemplates();
        });
    </script>
</body>
</html>