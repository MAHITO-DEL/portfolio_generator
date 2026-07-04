<?php
/**
 * sections/showcase.php
 * Section Portfolio Showcase — cartes Featured Portfolios
 */
?>
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
                    <a href="../../../templates.php">
    <div class="sc-card-btn">View Preview</div>
</a>
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
                    <a href="../../../templates.php">
    <div class="sc-card-btn">View Preview</div>
</a>
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
                    <a href="../../../templates.php">
    <div class="sc-card-btn">View Preview</div>
</a>
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
                    <a href="../../../templates.php">
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
                    <a href="../../../templates.php">
    <div class="sc-card-btn">View Preview</div>
</a>
                </div>
                <div class="sc-card-badge">Hot</div>
            </div>
        </div>
    </div>
    <div class="showcase-cta" id="showcase-cta">
        <?php if (isset($_SESSION['id_user'])): ?>
        <a href="explore.php" class="btn-cta">
        <?php else: ?>
        <a href="explorer.php" class="btn-cta" data-bs-toggle="modal" data-bs-target="#loginModal">
        <?php endif; ?>
            <span>Explore All Templates</span>
            <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </a>
    </div>
</section>
