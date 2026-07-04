<?php
session_start();

// Gérer les requêtes AJAX pour les favoris
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['template'])) {
        echo json_encode(['success' => false, 'message' => 'Template name missing']);
        exit;
    }
    
    // Initialiser le tableau des favoris en session
    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }
    
    $template = $data['template'];
    $action = $data['action'] ?? 'add';
    
    if ($action === 'add') {
        // Ajouter aux favoris si pas déjà présent
        if (!in_array($template, $_SESSION['favorites'])) {
            $_SESSION['favorites'][] = $template;
        }
    } elseif ($action === 'remove') {
        // Retirer des favoris
        $_SESSION['favorites'] = array_filter($_SESSION['favorites'], function($fav) use ($template) {
            return $fav !== $template;
        });
        $_SESSION['favorites'] = array_values($_SESSION['favorites']); // Réindexer
    }
    
    echo json_encode([
        'success' => true,
        'favorites' => $_SESSION['favorites'],
        'message' => 'Favorite updated'
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>