<?php
session_start();
require_once 'php/config.php';

if (isset($_SESSION['id_user'])) {
    header('Location: ../index.php');
    exit;
}

$erreur = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $erreur = 'Tous les champs sont obligatoires.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = 'Adresse email invalide.';

    } else {
        $stmt = $conn->prepare('SELECT id_user, nom, email, password, role FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nom']     = $user['nom'];
            $_SESSION['email']   = $user['email'];
            $_SESSION['role']    = $user['role'];
            header('Location: ../index.php');
            exit;
        } else {
            $erreur = 'Email ou mot de passe incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Portfolio</title>
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
        .card-header p  { margin: .3rem 0 0; opacity: .8; font-size: .88rem; }
        .card-body { padding: 2rem; }
        .btn-primary { background: #2C6BED; border-color: #2C6BED; }
        .btn-primary:hover { background: #1a4fc4; border-color: #1a4fc4; }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <i class="bi bi-person-lock fs-2 d-block mb-1"></i>
        <h4>Connexion</h4>
        <p>Accédez à votre espace Portfolio</p>
    </div>

    <div class="card-body">

        <?php if ($erreur): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 py-2">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['msg_succes'])): ?>
            <div class="alert alert-success d-flex align-items-center gap-2 py-2">
                <i class="bi bi-check-circle-fill"></i>
                <?= htmlspecialchars($_SESSION['msg_succes']) ?>
            </div>
            <?php unset($_SESSION['msg_succes']); ?>
        <?php endif; ?>

        <form method="POST" action="">

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="votre@email.com"
                        value="<?= htmlspecialchars($email) ?>"
                        required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="••••••••" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('password', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </button>
            </div>

        </form>

        <hr>
        <p class="text-center mb-0 text-muted" style="font-size:.9rem">
            Pas encore de compte ?
            <a href="register.php" class="text-primary fw-semibold">Créer un compte</a>
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
</script>
</body>
</html>