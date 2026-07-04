<?php
/**
 * index.php — Point d'entrée principal de PortfolioGen
 *
 * Ce fichier orchestre l'ensemble de la page d'accueil en incluant
 * des fragments réutilisables depuis includes/ et sections/.
 */
session_start();
?>
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

    <!-- style.css EN DERNIER (contient tout : page + chatbot + modals) -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
</head>
<body class="page-home">

    <!-- ===== Fixed Header ===== -->
    <?php require 'includes/header.php'; ?>

    <!-- ===== Sections ===== -->
    <?php require 'sections/hero.php'; ?>
    <?php require 'sections/showcase.php'; ?>
    <?php require 'sections/categories.php'; ?>
    <?php require 'sections/about.php'; ?>
    <?php require 'sections/testimonials.php'; ?>

    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content feedback-modal-content">
          <div class="modal-header border-0 pb-0">
            <div>
              <h5 class="modal-title">Give Feedback</h5>
              <p class="mb-0 text-muted" style="font-size:.95rem;">Submit your Gmail, stars and a quick message.</p>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body pt-3">
            <form id="feedback-form" novalidate>
              <div class="mb-3">
                <label class="form-label">Gmail address</label>
                <input type="email" id="fb-email" class="form-control" placeholder="yourname@gmail.com" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Rating</label>
                <div id="rating-stars" class="feedback-star-row" aria-label="Star rating input"></div>
              </div>
              <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea id="fb-message" class="form-control" rows="4" placeholder="Tell us what you liked or how we can improve." required></textarea>
              </div>
              <div id="feedback-status" class="feedback-status"></div>
              <div class="d-grid">
                <button type="submit" class="btn btn-lg btn-primary">Submit Feedback</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== Page Scripts (animations GSAP inline) ===== -->
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
            if (titleEl && !titleEl.textContent.trim()) {
                titleEl.textContent = 'Create Your Portfolio Experience';
            }
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
    <?php require 'includes/footer.php'; ?>

    <!-- ===== Scripts JS communs + modals ===== -->
    <?php require 'includes/scripts.php'; ?>

    <!-- ===== Chatbot (connecté uniquement) ===== -->
    <?php require 'includes/chatbot.php'; ?>

    <!-- ===== Modals Auth ===== -->
    <?php require 'includes/modals.php'; ?>

</body>
</html>
