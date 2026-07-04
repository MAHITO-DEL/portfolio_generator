<?php
header('Content-Type: application/json; charset=utf-8');

$storageDir = __DIR__ . '/../data';
$storageFile = $storageDir . '/feedback.json';

if (!is_dir($storageDir)) {
    mkdir($storageDir, 0755, true);
}

if (!file_exists($storageFile)) {
    file_put_contents($storageFile, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function sendJson($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function loadStorage($path) {
    $json = @file_get_contents($path);
    $data = json_decode($json, true);
    if (!is_array($data)) {
        return [];
    }
    return $data;
}

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'GET') {
    $entries = loadStorage($storageFile);
    usort($entries, function ($a, $b) {
        $timeA = strtotime($a['created_at'] ?? '');
        $timeB = strtotime($b['created_at'] ?? '');
        return $timeB <=> $timeA;
    });
    sendJson(['success' => true, 'feedback' => $entries]);
}

if ($method !== 'POST') {
    sendJson(['success' => false, 'error' => 'Method not allowed.'], 405);
}

$payload = json_decode(file_get_contents('php://input'), true);
if (!is_array($payload)) {
    sendJson(['success' => false, 'error' => 'Invalid request body.'], 400);
}

$email = trim($payload['email'] ?? '');
$message = trim($payload['message'] ?? '');
$rating = intval($payload['rating'] ?? 0);

if (!$email) {
    sendJson(['success' => false, 'error' => 'Email is required.'], 400);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/i', $email)) {
    sendJson(['success' => false, 'error' => 'Please provide a valid Gmail address.'], 400);
}
if ($rating < 1 || $rating > 5) {
    sendJson(['success' => false, 'error' => 'Rating must be between 1 and 5.'], 400);
}
if (!$message) {
    sendJson(['success' => false, 'error' => 'Message is required.'], 400);
}

$entries = loadStorage($storageFile);
$newEntry = [
    'id' => uniqid('fb_', true),
    'email' => $email,
    'rating' => $rating,
    'message' => $message,
    'created_at' => date('Y-m-d H:i:s'),
    'isUserComment' => true,
];

$entries[] = $newEntry;
if (file_put_contents($storageFile, json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) === false) {
    sendJson(['success' => false, 'error' => 'Unable to save feedback.'], 500);
}

sendJson(['success' => true, 'entry' => $newEntry]);
