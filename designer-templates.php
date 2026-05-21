<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore premium Designer portfolio templates.">
    <title>Designer Templates — PortfolioGen</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
    <!-- GSAP CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
</head>
<body class="page-category">

    <!-- ===== Fixed Header ===== -->
    <header class="site-header scrolled" id="header">
        <div class="header-container">
            <a href="index.php" class="logo">Portfolio<span>Gen</span></a>

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
                <a href="index.php" class="nav-link">Home</a>
                <a href="#" class="nav-link active">Explore</a>
                <a href="#" class="nav-link">Templates</a>
                <a href="#" class="nav-link">About</a>
            </nav>

            <div class="auth-buttons">
                <a href="#" class="btn btn-signin" id="btn-signin">Sign In</a>
                <a href="#" class="btn btn-login" id="btn-login">Login</a>
            </div>
        </div>
    </header>

    <main>
        <section class="template-page-hero">
            <span class="section-eyebrow" style="color: #D4AF37;">Premium Collection</span>
            <h1 class="section-title">Designer <span class="gradient-text">Templates</span></h1>
            <p class="section-subtitle">Visual-centric designs with sophisticated layouts for UI/UX and Graphic Designers.</p>
        </section>

        <section class="template-filters-section">
            <div class="template-search-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="template-search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" class="template-search-input" placeholder="Search designer templates...">
            </div>
            <div class="filter-group">
                <button class="filter-btn active">All</button>
                <button class="filter-btn">UI/UX</button>
                <button class="filter-btn">Graphic</button>
            </div>
        </section>

        <div class="template-grid">
            <div class="tm-card" data-category="ui/ux">
                <div class="tm-card-header">
                    <img src="assets/img/portfolio-img2.jpg" alt="Forty" class="tm-card-img">
                    <div class="tm-card-actions">
                        <button class="tm-action-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
                    </div>
                </div>
                <div class="tm-card-body">
                    <div class="tm-card-top">
                        <h3 class="tm-card-title">Forty</h3>
                        <div class="tm-rating"><span>★</span> 5.0</div>
                    </div>
                    <p class="tm-card-desc">Bold and responsive grid layout for professional designers.</p>
                    <div class="tm-card-footer">
                        <span class="tm-price">Free</span>
                        <a href="generator.php" class="tm-use-btn">Use Template</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="site-footer" style="padding: 60px 2rem; background: var(--bg-dark); border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="footer-container" style="max-width: 1400px; margin: 0 auto;">
            <div class="footer-grid" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 4rem;">
                <div class="footer-brand">
                    <a href="index.php" class="logo" style="margin-bottom: 20px; display: inline-block;">Portfolio<span>Gen</span></a>
                    <p class="footer-desc" style="color: var(--text-muted); line-height: 1.6;">Empowering creators to build stunning portfolios without the complexity of coding. Your professional journey starts here.</p>
                </div>
                <div class="footer-nav" style="display: flex; flex-direction: column; gap: 12px;">
                    <h4 class="footer-title" style="color: #fff; margin-bottom: 8px;">Platform</h4>
                    <a href="#" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">Explore</a>
                    <a href="#" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">Templates</a>
                    <a href="#" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">Showcase</a>
                </div>
                <div class="footer-nav" style="display: flex; flex-direction: column; gap: 12px;">
                    <h4 class="footer-title" style="color: #fff; margin-bottom: 8px;">Company</h4>
                    <a href="#" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">About Us</a>
                    <a href="#" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">Careers</a>
                    <a href="#" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">Contact</a>
                </div>
                <div class="footer-nav">
                    <h4 class="footer-title" style="color: #fff; margin-bottom: 16px;">Newsletter</h4>
                    <p class="footer-desc" style="color: var(--text-muted); margin-bottom: 16px; font-size: 0.9rem;">Subscribe to get the latest updates and templates.</p>
                </div>
            </div>
            <div class="footer-bottom" style="margin-top: 60px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; color: var(--text-muted); font-size: 0.85rem;">
                <p class="copyright">&copy; 2026 PortfolioGen. All rights reserved.</p>
                <div class="footer-legal" style="display: flex; gap: 24px;">
                    <a href="#" class="legal-link" style="color: inherit; text-decoration: none;">Privacy Policy</a>
                    <a href="#" class="legal-link" style="color: inherit; text-decoration: none;">Terms of Service</a>
                    <a href="#" class="legal-link" style="color: inherit; text-decoration: none;">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js?v=<?php echo filemtime('assets/js/script.js'); ?>" defer></script>
</body>
</html>
