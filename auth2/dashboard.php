<?php
// ================================================
//  dashboard.php — Page protégée
// ================================================
session_start();

// Protection : non connecté → login
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil — PortfolioGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
    /* ===== RESET & BASE ===== */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --bg:        #0a0a0f;
        --bg2:       #111118;
        --bg3:       #16161f;
        --border:    rgba(255,255,255,0.07);
        --border2:   rgba(44,107,237,0.3);
        --blue:      #2C6BED;
        --blue-soft: #1a4db5;
        --blue-glow: rgba(44,107,237,0.18);
        --cyan:      #38bdf8;
        --text:      #f0f0f8;
        --muted:     #6b6b80;
        --muted2:    #9898b0;
        --success:   #22c55e;
        --danger:    #ef4444;
        --warning:   #f59e0b;
        --radius:    14px;
        --radius-lg: 20px;
    }

    html { scroll-behavior: smooth; }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'Syne', sans-serif;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* ===== NOISE OVERLAY ===== */
    body::before {
        content: '';
        position: fixed; inset: 0; z-index: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        position: fixed;
        top: 0; left: 0;
        width: 260px;
        height: 100vh;
        background: var(--bg2);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        z-index: 100;
        padding: 0;
    }

    .sidebar-logo {
        display: flex; align-items: center; gap: 10px;
        padding: 28px 24px 22px;
        border-bottom: 1px solid var(--border);
        text-decoration: none;
    }
    .sidebar-logo-icon {
        width: 36px; height: 36px;
        background: var(--blue);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Space Mono', monospace;
        font-size: 12px; font-weight: 700;
        color: #fff;
    }
    .sidebar-logo-text {
        font-size: 18px; font-weight: 800;
        color: var(--text);
        letter-spacing: -0.5px;
    }
    .sidebar-logo-text span { color: var(--blue); }

    .sidebar-nav {
        flex: 1;
        padding: 20px 12px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .nav-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--muted);
        padding: 12px 12px 6px;
    }

    .nav-item {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 14px;
        border-radius: 10px;
        color: var(--muted2);
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all .2s;
        cursor: pointer;
        border: none; background: none; width: 100%; text-align: left;
    }
    .nav-item i { font-size: 17px; flex-shrink: 0; }
    .nav-item:hover {
        background: var(--blue-glow);
        color: var(--text);
    }
    .nav-item.active {
        background: var(--blue-glow);
        color: var(--blue);
        border: 1px solid var(--border2);
    }
    .nav-item.active i { color: var(--blue); }

    .sidebar-footer {
        padding: 16px 12px;
        border-top: 1px solid var(--border);
    }

    /* ===== MAIN CONTENT ===== */
    .main {
        margin-left: 260px;
        min-height: 100vh;
        padding: 0;
        position: relative; z-index: 1;
    }

    /* ===== TOPBAR ===== */
    .topbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 36px;
        border-bottom: 1px solid var(--border);
        background: rgba(10,10,15,0.8);
        backdrop-filter: blur(12px);
        position: sticky; top: 0; z-index: 50;
    }

    .topbar-title { font-size: 20px; font-weight: 800; letter-spacing: -0.5px; }
    .topbar-title span { color: var(--muted); font-weight: 400; font-size: 14px; margin-left: 8px; }

    .topbar-right { display: flex; align-items: center; gap: 16px; }

    .avatar-sm {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--blue), var(--cyan));
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 14px; color: #fff;
        flex-shrink: 0;
    }

    /* ===== PAGE SECTIONS ===== */
    .page-section { display: none; }
    .page-section.active { display: block; }

    .content-area { padding: 36px; }

    /* ===== PROFILE HERO ===== */
    .profile-hero {
        background: var(--bg3);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        margin-bottom: 28px;
    }

    .profile-banner {
        height: 130px;
        background: linear-gradient(135deg, #0d1b40 0%, #1a2e6e 40%, #0e3460 70%, #061428 100%);
        position: relative;
        overflow: hidden;
    }
    .profile-banner::before {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 20% 50%, rgba(44,107,237,0.3) 0%, transparent 70%),
            radial-gradient(ellipse 40% 60% at 80% 30%, rgba(56,189,248,0.15) 0%, transparent 60%);
    }
    .profile-banner-grid {
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 32px 32px;
    }

    .profile-info-row {
        display: flex; align-items: flex-end; gap: 20px;
        padding: 0 28px 24px;
        margin-top: -40px;
        position: relative;
    }

    .avatar-lg {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--blue), var(--cyan));
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 28px; color: #fff;
        border: 4px solid var(--bg3);
        flex-shrink: 0;
        box-shadow: 0 0 0 1px var(--border2), 0 8px 32px rgba(44,107,237,0.3);
    }

    .profile-meta { flex: 1; padding-bottom: 4px; }
    .profile-name { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 4px; }
    .profile-email { color: var(--muted2); font-size: 13px; font-family: 'Space Mono', monospace; }

    .role-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 14px;
        border-radius: 100px;
        font-size: 12px; font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .role-badge.admin { background: rgba(239,68,68,0.15); color: #ef4444; border: 1px solid rgba(239,68,68,0.25); }
    .role-badge.user  { background: rgba(44,107,237,0.15); color: var(--blue); border: 1px solid var(--border2); }

    /* ===== STAT CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--bg3);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: border-color .2s, transform .2s;
    }
    .stat-card:hover {
        border-color: var(--border2);
        transform: translateY(-2px);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 100px; height: 100px;
        border-radius: 50%;
        opacity: 0.08;
    }
    .stat-card.blue::before  { background: var(--blue); }
    .stat-card.cyan::before  { background: var(--cyan); }
    .stat-card.green::before { background: var(--success); }

    .stat-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        margin-bottom: 16px;
    }
    .stat-icon.blue  { background: rgba(44,107,237,0.15); color: var(--blue); }
    .stat-icon.cyan  { background: rgba(56,189,248,0.12); color: var(--cyan); }
    .stat-icon.green { background: rgba(34,197,94,0.12);  color: var(--success); }

    .stat-value { font-size: 32px; font-weight: 800; letter-spacing: -1px; margin-bottom: 4px; font-family: 'Space Mono', monospace; }
    .stat-label { color: var(--muted2); font-size: 13px; font-weight: 600; }
    .stat-trend { font-size: 12px; margin-top: 8px; color: var(--success); }
    .stat-trend.down { color: var(--danger); }

    /* ===== CARDS ===== */
    .card-dark {
        background: var(--bg3);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .card-dark-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
    }
    .card-dark-title {
        font-size: 15px; font-weight: 700;
        display: flex; align-items: center; gap: 8px;
    }
    .card-dark-title i { color: var(--blue); }
    .card-dark-body { padding: 24px; }

    /* ===== FORM CONTROLS ===== */
    .form-label-dark {
        display: block;
        font-size: 12px; font-weight: 700;
        letter-spacing: 0.8px; text-transform: uppercase;
        color: var(--muted2);
        margin-bottom: 8px;
    }

    .input-dark {
        width: 100%;
        background: var(--bg2);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px 16px;
        color: var(--text);
        font-family: 'Syne', sans-serif;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .input-dark:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(44,107,237,0.12);
    }
    .input-dark::placeholder { color: var(--muted); }
    .input-dark:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .input-group-dark {
        position: relative;
    }
    .input-group-dark .input-dark { padding-left: 42px; }
    .input-group-dark .input-icon {
        position: absolute; left: 14px; top: 50%;
        transform: translateY(-50%);
        color: var(--muted); font-size: 16px;
    }

    /* ===== BUTTONS ===== */
    .btn-blue {
        background: var(--blue);
        color: #fff; border: none;
        padding: 11px 24px;
        border-radius: 10px;
        font-family: 'Syne', sans-serif;
        font-size: 14px; font-weight: 700;
        cursor: pointer;
        transition: background .2s, transform .15s, box-shadow .2s;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-blue:hover {
        background: var(--blue-soft);
        transform: translateY(-1px);
        box-shadow: 0 4px 20px rgba(44,107,237,0.35);
    }
    .btn-blue:active { transform: translateY(0); }

    .btn-ghost {
        background: transparent;
        color: var(--muted2);
        border: 1px solid var(--border);
        padding: 11px 24px;
        border-radius: 10px;
        font-family: 'Syne', sans-serif;
        font-size: 14px; font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-ghost:hover { border-color: var(--muted2); color: var(--text); }

    .btn-danger {
        background: rgba(239,68,68,0.12);
        color: var(--danger);
        border: 1px solid rgba(239,68,68,0.25);
        padding: 11px 24px;
        border-radius: 10px;
        font-family: 'Syne', sans-serif;
        font-size: 14px; font-weight: 700;
        cursor: pointer;
        transition: all .2s;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-danger:hover {
        background: rgba(239,68,68,0.2);
        border-color: var(--danger);
    }

    /* ===== PORTFOLIO GRID ===== */
    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .portfolio-card {
        background: var(--bg2);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        transition: border-color .2s, transform .2s;
        cursor: pointer;
    }
    .portfolio-card:hover {
        border-color: var(--border2);
        transform: translateY(-3px);
    }

    .portfolio-thumb {
        height: 140px;
        position: relative;
        overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        font-size: 40px;
    }
    .portfolio-thumb.t1 { background: linear-gradient(135deg, #0d1b40, #1a4db5); }
    .portfolio-thumb.t2 { background: linear-gradient(135deg, #1a0d40, #7c3aed); }
    .portfolio-thumb.t3 { background: linear-gradient(135deg, #0d2e1b, #15803d); }

    .portfolio-card-body { padding: 16px; }
    .portfolio-card-title { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
    .portfolio-card-template {
        font-size: 12px; color: var(--muted2);
        font-family: 'Space Mono', monospace;
        margin-bottom: 12px;
    }
    .portfolio-card-footer {
        display: flex; align-items: center; justify-content: space-between;
    }
    .portfolio-card-views {
        font-size: 12px; color: var(--muted);
        display: flex; align-items: center; gap: 4px;
    }
    .portfolio-card-actions { display: flex; gap: 8px; }
    .icon-btn {
        width: 30px; height: 30px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: transparent;
        color: var(--muted2);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all .15s;
        font-size: 13px;
    }
    .icon-btn:hover { border-color: var(--blue); color: var(--blue); }

    .portfolio-empty {
        grid-column: 1/-1;
        text-align: center;
        padding: 60px 20px;
        color: var(--muted);
    }
    .portfolio-empty i { font-size: 48px; display: block; margin-bottom: 16px; }
    .portfolio-empty p { margin-bottom: 20px; }

    /* ===== CHART BARS ===== */
    .chart-area {
        display: flex; align-items: flex-end; gap: 6px;
        height: 120px;
        padding: 0 4px;
    }
    .chart-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .chart-bar {
        width: 100%;
        border-radius: 6px 6px 0 0;
        background: linear-gradient(to top, var(--blue), var(--cyan));
        opacity: 0.7;
        transition: opacity .2s;
        animation: grow-bar 1s ease both;
    }
    .chart-bar:hover { opacity: 1; }
    @keyframes grow-bar {
        from { transform: scaleY(0); transform-origin: bottom; }
        to   { transform: scaleY(1); transform-origin: bottom; }
    }
    .chart-lbl { font-size: 10px; color: var(--muted); font-family: 'Space Mono', monospace; }

    /* ===== PASSWORD STRENGTH ===== */
    .pwd-strength { height: 4px; border-radius: 2px; margin-top: 8px; background: var(--bg2); overflow: hidden; }
    .pwd-strength-fill { height: 100%; border-radius: 2px; transition: width .3s, background .3s; width: 0%; }

    /* ===== ALERT ===== */
    .alert-dark {
        border-radius: 10px;
        padding: 14px 18px;
        font-size: 14px;
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 20px;
    }
    .alert-dark.success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25); color: #86efac; }
    .alert-dark.error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #fca5a5; }

    /* ===== INFO ROW ===== */
    .info-row {
        display: flex;
        border-bottom: 1px solid var(--border);
        padding: 14px 0;
    }
    .info-row:last-child { border-bottom: none; }
    .info-key {
        width: 160px; flex-shrink: 0;
        font-size: 12px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: var(--muted);
        padding-top: 2px;
    }
    .info-val { font-size: 14px; color: var(--text); flex: 1; }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--bg); }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .sidebar { transform: translateX(-260px); transition: transform .3s; }
        .sidebar.open { transform: translateX(0); }
        .main { margin-left: 0; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: 1fr; }
        .content-area { padding: 20px; }
        .topbar { padding: 16px 20px; }
        .profile-info-row { padding: 0 18px 20px; flex-wrap: wrap; }
    }

    /* ===== FADE IN ===== */
    .fade-in {
        animation: fadeIn .4s ease both;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>
<body>

<?php
// Initiales de l'utilisateur
$nom    = htmlspecialchars($_SESSION['nom']);
$email  = htmlspecialchars($_SESSION['email']);
$role   = htmlspecialchars($_SESSION['role']);
$initiales = strtoupper(substr(trim($nom), 0, 2));
// Si deux mots, prendre initiales de chaque mot
$parts = explode(' ', trim($_SESSION['nom']));
if (count($parts) >= 2) {
    $initiales = strtoupper(substr($parts[0],0,1) . substr($parts[count($parts)-1],0,1));
}
?>

<!-- ===== SIDEBAR ===== -->
<aside class="sidebar" id="sidebar">
    <a href="../index.php" class="sidebar-logo">
        <div class="sidebar-logo-icon">PG</div>
        <span class="sidebar-logo-text">Portfolio<span>Gen</span></span>
    </a>

    <nav class="sidebar-nav">
        <span class="nav-label">Menu</span>

        <button class="nav-item active" onclick="showSection('profil', this)">
            <i class="bi bi-person-circle"></i>
            Mon Profil
        </button>
        <button class="nav-item" onclick="showSection('portfolios', this)">
            <i class="bi bi-grid-3x3-gap"></i>
            Mes Portfolios
        </button>
        <button class="nav-item" onclick="showSection('stats', this)">
            <i class="bi bi-bar-chart-line"></i>
            Statistiques
        </button>
        <button class="nav-item" onclick="showSection('password', this)">
            <i class="bi bi-shield-lock"></i>
            Sécurité
        </button>

        <span class="nav-label" style="margin-top:12px;">Liens</span>
        <a class="nav-item" href="../generator.php">
            <i class="bi bi-plus-circle"></i>
            Créer un portfolio
        </a>
        <a class="nav-item" href="../index.php">
            <i class="bi bi-house"></i>
            Accueil
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="logout.php" class="nav-item" style="color: var(--danger);">
            <i class="bi bi-box-arrow-right"></i>
            Déconnexion
        </a>
    </div>
</aside>

<!-- ===== MAIN ===== -->
<main class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-title" id="topbar-title">
            Mon Profil
            <span>/ Vue d'ensemble</span>
        </div>
        <div class="topbar-right">
            <a href="../generator.php" class="btn-blue" style="padding:9px 18px;font-size:13px;">
                <i class="bi bi-plus-lg"></i> Nouveau portfolio
            </a>
            <div class="avatar-sm"><?= $initiales ?></div>
        </div>
    </div>

    <!-- ===================== SECTION : PROFIL ===================== -->
    <div class="page-section active fade-in" id="section-profil">
    <div class="content-area">

        <!-- Profile Hero -->
        <div class="profile-hero">
            <div class="profile-banner">
                <div class="profile-banner-grid"></div>
            </div>
            <div class="profile-info-row">
                <div class="avatar-lg"><?= $initiales ?></div>
                <div class="profile-meta">
                    <div class="profile-name"><?= $nom ?></div>
                    <div class="profile-email"><?= $email ?></div>
                </div>
                <span class="role-badge <?= $role === 'admin' ? 'admin' : 'user' ?>">
                    <i class="bi bi-<?= $role === 'admin' ? 'shield-fill' : 'person-fill' ?>"></i>
                    <?= $role ?>
                </span>
            </div>
        </div>

        <!-- Quick stats -->
        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="bi bi-folder2-open"></i></div>
                <div class="stat-value">3</div>
                <div class="stat-label">Portfolios créés</div>
                <div class="stat-trend"><i class="bi bi-arrow-up-short"></i> +1 ce mois</div>
            </div>
            <div class="stat-card cyan">
                <div class="stat-icon cyan"><i class="bi bi-eye"></i></div>
                <div class="stat-value">1.2k</div>
                <div class="stat-label">Vues totales</div>
                <div class="stat-trend"><i class="bi bi-arrow-up-short"></i> +18% cette semaine</div>
            </div>
            <div class="stat-card green">
                <div class="stat-icon green"><i class="bi bi-cursor-fill"></i></div>
                <div class="stat-value">84</div>
                <div class="stat-label">Clics sur liens</div>
                <div class="stat-trend"><i class="bi bi-arrow-up-short"></i> +7 aujourd'hui</div>
            </div>
        </div>

        <!-- Informations personnelles -->
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title">
                    <i class="bi bi-person-vcard"></i> Informations personnelles
                </div>
            </div>
            <div class="card-dark-body">
                <div class="info-row">
                    <span class="info-key">Nom complet</span>
                    <span class="info-val"><?= $nom ?></span>
                </div>
                <div class="info-row">
                    <span class="info-key">Email</span>
                    <span class="info-val" style="font-family:'Space Mono',monospace;font-size:13px;"><?= $email ?></span>
                </div>
                <div class="info-row">
                    <span class="info-key">Rôle</span>
                    <span class="info-val">
                        <span class="role-badge <?= $role === 'admin' ? 'admin' : 'user' ?>" style="font-size:11px;">
                            <?= $role ?>
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-key">Membre depuis</span>
                    <span class="info-val" style="color:var(--muted2);">Mai 2026</span>
                </div>
            </div>
        </div>

    </div>
    </div>

    <!-- ===================== SECTION : MES PORTFOLIOS ===================== -->
    <div class="page-section fade-in" id="section-portfolios">
    <div class="content-area">

        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title">
                    <i class="bi bi-grid-3x3-gap"></i> Mes Portfolios
                </div>
                <a href="../generator.php" class="btn-blue" style="padding:8px 16px;font-size:13px;">
                    <i class="bi bi-plus-lg"></i> Nouveau
                </a>
            </div>
            <div class="card-dark-body">
                <div class="portfolio-grid">
                    <!-- Portfolio 1 -->
                    <div class="portfolio-card">
                        <div class="portfolio-thumb t1">🚀</div>
                        <div class="portfolio-card-body">
                            <div class="portfolio-card-title">Portfolio Principal</div>
                            <div class="portfolio-card-template">template: hyperspace</div>
                            <div class="portfolio-card-footer">
                                <span class="portfolio-card-views"><i class="bi bi-eye"></i> 842 vues</span>
                                <div class="portfolio-card-actions">
                                    <button class="icon-btn" title="Voir"><i class="bi bi-eye"></i></button>
                                    <button class="icon-btn" title="Modifier"><i class="bi bi-pencil"></i></button>
                                    <button class="icon-btn" title="Supprimer" style="color:var(--danger);border-color:rgba(239,68,68,.2)"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Portfolio 2 -->
                    <div class="portfolio-card">
                        <div class="portfolio-thumb t2">🎨</div>
                        <div class="portfolio-card-body">
                            <div class="portfolio-card-title">Portfolio Créatif</div>
                            <div class="portfolio-card-template">template: massively</div>
                            <div class="portfolio-card-footer">
                                <span class="portfolio-card-views"><i class="bi bi-eye"></i> 310 vues</span>
                                <div class="portfolio-card-actions">
                                    <button class="icon-btn" title="Voir"><i class="bi bi-eye"></i></button>
                                    <button class="icon-btn" title="Modifier"><i class="bi bi-pencil"></i></button>
                                    <button class="icon-btn" title="Supprimer" style="color:var(--danger);border-color:rgba(239,68,68,.2)"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Portfolio 3 -->
                    <div class="portfolio-card">
                        <div class="portfolio-thumb t3">💼</div>
                        <div class="portfolio-card-body">
                            <div class="portfolio-card-title">Portfolio Pro</div>
                            <div class="portfolio-card-template">template: read-only</div>
                            <div class="portfolio-card-footer">
                                <span class="portfolio-card-views"><i class="bi bi-eye"></i> 98 vues</span>
                                <div class="portfolio-card-actions">
                                    <button class="icon-btn" title="Voir"><i class="bi bi-eye"></i></button>
                                    <button class="icon-btn" title="Modifier"><i class="bi bi-pencil"></i></button>
                                    <button class="icon-btn" title="Supprimer" style="color:var(--danger);border-color:rgba(239,68,68,.2)"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <!-- ===================== SECTION : STATISTIQUES ===================== -->
    <div class="page-section fade-in" id="section-stats">
    <div class="content-area">

        <div class="stats-grid" style="margin-bottom:24px;">
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="bi bi-eye"></i></div>
                <div class="stat-value">1.2k</div>
                <div class="stat-label">Vues totales</div>
                <div class="stat-trend"><i class="bi bi-arrow-up-short"></i> +18% vs semaine dernière</div>
            </div>
            <div class="stat-card cyan">
                <div class="stat-icon cyan"><i class="bi bi-cursor-fill"></i></div>
                <div class="stat-value">84</div>
                <div class="stat-label">Clics sur liens</div>
                <div class="stat-trend"><i class="bi bi-arrow-up-short"></i> +7 aujourd'hui</div>
            </div>
            <div class="stat-card green">
                <div class="stat-icon green"><i class="bi bi-clock-history"></i></div>
                <div class="stat-value">2m34s</div>
                <div class="stat-label">Temps moyen / visite</div>
                <div class="stat-trend down"><i class="bi bi-arrow-down-short"></i> -12s vs hier</div>
            </div>
        </div>

        <!-- Chart vues par jour -->
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-bar-chart-line"></i> Vues — 7 derniers jours</div>
                <span style="font-size:12px;color:var(--muted);font-family:'Space Mono',monospace;">Mai 2026</span>
            </div>
            <div class="card-dark-body">
                <div class="chart-area" id="chart-views">
                    <?php
                    $days = ['L','Ma','Me','J','V','S','D'];
                    $vals = [42, 78, 55, 130, 95, 160, 112];
                    $max  = max($vals);
                    foreach ($days as $i => $d) {
                        $h = round(($vals[$i] / $max) * 110);
                        echo "<div class='chart-col'>";
                        echo "<div class='chart-bar' style='height:{$h}px;animation-delay:".($i*0.08)."s'></div>";
                        echo "<span class='chart-lbl'>{$d}</span>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Chart clics par portfolio -->
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-pie-chart"></i> Clics par portfolio</div>
            </div>
            <div class="card-dark-body">
                <?php
                $portfolios = [
                    ['Portfolio Principal', 52, 'var(--blue)'],
                    ['Portfolio Créatif',   22, 'var(--cyan)'],
                    ['Portfolio Pro',       10, 'var(--success)'],
                ];
                $totalClics = array_sum(array_column($portfolios, 1));
                foreach ($portfolios as $p) {
                    $pct = round($p[1] / $totalClics * 100);
                    echo "<div style='margin-bottom:16px;'>";
                    echo "<div style='display:flex;justify-content:space-between;margin-bottom:6px;font-size:13px;'>";
                    echo "<span style='color:var(--text);font-weight:600;'>{$p[0]}</span>";
                    echo "<span style='color:var(--muted2);font-family:Space Mono,monospace;'>{$p[1]} clics ({$pct}%)</span>";
                    echo "</div>";
                    echo "<div style='height:6px;background:var(--bg2);border-radius:3px;overflow:hidden;'>";
                    echo "<div style='height:100%;width:{$pct}%;background:{$p[2]};border-radius:3px;transition:width 1s ease;'></div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

    </div>
    </div>

    <!-- ===================== SECTION : MOT DE PASSE ===================== -->
    <div class="page-section fade-in" id="section-password">
    <div class="content-area">

        <div class="card-dark" style="max-width:560px;">
            <div class="card-dark-header">
                <div class="card-dark-title">
                    <i class="bi bi-shield-lock"></i> Changer le mot de passe
                </div>
            </div>
            <div class="card-dark-body">

                <div id="pwd-alert"></div>

                <form id="pwd-form" method="POST" action="change_password.php" onsubmit="return validatePwdForm()">

                    <div style="margin-bottom:20px;">
                        <label class="form-label-dark">Mot de passe actuel</label>
                        <div class="input-group-dark">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" class="input-dark" id="current_pwd" name="current_password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div style="margin-bottom:20px;">
                        <label class="form-label-dark">Nouveau mot de passe</label>
                        <div class="input-group-dark">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" class="input-dark" id="new_pwd" name="new_password"
                                   placeholder="Min. 8 caractères" required oninput="evalPwdStrength(this.value)">
                        </div>
                        <div class="pwd-strength">
                            <div class="pwd-strength-fill" id="pwd-strength-fill"></div>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-top:6px;">
                            <small id="pwd-strength-label" style="font-size:11px;color:var(--muted);"></small>
                            <small style="font-size:11px;color:var(--muted);">Maj + chiffre + symbole = fort</small>
                        </div>
                    </div>

                    <div style="margin-bottom:28px;">
                        <label class="form-label-dark">Confirmer le nouveau mot de passe</label>
                        <div class="input-group-dark">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" class="input-dark" id="confirm_pwd" name="confirm_password"
                                   placeholder="Répétez le mot de passe" required oninput="checkPwdMatch()">
                        </div>
                        <small id="pwd-match-msg" style="font-size:12px;margin-top:6px;display:block;"></small>
                    </div>

                    <div style="display:flex;gap:12px;">
                        <button type="submit" class="btn-blue">
                            <i class="bi bi-shield-check"></i> Mettre à jour
                        </button>
                        <button type="button" class="btn-ghost" onclick="document.getElementById('pwd-form').reset();document.getElementById('pwd-strength-fill').style.width='0%';">
                            Annuler
                        </button>
                    </div>
                </form>

                <hr style="border-color:var(--border);margin:32px 0;">

                <!-- Zone danger -->
                <div style="background:rgba(239,68,68,0.05);border:1px solid rgba(239,68,68,0.15);border-radius:var(--radius);padding:20px;">
                    <div style="font-weight:700;color:var(--danger);margin-bottom:6px;display:flex;align-items:center;gap:8px;">
                        <i class="bi bi-exclamation-triangle-fill"></i> Zone dangereuse
                    </div>
                    <p style="font-size:13px;color:var(--muted2);margin-bottom:16px;">
                        La suppression de votre compte est irréversible. Toutes vos données seront perdues.
                    </p>
                    <button class="btn-danger" onclick="confirmDelete()">
                        <i class="bi bi-trash3"></i> Supprimer mon compte
                    </button>
                </div>

            </div>
        </div>

    </div>
    </div>

</main>

<!-- ===== SCRIPTS ===== -->
<script>
// Navigation entre sections
function showSection(id, btn) {
    // Cacher toutes les sections
    document.querySelectorAll('.page-section').forEach(s => {
        s.classList.remove('active');
    });
    // Activer la section cliquée
    const target = document.getElementById('section-' + id);
    if (target) {
        target.classList.add('active');
        // Re-trigger animation
        target.classList.remove('fade-in');
        void target.offsetWidth;
        target.classList.add('fade-in');
    }

    // Mettre à jour nav
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    if (btn) btn.classList.add('active');

    // Mettre à jour topbar
    const titles = {
        profil:     ['Mon Profil', '/ Vue d\'ensemble'],
        portfolios: ['Mes Portfolios', '/ Gérer'],
        stats:      ['Statistiques', '/ Analyse'],
        password:   ['Sécurité', '/ Mot de passe'],
    };
    const t = titles[id] || ['Dashboard', ''];
    document.getElementById('topbar-title').innerHTML = t[0] + ' <span>' + t[1] + '</span>';
}

// Force du mot de passe
function evalPwdStrength(val) {
    const fill  = document.getElementById('pwd-strength-fill');
    const label = document.getElementById('pwd-strength-label');
    let score = 0;
    if (val.length >= 8)            score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        { w:'0%',   c:'transparent', t:'' },
        { w:'25%',  c:'#ef4444',     t:'Faible' },
        { w:'50%',  c:'#f59e0b',     t:'Moyen' },
        { w:'75%',  c:'#38bdf8',     t:'Bon' },
        { w:'100%', c:'#22c55e',     t:'Fort ✓' },
    ];
    fill.style.width      = levels[score].w;
    fill.style.background = levels[score].c;
    label.textContent     = levels[score].t;
    label.style.color     = levels[score].c;
}

// Vérif correspondance
function checkPwdMatch() {
    const np  = document.getElementById('new_pwd').value;
    const cp  = document.getElementById('confirm_pwd').value;
    const msg = document.getElementById('pwd-match-msg');
    if (!cp) { msg.textContent = ''; return true; }
    if (np === cp) {
        msg.textContent = '✓ Les mots de passe correspondent';
        msg.style.color = '#22c55e';
        return true;
    } else {
        msg.textContent = '✗ Ne correspondent pas';
        msg.style.color = '#ef4444';
        return false;
    }
}

function validatePwdForm() {
    if (!checkPwdMatch()) return false;
    const np = document.getElementById('new_pwd').value;
    if (np.length < 8) {
        showPwdAlert('Le mot de passe doit faire au moins 8 caractères.', 'error');
        return false;
    }
    return true;
}

function showPwdAlert(msg, type) {
    const el = document.getElementById('pwd-alert');
    el.innerHTML = `<div class="alert-dark ${type}"><i class="bi bi-${type==='success'?'check-circle-fill':'exclamation-triangle-fill'}"></i>${msg}</div>`;
    setTimeout(() => el.innerHTML = '', 5000);
}

// Suppression compte
function confirmDelete() {
    if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer votre compte ?\n\nCette action est irréversible.')) {
        window.location.href = 'delete_account.php';
    }
}

// Animation des barres de progression des stats au chargement
window.addEventListener('load', () => {
    setTimeout(() => {
        document.querySelectorAll('[style*="width:0%"]').forEach(el => {
            el.style.transition = 'width 1.2s ease';
        });
    }, 300);
});
</script>

</body>
</html>