<?php
require_once __DIR__ . '/Migration.php';

class CreatePersonalityResultsCollection extends Migration {
    public function up() {
        // Buat collection personality_results
        $this->createCollection('personality_results');
        
        // Buat indexes
        $this->createIndex('personality_results', 
            ['user_id' => 1]
        );
        
        $this->createIndex('personality_results',
            ['date' => 1]
        );
        
        $this->createIndex('personality_results',
            ['personality_type' => 1]
        );
        
        // Buat validator
        $this->db->command([
            'collMod' => 'personality_results',
            'validator' => [
                '$jsonSchema' => [
                    'bsonType' => 'object',
                    'required' => ['user_id', 'personality_type', 'choices', 'date'],
                    'properties' => [
                        'user_id' => ['bsonType' => 'string'],
                        'personality_type' => ['bsonType' => 'string'],
                        'choices' => ['bsonType' => 'array'],
                        'date' => ['bsonType' => 'date']
                    ]
                ]
            ]
        ]);
    }
    
    public function down() {
        $this->dropCollection('personality_results');
    }
} 