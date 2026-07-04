/**
 * assets/js/avatar-sync.js
 * ─────────────────────────────────────────────────────────────
 * Lit la photo de profil sauvegardée dans localStorage
 * et l'injecte dans TOUS les éléments avatar de la navbar,
 * quelle que soit la page (index, explore, templates, about...).
 *
 * Inclure via includes/header.php :
 *   <script src="assets/js/avatar-sync.js?v=1" defer></script>
 *
 * La clé localStorage est : pg_avatar_{user_id}
 * Le user_id PHP est passé via une meta tag dans header.php :
 *   <meta name="pg-uid" content="<?= $_SESSION['id_user'] ?? 0 ?>">
 * ─────────────────────────────────────────────────────────────
 */

(function () {
    'use strict';

    /* Récupérer l'UID depuis la meta tag injectée par header.php */
    function getUID() {
        const meta = document.querySelector('meta[name="pg-uid"]');
        return meta ? parseInt(meta.content, 10) || 0 : 0;
    }

    /* Sauvegarder l'avatar (appelé depuis dashboard.php aussi) */
    window.pgAvatarSave = function (dataUrl) {
        const uid = getUID();
        if (!uid || !dataUrl) return;
        try { localStorage.setItem('pg_avatar_' + uid, dataUrl); } catch (e) {}
        applyAvatar(dataUrl);
    };

    /* Supprimer l'avatar */
    window.pgAvatarRemove = function () {
        const uid = getUID();
        if (uid) { try { localStorage.removeItem('pg_avatar_' + uid); } catch (e) {} }
        applyAvatar(null);
    };

    /* Injecter l'avatar dans tous les éléments de la navbar */
    function applyAvatar(src) {
        /*
         * Sélecteurs couverts :
         *   .nav-avatar          → classe générique attendue dans header.php
         *   .avatar-nav          → variante
         *   #nav-user-avatar     → id spécifique
         *   .user-avatar-img     → img déjà présente
         *   [data-avatar="user"] → attribut data
         *
         * Pour chaque cible :
         *   - Si c'est un <img> → on change src
         *   - Sinon → on cherche le <img> enfant ou on remplace le texte (initiales)
         */
        const targets = document.querySelectorAll(
            '.nav-avatar, .avatar-nav, #nav-user-avatar, .user-avatar-img, [data-avatar="user"]'
        );

        targets.forEach(function (el) {
            _injectIntoTarget(el, src);
        });

        /* Cas spécifique de la structure existante dans header.php du projet */
        _syncHeaderUserMenu(src);
    }

    function _injectIntoTarget(el, src) {
        if (!el) return;

        if (el.tagName === 'IMG') {
            if (src) {
                el.src = src;
                el.style.display = '';
                /* Masquer les initiales voisines */
                const initEl = el.parentElement.querySelector('.nav-initials, .user-initials, .avatar-initials');
                if (initEl) initEl.style.display = 'none';
            } else {
                el.src = '';
                el.style.display = 'none';
                const initEl = el.parentElement.querySelector('.nav-initials, .user-initials, .avatar-initials');
                if (initEl) initEl.style.display = '';
            }
            return;
        }

        /* Wrapper div/span → chercher ou créer un <img> */
        let img = el.querySelector('img.pg-avatar-img');
        if (!img) {
            img = document.createElement('img');
            img.className = 'pg-avatar-img';
            img.alt       = 'Photo de profil';
            img.style.cssText = [
                'position:absolute',
                'inset:0',
                'width:100%',
                'height:100%',
                'object-fit:cover',
                'border-radius:50%',
                'display:none',
                'border:none',
                'outline:none',
                'box-shadow:none',
            ].join(';');
            /* Le wrapper doit être en position relative et overflow hidden */
            el.style.position = el.style.position || 'relative';
            el.style.overflow  = 'hidden';
            el.style.borderRadius = el.style.borderRadius || '50%';
            el.appendChild(img);
        }

        if (src) {
            img.src          = src;
            img.style.display = '';
            /* Cacher les initiales à l'intérieur du wrapper */
            el.childNodes.forEach(function (node) {
                if (node !== img && node.nodeType === 1) {
                    node.style.display = 'none';
                } else if (node.nodeType === 3 && node.textContent.trim()) {
                    /* nœud texte (initiales) */
                    node._pgOrigDisplay = node.textContent;
                    node.textContent = '';
                }
            });
        } else {
            img.style.display = 'none';
            img.src            = '';
            el.childNodes.forEach(function (node) {
                if (node !== img && node.nodeType === 1) {
                    node.style.display = '';
                } else if (node.nodeType === 3 && node._pgOrigDisplay) {
                    node.textContent = node._pgOrigDisplay;
                }
            });
        }
    }

    /*
     * Synchronisation spécifique pour la structure du header.php du projet.
     * Le header utilise typiquement :
     *   <div class="user-menu-trigger"> ... <div class="user-avatar"> SC </div> ...
     * On adapte ici selon ce qu'on observe dans les captures d'écran.
     */
    function _syncHeaderUserMenu(src) {
        /* Sélecteurs possibles selon la structure de header.php */
        const wrappers = document.querySelectorAll(
            '.user-avatar, .header-avatar, .nav-user-icon, ' +
            '.user-menu-avatar, #header-user-avatar, ' +
            '.user-btn .avatar, .user-dropdown-avatar'
        );

        wrappers.forEach(function (el) {
            _injectIntoTarget(el, src);
        });
    }

    /* Initialisation au chargement */
    function init() {
        /* Injecter un style global pour garantir l'arrondi sur tous les avatars */
        if (!document.getElementById('pg-avatar-style')) {
            const style = document.createElement('style');
            style.id = 'pg-avatar-style';
            style.textContent = [
                '.pg-avatar-img{border-radius:50%!important;object-fit:cover!important;border:none!important;outline:none!important;box-shadow:none!important;}',
                '.nav-avatar{border-radius:50%!important;overflow:hidden!important;}',
                '.user-avatar{border-radius:50%!important;overflow:hidden!important;}',
                '.header-avatar{border-radius:50%!important;overflow:hidden!important;}',
                '.nav-user-icon{border-radius:50%!important;overflow:hidden!important;}',
            ].join('');
            document.head.appendChild(style);
        }
        const uid = getUID();
        if (!uid) return; /* Pas connecté */

        let src = null;
        try { src = localStorage.getItem('pg_avatar_' + uid); } catch (e) {}

        if (src) applyAvatar(src);

        /* Écouter les changements de localStorage depuis d'autres onglets */
        window.addEventListener('storage', function (e) {
            if (e.key === 'pg_avatar_' + uid) {
                applyAvatar(e.newValue || null);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();