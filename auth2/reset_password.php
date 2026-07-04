<?php
/**
 * auth2/reset_password.php
 * Traite la soumission du formulaire de reset (POST depuis le modal).
 * Redirige ensuite vers index.php (avec ou sans message de succès/erreur).
 */

session_start();
require_once __DIR__ . '/../php/config.php';

/* ── Accepter uniquement POST ── */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$token    = trim($_POST['token']    ?? '');
$password = trim($_POST['password'] ?? '');
$confirm  = trim($_POST['confirm']  ?? '');

/* ── Validation basique côté serveur ── */
if (empty($token)) {
    $_SESSION['reset_erreur'] = 'Token manquant. Veuillez refaire une demande.';
    header('Location: ../index.php?reset_token=' . urlencode($token));
    exit;
}

if (empty($password) || empty($confirm)) {
    $_SESSION['reset_erreur'] = 'Tous les champs sont obligatoires.';
    header('Location: ../index.php?reset_token=' . urlencode($token));
    exit;
}

if (strlen($password) < 8) {
    $_SESSION['reset_erreur'] = 'Le mot de passe doit contenir au moins 8 caractères.';
    header('Location: ../index.php?reset_token=' . urlencode($token));
    exit;
}

if (!preg_match('/[A-Z]/', $password)) {
    $_SESSION['reset_erreur'] = 'Le mot de passe doit contenir au moins une majuscule.';
    header('Location: ../index.php?reset_token=' . urlencode($token));
    exit;
}

if (!preg_match('/[0-9]/', $password)) {
    $_SESSION['reset_erreur'] = 'Le mot de passe doit contenir au moins un chiffre.';
    header('Location: ../index.php?reset_token=' . urlencode($token));
    exit;
}

if ($password !== $confirm) {
    $_SESSION['reset_erreur'] = 'Les mots de passe ne correspondent pas.';
    header('Location: ../index.php?reset_token=' . urlencode($token));
    exit;
}

/* ── Vérifier le token en base ── */
try {
    $stmt = $conn->prepare(
        'SELECT id_user FROM users
          WHERE reset_token = ?
            AND reset_expires > NOW()
          LIMIT 1'
    );
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['reset_erreur'] = 'Ce lien est invalide ou a expiré. Veuillez refaire une demande.';
        header('Location: ../index.php?reset_token=' . urlencode($token));
        exit;
    }

    /* ── Mettre à jour le mot de passe ── */
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare(
        'UPDATE users
            SET password      = ?,
                reset_token   = NULL,
                reset_expires = NULL
          WHERE reset_token = ?'
    );
    $stmt->execute([$hash, $token]);

    /* ── Succès → ouvrir le modal reset avec message de succès ── */
    $_SESSION['reset_succes'] = 'Mot de passe modifié avec succès ! Vous pouvez maintenant vous connecter.';
    header('Location: ../index.php?reset_token=done');
    exit;

} catch (Exception $e) {
    $_SESSION['reset_erreur'] = 'Erreur serveur. Veuillez réessayer.';
    header('Location: ../index.php?reset_token=' . urlencode($token));
    exit;
}