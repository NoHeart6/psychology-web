<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Debugging
if (!class_exists('MongoDB\Client')) {
    die("MongoDB\Client class tidak ditemukan. Pastikan composer autoload sudah dimuat dengan benar.");
}

try {
    $mongoClient = new MongoDB\Client("mongodb+srv://wisnuhidayat016:wisnuhidayat@cluster0.ku7nz.mongodb.net/?retryWrites=true&w=majority");
    $database = $mongoClient->psychology_web;
    
    // Collections
    $users = $database->users;
    $iq_results = $database->iq_results;
    $personality_results = $database->personality_results;
    $quotes = $database->quotes;
    $game_scores = $database->game_scores;
    
} catch (MongoDB\Driver\Exception\Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}

// Fungsi untuk menyimpan hasil tes IQ
function saveIQResult($userId, $score) {
    global $iq_results;
    return $iq_results->insertOne([
        'user_id' => $userId,
        'score' => $score,
        'date' => new MongoDB\BSON\UTCDateTime()
    ]);
}

// Fungsi untuk menyimpan hasil personality game
function savePersonalityResult($userId, $personality_type, $choices) {
    global $personality_results;
    return $personality_results->insertOne([
        'user_id' => $userId,
        'personality_type' => $personality_type,
        'choices' => $choices,
        'date' => new MongoDB\BSON\UTCDateTime()
    ]);
}

// Fungsi untuk mendapatkan quotes acak
function getRandomQuote() {
    global $quotes;
    $quote = $quotes->aggregate([
        ['$sample' => ['size' => 1]]
    ])->toArray();
    return $quote[0] ?? null;
}

// Fungsi untuk mendapatkan high score game
function getHighScore($game) {
    global $game_scores;
    $result = $game_scores->findOne(
        ['game' => $game],
        [
            'sort' => ['score' => -1],
            'limit' => 1
        ]
    );
    return $result ? $result->score : 0;
}

// Fungsi untuk menyimpan skor game
function saveGameScore($userId, $game, $score) {
    global $game_scores;
    return $game_scores->insertOne([
        'user_id' => $userId,
        'game' => $game,
        'score' => (int)$score,
        'date' => new MongoDB\BSON\UTCDateTime()
    ]);
} 