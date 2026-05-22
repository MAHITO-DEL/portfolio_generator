<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse all PortfolioGen templates, including Free and VIP collections.">
    <title>Templates — PortfolioGen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
</head>
<body class="page-templates">

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
                <a href="index.php" class="nav-link">Home</a>
                <a href="explore.php" class="nav-link">Explore</a>
                <a href="templates.php" class="nav-link active">Templates</a>
                <a href="#about" class="nav-link">About</a>
            </nav>

            <div class="auth-buttons">
            <?php if (isset($_SESSION['id_user'])): ?>
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
                <button class="btn btn-signin" data-bs-toggle="modal" data-bs-target="#registerModal">Sign In</button>
                <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <section class="template-hub-hero">
            <span class="section-eyebrow">Premium Template Hub</span>
            <h1 class="section-title">Explore the Best <span class="gradient-text">Portfolio Templates</span></h1>
            <p class="section-subtitle">Browse curated Free and VIP templates with premium preview cards, bold animations, and responsive product styling.</p>
            <div class="hero-actions">
                <a href="#free" class="btn-cta">Free Templates</a>
                <a href="#vip" class="btn-secondary">VIP Templates</a>
            </div>
        </section>

        <section class="template-section" id="free">
            <div class="template-section-header">
                <div>
                    <span class="section-eyebrow">Free Collection</span>
                    <h2 class="section-title">Free <span class="gradient-text">Templates</span></h2>
                    <p class="section-subtitle">Launch fast with no-cost templates designed for creative portfolios, developers, and architects.</p>
                </div>
                <a href="#vip" class="btn-secondary">Browse VIP</a>
            </div>

            <div class="template-card-grid">
                <div class="tm-card template-card" data-preview="portfolio_templates/architecture/html5up-phantom/index.html">
                    <div class="tm-card-header">
                        <img src="assets/img/portfolio-img3.jpg" alt="Phantom preview" class="tm-card-img">
                        <div class="template-card-badge badge-free">Free</div>
                        <button type="button" class="template-favorite" aria-label="Favorite Phantom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                        <div class="template-card-preview">
                            <button type="button" class="template-preview-btn" data-preview="portfolio_templates/architecture/html5up-phantom/index.html">Preview</button>
                        </div>
                    </div>
                    <div class="tm-card-body">
                        <div class="tm-card-top">
                            <h3 class="tm-card-title">Phantom</h3>
                            <div class="tm-rating"><span>★</span> 4.8</div>
                        </div>
                        <div class="template-card-meta">Architecture</div>
                        <p class="tm-card-desc">A bold, modern portfolio built for architects and design studios.</p>
                        <div class="tm-card-footer">
                            <span class="tm-price">Free</span>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        </div>
                    </div>
                </div>

                <div class="tm-card template-card" data-preview="portfolio_templates/minimal/html5up-aerial/index.html">
                    <div class="tm-card-header">
                        <img src="assets/img/portfolio-img6.jpg" alt="Aerial preview" class="tm-card-img">
                        <div class="template-card-badge badge-free">Free</div>
                        <button type="button" class="template-favorite" aria-label="Favorite Aerial">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                        <div class="template-card-preview">
                            <button type="button" class="template-preview-btn" data-preview="portfolio_templates/minimal/html5up-aerial/index.html">Preview</button>
                        </div>
                    </div>
                    <div class="tm-card-body">
                        <div class="tm-card-top">
                            <h3 class="tm-card-title">Aerial</h3>
                            <div class="tm-rating"><span>★</span> 4.7</div>
                        </div>
                        <div class="template-card-meta">Minimal</div>
                        <p class="tm-card-desc">A clean, airy layout for personal portfolios and modern resumes.</p>
                        <div class="tm-card-footer">
                            <span class="tm-price">Free</span>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        </div>
                    </div>
                </div>

                <div class="tm-card template-card" data-preview="portfolio_templates/creative/html5up-editorial/index.html">
                    <div class="tm-card-header">
                        <img src="assets/img/portfolio-img2.jpg" alt="Editorial preview" class="tm-card-img">
                        <div class="template-card-badge badge-free">Free</div>
                        <button type="button" class="template-favorite" aria-label="Favorite Editorial">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                        <div class="template-card-preview">
                            <button type="button" class="template-preview-btn" data-preview="portfolio_templates/creative/html5up-editorial/index.html">Preview</button>
                        </div>
                    </div>
                    <div class="tm-card-body">
                        <div class="tm-card-top">
                            <h3 class="tm-card-title">Editorial</h3>
                            <div class="tm-rating"><span>★</span> 4.9</div>
                        </div>
                        <div class="template-card-meta">Creative</div>
                        <p class="tm-card-desc">A magazine-style portfolio for writers, editors, and brand storytellers.</p>
                        <div class="tm-card-footer">
                            <span class="tm-price">Free</span>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        </div>
                    </div>
                </div>

                <div class="tm-card template-card" data-preview="portfolio_templates/developper/html5up-read-only/index.html">
                    <div class="tm-card-header">
                        <img src="assets/img/portfolio-img5.jpg" alt="Read Only preview" class="tm-card-img">
                        <div class="template-card-badge badge-free">Free</div>
                        <button type="button" class="template-favorite" aria-label="Favorite Read Only">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                        <div class="template-card-preview">
                            <button type="button" class="template-preview-btn" data-preview="portfolio_templates/developper/html5up-read-only/index.html">Preview</button>
                        </div>
                    </div>
                    <div class="tm-card-body">
                        <div class="tm-card-top">
                            <h3 class="tm-card-title">Read Only</h3>
                            <div class="tm-rating"><span>★</span> 4.6</div>
                        </div>
                        <div class="template-card-meta">Developer</div>
                        <p class="tm-card-desc">A polished developer portfolio layout with clean code and strong visuals.</p>
                        <div class="tm-card-footer">
                            <span class="tm-price">Free</span>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="template-section" id="vip">
            <div class="template-section-header">
                <div>
                    <span class="section-eyebrow">VIP Collection</span>
                    <h2 class="section-title">VIP <span class="gradient-text">Templates</span></h2>
                    <p class="section-subtitle">Unlock exclusive high-end portfolio themes made for founders, agencies, and premium creators.</p>
                </div>
                <a href="#free" class="btn-secondary">Explore Free</a>
            </div>

            <div class="template-card-grid">
                <div class="tm-card template-card" data-preview="portfolio_templates/architecture/html5up-spectral/index.html">
                    <div class="tm-card-header">
                        <img src="assets/img/portfolio-img1.png" alt="Spectral preview" class="tm-card-img">
                        <div class="template-card-badge badge-vip">VIP</div>
                        <button type="button" class="template-favorite" aria-label="Favorite Spectral">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                        <div class="template-card-preview">
                            <button type="button" class="template-preview-btn" data-preview="portfolio_templates/architecture/html5up-spectral/index.html">Preview</button>
                        </div>
                    </div>
                    <div class="tm-card-body">
                        <div class="tm-card-top">
                            <h3 class="tm-card-title">Spectral</h3>
                            <div class="tm-rating"><span>★</span> 4.9</div>
                        </div>
                        <div class="template-card-meta">Architecture</div>
                        <p class="tm-card-desc">A luxurious architectural portfolio with layered motion and immersive details.</p>
                        <div class="tm-card-footer">
                            <span class="tm-price">VIP</span>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        </div>
                    </div>
                </div>

                <div class="tm-card template-card" data-preview="portfolio_templates/creative/html5up-forty/index.html">
                    <div class="tm-card-header">
                        <img src="assets/img/portfolio-img2.jpg" alt="Forty preview" class="tm-card-img">
                        <div class="template-card-badge badge-vip">VIP</div>
                        <button type="button" class="template-favorite" aria-label="Favorite Forty">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                        <div class="template-card-preview">
                            <button type="button" class="template-preview-btn" data-preview="portfolio_templates/creative/html5up-forty/index.html">Preview</button>
                        </div>
                    </div>
                    <div class="tm-card-body">
                        <div class="tm-card-top">
                            <h3 class="tm-card-title">Forty</h3>
                            <div class="tm-rating"><span>★</span> 4.8</div>
                        </div>
                        <div class="template-card-meta">Creative</div>
                        <p class="tm-card-desc">A stylish editorial portfolio with split-screen layouts and refined motion.</p>
                        <div class="tm-card-footer">
                            <span class="tm-price">VIP</span>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        </div>
                    </div>
                </div>

                <div class="tm-card template-card" data-preview="portfolio_templates/professional/html5up-stellar/index.html">
                    <div class="tm-card-header">
                        <img src="assets/img/portfolio-img4.jpg" alt="Stellar preview" class="tm-card-img">
                        <div class="template-card-badge badge-vip">VIP</div>
                        <button type="button" class="template-favorite" aria-label="Favorite Stellar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                        <div class="template-card-preview">
                            <button type="button" class="template-preview-btn" data-preview="portfolio_templates/professional/html5up-stellar/index.html">Preview</button>
                        </div>
                    </div>
                    <div class="tm-card-body">
                        <div class="tm-card-top">
                            <h3 class="tm-card-title">Stellar</h3>
                            <div class="tm-rating"><span>★</span> 4.9</div>
                        </div>
                        <div class="template-card-meta">Professional</div>
                        <p class="tm-card-desc">A polished executive portfolio with structured sections and premium polish.</p>
                        <div class="tm-card-footer">
                            <span class="tm-price">VIP</span>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        </div>
                    </div>
                </div>

                <div class="tm-card template-card" data-preview="portfolio_templates/developper/html5up-massively/index.html">
                    <div class="tm-card-header">
                        <img src="assets/img/portfolio-img6.jpg" alt="Massively preview" class="tm-card-img">
                        <div class="template-card-badge badge-vip">VIP</div>
                        <button type="button" class="template-favorite" aria-label="Favorite Massively">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                        <div class="template-card-preview">
                            <button type="button" class="template-preview-btn" data-preview="portfolio_templates/developper/html5up-massively/index.html">Preview</button>
                        </div>
                    </div>
                    <div class="tm-card-body">
                        <div class="tm-card-top">
                            <h3 class="tm-card-title">Massively</h3>
                            <div class="tm-rating"><span>★</span> 4.7</div>
                        </div>
                        <div class="template-card-meta">Developer</div>
                        <p class="tm-card-desc">A VIP developer portfolio with bold statements and dark, dramatic panels.</p>
                        <div class="tm-card-footer">
                            <span class="tm-price">VIP</span>
                            <a href="generator.php" class="tm-use-btn">Use Template</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer" style="padding: 60px 2rem; background: var(--bg-dark); border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="footer-container" style="max-width: 1400px; margin: 0 auto;">
            <div class="footer-grid" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 4rem;">
                <div class="footer-brand">
                    <a href="index.php" class="logo" style="margin-bottom: 20px; display: inline-block;">Portfolio<span>Gen</span></a>
                    <p class="footer-desc" style="color: var(--text-muted); line-height: 1.6;">Build polished portfolios fast with free and VIP templates designed for speed and impact.</p>
                </div>
                <div class="footer-nav" style="display: flex; flex-direction: column; gap: 12px;">
                    <h4 class="footer-title" style="color: #fff; margin-bottom: 8px;">Platform</h4>
                    <a href="explore.php" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">Explore</a>
                    <a href="templates.php" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">Templates</a>
                    <a href="#about" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">About</a>
                </div>
                <div class="footer-nav" style="display: flex; flex-direction: column; gap: 12px;">
                    <h4 class="footer-title" style="color: #fff; margin-bottom: 8px;">Company</h4>
                    <a href="#" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">About Us</a>
                    <a href="#" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">Careers</a>
                    <a href="#" class="footer-link" style="color: var(--text-muted); text-decoration: none; transition: color 0.3s;">Contact</a>
                </div>
                <div class="footer-nav">
                    <h4 class="footer-title" style="color: #fff; margin-bottom: 16px;">Newsletter</h4>
                    <p class="footer-desc" style="color: var(--text-muted); margin-bottom: 16px; font-size: 0.9rem;">Subscribe to updates, new templates, and special VIP launches.</p>
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
