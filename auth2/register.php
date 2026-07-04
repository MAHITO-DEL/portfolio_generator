<?php
/**
 * auth2/register.php — Traitement inscription
 * Pas de HTML — stocke tout en session et redirige vers index.php
 * Le modal #registerModal s'ouvre automatiquement via includes/scripts.php
 * Après succès, le modal #loginModal s'ouvre avec un message de confirmation
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

$nom      = trim($_POST['nom']      ?? '');
$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');
$confirm  = trim($_POST['confirm']  ?? '');

// Validations
if (empty($nom) || empty($email) || empty($password) || empty($confirm)) {
    $_SESSION['register_erreur'] = 'Tous les champs sont obligatoires.';
    header('Location: ../index.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_erreur'] = 'Adresse email invalide.';
    header('Location: ../index.php');
    exit;
}

if (strlen($password) < 8) {
    $_SESSION['register_erreur'] = 'Le mot de passe doit contenir au moins 8 caractères.';
    header('Location: ../index.php');
    exit;
}

if ($password !== $confirm) {
    $_SESSION['register_erreur'] = 'Les mots de passe ne correspondent pas.';
    header('Location: ../index.php');
    exit;
}

// Vérifier si email déjà utilisé
$stmt = $conn->prepare('SELECT id_user FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);

if ($stmt->fetch()) {
    $_SESSION['register_erreur'] = 'Cet email est déjà utilisé.';
    header('Location: ../index.php');
    exit;
}

// Insertion
$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $conn->prepare('INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, ?)');
$stmt->execute([$nom, $email, $hash, 'user']);

// Succès → ouvre le modal login avec message de confirmation
$_SESSION['msg_succes'] = 'Compte créé avec succès ! Connectez-vous dès maintenant.';
header('Location: ../index.php');
exit;
