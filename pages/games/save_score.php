<?php
require_once('../../includes/db.php');
require_once('../../includes/auth.php');

header('Content-Type: application/json');

if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Terima data JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['game']) || !isset($data['score'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

try {
    $result = saveGameScore($_SESSION['user_id'], $data['game'], $data['score']);
    echo json_encode([
        'success' => true,
        'message' => 'Score saved successfully'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to save score',
        'message' => $e->getMessage()
    ]);
} 