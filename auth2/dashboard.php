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

// ---- Données simulées (à remplacer par vraies requêtes BDD) ----
// Exemple: $stmt = $pdo->prepare("SELECT COUNT(*) FROM portfolios WHERE user_id=?");
$portfolios_data = []; // Vide pour un nouveau compte — remplacer par fetch BDD
// Exemple avec 3 portfolios (décommenter pour tester) :
/*
$portfolios_data = [
    ['id'=>1,'title'=>'Portfolio Principal','template'=>'hyperspace','views'=>842,'clicks'=>52,'emoji'=>'🚀','color'=>'t1','created_at'=>'2026-04-10'],
    ['id'=>2,'title'=>'Portfolio Créatif',  'template'=>'massively', 'views'=>310,'clicks'=>22,'emoji'=>'🎨','color'=>'t2','created_at'=>'2026-04-22'],
    ['id'=>3,'title'=>'Portfolio Pro',      'template'=>'read-only', 'views'=>98, 'clicks'=>10,'emoji'=>'💼','color'=>'t3','created_at'=>'2026-05-01'],
];
*/

// Calculs dynamiques depuis les vraies données
$nb_portfolios  = count($portfolios_data);
$total_views    = array_sum(array_column($portfolios_data, 'views'));
$total_clicks   = array_sum(array_column($portfolios_data, 'clicks'));

// Mois en cours : portfolios créés ce mois
$current_month  = date('Y-m');
$new_this_month = count(array_filter($portfolios_data, function($p) use ($current_month) {
    return isset($p['created_at']) && strpos($p['created_at'], $current_month) === 0;
}));

// Format vues
function formatNum($n) {
    if ($n >= 1000) return round($n/1000,1).'k';
    return $n;
}

// Initiales
$nom   = htmlspecialchars($_SESSION['nom'] ?? 'Utilisateur');
$email = htmlspecialchars($_SESSION['email'] ?? '');
$role  = htmlspecialchars($_SESSION['role'] ?? 'user');
$uid   = (int)($_SESSION['id_user'] ?? 0);

$initiales = strtoupper(substr(trim($nom), 0, 2));
$parts = explode(' ', trim($nom));
if (count($parts) >= 2) {
    $initiales = strtoupper(substr($parts[0],0,1) . substr($parts[count($parts)-1],0,1));
}

// Date membre
$membre_depuis = 'Mai 2026'; // À remplacer par $_SESSION['created_at']
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — PortfolioGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --bg:#0a0a0f; --bg2:#111118; --bg3:#16161f;
        --border:rgba(255,255,255,0.07); --border2:rgba(44,107,237,0.3);
        --blue:#2C6BED; --blue-soft:#1a4db5; --blue-glow:rgba(44,107,237,0.18);
        --cyan:#38bdf8; --text:#f0f0f8; --muted:#6b6b80; --muted2:#9898b0;
        --success:#22c55e; --danger:#ef4444; --warning:#f59e0b;
        --radius:14px; --radius-lg:20px;
    }
    html { scroll-behavior:smooth; }
    body { background:var(--bg); color:var(--text); font-family:'Syne',sans-serif; min-height:100vh; overflow-x:hidden; }
    body::before { content:''; position:fixed; inset:0; z-index:0; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E"); pointer-events:none; }

    /* SIDEBAR */
    .sidebar { position:fixed; top:0; left:0; width:260px; height:100vh; background:var(--bg2); border-right:1px solid var(--border); display:flex; flex-direction:column; z-index:100; }
    .sidebar-logo {
    font-size: 1.5rem;
    font-weight: 800;
    text-decoration: none;
    letter-spacing: -0.5px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
    background: linear-gradient(135deg, #B11226, #2563EB);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;}

    .sidebar-logo span { font-weight: 900; }
    .sidebar-logo-text { font-size:18px; font-weight:800; color:var(--text); letter-spacing:-0.5px; }
    .sidebar-logo-text span { color:var(--blue); }
    .sidebar-nav { flex:1; padding:20px 12px; display:flex; flex-direction:column; gap:4px; overflow-y:auto; }
    .nav-label { font-size:10px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:var(--muted); padding:12px 12px 6px; }
    .nav-item { display:flex; align-items:center; gap:12px; padding:11px 14px; border-radius:10px; color:var(--muted2); text-decoration:none; font-size:14px; font-weight:600; transition:all .2s; cursor:pointer; border:none; background:none; width:100%; text-align:left; }
    .nav-item i { font-size:17px; flex-shrink:0; }
    .nav-item:hover { background:var(--blue-glow); color:var(--text); }
    .nav-item.active { background:var(--blue-glow); color:var(--blue); border:1px solid var(--border2); }
    .nav-item.active i { color:var(--blue); }
    .sidebar-footer { padding:16px 12px; border-top:1px solid var(--border); }

    /* MAIN */
    .main { margin-left:260px; min-height:100vh; position:relative; z-index:1; }
    .topbar { display:flex; align-items:center; justify-content:space-between; padding:20px 36px; border-bottom:1px solid var(--border); background:rgba(10,10,15,0.8); backdrop-filter:blur(12px); position:sticky; top:0; z-index:50; }
    .topbar-title { font-size:20px; font-weight:800; letter-spacing:-0.5px; }
    .topbar-title span { color:var(--muted); font-weight:400; font-size:14px; margin-left:8px; }
    .topbar-right { display:flex; align-items:center; gap:16px; }

    /* AVATAR */
    .avatar-wrapper { position:relative; display:inline-block; }
    .avatar-sm { width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg,var(--blue),var(--cyan)); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:14px; color:#fff; flex-shrink:0; overflow:hidden; }
    .avatar-sm img { width:100%; height:100%; object-fit:cover; }
    .avatar-lg { width:90px; height:90px; border-radius:50%; background:linear-gradient(135deg,var(--blue),var(--cyan)); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:28px; color:#fff; border:4px solid var(--bg3); flex-shrink:0; box-shadow:0 0 0 1px var(--border2),0 8px 32px rgba(44,107,237,0.3); overflow:hidden; position:relative; }
    .avatar-lg img { width:100%; height:100%; object-fit:cover; }
    .avatar-upload-btn { position:absolute; bottom:0; right:0; width:28px; height:28px; background:var(--blue); border-radius:50%; border:2px solid var(--bg3); display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:12px; color:#fff; transition:background .2s; z-index:2; }
    .avatar-upload-btn:hover { background:var(--blue-soft); }

    /* SECTIONS */
    .page-section { display:none; }
    .page-section.active { display:block; }
    .content-area { padding:36px; }

    /* PROFILE HERO */
    .profile-hero { background:var(--bg3); border:1px solid var(--border); border-radius:var(--radius-lg); overflow:hidden; margin-bottom:28px; }
    .profile-banner { height:130px; background:linear-gradient(135deg,#0d1b40 0%,#1a2e6e 40%,#0e3460 70%,#061428 100%); position:relative; overflow:hidden; }
    .profile-banner::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 60% 80% at 20% 50%,rgba(44,107,237,0.3) 0%,transparent 70%),radial-gradient(ellipse 40% 60% at 80% 30%,rgba(56,189,248,0.15) 0%,transparent 60%); }
    .profile-banner-grid { position:absolute; inset:0; background-image:linear-gradient(rgba(255,255,255,0.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.03) 1px,transparent 1px); background-size:32px 32px; }
    .profile-info-row { display:flex; align-items:flex-end; gap:20px; padding:0 28px 24px; margin-top:-45px; position:relative; flex-wrap:wrap; }
    .profile-meta { flex:1; padding-bottom:4px; min-width:200px; }
    .profile-name { font-size:22px; font-weight:800; letter-spacing:-0.5px; margin-bottom:4px; }
    .profile-email { color:var(--muted2); font-size:13px; font-family:'Space Mono',monospace; }
    .profile-bio-preview { color:var(--muted2); font-size:13px; margin-top:6px; max-width:400px; }

    .role-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 14px; border-radius:100px; font-size:12px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; }
    .role-badge.admin { background:rgba(239,68,68,0.15); color:#ef4444; border:1px solid rgba(239,68,68,0.25); }
    .role-badge.user  { background:rgba(44,107,237,0.15); color:var(--blue); border:1px solid var(--border2); }

    /* STATS */
    .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:28px; }
    /* .stat-card { background:var(--bg3); border:1px solid var(--border); border-radius:var(--radius); padding:24px; position:relative; overflow:hidden; transition:border-color .2s,transform .2s; } */
    /* .stat-card:hover { border-color:var(--border2); transform:translateY(-2px); } */
    .stat-card::before { content:''; position:absolute; top:-30px; right:-30px; width:100px; height:100px; border-radius:50%; opacity:0.08; }
    .stat-card.blue::before  { background:var(--blue); }
    .stat-card.cyan::before  { background:var(--cyan); }
    .stat-card.green::before { background:var(--success); }
    .stat-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; margin-bottom:16px; }
    .stat-icon.blue  { background:rgba(44,107,237,0.15); color:var(--blue); }
    .stat-icon.cyan  { background:rgba(56,189,248,0.12); color:var(--cyan); }
    .stat-icon.green { background:rgba(34,197,94,0.12);  color:var(--success); }
    .stat-value { font-size:32px; font-weight:800; letter-spacing:-1px; margin-bottom:4px; font-family:'Inter',monospace; }
    .stat-label { color:var(--muted2); font-size:13px; font-weight:600; }
    .stat-trend { font-size:12px; margin-top:8px; color:var(--success); }
    .stat-trend.neutral { color:var(--muted); }
    .stat-trend.down { color:var(--danger); }

    /* CARDS */
    .card-dark { background:var(--bg3); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; margin-bottom:24px; }
    .card-dark-header { display:flex; align-items:center; justify-content:space-between; padding:20px 24px; border-bottom:1px solid var(--border); }
    .card-dark-title { font-size:15px; font-weight:700; display:flex; align-items:center; gap:8px; }
    .card-dark-title i { color:var(--blue); }
    .card-dark-body { padding:24px; }

    /* FORM */
    .form-label-dark { display:block; font-size:12px; font-weight:700; letter-spacing:0.8px; text-transform:uppercase; color:var(--muted2); margin-bottom:8px; }
    .input-dark { width:100%; background:var(--bg2); border:1px solid var(--border); border-radius:10px; padding:12px 16px; color:var(--text); font-family:'Inter',sans-serif; font-size:14px; transition:border-color .2s,box-shadow .2s; outline:none; }
    .input-dark:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(44,107,237,0.12); }
    .input-dark::placeholder { color:var(--muted); }
    .input-dark:disabled { opacity:0.5; cursor:not-allowed; }
    textarea.input-dark { resize:vertical; min-height:90px; }
    .input-group-dark { position:relative; }
    .input-group-dark .input-dark { padding-left:42px; }
    .input-group-dark .input-icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--muted); font-size:16px; }

    /* BUTTONS */
    .btn-blue { background:var(--blue); color:#fff; border:none; padding:11px 24px; border-radius:10px; font-family:'Inter',sans-serif; font-size:14px; font-weight:700; cursor:pointer; transition:background .2s,transform .15s,box-shadow .2s; display:inline-flex; align-items:center; gap:8px; }
    .btn-blue:hover { background:var(--blue-soft); transform:translateY(-1px); box-shadow:0 4px 20px rgba(44,107,237,0.35); }
    .btn-ghost { background:transparent; color:var(--muted2); border:1px solid var(--border); padding:11px 24px; border-radius:10px; font-family:'Inter',sans-serif; font-size:14px; font-weight:600; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:8px; }
    .btn-ghost:hover { border-color:var(--muted2); color:var(--text); }
    .btn-danger { background:rgba(239,68,68,0.12); color:var(--danger); border:1px solid rgba(239,68,68,0.25); padding:11px 24px; border-radius:10px; font-family:'Inter',sans-serif; font-size:14px; font-weight:700; cursor:pointer; transition:all .2s; display:inline-flex; align-items:center; gap:8px; }
    .btn-danger:hover { background:rgba(239,68,68,0.2); border-color:var(--danger); }

    /* PORTFOLIO GRID */
    .portfolio-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:20px; }
    .portfolio-card { background:var(--bg2); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; transition:border-color .2s,transform .2s; }
    .portfolio-card:hover { border-color:var(--border2); transform:translateY(-3px); }
    .portfolio-thumb { height:140px; position:relative; overflow:hidden; display:flex; align-items:center; justify-content:center; font-size:40px; }
    .portfolio-thumb.t1 { background:linear-gradient(135deg,#0d1b40,#1a4db5); }
    .portfolio-thumb.t2 { background:linear-gradient(135deg,#1a0d40,#7c3aed); }
    .portfolio-thumb.t3 { background:linear-gradient(135deg,#0d2e1b,#15803d); }
    .portfolio-card-body { padding:16px; }
    .portfolio-card-title { font-size:15px; font-weight:700; margin-bottom:4px; }
    .portfolio-card-template { font-size:12px; color:var(--muted2); font-family:'Inter',monospace; margin-bottom:12px; }
    .portfolio-card-footer { display:flex; align-items:center; justify-content:space-between; }
    .portfolio-card-views { font-size:12px; color:var(--muted); display:flex; align-items:center; gap:4px; }
    .portfolio-card-actions { display:flex; gap:8px; }
    .icon-btn { width:30px; height:30px; border-radius:8px; border:1px solid var(--border); background:transparent; color:var(--muted2); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .15s; font-size:13px; }
    .icon-btn:hover { border-color:var(--blue); color:var(--blue); }

    /* EMPTY STATE */
    .portfolio-empty { grid-column:1/-1; text-align:center; padding:70px 20px; color:var(--muted); }
    .portfolio-empty-icon { width:72px; height:72px; border-radius:20px; background:var(--bg2); border:1px dashed var(--border); display:flex; align-items:center; justify-content:center; font-size:28px; margin:0 auto 20px; }
    .portfolio-empty h3 { font-size:18px; font-weight:700; color:var(--muted2); margin-bottom:8px; }
    .portfolio-empty p { font-size:13px; margin-bottom:24px; max-width:320px; margin-left:auto; margin-right:auto; }

    /* SKILLS TAGS */
    .skill-tag { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; background:var(--bg2); border:1px solid var(--border); border-radius:100px; font-size:12px; font-weight:600; color:var(--muted2); margin:4px; cursor:default; transition:all .2s; }
    .skill-tag:hover { border-color:var(--blue); color:var(--blue); }
    .skill-tag .remove-skill { cursor:pointer; color:var(--muted); font-size:10px; margin-left:2px; }
    .skill-tag .remove-skill:hover { color:var(--danger); }

    /* SOCIAL ROW */
    .social-input-row { display:flex; align-items:center; gap:12px; margin-bottom:12px; }
    .social-icon { width:36px; height:36px; border-radius:8px; background:var(--bg2); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }

    /* CHART */
    .chart-area { display:flex; align-items:flex-end; gap:6px; height:120px; padding:0 4px; }
    .chart-col { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; }
    .chart-bar { width:100%; border-radius:6px 6px 0 0; background:linear-gradient(to top,var(--blue),var(--cyan)); opacity:0.7; transition:opacity .2s; animation:grow-bar 1s ease both; }
    .chart-bar:hover { opacity:1; }
    @keyframes grow-bar { from{transform:scaleY(0);transform-origin:bottom;} to{transform:scaleY(1);transform-origin:bottom;} }
    .chart-lbl { font-size:10px; color:var(--muted); font-family:'Inter',monospace; }

    /* PASSWORD */
    .pwd-strength { height:4px; border-radius:2px; margin-top:8px; background:var(--bg2); overflow:hidden; }
    .pwd-strength-fill { height:100%; border-radius:2px; transition:width .3s,background .3s; width:0%; }

    /* ALERT */
    .alert-dark { border-radius:10px; padding:14px 18px; font-size:14px; display:flex; align-items:center; gap:10px; margin-bottom:20px; }
    .alert-dark.success { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.25); color:#86efac; }
    .alert-dark.error   { background:rgba(239,68,68,0.1);  border:1px solid rgba(239,68,68,0.25);  color:#fca5a5; }

    /* INFO ROW */
    .info-row { display:flex; border-bottom:1px solid var(--border); padding:14px 0; }
    .info-row:last-child { border-bottom:none; }
    .info-key { width:160px; flex-shrink:0; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:var(--muted); padding-top:2px; }
    .info-val { font-size:14px; color:var(--text); flex:1; }

    /* FORM GRID */
    .form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    @media(max-width:640px) { .form-grid-2 { grid-template-columns:1fr; } }

    /* PROGRESS COMPLETE */
    .completion-bar { background:var(--bg2); border-radius:100px; height:8px; overflow:hidden; margin-top:12px; }
    .completion-fill { height:100%; border-radius:100px; background:linear-gradient(90deg,var(--blue),var(--cyan)); transition:width 1s ease; }
    .completion-label { display:flex; justify-content:space-between; font-size:12px; color:var(--muted2); margin-bottom:6px; }

    /* SCROLLBAR */
    ::-webkit-scrollbar { width:6px; }
    ::-webkit-scrollbar-track { background:var(--bg); }
    ::-webkit-scrollbar-thumb { background:var(--border); border-radius:3px; }

    /* RESPONSIVE */
    @media(max-width:900px) { .sidebar{transform:translateX(-260px);transition:transform .3s;} .sidebar.open{transform:translateX(0);} .main{margin-left:0;} .stats-grid{grid-template-columns:1fr 1fr;} }
    @media(max-width:600px) { .stats-grid{grid-template-columns:1fr;} .content-area{padding:20px;} .topbar{padding:16px 20px;} }

    /* FADE IN */
    .fade-in { animation:fadeIn .4s ease both; }
    @keyframes fadeIn { from{opacity:0;transform:translateY(12px);} to{opacity:1;transform:translateY(0);} }
    @keyframes spin { from{transform:rotate(0deg);} to{transform:rotate(360deg);} }

    /* COMPLETION CHECKLIST */
    .check-item { display:flex; align-items:center; gap:10px; padding:10px 0; border-bottom:1px solid var(--border); font-size:13px; }
    .check-item:last-child { border-bottom:none; }
    .check-dot { width:20px; height:20px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; flex-shrink:0; }
    .check-dot.done { background:rgba(34,197,94,0.15); color:var(--success); }
    .check-dot.todo { background:var(--bg2); border:1px solid var(--border); color:var(--muted); }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <a href="../index.php" class="sidebar-logo">
        <span class="sidebar-logo-text">Portfolio<span>Gen</span></span>
    </a>
    <nav class="sidebar-nav">
        <span class="nav-label">Menu</span>
        <button class="nav-item active" onclick="showSection('profil',this)">
            <i class="bi bi-person-circle"></i> Mon Profil
        </button>
        <button class="nav-item" onclick="showSection('portfolios',this)">
            <i class="bi bi-grid-3x3-gap"></i> Mes Portfolios
            <?php if($nb_portfolios > 0): ?>
            <span style="margin-left:auto;background:var(--blue);color:#fff;border-radius:100px;font-size:11px;padding:2px 7px;font-weight:700;"><?= $nb_portfolios ?></span>
            <?php endif; ?>
        </button>
        <button class="nav-item" onclick="showSection('stats',this)">
            <i class="bi bi-bar-chart-line"></i> Statistiques
        </button>
        <button class="nav-item" onclick="showSection('editprofil',this)">
            <i class="bi bi-person-gear"></i> Modifier Profil
        </button>
        <button class="nav-item" onclick="showSection('password',this)">
            <i class="bi bi-shield-lock"></i> Sécurité
        </button>
        <span class="nav-label" style="margin-top:12px;">Liens</span>
        <a class="nav-item" href="../generator.php">
            <i class="bi bi-plus-circle"></i> Créer un portfolio
        </a>
        <a class="nav-item" href="../index.php">
            <i class="bi bi-house"></i> Accueil
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="logout.php" class="nav-item" style="color:var(--danger);">
            <i class="bi bi-box-arrow-right"></i> Déconnexion
        </a>
    </div>
</aside>

<!-- MAIN -->
<main class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-title" id="topbar-title">
        </div>
        <div class="topbar-right">
            <a href="../generator.php" class="btn-blue" style="padding:9px 18px;font-size:13px;">
                <i class="bi bi-plus-lg"></i> Nouveau portfolio
            </a>
            <div class="avatar-sm" id="topbar-avatar">
                <span id="topbar-initials"><?= $initiales ?></span>
                <img id="topbar-avatar-img" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:50%;">
            </div>
        </div>
    </div>

    <!-- ===== SECTION : PROFIL ===== -->
    <div class="page-section active fade-in" id="section-profil">
    <div class="content-area">

        <!-- HERO -->
        <div class="profile-hero">
            <div class="profile-banner"><div class="profile-banner-grid"></div></div>
            <div class="profile-info-row">
                <!-- Avatar avec bouton upload -->
                <div class="avatar-wrapper">
                    <div class="avatar-lg" id="profile-avatar-lg">
                        <span id="avatar-initials-lg"><?= $initiales ?></span>
                        <img id="avatar-img-lg" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;">
                    </div>
                    <label class="avatar-upload-btn" for="avatar-upload" title="Changer la photo">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                    <input type="file" id="avatar-upload" accept="image/*" style="display:none;" onchange="handleAvatarUpload(this)">
                </div>
                <div class="profile-meta">
                    <div class="profile-name"><?= $nom ?></div>
                    <div class="profile-email"><?= $email ?></div>
                    <div class="profile-bio-preview" id="bio-preview-hero" style="display:none;"></div>
                </div>
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
                    <span class="role-badge <?= $role==='admin'?'admin':'user' ?>">
                        <i class="bi bi-<?= $role==='admin'?'shield-fill':'person-fill' ?>"></i> <?= $role ?>
                    </span>
                    <div id="social-links-hero" style="display:flex;gap:8px;"></div>
                </div>
            </div>
        </div>

        <!-- STATS DYNAMIQUES -->
        <div class="stats-grid">
            <div class="stat-card blue">
                <!-- <div class="stat-icon blue"><i class="bi bi-folder2-open"></i></div> -->
                <div class="stat-value"><?= $nb_portfolios ?></div>
                <div class="stat-label">Portfolios créés</div>
                <div class="stat-trend <?= $new_this_month == 0 ? 'neutral' : '' ?>">
                    <?php if($new_this_month > 0): ?>
                        <i class="bi bi-arrow-up-short"></i> +<?= $new_this_month ?> ce mois
                    <?php elseif($nb_portfolios == 0): ?>
                        <i class="bi bi-dash"></i> Aucun portfolio pour l'instant
                    <?php else: ?>
                        <i class="bi bi-dash"></i> Aucun nouveau ce mois
                    <?php endif; ?>
                </div>
            </div>
            <div class="stat-card cyan">
                <!-- <div class="stat-icon cyan"><i class="bi bi-eye"></i></div> -->
                <div class="stat-value"><?= $total_views > 0 ? formatNum($total_views) : '—' ?></div>
                <div class="stat-label">Vues totales</div>
                <div class="stat-trend <?= $total_views == 0 ? 'neutral' : '' ?>">
                    <?php if($total_views == 0): ?>
                        <i class="bi bi-dash"></i> Créez un portfolio pour commencer
                    <?php else: ?>
                        <i class="bi bi-arrow-up-short"></i> Données en direct
                    <?php endif; ?>
                </div>
            </div>
            <div class="stat-card green">
                <!-- <div class="stat-icon green"><i class="bi bi-cursor-fill"></i></div> -->   
                <div class="stat-value"><?= $total_clicks > 0 ? $total_clicks : '—' ?></div>
                <div class="stat-label">Clics sur liens</div>
                <div class="stat-trend <?= $total_clicks == 0 ? 'neutral' : '' ?>">
                    <?php if($total_clicks == 0): ?>
                        <i class="bi bi-dash"></i> Aucun clic enregistré
                    <?php else: ?>
                        <i class="bi bi-arrow-up-short"></i> Total cumulé
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- DEUX COLONNES -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

            <!-- Infos personnelles -->
            <div class="card-dark" style="margin-bottom:0;">
                <div class="card-dark-header">
                    <div class="card-dark-title"><i class="bi bi-person-vcard"></i> Informations</div>
                    <button class="btn-ghost" style="padding:6px 14px;font-size:12px;" onclick="showSection('editprofil',document.querySelectorAll('.nav-item')[3])">
                        <i class="bi bi-pencil"></i> Modifier
                    </button>
                </div>
                <div class="card-dark-body" style="padding:16px 24px;">
                    <div class="info-row"><span class="info-key">Nom</span><span class="info-val"><?= $nom ?></span></div>
                    <div class="info-row"><span class="info-key">Email</span><span class="info-val" style="font-family:'Inter',monospace;font-size:12px;"><?= $email ?></span></div>
                    <div class="info-row"><span class="info-key">Rôle</span><span class="info-val"><span class="role-badge <?= $role==='admin'?'admin':'user' ?>" style="font-size:11px;"><?= $role ?></span></span></div>
                    <div class="info-row"><span class="info-key">Membre</span><span class="info-val" style="color:var(--muted2);"><?= $membre_depuis ?></span></div>
                    <div class="info-row" id="info-localisation" style="display:none;"><span class="info-key">Localisation</span><span class="info-val" id="info-loc-val" style="color:var(--muted2);"></span></div>
                    <div class="info-row" id="info-site" style="display:none;"><span class="info-key">Site web</span><span class="info-val"><a id="info-site-val" href="#" target="_blank" style="color:var(--blue);font-size:13px;"></a></span></div>
                    <div class="info-row" id="info-poste" style="display:none;"><span class="info-key">Poste</span><span class="info-val" id="info-poste-val" style="color:var(--muted2);"></span></div>
                </div>
            </div>

            <!-- Complétion du profil -->
            <div class="card-dark" style="margin-bottom:0;">
                <div class="card-dark-header">
                    <div class="card-dark-title"><i class="bi bi-patch-check"></i> Complétion du profil</div>
                    <span id="completion-pct" style="font-family:'Inter',monospace;font-size:13px;color:var(--blue);font-weight:700;">30%</span>
                </div>
                <div class="card-dark-body" style="padding:16px 24px;">
                    <div class="completion-bar">
                        <div class="completion-fill" id="completion-fill" style="width:30%;"></div>
                    </div>
                    <div style="margin-top:16px;">
                        <div class="check-item">
                            <div class="check-dot done"><i class="bi bi-check"></i></div>
                            <span>Compte créé</span>
                        </div>
                        <div class="check-item" id="check-avatar">
                            <div class="check-dot todo"><i class="bi bi-dash"></i></div>
                            <span style="color:var(--muted2);">Photo de profil</span>
                            <span style="margin-left:auto;font-size:11px;color:var(--muted);">+15%</span>
                        </div>
                        <div class="check-item" id="check-bio">
                            <div class="check-dot todo"><i class="bi bi-dash"></i></div>
                            <span style="color:var(--muted2);">Biographie</span>
                            <span style="margin-left:auto;font-size:11px;color:var(--muted);">+15%</span>
                        </div>
                        <div class="check-item" id="check-social">
                            <div class="check-dot todo"><i class="bi bi-dash"></i></div>
                            <span style="color:var(--muted2);">Réseau social ajouté</span>
                            <span style="margin-left:auto;font-size:11px;color:var(--muted);">+15%</span>
                        </div>
                        <div class="check-item" id="check-skills">
                            <div class="check-dot todo"><i class="bi bi-dash"></i></div>
                            <span style="color:var(--muted2);">Compétences ajoutées</span>
                            <span style="margin-left:auto;font-size:11px;color:var(--muted);">+15%</span>
                        </div>
                        <div class="check-item" id="check-portfolio">
                            <div class="check-dot <?= $nb_portfolios > 0 ? 'done' : 'todo' ?>">
                                <i class="bi bi-<?= $nb_portfolios > 0 ? 'check' : 'dash' ?>"></i>
                            </div>
                            <span style="<?= $nb_portfolios == 0 ? 'color:var(--muted2);' : ''?>">Premier portfolio créé</span>
                            <span style="margin-left:auto;font-size:11px;color:var(--muted);">+25%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Compétences (affichage) -->
        <div class="card-dark" style="margin-top:24px;" id="skills-display-card">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-lightning-charge"></i> Compétences</div>
                <button class="btn-ghost" style="padding:6px 14px;font-size:12px;" onclick="showSection('editprofil',document.querySelectorAll('.nav-item')[3])">
                    <i class="bi bi-plus"></i> Ajouter
                </button>
            </div>
            <div class="card-dark-body">
                <div id="skills-display">
                    <p style="color:var(--muted);font-size:13px;">Aucune compétence ajoutée. <button onclick="showSection('editprofil',document.querySelectorAll('.nav-item')[3])" style="background:none;border:none;color:var(--blue);cursor:pointer;font-size:13px;font-family:inherit;">Ajouter des compétences →</button></p>
                </div>
            </div>
        </div>

    </div>
    </div>

    <!-- ===== SECTION : MES PORTFOLIOS ===== -->
    <div class="page-section fade-in" id="section-portfolios">
    <div class="content-area">
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-grid-3x3-gap"></i> Mes Portfolios</div>
                <a href="../generator.php" class="btn-blue" style="padding:8px 16px;font-size:13px;">
                    <i class="bi bi-plus-lg"></i> Nouveau
                </a>
            </div>
            <div class="card-dark-body">
                <div class="portfolio-grid">
                    <?php if(empty($portfolios_data)): ?>
                    <div class="portfolio-empty">
                        <div class="portfolio-empty-icon">📂</div>
                        <h3>Aucun portfolio pour l'instant</h3>
                        <p>Créez votre premier portfolio en quelques minutes et partagez votre travail avec le monde.</p>
                        <a href="../generator.php" class="btn-blue">
                            <i class="bi bi-plus-lg"></i> Créer mon premier portfolio
                        </a>
                    </div>
                    <?php else: ?>
                    <?php
                    $colors = ['t1','t2','t3'];
                    foreach($portfolios_data as $i => $p):
                        $c = $colors[$i % count($colors)];
                    ?>
                    <div class="portfolio-card">
                        <div class="portfolio-thumb <?= $c ?>"><?= htmlspecialchars($p['emoji'] ?? '📁') ?></div>
                        <div class="portfolio-card-body">
                            <div class="portfolio-card-title"><?= htmlspecialchars($p['title']) ?></div>
                            <div class="portfolio-card-template">template: <?= htmlspecialchars($p['template']) ?></div>
                            <div class="portfolio-card-footer">
                                <span class="portfolio-card-views"><i class="bi bi-eye"></i> <?= number_format($p['views'] ?? 0) ?> vues</span>
                                <div class="portfolio-card-actions">
                                    <a href="../portfolio/<?= $p['id'] ?>" class="icon-btn" title="Voir"><i class="bi bi-eye"></i></a>
                                    <a href="../generator.php?edit=<?= $p['id'] ?>" class="icon-btn" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <button class="icon-btn" title="Supprimer" style="color:var(--danger);border-color:rgba(239,68,68,.2)" onclick="deletePortfolio(<?= $p['id'] ?>)"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- ===== SECTION : STATISTIQUES ===== -->
    <div class="page-section fade-in" id="section-stats">
    <div class="content-area">

        <?php if(empty($portfolios_data)): ?>
        <div style="text-align:center;padding:80px 20px;color:var(--muted);">
            <div style="font-size:48px;margin-bottom:16px;">📊</div>
            <h3 style="color:var(--muted2);margin-bottom:8px;font-size:18px;">Pas encore de données</h3>
            <p style="font-size:13px;margin-bottom:24px;">Les statistiques apparaîtront une fois que vous aurez créé votre premier portfolio.</p>
            <a href="../generator.php" class="btn-blue"><i class="bi bi-plus-lg"></i> Créer un portfolio</a>
        </div>
        <?php else: ?>

        <div class="stats-grid" style="margin-bottom:24px;">
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="bi bi-eye"></i></div>
                <div class="stat-value"><?= formatNum($total_views) ?></div>
                <div class="stat-label">Vues totales</div>
            </div>
            <div class="stat-card cyan">
                <div class="stat-icon cyan"><i class="bi bi-cursor-fill"></i></div>
                <div class="stat-value"><?= $total_clicks ?></div>
                <div class="stat-label">Clics sur liens</div>
            </div>
            <div class="stat-card green">
                <div class="stat-icon green"><i class="bi bi-clock-history"></i></div>
                <div class="stat-value">—</div>
                <div class="stat-label">Temps moyen / visite</div>
                <div class="stat-trend neutral"><i class="bi bi-dash"></i> Données bientôt disponibles</div>
            </div>
        </div>

        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-bar-chart-line"></i> Vues — 7 derniers jours</div>
                <span style="font-size:12px;color:var(--muted);font-family:'Inter',monospace;"><?= date('M Y') ?></span>
            </div>
            <div class="card-dark-body">
                <div class="chart-area">
                    <?php
                    $days = ['L','Ma','Me','J','V','S','D'];
                    // Vraies données à remplacer par requête BDD
                    $vals = [0,0,0,0,0,0,0];
                    $max  = max($vals) ?: 1;
                    foreach ($days as $i => $d) {
                        $h = round(($vals[$i] / $max) * 110);
                        echo "<div class='chart-col'>";
                        echo "<div class='chart-bar' style='height:".max($h,4)."px;animation-delay:".($i*0.08)."s'></div>";
                        echo "<span class='chart-lbl'>{$d}</span>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-pie-chart"></i> Répartition des vues</div>
            </div>
            <div class="card-dark-body">
                <?php
                $totalV = array_sum(array_column($portfolios_data,'views')) ?: 1;
                $clrs = ['var(--blue)','var(--cyan)','var(--success)'];
                foreach ($portfolios_data as $i => $p) {
                    $pct = round($p['views'] / $totalV * 100);
                    echo "<div style='margin-bottom:16px;'>";
                    echo "<div style='display:flex;justify-content:space-between;margin-bottom:6px;font-size:13px;'>";
                    echo "<span style='color:var(--text);font-weight:600;'>".htmlspecialchars($p['title'])."</span>";
                    echo "<span style='color:var(--muted2);font-family:Inter,monospace;'>".$p['views']." vues ({$pct}%)</span>";
                    echo "</div>";
                    echo "<div style='height:6px;background:var(--bg2);border-radius:3px;overflow:hidden;'>";
                    echo "<div style='height:100%;width:{$pct}%;background:".$clrs[$i%3].";border-radius:3px;'></div>";
                    echo "</div></div>";
                }
                ?>
            </div>
        </div>

        <?php endif; ?>
    </div>
    </div>

    <!-- ===== SECTION : MODIFIER PROFIL ===== -->
    <div class="page-section fade-in" id="section-editprofil">
    <div class="content-area">

        <div id="edit-alert"></div>

        <!-- Photo de profil -->
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-camera"></i> Photo de profil</div>
            </div>
            <div class="card-dark-body">
                <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
                    <div class="avatar-lg" id="edit-avatar-preview" style="width:80px;height:80px;font-size:24px;">
                        <span id="edit-avatar-initials"><?= $initiales ?></span>
                        <img id="edit-avatar-img" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div>
                        <p style="font-size:13px;color:var(--muted2);margin-bottom:12px;">JPG, PNG ou GIF. Taille max : 2 Mo.</p>
                        <div style="display:flex;gap:10px;flex-wrap:wrap;">
                            <label for="avatar-upload-2" class="btn-blue" style="cursor:pointer;">
                                <i class="bi bi-upload"></i> Choisir une image
                            </label>
                            <input type="file" id="avatar-upload-2" accept="image/*" style="display:none;" onchange="handleAvatarUpload(this)">
                            <button class="btn-ghost" onclick="removeAvatar()"><i class="bi bi-x-lg"></i> Supprimer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Infos de base -->
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-person-gear"></i> Informations personnelles</div>
            </div>
            <div class="card-dark-body">
                <div class="form-grid-2" style="margin-bottom:20px;">
                    <div>
                        <label class="form-label-dark">Prénom & Nom</label>
                        <input type="text" class="input-dark" id="edit-nom" value="<?= $nom ?>" placeholder="Jean Dupont">
                    </div>
                    <div>
                        <label class="form-label-dark">Poste / Titre professionnel</label>
                        <input type="text" class="input-dark" id="edit-poste" placeholder="Ex: Développeur Full Stack">
                    </div>
                </div>
                <div class="form-grid-2" style="margin-bottom:20px;">
                    <div>
                        <label class="form-label-dark">Localisation</label>
                        <div class="input-group-dark">
                            <i class="bi bi-geo-alt input-icon"></i>
                            <input type="text" class="input-dark" id="edit-location" placeholder="Paris, France">
                        </div>
                    </div>
                    <div>
                        <label class="form-label-dark">Site web</label>
                        <div class="input-group-dark">
                            <i class="bi bi-globe input-icon"></i>
                            <input type="url" class="input-dark" id="edit-website" placeholder="https://monsite.com">
                        </div>
                    </div>
                </div>
                <div style="margin-bottom:20px;">
                    <label class="form-label-dark">Biographie <span style="color:var(--muted);font-weight:400;text-transform:none;letter-spacing:0;">(max 200 caractères)</span></label>
                    <textarea class="input-dark" id="edit-bio" placeholder="Décrivez-vous en quelques mots..." maxlength="200" oninput="updateBioCounter(this)"></textarea>
                    <div style="text-align:right;font-size:11px;color:var(--muted);margin-top:4px;">
                        <span id="bio-counter">0</span>/200
                    </div>
                </div>
            </div>
        </div>

        <!-- Réseaux sociaux -->
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-share"></i> Réseaux sociaux</div>
            </div>
            <div class="card-dark-body">
                <div class="social-input-row">
                    <div class="social-icon" style="color:#1877F2;"><i class="bi bi-linkedin"></i></div>
                    <div class="input-group-dark" style="flex:1;">
                        <i class="bi bi-at input-icon"></i>
                        <input type="text" class="input-dark" id="social-linkedin" placeholder="username LinkedIn">
                    </div>
                </div>
                <div class="social-input-row">
                    <div class="social-icon" style="color:#fff;"><i class="bi bi-github"></i></div>
                    <div class="input-group-dark" style="flex:1;">
                        <i class="bi bi-at input-icon"></i>
                        <input type="text" class="input-dark" id="social-github" placeholder="username GitHub">
                    </div>
                </div>
                <div class="social-input-row">
                    <div class="social-icon" style="color:#1DA1F2;"><i class="bi bi-twitter-x"></i></div>
                    <div class="input-group-dark" style="flex:1;">
                        <i class="bi bi-at input-icon"></i>
                        <input type="text" class="input-dark" id="social-twitter" placeholder="username Twitter/X">
                    </div>
                </div>
                <div class="social-input-row" style="margin-bottom:20px;">
                    <div class="social-icon" style="color:#E1306C;"><i class="bi bi-instagram"></i></div>
                    <div class="input-group-dark" style="flex:1;">
                        <i class="bi bi-at input-icon"></i>
                        <input type="text" class="input-dark" id="social-instagram" placeholder="username Instagram">
                    </div>
                </div>
            </div>
        </div>

        <!-- Compétences -->
        <div class="card-dark">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-lightning-charge"></i> Compétences</div>
            </div>
            <div class="card-dark-body">
                <div style="display:flex;gap:10px;margin-bottom:16px;">
                    <input type="text" class="input-dark" id="skill-input" placeholder="Ex: React, Photoshop, Python..." style="flex:1;" onkeydown="if(event.key==='Enter')addSkill()">
                    <button class="btn-blue" style="padding:11px 20px;" onclick="addSkill()"><i class="bi bi-plus-lg"></i></button>
                </div>
                <div id="skills-tags" style="min-height:40px;display:flex;flex-wrap:wrap;gap:4px;">
                    <span style="font-size:13px;color:var(--muted);align-self:center;" id="skills-empty-hint">Aucune compétence ajoutée</span>
                </div>
                <p style="font-size:12px;color:var(--muted);margin-top:12px;"><i class="bi bi-info-circle"></i> Appuyez sur Entrée ou cliquez + pour ajouter. Cliquez × pour supprimer.</p>
            </div>
        </div>

        <!-- BOUTON GLOBAL ENREGISTRER TOUT -->
        <div style="position:sticky;bottom:0;background:linear-gradient(to top,var(--bg) 70%,transparent);padding:20px 0 28px;margin-top:8px;display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
            <button class="btn-blue" id="btn-save-all" onclick="saveAll()" style="padding:14px 32px;font-size:15px;box-shadow:0 4px 24px rgba(44,107,237,0.35);">
                <i class="bi bi-check2-all"></i> Enregistrer toutes les modifications
            </button>
            <button class="btn-ghost" onclick="showSection('profil',document.querySelectorAll('.nav-item')[0])" style="padding:14px 24px;font-size:14px;">
                <i class="bi bi-x-lg"></i> Annuler
            </button>
            <span id="save-all-status" style="font-size:13px;color:var(--muted);display:none;">
                <i class="bi bi-check-circle-fill" style="color:var(--success);"></i> Modifications enregistrées
            </span>
        </div>

    </div>
    </div>

    <!-- ===== SECTION : MOT DE PASSE ===== -->
    <div class="page-section fade-in" id="section-password">
    <div class="content-area">
        <div class="card-dark" style="max-width:560px;">
            <div class="card-dark-header">
                <div class="card-dark-title"><i class="bi bi-shield-lock"></i> Changer le mot de passe</div>
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
                            <input type="password" class="input-dark" id="new_pwd" name="new_password" placeholder="Min. 8 caractères" required oninput="evalPwdStrength(this.value)">
                        </div>
                        <div class="pwd-strength"><div class="pwd-strength-fill" id="pwd-strength-fill"></div></div>
                        <div style="display:flex;justify-content:space-between;margin-top:6px;">
                            <small id="pwd-strength-label" style="font-size:11px;color:var(--muted);"></small>
                            <small style="font-size:11px;color:var(--muted);">Maj + chiffre + symbole = fort</small>
                        </div>
                    </div>
                    <div style="margin-bottom:28px;">
                        <label class="form-label-dark">Confirmer le nouveau mot de passe</label>
                        <div class="input-group-dark">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" class="input-dark" id="confirm_pwd" name="confirm_password" placeholder="Répétez le mot de passe" required oninput="checkPwdMatch()">
                        </div>
                        <small id="pwd-match-msg" style="font-size:12px;margin-top:6px;display:block;"></small>
                    </div>
                    <div style="display:flex;gap:12px;">
                        <button type="submit" class="btn-blue"><i class="bi bi-shield-check"></i> Mettre à jour</button>
                        <button type="button" class="btn-ghost" onclick="document.getElementById('pwd-form').reset();document.getElementById('pwd-strength-fill').style.width='0%';">Annuler</button>
                    </div>
                </form>
                <hr style="border-color:var(--border);margin:32px 0;">
                <div style="background:rgba(239,68,68,0.05);border:1px solid rgba(239,68,68,0.15);border-radius:var(--radius);padding:20px;">
                    <div style="font-weight:700;color:var(--danger);margin-bottom:6px;display:flex;align-items:center;gap:8px;">
                        <i class="bi bi-exclamation-triangle-fill"></i> Zone dangereuse
                    </div>
                    <p style="font-size:13px;color:var(--muted2);margin-bottom:16px;">La suppression de votre compte est irréversible. Toutes vos données seront perdues.</p>
                    <button class="btn-danger" onclick="confirmDelete()"><i class="bi bi-trash3"></i> Supprimer mon compte</button>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>

<script>
// ==================== NAVIGATION ====================
function showSection(id, btn) {
    document.querySelectorAll('.page-section').forEach(s => s.classList.remove('active'));
    const target = document.getElementById('section-' + id);
    if (target) {
        target.classList.add('active');
        target.classList.remove('fade-in');
        void target.offsetWidth;
        target.classList.add('fade-in');
    }
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    if (btn) btn.classList.add('active');
    const titles = {
        profil:     ['Mon Profil', '/ Vue d\'ensemble'],
        portfolios: ['Mes Portfolios', '/ Gérer'],
        stats:      ['Statistiques', '/ Analyse'],
        editprofil: ['Modifier Profil', '/ Édition'],
        password:   ['Sécurité', '/ Mot de passe'],
    };
    const t = titles[id] || ['Dashboard',''];
    document.getElementById('topbar-title').innerHTML = t[0] + ' <span>' + t[1] + '</span>';
}

// ==================== AVATAR ====================
function handleAvatarUpload(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    if (file.size > 2 * 1024 * 1024) {
        alert('Image trop lourde. Maximum 2 Mo.');
        return;
    }
    const reader = new FileReader();
    reader.onload = function(e) {
        const src = e.target.result;
        localStorage.setItem('pg_avatar_' + <?= $uid ?>, src);
        applyAvatar(src);
    };
    reader.readAsDataURL(file);
}

function applyAvatar(src) {
    // Topbar
    document.getElementById('topbar-initials').style.display = 'none';
    const timg = document.getElementById('topbar-avatar-img');
    timg.src = src; timg.style.display = 'block';
    // Hero profil
    document.getElementById('avatar-initials-lg').style.display = 'none';
    const limg = document.getElementById('avatar-img-lg');
    limg.src = src; limg.style.display = 'block';
    // Edit section
    document.getElementById('edit-avatar-initials').style.display = 'none';
    const eimg = document.getElementById('edit-avatar-img');
    eimg.src = src; eimg.style.display = 'block';
    // Complétion
    updateCompletion();
}

function removeAvatar() {
    localStorage.removeItem('pg_avatar_' + <?= $uid ?>);
    ['topbar-avatar-img','avatar-img-lg','edit-avatar-img'].forEach(id => {
        const el = document.getElementById(id);
        el.src = ''; el.style.display = 'none';
    });
    ['topbar-initials','avatar-initials-lg','edit-avatar-initials'].forEach(id => {
        document.getElementById(id).style.display = '';
    });
    updateCompletion();
}

// ==================== PROFIL INFO ====================
function applyProfileData(data) {
    // Bio dans le hero
    const bioEl = document.getElementById('bio-preview-hero');
    if (data.bio) { bioEl.textContent = data.bio; bioEl.style.display = 'block'; }
    else { bioEl.style.display = 'none'; }

    // Poste
    if (data.poste) {
        document.getElementById('info-poste').style.display = 'flex';
        document.getElementById('info-poste-val').textContent = data.poste;
    } else {
        document.getElementById('info-poste').style.display = 'none';
    }

    // Localisation
    if (data.location) {
        document.getElementById('info-localisation').style.display = 'flex';
        document.getElementById('info-loc-val').textContent = '📍 ' + data.location;
    } else {
        document.getElementById('info-localisation').style.display = 'none';
    }

    // Site web — lien cliquable
    if (data.website) {
        document.getElementById('info-site').style.display = 'flex';
        const a = document.getElementById('info-site-val');
        a.textContent = data.website.replace(/^https?:\/\//,'');
        a.href = data.website.startsWith('http') ? data.website : 'https://' + data.website;
        a.target = '_blank';
        a.rel = 'noopener noreferrer';
    } else {
        document.getElementById('info-site').style.display = 'none';
    }

    updateCompletion();
}

function updateBioCounter(el) {
    document.getElementById('bio-counter').textContent = el.value.length;
}

// ==================== RÉSEAUX SOCIAUX ====================
const SOCIAL_CONFIG = {
    linkedin:  { icon:'linkedin',  color:'#0A66C2', bg:'rgba(10,102,194,0.12)',  url:'https://linkedin.com/in/',  label:'LinkedIn'  },
    github:    { icon:'github',    color:'#e6edf3', bg:'rgba(230,237,243,0.10)', url:'https://github.com/',       label:'GitHub'    },
    twitter:   { icon:'twitter-x', color:'#1DA1F2', bg:'rgba(29,161,242,0.12)',  url:'https://twitter.com/',      label:'Twitter/X' },
    instagram: { icon:'instagram', color:'#E1306C', bg:'rgba(225,48,108,0.12)',  url:'https://instagram.com/',    label:'Instagram' },
};

function applySocials(s) {
    // 1. Icônes dans le hero (petits boutons)
    const heroContainer = document.getElementById('social-links-hero');
    heroContainer.innerHTML = '';
    // 2. Tableau dans la section infos du profil
    let infoSocialsEl = document.getElementById('info-socials-row');
    if (!infoSocialsEl) {
        // Créer la ligne si elle n'existe pas
        const infoCard = document.querySelector('#section-profil .card-dark-body');
        const row = document.createElement('div');
        row.className = 'info-row';
        row.id = 'info-socials-row';
        row.style.display = 'none';
        row.innerHTML = '<span class="info-key">Réseaux</span><span class="info-val" id="info-socials-val" style="display:flex;gap:8px;flex-wrap:wrap;"></span>';
        if (infoCard) infoCard.appendChild(row);
        infoSocialsEl = row;
    }
    const infoSocialsVal = document.getElementById('info-socials-val');
    if (infoSocialsVal) infoSocialsVal.innerHTML = '';

    let hasSocial = false;
    Object.keys(s).forEach(k => {
        if (!s[k]) return;
        hasSocial = true;
        const cfg = SOCIAL_CONFIG[k];
        const fullUrl = cfg.url + s[k];

        // Icône hero
        const aHero = document.createElement('a');
        aHero.href = fullUrl;
        aHero.target = '_blank';
        aHero.rel = 'noopener noreferrer';
        aHero.title = cfg.label + ': @' + s[k];
        aHero.style.cssText = `width:34px;height:34px;border-radius:9px;background:${cfg.bg};border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:${cfg.color};font-size:16px;text-decoration:none;transition:transform .15s,box-shadow .15s;`;
        aHero.innerHTML = `<i class="bi bi-${cfg.icon}"></i>`;
        aHero.onmouseenter = () => { aHero.style.transform='translateY(-2px)'; aHero.style.boxShadow='0 4px 12px rgba(0,0,0,0.3)'; };
        aHero.onmouseleave = () => { aHero.style.transform=''; aHero.style.boxShadow=''; };
        heroContainer.appendChild(aHero);

        // Badge cliquable dans infos
        if (infoSocialsVal) {
            const badge = document.createElement('a');
            badge.href = fullUrl;
            badge.target = '_blank';
            badge.rel = 'noopener noreferrer';
            badge.style.cssText = `display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:${cfg.bg};border:1px solid var(--border);border-radius:100px;color:${cfg.color};font-size:12px;font-weight:600;text-decoration:none;transition:all .2s;`;
            badge.innerHTML = `<i class="bi bi-${cfg.icon}"></i> @${s[k]}`;
            badge.onmouseenter = () => { badge.style.borderColor = cfg.color; badge.style.transform='translateY(-1px)'; };
            badge.onmouseleave = () => { badge.style.borderColor = 'var(--border)'; badge.style.transform=''; };
            infoSocialsVal.appendChild(badge);
        }
    });

    if (infoSocialsEl) infoSocialsEl.style.display = hasSocial ? 'flex' : 'none';
    updateCompletion();
}

// ==================== ENREGISTRER TOUT ====================
function saveAll() {
    const btn = document.getElementById('btn-save-all');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat" style="animation:spin .7s linear infinite;display:inline-block;"></i> Enregistrement...';

    // Profil
    const profileData = {
        nom:      document.getElementById('edit-nom').value.trim(),
        poste:    document.getElementById('edit-poste').value.trim(),
        location: document.getElementById('edit-location').value.trim(),
        website:  document.getElementById('edit-website').value.trim(),
        bio:      document.getElementById('edit-bio').value.trim(),
    };
    localStorage.setItem('pg_profile_' + <?= $uid ?>, JSON.stringify(profileData));
    applyProfileData(profileData);

    // Réseaux sociaux
    const socials = {
        linkedin:  document.getElementById('social-linkedin').value.trim(),
        github:    document.getElementById('social-github').value.trim(),
        twitter:   document.getElementById('social-twitter').value.trim(),
        instagram: document.getElementById('social-instagram').value.trim(),
    };
    localStorage.setItem('pg_socials_' + <?= $uid ?>, JSON.stringify(socials));
    applySocials(socials);

    // Compétences déjà sauvegardées en temps réel
    saveSkills();

    // Feedback + redirection
    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check2-all"></i> Enregistrer toutes les modifications';
        const status = document.getElementById('save-all-status');
        status.style.display = 'inline-flex';

        setTimeout(() => {
            status.style.display = 'none';
            showSection('profil', document.querySelectorAll('.nav-item')[0]);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }, 1000);
    }, 650);
}

// ==================== COMPÉTENCES ====================
let skills = [];

function addSkill() {
    const input = document.getElementById('skill-input');
    const val = input.value.trim();
    if (!val || skills.includes(val)) { input.value = ''; return; }
    skills.push(val);
    input.value = '';
    renderSkills();
    saveSkills();
}

function removeSkill(s) {
    skills = skills.filter(x => x !== s);
    renderSkills();
    saveSkills();
}

function renderSkills() {
    const container = document.getElementById('skills-tags');
    const hint = document.getElementById('skills-empty-hint');
    const display = document.getElementById('skills-display');
    container.innerHTML = '';

    if (skills.length === 0) {
        hint && (hint.style.display = '');
        if (display) display.innerHTML = '<p style="color:var(--muted);font-size:13px;">Aucune compétence ajoutée. <button onclick="showSection(\'editprofil\',document.querySelectorAll(\'.nav-item\')[3])" style="background:none;border:none;color:var(--blue);cursor:pointer;font-size:13px;font-family:inherit;">Ajouter des compétences →</button></p>';
        return;
    }

    if (hint) hint.style.display = 'none';

    skills.forEach(s => {
        const tag = document.createElement('span');
        tag.className = 'skill-tag';
        tag.innerHTML = `${s} <span class="remove-skill" onclick="removeSkill('${s.replace(/'/g,"\\'")}')">×</span>`;
        container.appendChild(tag);
    });

    // Mise à jour affichage profil
    if (display) {
        display.innerHTML = '';
        skills.forEach(s => {
            const t = document.createElement('span');
            t.className = 'skill-tag';
            t.textContent = s;
            display.appendChild(t);
        });
    }
    updateCompletion();
}

function saveSkills() {
    localStorage.setItem('pg_skills_' + <?= $uid ?>, JSON.stringify(skills));
}

// ==================== COMPLÉTION ====================
function updateCompletion() {
    let score = 10; // compte créé = 10%
    const hasAvatar = !!localStorage.getItem('pg_avatar_' + <?= $uid ?>);
    const profile   = JSON.parse(localStorage.getItem('pg_profile_' + <?= $uid ?>) || '{}');
    const socials   = JSON.parse(localStorage.getItem('pg_socials_' + <?= $uid ?>) || '{}');
    const hasSocial = Object.values(socials).some(v => v);
    const hasSkills = skills.length > 0;
    const hasPortfolio = <?= $nb_portfolios > 0 ? 'true' : 'false' ?>;

    // Items check
    setCheckItem('check-avatar',    hasAvatar,  15);
    setCheckItem('check-bio',       !!profile.bio,  15);
    setCheckItem('check-social',    hasSocial,  15);
    setCheckItem('check-skills',    hasSkills,  15);
    // Portfolio item déjà rendu côté PHP mais on gère le score
    if (hasAvatar)    score += 15;
    if (profile.bio)  score += 15;
    if (hasSocial)    score += 15;
    if (hasSkills)    score += 15;
    if (hasPortfolio) score += 25;

    score = Math.min(score, 100);
    document.getElementById('completion-fill').style.width = score + '%';
    document.getElementById('completion-pct').textContent = score + '%';
}

function setCheckItem(id, done, pts) {
    const el = document.getElementById(id);
    if (!el) return;
    const dot = el.querySelector('.check-dot');
    const label = el.querySelector('span:not(.check-dot)');
    dot.className = 'check-dot ' + (done ? 'done' : 'todo');
    dot.innerHTML = done ? '<i class="bi bi-check"></i>' : '<i class="bi bi-dash"></i>';
    if (label) label.style.color = done ? '' : 'var(--muted2)';
}

// ==================== MDP ====================
function evalPwdStrength(val) {
    const fill = document.getElementById('pwd-strength-fill');
    const label = document.getElementById('pwd-strength-label');
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const lvl = [{w:'0%',c:'transparent',t:''},{w:'25%',c:'#ef4444',t:'Faible'},{w:'50%',c:'#f59e0b',t:'Moyen'},{w:'75%',c:'#38bdf8',t:'Bon'},{w:'100%',c:'#22c55e',t:'Fort ✓'}];
    fill.style.width = lvl[score].w;
    fill.style.background = lvl[score].c;
    label.textContent = lvl[score].t;
    label.style.color = lvl[score].c;
}

function checkPwdMatch() {
    const np = document.getElementById('new_pwd').value;
    const cp = document.getElementById('confirm_pwd').value;
    const msg = document.getElementById('pwd-match-msg');
    if (!cp) { msg.textContent = ''; return true; }
    if (np === cp) { msg.textContent = '✓ Les mots de passe correspondent'; msg.style.color='#22c55e'; return true; }
    msg.textContent = '✗ Ne correspondent pas'; msg.style.color='#ef4444'; return false;
}

function validatePwdForm() {
    if (!checkPwdMatch()) return false;
    if (document.getElementById('new_pwd').value.length < 8) {
        showPwdAlert('Le mot de passe doit faire au moins 8 caractères.','error');
        return false;
    }
    return true;
}

function showPwdAlert(msg, type) {
    const el = document.getElementById('pwd-alert');
    el.innerHTML = `<div class="alert-dark ${type}"><i class="bi bi-${type==='success'?'check-circle-fill':'exclamation-triangle-fill'}"></i>${msg}</div>`;
    setTimeout(()=>el.innerHTML='', 5000);
}

function showEditAlert(msg, type) {
    const el = document.getElementById('edit-alert');
    if (!el) return;
    el.innerHTML = `<div class="alert-dark ${type}"><i class="bi bi-${type==='success'?'check-circle-fill':'exclamation-triangle-fill'}"></i>${msg}</div>`;
    setTimeout(()=>el.innerHTML='', 4000);
}

function confirmDelete() {
    if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer votre compte ?\n\nCette action est irréversible.')) {
        window.location.href = 'delete_account.php';
    }
}

function deletePortfolio(id) {
    if (confirm('Supprimer ce portfolio ? Cette action est irréversible.')) {
        window.location.href = 'delete_portfolio.php?id=' + id;
    }
}

// ==================== INIT ====================
window.addEventListener('load', () => {
    const uid = <?= $uid ?>;

    // Charger avatar
    const savedAvatar = localStorage.getItem('pg_avatar_' + uid);
    if (savedAvatar) applyAvatar(savedAvatar);

    // Charger profil
    const savedProfile = JSON.parse(localStorage.getItem('pg_profile_' + uid) || '{}');
    if (savedProfile.poste)    document.getElementById('edit-poste').value    = savedProfile.poste;
    if (savedProfile.location) document.getElementById('edit-location').value = savedProfile.location;
    if (savedProfile.website)  document.getElementById('edit-website').value  = savedProfile.website;
    if (savedProfile.bio) {
        document.getElementById('edit-bio').value = savedProfile.bio;
        document.getElementById('bio-counter').textContent = savedProfile.bio.length;
    }
    if (Object.keys(savedProfile).length) applyProfileData(savedProfile);

    // Charger socials
    const savedSocials = JSON.parse(localStorage.getItem('pg_socials_' + uid) || '{}');
    if (savedSocials.linkedin)  document.getElementById('social-linkedin').value  = savedSocials.linkedin;
    if (savedSocials.github)    document.getElementById('social-github').value    = savedSocials.github;
    if (savedSocials.twitter)   document.getElementById('social-twitter').value   = savedSocials.twitter;
    if (savedSocials.instagram) document.getElementById('social-instagram').value = savedSocials.instagram;
    if (Object.keys(savedSocials).length) applySocials(savedSocials);

    // Charger skills
    const savedSkills = JSON.parse(localStorage.getItem('pg_skills_' + uid) || '[]');
    skills = savedSkills;
    renderSkills();

    // Complétion
    updateCompletion();
});
</script>
</body>
</html>
