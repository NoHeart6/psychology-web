<?php
require_once('../../includes/db.php');
session_start();

header('Content-Type: application/json');

if (!isset($_GET['game'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Game parameter is required']);
    exit;
}

try {
    // Ambil 10 skor tertinggi untuk game tertentu
    $scores = $database->game_scores->find(
        ['game' => $_GET['game']],
        [
            'sort' => ['score' => -1],
            'limit' => 10,
            'projection' => [
                'player_name' => 1,
                'score' => 1,
                '_id' => 0
            ]
        ]
    )->toArray();

    echo json_encode($scores);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 