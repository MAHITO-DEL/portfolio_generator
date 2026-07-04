<?php
/**
 * auth2/check_reset_token.php
 * API AJAX — Vérifie si un token de reset est valide et non expiré.
 * Appelé depuis modals.php avant d'ouvrir le modal reset.
 */

header('Content-Type: application/json');

session_start();
require_once __DIR__ . '/../php/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['valid' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$token = trim($input['token'] ?? '');

if (empty($token)) {
    echo json_encode(['valid' => false, 'error' => 'Token manquant']);
    exit;
}

try {
    $stmt = $conn->prepare(
        'SELECT id_user FROM users
          WHERE reset_token = ?
            AND reset_expires > NOW()
          LIMIT 1'
    );
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        echo json_encode(['valid' => true]);
    } else {
        echo json_encode(['valid' => false, 'error' => 'Token invalide ou expiré']);
    }
} catch (Exception $e) {
    echo json_encode(['valid' => false, 'error' => 'Erreur serveur']);
}