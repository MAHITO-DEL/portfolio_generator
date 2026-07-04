<?php
header('Content-Type: application/json');

$baseDir = '../portfolio_templates';
$templates = [];
$defaultImage = 'assets/images/default-preview.jpg';

function scanTemplates($dir) {
    global $baseDir, $templates, $defaultImage;
    $items = @scandir($dir);
    
    if (!$items) {
        return;
    }
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        
        $path = $dir . '/' . $item;
        
        if (is_dir($path)) {
            // Check if it's a template folder (contains index.html)
            if (file_exists($path . '/index.html')) {
                // Calculate relative path inside portfolio_templates
                $relativePath = substr($path, strlen($baseDir) + 1);
                $parts = explode('/', str_replace('\\', '/', $relativePath));
                
                // category is the first folder name, name is the second (or fallback)
                $category = count($parts) > 1 ? ucfirst($parts[0]) : 'Portfolio';
                $rawName = count($parts) > 1 ? $parts[count($parts) - 1] : $parts[0];
                $name = ucwords(str_replace(['-', '_'], ' ', $rawName));
                
                $publicPath = 'portfolio_templates/' . $relativePath . '/index.html';
                $preview = 'portfolio_templates/' . $relativePath . '/preview.jpg';
                
                // Check if preview exists
                if (!file_exists('../' . $preview)) {
                    $preview = $defaultImage;
                }
                
                $templates[] = [
                    'name' => $name,
                    'preview' => $preview,
                    'path' => $publicPath,
                    'category' => $category
                ];
            } else {
                // Recursive call for subdirectories
                scanTemplates($path);
            }
        }
    }
}

if (is_dir($baseDir)) {
    scanTemplates($baseDir);
}

echo json_encode($templates);
