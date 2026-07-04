<?php
/**
 * auth2/forgot_password.php
 * Génère un token de reset et envoie l'email (ou l'affiche en mode dev).
 * IMPORTANT : le lien pointe vers index.php?reset_token=xxx
 *             pour que le modal s'ouvre directement sur la page d'accueil.
 */

session_start();
require_once 'php/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$email = trim($_POST['email'] ?? '');

/* ── Validation email ── */
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['forgot_erreur'] = 'Adresse email invalide.';
    header('Location: ../index.php#forgot');
    exit;
}

try {
    /* ── Chercher l'utilisateur (réponse identique si trouvé ou non — sécurité) ── */
    $stmt = $conn->prepare('SELECT id_user FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        /* Générer un token sécurisé valable 1 heure */
        $token   = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 3600);

        $upd = $conn->prepare(
            'UPDATE users SET reset_token = ?, reset_expires = ? WHERE id_user = ?'
        );
        $upd->execute([$token, $expires, $user['id_user']]);

        /* ── Lien pointant vers index.php?reset_token= ── */
        $baseUrl  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
                  . '://' . $_SERVER['HTTP_HOST']
                  . rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
        $resetUrl = $baseUrl . '/index.php?reset_token=' . urlencode($token);

        /* ── Mode développement : afficher le lien dans le modal ── */
        $_SESSION['reset_lien'] = $resetUrl;

        /*
         * ── Production : envoyer l'email ──
         * Décommenter et configurer pour la production :
         *
         * $sujet = 'Réinitialisation de votre mot de passe — PortfolioGen';
         * $corps = "Bonjour,\n\nCliquez sur ce lien pour réinitialiser votre mot de passe :\n\n"
         *        . $resetUrl . "\n\nCe lien est valable 1 heure.\n\n"
         *        . "Si vous n'avez pas fait cette demande, ignorez cet email.\n\n"
         *        . "L'équipe PortfolioGen";
         * $headers = "From: noreply@portfoliogen.com\r\nContent-Type: text/plain; charset=UTF-8";
         * mail($email, $sujet, $corps, $headers);
         */
    }

    /* Réponse générique (ne pas révéler si l'email existe) */
    $_SESSION['forgot_succes'] = 'Si cet email existe, un lien de réinitialisation a été envoyé.';
    header('Location: ../index.php#forgot');
    exit;

} catch (Exception $e) {
    $_SESSION['forgot_erreur'] = 'Erreur serveur. Veuillez réessayer.';
    header('Location: ../index.php#forgot');
    exit;
}