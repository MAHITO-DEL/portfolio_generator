<?php
session_start();
require_once 'php/config.php';

if (isset($_SESSION['id_user'])) {
    header('Location: dashboard.php');
    exit;
}

$erreur = '';
$nom    = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom      = trim($_POST['nom']      ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm']  ?? '');

    if (empty($nom) || empty($email) || empty($password) || empty($confirm)) {
        $erreur = 'Tous les champs sont obligatoires.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = 'Adresse email invalide.';

    } elseif (strlen($password) < 8) {
        $erreur = 'Le mot de passe doit contenir au moins 8 caractères.';

    } elseif ($password !== $confirm) {
        $erreur = 'Les mots de passe ne correspondent pas.';

    } else {
        // Vérifier si l'email existe déjà
        $stmt = $conn->prepare('SELECT id_user FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $erreur = 'Cet email est déjà utilisé.';
        } else {
            // Insérer le nouvel utilisateur
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare('INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nom, $email, $hash, 'user']);

            $_SESSION['msg_succes'] = 'Compte créé ! Vous pouvez maintenant vous connecter.';
            header('Location: login.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Portfolio</title>
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
            max-width: 440px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 32px rgba(0,0,0,.10);
        }
        .card-header {
            background: #198754;
            color: #fff;
            border-radius: 16px 16px 0 0 !important;
            text-align: center;
            padding: 1.6rem;
        }
        .card-header h4 { margin: 0; font-weight: 700; }
        .card-header p  { margin: .3rem 0 0; opacity: .8; font-size: .88rem; }
        .card-body { padding: 2rem; }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <i class="bi bi-person-plus-fill fs-2 d-block mb-1"></i>
        <h4>Créer un compte</h4>
        <p>Rejoignez Portfolio Pro</p>
    </div>

    <div class="card-body">

        <?php if ($erreur): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">

            <div class="mb-3">
                <label for="nom" class="form-label fw-semibold">Nom complet</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" id="nom" name="nom" class="form-control"
                        placeholder="Jean Dupont"
                        value="<?= htmlspecialchars($nom) ?>"
                        required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="votre@email.com"
                        value="<?= htmlspecialchars($email) ?>"
                        required>
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Min. 8 caractères"
                        required oninput="evalForce(this.value)">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('password', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <div class="bg-light rounded mt-1" style="height:5px">
                    <div id="pwdBar" style="width:0%;height:100%;border-radius:3px;transition:width .3s,background .3s"></div>
                </div>
                <small id="pwdLabel" class="text-muted"></small>
            </div>

            <div class="mb-4">
                <label for="confirm" class="form-label fw-semibold">Confirmer le mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" id="confirm" name="confirm" class="form-control"
                        placeholder="Répétez le mot de passe"
                        required oninput="checkMatch()">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('confirm', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <small id="matchMsg"></small>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-person-check me-2"></i>Créer mon compte
                </button>
            </div>

        </form>

        <hr>
        <p class="text-center mb-0 text-muted" style="font-size:.9rem">
            Déjà un compte ?
            <a href="login.php" class="text-primary fw-semibold">Se connecter</a>
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