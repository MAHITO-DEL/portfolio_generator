<?php
// ================================================
//  forgot_password.php — Demande de réinitialisation
// ================================================
session_start();
require_once 'php/config.php';

// Ajouter la colonne reset_token si elle n'existe pas encore
// (à faire une seule fois, ou via phpMyAdmin)
// ALTER TABLE users ADD COLUMN reset_token VARCHAR(64) NULL;
// ALTER TABLE users ADD COLUMN reset_expires DATETIME NULL;

$message = '';
$type    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Veuillez entrer une adresse email valide.';
        $type    = 'danger';

    } else {
        // Vérifier si l'email existe
        $stmt = $conn->prepare('SELECT id_user FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Générer un token unique
            $token   = bin2hex(random_bytes(32)); // 64 caractères
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Sauvegarder le token en base
            $stmt = $conn->prepare(
                'UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?'
            );
            $stmt->execute([$token, $expires, $email]);

            // Lien de réinitialisation
            $lien = 'http://' . $_SERVER['HTTP_HOST']
                  . dirname($_SERVER['PHP_SELF'])
                  . '/reset_password.php?token=' . $token;

            // ── Envoi email (PHP mail) ──────────────────────
            // En production, utilisez PHPMailer ou SMTP
            $sujet  = 'Réinitialisation de votre mot de passe — Portfolio';
            $corps  = "Bonjour,\n\n";
            $corps .= "Vous avez demandé à réinitialiser votre mot de passe.\n\n";
            $corps .= "Cliquez sur ce lien (valable 1 heure) :\n";
            $corps .= $lien . "\n\n";
            $corps .= "Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.\n\n";
            $corps .= "— Portfolio Pro";

            $headers = 'From: noreply@portfolio.com' . "\r\n";

            // mail($email, $sujet, $corps, $headers); // décommenter en production

            // ── Pour le développement : afficher le lien directement ──
            $_SESSION['reset_lien'] = $lien;
        }

        // Toujours afficher le même message (sécurité : ne pas révéler si l'email existe)
        $message = 'Si cet email existe, un lien de réinitialisation a été envoyé.';
        $type    = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — Portfolio</title>
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
            background: #f59e0b;
            color: #fff;
            border-radius: 16px 16px 0 0 !important;
            text-align: center;
            padding: 1.6rem;
        }
        .card-header h4 { margin: 0; font-weight: 700; }
        .card-header p  { margin: .3rem 0 0; opacity: .85; font-size: .88rem; }
        .card-body { padding: 2rem; }
        .btn-warning { background: #f59e0b; border-color: #f59e0b; color: #fff; }
        .btn-warning:hover { background: #d97706; border-color: #d97706; color: #fff; }
        .dev-box {
            background: #fffbeb;
            border: 1px dashed #f59e0b;
            border-radius: 10px;
            padding: 1rem;
            font-size: .82rem;
            word-break: break-all;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <i class="bi bi-key-fill fs-2 d-block mb-1"></i>
        <h4>Mot de passe oublié ?</h4>
        <p>Entrez votre email pour recevoir un lien de réinitialisation</p>
    </div>

    <div class="card-body">

        <?php if ($message): ?>
            <div class="alert alert-<?= $type ?> d-flex align-items-center gap-2 py-2">
                <i class="bi bi-<?= $type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?>"></i>
                <?= htmlspecialchars($message) ?>
            </div>

            <!-- ── DÉVELOPPEMENT UNIQUEMENT : afficher le lien ── -->
            <?php if (!empty($_SESSION['reset_lien'])): ?>
                <div class="dev-box mb-3">
                    <strong><i class="bi bi-code-slash me-1"></i>Mode dev — lien de réinitialisation :</strong><br>
                    <a href="<?= htmlspecialchars($_SESSION['reset_lien']) ?>">
                        <?= htmlspecialchars($_SESSION['reset_lien']) ?>
                    </a>
                </div>
                <?php unset($_SESSION['reset_lien']); ?>
            <?php endif; ?>
        <?php endif; ?>

        <form method="POST" action="">

            <div class="mb-4">
                <label for="email" class="form-label fw-semibold">Adresse email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="votre@email.com"
                        required
                        autofocus
                    >
                </div>
                <div class="form-text">Un lien valable <strong>1 heure</strong> vous sera envoyé.</div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="bi bi-send me-2"></i>Envoyer le lien
                </button>
            </div>

        </form>

        <hr>
        <p class="text-center mb-0 text-muted" style="font-size:.9rem">
            <a href="login.php" class="text-primary fw-semibold">
                <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
            </a>
        </p>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>