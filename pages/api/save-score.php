<?php
require_once('../../includes/db.php');
session_start();

header('Content-Type: application/json');

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Ambil data dari request
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['score']) || !isset($data['game'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

try {
    // Simpan skor ke database
    $result = $database->game_scores->insertOne([
        'user_id' => $_SESSION['user_id'],
        'player_name' => $_SESSION['user_name'],
        'game' => $data['game'],
        'score' => (int)$data['score'],
        'date' => new MongoDB\BSON\UTCDateTime()
    ]);

    if ($result->getInsertedCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to save score');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 