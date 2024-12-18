<?php
require_once __DIR__ . '/Migration.php';

class CreateGameScoresCollection extends Migration {
    public function up() {
        // Buat collection game_scores
        $this->createCollection('game_scores');
        
        // Buat indexes
        $this->createIndex('game_scores', 
            ['user_id' => 1]
        );
        
        $this->createIndex('game_scores',
            ['game' => 1]
        );
        
        $this->createIndex('game_scores',
            ['score' => -1]
        );
        
        $this->createIndex('game_scores',
            ['date' => -1]
        );
        
        // Buat validator
        $this->db->command([
            'collMod' => 'game_scores',
            'validator' => [
                '$jsonSchema' => [
                    'bsonType' => 'object',
                    'required' => ['user_id', 'player_name', 'game', 'score', 'date'],
                    'properties' => [
                        'user_id' => ['bsonType' => 'string'],
                        'player_name' => ['bsonType' => 'string'],
                        'game' => ['bsonType' => 'string'],
                        'score' => ['bsonType' => 'int'],
                        'date' => ['bsonType' => 'date']
                    ]
                ]
            ]
        ]);
    }
    
    public function down() {
        $this->dropCollection('game_scores');
    }
} 