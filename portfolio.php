<?php
require_once 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    die("Error: Portfolio ID is required.");
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM portfolios WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $portfolio = $stmt->fetch();

    if (!$portfolio) {
        http_response_code(404);
        die("Error: Portfolio not found.");
    }

    // Safely decode JSON fields (from form.php structure)
    // form.php sends: name, title, email, location, bio, skills (JSON), exp (array), proj (array), template
    $data = $portfolio;
    
    // Skills are already a JSON string from form
    $data['skills'] = isset($data['skills']) && !empty($data['skills']) 
        ? json_decode($data['skills'], true) 
        : [];
        
    // Experience (could be stored as 'exp' or 'experience' in DB)
    $expRaw = $data['exp'] ?? ($data['experience'] ?? '[]');
    $data['experience'] = is_string($expRaw) ? json_decode($expRaw, true) : $expRaw;
    if (!is_array($data['experience'])) $data['experience'] = [];

    // Projects (could be stored as 'proj' or 'projects' in DB)
    $projRaw = $data['proj'] ?? ($data['projects'] ?? '[]');
    $data['projects'] = is_string($projRaw) ? json_decode($projRaw, true) : $projRaw;
    if (!is_array($data['projects'])) $data['projects'] = [];

    // Identify the template
    $templateName = $data['template'] ?? 'minimal'; 
    
    // Sanitize template name to prevent directory traversal attacks
    $templateName = preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower($templateName));
    
    $templatePath = __DIR__ . "/templates/{$templateName}.php";

    // Load the template if it exists
    if (file_exists($templatePath)) {
        require $templatePath;
    } else {
        http_response_code(500);
        die("Error: The selected template '{$templateName}' does not exist.");
    }

} catch (\PDOException $e) {
    http_response_code(500);
    die("Database error: " . $e->getMessage());
}
?>