<?php
// ================================================
//  reset_password.php — Nouveau mot de passe
// ================================================
session_start();
require_once 'php/config.php';

$token   = trim($_GET['token'] ?? '');
$erreur  = '';
$succes  = '';
$valide  = false;

// ── Vérifier le token ────────────────────────
if (empty($token)) {
    $erreur = 'Lien invalide ou manquant.';
} else {
    $stmt = $conn->prepare(
        'SELECT id_user FROM users
          WHERE reset_token = ?
            AND reset_expires > NOW()
          LIMIT 1'
    );
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $valide = true;
    } else {
        $erreur = 'Ce lien est invalide ou a expiré. Veuillez refaire une demande.';
    }
}

// ── Traitement du nouveau mot de passe ───────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valide) {

    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm']  ?? '');

    if (empty($password) || empty($confirm)) {
        $erreur = 'Tous les champs sont obligatoires.';

    } elseif (strlen($password) < 8) {
        $erreur = 'Le mot de passe doit contenir au moins 8 caractères.';

    } elseif (!preg_match('/[A-Z]/', $password)) {
        $erreur = 'Le mot de passe doit contenir au moins une majuscule.';

    } elseif (!preg_match('/[0-9]/', $password)) {
        $erreur = 'Le mot de passe doit contenir au moins un chiffre.';

    } elseif ($password !== $confirm) {
        $erreur = 'Les mots de passe ne correspondent pas.';

    } else {
        // Mettre à jour le mot de passe et effacer le token
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare(
            'UPDATE users
                SET password = ?, reset_token = NULL, reset_expires = NULL
              WHERE reset_token = ?'
        );
        $stmt->execute([$hash, $token]);

        $succes = 'Mot de passe modifié avec succès !';
        $valide = false; // cacher le formulaire
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe — Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f5fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 32px rgba(0,0,0,.10);
        }
        .card-header {
            background: #2C6BED;
            color: #fff;
            border-radius: 16px 16px 0 0 !important;
            text-align: center;
            padding: 1.6rem;
        }
        .card-header h4 { margin: 0; font-weight: 700; }
        .card-header p  { margin: .3rem 0 0; opacity: .85; font-size: .88rem; }
        .card-body { padding: 2rem; }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <i class="bi bi-shield-lock-fill fs-2 d-block mb-1"></i>
        <h4>Nouveau mot de passe</h4>
        <p>Choisissez un nouveau mot de passe sécurisé</p>
    </div>

    <div class="card-body">

        <!-- Erreur -->
        <?php if ($erreur): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <!-- Succès -->
        <?php if ($succes): ?>
            <div class="alert alert-success d-flex align-items-center gap-2 py-2">
                <i class="bi bi-check-circle-fill"></i>
                <?= htmlspecialchars($succes) ?>
            </div>
            <div class="d-grid mt-3">
                <a href="login.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </a>
            </div>

        <!-- Formulaire -->
        <?php elseif ($valide): ?>
            <form method="POST" action="reset_password.php?token=<?= urlencode($token) ?>">

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Min. 8 car., 1 majuscule, 1 chiffre"
                            required
                            autofocus
                            oninput="evalForce(this.value)"
                        >
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <!-- Barre de force -->
                    <div class="bg-light rounded mt-1" style="height:5px">
                        <div id="pwdBar" style="width:0%;height:100%;border-radius:3px;transition:width .3s,background .3s"></div>
                    </div>
                    <small id="pwdLabel" class="text-muted"></small>
                </div>

                <div class="mb-4">
                    <label for="confirm" class="form-label fw-semibold">Confirmer le mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input
                            type="password"
                            id="confirm"
                            name="confirm"
                            class="form-control"
                            placeholder="Répétez le mot de passe"
                            required
                            oninput="checkMatch()"
                        >
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('confirm', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <small id="matchMsg"></small>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-lg me-2"></i>Réinitialiser le mot de passe
                    </button>
                </div>

            </form>

        <!-- Lien invalide -->
        <?php else: ?>
            <div class="d-grid mt-2">
                <a href="forgot_password.php" class="btn btn-warning btn-lg">
                    <i class="bi bi-arrow-repeat me-2"></i>Refaire une demande
                </a>
            </div>
        <?php endif; ?>

        <hr>
        <p class="text-center mb-0 text-muted" style="font-size:.9rem">
            <a href="login.php" class="text-primary fw-semibold">
                <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
            </a>
        </p>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}

function evalForce(val) {
    const bar = document.getElementById('pwdBar');
    const lbl = document.getElementById('pwdLabel');
    let score = 0;
    if (val.length >= 8)            score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        { w:'0%',   c:'#dee2e6', t:'' },
        { w:'25%',  c:'#dc3545', t:'Faible' },
        { w:'50%',  c:'#fd7e14', t:'Moyen' },
        { w:'75%',  c:'#ffc107', t:'Bon' },
        { w:'100%', c:'#198754', t:'Fort ✓' },
    ];
    bar.style.width      = levels[score].w;
    bar.style.background = levels[score].c;
    lbl.textContent      = levels[score].t;
    lbl.style.color      = levels[score].c;
}

function checkMatch() {
    const pwd = document.getElementById('password').value;
    const cfm = document.getElementById('confirm').value;
    const msg = document.getElementById('matchMsg');
    if (!cfm) { msg.textContent = ''; return; }
    if (pwd === cfm) {
        msg.textContent = '✓ Les mots de passe correspondent';
        msg.style.color = '#198754';
    } else {
        msg.textContent = '✗ Ne correspondent pas';
        msg.style.color = '#dc3545';
    }
}
</script>
</body>
</html>