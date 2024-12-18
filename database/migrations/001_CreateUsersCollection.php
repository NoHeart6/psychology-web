<?php
require_once __DIR__ . '/Migration.php';

class CreateUsersCollection extends Migration {
    public function up() {
        // Buat collection users
        $this->createCollection('users');
        
        // Buat indexes
        $this->createIndex('users', 
            ['email' => 1], 
            ['unique' => true]
        );
        
        $this->createIndex('users',
            ['created_at' => 1]
        );
        
        // Insert data awal admin
        $this->db->users->insertOne([
            'name' => 'Admin',
            'email' => 'admin@journeytobetterself.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
    }
    
    public function down() {
        $this->dropCollection('users');
    }
} 