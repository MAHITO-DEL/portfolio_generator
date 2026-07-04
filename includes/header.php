<?php
/**
 * includes/header.php
 * Navbar principale + boutons d'authentification
 * Requiert : session_start() déjà appelé dans index.php
 */
?>
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

        <?php $current = basename($_SERVER['PHP_SELF']); ?>
        <nav class="main-nav" id="main-nav">
            <a href="index.php"    class="nav-link <?= $current === 'index.php'     ? 'active' : '' ?>">Home</a>
            <a href="explore.php"            class="nav-link">Explore</a>
            <a href="templates.php"          class="nav-link">Templates</a>
            <a href="about.php"            class="nav-link">About</a>
        </nav>

        <div class="auth-buttons">
            <!-- Lien Saved (Cœur) -->
            <a href="saved.php" class="nav-saved-link" id="nav-saved-link" title="Saved Templates">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" 
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                     stroke-linejoin="round" class="heart-icon">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span class="favorites-count" id="favorites-count">0</span>
            </a>

        <?php if (isset($_SESSION['id_user'])): ?>
            <!-- Utilisateur connecté : avatar cercle -->
            <div class="dropdown">
                <button class="user-avatar" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" title="<?= htmlspecialchars($_SESSION['nom']) ?>">
                    <?= strtoupper(mb_substr($_SESSION['nom'], 0, 1)) ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu">
                    <li class="dropdown-user-info">
                        <div class="user-avatar"><?= strtoupper(mb_substr($_SESSION['nom'], 0, 1)) ?></div>
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
    <meta name="pg-uid" content="<?= isset($_SESSION['id_user']) ? (int)$_SESSION['id_user'] : 0 ?>">
    <script src="assets/js/avatar-sync.js?v=1" defer></script>
</header>

<script>
    // Mettre à jour le compteur des favoris au chargement
    document.addEventListener('DOMContentLoaded', function() {
        updateFavoritesCount();
    });

    // Écouter les changements de localStorage pour mettre à jour le compteur
    window.addEventListener('storage', function() {
        updateFavoritesCount();
    });

    function updateFavoritesCount() {
        const favorites = JSON.parse(localStorage.getItem('portfolioFavorites')) || [];
        const countElement = document.getElementById('favorites-count');
        if (countElement) {
            countElement.textContent = favorites.length;
        }
    }
</script>

<style>
    .nav-saved-link {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #ef4444;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        padding: 8px 12px;
        border-radius: 8px;
    }

    .nav-saved-link:hover {
        color: #ef4444;
        opacity: 0.8;
    }

    .nav-saved-link:hover .heart-icon {
        stroke: #ef4444;
        transform: scale(1.1);
    }

    .heart-icon {
        transition: all 0.3s ease;
        stroke: #ef4444;
    }

    .favorites-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        min-width: 20px;
        height: 20px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        opacity: 1;
        transition: all 0.3s ease;
    }

    .favorites-count:empty {
        display: none;
    }
</style>