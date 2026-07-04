/**
 * PortfolioGen - Unified Animation & Interaction Logic
 */

document.addEventListener('DOMContentLoaded', () => {

    const isHome      = document.body.classList.contains('page-home');
    const isGenerator = document.body.classList.contains('page-generator');

    /* =========================================================================
       1. GSAP Initialization
       ========================================================================= */
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
    }

    /* =========================================================================
       2. Smooth Scroll (Lenis) — home only
       ========================================================================= */
    if (isHome && typeof Lenis !== 'undefined') {
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            smoothWheel: true
        });
        function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
        requestAnimationFrame(raf);
    }

    /* =========================================================================
       3. Home Page
       ========================================================================= */
    if (isHome && typeof gsap !== 'undefined') {

        gsap.utils.toArray('section').forEach(section => {
            const header = section.querySelector('.showcase-header, .categories-header, .about-content');
            if (header) {
                gsap.from(header, {
                    scrollTrigger: { trigger: header, start: "top 85%" },
                    y: 60, opacity: 0, duration: 1.2, ease: "power3.out"
                });
            }
        });

        gsap.utils.toArray('.sc-card').forEach((card, i) => {
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

        document.querySelectorAll('.sc-card').forEach(card => {
            card.addEventListener('click', () => {
                const path = card.getAttribute('data-template-path');
                if (path) window.open(path, '_blank');
            });
        });

        const searchInput    = document.getElementById('search-input');
        const portfolioCards = document.querySelectorAll('.sc-card');
        if (searchInput) {
            searchInput.addEventListener('input', e => {
                const query = e.target.value.toLowerCase().trim();
                portfolioCards.forEach(card => {
                    const match =
                        (card.getAttribute('data-title')    || '').toLowerCase().includes(query) ||
                        (card.getAttribute('data-category') || '').toLowerCase().includes(query);
                    if (match) {
                        card.style.display = 'block';
                        gsap.to(card, { opacity: 1, scale: 1, duration: 0.4 });
                    } else {
                        gsap.to(card, { opacity: 0, scale: 0.95, duration: 0.3,
                            onComplete: () => { card.style.display = 'none'; }
                        });
                    }
                });
                ScrollTrigger.refresh();
            });
        }
    }

    /* =========================================================================
       4. Generator Page
       ========================================================================= */
    if (isGenerator && typeof gsap !== 'undefined') {
        const cards      = gsap.utils.toArray('.temp-card');
        const scrollArea = document.querySelector('.templates-scroll-area');

        function activateCard(card) {
            const mask     = card.querySelector('.mask-container');
            const thumb    = card.querySelector('.temp-thumb');
            const info     = card.querySelector('.temp-info');
            const nameSpan = card.querySelector('.temp-name span');
            card.classList.add('active-center');
            gsap.to(mask,  { width: "100%", height: "400px", borderRadius: "12px", duration: 0.7, ease: "power3.out" });
            gsap.to(thumb, { scale: 1.1, y: "0%", duration: 0.7, ease: "power3.out" });
            gsap.to(info,  { opacity: 1, y: 0, duration: 0.5, delay: 0.2 });
            if (nameSpan) gsap.to(nameSpan, { y: "0%", duration: 0.5, delay: 0.2, ease: "power2.out" });
        }

        function deactivateCard(card) {
            const mask     = card.querySelector('.mask-container');
            const thumb    = card.querySelector('.temp-thumb');
            const info     = card.querySelector('.temp-info');
            const nameSpan = card.querySelector('.temp-name span');
            card.classList.remove('active-center');
            gsap.to(mask,  { width: "350px", height: "350px", borderRadius: "50%", duration: 0.5, ease: "power3.in" });
            gsap.to(thumb, { scale: 1.3, y: "10%", duration: 0.5 });
            gsap.to(info,  { opacity: 0, y: 20, duration: 0.3 });
            if (nameSpan) gsap.to(nameSpan, { y: "100%", duration: 0.3 });
        }

        if (cards.length && scrollArea) {
            cards.forEach(card => {
                ScrollTrigger.create({
                    trigger    : card,
                    scroller   : scrollArea,
                    start      : "top center+=150",
                    end        : "bottom center-=150",
                    onEnter    : () => activateCard(card),
                    onLeave    : () => deactivateCard(card),
                    onEnterBack: () => activateCard(card),
                    onLeaveBack: () => deactivateCard(card),
                });
            });
        }

        const genSearch = document.getElementById('gen-search');
        if (genSearch && cards.length) {
            genSearch.addEventListener('input', e => {
                const query = e.target.value.toLowerCase().trim();
                cards.forEach(card => {
                    const match =
                        (card.getAttribute('data-name')     || '').toLowerCase().includes(query) ||
                        (card.getAttribute('data-category') || '').toLowerCase().includes(query);
                    if (match) {
                        card.style.display = 'flex';
                        gsap.to(card, { opacity: 1, scale: 1, duration: 0.3 });
                    } else {
                        gsap.to(card, { opacity: 0, scale: 0.8, duration: 0.3,
                            onComplete: () => { card.style.display = 'none'; }
                        });
                    }
                });
                ScrollTrigger.refresh();
            });
        }

        [
            { inputId: 'f-name',       targetClass: 'pv-name',       fallback: 'Your Name' },
            { inputId: 'f-title',      targetClass: 'pv-title',      fallback: 'Your Job Title' },
            { inputId: 'f-bio',        targetClass: 'pv-bio',        fallback: 'A short bio about your expertise...' },
            { inputId: 'f-email',      targetClass: 'pv-email',      fallback: 'Email' },
            { inputId: 'f-phone',      targetClass: 'pv-phone',      fallback: 'Phone' },
            { inputId: 'f-proj-title', targetClass: 'pv-proj-title', fallback: 'Featured Project' },
        ].forEach(item => {
            const input = document.getElementById(item.inputId);
            if (input) {
                input.addEventListener('input', e => {
                    const val = e.target.value.trim() || item.fallback;
                    document.querySelectorAll('.' + item.targetClass).forEach(el => el.innerText = val);
                });
            }
        });

        const profileInput = document.getElementById('f-profile');
        if (profileInput) {
            profileInput.addEventListener('change', e => {
                if (e.target.files && e.target.files[0]) {
                    const url = URL.createObjectURL(e.target.files[0]);
                    document.querySelectorAll('.pv-profile-img').forEach(img => {
                        img.src = url; img.style.display = 'block';
                    });
                }
            });
        }

        const projImgInput = document.getElementById('f-proj-img');
        if (projImgInput) {
            projImgInput.addEventListener('change', e => {
                if (e.target.files && e.target.files[0]) {
                    const url = URL.createObjectURL(e.target.files[0]);
                    document.querySelectorAll('.pv-proj-img').forEach(img => {
                        img.src = url; img.style.display = 'block';
                    });
                }
            });
        }
    }

    /* =========================================================================
       5. Category Pages
       ========================================================================= */
    const templateSearch = document.querySelector('.template-search-input');
    const templateCards  = document.querySelectorAll('.tm-card');
    const filterBtns     = document.querySelectorAll('.filter-btn');

    if (templateSearch) {
        templateSearch.addEventListener('input', e => {
            const query = e.target.value.toLowerCase().trim();
            templateCards.forEach(card => {
                const title = card.querySelector('.tm-card-title')?.innerText.toLowerCase() || '';
                const desc  = card.querySelector('.tm-card-desc')?.innerText.toLowerCase()  || '';
                const match = title.includes(query) || desc.includes(query);
                if (match) {
                    card.style.display = 'block';
                    gsap.to(card, { opacity: 1, scale: 1, duration: 0.4 });
                } else {
                    gsap.to(card, { opacity: 0, scale: 0.95, duration: 0.3,
                        onComplete: () => { card.style.display = 'none'; }
                    });
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
                    const match = filter === 'all' || card.getAttribute('data-category') === filter;
                    if (match) {
                        card.style.display = 'block';
                        gsap.to(card, { opacity: 1, scale: 1, duration: 0.4, clearProps: "all" });
                    } else {
                        gsap.to(card, { opacity: 0, scale: 0.95, duration: 0.3,
                            onComplete: () => { card.style.display = 'none'; }
                        });
                    }
                });
            });
        });
    }

    /* =========================================================================
       6. Page Transitions
       FIX : gsap.fromTo garantit que body arrive bien à opacity:1
       ========================================================================= */
    gsap.fromTo('body', { opacity: 0 }, { opacity: 1, duration: 0.4, ease: "power1.out" });

    document.querySelectorAll('a.nav-link, a.logo').forEach(link => {
        const href = link.getAttribute('href');
        if (href && href.includes('.php') && !link.target) {
            link.addEventListener('click', e => {
                e.preventDefault();
                gsap.to('body', {
                    opacity: 0, duration: 0.3,
                    onComplete: () => { window.location.href = href; }
                });
            });
        }
    });
});
