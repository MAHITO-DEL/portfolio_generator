<?php
/**
 * sections/hero.php
 * Section Hero principale avec animations GSAP
 */
?>
<section class="hero" id="hero">
    <div class="hero-bg"></div>

    <div class="hero-content">
        <div class="hero-text" id="hero-text">
            <h1 class="hero-title" id="hero-title">Create Your Portfolio Experience</h1>
            <p class="hero-subtitle" id="hero-subtitle">
                Generate a modern, animated portfolio in seconds.
                Showcase your work with stunning templates, fluid animations,
                and zero coding required.
            </p>
            <div class="hero-actions" id="hero-actions">
                <?php if (isset($_SESSION['id_user'])): ?>
                <a href="generator.php" class="btn-cta" id="btn-cta">
                <?php else: ?>
                <a href="#" class="btn-cta" id="btn-cta"
                   data-bs-toggle="modal" data-bs-target="#loginModal">
                <?php endif; ?>
                    <span>Get Started</span>
                    <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
                <a href="#" class="btn-secondary" id="openDemoVideo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <polygon points="5 3 19 12 5 21 5 3"></polygon>
                    </svg>
                    Watch Demo
                </a>
            </div>
        </div>
    </div>
    <!-- VIDEO MODAL -->
<div id="demoVideoModal" class="video-modal">

    <div class="video-container">

        <button class="close-video" id="closeDemoVideo">
            ✕
        </button>

        <video id="demoVideo" controls>
            <source src="images/demo.mp4" type="video/mp4">
        </video>

    </div>

</div>
</section>
<style>
    /* =========================
   DEMO VIDEO MODAL
========================= */

.video-modal{
    position: fixed;
    inset: 0;

    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    background: rgba(0,0,0,0.45);

    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);

    opacity: 0;
    visibility: hidden;

    transition: 0.35s ease;

    z-index: 999999;
}

.video-modal.active{
    opacity: 1;
    visibility: visible;
}

.video-container{
    position: relative;

    width: 75%;
    max-width: 1000px;

    border-radius: 24px;
    overflow: hidden;

    background: #000;

    box-shadow: 0 30px 120px rgba(0,0,0,0.6);

    transform: scale(0.92);
    transition: 0.35s ease;
}

.video-modal.active .video-container{
    transform: scale(1);
}

.video-container video{
    width: 100%;
    display: block;
}

.close-video{
    position: absolute;

    top: 15px;
    right: 15px;

    width: 42px;
    height: 42px;

    border: none;
    border-radius: 50%;

    background: rgba(255,255,255,0.15);

    color: white;

    font-size: 20px;
    cursor: pointer;

    z-index: 10;

    backdrop-filter: blur(10px);

    transition: 0.3s ease;
}

.close-video:hover{
    background: #ef4444;
    transform: rotate(90deg);
}
</style>
<script>
    /* =========================
   DEMO VIDEO MODAL
========================= */

const openDemoBtn = document.getElementById('openDemoVideo');
const closeDemoBtn = document.getElementById('closeDemoVideo');
const demoModal = document.getElementById('demoVideoModal');
const demoVideo = document.getElementById('demoVideo');

if(openDemoBtn){

    openDemoBtn.addEventListener('click', function(e){

        e.preventDefault();

        demoModal.classList.add('active');

        demoVideo.currentTime = 0;
        demoVideo.play();

    });

}

if(closeDemoBtn){

    closeDemoBtn.addEventListener('click', function(){

        demoModal.classList.remove('active');

        demoVideo.pause();

    });

}

if(demoModal){

    demoModal.addEventListener('click', function(e){

        if(e.target === demoModal){

            demoModal.classList.remove('active');

            demoVideo.pause();

        }

    });

}
</script>