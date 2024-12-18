<?php
require_once __DIR__ . '/Migration.php';

class CreateIQResultsCollection extends Migration {
    public function up() {
        // Buat collection iq_results
        $this->createCollection('iq_results');
        
        // Buat indexes
        $this->createIndex('iq_results', 
            ['user_id' => 1]
        );
        
        $this->createIndex('iq_results',
            ['date' => 1]
        );
        
        // Buat validator
        $this->db->command([
            'collMod' => 'iq_results',
            'validator' => [
                '$jsonSchema' => [
                    'bsonType' => 'object',
                    'required' => ['user_id', 'score', 'date'],
                    'properties' => [
                        'user_id' => ['bsonType' => 'string'],
                        'score' => ['bsonType' => 'int'],
                        'date' => ['bsonType' => 'date']
                    ]
                ]
            ]
        ]);
    }
    
    public function down() {
        $this->dropCollection('iq_results');
    }
} 