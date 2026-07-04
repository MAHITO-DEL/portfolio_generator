<?php
/**
 * auth2/login.php — Traitement connexion
 * Pas de HTML — stocke tout en session et redirige vers index.php
 * Le modal #loginModal s'ouvre automatiquement via includes/scripts.php
 */
session_start();
require_once 'php/config.php';

// Déjà connecté
if (isset($_SESSION['id_user'])) {
    header('Location: ../index.php');
    exit;
}

// Pas une requête POST → retour accueil
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');

// Validations
if (empty($email) || empty($password)) {
    $_SESSION['login_erreur'] = 'Tous les champs sont obligatoires.';
    header('Location: ../index.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_erreur'] = 'Adresse email invalide.';
    header('Location: ../index.php');
    exit;
}

// Vérification BDD
$stmt = $conn->prepare('SELECT id_user, nom, email, password, role FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Connexion réussie
    session_regenerate_id(true);
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['nom']     = $user['nom'];
    $_SESSION['email']   = $user['email'];
    $_SESSION['role']    = $user['role'];
    header('Location: ../index.php');
    exit;
} else {
    // Mauvais identifiants → modal login s'ouvre avec l'erreur
    $_SESSION['login_erreur'] = 'Email ou mot de passe incorrect.';
    header('Location: ../index.php');
    exit;
}
