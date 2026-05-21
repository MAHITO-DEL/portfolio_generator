/**
 * PortfolioGen - Unified Animation & Interaction Logic
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // Check which page we are on
    const isHome = document.body.classList.contains('page-home');
    const isGenerator = document.body.classList.contains('page-generator');

    /* =========================================================================
       1. Global Core (Lenis & GSAP Initialization)
       ========================================================================= */
    if (typeof Lenis !== 'undefined') {
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            smoothWheel: true
        });
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
    }

    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
    }

    /* =========================================================================
       2. Home Page Specific (Cinematic Storytelling)
       ========================================================================= */
    if (isHome && typeof gsap !== 'undefined') {
        const initHome = () => {
            const tl = gsap.timeline();
            
            tl.from('.hero-visual', { x: 50, opacity: 0, duration: 1.5, ease: "power4.out" });

            // Section Reveals
            const reveals = document.querySelectorAll('section');
            reveals.forEach(section => {
                const header = section.querySelector('.showcase-header, .categories-header, .about-content');
                if (header) {
                    gsap.from(header, {
                        scrollTrigger: { trigger: header, start: "top 85%" },
                        y: 60, opacity: 0, duration: 1.2, ease: "power3.out"
                    });
                }
            });

            // Parallax Cards
            const cards = gsap.utils.toArray('.sc-card');
            cards.forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: { trigger: card, start: "top 90%" },
                    y: 100, opacity: 0, duration: 1, delay: i % 3 * 0.1
                });
                const img = card.querySelector('.sc-card-img');
                if (img) {
                    gsap.to(img, {
                        scrollTrigger: { trigger: card, start: "top bottom", end: "bottom top", scrub: true },
                        y: -40, ease: "none"
                    });
                }
            });
        };
        initHome();

        // Template Redirect Interaction
        const initShowcaseClick = () => {
            const cards = document.querySelectorAll('.sc-card');
            cards.forEach(card => {
                card.addEventListener('click', () => {
                    const path = card.getAttribute('data-template-path');
                    if (path) {
                        window.open(path, '_blank');
                    }
                });
            });
        };
        initShowcaseClick();
    }

    /* =========================================================================
       3. Live Portfolio Search Filtering
       ========================================================================= */
    const searchInput = document.getElementById('search-input');
    const portfolioCards = document.querySelectorAll('.sc-card');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            portfolioCards.forEach(card => {
                const title = (card.getAttribute('data-title') || '').toLowerCase();
                const category = (card.getAttribute('data-category') || '').toLowerCase();
                const isMatch = title.includes(query) || category.includes(query);
                
                if (isMatch) {
                    card.style.display = 'block';
                    gsap.killTweensOf(card);
                    gsap.to(card, { opacity: 1, scale: 1, duration: 0.4, ease: "power2.out" });
                } else {
                    gsap.killTweensOf(card);
                    gsap.to(card, {
                        opacity: 0, scale: 0.95, duration: 0.3, ease: "power2.in",
                        onComplete: () => { card.style.display = 'none'; }
                    });
                }
            });
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.refresh();
            }
        });
    }

    /* =========================================================================
       4. Generator Page Specific (Obys Porsche Interaction)
       ========================================================================= */
    if (isGenerator && typeof gsap !== 'undefined') {
        const cards = gsap.utils.toArray('.temp-card');
        const scrollArea = document.querySelector('.templates-scroll-area');

        if (cards.length && scrollArea) {
            cards.forEach((card, index) => {
                const mask = card.querySelector('.mask-container');
                const thumb = card.querySelector('.temp-thumb');
                const info = card.querySelector('.temp-info');
                const nameSpan = card.querySelector('.temp-name span');

                let tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: card,
                        scroller: scrollArea,
                        start: "top center+=200",
                        end: "bottom center-=200",
                        scrub: 1,
                        onEnter: () => card.classList.add('active-center'),
                        onLeave: () => card.classList.remove('active-center'),
                        onEnterBack: () => card.classList.add('active-center'),
                        onLeaveBack: () => card.classList.remove('active-center')
                    }
                });

                tl.to(mask, { width: "100%", height: "400px", borderRadius: "12px", duration: 1 })
                  .to(thumb, { scale: 1.1, y: "0%", duration: 1 }, 0)
                  .to(info, { opacity: 1, y: 0, duration: 0.5 }, 0.5)
                  .to(nameSpan, { y: "0%", duration: 0.5, ease: "power2.out" }, 0.5);
            });
        }

        // Real-time Search for Generator
        const genSearch = document.getElementById('gen-search');
        if (genSearch && cards.length) {
            genSearch.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase().trim();
                cards.forEach(card => {
                    const name = card.getAttribute('data-name').toLowerCase();
                    const cat = card.getAttribute('data-category').toLowerCase();
                    if (name.includes(query) || cat.includes(query)) {
                        card.style.display = 'flex';
                        gsap.to(card, { opacity: 1, scale: 1, duration: 0.3 });
                    } else {
                        gsap.to(card, { opacity: 0, scale: 0.8, duration: 0.3, onComplete: () => {
                            card.style.display = 'none';
                        }});
                    }
                });
                ScrollTrigger.refresh();
            });
        }

        // Live Preview - Text Fields
        const inputsToWatch = [
            { inputId: 'f-name',       targetClass: 'pv-name',       fallback: 'Your Name' },
            { inputId: 'f-title',      targetClass: 'pv-title',      fallback: 'Your Job Title' },
            { inputId: 'f-bio',        targetClass: 'pv-bio',        fallback: 'A short bio about your expertise...' },
            { inputId: 'f-email',      targetClass: 'pv-email',      fallback: 'Email' },
            { inputId: 'f-phone',      targetClass: 'pv-phone',      fallback: 'Phone' },
            { inputId: 'f-proj-title', targetClass: 'pv-proj-title', fallback: 'Featured Project' },
        ];

        inputsToWatch.forEach(item => {
            const input = document.getElementById(item.inputId);
            if (input) {
                input.addEventListener('input', (e) => {
                    const val = e.target.value.trim() || item.fallback;
                    document.querySelectorAll('.' + item.targetClass).forEach(el => el.innerText = val);
                });
            }
        });

        // Live Preview - Profile Image
        const profileInput = document.getElementById('f-profile');
        if (profileInput) {
            profileInput.addEventListener('change', (e) => {
                if (e.target.files && e.target.files[0]) {
                    const url = URL.createObjectURL(e.target.files[0]);
                    document.querySelectorAll('.pv-profile-img').forEach(img => {
                        img.src = url;
                        img.style.display = 'block';
                    });
                }
            });
        }

        // Live Preview - Project Image (shows in glassmorphic overlay)
        const projImgInput = document.getElementById('f-proj-img');
        if (projImgInput) {
            projImgInput.addEventListener('change', (e) => {
                if (e.target.files && e.target.files[0]) {
                    const url = URL.createObjectURL(e.target.files[0]);
                    document.querySelectorAll('.pv-proj-img').forEach(img => {
                        img.src = url;
                        img.style.display = 'block';
                    });
                }
            });
        }
    }
});

/* =========================================================================
   Category Pages - Search & Filtering Logic
   ========================================================================= */
document.addEventListener('DOMContentLoaded', () => {
    const templateSearch = document.querySelector('.template-search-input');
    const templateCards = document.querySelectorAll('.tm-card');
    const filterBtns = document.querySelectorAll('.filter-btn');

    if (templateSearch) {
        templateSearch.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            templateCards.forEach(card => {
                const title = card.querySelector('.tm-card-title').innerText.toLowerCase();
                const desc = card.querySelector('.tm-card-desc').innerText.toLowerCase();
                if (title.includes(query) || desc.includes(query)) {
                    card.style.display = 'block';
                    gsap.to(card, { opacity: 1, scale: 1, duration: 0.4 });
                } else {
                    gsap.to(card, { opacity: 0, scale: 0.95, duration: 0.3, onComplete: () => card.style.display = 'none' });
                }
            });
        });
    }

    if (filterBtns.length) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const filter = btn.getAttribute('data-filter') || btn.textContent.trim().toLowerCase();
                templateCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');
                    if (filter === 'all' || cardCategory === filter) {
                        card.style.display = 'block';
                        gsap.to(card, { opacity: 1, scale: 1, duration: 0.4, clearProps: "all" });
                    } else {
                        gsap.to(card, { opacity: 0, scale: 0.95, duration: 0.3, onComplete: () => card.style.display = 'none' });
                    }
                });
            });
        });
    }

    // Smooth Page Transitions
    document.querySelectorAll('a.nav-link, a.logo, .category-card').forEach(link => {
        const href = link.getAttribute('href');
        if (href && href.includes('.php') && !link.target) {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                gsap.to('body', { opacity: 0, duration: 0.4, onComplete: () => window.location.href = href });
            });
        }
    });
    gsap.from('body', { opacity: 0, duration: 0.5 });
});
