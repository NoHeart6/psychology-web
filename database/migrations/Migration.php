<?php

class Migration {
    protected $db;
    protected $collection;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    public function up() {
        // Method yang akan diimplementasikan oleh child class
    }
    
    public function down() {
        // Method yang akan diimplementasikan oleh child class
    }
    
    protected function createCollection($name, $options = []) {
        try {
            $this->db->createCollection($name, $options);
            echo "Collection {$name} berhasil dibuat.\n";
        } catch (Exception $e) {
            echo "Error saat membuat collection {$name}: " . $e->getMessage() . "\n";
        }
    }
    
    protected function createIndex($collection, $keys, $options = []) {
        try {
            $this->db->$collection->createIndex($keys, $options);
            echo "Index pada {$collection} berhasil dibuat.\n";
        } catch (Exception $e) {
            echo "Error saat membuat index pada {$collection}: " . $e->getMessage() . "\n";
        }
    }
    
    protected function dropCollection($name) {
        try {
            $this->db->$name->drop();
            echo "Collection {$name} berhasil dihapus.\n";
        } catch (Exception $e) {
            echo "Error saat menghapus collection {$name}: " . $e->getMessage() . "\n";
        }
    }
} 