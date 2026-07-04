<?php
ob_start(); // Capture any accidental output (warnings, notices) before headers are sent.
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../generator/TemplateLoader.php';
require_once __DIR__ . '/../generator/TemplateGenerator.php';

$payload = json_decode(file_get_contents('php://input'), true);
if (!is_array($payload) || empty($payload['template'])) {
    ob_end_clean();
    echo json_encode(['success' => false, 'error' => 'No template selected.']);
    exit;
}

$templatePath = trim($payload['template']);
if (strpos($templatePath, 'portfolio_templates/') !== 0) {
    ob_end_clean();
    echo json_encode(['success' => false, 'error' => 'Invalid template path.']);
    exit;
}

try {
    $html = TemplateGenerator::generateFromTemplate($templatePath, $payload['data'] ?? []);
    
    $userId = $_SESSION['id_user'] ?? null;
    $jsonData = json_encode($payload['data'] ?? []);
    
    $stmt = $pdo->prepare("INSERT INTO user_portfolios (user_id, template_path, json_data, generated_html) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userId, $templatePath, $jsonData, $html]);
    $portfolioId = $pdo->lastInsertId();

    ob_end_clean(); // Discard any accidental output before sending clean JSON.
    echo json_encode([
        'success' => true, 
        'html' => $html,
        'portfolio_id' => $portfolioId
    ]);
} catch (Throwable $error) {
    ob_end_clean(); // Discard any accidental output.
    echo json_encode(['success' => false, 'error' => $error->getMessage()]);
}
