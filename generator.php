<?php
/**
 * generator.php — Page générateur de portfolio
 * Requiert une session active — redirige vers index.php si non connecté.
 */
session_start();

if (!isset($_SESSION['id_user'])) {
    $_SESSION['login_erreur'] = "Veuillez vous connecter pour accéder au générateur.";
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/generator/TemplateLoader.php';
$templates = TemplateLoader::getTemplates('portfolio_templates');

$selectedTemplatePath = '';
if (!empty($_GET['template'])) {
    $query = trim(urldecode($_GET['template']));
    foreach ($templates as $template) {
        if (strcasecmp($template['name'], $query) === 0 || strcasecmp(basename($template['path']), $query) === 0) {
            $selectedTemplatePath = $template['path'];
            break;
        }
    }
   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortfolioGen — Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
    <script src="assets/js/script.js?v=<?php echo filemtime('assets/js/script.js'); ?>" defer></script>
    <script src="assets/js/generator.js?v=<?php echo filemtime('assets/js/generator.js'); ?>" defer></script>






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
        padding-top: var(--site-header-height);
    }

    .gen-panels {
        display: flex;
        min-height: calc(100vh - var(--site-header-height));
        gap: 0;
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
        overflow-y: auto;
        max-height: calc(100vh - var(--site-header-height));
    }
    
    .panel-left::-webkit-scrollbar { 
        width: 8px;
    }
    .panel-left::-webkit-scrollbar-track { 
        background: transparent;
    }
    .panel-left::-webkit-scrollbar-thumb { 
        background: rgba(255,255,255,0.1);
        border-radius: 4px;
    }

    @keyframes slideInLeft { to { transform: translateX(0); } }
    
    .form-container {
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
        box-sizing: border-box;
    }
    
    .minimal-input:focus {
        outline: none;
        border-bottom-color: #2563EB;
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
        margin-top: 1.5rem;
        margin-bottom: 1rem;
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
        width: 100%;
    }
    
    .btn-submit:hover {
        background: #2563EB;
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
        color: #2563EB;
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
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-remove-item:hover { 
        color: var(--red-accent); 
    }

    .search-wrapper {
        position: fixed;
        top: calc(var(--site-header-height) + 2rem);
        right: 3rem;
        z-index: 50;
        width: calc(50% - 6rem);
        max-width: 350px;
    }
    
    .pill-search {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 50px;
        padding: 0.8rem 1.5rem;
        color: #fff;
        width: 100%;
        font-size: 0.9rem;
        transition: width 0.3s ease, border-color 0.3s ease;
        box-sizing: border-box;
    }
    
    .pill-search:focus {
        outline: none;
        border-color: var(--red-accent);
    }

    .panel-right {
        width: 50%;
        height: calc(100vh - var(--site-header-height));
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        background: #0a0a0a;
    }

    .templates-scroll-area {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 100px 40px 40px 40px;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
    }

    .templates-scroll-area::-webkit-scrollbar {
        width: 8px;
    }
    
    .templates-scroll-area::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .templates-scroll-area::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.15);
        border-radius: 4px;
    }
    
    .templates-scroll-area::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.3);
    }

    .templates-track {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
    }

    .temp-card {
        flex-shrink: 0;
    }

    .temp-card.selected-template {
        border-color: var(--red-accent) !important;
        box-shadow: 0 0 0 2px var(--red-accent), 0 15px 35px rgba(0,0,0,0.3) !important;
    }

    .temp-card.selected-template .btn-use-template {
        background: rgba(37, 99, 235, 0.95);
        border-color: rgba(37, 99, 235, 0.95);
        color: #fff;
    }

    .template-preview-shell,
    .generated-output-shell {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.35s ease, transform 0.35s ease;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        padding: 1.5rem;
        margin: 0 40px 1.5rem 80px;
        min-height: 260px;
        box-shadow: 0 30px 80px rgba(0,0,0,0.45);
        display: none;
    }
    
    .template-preview-shell.visible,
    .generated-output-shell.visible {
        opacity: 1;
        transform: translateY(0);
        display: block;
    }

    .generated-output-shell {
        display: none;
    }

    .generated-output-shell.visible {
        display: flex;
        flex-direction: column;
        position: fixed;
        inset: 0;
        z-index: 9999;
        width: 100%;
        height: 100%;
        min-height: 0;
        margin: 0;
        border-radius: 0;
        padding: 1.5rem 1.75rem 1.75rem;
        background: #060606;
        overflow: hidden;
        box-shadow: none;
    }

    .generated-output-shell.visible .preview-header {
        margin-bottom: 1rem;
    }

    .generated-action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: flex-end;
        align-items: flex-start;
    }

    .generated-output-shell.visible .generated-template-frame {
        flex: 1 1 auto;
        min-height: 0;
        width: 100%;
        border-radius: 18px;
    }

    .preview-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .preview-header h2 {
        font-size: 1.65rem;
        margin: 0;
        letter-spacing: -0.03em;
    }

    .preview-frame,
    .generated-template-frame {
        width: 100%;
        min-height: 420px;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.08);
        background: #090909;
        overflow: hidden;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.45s ease, transform 0.45s ease;
    }
    
    .preview-frame.loaded,
    .generated-template-frame.loaded {
        opacity: 1;
        transform: translateY(0);
    }

    /* Card styles are imported from style.css (.tm-card) */

    @media (max-width: 1024px) {
        .gen-panels {
            flex-direction: column;
            height: auto;
        }
        
        .panel-left {
            width: 100%;
            height: auto;
            border-right: none;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        
        .panel-right {
            width: 100%;
            height: 60vh;
        }
        
        .templates-scroll-area {
            padding: 100px 20px 20px 20px;
        }

        .search-wrapper {
            position: fixed;
            width: calc(100% - 6rem);
        }
    }
</style>
</head>
<body class="page-generator" data-selected-template="<?= htmlspecialchars($selectedTemplatePath); ?>">

    <!-- ===== Header partagé (gère session automatiquement) ===== -->
    <?php require 'includes/header.php'; ?>

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

                    <h3 class="form-section-title">Personal Information</h3>
                    <div class="input-group"><input type="text"  id="f-name"  class="minimal-input" placeholder="Full Name" autocomplete="off"></div>
                    <div class="input-group"><input type="text"  id="f-title" class="minimal-input" placeholder="Professional Title (e.g. UI/UX Designer)" autocomplete="off"></div>
                    <div class="input-group"><input type="email" id="f-email" class="minimal-input" placeholder="Email Address" autocomplete="off"></div>
                    <div class="input-group"><input type="tel"   id="f-phone" class="minimal-input" placeholder="Phone Number" autocomplete="off"></div>
                    <div class="input-group"><textarea id="f-bio" class="minimal-input" placeholder="Short bio about your expertise..." rows="3" style="resize:none;"></textarea></div>

                    <h3 class="form-section-title">Skills</h3>
                    <div class="input-group"><input type="text" id="f-skills" class="minimal-input" placeholder="e.g. Figma, React, Python (comma separated)" autocomplete="off"></div>

                    <h3 class="form-section-title">Education</h3>
                    <div id="edu-container">
                        <div class="dynamic-group">
                            <div class="input-group"><input type="text" class="minimal-input" placeholder="Degree / Certification" autocomplete="off"></div>
                            <div class="input-group"><input type="text" class="minimal-input" placeholder="School / University" autocomplete="off"></div>
                            <div class="input-group"><input type="text" class="minimal-input" placeholder="Year (e.g. 2020 – 2024)" autocomplete="off"></div>
                        </div>
                    </div>
                    <button type="button" class="btn-add-item" onclick="addDynamicItem('edu-container', this)">+ Add Education</button>

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

                    <h3 class="form-section-title">Social Links</h3>
                    <div class="input-group"><input type="url" id="f-github"    class="minimal-input" placeholder="GitHub URL" autocomplete="off"></div>
                    <div class="input-group"><input type="url" id="f-linkedin"  class="minimal-input" placeholder="LinkedIn URL" autocomplete="off"></div>
                    <div class="input-group"><input type="url" id="f-behance"   class="minimal-input" placeholder="Behance URL" autocomplete="off"></div>
                    <div class="input-group"><input type="url" id="f-dribbble"  class="minimal-input" placeholder="Dribbble URL" autocomplete="off"></div>
                    <div class="input-group"><input type="url" id="f-instagram" class="minimal-input" placeholder="Instagram URL" autocomplete="off"></div>

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

                    <h3 class="form-section-title">Featured Projects</h3>
                    <div id="proj-container">
                        <div class="dynamic-group">
                            <div class="input-group"><input type="text" class="minimal-input" placeholder="Project Title" autocomplete="off"></div>
                            <div class="input-group"><textarea class="minimal-input" placeholder="Project description..." rows="2" style="resize:none;"></textarea></div>
                            <label class="file-upload-btn full-width" style="margin-top:10px;">
                                <input type="file" accept="image/*" hidden class="proj-image-input" onchange="updateFileName(this)">
                                <span><svg style="width:18px;height:18px;margin-bottom:6px;display:block;margin-left:auto;margin-right:auto;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Upload Project Cover Image</span>
                            </label>
                        </div>
                    </div>
                    <button type="button" class="btn-add-item" onclick="addDynamicItem('proj-container', this)">+ Add Another Project</button>

                    <h3 class="form-section-title">Portfolio Settings</h3>
                    <div class="input-group">
                        <select id="f-theme" class="minimal-input" style="cursor:pointer;background-color:var(--bg-deep);border:1px solid rgba(255,255,255,0.2);">
                            <option value="" disabled selected>Portfolio Theme</option>
                            <option value="dark">Dark Luxury</option>
                            <option value="light">Clean Minimal</option>
                            <option value="cinematic">Cinematic</option>
                            <option value="creative">Creative Bold</option>
                        </select>
                    </div>
                    <div class="input-group" style="display:flex;gap:1rem;flex-wrap:wrap;padding:0.8rem 0;">
                        <span style="color:rgba(255,255,255,0.4);font-size:0.85rem;width:100%;">Color Accent</span>
                        <label style="cursor:pointer;display:flex;align-items:center;gap:6px;"><input type="radio" name="color-accent" value="red"   checked style="accent-color:#B11226;"> <span style="font-size:0.85rem;">Red</span></label>
                        <label style="cursor:pointer;display:flex;align-items:center;gap:6px;"><input type="radio" name="color-accent" value="blue"   style="accent-color:#2563EB;"> <span style="font-size:0.85rem;">Blue</span></label>
                        <label style="cursor:pointer;display:flex;align-items:center;gap:6px;"><input type="radio" name="color-accent" value="gold"   style="accent-color:#D4AF37;"> <span style="font-size:0.85rem;">Gold</span></label>
                        <label style="cursor:pointer;display:flex;align-items:center;gap:6px;"><input type="radio" name="color-accent" value="green"  style="accent-color:#10B981;"> <span style="font-size:0.85rem;">Emerald</span></label>
                    </div>

                    <h3 class="form-section-title">Sections to Include</h3>
                    <div style="display:flex;flex-direction:column;gap:1rem;padding:0.5rem 0;">
                        <label class="toggle-row" style="display:flex;align-items:center;gap:8px;cursor:pointer;"><input type="checkbox" id="t-contact"  checked style="accent-color:var(--red-accent);"> <span style="color:rgba(255,255,255,0.8);font-size:0.95rem;">Contact Section</span></label>
                        <label class="toggle-row" style="display:flex;align-items:center;gap:8px;cursor:pointer;"><input type="checkbox" id="t-projects" checked style="accent-color:var(--red-accent);"> <span style="color:rgba(255,255,255,0.8);font-size:0.95rem;">Projects Section</span></label>
                        <label class="toggle-row" style="display:flex;align-items:center;gap:8px;cursor:pointer;"><input type="checkbox" id="t-skills"   checked style="accent-color:var(--red-accent);"> <span style="color:rgba(255,255,255,0.8);font-size:0.95rem;">Skills Section</span></label>
                        <label class="toggle-row" style="display:flex;align-items:center;gap:8px;cursor:pointer;"><input type="checkbox" id="t-edu"              style="accent-color:var(--red-accent);"> <span style="color:rgba(255,255,255,0.8);font-size:0.95rem;">Education Section</span></label>
                        <label class="toggle-row" style="display:flex;align-items:center;gap:8px;cursor:pointer;"><input type="checkbox" id="t-exp"              style="accent-color:var(--red-accent);"> <span style="color:rgba(255,255,255,0.8);font-size:0.95rem;">Experience Section</span></label>
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
                <div class="templates-track" id="templates-container">
                    <?php foreach ($templates as $template): ?>
                    <div class="tm-card temp-card" data-name="<?= htmlspecialchars($template['name']); ?>" data-category="<?= htmlspecialchars($template['category']); ?>" data-description="<?= htmlspecialchars($template['description']); ?>" data-path="<?= htmlspecialchars($template['path']); ?>" style="cursor: pointer; margin-bottom: 2rem;">
                        <div class="tm-card-header" style="height: 220px;">
                            <img src="<?= htmlspecialchars($template['preview']); ?>" class="tm-card-img" alt="Preview of <?= htmlspecialchars($template['name']); ?>" style="object-fit: cover; width: 100%; height: 100%;">
                        </div>
                        <div class="tm-card-body">
                            <div class="tm-card-top">
                                <h3 class="tm-card-title"><?= htmlspecialchars($template['name']); ?></h3>
                                <div class="tm-rating"><span>★</span> 5.0</div>
                            </div>
                            <p class="tm-card-desc"><?= htmlspecialchars($template['description'] ?: 'A professional, well-structured theme for your portfolio.'); ?></p>
                            <div class="tm-card-footer">
                                <span class="tm-price"><?= htmlspecialchars($template['category']); ?></span>
                                <button type="button" class="tm-use-btn btn-use-template">Use Template</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div id="template-preview" class="template-preview-shell <?= $selectedTemplatePath ? 'visible' : ''; ?>">
                <div class="preview-header">
                    <div>
                        <span class="form-section-title" style="margin-bottom:0.75rem;">Selected Template</span>
                        <h2 id="preview-template-name"><?= $selectedTemplatePath ? htmlspecialchars(basename(dirname($selectedTemplatePath))) : 'Choose a template'; ?></h2>
                        <div id="preview-template-category" style="color: rgba(255,255,255,0.65);letter-spacing:0.14em;text-transform:uppercase;font-size:0.78rem;">Template Preview</div>
                    </div>
                    <button type="button" class="btn-add-item" id="clear-template-selection" style="padding:0.8rem 1rem;">Choose another</button>
                </div>
                <iframe id="template-preview-iframe" class="preview-frame" src="<?= $selectedTemplatePath ? htmlspecialchars($selectedTemplatePath) : 'about:blank'; ?>" title="Template preview"></iframe>
            </div>

            <div id="generated-output-shell" class="generated-output-shell">
                <div class="preview-header generated-actions-row">
                    <div>
                        <span class="form-section-title" style="margin-bottom:0.75rem;">Generated Portfolio</span>
                        <h2>Final Portfolio</h2>
                        <p style="color: rgba(255,255,255,0.55);margin:0;font-size:0.95rem;">Your completed portfolio is rendered here in real time.</p>
                    </div>
                    <div class="generated-action-buttons">
                        <button type="button" class="btn-add-item" id="download-generated" style="padding:0.8rem 1rem;">Download PDF</button>
                        <button type="button" class="btn-add-item" id="edit-generated" style="padding:0.8rem 1rem;">Edit</button>
                        <button type="button" class="btn-add-item" id="back-to-templates" style="padding:0.8rem 1rem;">Back to templates</button>
                    </div>
                </div>
                <iframe id="generated-portfolio-iframe" class="generated-template-frame" title="Generated portfolio"></iframe>
            </div>
        </div>

    </div><!-- end gen-panels -->

    <!-- ===== Footer partagé ===== -->
    <?php require 'includes/footer.php'; ?>

    <!-- ===== Scripts JS communs + modals ===== -->
    <?php require 'includes/scripts.php'; ?>

    <!-- ===== Modals Auth ===== -->
    <?php require 'includes/modals.php'; ?>

    <!-- ===== Chatbot (connecté uniquement) ===== -->
    <?php require 'includes/chatbot.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInputs = [
                { id: 'f-profile', labelId: 'label-profile' },
                { id: 'f-cv',      labelId: 'label-cv'      },
            ];
            fileInputs.forEach(item => {
                const input     = document.getElementById(item.id);
                const labelSpan = document.querySelector('#' + item.labelId + ' span');
                if (input && labelSpan) {
                    input.addEventListener('change', e => {
                        if (e.target.files.length > 0) {
                            labelSpan.innerHTML = `<span style="color:#27c93f;">✓</span> ${e.target.files[0].name}`;
                        }
                    });
                }
            });
        });

        function addDynamicItem(containerId, btnElement) {
            const container = document.getElementById(containerId);
            if (!container) return;
            const template = container.querySelector('.dynamic-group');
            if (!template) return;
            const clone = template.cloneNode(true);
            clone.querySelectorAll('input, textarea').forEach(input => {
                if (input.type !== 'file') input.value = '';
            });
            if (!clone.querySelector('.btn-remove-item')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn-remove-item';
                removeBtn.innerHTML = '✕';
                removeBtn.onclick = function() { clone.remove(); };
                clone.appendChild(removeBtn);
            }
            container.appendChild(clone);
            if (container.children.length > 1 && !template.querySelector('.btn-remove-item')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn-remove-item';
                removeBtn.innerHTML = '✕';
                removeBtn.onclick = function() { if (container.children.length > 1) template.remove(); };
                template.appendChild(removeBtn);
            }
        }

        function updateFileName(input) {
            const labelSpan = input.nextElementSibling;
            if (labelSpan && input.files && input.files.length > 0) {
                const svgMatch = labelSpan.innerHTML.match(/<svg.*?<\/svg>/);
                const svg = svgMatch ? svgMatch[0] : '';
                labelSpan.innerHTML = svg + `<span style="color:#2563EB;">✓</span> ` + input.files[0].name;
            }
        }
    </script>

</body>
</html>
