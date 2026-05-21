<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortfolioGen — Generator</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
    <script src="assets/js/script.js?v=<?php echo filemtime('assets/js/script.js'); ?>" defer></script>
    <style>
        /* Specific Styles for Premium Generator */
        :root {
            --bg-deep: #121212;
            --red-accent: #EF4444;
            --burgundy: #450A0A;
        }
        
        body.page-generator {
            background-color: var(--bg-deep);
            color: #fff;
            margin: 0;
            padding: 0;
            /* Natural page scroll — footer reachable */
        }

        .gen-panels {
            display: flex;
            align-items: flex-start; /* critical for sticky sidebar */
        }

        .panel-left {
            transform: translateX(-100%);
            animation: slideInLeft 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            width: 50%;
            background: #161616;
            border-right: 1px solid rgba(255,255,255,0.08);
            padding: 2.5rem 4rem 6rem;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 10;
            box-sizing: border-box;
            /* Scrolls with the page naturally */
        }
        
        /* Hide scrollbar for left panel */
        .panel-left::-webkit-scrollbar { display: none; }
        .panel-left { scrollbar-width: none; }

        .panel-right {
            transform: translateX(100%);
            animation: slideInRight 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0.1s;
            width: 50%;
            height: calc(100vh - 80px);
            background: #121212;
            position: sticky;
            top: 80px; /* sticks just below the header */
            overflow: hidden;
            perspective: 1200px;
            box-sizing: border-box;
        }

        @keyframes slideInLeft { to { transform: translateX(0); } }
        @keyframes slideInRight { to { transform: translateX(0); } }
        
        .brand-header {
            margin-bottom: 3rem;
            flex-shrink: 0;
        }
        .brand-header a {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            letter-spacing: -0.03em;
        }
        .brand-header span {
            color: var(--red-accent);
        }

        .form-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .form-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .form-header p {
            color: rgba(255,255,255,0.5);
            font-size: 0.9rem;
        }

        .input-group {
            position: relative;
        }
        .minimal-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding: 0.8rem 0;
            color: #fff;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        .minimal-input:focus {
            outline: none;
            border-bottom-color: #2563EB; /* Subtle blue touch on focus */
            box-shadow: 0 1px 0 0 rgba(37, 99, 235, 0.2);
        }
        .minimal-input::placeholder {
            color: rgba(255,255,255,0.3);
        }
        
        .form-section-title {
            font-size: 1rem;
            color: var(--red-accent);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-bottom: 0.5rem;
        }

        .file-uploads-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .file-upload-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(255,255,255,0.03);
            border: 1px dashed rgba(255,255,255,0.2);
            border-radius: 8px;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        .file-upload-btn:hover {
            border-color: var(--red-accent);
            color: #fff;
            background: rgba(177, 18, 38, 0.1);
        }
        .file-upload-btn.full-width {
            grid-column: span 2;
        }
        
        .btn-submit {
            margin-top: 3rem;
            margin-bottom: 2rem;
            background: var(--red-accent);
            color: #fff;
            border: none;
            padding: 1.2rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(177, 18, 38, 0.2);
        }
        .btn-submit:hover {
            background: #2563EB; /* Blue touch on hover */
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }
        
        .dynamic-group {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            transition: all 0.3s ease;
        }
        .dynamic-group:hover {
            border-color: rgba(37, 99, 235, 0.3);
        }
        .btn-add-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: #2563EB; /* Blue text */
            border: 1px dashed rgba(37, 99, 235, 0.4);
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            width: 100%;
            justify-content: center;
        }
        .btn-add-item:hover {
            background: rgba(37, 99, 235, 0.1);
            border-color: #2563EB;
        }
        .btn-remove-item {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.4);
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .btn-remove-item:hover {
            color: var(--red-accent);
        }

        /* Right Panel Search */
        .search-wrapper {
            position: absolute;
            top: 2rem;
            right: 3rem;
            z-index: 50;
        }
        .pill-search {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 0.8rem 1.5rem;
            color: #fff;
            width: 250px;
            font-size: 0.9rem;
            transition: width 0.3s ease, border-color 0.3s ease;
        }
        .pill-search:focus {
            outline: none;
            width: 300px;
            border-color: var(--red-accent);
        }

        .templates-scroll-area {
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 100px 40px 200px 80px;
            scrollbar-width: none;
        }
        .templates-scroll-area::-webkit-scrollbar {
            display: none;
        }

        .templates-track {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        /* Template Cards */
        .temp-card {
            position: relative;
            width: 100%;
            height: 550px;
            margin-bottom: -150px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            transform-origin: right center;
            will-change: transform;
        }

        .mask-container {
            width: 350px;
            height: 350px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            background: #111;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            will-change: width, height, border-radius;
            border: 1px solid rgba(255,255,255,0.05);
        }

        /* Browser Mockup Header */
        .browser-header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 32px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            padding: 0 16px;
            gap: 8px;
            z-index: 20;
            opacity: 0; /* Hidden when circle */
            transition: opacity 0.5s ease;
        }
        .temp-card.active-center .browser-header {
            opacity: 1; /* Shows when expanded */
        }
        .browser-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .dot-red { background: #ff5f56; }
        .dot-yellow { background: #ffbd2e; }
        .dot-green { background: #27c93f; }

        .temp-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.3) translateY(10%);
            transition: filter 0.3s ease;
            filter: grayscale(40%) brightness(0.7);
            position: absolute;
            inset: 0;
        }
        
        .temp-card.active-center .temp-thumb {
            filter: grayscale(0%) brightness(0.9);
        }

        /* Glassmorphic Interface Overlay */
        .glass-ui-overlay {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 250px;
            height: 140px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 16px;
            z-index: 15;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .temp-card.active-center .glass-ui-overlay {
            opacity: 1;
            transform: translateY(0);
        }
        .ui-mock-img {
            width: 100%;
            height: 70px;
            background: rgba(0,0,0,0.3);
            border-radius: 8px;
            margin-bottom: 12px;
            object-fit: cover;
        }
        .ui-mock-text {
            height: 8px;
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
            margin-bottom: 6px;
        }

        .temp-info {
            position: absolute;
            bottom: 40px;
            left: -40px; /* Pull name slightly outside the mask for 3D effect */
            z-index: 30;
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
        }

        .temp-name {
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 10px 0;
            line-height: 1;
            letter-spacing: -0.02em;
            text-shadow: 0 4px 30px rgba(0,0,0,0.9);
            overflow: hidden;
        }
        
        .temp-name span {
            display: block;
            transform: translateY(100%);
            will-change: transform;
        }

        .temp-category {
            font-size: 1rem;
            color: var(--red-accent);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
            margin-left: 45px;
        }
        
        /* Live Preview overlay inside the card */
        .live-preview-box {
            position: absolute;
            top: 60px;
            left: 30px;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.5s ease;
            max-width: 70%;
        }
        .temp-card.active-center .live-preview-box {
            opacity: 1;
        }
        .pv-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .pv-profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
        }
        .pv-name { font-size: 1.8rem; font-weight: 700; color: #fff; line-height: 1.1; }
        .pv-title { font-size: 0.9rem; color: var(--red-accent); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .pv-bio { font-size: 0.85rem; color: rgba(255,255,255,0.8); line-height: 1.5; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .pv-contact { font-size: 0.75rem; color: rgba(255,255,255,0.5); display: flex; gap: 10px; }
        .pv-contact span { display: inline-block; }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .gen-panels {
                flex-direction: column;
                height: auto;
            }
            .panel-left, .panel-right {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
            }
            .panel-right {
                height: 60vh;
                order: -1; /* Templates on top for mobile */
                overflow-y: hidden;
            }
            .panel-left {
                padding: 2rem;
                overflow-y: visible; /* Let the main page handle scroll on mobile */
            }
            .templates-scroll-area {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body class="page-generator">

    <!-- ===== Exact Header from index.php ===== -->
    <header class="site-header scrolled" id="header" style="position:sticky; top:0; z-index:200;">
        <div class="header-container">
            <a href="index.php" class="logo">Portfolio<span>Gen</span></a>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search portfolios…">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
            <nav class="main-nav" id="main-nav">
                <a href="index.php" class="nav-link">Home</a>
                <a href="#" class="nav-link">Explore</a>
                <a href="generator.php" class="nav-link active">Templates</a>
                <a href="#" class="nav-link">About</a>
            </nav>
            <div class="auth-buttons">
                <a href="#" class="btn btn-signin" id="btn-signin">Sign In</a>
                <a href="#" class="btn btn-login" id="btn-login">Login</a>
            </div>
        </div>
    </header>

    <!-- ===== Two-Panel Generator ===== -->
    <div class="gen-panels">

    <!-- Left Panel: Full Form -->
    <div class="panel-left">
        <div class="form-container">
            <div class="form-header">
                <h1>Build Your Story</h1>
                <p>Fill in your details. Watch your portfolio adapt in real-time.</p>
            </div>
            
            <form action="#" method="POST" id="gen-form" enctype="multipart/form-data">

                <!-- Personal Info -->
                <h3 class="form-section-title">Personal Information</h3>
                <div class="input-group"><input type="text" id="f-name" class="minimal-input" placeholder="Full Name" autocomplete="off"></div>
                <div class="input-group"><input type="text" id="f-title" class="minimal-input" placeholder="Professional Title (e.g. UI/UX Designer)" autocomplete="off"></div>
                <div class="input-group"><input type="email" id="f-email" class="minimal-input" placeholder="Email Address" autocomplete="off"></div>
                <div class="input-group"><input type="tel" id="f-phone" class="minimal-input" placeholder="Phone Number" autocomplete="off"></div>
                <div class="input-group"><textarea id="f-bio" class="minimal-input" placeholder="Short bio about your expertise..." rows="3" style="resize:none;"></textarea></div>

                <!-- Skills -->
                <h3 class="form-section-title">Skills</h3>
                <div class="input-group"><input type="text" id="f-skills" class="minimal-input" placeholder="e.g. Figma, React, Python, Photoshop (comma separated)" autocomplete="off"></div>

                <!-- Education -->
                <h3 class="form-section-title">Education</h3>
                <div id="edu-container">
                    <div class="dynamic-group">
                        <div class="input-group"><input type="text" class="minimal-input" placeholder="Degree / Certification" autocomplete="off"></div>
                        <div class="input-group"><input type="text" class="minimal-input" placeholder="School / University" autocomplete="off"></div>
                        <div class="input-group"><input type="text" class="minimal-input" placeholder="Year (e.g. 2020 – 2024)" autocomplete="off"></div>
                    </div>
                </div>
                <button type="button" class="btn-add-item" onclick="addDynamicItem('edu-container', this)">+ Add Education</button>

                <!-- Experience -->
                <h3 class="form-section-title">Experience</h3>
                <div id="exp-container">
                    <div class="dynamic-group">
                        <div class="input-group"><input type="text" class="minimal-input" placeholder="Job Role / Position" autocomplete="off"></div>
                        <div class="input-group"><input type="text" class="minimal-input" placeholder="Company Name" autocomplete="off"></div>
                        <div class="input-group"><input type="text" class="minimal-input" placeholder="Duration (e.g. Jan 2022 – Present)" autocomplete="off"></div>
                        <div class="input-group"><textarea class="minimal-input" placeholder="Brief description of your responsibilities..." rows="2" style="resize:none;"></textarea></div>
                    </div>
                </div>
                <button type="button" class="btn-add-item" onclick="addDynamicItem('exp-container', this)">+ Add Experience</button>

                <!-- Social Links -->
                <h3 class="form-section-title">Social Links</h3>
                <div class="input-group"><input type="url" id="f-github" class="minimal-input" placeholder="GitHub URL" autocomplete="off"></div>
                <div class="input-group"><input type="url" id="f-linkedin" class="minimal-input" placeholder="LinkedIn URL" autocomplete="off"></div>
                <div class="input-group"><input type="url" id="f-behance" class="minimal-input" placeholder="Behance URL" autocomplete="off"></div>
                <div class="input-group"><input type="url" id="f-dribbble" class="minimal-input" placeholder="Dribbble URL" autocomplete="off"></div>
                <div class="input-group"><input type="url" id="f-instagram" class="minimal-input" placeholder="Instagram URL" autocomplete="off"></div>

                <!-- Media & Documents -->
                <h3 class="form-section-title">Media &amp; Documents</h3>
                <div class="file-uploads-grid">
                    <label class="file-upload-btn" id="label-profile">
                        <input type="file" id="f-profile" accept="image/*" hidden>
                        <span><svg style="width:18px;height:18px;margin-bottom:6px;display:block;margin-left:auto;margin-right:auto;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>Profile Photo</span>
                    </label>
                    <label class="file-upload-btn" id="label-cv">
                        <input type="file" id="f-cv" accept="application/pdf" hidden>
                        <span><svg style="width:18px;height:18px;margin-bottom:6px;display:block;margin-left:auto;margin-right:auto;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Upload CV (PDF)</span>
                    </label>
                </div>

                <!-- Projects -->
                <h3 class="form-section-title">Featured Projects</h3>
                <div id="proj-container">
                    <div class="dynamic-group">
                        <div class="input-group"><input type="text" class="minimal-input" placeholder="Project Title" autocomplete="off"></div>
                        <div class="input-group"><textarea class="minimal-input" placeholder="Project description..." rows="2" style="resize:none;"></textarea></div>
                        <label class="file-upload-btn full-width" style="grid-column:span 2; margin-top:10px;">
                            <input type="file" accept="image/*" hidden onchange="updateFileName(this)">
                            <span><svg style="width:18px;height:18px;margin-bottom:6px;display:block;margin-left:auto;margin-right:auto;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Upload Project Cover Image</span>
                        </label>
                    </div>
                </div>
                <button type="button" class="btn-add-item" onclick="addDynamicItem('proj-container', this)">+ Add Another Project</button>

                <!-- Portfolio Settings -->
                <h3 class="form-section-title">Portfolio Settings</h3>
                <div class="input-group">
                    <select id="f-theme" class="minimal-input" style="cursor:pointer; background-color: var(--bg-deep); border: 1px solid rgba(255,255,255,0.2);">
                        <option value="" disabled selected>Portfolio Theme</option>
                        <option value="dark">Dark Luxury</option>
                        <option value="light">Clean Minimal</option>
                        <option value="cinematic">Cinematic</option>
                        <option value="creative">Creative Bold</option>
                    </select>
                </div>
                <div class="input-group" style="display:flex; gap:1rem; flex-wrap:wrap; padding:0.8rem 0;">
                    <span style="color:rgba(255,255,255,0.4); font-size:0.85rem; width:100%;">Color Accent</span>
                    <label style="cursor:pointer; display:flex; align-items:center; gap:6px;">
                        <input type="radio" name="color-accent" value="red" checked style="accent-color:#B11226;"> <span style="font-size:0.85rem;">Red</span>
                    </label>
                    <label style="cursor:pointer; display:flex; align-items:center; gap:6px;">
                        <input type="radio" name="color-accent" value="blue" style="accent-color:#2563EB;"> <span style="font-size:0.85rem;">Blue</span>
                    </label>
                    <label style="cursor:pointer; display:flex; align-items:center; gap:6px;">
                        <input type="radio" name="color-accent" value="gold" style="accent-color:#D4AF37;"> <span style="font-size:0.85rem;">Gold</span>
                    </label>
                    <label style="cursor:pointer; display:flex; align-items:center; gap:6px;">
                        <input type="radio" name="color-accent" value="green" style="accent-color:#10B981;"> <span style="font-size:0.85rem;">Emerald</span>
                    </label>
                </div>

                <!-- Section Toggles -->
                <h3 class="form-section-title">Sections to Include</h3>
                <div style="display:flex; flex-direction:column; gap:1rem; padding:0.5rem 0;">
                    <label class="toggle-row" style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" id="t-contact" checked style="accent-color: var(--red-accent);"> <span style="color: rgba(255,255,255,0.8); font-size: 0.95rem;">Contact Section</span></label>
                    <label class="toggle-row" style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" id="t-projects" checked style="accent-color: var(--red-accent);"> <span style="color: rgba(255,255,255,0.8); font-size: 0.95rem;">Projects Section</span></label>
                    <label class="toggle-row" style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" id="t-skills" checked style="accent-color: var(--red-accent);"> <span style="color: rgba(255,255,255,0.8); font-size: 0.95rem;">Skills Section</span></label>
                    <label class="toggle-row" style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" id="t-edu" style="accent-color: var(--red-accent);"> <span style="color: rgba(255,255,255,0.8); font-size: 0.95rem;">Education Section</span></label>
                    <label class="toggle-row" style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" id="t-exp" style="accent-color: var(--red-accent);"> <span style="color: rgba(255,255,255,0.8); font-size: 0.95rem;">Experience Section</span></label>
                </div>

            </form>
            
            <button type="submit" form="gen-form" class="btn-submit">Generate Portfolio →</button>
        </div>
    </div>

    <!-- Right Panel: Cinematic Gallery -->
    <div class="panel-right">
        <div class="search-wrapper">
            <input type="text" class="pill-search" id="gen-search" placeholder="Search templates...">
        </div>
        
        <div class="templates-scroll-area">
            <div class="templates-track">
                
                <!-- Template 1 -->
                <div class="temp-card" data-name="salma" data-category="minimal">
                    <div class="mask-container">
                        <div class="browser-header">
                            <div class="browser-dot dot-red"></div>
                            <div class="browser-dot dot-yellow"></div>
                            <div class="browser-dot dot-green"></div>
                        </div>
                        <img src="portfolio_preview_1_1778103425810.png" class="temp-thumb" alt="Template Preview">
                        
                        <div class="live-preview-box">
                            <div class="pv-header">
                                <img src="" class="pv-profile-img" style="display:none;" alt="Profile">
                                <div>
                                    <div class="pv-name">Your Name</div>
                                    <div class="pv-title">Your Job Title</div>
                                </div>
                            </div>
                            <div class="pv-bio">A short bio about your expertise...</div>
                            <div class="pv-contact"><span class="pv-email">Email</span> &bull; <span class="pv-phone">Phone</span></div>
                        </div>
                        
                        <div class="glass-ui-overlay">
                            <img src="" class="ui-mock-img pv-proj-img" style="display:none;">
                            <div class="ui-mock-text" style="width: 80%;"></div>
                            <div class="ui-mock-text" style="width: 60%;"></div>
                            <div class="pv-proj-title" style="font-size: 0.8rem; font-weight: 600; color: #fff; margin-top: 8px;">Featured Project</div>
                        </div>

                        <div class="temp-info">
                            <h2 class="temp-name"><span>Salma</span></h2>
                            <div class="temp-category">Minimal</div>
                        </div>
                    </div>
                </div>

                <!-- Template 2 -->
                <div class="temp-card" data-name="maya" data-category="creative">
                    <div class="mask-container">
                        <div class="browser-header">
                            <div class="browser-dot dot-red"></div>
                            <div class="browser-dot dot-yellow"></div>
                            <div class="browser-dot dot-green"></div>
                        </div>
                        <img src="portfolio_preview_2_1778103491552.png" class="temp-thumb" alt="Template Preview" style="filter: saturate(1.5) brightness(0.8);">
                        
                        <div class="live-preview-box" style="left: auto; right: 30px; text-align: right;">
                            <div class="pv-header" style="flex-direction: row-reverse;">
                                <img src="" class="pv-profile-img" style="display:none;" alt="Profile">
                                <div>
                                    <div class="pv-name">Your Name</div>
                                    <div class="pv-title">Your Job Title</div>
                                </div>
                            </div>
                            <div class="pv-bio" style="margin-left: auto;">A short bio about your expertise...</div>
                            <div class="pv-contact" style="justify-content: flex-end;"><span class="pv-email">Email</span> &bull; <span class="pv-phone">Phone</span></div>
                        </div>

                        <div class="glass-ui-overlay" style="right: auto; left: 20px; bottom: 40px;">
                            <img src="" class="ui-mock-img pv-proj-img" style="display:none;">
                            <div class="ui-mock-text" style="width: 70%;"></div>
                            <div class="ui-mock-text" style="width: 50%;"></div>
                            <div class="pv-proj-title" style="font-size: 0.8rem; font-weight: 600; color: #fff; margin-top: 8px;">Featured Project</div>
                        </div>

                        <div class="temp-info">
                            <h2 class="temp-name"><span>Maya</span></h2>
                            <div class="temp-category">Creative</div>
                        </div>
                    </div>
                </div>

                <!-- Template 3 -->
                <div class="temp-card" data-name="david" data-category="developer">
                    <div class="mask-container">
                        <div class="browser-header">
                            <div class="browser-dot dot-red"></div>
                            <div class="browser-dot dot-yellow"></div>
                            <div class="browser-dot dot-green"></div>
                        </div>
                        <img src="portfolio_preview_1_1778103425810.png" class="temp-thumb" alt="Template Preview" style="filter: hue-rotate(45deg) brightness(0.8);">
                        
                        <div class="live-preview-box">
                            <div class="pv-header">
                                <img src="" class="pv-profile-img" style="display:none;" alt="Profile">
                                <div>
                                    <div class="pv-name">Your Name</div>
                                    <div class="pv-title">Your Job Title</div>
                                </div>
                            </div>
                            <div class="pv-bio">A short bio about your expertise...</div>
                            <div class="pv-contact"><span class="pv-email">Email</span> &bull; <span class="pv-phone">Phone</span></div>
                        </div>
                        
                        <div class="glass-ui-overlay">
                            <img src="" class="ui-mock-img pv-proj-img" style="display:none;">
                            <div class="ui-mock-text" style="width: 80%;"></div>
                            <div class="ui-mock-text" style="width: 60%;"></div>
                            <div class="pv-proj-title" style="font-size: 0.8rem; font-weight: 600; color: #fff; margin-top: 8px;">Featured Project</div>
                        </div>

                        <div class="temp-info">
                            <h2 class="temp-name"><span>David</span></h2>
                            <div class="temp-category">Developer</div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Extra padding at bottom for scroll reach -->
            <div style="height: 400px;"></div>
        </div>
    </div>

    <!-- Small inline script for file upload label updates -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInputs = [
                { id: 'f-profile', labelId: 'label-profile', text: 'Profile Picture' },
                { id: 'f-cv', labelId: 'label-cv', text: 'CV (PDF)' },
                { id: 'f-proj-img', labelId: 'label-proj-img', text: 'Project Image' }
            ];
            
            fileInputs.forEach(item => {
                const input = document.getElementById(item.id);
                const labelSpan = document.querySelector('#' + item.labelId + ' span');
                if (input && labelSpan) {
                    input.addEventListener('change', (e) => {
                        if (e.target.files.length > 0) {
                            labelSpan.innerHTML = `<span style="color:#27c93f;">✓</span> ${e.target.files[0].name}`;
                        } else {
                            labelSpan.innerHTML = `Upload ${item.text}`;
                        }
                    });
                }
            });
        });
    </script>
    </div><!-- end gen-panels -->

    <!-- ===== Exact Footer from index.php ===== -->
    <footer class="site-footer" style="padding: 40px 2rem; background: var(--bg-dark); border-top: 1px solid rgba(255,255,255,0.05); flex-shrink:0;">
        <div class="footer-container" style="max-width: 1400px; margin: 0 auto;">
            <div class="footer-grid" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 4rem;">
                <div class="footer-brand">
                    <a href="index.php" class="logo" style="margin-bottom: 12px; display: inline-block;">Portfolio<span>Gen</span></a>
                    <p style="color: var(--text-muted); line-height: 1.6; font-size:0.9rem;">Empowering creators to build stunning portfolios without the complexity of coding.</p>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <h4 style="color: #fff; margin-bottom: 8px;">Platform</h4>
                    <a href="#" style="color: var(--text-muted); text-decoration: none;">Explore</a>
                    <a href="generator.php" style="color: var(--text-muted); text-decoration: none;">Templates</a>
                    <a href="#" style="color: var(--text-muted); text-decoration: none;">Showcase</a>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <h4 style="color: #fff; margin-bottom: 8px;">Company</h4>
                    <a href="#" style="color: var(--text-muted); text-decoration: none;">About Us</a>
                    <a href="#" style="color: var(--text-muted); text-decoration: none;">Careers</a>
                    <a href="#" style="color: var(--text-muted); text-decoration: none;">Contact</a>
                </div>
                <div>
                    <h4 style="color: #fff; margin-bottom: 16px;">Newsletter</h4>
                    <p style="color: var(--text-muted); margin-bottom: 16px; font-size: 0.9rem;">Subscribe to get the latest updates and templates.</p>
                </div>
            </div>
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; color: var(--text-muted); font-size: 0.85rem;">
                <p>&copy; 2026 PortfolioGen. All rights reserved.</p>
                <div style="display: flex; gap: 24px;">
                    <a href="#" style="color: inherit; text-decoration: none;">Privacy Policy</a>
                    <a href="#" style="color: inherit; text-decoration: none;">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function addDynamicItem(containerId, btnElement) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            // Find the first dynamic-group as a template
            const template = container.querySelector('.dynamic-group');
            if (!template) return;
            
            // Clone the template
            const clone = template.cloneNode(true);
            
            // Clear input values in the clone
            const inputs = clone.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if (input.type !== 'file') input.value = '';
                if (input.type === 'file') {
                    // Reset file input label
                    const labelSpan = input.nextElementSibling;
                    if (labelSpan) labelSpan.innerHTML = labelSpan.innerHTML.replace(/<span.*span>/, '').trim(); // Remove checkmark if any
                }
            });
            
            // Add a remove button if it doesn't exist
            if (!clone.querySelector('.btn-remove-item')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn-remove-item';
                removeBtn.innerHTML = '✕';
                removeBtn.onclick = function() {
                    clone.remove();
                };
                clone.appendChild(removeBtn);
            }
            
            // Append clone to container
            container.appendChild(clone);
            
            // Re-apply remove button to original if there are multiple now (optional, but good UX)
            if (container.children.length > 1 && !template.querySelector('.btn-remove-item')) {
                 const removeBtn = document.createElement('button');
                 removeBtn.type = 'button';
                 removeBtn.className = 'btn-remove-item';
                 removeBtn.innerHTML = '✕';
                 removeBtn.onclick = function() {
                     if (container.children.length > 1) template.remove();
                 };
                 template.appendChild(removeBtn);
            }
        }
        
        function updateFileName(input) {
            const labelSpan = input.nextElementSibling;
            if (labelSpan && input.files && input.files.length > 0) {
                // Get the original SVG if it exists to preserve it
                const svgMatch = labelSpan.innerHTML.match(/<svg.*?<\/svg>/);
                const svg = svgMatch ? svgMatch[0] : '';
                labelSpan.innerHTML = svg + `<span style="color:#2563EB;">✓</span> ` + input.files[0].name;
            }
        }
    </script>
</body>
</html>
