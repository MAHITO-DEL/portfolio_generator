<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PortfolioGen — Generate a modern, animated portfolio in seconds. Build your professional presence effortlessly.">
    <title>PortfolioGen — Create Your Portfolio Experience</title>

    <!-- Bootstrap EN PREMIER -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- style.css EN DERNIER -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
</head>
<body class="page-home">

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
                <a href="index.php" class="nav-link active">Home</a>
                <a href="#" class="nav-link">Explore</a>
                <a href="#" class="nav-link">Templates</a>
                <a href="#" class="nav-link">About</a>
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

    <!-- ===== Hero Section ===== -->
    <section class="hero" id="hero">
        <div class="hero-bg"></div>
        <div class="hero-grid"></div>
        <div class="hero-noise"></div>
        <div class="hero-orb hero-orb--purple" id="orb-purple"></div>
        <div class="hero-orb hero-orb--blue"   id="orb-blue"></div>
        <div class="hero-orb hero-orb--cyan"   id="orb-cyan"></div>

        <div class="hero-content">
            <div class="hero-text" id="hero-text">
                <h1 class="hero-title" id="hero-title"></h1>
                <p class="hero-subtitle" id="hero-subtitle">
                    Generate a modern, animated portfolio in seconds.
                    Showcase your work with stunning templates, fluid animations,
                    and zero coding required.
                </p>
                <div class="hero-actions" id="hero-actions">
                    <?php if (isset($_SESSION['id_user'])): ?>
                        <!-- Connecté → accès direct -->
                        <a href="generator.php" class="btn-cta" id="btn-cta">
                            <span>Get Started</span>
                            <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    <?php else: ?>
                        <!-- Non connecté → ouvre le modal login -->
                        <button class="btn-cta" id="btn-cta"
                            data-bs-toggle="modal" data-bs-target="#loginModal">
                            <span>Get Started</span>
                            <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>
                    <?php endif; ?>
                    <a href="#" class="btn-secondary" id="btn-demo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                        </svg>
                        Watch Demo
                    </a>
                </div>
                <div class="hero-stats" id="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number" id="stat-portfolios">0</span>
                        <span class="stat-label">Portfolios Created</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" id="stat-templates">0</span>
                        <span class="stat-label">Templates</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" id="stat-users">0</span>
                        <span class="stat-label">Active Users</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual" id="hero-visual">
                <div class="deco-ring deco-ring--lg"></div>
                <div class="deco-ring deco-ring--sm"></div>
                <div class="deco-dot deco-dot--1"></div>
                <div class="deco-dot deco-dot--2"></div>
                <div class="deco-dot deco-dot--3"></div>
                <div class="float-card float-card--main" id="float-main">
                    <div class="card-header-bar">
                        <span class="dot-red"></span><span class="dot-yellow"></span><span class="dot-green"></span>
                    </div>
                    <div class="card-body">
                        <div class="card-avatar">SF</div>
                        <div class="card-title-text">Sabir Fatima</div>
                        <div class="card-role">Full-Stack Developer</div>
                        <div class="card-skill-tags">
                            <span class="card-skill-tag">React</span>
                            <span class="card-skill-tag">Node.js</span>
                            <span class="card-skill-tag">Php</span>
                        </div>
                        <div class="card-bar-group">
                            <div class="card-bar"><div class="card-bar-fill card-bar-fill--purple" data-w="85%"></div></div>
                            <div class="card-bar"><div class="card-bar-fill card-bar-fill--blue"   data-w="70%"></div></div>
                            <div class="card-bar"><div class="card-bar-fill card-bar-fill--cyan"   data-w="60%"></div></div>
                        </div>
                    </div>
                </div>
                <div class="float-card float-card--sm1" id="float-sm1">
                    <div class="mini-card-inner">
                        <span class="mini-card-label">Views this week</span>
                        <span class="mini-card-value" id="mini-views">0</span>
                        <div class="mini-card-chart" id="mini-chart"></div>
                    </div>
                </div>
                <div class="float-card float-card--sm2" id="float-sm2">
                    <div class="code-preview" id="code-preview">
                        <span class="code-keyword">const</span> portfolio = <span class="code-func">generate</span>({<br>
                        &nbsp;&nbsp;name: <span class="code-string">"Sabir Fatima"</span>,<br>
                        &nbsp;&nbsp;template: <span class="code-string">"modern"</span>,<br>
                        &nbsp;&nbsp;animate: <span class="code-keyword">true</span><br>
                        });
                    </div>
                </div>
                <div class="float-card float-card--badge" id="float-badge">
                    <div class="badge-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div class="badge-text-group">
                        <span class="badge-text-main">Deployed!</span>
                        <span class="badge-text-sub">portfolio-jd.dev</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Portfolio Showcase Section ===== -->
    <section class="showcase" id="showcase">
        <div class="showcase-glow showcase-glow--left"></div>
        <div class="showcase-glow showcase-glow--right"></div>
        <div class="showcase-header" id="showcase-header">
            <span class="section-eyebrow">Top Rated</span>
            <h2 class="section-title">Featured <span class="gradient-text">Portfolios</span></h2>
            <p class="section-subtitle">Discover stunning portfolios built with PortfolioGen. Get inspired and create your own.</p>
        </div>
        <div class="showcase-layout" id="showcase-layout">
            <div class="sc-col sc-col--a">
                <div class="sc-card sc-card--tall sc-card--blue" data-reveal="left" id="sc-card-1"
                     data-title="Salma Cherradi" data-category="Full-Stack Developer"
                     data-template-path="portfolio_templates/developper/html5up-hyperspace/index.html">
                    <img src="assets/img/portfolio-img1.png" alt="Creative Portfolio" class="sc-card-img">
                    <div class="sc-card-overlay"></div>
                    <div class="sc-card-content">
                        <div class="sc-card-category">Full-Stack Developer</div>
                        <h3 class="sc-card-title">Salma Cherradi</h3>
                        <div class="sc-card-btn">View Preview</div>
                    </div>
                    <div class="sc-card-badge">Featured</div>
                </div>
                <div class="sc-card sc-card--red" data-reveal="left" id="sc-card-2"
                     data-title="Maya Torres" data-category="UI/UX Designer"
                     data-template-path="portfolio_templates/creative/html5up-forty/index.html">
                    <img src="assets/img/portfolio-img2.jpg" alt="Architectural Portfolio" class="sc-card-img">
                    <div class="sc-card-overlay"></div>
                    <div class="sc-card-content">
                        <div class="sc-card-category">UI/UX Designer</div>
                        <h3 class="sc-card-title">Maya Torres</h3>
                        <div class="sc-card-btn">View Preview</div>
                    </div>
                </div>
            </div>
            <div class="sc-col sc-col--b">
                <div class="sc-card sc-card--blue" data-reveal="up" id="sc-card-3"
                     data-title="Liam Andersson" data-category="Architect"
                     data-template-path="portfolio_templates/architecture/html5up-phantom/index.html">
                    <img src="assets/img/portfolio-img3.jpg" alt="Minimal Portfolio" class="sc-card-img" style="filter:hue-rotate(45deg)">
                    <div class="sc-card-overlay"></div>
                    <div class="sc-card-content">
                        <div class="sc-card-category">Architect</div>
                        <h3 class="sc-card-title">Liam Andersson</h3>
                        <div class="sc-card-btn">View Preview</div>
                    </div>
                    <div class="sc-card-badge">New</div>
                </div>
                <div class="sc-card sc-card--tall sc-card--red" data-reveal="up" id="sc-card-4"
                     data-title="Elena Rossi" data-category="Photographer"
                     data-template-path="portfolio_templates/creative/html5up-lens/index.html">
                    <img src="assets/img/portfolio-img4.jpg" alt="Photography Portfolio" class="sc-card-img" style="filter:saturate(1.5)">
                    <div class="sc-card-overlay"></div>
                    <div class="sc-card-content">
                        <div class="sc-card-category">Photographer</div>
                        <h3 class="sc-card-title">Elena Rossi</h3>
                        <div class="sc-card-btn">View Preview</div>
                    </div>
                </div>
            </div>
            <div class="sc-col sc-col--c">
                <div class="sc-card sc-card--red" data-reveal="right" id="sc-card-5"
                     data-title="David Chen" data-category="Software Developer"
                     data-template-path="portfolio_templates/developper/html5up-read-only/index.html">
                    <img src="assets/img/portfolio-img5.jpg" alt="Developer Portfolio" class="sc-card-img" style="filter:brightness(0.8)">
                    <div class="sc-card-overlay"></div>
                    <div class="sc-card-content">
                        <div class="sc-card-category">Software Developer</div>
                        <h3 class="sc-card-title">David Chen</h3>
                        <div class="sc-card-btn">View Preview</div>
                    </div>
                </div>
                <div class="sc-card sc-card--blue" data-reveal="right" id="sc-card-6"
                     data-title="Sarah Jenkins" data-category="Motion Designer"
                     data-template-path="portfolio_templates/creative/html5up-massively/index.html">
                    <img src="assets/img/portfolio-img6.jpg" alt="Design Portfolio" class="sc-card-img" style="filter:contrast(1.2)">
                    <div class="sc-card-overlay"></div>
                    <div class="sc-card-content">
                        <div class="sc-card-category">Motion Designer</div>
                        <h3 class="sc-card-title">Sarah Jenkins</h3>
                        <div class="sc-card-btn">View Preview</div>
                    </div>
                    <div class="sc-card-badge">Hot</div>
                </div>
            </div>
        </div>
        <div class="showcase-cta" id="showcase-cta">
            <?php if (isset($_SESSION['id_user'])): ?>
                <a href="generator.php" class="btn-cta">
                    <span>Explore All Templates</span>
                    <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            <?php else: ?>
                <button class="btn-cta" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <span>Explore All Templates</span>
                    <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
            <?php endif; ?>
        </div>
    </section>

    <!-- ===== Categories Section ===== -->
    <section class="categories" id="categories">
        <div class="categories-bg">
            <div class="category-blob category-blob--1" id="blob-1"></div>
            <div class="category-blob category-blob--2" id="blob-2"></div>
        </div>
        <div class="categories-container">
            <div class="categories-header" id="categories-header">
                <span class="section-eyebrow">Explore Styles</span>
                <h2 class="section-title">Portfolio <span class="gradient-text">Categories</span></h2>
                <p class="section-subtitle">Choose from a variety of professionally designed themes for every niche.</p>
            </div>
            <div class="categories-grid" id="categories-grid">
                <a href="<?= isset($_SESSION['id_user']) ? 'minimal-templates.php' : '#' ?>"
                   class="category-card category--minimal"
                   <?= !isset($_SESSION['id_user']) ? 'data-bs-toggle="modal" data-bs-target="#loginModal"' : '' ?>>
                    <div class="category-card-bg" style="background-image:url('assets/img/portfolio-img3.jpg');background-size:cover;opacity:0.4;"></div>
                    <div class="category-content">
                        <div class="category-icon-wrapper"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg></div>
                        <h3 class="category-title">Minimal</h3>
                        <p class="category-desc">Clean, white-space driven layouts that put your work front and center.</p>
                    </div>
                </a>
                <a href="<?= isset($_SESSION['id_user']) ? 'creative-templates.php' : '#' ?>"
                   class="category-card category--creative"
                   <?= !isset($_SESSION['id_user']) ? 'data-bs-toggle="modal" data-bs-target="#loginModal"' : '' ?>>
                    <div class="category-card-bg" style="background-image:url('assets/img/portfolio-img2.jpg');background-size:cover;opacity:0.4;"></div>
                    <div class="category-content">
                        <div class="category-icon-wrapper"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/></svg></div>
                        <h3 class="category-title">Creative</h3>
                        <p class="category-desc">Bold colors and unique layouts for artists, photographers, and makers.</p>
                    </div>
                </a>
                <a href="<?= isset($_SESSION['id_user']) ? 'developer-templates.php' : '#' ?>"
                   class="category-card category--developer"
                   <?= !isset($_SESSION['id_user']) ? 'data-bs-toggle="modal" data-bs-target="#loginModal"' : '' ?>>
                    <div class="category-card-bg" style="background-image:url('assets/img/portfolio-img1.png');background-size:cover;opacity:0.4;"></div>
                    <div class="category-content">
                        <div class="category-icon-wrapper"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/><line x1="14" y1="22" x2="10" y2="2"/></svg></div>
                        <h3 class="category-title">Developer</h3>
                        <p class="category-desc">Tech-focused themes with code integration and sleek modern UI.</p>
                    </div>
                </a>
                <a href="<?= isset($_SESSION['id_user']) ? 'professional-templates.php' : '#' ?>"
                   class="category-card category--professional"
                   <?= !isset($_SESSION['id_user']) ? 'data-bs-toggle="modal" data-bs-target="#loginModal"' : '' ?>>
                    <div class="category-card-bg" style="background-image:url('assets/img/portfolio-img5.jpg');background-size:cover;opacity:0.4;"></div>
                    <div class="category-content">
                        <div class="category-icon-wrapper"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <h3 class="category-title">Professional</h3>
                        <p class="category-desc">Sophisticated themes for corporate and high-end freelance use.</p>
                    </div>
                </a>
                <a href="<?= isset($_SESSION['id_user']) ? 'architecture-templates.php' : '#' ?>"
                   class="category-card category--architecture"
                   <?= !isset($_SESSION['id_user']) ? 'data-bs-toggle="modal" data-bs-target="#loginModal"' : '' ?>>
                    <div class="category-card-bg" style="background-image:url('assets/img/portfolio-img3.jpg');background-size:cover;opacity:0.4;"></div>
                    <div class="category-content">
                        <div class="category-icon-wrapper"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M19 21v-4"/><path d="M15 21v-10"/><path d="M11 21v-14"/><path d="M7 21v-18"/><path d="M12 3l8 4.5V21"/><path d="M12 3L4 7.5V21"/></svg></div>
                        <h3 class="category-title">Architecture</h3>
                        <p class="category-desc">Structural lines and geometric beauty for modern architectural studios.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== About Section ===== -->
    <section class="about" id="about">
        <div class="about-container">
            <div class="about-content" id="about-content">
                <span class="about-eyebrow" data-reveal="up">Our Story</span>
                <h2 class="about-title" data-reveal="up">We redefine the <span class="gradient-text">Portfolio Experience</span></h2>
                <p class="about-text" data-reveal="up">PortfolioGen was born out of a desire to bridge the gap between complex development and stunning visual storytelling.</p>
                <div class="about-features">
                    <div class="about-feature-item" data-reveal="up">
                        <div class="about-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
                        <h3 class="about-feature-title">Pure Simplicity</h3>
                        <p class="about-feature-desc">Generate complex, animated layouts with a single click.</p>
                    </div>
                    <div class="about-feature-item" data-reveal="up">
                        <div class="about-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/></svg></div>
                        <h3 class="about-feature-title">Boundless Creativity</h3>
                        <p class="about-feature-desc">Interactive themes that breathe life into your professional narrative.</p>
                    </div>
                </div>
            </div>
            <div class="about-visual" id="about-visual">
                <div class="about-graphic" data-reveal="scale">
                    <div class="about-logo-icon">PG</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Testimonials Section ===== -->
    <section class="testimonials" id="testimonials">
        <div class="testimonials-header">
            <span class="section-eyebrow">Testimonials</span>
            <h2 class="section-title">What our <span class="gradient-text">Users Say</span></h2>
            <p class="section-subtitle">Join thousands of creatives who have elevated their professional presence.</p>
        </div>
        <div class="testimonials-container" id="testimonials-container">
            <div class="testimonials-track" id="testimonials-track">
                <div class="testimonial-card">
                    <div class="testimonial-rating"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                    <p class="testimonial-text">"PortfolioGen completely changed how I showcase my work. The animations are so smooth."</p>
                    <div class="testimonial-user">
                        <div class="user-avatar">JD</div>
                        <div class="user-info"><span class="user-name">John Doe</span><span class="user-role">Designer</span></div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-rating"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                    <p class="testimonial-text">"The glassmorphism design is stunning. I've received so many compliments."</p>
                    <div class="testimonial-user">
                        <div class="user-avatar">SS</div>
                        <div class="user-info"><span class="user-name">Sarah Smith</span><span class="user-role">Product Manager</span></div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-rating"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                    <p class="testimonial-text">"Finally, a portfolio builder that actually understands modern aesthetics."</p>
                    <div class="testimonial-user">
                        <div class="user-avatar">MW</div>
                        <div class="user-info"><span class="user-name">Michael Wong</span><span class="user-role">Developer</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Page Scripts ===== -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const boot = () => {
            if (typeof gsap === 'undefined') return setTimeout(boot, 50);
            initHeroAnimations();
            initShowcase();
            initCategories();
            initAbout();
            initTestimonials();
        };
        boot();

        function initHeroAnimations() {
            const titleEl = document.getElementById('hero-title');
            titleEl.innerHTML = '<span class="word" style="display:inline-block;opacity:0;transform:translateY(20px)">Create</span> <span class="word" style="display:inline-block;opacity:0;transform:translateY(20px)">Your</span> <span class="word gradient-text" style="display:inline-block;opacity:0;transform:translateY(20px)">Portfolio</span> <span class="word" style="display:inline-block;opacity:0;transform:translateY(20px)">Experience</span>';
            const tl = gsap.timeline();
            tl.to('.word', { opacity:1, y:0, stagger:0.1, duration:0.8, ease:'power3.out' })
              .to(['#hero-subtitle','#hero-actions','#hero-stats'], { opacity:1, y:0, stagger:0.2, duration:0.8 }, '-=0.4');
            gsap.to('#float-main',  { y:'+=15', duration:4,   repeat:-1, yoyo:true, ease:'sine.inOut' });
            gsap.to('#float-sm1',   { y:'-=10', duration:3.5, repeat:-1, yoyo:true, ease:'sine.inOut' });
            gsap.to('#float-sm2',   { y:'+=12', duration:5,   repeat:-1, yoyo:true, ease:'sine.inOut' });
            gsap.to('#float-badge', { y:'-=8',  duration:3,   repeat:-1, yoyo:true, ease:'sine.inOut' });
            const chart = document.getElementById('mini-chart');
            [14,22,18,28,20,32,26].forEach(h => {
                const bar = document.createElement('div');
                bar.className = 'mini-bar';
                bar.style.cssText = 'width:4px;background:var(--blue-glow);border-radius:2px;height:0';
                chart.appendChild(bar);
                gsap.to(bar, { height:h, duration:1, delay:1, ease:'power2.out' });
            });
        }

        function initShowcase() {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        gsap.fromTo(e.target, { opacity:0, y:40 }, { opacity:1, y:0, duration:0.8 });
                        observer.unobserve(e.target);
                    }
                });
            }, { threshold:0.1 });
            document.querySelectorAll('.sc-card').forEach(c => observer.observe(c));
        }

        function initCategories() {
            const grid  = document.querySelector('.categories-grid');
            const cards = document.querySelectorAll('.category-card');
            if (!grid) return;
            cards.forEach(card => {
                card.addEventListener('mousemove', e => {
                    const rect = card.getBoundingClientRect();
                    card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
                    card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
                });
            });
            grid.addEventListener('mousemove', e => {
                const mx = e.clientX, my = e.clientY;
                cards.forEach(card => {
                    const r = card.getBoundingClientRect();
                    if (mx>=r.left && mx<=r.right && my>=r.top && my<=r.bottom) {
                        card.style.transform = 'translateY(-15px) scale(1.02)';
                        card.style.zIndex = 10;
                    } else {
                        const dx = mx-(r.left+r.width/2), dy = my-(r.top+r.height/2);
                        card.style.transform = `scale(0.95) rotateX(${Math.max(-20,Math.min(20,-dy*0.05))}deg) rotateY(${Math.max(-20,Math.min(20,dx*0.05))}deg)`;
                        card.style.zIndex = 1;
                    }
                });
            });
            grid.addEventListener('mouseleave', () => {
                cards.forEach(card => { card.style.transform=''; card.style.zIndex=''; });
            });
        }

        function initAbout() {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        gsap.fromTo(e.target, { opacity:0, y:30 }, { opacity:1, y:0, duration:1 });
                        observer.unobserve(e.target);
                    }
                });
            });
            document.querySelectorAll('#about [data-reveal]').forEach(r => observer.observe(r));
        }

        function initTestimonials() {
            const track = document.getElementById('testimonials-track');
            Array.from(track.children).map(c => c.cloneNode(true)).forEach(c => track.appendChild(c));
            let xPos = 0;
            (function animate() {
                xPos -= 0.5;
                if (Math.abs(xPos) >= track.scrollWidth/2) xPos = 0;
                gsap.set(track, { x:xPos });
                requestAnimationFrame(animate);
            })();
        }
    });
    </script>

    <!-- ===== Footer ===== -->
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

    <!-- script.js -->
    <script src="assets/js/script.js?v=<?php echo filemtime('assets/js/script.js'); ?>" defer></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ================================================
         CHATBOT (visible uniquement si connecté)
    ================================================ -->
    <?php if (isset($_SESSION['id_user'])): ?>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <button class="chatbot-fab" id="chatbot-fab" onclick="toggleChatbot()"
            title="Assistant Portfolio" aria-label="Ouvrir le chatbot">
        <i class="ti ti-message-chatbot"></i>
    </button>

    <div class="chatbot-window" id="chatbot-window">
        <div class="chat-header">
            <div class="avatar"><i class="ti ti-robot"></i></div>
            <div class="header-info">
                <h2>Portfolio Assistant</h2>
                <p>En ligne · répond en quelques secondes</p>
            </div>
            <button class="chatbot-close" onclick="toggleChatbot()" title="Fermer" aria-label="Fermer">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="chat-window" id="chat-window">
            <div class="msg bot">
                <div class="msg-avatar"><i class="ti ti-robot"></i></div>
                <div>
                    <div class="bubble">
                        Bonjour <?= htmlspecialchars($_SESSION['nom']) ?> ! 👋 Je suis l'assistant de ce portfolio.
                        Je peux vous parler des projets, des compétences ou vous aider à prendre contact.
                    </div>
                    <div class="quick-replies">
                        <button class="qr-btn" onclick="sendQuick('Voir les projets')">🚀 Voir les projets</button>
                        <button class="qr-btn" onclick="sendQuick('Compétences techniques')">💻 Compétences</button>
                        <button class="qr-btn" onclick="sendQuick('Me contacter')">✉️ Contact</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-input-area">
            <button class="action-btn" title="Emoji" aria-label="Emoji"><i class="ti ti-mood-smile"></i></button>
            <input type="text" id="chat-input" placeholder="Écrivez un message..." autocomplete="off"/>
            <button class="send-btn" id="send-btn" aria-label="Envoyer"><i class="ti ti-send"></i></button>
        </div>
    </div>

    <script>
    function toggleChatbot() {
        const win = document.getElementById('chatbot-window');
        const fab = document.getElementById('chatbot-fab');
        const isOpen = win.classList.contains('open');
        win.classList.toggle('open');
        fab.classList.toggle('open');
        fab.innerHTML = isOpen ? '<i class="ti ti-message-chatbot"></i>' : '<i class="ti ti-x"></i>';
        if (!isOpen) setTimeout(() => document.getElementById('chat-input').focus(), 300);
    }
    </script>
    <script>const _originalFetch = window.fetch;</script>
    <script src="chatbot/chatbot.js"></script>
    <script>
    window.fetch = function(url, options) {
        if (url === 'bot.php') url = 'chatbot/bot.php';
        return _originalFetch(url, options);
    };
    </script>
    <?php endif; ?>

    <!-- ================================================
         MODALS (toujours présents pour les visiteurs)
    ================================================ -->
    <?php if (!isset($_SESSION['id_user'])): ?>

    <!-- MODAL LOGIN -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div style="color:#fff;text-align:center;padding:1.6rem;">
            <i class="bi bi-person-lock" style="font-size:2rem;display:block;margin-bottom:.4rem;"></i>
            <h5 style="margin:0;font-weight:700;">Connexion</h5>
            <p style="margin:.3rem 0 0;opacity:.85;font-size:.85rem;">Accédez à votre espace Portfolio</p>
          </div>
          <div class="modal-body p-4">
            <?php if (!empty($_SESSION['login_erreur'])): ?>
              <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($_SESSION['login_erreur']) ?>
              </div>
              <?php unset($_SESSION['login_erreur']); ?>
            <?php endif; ?>
            <?php if (!empty($_SESSION['msg_succes'])): ?>
              <div class="alert alert-success d-flex align-items-center gap-2 py-2">
                <i class="bi bi-check-circle-fill"></i>
                <?= htmlspecialchars($_SESSION['msg_succes']) ?>
              </div>
              <?php unset($_SESSION['msg_succes']); ?>
            <?php endif; ?>
            <form method="POST" action="auth2/login.php">
              <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                  <input type="email" name="email" class="form-control" placeholder="email" required>
                </div>
              </div>
              <div class="mb-2">
                <label class="form-label fw-semibold">Mot de passe</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock"></i></span>
                  <input type="password" name="password" id="loginPwd" class="form-control" placeholder="password" required>
                  <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('loginPwd','loginPwdIcon')">
                    <i class="bi bi-eye" id="loginPwdIcon"></i>
                  </button>
                </div>
              </div>
              <div class="text-end mb-4">
                <a href="#" style="font-size:.85rem;font-weight:600;text-decoration:none;"
                   data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotModal">
                  <i class="bi bi-question-circle me-1"></i>Mot de passe oublié ?
                </a>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-lg" style="background:#2C6BED;color:#fff;border-color:#2C6BED;">
                  <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </button>
              </div>
            </form>
            <hr>
            <p class="text-center mb-0 text-muted" style="font-size:.9rem;">
              Pas encore de compte ?
              <a href="#" style="font-weight:600;"
                 data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Créer un compte</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL INSCRIPTION -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div style="color:#fff;text-align:center;padding:1.6rem;">
            <i class="bi bi-person-plus-fill" style="font-size:2rem;display:block;margin-bottom:.4rem;"></i>
            <h5 style="margin:0;font-weight:700;">Créer un compte</h5>
            <p style="margin:.3rem 0 0;opacity:.85;font-size:.85rem;">Rejoignez Portfolio Pro</p>
          </div>
          <div class="modal-body p-4">
            <?php if (!empty($_SESSION['register_erreur'])): ?>
              <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($_SESSION['register_erreur']) ?>
              </div>
              <?php unset($_SESSION['register_erreur']); ?>
            <?php endif; ?>
            <form method="POST" action="auth2/register.php">
              <div class="mb-3">
                <label class="form-label fw-semibold">Nom complet</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person"></i></span>
                  <input type="text" name="nom" class="form-control" placeholder="Nom & Prenom" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                  <input type="email" name="email" class="form-control" placeholder="email" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Mot de passe</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock"></i></span>
                  <input type="password" name="password" id="regPwd" class="form-control"
                         placeholder="Min. 8 car." required oninput="evalForceReg(this.value)">
                  <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('regPwd','regPwdIcon')">
                    <i class="bi bi-eye" id="regPwdIcon"></i>
                  </button>
                </div>
                <div class="bg-light rounded mt-1" style="height:5px;">
                  <div id="regPwdBar" style="width:0%;height:100%;border-radius:3px;transition:width .3s,background .3s;"></div>
                </div>
                <small id="regPwdLabel" class="text-muted"></small>
              </div>
              <div class="mb-4">
                <label class="form-label fw-semibold">Confirmer le mot de passe</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                  <input type="password" name="confirm" id="regConfirm" class="form-control"
                         placeholder="Confirmer" required oninput="checkMatchReg()">
                  <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('regConfirm','regConfirmIcon')">
                    <i class="bi bi-eye" id="regConfirmIcon"></i>
                  </button>
                </div>
                <small id="regMatchMsg"></small>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-lg" style="background:#2C6BED;color:#fff;border-color:#2C6BED;">
                  <i class="bi bi-person-check me-2"></i>Créer mon compte
                </button>
              </div>
            </form>
            <hr>
            <p class="text-center mb-0 text-muted" style="font-size:.9rem;">
              Déjà un compte ?
              <a href="#" style="font-weight:600;"
                 data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL MOT DE PASSE OUBLIÉ -->
    <div class="modal fade" id="forgotModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div style="color:#fff;text-align:center;padding:1.6rem;">
            <i class="bi bi-key-fill" style="font-size:2rem;display:block;margin-bottom:.4rem;"></i>
            <h5 style="margin:0;font-weight:700;">Mot de passe oublié ?</h5>
            <p style="margin:.3rem 0 0;opacity:.85;font-size:.85rem;">Un lien de réinitialisation vous sera envoyé</p>
          </div>
          <div class="modal-body p-4">
            <?php if (!empty($_SESSION['forgot_succes'])): ?>
              <div class="alert alert-success d-flex align-items-center gap-2 py-2">
                <i class="bi bi-check-circle-fill"></i>
                <?= htmlspecialchars($_SESSION['forgot_succes']) ?>
              </div>
              <?php unset($_SESSION['forgot_succes']); ?>
            <?php endif; ?>
            <?php if (!empty($_SESSION['forgot_erreur'])): ?>
              <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($_SESSION['forgot_erreur']) ?>
              </div>
              <?php unset($_SESSION['forgot_erreur']); ?>
            <?php endif; ?>
            <form method="POST" action="auth2/forgot_password.php">
              <div class="mb-4">
                <label class="form-label fw-semibold">Adresse email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                  <input type="email" name="email" class="form-control" placeholder="email" required>
                </div>
                <div class="form-text">Lien valable <strong>1 heure</strong>.</div>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-lg" style="background:#2C6BED;color:#fff;border-color:#2C6BED;">
                  <i class="bi bi-send me-2"></i>Envoyer 
                </button>
              </div>
            </form>
            <hr>
            <p class="text-center mb-0 text-muted" style="font-size:.9rem;">
              <a href="#" style="font-weight:600;"
                 data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts modals -->
    <script>
    function togglePwd(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    }
    function evalForceReg(val) {
        const bar = document.getElementById('regPwdBar');
        const lbl = document.getElementById('regPwdLabel');
        let score = 0;
        if (val.length >= 8)            score++;
        if (/[A-Z]/.test(val))         score++;
        if (/[0-9]/.test(val))         score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        const levels = [
            { w:'0%',   c:'#dee2e6', t:'' },
            { w:'25%',  c:'#dc3545', t:'Faible' },
            { w:'50%',  c:'#fd7e14', t:'Moyen' },
            { w:'75%',  c:'#ffc107', t:'Bon' },
            { w:'100%', c:'#2C6BED', t:'Fort ✓' },
        ];
        bar.style.width      = levels[score].w;
        bar.style.background = levels[score].c;
        lbl.textContent      = levels[score].t;
        lbl.style.color      = levels[score].c;
    }
    function checkMatchReg() {
        const pwd = document.getElementById('regPwd').value;
        const cfm = document.getElementById('regConfirm').value;
        const msg = document.getElementById('regMatchMsg');
        if (!cfm) { msg.textContent = ''; return; }
        if (pwd === cfm) {
            msg.textContent = '✓ Les mots de passe correspondent';
            msg.style.color = '#2C6BED';
        } else {
            msg.textContent = '✗ Ne correspondent pas';
            msg.style.color = '#dc3545';
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
        <?php if (!empty($_SESSION['register_erreur'])): ?>
            new bootstrap.Modal(document.getElementById('registerModal')).show();
        <?php endif; ?>
        <?php if (!empty($_SESSION['forgot_succes']) || !empty($_SESSION['forgot_erreur'])): ?>
            new bootstrap.Modal(document.getElementById('forgotModal')).show();
        <?php endif; ?>
        <?php if (!empty($_SESSION['login_erreur'])): ?>
            new bootstrap.Modal(document.getElementById('loginModal')).show();
        <?php endif; ?>
    });
    </script>

    <?php endif; ?>

</body>
</html>